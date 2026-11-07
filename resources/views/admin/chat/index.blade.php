<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chats · {{ config('app.name', 'Handy Games') }}</title>
    <style>
        :root {
            --blue: #1877f2;
            --blue-dark: #0866ff;
            --blue-soft: #e7f3ff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e5e7eb;
            --panel: #fff;
            --soft: #f0f2f5;
            --bubble: #eef0f4;
            --green: #22c55e;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            overflow: hidden;
            color: var(--ink);
            background: var(--panel);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        button, input, textarea { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }
        button { cursor: pointer; }
        a { color: inherit; text-decoration: none; }

        .messenger {
            display: grid;
            width: 100%;
            height: 100vh;
            grid-template-rows: 85px minmax(0, 1fr);
            background: var(--panel);
        }

        .topbar {
            display: grid;
            min-width: 0;
            grid-template-columns: 430px minmax(0, 1fr) auto;
            align-items: center;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, .98);
        }

        .brand-area {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 36px;
        }

        .brand {
            display: grid;
            width: 52px;
            height: 52px;
            place-items: center;
            border-radius: 50%;
            color: #fff;
            background: var(--blue);
            box-shadow: inset 0 -4px 0 rgba(0, 0, 0, .08);
            font-size: 37px;
            font-weight: 800;
            letter-spacing: -7px;
            line-height: 1;
            padding-right: 6px;
        }

        .main-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(18px, 4vw, 70px);
            height: 100%;
        }

        .nav-link {
            position: relative;
            display: grid;
            width: 52px;
            height: 100%;
            place-items: center;
            color: #596275;
            transition: color .15s ease;
        }

        .nav-link:hover, .nav-link.active { color: var(--blue); }
        .nav-link.active::after {
            position: absolute;
            right: 0;
            bottom: -1px;
            left: 0;
            height: 3px;
            border-radius: 3px 3px 0 0;
            background: var(--blue);
            content: "";
        }

        .top-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 17px;
            height: 100%;
            padding: 0 24px 0 10px;
        }

        .top-action {
            display: grid;
            width: 52px;
            height: 52px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            color: #273247;
            background: #f2f4f8;
        }

        .top-action.active {
            color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 1px #dbeafe, 0 0 0 7px #f8fbff;
        }

        .top-action svg { width: 24px; height: 24px; }
        .profile-link { display: block; }
        .profile-avatar { width: 49px; height: 49px; font-size: 18px; }

        .workspace {
            display: grid;
            min-width: 0;
            min-height: 0;
            grid-template-columns: 430px minmax(0, 1fr) 350px;
        }

        .workspace:not(.details-open) { grid-template-columns: 430px minmax(0, 1fr); }

        .sidebar, .chat-column, .details {
            min-width: 0;
            min-height: 0;
            background: var(--panel);
        }

        .sidebar { display: flex; flex-direction: column; border-right: 1px solid var(--line); }
        .sidebar-header { padding: 21px 24px 13px; }
        .sidebar-heading { display: flex; align-items: center; justify-content: space-between; gap: 14px; }
        .sidebar-heading h1 { margin: 0; color: #101828; font-size: 33px; line-height: 1; letter-spacing: -.045em; }
        .heading-actions { display: flex; gap: 11px; }
        .chat-tabs { display: flex; margin: 18px -24px 0; padding: 0 24px; border-bottom: 1px solid var(--line); }
        .chat-tab { position: relative; flex: 1; padding: 0 5px 12px; border: 0; color: #657086; background: transparent; font-size: 13px; font-weight: 650; }
        .chat-tab:hover, .chat-tab.active { color: var(--blue); }
        .chat-tab.active::after { position: absolute; right: 0; bottom: -1px; left: 0; height: 2px; border-radius: 2px 2px 0 0; background: var(--blue); content: ""; }
        .round-button {
            display: grid;
            width: 50px;
            height: 50px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            color: #101828;
            background: #f2f4f8;
        }
        .round-button:hover { background: #e8edf5; }
        .round-button svg { width: 25px; height: 25px; }

        .search-row { display: flex; align-items: center; gap: 7px; margin-top: 15px; }
        .search-box { position: relative; min-width: 0; flex: 1; }
        .search-box svg { position: absolute; top: 15px; left: 16px; color: #657086; }
        .search-box input {
            width: 100%;
            height: 51px;
            padding: 0 18px 0 47px;
            border: 0;
            border-radius: 28px;
            outline: 0;
            color: var(--ink);
            background: #f0f2f5;
            font-size: 16px;
        }
        .search-box input::placeholder { color: #647086; }
        .search-box input:focus { box-shadow: 0 0 0 2px #bfdbfe; }
        .search-submit { height: 42px; padding: 0 13px; border: 1px solid #cbd5e1; border-radius: 9px; color: #334155; background: #fff; font-size: 12px; font-weight: 700; }
        .search-submit:hover { border-color: #93c5fd; color: var(--blue); background: var(--blue-soft); }

        .conversation-list {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding: 0 7px 16px;
        }
        .conversation-list::-webkit-scrollbar, .messages::-webkit-scrollbar { width: 7px; }
        .conversation-list::-webkit-scrollbar-thumb, .messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }

        .conversation {
            position: relative;
            display: flex;
            width: 100%;
            align-items: flex-start;
            gap: 15px;
            padding: 13px 16px;
            border: 0;
            border-radius: 11px;
            color: inherit;
            text-align: left;
            background: transparent;
        }
        .conversation:hover { background: #f5f7fa; }
        .conversation.active { background: #e6f0ff; }
        .conversation.active::before {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 4px;
            border-radius: 4px;
            background: var(--blue);
            content: "";
        }
        .avatar-wrap { position: relative; flex: 0 0 auto; }
        .avatar {
            display: grid;
            width: 59px;
            height: 59px;
            place-items: center;
            overflow: hidden;
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(135deg, #1877f2, #6a5df5);
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -.03em;
        }
        .avatar.tone-1 { background: linear-gradient(135deg, #8b5cf6, #c084fc); }
        .avatar.tone-2 { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
        .avatar.tone-3 { background: linear-gradient(135deg, #f59e0b, #ef4444); }
        .avatar.tone-4 { background: linear-gradient(135deg, #10b981, #059669); }
        .avatar.tone-5 { background: linear-gradient(135deg, #64748b, #334155); }
        .online-dot {
            position: absolute;
            right: 0;
            bottom: 1px;
            width: 16px;
            height: 16px;
            border: 3px solid #fff;
            border-radius: 50%;
            background: var(--green);
        }
        .person-copy { min-width: 0; flex: 1; }
        .person-top { display: flex; min-width: 0; align-items: center; gap: 8px; }
        .person-name, .preview { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .person-name { color: #101828; font-size: 17px; font-weight: 700; }
        .time { margin-left: auto; flex: 0 0 auto; color: #5f6b80; font-size: 13px; }
        .preview { margin-top: 5px; color: #526078; font-size: 15px; }
        .status-badge { flex: 0 0 auto; padding: 2px 6px; border-radius: 5px; color: #087443; background: #dcfce7; font-size: 10px; font-weight: 800; text-transform: lowercase; }
        .status-badge.closed { color: #64748b; background: #e2e8f0; }
        .session-presence { display: flex; align-items: center; gap: 5px; margin-top: 5px; color: #64748b; font-size: 12px; }
        .presence-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green); }
        .presence-dot.offline { background: #94a3b8; }
        .conversation.unread .person-name, .conversation.unread .preview { font-weight: 800; }
        .unread-count { min-width: 22px; padding: 3px 6px; border-radius: 12px; color: #fff; background: var(--blue); text-align: center; font-size: 11px; font-weight: 800; }
        .empty-list { padding: 42px 18px; color: var(--muted); text-align: center; font-size: 14px; }

        .chat-column { display: flex; flex-direction: column; border-right: 1px solid var(--line); }
        .chat-empty { display: grid; flex: 1; place-items: center; padding: 30px; color: var(--muted); text-align: center; }
        .chat-empty-card { max-width: 310px; }
        .empty-icon { display: grid; width: 76px; height: 76px; margin: 0 auto 18px; place-items: center; border-radius: 50%; color: var(--blue); background: var(--blue-soft); }
        .chat-empty h2 { margin: 0 0 8px; color: var(--ink); font-size: 22px; }
        .chat-empty p { margin: 0; font-size: 14px; }
        .chat-panel { display: flex; min-height: 0; height: 100%; flex-direction: column; }
        .chat-head { display: flex; min-height: 84px; align-items: center; gap: 13px; padding: 14px 23px; border-bottom: 1px solid var(--line); }
        .chat-head .avatar { width: 50px; height: 50px; font-size: 16px; }
        .chat-title { min-width: 0; }
        .chat-name { overflow: hidden; margin: 0; color: #101828; font-size: 22px; line-height: 1.1; text-overflow: ellipsis; white-space: nowrap; }
        .chat-meta { display: flex; align-items: center; gap: 8px; margin-top: 6px; overflow: hidden; color: #617087; font-size: 13px; text-overflow: ellipsis; white-space: nowrap; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green); }
        .status-dot.offline { background: #94a3b8; }
        .chat-actions { display: flex; min-width: 0; align-items: center; margin-left: auto; gap: 8px; }
        .header-button { display: inline-flex; height: 36px; align-items: center; gap: 7px; padding: 0 12px; border: 1px solid #dbe3ef; border-radius: 8px; color: #475569; background: #f8fafc; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .header-button:hover { border-color: #93c5fd; color: var(--blue); background: var(--blue-soft); }
        .header-button.danger { border-color: #fee2e2; color: #b42318; background: #fff7f7; }
        .header-button.danger:hover { border-color: #fecaca; background: #fff1f0; }
        .header-button:disabled { cursor: not-allowed; opacity: .5; }
        .header-button svg { width: 14px; height: 14px; }
        .chat-action {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            color: var(--blue);
            background: transparent;
        }
        .chat-action:hover { background: var(--blue-soft); }

        .conversation-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); border-bottom: 1px solid var(--line); background: #fbfcfe; }
        .summary-item { min-width: 0; padding: 10px 15px 9px; border-right: 1px solid var(--line); text-align: center; }
        .summary-item:last-child { border-right: 0; }
        .summary-item strong, .summary-item span { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .summary-item strong { color: #172033; font-size: 18px; line-height: 1.1; }
        .summary-item span { margin-top: 3px; color: #8a95a8; font-size: 11px; }

        .messages { flex: 1; min-height: 0; overflow-y: auto; padding: 21px clamp(20px, 4vw, 70px) 28px; background: linear-gradient(#fff, #fcfdff); }
        .day-divider { margin: 0 auto 23px; color: #606c81; text-align: center; font-size: 16px; }
        .message-row { display: flex; align-items: flex-end; margin: 11px 0; gap: 10px; }
        .message-row.visitor { justify-content: flex-start; }
        .message-row.agent { justify-content: flex-end; }
        .message-row.system { justify-content: center; }
        .message-avatar { display: grid; width: 42px; height: 42px; flex: 0 0 auto; place-items: center; border-radius: 50%; color: #fff; background: #78a95a; font-size: 13px; font-weight: 800; }
        .message-content { max-width: min(650px, 78%); }
        .message-bubble { padding: 12px 18px; border-radius: 23px; color: #111827; background: var(--bubble); font-size: 18px; line-height: 1.35; white-space: pre-wrap; overflow-wrap: anywhere; }
        .message-row.agent .message-bubble { color: #fff; background: var(--blue); border-bottom-right-radius: 6px; }
        .message-row.visitor .message-bubble { border-bottom-left-radius: 6px; }
        .message-row.system .message-bubble { padding: 7px 12px; border-radius: 12px; color: var(--muted); background: var(--soft); font-size: 12px; }
        .message-time { margin: 4px 10px 0; color: #8994a7; font-size: 11px; }
        .message-row.agent .message-time { text-align: right; }
        .message-status { margin-left: 6px; color: var(--blue); font-weight: 700; }
        .message-image { display: block; max-width: 280px; max-height: 280px; border-radius: 15px; }
        .message-file { display: inline-flex; align-items: center; gap: 8px; padding: 9px 11px; border: 1px solid rgba(100, 116, 139, .2); border-radius: 10px; color: #334155; background: rgba(255, 255, 255, .7); font-size: 14px; font-weight: 650; }
        .message-file:hover { color: var(--blue); background: #fff; }
        .message-caption { margin-top: 8px; white-space: pre-wrap; overflow-wrap: anywhere; }

        .composer { display: flex; align-items: center; gap: 10px; padding: 14px 22px 18px; border-top: 1px solid var(--line); }
        .composer-plus, .send {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            place-items: center;
            border: 0;
            border-radius: 50%;
        }
        .composer-plus { color: #fff; background: var(--blue); }
        .composer-plus:hover, .send:hover { background: var(--blue-dark); }
        .composer-box { display: flex; min-width: 0; flex: 1; align-items: center; border-radius: 24px; background: #f0f2f5; }
        .composer textarea { width: 100%; min-height: 46px; max-height: 120px; resize: none; padding: 12px 8px 11px 18px; border: 0; outline: 0; color: var(--ink); background: transparent; font-size: 16px; }
        .composer textarea::placeholder { color: #647086; }
        .composer-tools { display: flex; align-items: center; padding-right: 9px; gap: 7px; }
        .composer-tool { display: grid; width: 34px; height: 34px; place-items: center; border: 0; border-radius: 50%; color: #5b6678; background: transparent; }
        .composer-tool:hover { color: var(--blue); background: #e2e8f0; }
        .composer-tool:disabled, .composer-plus:disabled { cursor: not-allowed; opacity: .45; }
        .attachment-preview { display: flex; align-items: center; gap: 8px; padding: 8px 22px 0; color: #526078; font-size: 12px; }
        .attachment-preview[hidden] { display: none; }
        .attachment-preview span { max-width: min(520px, 70%); overflow: hidden; padding: 6px 9px; border: 1px solid #dbe3ef; border-radius: 8px; background: #f8fafc; text-overflow: ellipsis; white-space: nowrap; }
        .attachment-preview button { display: grid; width: 24px; height: 24px; place-items: center; border: 0; border-radius: 50%; color: #64748b; background: #f1f5f9; }
        .attachment-preview button:hover { color: #b42318; background: #fee2e2; }
        .send { color: #fff; background: var(--blue); }
        .send:disabled { cursor: not-allowed; opacity: .45; }
        .error { display: none; padding: 8px 22px; color: #b42318; background: #fff1f0; font-size: 12px; }
        .error.show { display: block; }

        .settings-panel { flex: 1; padding: 24px; color: #526078; font-size: 13px; line-height: 1.5; }
        .settings-panel h2 { margin: 0 0 8px; color: #172033; font-size: 18px; }
        .settings-card { padding: 13px; border: 1px solid #dbeafe; border-radius: 12px; background: #f8fbff; }

        .details {
            display: none;
            overflow-y: auto;
            border-left: 1px solid var(--line);
            background: #fbfcfe;
        }
        .workspace.details-open .details { display: block; }
        .details-empty { display: grid; height: 100%; place-items: center; padding: 30px; color: var(--muted); text-align: center; }
        .details-content { min-height: 100%; }
        .profile-card { padding: 25px 20px 27px; text-align: center; }
        .profile-avatar-wrap { position: relative; display: inline-block; }
        .profile-avatar-large { width: 150px; height: 150px; font-size: 42px; box-shadow: 0 4px 18px rgba(15, 23, 42, .12); }
        .profile-avatar-wrap .online-dot { right: 5px; bottom: 8px; width: 29px; height: 29px; border-width: 5px; }
        .profile-name { margin: 17px 0 5px; color: #101828; font-size: 29px; letter-spacing: -.04em; }
        .profile-status { color: #657086; font-size: 18px; }
        .profile-email { max-width: 100%; margin: 5px 0 0; overflow: hidden; color: #8a95a8; font-size: 13px; text-overflow: ellipsis; white-space: nowrap; }
        .form-details { margin: 0 21px 18px; padding: 14px; border: 1px solid #dbeafe; border-radius: 14px; background: #f8fbff; }
        .form-details h3 { margin: 0 0 11px; color: #1877f2; font-size: 12px; letter-spacing: .08em; text-transform: uppercase; }
        .form-detail { display: flex; justify-content: space-between; gap: 12px; padding: 6px 0; border-top: 1px solid #e4efff; color: #667085; font-size: 12px; }
        .form-detail:first-of-type { border-top: 0; }
        .form-detail strong { color: #172033; font-size: 13px; font-weight: 650; text-align: right; word-break: break-word; }
        .details-actions { padding: 0 21px 19px; }
        .detail-action { display: flex; width: 100%; align-items: center; gap: 22px; padding: 12px 0; border: 0; color: #101828; background: transparent; font-size: 17px; text-align: left; }
        .detail-action svg { width: 25px; height: 25px; flex: 0 0 auto; color: #101828; }
        .detail-action:hover, .detail-action:hover svg { color: var(--blue); }
        .details-section { padding: 20px 24px; border-top: 1px solid var(--line); }
        .details-section h3 { display: flex; align-items: center; justify-content: space-between; margin: 0 0 17px; color: #101828; font-size: 19px; }
        .details-section h3 span { color: var(--blue); font-size: 14px; font-weight: 500; }
        .detail-card { display: flex; align-items: center; gap: 12px; color: #526078; font-size: 14px; }
        .detail-card + .detail-card { margin-top: 13px; }
        .detail-card-icon { display: grid; width: 36px; height: 36px; place-items: center; border-radius: 8px; color: var(--blue); background: var(--blue-soft); }
        .detail-card strong { display: block; margin-bottom: 2px; color: #172033; font-size: 15px; font-weight: 600; }
        .detail-card small { color: #8a95a8; font-size: 12px; }
        .no-shared { color: #8a95a8; font-size: 13px; }

        @media (max-width: 1180px) {
            .topbar { grid-template-columns: 330px minmax(0, 1fr) auto; }
            .workspace { grid-template-columns: 330px minmax(0, 1fr) 290px; }
            .workspace:not(.details-open) { grid-template-columns: 330px minmax(0, 1fr); }
            .main-nav { gap: 15px; }
            .top-actions { gap: 8px; padding-right: 14px; }
            .profile-name { font-size: 24px; }
        }

        @media (max-width: 900px) {
            .topbar { grid-template-columns: 300px minmax(0, 1fr) auto; }
            .workspace, .workspace.details-open { grid-template-columns: 300px minmax(0, 1fr); }
            .details {
                position: fixed;
                z-index: 20;
                top: 85px;
                right: 0;
                bottom: 0;
                width: min(350px, calc(100vw - 300px));
                box-shadow: -8px 0 28px rgba(15, 23, 42, .12);
            }
            .top-actions { padding-right: 13px; }
            .top-actions .top-action:not(.active), .profile-link { display: none; }
            .main-nav { gap: 10px; }
        }

        @media (max-width: 680px) {
            body { overflow: auto; }
            .messenger { min-height: 100vh; height: auto; grid-template-rows: 70px minmax(0, 1fr); }
            .topbar, .workspace, .workspace.details-open { grid-template-columns: 1fr; }
            .brand-area { padding: 0 20px; }
            .brand { width: 42px; height: 42px; font-size: 30px; }
            .main-nav { display: none; }
            .top-actions { position: absolute; top: 0; right: 10px; height: 70px; }
            .top-actions .top-action { width: 42px; height: 42px; }
            .sidebar { min-height: calc(100vh - 70px); border-right: 0; }
            .chat-column { position: fixed; z-index: 10; inset: 70px 0 0; display: none; border: 0; }
            .chat-column.open { display: flex; }
            .details { top: 70px; width: min(360px, 100vw); }
            .chat-head { padding: 12px 15px; }
            .chat-head::before { margin-right: 0; color: var(--blue); content: "‹"; cursor: pointer; font-size: 30px; line-height: 1; }
            .chat-name { font-size: 19px; }
            .chat-meta { font-size: 13px; }
            .chat-actions { gap: 0; }
            .chat-actions .header-button { display: none; }
            .messages { padding: 18px 13px 24px; }
            .message-content { max-width: 83%; }
            .message-bubble { font-size: 16px; }
            .composer { padding: 10px 12px 14px; }
            .composer-tools { display: none; }
            .sidebar-heading h1 { font-size: 29px; }
        }
    </style>
</head>
<body>
<div class="messenger">
    <header class="topbar">
        <div class="brand-area">
            <a class="brand" href="{{ route('admin.index') }}" aria-label="Admin home">A</a>
        </div>

        <nav class="main-nav" aria-label="Main navigation">
            <a class="nav-link" href="{{ route('admin.index') }}" title="Home" aria-label="Home">
                <svg width="31" height="31" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 10.8 8.5-7 8.5 7M5.5 9.5v10h5v-6h3v6h5v-10"></path></svg>
            </a>
            <a class="nav-link" href="#" title="People" aria-label="People">
                <svg width="31" height="31" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"></circle><path stroke-linecap="round" d="M3.5 18.5c.6-3 2.4-4.5 5.5-4.5s4.9 1.5 5.5 4.5M16.5 6.5a2.6 2.6 0 1 1 0 5.2M16 14.1c2.6.2 4 1.7 4.5 4"></path></svg>
            </a>
            <a class="nav-link" href="#" title="Videos" aria-label="Videos">
                <svg width="31" height="31" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="4.5" width="17" height="14" rx="2"></rect><path stroke-linecap="round" stroke-linejoin="round" d="m10 8 5 3.5-5 3.5V8Z"></path><path stroke-linecap="round" d="M8 21h8"></path></svg>
            </a>
            <a class="nav-link" href="#" title="Marketplace" aria-label="Marketplace">
                <svg width="31" height="31" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linejoin="round" d="M4 10v9.5h16V10M3 9.5l1.5-5h15l1.5 5c0 1.1-.9 2-2 2s-2-.9-2-2c0 1.1-.9 2-2 2s-2-.9-2-2c0 1.1-.9 2-2 2s-2-.9-2-2c0 1.1-.9 2-2 2s-2-.9-2-2Z"></path><path stroke-linecap="round" d="M8 19.5v-5h8v5"></path></svg>
            </a>
            <a class="nav-link" href="#" title="Groups" aria-label="Groups">
                <svg width="31" height="31" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="9" r="3"></circle><path stroke-linecap="round" d="M6.5 19c.5-3.2 2.3-4.8 5.5-4.8s5 1.6 5.5 4.8M5.5 9.5a2.2 2.2 0 1 1 0 4.4M18.5 9.5a2.2 2.2 0 1 1 0 4.4M3.5 19c.2-1.8 1-3 2.5-3.7M20.5 19c-.2-1.8-1-3-2.5-3.7"></path></svg>
            </a>
        </nav>

        <div class="top-actions">
            <button class="top-action active" type="button" title="Messenger" aria-label="Messenger">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" fill="currentColor" d="M12 3.5a8.5 8.5 0 0 0-8.5 8.2c0 2.5 1.2 4.7 3 6.2v3.1l3-1.7c.8.2 1.6.4 2.5.4a8.5 8.5 0 1 0 0-17Z"></path><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" d="m7.4 13 3-3 1.8 1.5 3.5-2.5-2.2 3.8-1.8-1.4L8.2 14Z"></path></svg>
            </button>
            <button class="top-action" type="button" title="Notifications" aria-label="Notifications">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4"></path></svg>
            </button>
            <a class="profile-link" href="{{ route('logout') }}" title="Log out">
                <span class="avatar profile-avatar tone-2">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
            </a>
        </div>
    </header>

    <div class="workspace">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-heading">
                    <h1>Chats</h1>
                    <div class="heading-actions">
                        <button class="round-button" type="button" title="New message" aria-label="New message">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 19h4l10.5-10.5a2.1 2.1 0 0 0-3-3L6 16v3ZM14.5 7.5l2 2"></path></svg>
                        </button>
                        <button class="round-button" type="button" title="More options" aria-label="More options">
                            <svg fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.8"></circle><circle cx="12" cy="12" r="1.8"></circle><circle cx="19" cy="12" r="1.8"></circle></svg>
                        </button>
                    </div>
                </div>
                <nav class="chat-tabs" aria-label="Chat filters">
                    <button class="chat-tab active" type="button" data-status="open">Open</button>
                    <button class="chat-tab" type="button" data-status="all">All</button>
                    <button class="chat-tab" type="button" data-status="closed">Closed</button>
                    <button class="chat-tab" type="button" data-status="settings">Settings</button>
                </nav>
                <div class="search-row">
                    <div class="search-box">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path stroke-linecap="round" d="m20 20-4-4"></path></svg>
                        <input id="search" type="search" placeholder="Search conversations..." autocomplete="off">
                    </div>
                    <button id="search-button" class="search-submit" type="button">Search</button>
                </div>
            </div>
            <div id="conversation-list" class="conversation-list" aria-live="polite"></div>
            <div id="settings-panel" class="settings-panel" hidden>
                <div class="settings-card">
                    <h2>Chat settings</h2>
                    <p>Conversations refresh automatically while this inbox is open. Use the filters above to switch between open, all, and closed chats.</p>
                </div>
            </div>
        </aside>

        <main id="chat" class="chat-column">
            <section id="chat-empty" class="chat-empty">
            </section>

            <section id="chat-panel" class="chat-panel" hidden>
                <header class="chat-head">
                    <span id="chat-avatar" class="avatar"></span>
                    <div class="chat-title">
                        <h2 id="chat-name" class="chat-name"></h2>
                        <div class="chat-meta"><span id="chat-meta-ip">IP not recorded</span><span aria-hidden="true">·</span><span id="chat-meta-started"></span></div>
                    </div>
                    <div class="chat-actions">
                        <button id="session-id-button" class="header-button" type="button" title="Copy session ID"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="8" y="8" width="11" height="11" rx="2"></rect><path stroke-linecap="round" d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2"></path></svg><span>Session ID</span></button>
                        <button id="destroy-button" class="header-button danger" type="button">Destroy</button>
                        <button id="block-button" class="header-button danger" type="button">Block Chat</button>
                        <button id="close-button" class="header-button danger" type="button">Close Chat</button>
                        <button id="details-toggle" class="chat-action" type="button" title="Show conversation details" aria-label="Show conversation details" aria-expanded="false"><svg width="23" height="23" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" d="M12 10.5v5M12 7.5h.01"></path></svg></button>
                    </div>
                </header>
                <div class="conversation-summary" aria-label="Conversation summary">
                    <div class="summary-item"><strong id="summary-messages">0</strong><span>Messages</span></div>
                    <div class="summary-item"><strong id="summary-ip">—</strong><span>IP Address</span></div>
                    <div class="summary-item"><strong id="summary-started">—</strong><span>Started</span></div>
                </div>
                <div id="error" class="error" role="alert"></div>
                <div id="messages" class="messages"></div>
                <div id="attachment-preview" class="attachment-preview" hidden></div>
                <div class="composer">
                    <button id="add-file-button" class="composer-plus" type="button" title="Attach a file" aria-label="Attach a file"><svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M12 5v14M5 12h14"></path></svg></button>
                    <div class="composer-box">
                        <textarea id="message-input" rows="1" placeholder="Type a message..." maxlength="5000"></textarea>
                        <div class="composer-tools">
                            <button class="composer-tool" type="button" title="Add emoji" aria-label="Add emoji"><svg width="23" height="23" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" d="M8.5 14.5a4.2 4.2 0 0 0 7 0M9 9.5h.01M15 9.5h.01"></path></svg></button>
                            <button id="image-button" class="composer-tool" type="button" title="Add image" aria-label="Add image"><svg width="23" height="23" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="4" width="17" height="16" rx="2"></rect><circle cx="8.5" cy="9" r="1.3"></circle><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 17 4.5-4 3 2.5 2-2 5.5 4.5"></path></svg></button>
                            <button id="file-button" class="composer-tool" type="button" title="Attach file" aria-label="Attach file"><svg width="23" height="23" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="m8.5 12.5 5.9-5.9a3 3 0 0 1 4.2 4.2l-7.5 7.5a4.5 4.5 0 0 1-6.4-6.4l7.2-7.2"></path></svg></button>
                        </div>
                    </div>
                    <button id="send-button" class="send" type="button" title="Send message" aria-label="Send message" disabled><svg width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4 4 16 8-16 8 3-8-3-8Zm3 8h13"></path></svg></button>
                    <input id="chat-file-input" type="file" hidden accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip">
                </div>
            </section>
        </main>

        <aside class="details">
            <div id="details-empty" class="details-empty"></div>
            <div id="details-content" class="details-content" hidden>
                <section class="profile-card">
                    <div class="profile-avatar-wrap"><span id="profile-avatar" class="avatar profile-avatar-large"></span><span id="profile-online" class="online-dot"></span></div>
                    <h2 id="profile-name" class="profile-name"></h2>
                    <div id="profile-status" class="profile-status"></div>
                    <p id="profile-email" class="profile-email"></p>
                </section>
                <section class="form-details" aria-label="Registration form details">
                    <h3>Form details</h3>
                    <div class="form-detail"><span>Form ID</span><strong id="form-id">—</strong></div>
                    <div class="form-detail"><span>IP address</span><strong id="form-ip">—</strong></div>
                    <div class="form-detail"><span>Phone</span><strong id="form-number">—</strong></div>
                    <div class="form-detail"><span>Game ID</span><strong id="form-game-id">—</strong></div>
                    <div class="form-detail"><span>Facebook</span><strong id="form-facebook">—</strong></div>
                    <div class="form-detail"><span>Mail</span><strong id="form-mail">—</strong></div>
                    <div class="form-detail"><span>Balance</span><strong id="form-balance">—</strong></div>
                </section>
                <section class="details-actions" aria-label="Conversation actions">
                    <button class="detail-action" type="button"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3"></circle><path stroke-linecap="round" d="M5.5 19c.5-3.2 2.7-5 6.5-5s6 1.8 6.5 5"></path></svg><span>View Profile</span></button>
                    <button class="detail-action" type="button"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="10.5" cy="10.5" r="6.5"></circle><path stroke-linecap="round" d="m16 16 4.5 4.5"></path></svg><span>Search in Conversation</span></button>
                    <button class="detail-action" type="button"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4"></path></svg><span>Mute Notifications</span></button>
                    <button id="detail-block-button" class="detail-action" type="button"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" d="m5.7 5.7 12.6 12.6"></path></svg><span id="detail-block-label">Block</span></button>
                    <button id="detail-delete-button" class="detail-action" type="button"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14M9 7V4h6v3m-8 0 1 13h8l1-13M10 11v5M14 11v5"></path></svg><span>Delete Chat</span></button>
                </section>
                <section class="details-section">
                    <h3>Conversation details <span>View all</span></h3>
                    <div class="detail-card"><span class="detail-card-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 3v-3h0A2.5 2.5 0 0 1 4 13.5v-7Z"></path></svg></span><span><strong id="detail-status">Open conversation</strong><small id="detail-created"></small></span></div>
                    <div class="detail-card"><span class="detail-card-icon"><svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9Z"></path><path stroke-linecap="round" d="m4.5 8 7.5 3 7.5-3M12 11v8"></path></svg></span><span><strong>Shared files</strong><small class="no-shared">No files shared yet</small></span></div>
                </section>
                <section class="details-section">
                    <h3>Shared Photos <span>See all</span></h3>
                    <div class="no-shared">Photos shared in this conversation will appear here.</div>
                </section>
            </div>
        </aside>
    </div>
</div>

<script>
    const state = {
        sessions: @json($sessions),
        activeId: @json(optional($selectedSession)->session_id),
        activeSession: @json($selectedSession),
        messages: @json($messages),
        status: @json($status),
        search: '',
        loading: false,
        detailsOpen: false,
        settingsOpen: false,
        pendingFile: null,
    };

    const urls = {
        index: @json(route('admin.chat')),
        sessions: @json(route('admin.chat.sessions')),
        messages: @json(route('admin.chat.messages', ['sessionId' => '__SESSION__'])),
        store: @json(route('admin.chat.messages.store', ['sessionId' => '__SESSION__'])),
        block: @json(route('admin.chat.block', ['sessionId' => '__SESSION__'])),
        close: @json(route('admin.chat.close', ['sessionId' => '__SESSION__'])),
        destroy: @json(route('admin.chat.destroy', ['sessionId' => '__SESSION__'])),
    };
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const list = document.getElementById('conversation-list');
    const chat = document.getElementById('chat');
    const empty = document.getElementById('chat-empty');
    const panel = document.getElementById('chat-panel');
    const messages = document.getElementById('messages');
    const input = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const errorBox = document.getElementById('error');
    const searchInput = document.getElementById('search');
    const searchButton = document.getElementById('search-button');
    const settingsPanel = document.getElementById('settings-panel');
    const sessionIdButton = document.getElementById('session-id-button');
    const destroyButton = document.getElementById('destroy-button');
    const blockButton = document.getElementById('block-button');
    const closeButton = document.getElementById('close-button');
    const detailBlockButton = document.getElementById('detail-block-button');
    const detailBlockLabel = document.getElementById('detail-block-label');
    const detailDeleteButton = document.getElementById('detail-delete-button');
    const addFileButton = document.getElementById('add-file-button');
    const imageButton = document.getElementById('image-button');
    const fileButton = document.getElementById('file-button');
    const fileInput = document.getElementById('chat-file-input');
    const attachmentPreview = document.getElementById('attachment-preview');
    const workspace = document.querySelector('.workspace');
    const detailsPanel = document.querySelector('.details');
    const detailsEmpty = document.getElementById('details-empty');
    const detailsContent = document.getElementById('details-content');
    const detailsToggle = document.getElementById('details-toggle');

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
    }[character]));

    function initials(name) {
        return String(name || 'Visitor').trim().split(/\s+/).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'V';
    }

    function avatarTone(name) {
        return `tone-${String(name || '').split('').reduce((sum, character) => sum + character.charCodeAt(0), 0) % 6}`;
    }

    function timeAgo(value) {
        if (!value) return '';
        const date = new Date(String(value).replace(' ', 'T'));
        if (Number.isNaN(date.getTime())) return '';
        const seconds = Math.max(0, Math.floor((Date.now() - date.getTime()) / 1000));
        if (seconds < 60) return 'now';
        if (seconds < 3600) return `${Math.floor(seconds / 60)}m`;
        if (seconds < 86400) return `${Math.floor(seconds / 3600)}h`;
        if (seconds < 2592000) return `${Math.floor(seconds / 86400)}d`;
        return date.toLocaleDateString([], { month: 'short', day: 'numeric' });
    }

    function fullTime(value) {
        if (!value) return '';
        const date = new Date(String(value).replace(' ', 'T'));
        return Number.isNaN(date.getTime()) ? '' : date.toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' });
    }

    function dateOnly(value) {
        if (!value) return '';
        const date = new Date(String(value).replace(' ', 'T'));
        return Number.isNaN(date.getTime()) ? '' : date.toLocaleDateString();
    }

    function filteredSessions() {
        const search = state.search.trim().toLowerCase();
        return state.sessions.filter(session => !search
            || String(session.form_full_name || session.visitor_name || '').toLowerCase().includes(search)
            || String(session.visitor_email || '').toLowerCase().includes(search)
            || String(session.ip_address || '').toLowerCase().includes(search));
    }

    function renderSessions() {
        if (state.settingsOpen) return;
        const visible = filteredSessions();
        if (!visible.length) {
            list.innerHTML = '<div class="empty-list">No conversations found.</div>';
            return;
        }

        list.innerHTML = visible.map(session => {
            const active = session.session_id === state.activeId;
            const unread = Number(session.unread_count) > 0;
            const preview = session.last_message_type === 'image'
                ? 'Photo'
                : (session.last_message_type === 'file' ? 'File attachment' : (session.last_message || 'No messages yet'));
            const displayName = session.form_full_name || session.visitor_name || 'Visitor';
            const presence = Number(session.is_viewing) ? 'Viewing' : (Number(session.visitor_online) ? 'Online' : 'Offline');
            const presenceClass = presence === 'Offline' ? ' offline' : '';
            const statusClass = session.status === 'closed' ? ' closed' : '';
            return `<button type="button" class="conversation${active ? ' active' : ''}${unread ? ' unread' : ''}" data-session-id="${escapeHtml(session.session_id)}">
                <span class="avatar-wrap"><span class="avatar ${avatarTone(displayName)}">${escapeHtml(initials(displayName))}</span>${Number(session.visitor_online) ? '<span class="online-dot"></span>' : ''}</span>
                <span class="person-copy"><span class="person-top"><span class="person-name">${escapeHtml(displayName)}</span><span class="status-badge${statusClass}">${escapeHtml(session.status || 'open')}</span><span class="time">${escapeHtml(timeAgo(session.last_activity || session.created_at))}</span></span><span class="preview">${escapeHtml(preview)}</span><span class="session-presence"><span class="presence-dot${presenceClass}"></span>${presence}</span></span>
                ${unread ? `<span class="unread-count">${Number(session.unread_count) > 99 ? '99+' : Number(session.unread_count)}</span>` : ''}
            </button>`;
        }).join('');

        list.querySelectorAll('[data-session-id]').forEach(button => {
            button.addEventListener('click', () => openSession(button.dataset.sessionId));
        });
    }

    function setError(message = '') {
        errorBox.textContent = message;
        errorBox.classList.toggle('show', Boolean(message));
    }

    function sessionFor(id = state.activeId) {
        return state.sessions.find(session => session.session_id === id)
            || (state.activeSession && state.activeSession.session_id === id ? state.activeSession : null);
    }

    function updateComposerState(session = sessionFor()) {
        const closed = !session || session.status === 'closed';
        input.disabled = closed;
        addFileButton.disabled = closed;
        imageButton.disabled = closed;
        fileButton.disabled = closed;
        input.placeholder = closed ? 'Chat is closed' : 'Type a message...';
        sendButton.disabled = closed || (!input.value.trim() && !state.pendingFile) || !state.activeId;
    }

    function renderAttachmentPreview() {
        if (!state.pendingFile) {
            attachmentPreview.hidden = true;
            attachmentPreview.innerHTML = '';
            return;
        }

        attachmentPreview.hidden = false;
        attachmentPreview.innerHTML = `<span title="${escapeHtml(state.pendingFile.name)}">📎 ${escapeHtml(state.pendingFile.name)}</span><button type="button" aria-label="Remove attachment">×</button>`;
        attachmentPreview.querySelector('button').addEventListener('click', () => {
            state.pendingFile = null;
            fileInput.value = '';
            renderAttachmentPreview();
            updateComposerState();
        });
    }

    function updateActiveSession(session) {
        state.activeSession = session;
        const index = state.sessions.findIndex(item => item.session_id === session.session_id);
        if (index !== -1) state.sessions[index] = session;
    }

    function renderChatHeader(session) {
        const online = Number(session.visitor_online);
        const avatar = document.getElementById('chat-avatar');
        const displayName = session.form_full_name || session.visitor_name || 'Visitor';
        avatar.className = `avatar ${avatarTone(displayName)}`;
        avatar.textContent = initials(displayName);
        document.getElementById('chat-name').textContent = displayName;
        document.getElementById('chat-meta-ip').textContent = session.ip_address || 'IP not recorded';
        document.getElementById('chat-meta-started').textContent = session.created_at ? `Started ${timeAgo(session.created_at)}` : 'Start date unavailable';
        document.getElementById('summary-messages').textContent = session.message_count ?? state.messages.length;
        document.getElementById('summary-ip').textContent = session.ip_address || 'Not recorded';
        document.getElementById('summary-started').textContent = session.created_at ? dateOnly(session.created_at) : '—';
        blockButton.textContent = Number(session.is_blocked) ? 'Unblock Chat' : 'Block Chat';
        detailBlockLabel.textContent = Number(session.is_blocked) ? 'Unblock' : 'Block';
        closeButton.textContent = session.status === 'closed' ? 'Reopen Chat' : 'Close Chat';
        updateComposerState(session);

        const profileAvatar = document.getElementById('profile-avatar');
        profileAvatar.className = `avatar profile-avatar-large ${avatarTone(displayName)}`;
        profileAvatar.textContent = initials(displayName);
        document.getElementById('profile-name').textContent = displayName;
        document.getElementById('profile-status').textContent = online ? 'Active now' : 'Offline';
        document.getElementById('profile-email').textContent = session.visitor_email || 'No email provided';
        document.getElementById('profile-online').style.display = online ? 'block' : 'none';
        document.getElementById('detail-status').textContent = `${session.status === 'closed' ? 'Closed' : 'Open'} conversation`;
        document.getElementById('detail-created').textContent = session.created_at ? `Started ${fullTime(session.created_at)}` : '';
        document.getElementById('form-id').textContent = session.form_id || 'Not matched';
        document.getElementById('form-ip').textContent = session.ip_address || 'Not recorded';
        document.getElementById('form-number').textContent = session.form_number || '—';
        document.getElementById('form-game-id').textContent = session.form_game_id || '—';
        document.getElementById('form-facebook').textContent = session.form_facebook_name || '—';
        document.getElementById('form-mail').textContent = session.form_mail || '—';
        document.getElementById('form-balance').textContent = session.form_balance ?? '—';
    }

    function renderMessages() {
        messages.innerHTML = '';
        document.getElementById('summary-messages').textContent = state.messages.length;
        if (!state.messages.length) {
            messages.innerHTML = '<div class="empty-list">No messages in this conversation yet.</div>';
            return;
        }

        const firstMessage = state.messages[0];
        const firstDate = firstMessage.created_at ? new Date(String(firstMessage.created_at).replace(' ', 'T')) : null;
        if (firstDate && !Number.isNaN(firstDate.getTime())) {
            const divider = document.createElement('div');
            divider.className = 'day-divider';
            divider.textContent = firstDate.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' });
            messages.appendChild(divider);
        }

        state.messages.forEach(message => {
            const row = document.createElement('div');
            row.className = `message-row ${message.sender || 'visitor'}`;
            if (message.sender === 'visitor') {
                const avatar = document.createElement('span');
                const visitorName = sessionFor()?.form_full_name || sessionFor()?.visitor_name;
                avatar.className = `message-avatar ${avatarTone(visitorName)}`;
                avatar.textContent = initials(visitorName);
                row.appendChild(avatar);
            }

            const content = document.createElement('div');
            content.className = 'message-content';
            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';
            if (message.message_type === 'image' && message.file_url) {
                const image = document.createElement('img');
                image.className = 'message-image';
                image.src = message.file_url;
                image.alt = message.file_name || 'Uploaded image';
                image.loading = 'lazy';
                bubble.appendChild(image);
                if (message.message) {
                    const caption = document.createElement('div');
                    caption.className = 'message-caption';
                    caption.textContent = message.message;
                    bubble.appendChild(caption);
                }
            } else if (message.message_type === 'file' && message.file_url) {
                const link = document.createElement('a');
                link.className = 'message-file';
                link.href = message.file_url;
                link.target = '_blank';
                link.rel = 'noopener';
                link.download = message.file_name || '';
                link.textContent = `📎 ${message.file_name || 'Download file'}`;
                bubble.appendChild(link);
                if (message.message) {
                    const caption = document.createElement('div');
                    caption.className = 'message-caption';
                    caption.textContent = message.message;
                    bubble.appendChild(caption);
                }
            } else {
                bubble.textContent = message.message || '';
            }
            const timestamp = document.createElement('div');
            timestamp.className = 'message-time';
            timestamp.textContent = fullTime(message.created_at);
            if (message.sender === 'agent') {
                const status = document.createElement('span');
                status.className = 'message-status';
                status.textContent = message.status === 'seen' ? 'Seen' : 'Sent';
                timestamp.appendChild(status);
            }
            content.appendChild(bubble);
            content.appendChild(timestamp);
            row.appendChild(content);
            messages.appendChild(row);
        });
        messages.scrollTop = messages.scrollHeight;
    }

    function setDetailsOpen(open) {
        state.detailsOpen = Boolean(open && state.activeId);
        workspace.classList.toggle('details-open', state.detailsOpen);
        detailsPanel.setAttribute('aria-hidden', state.detailsOpen ? 'false' : 'true');
        detailsEmpty.hidden = state.detailsOpen;
        detailsContent.hidden = !state.detailsOpen;
        detailsToggle.classList.toggle('active', state.detailsOpen);
        detailsToggle.setAttribute('aria-expanded', state.detailsOpen ? 'true' : 'false');
        detailsToggle.title = state.detailsOpen ? 'Hide conversation details' : 'Show conversation details';
        detailsToggle.setAttribute('aria-label', detailsToggle.title);
    }

    function showChat() {
        empty.hidden = true;
        panel.hidden = false;
        chat.classList.add('open');
    }

    function showSettings(show) {
        state.settingsOpen = show;
        list.hidden = show;
        settingsPanel.hidden = !show;
    }

    function setActiveTab(status) {
        document.querySelectorAll('.chat-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.status === status);
        });
    }

    function sessionsUrl() {
        const query = new URLSearchParams({ status: state.status });
        if (state.search.trim()) query.set('search', state.search.trim());
        return `${urls.sessions}?${query.toString()}`;
    }

    async function openSession(id) {
        const session = sessionFor(id);
        if (!session) return;
        state.activeId = id;
        state.activeSession = session;
        state.messages = [];
        state.pendingFile = null;
        fileInput.value = '';
        renderAttachmentPreview();
        renderSessions();
        renderChatHeader(session);
        showChat();
        setError();
        history.replaceState({}, '', `${urls.index}?session=${encodeURIComponent(id)}`);
        renderMessages();

        try {
            const response = await fetch(urls.messages.replace('__SESSION__', encodeURIComponent(id)), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!response.ok) throw new Error('Unable to load this conversation.');
            const data = await response.json();
            state.messages = data.messages || [];
            const refreshed = data.session || sessionFor(id);
            if (refreshed) {
                updateActiveSession(refreshed);
                renderChatHeader(refreshed);
            }
            renderSessions();
            renderMessages();
        } catch (error) {
            setError(error.message);
        }
    }

    async function refreshSessions() {
        if (state.settingsOpen) return;
        try {
            const response = await fetch(sessionsUrl(), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!response.ok) return;
            const data = await response.json();
            state.sessions = data.sessions || [];
            renderSessions();
            if (state.activeId && sessionFor()) renderChatHeader(sessionFor());
        } catch (_) { /* The next poll will retry. */ }
    }

    async function refreshMessages() {
        if (!state.activeId || state.loading) return;
        state.loading = true;
        try {
            const response = await fetch(urls.messages.replace('__SESSION__', encodeURIComponent(state.activeId)), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!response.ok) return;
            const data = await response.json();
            state.messages = data.messages || [];
            if (data.session) {
                updateActiveSession(data.session);
                renderChatHeader(data.session);
            }
            renderMessages();
        } catch (_) { /* Keep the current conversation visible during short failures. */ }
        finally { state.loading = false; }
    }

    async function sendMessage() {
        const message = input.value.trim();
        const file = state.pendingFile;
        if (!state.activeId || (!message && !file) || sessionFor()?.status === 'closed') return;
        sendButton.disabled = true;
        setError();
        try {
            const body = new FormData();
            if (message) body.append('message', message);
            if (file) body.append('file', file, file.name);

            const response = await fetch(urls.store.replace('__SESSION__', encodeURIComponent(state.activeId)), {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body,
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Message could not be sent.');
            input.value = '';
            state.pendingFile = null;
            fileInput.value = '';
            renderAttachmentPreview();
            state.messages.push(data.message);
            renderMessages();
            await refreshSessions();
        } catch (error) {
            setError(error.message);
        } finally {
            updateComposerState();
            input.focus();
        }
    }

    async function runSessionAction(url, method = 'POST') {
        if (!state.activeId) return;
        setError();
        try {
            const response = await fetch(url.replace('__SESSION__', encodeURIComponent(state.activeId)), {
                method,
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'The chat action could not be completed.');
            if (data.session) updateActiveSession(data.session);
            if (data.session) renderChatHeader(data.session);
            renderSessions();
            await refreshMessages();
            await refreshSessions();
        } catch (error) {
            setError(error.message);
        }
    }

    function clearActiveChat() {
        state.activeId = null;
        state.activeSession = null;
        state.messages = [];
        panel.hidden = true;
        empty.hidden = false;
        chat.classList.remove('open');
        setDetailsOpen(false);
        input.value = '';
        state.pendingFile = null;
        fileInput.value = '';
        renderAttachmentPreview();
        updateComposerState(null);
        history.replaceState({}, '', urls.index);
    }

    async function destroyActiveChat() {
        if (!state.activeId || !window.confirm('Destroy this chat permanently?')) return;
        const id = state.activeId;
        setError();
        try {
            const response = await fetch(urls.destroy.replace('__SESSION__', encodeURIComponent(id)), {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'The chat could not be destroyed.');
            state.sessions = state.sessions.filter(session => session.session_id !== id);
            clearActiveChat();
            renderSessions();
            await refreshSessions();
        } catch (error) {
            setError(error.message);
        }
    }

    function chooseFile(accept) {
        fileInput.accept = accept;
        fileInput.click();
    }

    addFileButton.addEventListener('click', () => chooseFile('image/*,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip'));
    imageButton.addEventListener('click', () => chooseFile('image/*'));
    fileButton.addEventListener('click', () => chooseFile('.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip'));
    fileInput.addEventListener('change', event => {
        const file = event.target.files[0];
        if (!file) return;
        if (file.size > 10 * 1024 * 1024) {
            fileInput.value = '';
            setError('Files must be 10 MB or smaller.');
            return;
        }
        setError();
        state.pendingFile = file;
        renderAttachmentPreview();
        updateComposerState();
    });

    let searchTimer;
    searchInput.addEventListener('input', event => {
        state.search = event.target.value;
        renderSessions();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(refreshSessions, 250);
    });
    searchInput.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            event.preventDefault();
            refreshSessions();
        }
    });
    searchButton.addEventListener('click', refreshSessions);
    document.querySelectorAll('.chat-tab').forEach(tab => tab.addEventListener('click', () => {
        const status = tab.dataset.status;
        setActiveTab(status);
        if (status === 'settings') {
            showSettings(true);
            return;
        }
        showSettings(false);
        state.status = status;
        refreshSessions();
    }));
    detailsToggle.addEventListener('click', () => setDetailsOpen(!state.detailsOpen));
    document.querySelector('.chat-head').addEventListener('click', event => {
        if (window.innerWidth <= 680 && event.target.closest('.chat-head') === event.currentTarget && !event.target.closest('button')) chat.classList.remove('open');
    });
    input.addEventListener('input', () => updateComposerState());
    input.addEventListener('keydown', event => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });
    sendButton.addEventListener('click', sendMessage);
    sessionIdButton.addEventListener('click', async () => {
        if (!state.activeId) return;
        try {
            await navigator.clipboard.writeText(state.activeId);
            const label = sessionIdButton.querySelector('span');
            label.textContent = 'Copied';
            setTimeout(() => { label.textContent = 'Session ID'; }, 1200);
        } catch (_) {
            setError('Unable to copy the session ID.');
        }
    });
    destroyButton.addEventListener('click', destroyActiveChat);
    blockButton.addEventListener('click', () => runSessionAction(urls.block));
    closeButton.addEventListener('click', () => runSessionAction(urls.close));
    detailBlockButton.addEventListener('click', () => runSessionAction(urls.block));
    detailDeleteButton.addEventListener('click', destroyActiveChat);

    setActiveTab(state.status);
    renderSessions();
    setDetailsOpen(false);
    if (state.activeId && sessionFor()) {
        renderChatHeader(sessionFor());
        showChat();
        renderMessages();
    }
    setInterval(refreshSessions, 10000);
    setInterval(refreshMessages, 5000);
</script>
</body>
</html>
