<?php
/**
 * chat.php - Dedicated full-page chat interface
 * Mobile-first, iMessage-inspired design.
 */
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover, interactive-widget=resizes-content">
    <title>AB Gaming</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Connect with our support team instantly through our dedicated chat portal.">
    <!-- Theme color adapts to light/dark mode for status bar -->
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)" id="theme-color-light">
    <meta name="theme-color" content="#000000" media="(prefers-color-scheme: dark)" id="theme-color-dark">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --ios-blue: #007aff;
            --ios-gray: #e9e9eb;
            --ios-gray-text: #8e8e93;
            --ios-bg: #ffffff;
            --ios-surface: #f2f2f7;
            --ios-border: #d1d1d6;
            --ios-text: #000000;
            --ios-bubble-visitor: var(--ios-blue);
            --ios-bubble-agent: var(--ios-gray);
            --ios-bubble-visitor-text: #ffffff;
            --ios-bubble-agent-text: #000000;
            --ios-header-bg: rgba(255,255,255,0.82);
            
            --safe-top: env(safe-area-inset-top, 0px);
            --safe-bottom: env(safe-area-inset-bottom, 0px);
        }

        [data-theme="dark"] {
            --ios-bg: #000000;
            --ios-surface: #1c1c1e;
            --ios-border: #38383a;
            --ios-text: #ffffff;
            --ios-gray: #262629;
            --ios-bubble-agent: #262629;
            --ios-bubble-agent-text: #ffffff;
            --ios-gray-text: #8e8e93;
            --ios-header-bg: rgba(0,0,0,0.82);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            height: 100%;
            /* dvh = dynamic viewport height: shrinks automatically when soft keyboard opens */
            height: 100dvh;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--ios-bg);
            color: var(--ios-text);
            display: flex;
            flex-direction: column;
            line-height: 1.4;
            /* -webkit-fill-available covers older Safari that doesn't support dvh */
            min-height: -webkit-fill-available;
        }

        /* ── Header ── */
        header {
            /* Uses CSS variable so dark mode is respected */
            background-color: var(--ios-header-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 0.5px solid var(--ios-border);
            padding-top: calc(var(--safe-top) + 12px);
            padding-bottom: 12px;
            padding-left: 16px;
            padding-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .agent-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
        }

        .agent-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a2a2a2, #7a7a7a);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .agent-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--ios-text);
        }

        .agent-status {
            font-size: 11px;
            color: var(--ios-gray-text);
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4cd964;
        }

        /* ── Messages Container ── */
        .chat-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            /* min-height:0 is CRITICAL — without it, flex children won't shrink below their content size */
            min-height: 0;
            overflow: hidden;
        }

        main {
            flex: 1 1 0;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            scroll-behavior: smooth;
            justify-content: flex-start;
        }

        /* ── Pre-chat ── */
        #prechat-screen {
            position: fixed;
            inset: 0;
            background: var(--ios-bg);
            z-index: 200;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            text-align: center;
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: var(--ios-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(0, 122, 255, 0.3);
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .welcome-desc {
            font-size: 16px;
            color: var(--ios-gray-text);
            margin-bottom: 32px;
            max-width: 280px;
        }

        .input-group {
            width: 100%;
            max-width: 320px;
            margin-bottom: 20px;
        }

        .ios-input {
            width: 100%;
            background: var(--ios-surface);
            border: none;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 17px;
            color: var(--ios-text);
            outline: none;
        }

        .ios-btn {
            width: 100%;
            max-width: 320px;
            background: var(--ios-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .ios-btn:active {
            opacity: 0.7;
        }

        /* ── Message Bubbles ── */
        .msg-row {
            display: flex;
            width: 100%;
            margin-bottom: 2px;
        }

        .msg-row.visitor {
            justify-content: flex-end;
        }

        .msg-row.agent {
            justify-content: flex-start;
        }

        .bubble {
            max-width: 75%;
            padding: 8px 14px;
            font-size: 16px;
            position: relative;
            line-height: 1.35;
        }

        .visitor .bubble {
            background-color: var(--ios-bubble-visitor);
            color: var(--ios-bubble-visitor-text);
            border-radius: 18px 18px 4px 18px;
        }

        .agent .bubble {
            background-color: var(--ios-bubble-agent);
            color: var(--ios-bubble-agent-text);
            border-radius: 18px 18px 18px 4px;
        }

        /* Grouping logic */
        .msg-row.first-in-group .bubble.visitor { border-radius: 18px 18px 4px 18px; }
        .msg-row.middle-in-group .bubble.visitor { border-radius: 18px 4px 4px 18px; }
        .msg-row.last-in-group .bubble.visitor  { border-radius: 18px 4px 18px 18px; }
        .msg-row.single-in-group .bubble.visitor { border-radius: 18px 18px 18px 18px; }
        
        .msg-row.first-in-group .bubble.agent { border-radius: 18px 18px 18px 4px; }
        .msg-row.middle-in-group .bubble.agent { border-radius: 4px 18px 18px 4px; }
        .msg-row.last-in-group .bubble.agent  { border-radius: 4px 18px 18px 18px; }
        .msg-row.single-in-group .bubble.agent { border-radius: 18px 18px 18px 18px; }

        .msg-row[data-sender-change="true"] {
            margin-top: 10px;
        }

        .bubble img {
            max-width: 220px;
            max-height: 260px;
            border-radius: 14px;
            display: block;
            cursor: zoom-in;
            object-fit: cover;
        }

        /* Time label shown below last bubble in a group */
        .msg-time {
            font-size: 11px;
            color: var(--ios-gray-text);
            margin-top: 3px;
            margin-bottom: 6px;
            padding: 0 4px;
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity 0.2s ease, transform 0.2s ease;
            pointer-events: none;
        }
        .msg-row.visitor + .msg-time { text-align: right; }
        .msg-row.agent  + .msg-time { text-align: left;  }
        .msg-time.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Tap on a bubble to reveal timestamp */
        .msg-row.show-time + .msg-time {
            opacity: 1;
            transform: translateY(0);
        }

        .day-sep {
            text-align: center;
            font-size: 11px;
            font-weight: 500;
            color: var(--ios-gray-text);
            margin: 18px 0 8px;
            letter-spacing: 0.3px;
        }

        /* ── Lightbox ── */
        #lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.92);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            cursor: zoom-out;
            animation: fadeIn 0.2s ease;
        }
        #lightbox.active { display: flex; }
        #lightbox img {
            max-width: 100%;
            max-height: 90dvh;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            pointer-events: none;
        }
        #lightbox-close {
            position: fixed;
            top: 16px;
            right: 16px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* ── Footer / Input ── */
        footer {
            flex-shrink: 0;
            padding: 8px 12px calc(var(--safe-bottom) + 8px);
            background-color: var(--ios-bg);
            border-top: 0.5px solid var(--ios-border);
            display: flex;
            align-items: flex-end;
            gap: 8px;
            /* Always visible at bottom */
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        .input-container {
            flex: 1;
            background: var(--ios-surface);
            border: 0.5px solid var(--ios-border);
            border-radius: 20px;
            display: flex;
            align-items: flex-end;
            padding: 4px 12px;
            min-height: 38px;
        }

        #message-input {
            flex: 1;
            background: none;
            border: none;
            padding: 6px 0;
            font-size: 16px;
            font-family: inherit;
            color: var(--ios-text);
            max-height: 120px;
            overflow-y: auto;
            outline: none;
            resize: none;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ios-blue);
            background: none;
            border: none;
            cursor: pointer;
            flex-shrink: 0;
        }

        .send-btn {
            width: 32px;
            height: 32px;
            background-color: var(--ios-blue);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.1s;
        }

        .send-btn.disabled {
            opacity: 0.3;
            cursor: default;
        }

        .send-btn:active:not(.disabled) {
            transform: scale(0.9);
        }

        .bubble.emoji-only {
            background: none !important;
            font-size: 44px;
            padding: 0;
            line-height: 1;
        }

        /* ── Animations ── */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .msg-row {
            animation: slideIn 0.2s ease-out forwards;
        }

        /* ── Media Queries ── */
        @media (min-width: 768px) {
            body {
                background-color: #f0f0f2;
                align-items: center;
                justify-content: center;
            }
            .chat-wrapper {
                width: 400px;
                height: min(800px, 90vh);
                flex: none;
                background-color: var(--ios-bg);
                box-shadow: 0 20px 50px rgba(0,0,0,0.15);
                border-radius: 20px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                position: relative;
            }
            .chat-wrapper footer {
                position: relative;
                bottom: auto;
            }
            #prechat-screen {
                position: absolute;
            }
        }

        /* Image Preview Overlay */
        #preview-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.1);
            z-index: 50;
            display: none;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 100px;
            padding-left: 20px;
        }
        .preview-card {
            background: var(--ios-surface);
            padding: 8px;
            border-radius: 12px;
            width: fit-content;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
        }
        .preview-card img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
        }
        .remove-preview {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff3b30;
            color: white;
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
        }

        .system-msg {
            text-align: center;
            font-size: 13px;
            color: var(--ios-gray-text);
            margin: 10px 0;
            padding: 0 40px;
        }
    </style>
