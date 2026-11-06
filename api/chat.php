<?php
// Central API handler for chat widget & admin
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Session-ID');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') exit(0);

require_once __DIR__ . '/../db.php';

function getRequestData() {
    static $data = null;
    if ($data !== null) return $data;
    
    $json = json_decode(file_get_contents('php://input'), true);
    $data = array_merge($_GET, $_POST, is_array($json) ? $json : []);
    return $data;
}

$reqData = getRequestData();
$action  = $reqData['action'] ?? '';

// ─── Rate-limit constants ─────────────────────────────────────────────────────
define('RL_WINDOW_SECONDS', 60);   // rolling window length
define('RL_MAX_MESSAGES',   30);   // messages allowed per window
define('RL_BLOCK_SECONDS',  3600); // 1-hour block duration

switch ($action) {
    case 'start_session':   handleStartSession(); break;
    case 'send_message':    handleSendMessage();  break;
    case 'get_messages':    handleGetMessages();  break;
    case 'get_sessions':    handleGetSessions();  break;
    case 'agent_reply':     handleAgentReply();   break;
    case 'mark_read':       handleMarkRead();     break;
    case 'close_session':   handleCloseSession(); break;
    case 'reopen_session':  handleReopenSession(); break;
    case 'block_session':   handleBlockSession(); break;
    case 'unblock_session': handleUnblockSession(); break;
    case 'get_session':     handleGetSession();   break;
    case 'heartbeat':       handleHeartbeat();    break;
    case 'destroy_session': handleDestroySession(); break;
    case 'get_settings':    handleGetSettings();  break;
    case 'update_settings': handleUpdateSettings(); break;
    case 'upload_logo':     handleUploadLogo();   break;
    case 'check_rate_limit': handleCheckRateLimit(); break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action']);
}

