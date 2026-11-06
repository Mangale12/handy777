<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebChat — Agent Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:         #0a0f1e;
      --surface:    #111827;
      --surface2:   #1e293b;
      --surface3:   #273549;
      --border:     #1e293b;
      --border2:    #334155;
      --primary:    #6366f1;
      --primary-d:  #4f46e5;
      --success:    #10b981;
      --danger:     #ef4444;
      --text:       #f1f5f9;
      --text-muted: #64748b;
      --text-dim:   #94a3b8;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      overflow: hidden;
    }

    /* ── Sidebar ─────────────────────── */
    #sidebar {
      width: 300px;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      height: 100vh;
    }

    .sidebar-header {
      padding: 20px 18px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
    }
    .logo-icon {
      width: 38px; height: 38px;
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(99,102,241,0.35);
    }
    .logo-title { font-size: 17px; font-weight: 800; letter-spacing: -0.3px; }
    .logo-sub { font-size: 10px; color: var(--text-muted); font-weight: 400; }
    #logout-btn {
      margin-left: auto;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-muted);
      padding: 6px;
      border-radius: 8px;
      transition: background 0.2s, color 0.2s;
    }
    #logout-btn:hover { background: var(--surface2); color: var(--danger); }

    /* Tab bar */
    .tab-bar {
      display: flex;
      border-bottom: 1px solid var(--border);
      flex-shrink: 0;
    }
    .tab-btn {
      flex: 1;
      padding: 10px;
      background: none;
      border: none;
      color: var(--text-muted);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      border-bottom: 2px solid transparent;
      transition: all 0.2s;
      font-family: inherit;
    }
    .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }

    /* Search */
    .search-wrap {
      padding: 12px 14px;
      border-bottom: 1px solid var(--border);
      flex-shrink: 0;
    }
    #search-input {
      width: 100%;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 10px;
      padding: 8px 14px 8px 36px;
      color: var(--text);
      font-size: 13px;
      outline: none;
      font-family: inherit;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 12px center;
      transition: border-color 0.2s;
    }
    #search-input:focus { border-color: var(--primary); }
    #search-input::placeholder { color: var(--text-muted); }

    /* Session list */
    #session-list {
      flex: 1;
      overflow-y: auto;
      padding: 6px 0;
    }
    #session-list::-webkit-scrollbar { width: 4px; }
    #session-list::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 4px; }

    .session-item {
      padding: 12px 16px;
      cursor: pointer;
      border-bottom: 1px solid var(--border);
      transition: background 0.15s;
      display: flex;
      align-items: center;
      gap: 12px;
      position: relative;
    }
    .session-item:hover { background: var(--surface2); }
    .session-item.active { background: var(--surface2); border-left: 3px solid var(--primary); }
    .session-item.unread .si-name { color: var(--text); font-weight: 700; }
    .si-avatar {
      width: 42px; height: 42px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 16px; color: #fff;
      flex-shrink: 0;
    }
    .si-body { flex: 1; min-width: 0; }
    .si-name { font-size: 14px; font-weight: 500; color: var(--text-dim); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .si-last { font-size: 12px; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
    .si-time { font-size: 10px; color: var(--text-muted); flex-shrink: 0; }
    .si-unread-dot {
      position: absolute;
      top: 12px; right: 14px;
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--primary);
      display: none;
    }
    .session-item.unread .si-unread-dot { display: block; }
    .si-status-badge {
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: 600;
      margin-left: 6px;
    }
    .si-status-badge.open { background: rgba(16,185,129,0.15); color: var(--success); }
    .si-status-badge.closed { background: rgba(100,116,139,0.15); color: var(--text-muted); }
    .si-status-badge.blocked { background: rgba(239,68,68,0.15); color: var(--danger); }

    .empty-sidebar {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 200px;
      color: var(--text-muted);
      font-size: 13px;
      gap: 10px;
      text-align: center;
      padding: 20px;
    }

    /* ── Main Panel ───────────────────── */
    #main-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
    }

    /* Placeholder / no chat selected */
    #no-chat {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 16px;
      color: var(--text-muted);
    }
    #no-chat svg { opacity: 0.2; }
    #no-chat h3 { font-size: 20px; color: var(--text-dim); font-weight: 600; }
    #no-chat p { font-size: 14px; }

    /* Chat view */
    #chat-view {
      display: none;
      flex-direction: column;
      height: 100vh;
    }

    /* Chat Header */
    #chat-header {
      padding: 16px 24px;
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 14px;
      flex-shrink: 0;
    }
    .ch-avatar {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 18px; color: #fff;
    }
    .ch-info { flex: 1; }
    .ch-name { font-size: 16px; font-weight: 700; }
    .ch-meta { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
    .ch-actions { display: flex; gap: 8px; }
    .ch-btn {
      padding: 7px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      font-family: inherit;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
    }
    .ch-btn-danger { background: rgba(239,68,68,0.15); color: var(--danger); }
    .ch-btn-danger:hover { background: var(--danger); color: #fff; }
    .ch-btn-outline { background: var(--surface2); color: var(--text-dim); border: 1px solid var(--border2); }
    .ch-btn-outline:hover { background: var(--surface3); }

    #menu-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--text-dim);
        cursor: pointer;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
    }
    #sidebar-close {
        display: none;
        margin-left: auto;
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
    }

    /* Messages */
    #chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 20px 24px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      background: var(--bg);
    }
    #chat-messages::-webkit-scrollbar { width: 5px; }
    #chat-messages::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 4px; }

    .msg-row { display: flex; gap: 10px; align-items: flex-end; width: 100%; }
    .msg-row.agent { flex-direction: row-reverse; }
    .msg-avatar-sm {
      width: 30px; height: 30px;
      border-radius: 50%;
      background: var(--surface2);
      display: flex; align-items: center; justify-content: center;
      font-size: 11px; font-weight: 700; color: var(--text-muted);
      flex-shrink: 0;
    }
    .msg-avatar-sm.agent-av { background: linear-gradient(135deg, var(--primary), var(--primary-d)); color: #fff; }
    /* Message row — full width so bubble % is computed against panel width */
    .msg-row { width: 100%; }
    .msg-col {
      display: flex; flex-direction: column;
      max-width: 68%;
      min-width: 0;
    }
    .msg-row.agent .msg-col { align-items: flex-end; }
    .msg-row.visitor .msg-col { align-items: flex-start; }
    .msg-bubble {
      display: inline-block;
      max-width: 100%;
      padding: 10px 15px;
      border-radius: 16px;
      font-size: 14px;
      line-height: 1.55;
      word-break: break-word;
      white-space: pre-wrap;
      animation: msg-pop 0.18s ease;
    }
    @keyframes msg-pop {
      from { opacity:0; transform: translateY(5px) scale(0.97); }
      to   { opacity:1; transform: translateY(0)   scale(1); }
    }
    .msg-bubble.visitor { background: var(--surface2); border: 1px solid var(--border2); border-bottom-left-radius: 4px; }
    .msg-bubble.agent {
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      color: #fff;
      border-bottom-right-radius: 4px;
    }
    .msg-bubble img { max-width: 220px; max-height: 220px; border-radius: 10px; cursor: pointer; display: block; object-fit: cover; }
    .msg-time { font-size: 10px; color: var(--text-muted); margin-top: 3px; padding: 0 2px; white-space: nowrap; }
    .msg-row.agent .msg-time { text-align: right; }

    /* System Message */
    .msg-row.system { justify-content: center; margin: 10px 0; }
    .msg-bubble.system {
      background: var(--surface3);
      color: var(--text-dim);
      font-size: 12px;
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid var(--border2);
      text-align: center;
      max-width: 90%;
    }

    /* Presence Indicators */
    .presence-row { display: flex; align-items: center; gap: 6px; font-size: 11px; margin-top: 4px; }
    .presence-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .presence-dot.online { background: var(--success); box-shadow: 0 0 8px var(--success); animation: pulse 2s infinite; }
    .presence-dot.viewing { background: var(--primary); box-shadow: 0 0 8px var(--primary); animation: pulse 1s infinite; }
    .presence-dot.offline { background: var(--text-muted); }

    /* Message Status */
    .msg-time-row { display: flex; align-items: center; gap: 4px; margin-top: 3px; padding: 0 2px; }
    .msg-status { font-size: 10px; color: var(--text-muted); display: flex; align-items: center; }
    .msg-status.seen { color: var(--primary); }

    @keyframes pulse { 
      0% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(1.1); }
      100% { opacity: 1; transform: scale(1); }
    }

    /* ── Stacking Logic ── */
    .msg-row.stacked {
      margin-top: -8px;
    }
    .msg-row.stacked .msg-avatar-sm {
      visibility: hidden;
    }
    .msg-row.stacked.agent .msg-bubble {
      border-top-right-radius: 4px;
    }
    .msg-row.stacked.visitor .msg-bubble {
      border-top-left-radius: 4px;
    }
    .msg-row.has-next .msg-time {
      display: none;
    }
    .msg-row:not(.stacked) + .msg-row:not(.stacked) {
      margin-top: 4px;
    }

    /* ── Emoji Only ── */
    .msg-bubble.emoji-only {
      background: transparent !important;
      border: none !important;
      font-size: 42px;
      padding: 4px 0;
      line-height: 1.2;
      box-shadow: none !important;
      color: inherit !important;
    }

    .day-sep {
      text-align: center;
      font-size: 11px;
      color: var(--text-muted);
      margin: 8px 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .day-sep::before, .day-sep::after { content: ''; flex: 1; height: 1px; background: var(--border2); }

    /* Image lightbox */
    #admin-lightbox {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.88);
      z-index: 9999;
      align-items: center;
      justify-content: center;
    }
    #admin-lightbox.show { display: flex; }
    #admin-lightbox img { max-width: 90vw; max-height: 90vh; border-radius: 8px; }
    #lb-close {
      position: fixed; top: 16px; right: 16px;
      width: 40px; height: 40px;
      background: rgba(255,255,255,0.1);
      border: none; border-radius: 50%;
      color: #fff; font-size: 20px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
    }

    /* Preview bar */
    #preview-bar {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 8px 16px;
      display: none;
      align-items: center;
      gap: 10px;
    }
    #preview-bar img { height: 48px; border-radius: 8px; }
    #preview-bar span { font-size: 12px; color: var(--text-muted); flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    #rm-preview {
      background: var(--danger);
      border: none;
      border-radius: 50%;
      width: 22px; height: 22px;
      color: #fff;
      cursor: pointer;
      font-size: 13px;
      display: flex; align-items: center; justify-content: center;
    }

    /* Input bar */
    #input-bar {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 12px 16px;
      display: flex;
      align-items: flex-end;
      gap: 10px;
      flex-shrink: 0;
    }
    #reply-input {
      flex: 1;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 14px;
      padding: 10px 16px;
      color: var(--text);
      font-size: 14px;
      font-family: inherit;
      resize: none;
      outline: none;
      min-height: 44px;
      max-height: 120px;
      transition: border-color 0.2s;
      line-height: 1.45;
    }
    #reply-input:focus { border-color: var(--primary); }
    #reply-input::placeholder { color: var(--text-muted); }

    .icon-btn {
      width: 42px; height: 42px;
      border-radius: 50%;
      border: none;
      background: var(--surface2);
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: var(--text-muted);
      transition: background 0.2s, color 0.2s;
      flex-shrink: 0;
    }
    .icon-btn:hover { background: var(--primary); color: #fff; }
    #send-reply-btn { background: var(--primary); color: #fff; }
    #send-reply-btn:hover { background: var(--primary-d); }

    /* Stats strip */
    .stats-strip {
      display: flex;
      gap: 0;
      border-bottom: 1px solid var(--border);
      padding: 0;
      background: var(--surface);
      flex-shrink: 0;
    }
    .stat-item {
      flex: 1;
      text-align: center;
      padding: 10px;
      border-right: 1px solid var(--border);
      font-size: 11px;
      color: var(--text-muted);
    }
    .stat-item:last-child { border-right: none; }
    .stat-value { font-size: 18px; font-weight: 700; color: var(--text); display: block; }

    /* Toast / Notification Card */
    #toast-container {
      position: fixed;
      top: 24px;
      right: 24px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 12px;
      pointer-events: none;
    }
    .toast-card {
      width: 320px;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 12px;
      padding: 12px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.4);
      display: flex;
      gap: 12px;
      align-items: flex-start;
      transform: translateX(40px);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      opacity: 0;
      pointer-events: auto;
      cursor: pointer;
    }
    .toast-card.show {
      transform: translateX(0);
      opacity: 1;
    }
    .toast-av {
      width: 40px; height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .toast-content { flex: 1; min-width: 0; }
    .toast-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
    .toast-msg { font-size: 12px; color: var(--text-dim); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .toast-img { width: 100%; max-height: 120px; border-radius: 6px; margin-top: 8px; object-fit: cover; }
    .toast-close {
      background: none; border: none; color: var(--text-muted); cursor: pointer;
      padding: 2px; line-height: 1; font-size: 16px;
    }
    .toast-close:hover { color: var(--text); }

    @media (max-width: 768px) {
      #sidebar { 
        width: 100%; 
        position: fixed; 
        top: 0; 
        left: 0; 
        z-index: 1000; 
        transform: translateX(-100%); 
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        height: 100vh; 
      }
      #sidebar.visible { transform: translateX(0); }
      #main-panel { width: 100%; }
      
      .ch-actions { 
        flex-wrap: wrap; 
        gap: 4px;
        justify-content: flex-end;
      }
      .ch-actions .ch-btn {
        padding: 6px 10px;
        font-size: 11px;
      }
      
      #menu-toggle, #sidebar-close { display: flex; }
      
      .msg-col { max-width: 88%; }
      .msg-bubble { font-size: 15px; } /* Slightly larger for easier reading */
      
      .ch-info { min-width: 0; }
      .ch-name { font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
      
      #input-bar { padding: 10px; gap: 8px; }
      #reply-input { font-size: 16px; border-radius: 18px; }
      
      #chat-header { padding: 12px 16px; }
      #chat-messages { padding: 15px; }
      
      .stats-strip { flex-wrap: wrap; }
      .stat-item { flex: 1 1 50%; border-bottom: 1px solid var(--border); padding: 8px; }
      .stat-item:last-child { border-right: none; flex: 1 1 100%; border-bottom: none; }

      #settings-view { padding: 15px; }
      #settings-view > div { max-width: 100% !important; }
      #settings-view .setting-item { grid-column: span 2; }
      
      #no-chat-menu, #settings-menu { display: flex !important; }
      #no-chat h2, #settings-view h2 { margin-left: 50px; }
    }

    @media (max-width: 480px) {
        .ch-actions {
            position: fixed;
            bottom: 80px;
            right: 16px;
            flex-direction: column;
            background: var(--surface2);
            padding: 10px;
            border-radius: 12px;
            border: 1px solid var(--border2);
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            display: none; /* Show only when "More" is clicked? No, let's keep them in header if possible, or hide some */
        }
        /* Let's try to keep essential ones: Close, Block. Hide others or wrap. */
        .ch-btn span { display: none; } /* Hide text if we had spans, but we don't */
        
        /* Better: hide less important buttons on very small screens */
        #copy-session-btn, #reopen-session-btn { display: none !important; }
    }
  </style>
</head>
<body>

<!-- Image lightbox -->
<div id="admin-lightbox">
  <button id="lb-close">✕</button>
  <img id="lb-img" src="" alt="Preview">
</div>

<!-- Toast container -->
<div id="toast-container"></div>

<!-- Sidebar -->
<div id="sidebar">
  <div class="sidebar-header">
    <div class="logo-icon">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
    </div>
    <div>
      <div class="logo-title">WebChat</div>
      <div class="logo-sub" id="agent-name-label">Loading…</div>
    </div>
    <button id="logout-btn" title="Logout" style="margin-left: 0;">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
      </svg>
    </button>
    <button id="sidebar-close" title="Close menu">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>

  <div class="tab-bar">
    <button class="tab-btn active" id="tab-open" data-status="open">Open <span id="open-count"></span></button>
    <button class="tab-btn" id="tab-all" data-status="all">All</button>
    <button class="tab-btn" id="tab-closed" data-status="closed">Closed</button>
    <button class="tab-btn" id="tab-settings" data-status="settings">Settings</button>
  </div>

  <div class="search-wrap">
    <input type="search" id="search-input" placeholder="Search conversations…">
  </div>

  <div id="session-list">
    <div class="empty-sidebar">
      <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" opacity="0.3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
      <span>Loading chats…</span>
    </div>
  </div>
</div>

<!-- Main Panel -->
<div id="main-panel">
  <!-- No chat selected -->
  <div id="no-chat">
    <button class="icon-btn" style="position:absolute; top:16px; left:16px; display:none; border: 1px solid var(--border2);" id="no-chat-menu">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
    <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    <h3>Select a conversation</h3>
    <p>Choose a chat from the left panel to start responding</p>
  </div>

  <!-- Active chat view -->
  <div id="chat-view">
    <div id="chat-header">
      <button id="menu-toggle" title="Open menu">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div class="ch-avatar" id="ch-avatar">?</div>
      <div class="ch-info">
        <div class="ch-name" id="ch-name">—</div>
        <div class="ch-meta" id="ch-meta"></div>
      </div>
      <div class="ch-actions">
        <button class="ch-btn ch-btn-outline" id="copy-session-btn" title="Copy session ID">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:4px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
          </svg>Session ID
        </button>
        <button class="ch-btn ch-btn-outline" id="reopen-session-btn" style="display:none">Reopen Chat</button>
        <button class="ch-btn ch-btn-danger" id="destroy-session-btn" title="Destroy everything: chat history, photos, and record">Destroy</button>
        <button class="ch-btn ch-btn-danger" id="block-session-btn">Block Chat</button>
        <button class="ch-btn ch-btn-outline" id="unblock-session-btn" style="display:none">Unblock Chat</button>
        <button class="ch-btn ch-btn-danger" id="close-session-btn">Close Chat</button>
      </div>
    </div>

    <div class="stats-strip" id="stats-strip" style="display:none">
      <div class="stat-item"><span class="stat-value" id="stat-msgs">0</span>Messages</div>
      <div class="stat-item"><span class="stat-value" id="stat-ip">—</span>IP Address</div>
      <div class="stat-item"><span class="stat-value" id="stat-started">—</span>Started</div>
    </div>

    <div id="chat-messages"></div>

    <div id="preview-bar">
      <img id="preview-img-admin" src="" alt="">
      <span id="preview-name-admin"></span>
      <button id="rm-preview">✕</button>
    </div>

    <div id="input-bar">
      <textarea id="reply-input" placeholder="Type your reply… (Enter to send, Shift+Enter for newline)" rows="1"></textarea>
      <label class="icon-btn" for="admin-file-input" title="Attach image">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
      </label>
      <input type="file" id="admin-file-input" accept="image/*" style="display:none">
      <button id="send-reply-btn" class="icon-btn" title="Send reply">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Settings view -->
  <div id="settings-view" style="display:none; flex-direction:column; flex:1; overflow-y:auto; padding:30px; position:relative;">
    <button class="icon-btn" style="position:absolute; top:16px; left:16px; display:none; border: 1px solid var(--border2);" id="settings-menu">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
    <h2 style="margin-bottom:20px; margin-top: 10px;">Widget Customization</h2>
    <div style="max-width:600px; display:flex; flex-direction:column; gap:20px;">
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; background:var(--surface); padding:20px; border-radius:12px; border:1px solid var(--border);">
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Primary Color</label>
          <input type="color" id="set-wc-primary" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Primary Dark Color</label>
          <input type="color" id="set-wc-primary-dark" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Background Color</label>
          <input type="color" id="set-wc-bg" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Surface Color</label>
          <input type="color" id="set-wc-surface" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Surface 2 Color</label>
          <input type="color" id="set-wc-surface2" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Surface 3 Color</label>
          <input type="color" id="set-wc-surface3" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Text Color</label>
          <input type="color" id="set-wc-text" class="color-picker-input">
        </div>
        <div class="setting-item">
          <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-muted);">Text Muted Color</label>
          <input type="color" id="set-wc-text-muted" class="color-picker-input">
        </div>
      </div>
      <button id="save-settings-btn" class="ch-btn" style="background:var(--primary); color:white; align-self:flex-start; padding:10px 24px;">Save Configuration</button>
    </div>
  </div>
</div>

<script>
const API_AUTH = '../api/auth.php';
const API_CHAT = '../api/chat.php';
const POLL_MS  = 2000;

// ── Admin Sound Engine (Web Audio API) ────────────────────────────────────
let _adminAudioCtx = null;
function getAdminAudio() {
  if (!_adminAudioCtx) {
    try { _adminAudioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch(e) {}
  }
  return _adminAudioCtx;
}
function adminPlaySend() {
  try {
    const ctx = getAdminAudio(); if (!ctx) return;
    const osc = ctx.createOscillator(), gain = ctx.createGain();
    osc.connect(gain); gain.connect(ctx.destination);
    osc.type = 'sine';
    osc.frequency.setValueAtTime(600, ctx.currentTime);
    osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.08);
    gain.gain.setValueAtTime(0.12, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.16);
    osc.start(ctx.currentTime); osc.stop(ctx.currentTime + 0.16);
  } catch(e) {}
}
function adminPlayReceive() {
  try {
    const ctx = getAdminAudio(); if (!ctx) return;
    [[380, 0], [560, 0.13]].forEach(([freq, delay]) => {
      const osc = ctx.createOscillator(), gain = ctx.createGain();
      osc.connect(gain); gain.connect(ctx.destination);
      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, ctx.currentTime + delay);
      gain.gain.setValueAtTime(0, ctx.currentTime + delay);
      gain.gain.linearRampToValueAtTime(0.18, ctx.currentTime + delay + 0.02);
      gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + delay + 0.3);
      osc.start(ctx.currentTime + delay); osc.stop(ctx.currentTime + delay + 0.32);
    });
  } catch(e) {}
}

