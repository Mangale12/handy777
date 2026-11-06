<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../db.php';

$data   = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $data['action'] ?? $_GET['action'] ?? '';

if ($action === 'login') {
    $username = trim($data['username'] ?? '');
    $password = trim($data['password'] ?? '');

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(['error' => 'Username and password required']);
        exit;
    }

    $db   = getDB();
    $stmt = $db->prepare("SELECT id, username, password_hash, display_name FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin_logged_in']  = true;
        $_SESSION['admin_id']         = $user['id'];
        $_SESSION['admin_username']   = $user['username'];
        $_SESSION['admin_name']       = $user['display_name'];
        echo json_encode(['success' => true, 'name' => $user['display_name']]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }
    exit;
}

if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'check') {
    echo json_encode([
        'logged_in' => !empty($_SESSION['admin_logged_in']),
        'name'      => $_SESSION['admin_name'] ?? ''
    ]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Unknown action']);