// ─── Visitor: Start or Resume Session ────────────────────────────────────────
function handleStartSession() {
    $data = getRequestData();
    $fp   = sanitize($data['fp'] ?? '');       // browser fingerprint
    $email = strtolower(trim((string)($data['email'] ?? '')));
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonError('A valid email address is required', 422);
        return;
    }

    $name = sanitize($data['name'] ?? '');
    if ($name === '') $name = $email ?: 'Visitor';
    $ip   = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';

    if (!$fp) { jsonError('Missing browser fingerprint', 400); return; }

    $db = getDB();
    // Look for existing open session with same fingerprint
    $stmt = $db->prepare("SELECT session_id FROM chat_sessions WHERE browser_fp = ? AND status = 'open' ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$fp]);
    $row = $stmt->fetch();

    if ($row) {
        if ($email !== '') {
            $stmt = $db->prepare("UPDATE chat_sessions SET visitor_name = ?, visitor_email = ? WHERE session_id = ?");
            $stmt->execute([$name, $email, $row['session_id']]);
        }
        echo json_encode(['session_id' => $row['session_id'], 'new' => false]);
    } else {
        $sessionId = bin2hex(random_bytes(20));
        if ($email !== '') {
            $stmt = $db->prepare("INSERT INTO chat_sessions (session_id, visitor_name, visitor_email, browser_fp, ip_address, last_presence) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$sessionId, $name, $email, $fp, $ip]);
        } else {
            $stmt = $db->prepare("INSERT INTO chat_sessions (session_id, visitor_name, browser_fp, ip_address, last_presence) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$sessionId, $name, $fp, $ip]);
        }
        echo json_encode(['session_id' => $sessionId, 'new' => true]);
    }
}



// ─── Rate-limit check (per session) ─────────────────────────────────────────
// Returns an array: ['ok'=>bool, 'warn'=>bool, 'blocked'=>bool, 'retry_after'=>int]
function checkSessionRateLimit(string $sessionId, bool $increment = true): array {
    $db   = getDB();
    $stmt = $db->prepare(
        "SELECT msg_count_window, window_start, rate_warned, rate_blocked_until FROM chat_sessions WHERE session_id = ?"
    );
    $stmt->execute([$sessionId]);
    $row  = $stmt->fetch();
    $now  = time();

    // Currently hard-blocked?
    if (!empty($row['rate_blocked_until'])) {
        $blockEnd = strtotime($row['rate_blocked_until']);
        if ($now < $blockEnd) {
            return ['ok' => false, 'warn' => false, 'blocked' => true, 'retry_after' => $blockEnd - $now];
        }
        // Block expired — reset
        $db->prepare("UPDATE chat_sessions SET msg_count_window=0, window_start=NULL, rate_warned=0, rate_blocked_until=NULL WHERE session_id=?")->execute([$sessionId]);
        $row['msg_count_window'] = 0;
        $row['window_start']     = null;
        $row['rate_warned']      = 0;
        $row['rate_blocked_until'] = null;
    }

    $windowStart = $row['window_start'] ? strtotime($row['window_start']) : 0;
    $count       = (int)($row['msg_count_window'] ?? 0);

    // Reset window if older than RL_WINDOW_SECONDS
    if ($now - $windowStart >= RL_WINDOW_SECONDS) {
        if ($increment) {
            $windowStart = $now;
            $count       = 0;
            $db->prepare("UPDATE chat_sessions SET msg_count_window=0, window_start=NOW(), rate_warned=0 WHERE session_id=?")->execute([$sessionId]);
            $row['rate_warned'] = 0;
        } else {
            return ['ok' => true, 'warn' => false, 'blocked' => false, 'retry_after' => 0];
        }
    }

    if (!$increment) {
        return ['ok' => ($count <= RL_MAX_MESSAGES), 'warn' => (bool)$row['rate_warned'], 'blocked' => false, 'retry_after' => 0];
    }

    $count++;

    if ($count > RL_MAX_MESSAGES) {
        // Already over-limit this window
        if ($row['rate_warned']) {
            // Second offence in same window — enforce 1-hr block
            $db->prepare("UPDATE chat_sessions SET rate_blocked_until = (NOW() + INTERVAL 1 HOUR), msg_count_window=? WHERE session_id=?")->execute([$count, $sessionId]);
            return ['ok' => false, 'warn' => false, 'blocked' => true, 'retry_after' => RL_BLOCK_SECONDS];
        } else {
            // First over-limit — warn but still allow this single message through (soft warn)
            $db->prepare("UPDATE chat_sessions SET msg_count_window=?, rate_warned=1 WHERE session_id=?")->execute([$count, $sessionId]);
            return ['ok' => true, 'warn' => true, 'blocked' => false, 'retry_after' => 0];
        }
    }

    // Under the limit — increment
    $db->prepare("UPDATE chat_sessions SET msg_count_window=? WHERE session_id=?")->execute([$count, $sessionId]);
    return ['ok' => true, 'warn' => false, 'blocked' => false, 'retry_after' => 0];
}

// ─── Visitor: Check rate-limit status (polling) ────────────────────────────────
function handleCheckRateLimit() {
    $sessionId = getSessionId();
    if (!$sessionId) { echo json_encode(['blocked' => false, 'warn' => false]); return; }
    
    // Check status WITHOUT incrementing the counter
    $rl = checkSessionRateLimit($sessionId, false);
    
    echo json_encode([
        'blocked'     => $rl['blocked'],
        'warn'        => $rl['warn'],
        'retry_after' => $rl['retry_after']
    ]);
}

// ─── Visitor: Send Message ───────────────────────────────────────────────────
function handleSendMessage() {
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    verifySession($sessionId);

    $db = getDB();

    // Check if session is blocked or closed
    $stmt = $db->prepare("SELECT status, is_blocked FROM chat_sessions WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    $session = $stmt->fetch();
    if ($session['status'] === 'closed') { jsonError('This chat is closed. Please reopen to send messages.', 403); return; }
    if ($session['is_blocked']) { jsonError('Message sending is disabled for this chat.', 403); return; }

    // ── Rate-limit check ──
    $rl = checkSessionRateLimit($sessionId);
    if ($rl['blocked']) {
        $mins = ceil($rl['retry_after'] / 60);
        http_response_code(429);
        echo json_encode([
            'error'       => "You have been temporarily blocked for sending too many messages. Please try again in {$mins} minute(s).",
            'rate_blocked' => true,
            'retry_after'  => $rl['retry_after'],
        ]);
        return;
    }

    // Check recipient status (Admin)
    $stmt = $db->prepare("SELECT COUNT(*) FROM admin_users WHERE last_activity > (NOW() - INTERVAL 10 SECOND)");
    $stmt->execute();
    $adminOnline = $stmt->fetchColumn() > 0;

    $stmt = $db->prepare("SELECT COUNT(*) FROM admin_users WHERE last_activity > (NOW() - INTERVAL 10 SECOND) AND is_viewing = 1 AND (viewing_session_id = ? OR viewing_session_id IS NULL)");
    $stmt->execute([$sessionId]);
    $adminViewing = $stmt->fetchColumn() > 0;

    $status = 'sent';
    if ($adminViewing) $status = 'seen';
    elseif ($adminOnline) $status = 'delivered';

    // Image upload
    if (!empty($_FILES['image'])) {
        $file = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
        if (!in_array($file['type'], $allowed)) { jsonError('Invalid file type', 400); return; }
        if ($file['size'] > 10 * 1024 * 1024) { jsonError('File too large (max 10MB)', 400); return; }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = bin2hex(random_bytes(16)) . '.' . $ext;
        $filePath = 'uploads/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../' . $filePath)) {
            jsonError('Upload failed', 500); return;
        }

        $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, file_path, file_name, status) VALUES (?, 'visitor', 'image', ?, ?, ?)");
        $stmt->execute([$sessionId, $filePath, $file['name'], $status]);

    } else {
        $data    = getRequestData();
        $message = trim($data['message'] ?? '');
        if (!$message) { jsonError('Empty message', 400); return; }

        $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message, status) VALUES (?, 'visitor', 'text', ?, ?)");
        $stmt->execute([$sessionId, $message, $status]);
    }

    // Update session activity & mark unread for agent
    $db->prepare("UPDATE chat_sessions SET last_activity = NOW(), is_read = 0 WHERE session_id = ?")->execute([$sessionId]);

    // Build response — include warn flag so front-end can show the warning
    $response = ['success' => true, 'id' => $db->lastInsertId(), 'status' => $status];
    if ($rl['warn']) {
        $response['rate_warn'] = true;
        $response['rate_warn_msg'] = 'You are sending messages too quickly. If you continue, you will be blocked for 1 hour.';
    }
    echo json_encode($response);
}