let sessions = [];
let activeSessionId = null;
let lastMsgId = 0;
let pollTimer = null;
let currentStatus = 'open';
let adminFileUpload = null;
let isFocused = true;
let prevUnreadCounts = {}; // Key: session_id, Value: unread_count
let isInitialLoad = true;
let firstMsgId = null;
let hasMoreMessages = true;
let isLoadingMore = false;
const MSG_LIMIT = 30;

// ── Heartbeat ─────────────────────────────────────────────────────────────
function startHeartbeat() {
  sendHeartbeat();
  setInterval(sendHeartbeat, 5000);
}

function sendHeartbeat() {
  fetch(`${API_CHAT}?action=heartbeat`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ 
      is_viewing: isFocused ? 1 : 0,
      session_id: activeSessionId
    })
  });
}

window.addEventListener('focus', () => { isFocused = true; sendHeartbeat(); });
window.addEventListener('blur', () => { isFocused = false; sendHeartbeat(); });

// Handle tab/window closure
window.addEventListener('beforeunload', () => {
  const data = JSON.stringify({ action: 'heartbeat', session_id: activeSessionId, is_leaving: 1 });
  const blob = new Blob([data], { type: 'application/json' });
  navigator.sendBeacon(`${API_CHAT}?action=heartbeat`, blob);
});