</head>
<body>
    <div class="chat-wrapper">
        <!-- Pre-chat Screen -->
        <div id="prechat-screen">
            <div class="welcome-icon">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2 22l5-1.338c1.47.851 3.179 1.338 5 1.338 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.476 0-2.886-.313-4.156-.885l-2.731.731.731-2.731A7.94 7.94 0 014 12c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z"/>
                </svg>
            </div>
            <h1 class="welcome-title">AB Gaming</h1>
            <p class="welcome-desc">Connect with our support team. Tell us your name to get started.</p>
            
            <div class="input-group">
                <input type="text" id="visitor-name-input" class="ios-input" placeholder="Your Email" autofocus>
            </div>
            <button id="start-chat-btn" class="ios-btn">Continue</button>
        </div>

        <header>
            <div class="agent-info">
                <div class="agent-avatar" id="agent-avatar-icon">AB</div>
                <div class="agent-name" id="agent-display-name">AB Gaming</div>
                <div class="agent-status">
                    <span class="status-dot"></span>
                    Online
                </div>
            </div>
        </header>

        <main id="messages-container">
            <!-- Messages will be injected here -->
        </main>

        <div id="preview-overlay">
            <div class="preview-card">
                <button class="remove-preview">&times;</button>
                <img id="image-preview" src="" alt="Selected Image">
            </div>
        </div>

        <footer>
            <button class="action-btn" id="attach-btn">
                <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
            <input type="file" id="file-input" accept="image/*" style="display: none">
            
            <div class="input-container">
                <textarea id="message-input" placeholder="iMessage" rows="1"></textarea>
            </div>
            
            <button class="send-btn disabled" id="send-btn" title="Send">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </footer>
    </div>

    <!-- Lightbox -->
    <div id="lightbox">
        <button id="lightbox-close" aria-label="Close">&times;</button>
        <img id="lightbox-img" src="" alt="Full size">
    </div>

    <script>
        // ── Constants & State ──
        const API = 'api/chat.php';
        let sessionId = localStorage.getItem('wc_session_id') || null;
        let visitorName = localStorage.getItem('wc_visitor_name') || null;
        let lastMsgId = 0;
        let isPolling = false;
        let uploadFile = null;

        // ── DOM Elements ──
        const prechatScreen = document.getElementById('prechat-screen');
        const startChatBtn = document.getElementById('start-chat-btn');
        const visitorNameInput = document.getElementById('visitor-name-input');
        const messagesContainer = document.getElementById('messages-container');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const attachBtn = document.getElementById('attach-btn');
        const fileInput = document.getElementById('file-input');
        const previewOverlay = document.getElementById('preview-overlay');
        const imagePreview = document.getElementById('image-preview');
        const removePreview = document.querySelector('.remove-preview');

        // ── Initialization ──
        function init() {
            if (sessionId) {
                prechatScreen.style.display = 'none';
                startPolling();
            }

            // Fingerprint for session consistency
            if (!localStorage.getItem('wc_fp')) {
                const fp = Math.random().toString(36).substring(2, 15) + Date.now().toString(36);
                localStorage.setItem('wc_fp', fp);
            }
        }

        // ── API Helpers ──
        async function apiFetch(action, data = {}) {
            const body = { action, ...data };
            if (sessionId) body.session_id = sessionId;
            
            try {
                const response = await fetch(API, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-Session-ID': sessionId || ''
                    },
                    body: JSON.stringify(body)
                });
                return await response.json();
            } catch (error) {
                console.error('API Error:', error);
                return { error: 'Connection failed' };
            }
        }

        async function apiUpload(file) {
            const formData = new FormData();
            formData.append('action', 'send_message');
            formData.append('image', file);
            if (sessionId) formData.append('session_id', sessionId);

            try {
                const response = await fetch(API, {
                    method: 'POST',
                    body: formData
                });
                return await response.json();
            } catch (error) {
                console.error('Upload Error:', error);
                return { error: 'Upload failed' };
            }
        }

        // ── Actions ──
        async function startChat() {
            const name = visitorNameInput.value.trim();
            if (!name) return;

            const fp = localStorage.getItem('wc_fp');
            const res = await apiFetch('start_session', { name, fp });

            if (res.session_id) {
                sessionId = res.session_id;
                visitorName = name;
                localStorage.setItem('wc_session_id', sessionId);
                localStorage.setItem('wc_visitor_name', visitorName);
                
                prechatScreen.style.opacity = '0';
                setTimeout(() => {
                    prechatScreen.style.display = 'none';
                    startPolling();
                }, 300);
            }
        }

        async function sendMessage() {
            const text = messageInput.value.trim();
            if (!text && !uploadFile) return;

            let res;
            if (uploadFile) {
                res = await apiUpload(uploadFile);
                clearPreview();
            } else {
                res = await apiFetch('send_message', { message: text });
                messageInput.value = '';
                messageInput.style.height = 'auto';
            }

            if (res.success) {
                playSound('send');
                updateSendButton();
                pollMessages();
            }
        }

        function clearPreview() {
            uploadFile = null;
            fileInput.value = '';
            previewOverlay.style.display = 'none';
            updateSendButton();
        }

        // ── Polling & UI ──
        let audioCtx = null;
        function getAudioCtx() {
            if (!audioCtx) {
                try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch (e) { }
            }
            return audioCtx;
        }

        function playSound(type) {
            const ctx = getAudioCtx();
            if (!ctx) return;
            if (type === 'send') {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.type = 'sine';
                osc.frequency.setValueAtTime(520, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(700, ctx.currentTime + 0.08);
                gain.gain.setValueAtTime(0.18, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.18);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.18);
            } else {
                [[440, 0], [660, 0.12]].forEach(([freq, delay]) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime + delay);
                    gain.gain.setValueAtTime(0, ctx.currentTime + delay);
                    gain.gain.linearRampToValueAtTime(0.2, ctx.currentTime + delay + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + delay + 0.28);
                    osc.start(ctx.currentTime + delay);
                    osc.stop(ctx.currentTime + delay + 0.3);
                });
            }
        }

        function startPolling() {
            pollMessages(true); // First poll
            setInterval(pollMessages, 3000);
            setInterval(sendHeartbeat, 5000);
            
            // Unlock audio on first click
            document.body.addEventListener('click', () => getAudioCtx(), { once: true });
        }

        async function sendHeartbeat() {
            if (!sessionId) return;
            apiFetch('heartbeat', { is_viewing: 1 });
        }

        async function pollMessages(isFirst = false) {
            if (!sessionId || isPolling) return;
            isPolling = true;

            const res = await apiFetch('get_messages', { since: lastMsgId });
            isPolling = false;

            if (res.messages && res.messages.length > 0) {
                const newMessages = res.messages.filter(m => parseInt(m.id) > lastMsgId);
                
                if (newMessages.length > 0) {
                    // Batch all new messages then render as a group
                    renderMessages(newMessages, isFirst);
                    lastMsgId = Math.max(...newMessages.map(m => parseInt(m.id)));
                    
                    if (!isFirst) {
                        const hasAgentMsg = newMessages.some(m => m.sender === 'agent');
                        if (hasAgentMsg) playSound('receive');
                    }
                }
            }
            
            if (res.agent) {
                updateAgentStatus(res.agent);
            }
        }

        function updateAgentStatus(agent) {
            const statusEl = document.querySelector('.agent-status');
            const dotEl = document.querySelector('.status-dot');
            
            if (agent.online) {
                dotEl.style.background = '#4cd964';
                statusEl.innerHTML = '<span class="status-dot"></span> Online';
            } else {
                dotEl.style.background = '#8e8e93';
                statusEl.innerHTML = '<span class="status-dot" style="background: #8e8e93"></span> Offline';
            }
        }

        function isEmojiOnly(text) {
            if (!text) return false;
            const emojiRegex = /^(\u00a9|\u00ae|[\u2000-\u3300]|\ud83c[\ud000-\udfff]|\ud83d[\ud000-\udfff]|\ud83e[\ud000-\udfff])+$/;
            const stripped = text.replace(/\s/g, '');
            return emojiRegex.test(stripped) && stripped.length <= 6;
        }

        function formatTime(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        }

        function formatDaySep(dateStr) {
            const d = new Date(dateStr);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);
            if (d.toDateString() === today.toDateString()) return 'Today';
            if (d.toDateString() === yesterday.toDateString()) return 'Yesterday';
            return d.toLocaleDateString([], { weekday: 'long', month: 'short', day: 'numeric' });
        }

        function openLightbox(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.add('active');
        }

        function renderMessages(history, isFirst = false) {
            // Near-bottom check BEFORE adding new nodes
            const nearBottom = messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight - 120;
            
            let lastSender = null;
            let lastDate = null;

            // Find previous last row's sender to continue grouping
            const existingRows = messagesContainer.querySelectorAll('.msg-row');
            if (existingRows.length > 0) {
                const last = existingRows[existingRows.length - 1];
                lastSender = last.classList.contains('visitor') ? 'visitor' : (last.classList.contains('agent') ? 'agent' : 'system');
            }
            // Find last date separator
            const existingSeps = messagesContainer.querySelectorAll('.day-sep');
            if (existingSeps.length > 0) {
                lastDate = existingSeps[existingSeps.length - 1].dataset.date || null;
            }

            history.forEach((msg, idx) => {
                const msgDate = new Date(msg.created_at).toDateString();
                if (lastDate !== msgDate) {
                    const sep = document.createElement('div');
                    sep.className = 'day-sep';
                    sep.dataset.date = msgDate;
                    sep.textContent = formatDaySep(msg.created_at);
                    messagesContainer.appendChild(sep);
                    lastDate = msgDate;
                }

                const senderChanged = lastSender !== null && lastSender !== msg.sender;
                const row = document.createElement('div');
                row.className = `msg-row ${msg.sender}`;
                row.dataset.sender = msg.sender;
                row.dataset.time = msg.created_at;
                if (senderChanged) row.setAttribute('data-sender-change', 'true');

                if (msg.sender === 'system') {
                    row.innerHTML = `<div class="system-msg">${msg.message}</div>`;
                } else {
                    let content = '';
                    let extraClass = '';
                    if (msg.message_type === 'image') {
                        const escapedSrc = msg.file_path.replace(/'/g, "\\'");
                        content = `<img src="${msg.file_path}" alt="Image" onclick="openLightbox('${escapedSrc}')">`;
                    } else {
                        if (isEmojiOnly(msg.message)) extraClass = ' emoji-only';
                        content = formatMessage(msg.message);
                    }
                    row.innerHTML = `<div class="bubble${extraClass}">${content}</div>`;

                    // Tap bubble to show/hide time
                    row.addEventListener('click', () => {
                        row.classList.toggle('show-time');
                    });
                }

                messagesContainer.appendChild(row);
                lastSender = msg.sender;
            });

            applyGroupingStyles();
            injectTimeLabels();

            // Always scroll on first load; otherwise only if near bottom
            if (isFirst || nearBottom) {
                requestAnimationFrame(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
            }
        }

        function formatMessage(text) {
            if (!text) return '';
            return text.replace(/\n/g, '<br>');
        }

        function applyGroupingStyles() {
            const rows = Array.from(document.querySelectorAll('.msg-row')).filter(r => !r.querySelector('.system-msg'));
            rows.forEach((row, i) => {
                const prev = rows[i - 1];
                const next = rows[i + 1];
                
                const sender = row.dataset.sender || (row.classList.contains('visitor') ? 'visitor' : 'agent');
                const prevSender = prev ? (prev.dataset.sender || (prev.classList.contains('visitor') ? 'visitor' : 'agent')) : null;
                const nextSender = next ? (next.dataset.sender || (next.classList.contains('visitor') ? 'visitor' : 'agent')) : null;

                row.classList.remove('first-in-group', 'middle-in-group', 'last-in-group', 'single-in-group');

                if (prevSender !== sender && nextSender !== sender) {
                    row.classList.add('single-in-group');
                } else if (prevSender !== sender && nextSender === sender) {
                    row.classList.add('first-in-group');
                } else if (prevSender === sender && nextSender === sender) {
                    row.classList.add('middle-in-group');
                } else if (prevSender === sender && nextSender !== sender) {
                    row.classList.add('last-in-group');
                }
            });
        }

        function injectTimeLabels() {
            // Remove old time labels first
            document.querySelectorAll('.msg-time').forEach(el => el.remove());

            const rows = Array.from(document.querySelectorAll('.msg-row')).filter(r => !r.querySelector('.system-msg'));
            rows.forEach((row, i) => {
                const next = rows[i + 1];
                const sender = row.dataset.sender;
                const nextSender = next ? next.dataset.sender : null;
                // Insert a time label after the last message in a group
                if (sender !== nextSender || !next) {
                    const timeEl = document.createElement('div');
                    timeEl.className = 'msg-time';
                    timeEl.textContent = formatTime(row.dataset.time);
                    row.after(timeEl);
                    // Show time when bubble is tapped
                    row.addEventListener('click', () => {
                        timeEl.classList.toggle('visible');
                    }, { once: false });
                }
            });
        }

        function updateSendButton() {
            const hasContent = messageInput.value.trim().length > 0 || uploadFile !== null;
            sendBtn.classList.toggle('disabled', !hasContent);
        }

        // ── Event Listeners ──
        startChatBtn.addEventListener('click', startChat);
        visitorNameInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') startChat();
        });

        messageInput.addEventListener('input', () => {
            messageInput.style.height = 'auto';
            messageInput.style.height = messageInput.scrollHeight + 'px';
            updateSendButton();
        });

        sendBtn.addEventListener('click', () => {
            if (!sendBtn.classList.contains('disabled')) sendMessage();
        });

        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (!sendBtn.classList.contains('disabled')) sendMessage();
            }
        });

        attachBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                uploadFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    previewOverlay.style.display = 'flex';
                    updateSendButton();
                };
                reader.readAsDataURL(file);
            }
        });

        removePreview.addEventListener('click', clearPreview);

        // Lightbox close
        const lightbox = document.getElementById('lightbox');
        document.getElementById('lightbox-close').addEventListener('click', () => lightbox.classList.remove('active'));
        lightbox.addEventListener('click', (e) => { if (e.target === lightbox) lightbox.classList.remove('active'); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') lightbox.classList.remove('active'); });

        // ── Dark mode detection + status bar theme-color sync ──
        const mq = window.matchMedia('(prefers-color-scheme: dark)');
        function applyTheme(dark) {
            document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
            // Swap theme-color so iOS status bar matches the app background
            const lightMeta = document.getElementById('theme-color-light');
            const darkMeta  = document.getElementById('theme-color-dark');
            if (lightMeta) lightMeta.setAttribute('media', dark ? 'not all' : '(prefers-color-scheme: light)');
            if (darkMeta)  darkMeta.setAttribute('media',  dark ? '(prefers-color-scheme: dark)' : 'not all');
        }
        applyTheme(mq.matches);
        mq.addEventListener('change', e => applyTheme(e.matches));

        init();
    </script>
</body>
</html>