// ─── Visitor/Agent: Get Messages ─────────────────────────────────────────────
function handleGetMessages() {
    $data      = getRequestData();
    $sessionId = getSessionId();
    $since     = intval($data['since'] ?? 0);
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db   = getDB();
    
    // Safety check: if session doesn't exist, return error so client can reset
    $check = $db->prepare("SELECT id FROM chat_sessions WHERE session_id = ?");
    $check->execute([$sessionId]);
    if (!$check->fetch()) { jsonError('Session not found', 404); return; }

    // Determine requester — admin dashboard uses GET, visitors (chat.php / widget) use POST.
    // Avoid relying on PHP session alone: if the same browser is logged into admin and
    // also has chat.php open, the admin PHPSESSID cookie would bleed into visitor requests,
    // causing last_presence to never update and the visitor to appear offline.
    $isAgent = false;
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ini_set('session.gc_maxlifetime', 365 * 24 * 60 * 60);
        session_start();
        $isAgent = !empty($_SESSION['admin_logged_in']);
    }
    
    // If agent is reading, mark visitor's messages as 'seen' if viewing
    if ($isAgent) {
        $username = $_SESSION['admin_username'] ?? 'admin';
        // Agent is viewing this session
        $db->prepare("UPDATE chat_messages SET status = 'seen', is_read = 1 WHERE session_id = ? AND sender = 'visitor' AND status != 'seen'")->execute([$sessionId]);
        $db->prepare("UPDATE chat_sessions SET is_read = 1 WHERE session_id = ?")->execute([$sessionId]);
        // Update admin activity
        $db->prepare("UPDATE admin_users SET last_activity = NOW() WHERE username = ?")->execute([$username]);
    } else {
        // Visitor is reading, mark agent's messages as 'seen'
        $db->prepare("UPDATE chat_messages SET status = 'seen' WHERE session_id = ? AND sender = 'agent' AND status != 'seen'")->execute([$sessionId]);
        // Update visitor presence (not activity, unless we want to bump session to top which we do when they message)
        $db->prepare("UPDATE chat_sessions SET last_presence = NOW() WHERE session_id = ?")->execute([$sessionId]);
    }

    $limit     = intval($data['limit'] ?? 0);
    $before_id = intval($data['before_id'] ?? 0);

    $sql  = "SELECT id, sender, message, message_type, file_path, file_name, status, created_at FROM chat_messages WHERE session_id = ?";
    $args = [$sessionId];

    if ($since) {
        $sql  .= " AND id > ?";
        $args[] = $since;
    }
    
    if ($before_id) {
        $sql  .= " AND id < ?";
        $args[] = $before_id;
    }

    if ($since) {
        $sql .= " ORDER BY created_at ASC";
    } else {
        $sql .= " ORDER BY created_at DESC";
    }

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($args);
    $messages = $stmt->fetchAll();

    // If we loaded older messages (DESC), we need to reverse them back for the client
    if (!$since) {
        $messages = array_reverse($messages);
    }

    // Also return session info & agent status
    $s = $db->prepare("SELECT visitor_name, visitor_email, status, is_blocked, is_viewing, is_typing, last_activity, last_presence FROM chat_sessions WHERE session_id = ?");
    $s->execute([$sessionId]);
    $session = $s->fetch();
    
    // Get agent status
    $a = $db->prepare("SELECT last_activity, is_typing, is_viewing FROM admin_users ORDER BY last_activity DESC LIMIT 1");
    $a->execute();
    $admin = $a->fetch();

    echo json_encode([
        'messages' => $messages,
        'session'  => $session,
        'agent'    => [
            'online'  => ($admin && strtotime($admin['last_activity']) > (time() - 10)),
            'typing'  => ($admin && !empty($admin['is_typing'])),
            'viewing' => ($admin && !empty($admin['is_viewing']))
        ]
    ]);
}