// ── Auth check ─────────────────────────────────────────────────────────────
(async function init() {
  const res  = await fetch(API_AUTH + '?action=check');
  const data = await res.json();
  if (!data.logged_in) { window.location.href = 'index.php'; return; }
  document.getElementById('agent-name-label').textContent = data.name || 'Agent';
  // Unlock AudioContext on first user interaction
  document.addEventListener('click', () => getAdminAudio(), { once: true });
  loadSessions();
  setInterval(loadSessions, POLL_MS);
  startHeartbeat();
})();

// ── Logout ─────────────────────────────────────────────────────────────────
document.getElementById('logout-btn').addEventListener('click', async () => {
  await fetch(API_AUTH, { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify({action:'logout'}) });
  window.location.href = 'index.php';
});

// ── Sidebar Mobile Toggle ──────────────────────────────────────────────────
document.querySelectorAll('#menu-toggle, #no-chat-menu, #settings-menu').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('sidebar').classList.add('visible');
  });
});
document.getElementById('sidebar-close')?.addEventListener('click', () => {
  document.getElementById('sidebar').classList.remove('visible');
});
// Also close if clicked outside on mobile
document.addEventListener('click', (e) => {
  const sidebar = document.getElementById('sidebar');
  const isToggle = e.target.closest('#menu-toggle, #no-chat-menu, #settings-menu');
  if (window.innerWidth <= 768 && 
      sidebar.classList.contains('visible') && 
      !sidebar.contains(e.target) && 
      !isToggle) {
    sidebar.classList.remove('visible');
  }
});