// ─── Agent: Get All Sessions ─────────────────────────────────────────────────
function handleGetSessions() {
    requireAdmin();
    $data   = getRequestData();
    $db     = getDB();
    $since  = intval($data['since'] ?? 0);
    $status = $data['status'] ?? 'open';

    $sql  = "SELECT s.id, s.session_id, s.visitor_name, s.visitor_email, s.ip_address, s.status, s.is_blocked, s.is_read, s.is_viewing, s.is_typing, s.last_activity, s.last_presence, s.created_at,
                    (TIMESTAMPDIFF(SECOND, s.last_presence, NOW()) < 10) AS visitor_online,
                    (SELECT COUNT(*) FROM chat_messages m WHERE m.session_id = s.session_id) AS msg_count,
                    (SELECT COUNT(*) FROM chat_messages m WHERE m.session_id = s.session_id AND m.is_read = 0 AND m.sender = 'visitor') AS unread_count,
                    (SELECT m2.message FROM chat_messages m2 WHERE m2.session_id = s.session_id ORDER BY m2.created_at DESC LIMIT 1) AS last_message,
                    (SELECT m2.message_type FROM chat_messages m2 WHERE m2.session_id = s.session_id ORDER BY m2.created_at DESC LIMIT 1) AS last_message_type,
                    (SELECT m2.file_path FROM chat_messages m2 WHERE m2.session_id = s.session_id ORDER BY m2.created_at DESC LIMIT 1) AS last_message_file
             FROM chat_sessions s";
    $args = [];
    if ($status !== 'all') {
        $sql  .= " WHERE s.status = ?";
        $args[] = $status;
    }
    $sql .= " ORDER BY s.last_activity DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($args);
    echo json_encode(['sessions' => $stmt->fetchAll()]);
}

// ─── Agent: Get Single Session ───────────────────────────────────────────────
function handleGetSession() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db   = getDB();
    $stmt = $db->prepare("SELECT * FROM chat_sessions WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    $session = $stmt->fetch();
    if (!$session) { jsonError('Session not found', 404); return; }
    echo json_encode(['session' => $session]);
}

// ─── Agent: Reply ─────────────────────────────────────────────────────────────
function handleAgentReply() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    verifySession($sessionId);

    // Check recipient status (Visitor) - Use last_presence for actual online status
    $stmt = $db->prepare("SELECT last_presence, is_viewing FROM chat_sessions WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    $visitor = $stmt->fetch();
    
    $isOnline = (isset($visitor['last_presence']) && strtotime($visitor['last_presence']) > (time() - 10));
    $isViewing = (isset($visitor['is_viewing']) && $visitor['is_viewing'] == 1);

    $status = 'sent';
    if ($isViewing) $status = 'seen';
    elseif ($isOnline) $status = 'delivered';

    if (!empty($_FILES['image'])) {
        $file    = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
        if (!in_array($file['type'], $allowed)) { jsonError('Invalid file type', 400); return; }
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = bin2hex(random_bytes(16)) . '.' . $ext;
        $filePath = 'uploads/' . $fileName;
        move_uploaded_file($file['tmp_name'], __DIR__ . '/../' . $filePath);

        $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, file_path, file_name, status) VALUES (?, 'agent', 'image', ?, ?, ?)");
        $stmt->execute([$sessionId, $filePath, $file['name'], $status]);
    } else {
        $data    = getRequestData();
        $message = trim($data['message'] ?? '');
        if (!$message) { jsonError('Empty message', 400); return; }

        $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message, status) VALUES (?, 'agent', 'text', ?, ?)");
        $stmt->execute([$sessionId, $message, $status]);
    }

    $db->prepare("UPDATE chat_sessions SET last_activity = NOW() WHERE session_id = ?")->execute([$sessionId]);
    echo json_encode(['success' => true, 'id' => $db->lastInsertId(), 'status' => $status]);
}

// ─── Shared: Heartbeat for online & viewing status ───────────────────────────
function handleHeartbeat() {
    $data      = getRequestData();
    $sessionId = getSessionId();
    $isViewing = !empty($data['is_viewing']) ? 1 : 0;
    $isLeaving = !empty($data['is_leaving']) ? 1 : 0;

    // Visitor heartbeats always include the X-Session-ID header (set by apiFetch).
    // Admin heartbeats do not. Use this to distinguish without relying on PHP session
    // alone, which would misidentify a same-browser visitor as admin.
    $isAdmin = false;
    if (empty($_SERVER['HTTP_X_SESSION_ID'])) {
        ini_set('session.gc_maxlifetime', 365 * 24 * 60 * 60);
        session_start();
        $isAdmin = !empty($_SESSION['admin_logged_in']);
    }
    $db = getDB();

    $isTyping  = !empty($data['is_typing']) ? 1 : 0;
    $timeExpr = $isLeaving ? "NOW() - INTERVAL 1 MINUTE" : "NOW()";

    if ($isAdmin) {
        $username = $_SESSION['admin_username'] ?? 'admin';
        $viewingId = $data['session_id'] ?? null;
        $stmt = $db->prepare("UPDATE admin_users SET last_activity = $timeExpr, is_viewing = ?, is_typing = ?, viewing_session_id = ? WHERE username = ?");
        $stmt->execute([$isLeaving ? 0 : $isViewing, $isLeaving ? 0 : $isTyping, $viewingId, $username]);
        
        // If admin is viewing a specific session, mark its visitor messages as 'seen'
        if ($isViewing && $viewingId && !$isLeaving) {
             $db->prepare("UPDATE chat_messages SET status = 'seen', is_read = 1 WHERE session_id = ? AND sender = 'visitor' AND status != 'seen'")->execute([$viewingId]);
        }
    } else {
        if (!$sessionId) { jsonError('Missing session', 400); return; }
        $stmt = $db->prepare("UPDATE chat_sessions SET last_presence = $timeExpr, is_viewing = ?, is_typing = ? WHERE session_id = ?");
        $stmt->execute([$isLeaving ? 0 : $isViewing, $isLeaving ? 0 : $isTyping, $sessionId]);
        
        // If visitor is viewing, mark agent messages as 'seen'
        if ($isViewing && !$isLeaving) {
            $db->prepare("UPDATE chat_messages SET status = 'seen' WHERE session_id = ? AND sender = 'agent' AND status != 'seen'")->execute([$sessionId]);
        }
    }

    // Auto-promote 'sent' to 'delivered' if recipient is online
    if ($isAdmin && $sessionId) {
        // I am admin, promote my messages to visitor
        $stmt = $db->prepare("SELECT last_presence FROM chat_sessions WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        $v = $stmt->fetch();
        if ($v && strtotime($v['last_presence']) > (time() - 10)) {
            $db->prepare("UPDATE chat_messages SET status = 'delivered' WHERE session_id = ? AND sender = 'agent' AND status = 'sent'")->execute([$sessionId]);
        }
    } elseif (!$isAdmin && $sessionId) {
        // I am visitor, promote my messages to agent(s)
        $stmt = $db->prepare("SELECT COUNT(*) FROM admin_users WHERE last_activity > (NOW() - INTERVAL 10 SECOND)");
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $db->prepare("UPDATE chat_messages SET status = 'delivered' WHERE session_id = ? AND sender = 'visitor' AND status = 'sent'")->execute([$sessionId]);
        }
    }

    echo json_encode(['success' => true]);
}