// ── Tabs ───────────────────────────────────────────────────────────────────
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentStatus = btn.dataset.status;
    if (currentStatus === 'settings') {
      document.getElementById('no-chat').style.display = 'none';
      document.getElementById('chat-view').style.display = 'none';
      document.getElementById('settings-view').style.display = 'flex';
      loadSettings();
      if (window.innerWidth <= 768) document.getElementById('sidebar').classList.remove('visible');
    } else {
      document.getElementById('settings-view').style.display = 'none';
      document.getElementById('no-chat').style.display = activeSessionId ? 'none' : 'flex';
      document.getElementById('chat-view').style.display = activeSessionId ? 'flex' : 'none';
      loadSessions();
    }
  });
});

async function loadSettings() {
  const res = await fetch(`${API_CHAT}?action=get_settings`);
  const data = await res.json();
  if (data.settings) {
    for (const key in data.settings) {
      const el = document.getElementById('set-' + key.replace(/_/g, '-'));
      if (el) el.value = data.settings[key];
    }
  }
}

document.getElementById('save-settings-btn').addEventListener('click', async () => {
  const settings = {
    wc_primary: document.getElementById('set-wc-primary').value,
    wc_primary_dark: document.getElementById('set-wc-primary-dark').value,
    wc_bg: document.getElementById('set-wc-bg').value,
    wc_surface: document.getElementById('set-wc-surface').value,
    wc_surface2: document.getElementById('set-wc-surface2').value,
    wc_surface3: document.getElementById('set-wc-surface3').value,
    wc_text: document.getElementById('set-wc-text').value,
    wc_text_muted: document.getElementById('set-wc-text-muted').value,
  };
  
  const res = await fetch(`${API_CHAT}?action=update_settings`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'update_settings', settings })
  });
  const data = await res.json();
  if (data.success) showToast('Settings saved successfully');
});

// ── Search ─────────────────────────────────────────────────────────────────
document.getElementById('search-input').addEventListener('input', function() {
  renderSessions(sessions.filter(s =>
    s.visitor_name.toLowerCase().includes(this.value.toLowerCase()) ||
    (s.last_message || '').toLowerCase().includes(this.value.toLowerCase())
  ));
});

// ── Load sessions ──────────────────────────────────────────────────────────
async function loadSessions() {
  try {
    const res  = await fetch(`${API_CHAT}?action=get_sessions&status=${currentStatus}`);
    const data = await res.json();
    if (!data.sessions) return;
    sessions = data.sessions;

    const searchVal = document.getElementById('search-input').value.toLowerCase();
    const filtered  = searchVal
      ? sessions.filter(s => s.visitor_name.toLowerCase().includes(searchVal) || (s.last_message || '').toLowerCase().includes(searchVal))
      : sessions;

    renderSessions(filtered);

    const openCount = sessions.filter(s => parseInt(s.unread_count) > 0 && s.status === 'open').length;
    document.getElementById('open-count').textContent = openCount ? `(${openCount})` : '';

    // Check for new unread messages for sessions NOT active
    sessions.forEach(s => {
      const oldVal = prevUnreadCounts[s.session_id] || 0;
      const newVal = parseInt(s.unread_count);
      
      if (newVal > oldVal && s.session_id !== activeSessionId && !isInitialLoad) {
        showChatToast(s);
      }
      prevUnreadCounts[s.session_id] = newVal;
    });
    isInitialLoad = false;

    // If active session is open, poll messages
    if (activeSessionId) pollMessages();
  } catch(e) {}
}

function showChatToast(session) {
  const container = document.getElementById('toast-container');
  const card = document.createElement('div');
  card.className = 'toast-card';
  
  const initials = session.visitor_name.charAt(0).toUpperCase();
  let msgPreview = session.last_message || '';
  if (session.last_message_type === 'image') msgPreview = '📷 Image';
  
  let imgHtml = '';
  if (session.last_message_type === 'image' && session.last_message_file) {
    imgHtml = `<img src="../${session.last_message_file}" class="toast-img">`;
  }

  card.innerHTML = `
    <div class="toast-av">${initials}</div>
    <div class="toast-content" onclick="openSession('${escHtml(session.session_id)}', '${escHtml(session.visitor_name)}')">
      <div class="toast-title">${escHtml(session.visitor_name)}</div>
      <div class="toast-msg">${escHtml(msgPreview)}</div>
      ${imgHtml}
    </div>
    <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
  `;

  container.appendChild(card);
  setTimeout(() => card.classList.add('show'), 50);

  // Auto-remove after 5s
  setTimeout(() => {
    card.classList.remove('show');
    setTimeout(() => card.remove(), 500);
  }, 5000);

  // Sound
  try { adminPlayReceive(); } catch(e) {}
}