// ─── Agent: Mark Session as Read ─────────────────────────────────────────────
function handleMarkRead() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    $db->prepare("UPDATE chat_sessions SET is_read = 1 WHERE session_id = ?")->execute([$sessionId]);
    $db->prepare("UPDATE chat_messages SET status = 'seen', is_read = 1 WHERE session_id = ? AND sender = 'visitor' AND status != 'seen'")->execute([$sessionId]);
    echo json_encode(['success' => true]);
}

// ─── Agent: Close Session ─────────────────────────────────────────────────────
function handleCloseSession() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    $db->prepare("UPDATE chat_sessions SET status = 'closed' WHERE session_id = ?")->execute([$sessionId]);
    
    // Insert system message
    $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message) VALUES (?, 'system', 'text', ?)");
    $stmt->execute([$sessionId, 'Chat has been closed. You can reopen it if you need further assistance.']);

    echo json_encode(['success' => true]);
}

// ─── Agent/Visitor: Reopen Session ──────────────────────────────────────────
function handleReopenSession() {
    // Both agent and visitor can reopen? User says "have option in the top to reopen chat if needed" 
    // Usually means visitors can reopen their own.
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    verifySession($sessionId);

    $db->prepare("UPDATE chat_sessions SET status = 'open' WHERE session_id = ?")->execute([$sessionId]);
    
    // Insert system message
    $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message) VALUES (?, 'system', 'text', ?)");
    $stmt->execute([$sessionId, 'Chat has been reopened.']);

    echo json_encode(['success' => true]);
}

// ─── Agent: Block Session ─────────────────────────────────────────────────────
function handleBlockSession() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    $db->prepare("UPDATE chat_sessions SET is_blocked = 1 WHERE session_id = ?")->execute([$sessionId]);
    
    // Insert system message
    $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message) VALUES (?, 'system', 'text', ?)");
    $stmt->execute([$sessionId, 'Chat has been blocked by moderator.']);

    echo json_encode(['success' => true]);
}

// ─── Agent: Unblock Session ───────────────────────────────────────────────────
function handleUnblockSession() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    $db->prepare("UPDATE chat_sessions SET is_blocked = 0 WHERE session_id = ?")->execute([$sessionId]);
    
    // Insert system message
    $stmt = $db->prepare("INSERT INTO chat_messages (session_id, sender, message_type, message) VALUES (?, 'system', 'text', ?)");
    $stmt->execute([$sessionId, 'Chat has been unblocked.']);

    echo json_encode(['success' => true]);
}

// ─── Shared: Get Settings ────────────────────────────────────────────────────
function handleGetSettings() {
    $db = getDB();
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    echo json_encode(['settings' => $settings]);
}