function renderSessions(list) {
  const el = document.getElementById('session-list');
  if (!list.length) {
    el.innerHTML = `<div class="empty-sidebar">
      <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" opacity="0.3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <span>No conversations</span>
    </div>`;
    return;
  }
  el.innerHTML = list.map(s => {
    const initials = s.visitor_name.charAt(0).toUpperCase();
    let last = s.last_message ? escHtml(s.last_message).substring(0,50) : '<em>Image</em>';
    if (s.last_message_type === 'image') last = '📷 Image';
    const time     = timeAgo(s.last_activity);
    const unread   = parseInt(s.unread_count) > 0;
    const isActive = s.session_id === activeSessionId;
    let badges = `<span class="si-status-badge ${s.status}">${s.status}</span>`;
    if (parseInt(s.is_blocked)) badges += `<span class="si-status-badge blocked">blocked</span>`;

    // Presence - Only use last_presence, not last_activity (which is for sorting/messages)
    const isOnline = (new Date() - new Date(s.last_presence || '2000-01-01')) < 10000;
    const isViewing = parseInt(s.is_viewing) === 1 && isOnline;
    const pClass = isViewing ? 'viewing' : (isOnline ? 'online' : 'offline');
    const pLabel = isViewing ? 'Viewing' : (isOnline ? 'Online' : 'Offline');

    return `<div class="session-item${unread ? ' unread' : ''}${isActive ? ' active' : ''}" data-id="${escHtml(s.session_id)}" data-name="${escHtml(s.visitor_name)}">
      <div class="si-avatar">${initials}</div>
      <div class="si-body">
        <div class="si-name">${escHtml(s.visitor_name)}${badges}</div>
        <div class="si-last">${last}</div>
        <div class="presence-row"><span class="presence-dot ${pClass}"></span>${pLabel}</div>
      </div>
      <div class="si-time">${time}</div>
      <div class="si-unread-dot"></div>
    </div>`;
  }).join('');

  el.querySelectorAll('.session-item').forEach(item => {
    item.addEventListener('click', () => openSession(item.dataset.id, item.dataset.name));
  });
}

// ── Open Session ───────────────────────────────────────────────────────────
async function openSession(sessionId, name) {
  activeSessionId = sessionId;
  lastMsgId = 0;

  // Update sidebar highlight
  document.querySelectorAll('.session-item').forEach(el => {
    el.classList.toggle('active', el.dataset.id === sessionId);
  });

  // Update header
  document.getElementById('ch-avatar').textContent = name.charAt(0).toUpperCase();
  document.getElementById('ch-name').textContent   = name;
  document.getElementById('ch-meta').textContent   = 'Loading…';
  document.getElementById('no-chat').style.display = 'none';
  document.getElementById('settings-view').style.display = 'none';
  document.getElementById('chat-view').style.display = 'flex';

  // Clear messages
  document.getElementById('chat-messages').innerHTML = '';
  firstMsgId = null;
  lastMsgId = 0;
  hasMoreMessages = true;

  // Get session info
  try {
    const sRes  = await fetch(`${API_CHAT}?action=get_session&session_id=${encodeURIComponent(sessionId)}`);
    const sData = await sRes.json();
    if (sData.session) {
      const s = sData.session;
      document.getElementById('ch-meta').textContent = `${s.ip_address || 'Unknown IP'} · Started ${timeAgo(s.created_at)}`;
      document.getElementById('stat-ip').textContent = s.ip_address || '—';
      document.getElementById('stat-started').textContent = formatDate(s.created_at);
      document.getElementById('stats-strip').style.display = 'flex';

      // Update actions based on status
      document.getElementById('close-session-btn').style.display = (s.status === 'open') ? 'block' : 'none';
      document.getElementById('reopen-session-btn').style.display = (s.status === 'closed') ? 'block' : 'none';
      document.getElementById('block-session-btn').style.display = (parseInt(s.is_blocked) === 0) ? 'block' : 'none';
      document.getElementById('unblock-session-btn').style.display = (parseInt(s.is_blocked) === 1) ? 'block' : 'none';
      
      // Disable input if closed
      document.getElementById('reply-input').disabled = (s.status === 'closed');
      document.getElementById('reply-input').placeholder = (s.status === 'closed') ? 'Reopen chat to reply' : 'Type your reply…';
    }
  } catch(e) {}

  // Mark as read
  fetch(API_CHAT + '?action=mark_read', {
    method: 'POST',
    headers: {'Content-Type':'application/json', 'X-Session-ID': sessionId },
    body: JSON.stringify({ action: 'mark_read' })
  });

  // Load initial messages
  await loadMessages();
  if (pollTimer) clearInterval(pollTimer);
  pollTimer = setInterval(pollMessages, POLL_MS);

  // Send heartbeat immediately to update "viewing" status
  sendHeartbeat();

  document.getElementById('reply-input').focus();
  
  // Close sidebar on mobile after selecting a session
  if (window.innerWidth <= 768) {
    document.getElementById('sidebar').classList.remove('visible');
  }
}

async function loadMessages() {
  if (!activeSessionId || isLoadingMore || !hasMoreMessages) return;
  isLoadingMore = true;
  
  const url = `${API_CHAT}?action=get_messages&session_id=${encodeURIComponent(activeSessionId)}&limit=${MSG_LIMIT}` + (firstMsgId ? `&before_id=${firstMsgId}` : '');
  const res  = await fetch(url);
  const data = await res.json();
  
  if (data.messages && data.messages.length > 0) {
    const container = document.getElementById('chat-messages');
    const oldHeight = container.scrollHeight;
    
    // If loading more, we prepend
    if (firstMsgId) {
      // Reverse because they come in DESC order now from API when not using 'since' but array_reversed at end of handleGetMessages
      // Actually handleGetMessages reverses them before returning, so they are ASC
      data.messages.slice().reverse().forEach(m => prependMsg(m));
    } else {
      data.messages.forEach(m => appendMsg(m));
    }
    
    if (!firstMsgId) {
        scrollToBottom();
        lastMsgId = Math.max(...data.messages.map(m => parseInt(m.id)));
    } else {
        container.scrollTop = container.scrollHeight - oldHeight;
    }
    
    firstMsgId = Math.min(...data.messages.map(m => parseInt(m.id)));
    if (data.messages.length < MSG_LIMIT) hasMoreMessages = false;
    
    document.getElementById('stat-msgs').textContent = container.querySelectorAll('.msg-row:not(.system)').length;
  } else {
    hasMoreMessages = false;
  }
  isLoadingMore = false;
}

// Scroll listener for lazy loading
document.getElementById('chat-messages').addEventListener('scroll', function() {
  if (this.scrollTop < 50 && hasMoreMessages && !isLoadingMore) {
    loadMessages();
  }
});