// ─── Agent: Upload Logo ─────────────────────────────────────────────────────
function handleUploadLogo() {
    requireAdmin();
    if (empty($_FILES['logo'])) { jsonError('No file uploaded', 400); return; }

    $file    = $_FILES['logo'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];

    // Validate MIME via finfo, not just the browser-supplied type
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeReal = $finfo->file($file['tmp_name']);
    if (!in_array($mimeReal, $allowed)) { jsonError('Invalid file type', 400); return; }
    if ($file['size'] > 2 * 1024 * 1024) { jsonError('File too large (max 2 MB)', 400); return; }

    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

    // Delete previous logo if stored in uploads/
    $db      = getDB();
    $oldStmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'support_logo_url'");
    $oldStmt->execute();
    $oldUrl  = $oldStmt->fetchColumn();
    if ($oldUrl) {
        // Only delete files we own (relative paths starting with uploads/)
        $oldRel = ltrim(parse_url($oldUrl, PHP_URL_PATH), '/');
        if (strpos($oldRel, 'uploads/logo_') === 0) {
            $oldAbs = __DIR__ . '/../' . $oldRel;
            if (file_exists($oldAbs)) @unlink($oldAbs);
        }
    }

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = 'logo_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $filePath = 'uploads/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../' . $filePath)) {
        jsonError('Upload failed', 500); return;
    }

    // Build an absolute URL the browser can use
    $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
    $logoUrl  = $scheme . '://' . $host . $basePath . '/' . $filePath;

    $upsert = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('support_logo_url', ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    $upsert->execute([$logoUrl]);

    echo json_encode(['success' => true, 'url' => $logoUrl]);
}

// ─── Agent: Update Settings ──────────────────────────────────────────────────
function handleUpdateSettings() {
    requireAdmin();
    $data = getRequestData();
    $settings = $data['settings'] ?? [];
    if (empty($settings)) { jsonError('No settings provided', 400); return; }

    $db = getDB();
    $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($settings as $key => $value) {
        $stmt->execute([$key, $value]);
    }
    echo json_encode(['success' => true]);
}

// ─── Agent: Destroy Session ───────────────────────────────────────────────────
function handleDestroySession() {
    requireAdmin();
    $sessionId = getSessionId();
    if (!$sessionId) { jsonError('Missing session', 400); return; }

    $db = getDB();
    
    // 1. Find all files to delete
    $stmt = $db->prepare("SELECT file_path FROM chat_messages WHERE session_id = ? AND message_type = 'image' AND file_path IS NOT NULL");
    $stmt->execute([$sessionId]);
    $files = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 2. Delete files from filesystem
    foreach ($files as $fileRelPath) {
        $fullPath = __DIR__ . '/../' . $fileRelPath;
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    // 3. Delete messages
    $stmt = $db->prepare("DELETE FROM chat_messages WHERE session_id = ?");
    $stmt->execute([$sessionId]);

    // 4. Delete session
    $stmt = $db->prepare("DELETE FROM chat_sessions WHERE session_id = ?");
    $stmt->execute([$sessionId]);

    echo json_encode(['success' => true]);
}

// ─── Helpers ─────────────────────────────────────────────────────────────────
function getSessionId() {
    $data = getRequestData();
    return $_SERVER['HTTP_X_SESSION_ID'] ?? $data['session_id'] ?? '';
}

function sanitize($v) {
    return htmlspecialchars(strip_tags(trim($v)), ENT_QUOTES, 'UTF-8');
}

function jsonError($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['error' => $msg]);
}

function verifySession($sessionId) {
    $db   = getDB();
    $stmt = $db->prepare("SELECT id FROM chat_sessions WHERE session_id = ?");
    $stmt->execute([$sessionId]);
    if (!$stmt->fetch()) {
        jsonError('Session not found', 404);
        exit;
    }
}

function requireAdmin() {
    ini_set('session.gc_maxlifetime', 365 * 24 * 60 * 60);
    session_start();
    if (empty($_SESSION['admin_logged_in'])) {
        jsonError('Unauthorized', 401);
        exit;
    }
}