function prependMsg(msg) {
  const container = document.getElementById('chat-messages');
  const row = buildMsgRow(msg);
  container.insertBefore(row, container.firstChild);
}

function buildMsgRow(msg) {
  const isAgent   = msg.sender === 'agent';
  const time      = formatTime(msg.created_at);
  const agentName = document.getElementById('agent-name-label').textContent;
  const initials  = isAgent ? (agentName.charAt(0) || 'A') : (document.getElementById('ch-name').textContent.charAt(0) || 'V');

  let content = '';
  let isEmojiOnly = false;
  if (msg.message_type === 'image' && msg.file_path) {
    const imgSrc = `../${msg.file_path}`;
    content = `<img src="${imgSrc}" alt="${escHtml(msg.file_name||'image')}" loading="lazy">`;
  } else {
    const rawMsg = msg.message || '';
    const emojiRegex = /^(\s*[\u{1F300}-\u{1F9FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{1F191}-\u{1F251}\u{1F004}\u{1F0CF}\u{1F170}-\u{1F171}\u{1F17E}-\u{1F17F}\u{1F18E}\u{3030}\u{303D}\u{2139}\u{2122}\u{3297}\u{3299}\u{1F1E6}-\u{1F1FF}]\s*)+$/u;
    if (rawMsg.length > 0 && emojiRegex.test(rawMsg) && rawMsg.replace(/\s/g, '').length <= 20) {
      isEmojiOnly = true;
    }
    content = escHtml(rawMsg).replace(/\n/g, '<br>');
  }

  const row = document.createElement('div');
  row.setAttribute('data-time', new Date(msg.created_at).getTime());
  row.setAttribute('data-msg-id', msg.id);
  if (msg.sender === 'system') {
    row.className = 'msg-row system';
    row.innerHTML = `<div class="msg-bubble system">${content.replace(/<br>/g, ' ')}</div>`;
  } else {
    row.className = `msg-row ${isAgent ? 'agent' : 'visitor'}`;
    
    let statusHtml = '';
    if (isAgent) {
      const status = msg.status || 'sent';
      let icon = '';
      if (status === 'sent') icon = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12l5 5L20 7"/></svg>';
      else if (status === 'delivered' || status === 'seen') icon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12l5 5L15 7M10 17l5 5L22 10"/></svg>';
      statusHtml = `<div class="msg-status ${status}" title="${status}">${icon}</div>`;
    }

    row.innerHTML = `
      <div class="msg-avatar-sm ${isAgent ? 'agent-av' : ''}">${initials.toUpperCase()}</div>
      <div class="msg-col">
        <div class="msg-bubble ${isAgent ? 'agent' : 'visitor'}${isEmojiOnly ? ' emoji-only' : ''}">${content}</div>
        <div class="msg-time-row">
          <div class="msg-time">${time}</div>
          ${statusHtml}
        </div>
      </div>
    `;
  }
  row.querySelectorAll('img').forEach(img => {
    img.addEventListener('click', () => openLightbox(img.src));
  });
  return row;
}

async function pollMessages() {
  if (!activeSessionId) return;
  try {
    const res  = await fetch(`${API_CHAT}?action=get_messages&session_id=${encodeURIComponent(activeSessionId)}&since=${lastMsgId}`);
    const data = await res.json();
    
    // Handle status updates for existing agent messages
    if (data.messages) {
      data.messages.forEach(m => {
        const existing = document.querySelector(`.msg-row[data-msg-id="${m.id}"]`);
        if (existing) {
          const statusEl = existing.querySelector('.msg-status');
          if (statusEl && m.status) {
            statusEl.className = `msg-status ${m.status}`;
            statusEl.title = m.status;
            if (m.status === 'delivered' || m.status === 'seen') {
              statusEl.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12l5 5L15 7M10 17l5 5L22 10"/></svg>';
            }
          }
        }
      });
    }

    if (data.messages && data.messages.length) {
      data.messages.forEach(m => {
        if (parseInt(m.id) > lastMsgId) {
          appendMsg(m, true);
          lastMsgId = parseInt(m.id);
        }
      });
      scrollToBottom();
      const total = document.getElementById('chat-messages').querySelectorAll('.msg-row').length;
      document.getElementById('stat-msgs').textContent = total;
    }
  } catch(e) {}
}

function appendMsg(msg, playSound) {
  const container = document.getElementById('chat-messages');
  const row = buildMsgRow(msg);
  
  // Stacking logic
  const lastRow = container.lastElementChild;
  if (lastRow && !lastRow.classList.contains('system') && msg.sender !== 'system') {
    const lastSender = lastRow.classList.contains('agent') ? 'agent' : 'visitor';
    if (lastSender === msg.sender) {
      const lastTime = parseInt(lastRow.getAttribute('data-time'));
      const currentTime = new Date(msg.created_at).getTime();
      if (currentTime - lastTime < 120000) {
        row.classList.add('stacked');
        lastRow.classList.add('has-next');
      }
    }
  }

  container.appendChild(row);
  if (playSound) {
    if (msg.sender === 'agent') adminPlaySend(); else adminPlayReceive();
  }
}

// ── Send reply ─────────────────────────────────────────────────────────────
document.getElementById('send-reply-btn').addEventListener('click', sendReply);
document.getElementById('reply-input').addEventListener('keydown', e => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendReply(); }
});
document.getElementById('reply-input').addEventListener('input', function() {
  this.style.height = 'auto';
  this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

async function sendReply() {
  if (!activeSessionId) return;

  if (adminFileUpload) {
    const fd = new FormData();
    fd.append('action', 'agent_reply');
    fd.append('session_id', activeSessionId);
    fd.append('image', adminFileUpload);
    clearAdminPreview();
    adminPlaySend();
    await fetch(API_CHAT, { method: 'POST', headers: { 'X-Session-ID': activeSessionId }, body: fd });
  } else {
    const input = document.getElementById('reply-input');
    const text  = input.value.trim();
    if (!text) return;
    input.value = '';
    input.style.height = 'auto';
    adminPlaySend();
    await fetch(API_CHAT + '?action=agent_reply', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
      body: JSON.stringify({ action: 'agent_reply', message: text })
    });
  }
  await loadSessions();
}

// ── Image attach ───────────────────────────────────────────────────────────
document.getElementById('admin-file-input').addEventListener('change', function() {
  const file = this.files[0];
  if (!file) return;
  adminFileUpload = file;
  const url = URL.createObjectURL(file);
  document.getElementById('preview-img-admin').src = url;
  document.getElementById('preview-name-admin').textContent = file.name;
  document.getElementById('preview-bar').style.display = 'flex';
});
document.getElementById('rm-preview').addEventListener('click', clearAdminPreview);
function clearAdminPreview() {
  adminFileUpload = null;
  document.getElementById('admin-file-input').value = '';
  document.getElementById('preview-bar').style.display = 'none';
}

// ── Close session ──────────────────────────────────────────────────────────
document.getElementById('close-session-btn').addEventListener('click', async () => {
  if (!activeSessionId) return;
  if (!confirm('Close this chat session?')) return;
  await fetch(API_CHAT + '?action=close_session', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
    body: JSON.stringify({ action: 'close_session' })
  });
  showToast('Chat closed');
  // Refresh UI
  openSession(activeSessionId, document.getElementById('ch-name').textContent);
  loadSessions();
});

// ── Reopen session ────────────────────────────────────────────────────────
document.getElementById('reopen-session-btn').addEventListener('click', async () => {
  if (!activeSessionId) return;
  await fetch(API_CHAT + '?action=reopen_session', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
    body: JSON.stringify({ action: 'reopen_session' })
  });
  showToast('Chat reopened');
  openSession(activeSessionId, document.getElementById('ch-name').textContent);
  loadSessions();
});

// ── Block session ──────────────────────────────────────────────────────────
document.getElementById('block-session-btn').addEventListener('click', async () => {
  if (!activeSessionId) return;
  if (!confirm('Block this user? They will not be able to send messages.')) return;
  await fetch(API_CHAT + '?action=block_session', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
    body: JSON.stringify({ action: 'block_session' })
  });
  showToast('User blocked');
  openSession(activeSessionId, document.getElementById('ch-name').textContent);
  loadSessions();
});

// ── Unblock session ────────────────────────────────────────────────────────
document.getElementById('unblock-session-btn').addEventListener('click', async () => {
  if (!activeSessionId) return;
  await fetch(API_CHAT + '?action=unblock_session', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
    body: JSON.stringify({ action: 'unblock_session' })
  });
  showToast('User unblocked');
  openSession(activeSessionId, document.getElementById('ch-name').textContent);
  loadSessions();
});

// ─── Destroy session ────────────────────────────────────────────────────────
document.getElementById('destroy-session-btn').addEventListener('click', async () => {
  if (!activeSessionId) return;
  const name = document.getElementById('ch-name').textContent;
  if (!confirm(`💣 DESTROY EVERYTHING?\n\nThis will permanently delete ALL messages, ALL uploaded photos, and remove "${name}" from your recent chats. This cannot be undone.\n\nProceed?`)) return;

  try {
    const res = await fetch(API_CHAT + '?action=destroy_session', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Session-ID': activeSessionId },
      body: JSON.stringify({ action: 'destroy_session' })
    });
    const data = await res.json();
    if (data.success) {
      showToast('Session destroyed successfully');
      // Clear view and refresh list
      activeSessionId = null;
      document.getElementById('chat-view').style.display = 'none';
      document.getElementById('no-chat').style.display = 'flex';
      loadSessions();
    } else {
      showToast('Error: ' + (data.error || 'Failed to destroy session'));
    }
  } catch (e) {
    showToast('Error connecting to server');
  }
});

// ── Copy Session ID ────────────────────────────────────────────────────────
document.getElementById('copy-session-btn').addEventListener('click', () => {
  if (!activeSessionId) return;
  navigator.clipboard.writeText(activeSessionId).then(() => showToast('Session ID copied!'));
});

// ── Lightbox ───────────────────────────────────────────────────────────────
function openLightbox(src) {
  document.getElementById('lb-img').src = src;
  document.getElementById('admin-lightbox').classList.add('show');
}
document.getElementById('lb-close').addEventListener('click', () => {
  document.getElementById('admin-lightbox').classList.remove('show');
});
document.getElementById('admin-lightbox').addEventListener('click', e => {
  if (e.target === document.getElementById('admin-lightbox'))
    document.getElementById('admin-lightbox').classList.remove('show');
});

// ── Scroll ─────────────────────────────────────────────────────────────────
function scrollToBottom() {
  const c = document.getElementById('chat-messages');
  c.scrollTop = c.scrollHeight;
}

// ── Toast ──────────────────────────────────────────────────────────────────
function showToast(msg) {
  const container = document.getElementById('toast-container');
  const card = document.createElement('div');
  card.className = 'toast-card';
  card.innerHTML = `
    <div class="toast-content" style="padding-right: 20px;">
      <div class="toast-title">${escHtml(msg)}</div>
    </div>
    <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
  `;
  container.appendChild(card);
  setTimeout(() => card.classList.add('show'), 50);
  setTimeout(() => {
    card.classList.remove('show');
    setTimeout(() => card.remove(), 500);
  }, 3000);
}

// ── Utilities ──────────────────────────────────────────────────────────────
function escHtml(str) {
  return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function formatTime(ts) {
  if (!ts) return '';
  try { return new Date(ts).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}); } catch{ return ''; }
}
function formatDate(ts) {
  if (!ts) return '—';
  try { return new Date(ts).toLocaleDateString(); } catch { return '—'; }
}
function timeAgo(ts) {
  if (!ts) return '';
  const diff = Math.floor((Date.now() - new Date(ts).getTime()) / 1000);
  if (diff < 60) return 'just now';
  if (diff < 3600) return Math.floor(diff/60) + 'm';
  if (diff < 86400) return Math.floor(diff/3600) + 'h';
  return Math.floor(diff/86400) + 'd';
}
</script>
</body>
</html>
