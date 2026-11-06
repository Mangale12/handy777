/**
 * WebChat Widget — embeddable chat plugin
 * Usage: <script src="/webchat/widget/webchat.js" defer></script>
 */
(function () {
  'use strict';

  // ── Configuration ──────────────────────────────────────────────────────────
  const BASE_URL = (function () {
    const scripts = document.querySelectorAll('script[src*="webchat.js"]');
    const src = scripts.length ? scripts[scripts.length - 1].src : '';
    return src ? src.replace(/\/widget\/webchat\.js.*/, '') : window.location.origin + '/webchat';
  })();
  const API = BASE_URL + '/api/chat.php';
  const POLL_INTERVAL = 2000;

  // ── State ──────────────────────────────────────────────────────────────────
  let sessionId = localStorage.getItem('wc_session_id') || null;
  let visitorName = localStorage.getItem('wc_visitor_name') || null;
  let lastMsgId = 0;
  let pollTimer = null;
  let heartbeatTimer = null;
  let isOpen = false;
  let isFocused = true;
  let uploadPreview = null;
  let audioCtx = null;
  let soundEnabled = true;
  let firstMsgId = null;
  let hasMoreMessages = true;
  let isLoadingMore = false;
  const MSG_LIMIT = 20;

  // ── Heartbeat ─────────────────────────────────────────────────────────────
  function startHeartbeat() {
    if (heartbeatTimer) return;
    sendHeartbeat();
    heartbeatTimer = setInterval(sendHeartbeat, 5000);
  }

  function sendHeartbeat() {
    if (!sessionId) return;
    apiFetch('heartbeat', {
      is_viewing: (isOpen && isFocused) ? 1 : 0
    });
  }

  // Window focus tracking
  window.addEventListener('focus', () => { isFocused = true; sendHeartbeat(); });
  window.addEventListener('blur', () => { isFocused = false; sendHeartbeat(); });

  // Handle tab/window closure
  window.addEventListener('beforeunload', () => {
    if (!sessionId) return;
    const data = JSON.stringify({ action: 'heartbeat', session_id: sessionId, is_leaving: 1 });
    const blob = new Blob([data], { type: 'application/json' });
    navigator.sendBeacon(`${API}?action=heartbeat`, blob);
  });

  // ── Web Audio — Sound Engine ──────────────────────────────────────────────
  function getAudioCtx() {
    if (!audioCtx) {
      try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch (e) { }
    }
    return audioCtx;
  }

  function playSend() {
    if (!soundEnabled) return;
    try {
      const ctx = getAudioCtx();
      if (!ctx) return;
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
    } catch (e) { }
  }

  function playReceive() {
    if (!soundEnabled) return;
    try {
      const ctx = getAudioCtx();
      if (!ctx) return;
      // Two-tone chime: low then high
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
    } catch (e) { }
  }

  // ── Browser Fingerprint ─────────────────────────────────────────────────
  function getFingerprint() {
    const nav = navigator;
    const raw = [
      nav.userAgent, nav.language, screen.width, screen.height,
      screen.colorDepth, new Date().getTimezoneOffset(),
      nav.hardwareConcurrency, nav.platform
    ].join('|');
    let hash = 0;
    for (let i = 0; i < raw.length; i++) {
      hash = ((hash << 5) - hash + raw.charCodeAt(i)) | 0;
    }
    let stored = localStorage.getItem('wc_fp');
    if (!stored) {
      stored = Math.abs(hash).toString(16) + Date.now().toString(36);
      localStorage.setItem('wc_fp', stored);
    }
    return stored;
  }

  // ── CSS Injection ──────────────────────────────────────────────────────────
  function injectStyles() {
    const css = `
      :root {
        --wc-primary:      #6366f1;
        --wc-primary-dark: #4f46e5;
        --wc-bg:           #0f172a;
        --wc-surface:      #1e293b;
        --wc-surface2:     #273549;
        --wc-border:       #334155;
        --wc-text:         #f1f5f9;
        --wc-text-muted:   #94a3b8;
        --wc-shadow:       0 20px 60px rgba(0,0,0,0.55);
        --wc-radius:       20px;
      }

      body.wc-customized {
        --wc-primary:      var(--pref-wc-primary, #6366f1);
        --wc-primary-dark: var(--pref-wc-primary-dark, #4f46e5);
        --wc-bg:           var(--pref-wc-bg, #0f172a);
        --wc-surface:      var(--pref-wc-surface, #1e293b);
        --wc-surface2:     var(--pref-wc-surface2, #273549);
        --wc-surface3:     var(--pref-wc-surface3, #273549);
        --wc-text:         var(--pref-wc-text, #f1f5f9);
        --wc-text-muted:   var(--pref-wc-text-muted, #94a3b8);
      }

      #wc-wrapper * {
        box-sizing: border-box;
        margin: 0; 
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
      }

      #wc-wrapper {
        position: fixed;
        bottom: 28px; right: 28px;
        z-index: 2147483647;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 14px;
      }

      /* ── Toggle button ── */
      #wc-toggle {
        width: 60px; height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--wc-primary), var(--wc-primary-dark));
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 32px rgba(99,102,241,0.45);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative; overflow: visible;
      }
      #wc-toggle:hover { transform: scale(1.08); box-shadow: 0 12px 40px rgba(99,102,241,0.6); }
      #wc-toggle svg { transition: opacity 0.25s, transform 0.25s; }
      #wc-toggle .wc-icon-chat  { position: absolute; }
      #wc-toggle .wc-icon-close { position: absolute; opacity: 0; transform: rotate(-90deg); }
      #wc-wrapper.wc-open #wc-toggle .wc-icon-chat  { opacity: 0; transform: rotate(90deg); }
      #wc-wrapper.wc-open #wc-toggle .wc-icon-close { opacity: 1; transform: rotate(0deg); }

      /* ── Unread badge ── */
      #wc-badge {
        position: absolute; top: -4px; right: -4px;
        background: #ef4444; color: #fff;
        border-radius: 50%; width: 20px; height: 20px;
        font-size: 11px; font-weight: 700;
        display: none; align-items: center; justify-content: center;
        border: 2px solid #fff; z-index: 1;
        animation: wc-badge-pop 0.3s cubic-bezier(0.34,1.56,0.64,1);
      }
      #wc-badge.visible { display: flex; }
      @keyframes wc-badge-pop { from { transform: scale(0); } to { transform: scale(1); } }

      /* ── Chat window ── */
      #wc-window {
        width: 360px; height: 530px;
        border-radius: var(--wc-radius);
        background: var(--wc-bg);
        border: 1px solid var(--wc-border);
        box-shadow: var(--wc-shadow);
        display: flex; flex-direction: column;
        overflow: hidden;
        transform: scale(0.88) translateY(24px);
        opacity: 0; pointer-events: none;
        transform-origin: bottom right;
        transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
      }
      #wc-wrapper.wc-open #wc-window {
        transform: scale(1) translateY(0);
        opacity: 1; pointer-events: all;
      }

      /* ── Header ── */
      #wc-header {
        background: linear-gradient(135deg, var(--wc-primary), var(--wc-primary-dark));
        padding: 16px 20px;          /* Increased padding for better appearance */
        display: flex; align-items: center; gap: 12px;
        flex-shrink: 0;
        position: relative;
      }
      .wc-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 18px; font-weight: 700; color: #fff;
      }
      .wc-header-info { flex: 1; min-width: 0; }
      .wc-header-name   { font-size: 14px; font-weight: 700; color: #fff; }
      .wc-header-status {
        font-size: 11px; color: rgba(255,255,255,0.75);
        display: flex; align-items: center; gap: 5px; margin-top: 1px;
      }
      .wc-status-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #4ade80; display: inline-block;
        animation: wc-pulse 2s infinite;
      }
      @keyframes wc-pulse { 0%,100%{opacity:1;} 50%{opacity:0.35;} }

      /* Sound toggle button in header */
      #wc-sound-btn {
        background: rgba(255,255,255,0.15);
        border: none; border-radius: 8px;
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #fff; flex-shrink: 0;
        transition: background 0.2s;
      }
      #wc-sound-btn:hover { background: rgba(255,255,255,0.25); }
      #wc-sound-btn.muted { opacity: 0.5; }

      /* ── Pre-chat form ── */
      #wc-prechat {
        flex: 1; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 28px 22px; gap: 14px;
      }
      #wc-prechat h3 { color: var(--wc-text); font-size: 17px; font-weight: 700; text-align: center; }
      #wc-prechat p  { color: var(--wc-text-muted); font-size: 13px; text-align: center; line-height: 1.55; }
      .wc-input-group { width: 100%; display: flex; flex-direction: column; gap: 5px; }
      .wc-input-group label { font-size: 11px; color: var(--wc-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
      .wc-input {
        width: 100%;
        background: var(--wc-surface); border: 1.5px solid var(--wc-border);
        border-radius: 10px; padding: 10px 13px;
        color: var(--wc-text); font-size: 14px; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
      }
      .wc-input:focus {
        border-color: var(--wc-primary);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
      }
      .wc-btn {
        width: 100%; padding: 11px;
        background: linear-gradient(135deg, var(--wc-primary), var(--wc-primary-dark));
        color: #fff; border: none; border-radius: 10px;
        font-size: 14px; font-weight: 600;
        cursor: pointer; transition: opacity 0.2s, transform 0.1s;
        box-shadow: 0 4px 14px rgba(99,102,241,0.35);
      }
      .wc-btn:hover  { opacity: 0.9; }
      .wc-btn:active { transform: scale(0.98); }

      /* ── Messages area ── */
      #wc-messages {
        flex: 1; overflow-y: auto;
        padding: 18px 16px;          /* Increased padding for a more spacious feel */
        display: none; flex-direction: column; gap: 10px; /* Increased gap between messages */
      }
      #wc-messages::-webkit-scrollbar { width: 4px; }
      #wc-messages::-webkit-scrollbar-track { background: transparent; }
      #wc-messages::-webkit-scrollbar-thumb { background: var(--wc-border); border-radius: 4px; }

      /* ── Message row — KEY FIX:
         The wrapper div must be constrained so .wc-bubble's max-width
         is computed against the chat window width, not an unconstrained parent. ── */
      .wc-msg-row {
        display: flex; gap: 10px; align-items: flex-end;
        width: 100%;                /* ← ensures children can use % widths */
      }
      .wc-msg-row.visitor { flex-direction: row-reverse; }

      .wc-msg-avatar-sm {
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--wc-surface2);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        font-size: 10px; font-weight: 700; color: var(--wc-text-muted);
      }
      .wc-msg-avatar-sm.wc-av-visitor {
        background: linear-gradient(135deg, var(--wc-primary), var(--wc-primary-dark));
        color: #fff;
      }

      /* The column wrapper for bubble + timestamp */
      .wc-msg-col {
        display: flex; flex-direction: column;
        max-width: 82%;            /* Changed to percentage for better responsive balance */
        min-width: 0;
      }
      .wc-msg-row.visitor .wc-msg-col { align-items: flex-end; }
      .wc-msg-row.agent   .wc-msg-col { align-items: flex-start; }

      /* The bubble itself */
      .wc-bubble {
        display: inline-block;      /* shrinks to content width */
        max-width: 100%;            /* won't exceed the .wc-msg-col */
        padding: 10px 15px;         /* Standardized padding to match admin dashboard */
        border-radius: 16px;
        font-size: 13.5px; line-height: 1.55;
        word-break: break-word;
        white-space: pre-wrap;      /* preserves intentional newlines */
        animation: wc-msg-in 0.2s ease;
      }
      @keyframes wc-msg-in {
        from { opacity:0; transform: translateY(6px) scale(0.97); }
        to   { opacity:1; transform: translateY(0)  scale(1); }
      }
      .wc-bubble.visitor {
        background: var(--wc-primary);
        color: #fff;
        border-bottom-right-radius: 4px;
      }
      .wc-bubble.agent {
        background: var(--wc-surface2);
        color: var(--wc-text);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--wc-border);
      }
      .wc-bubble img {
        max-width: 200px; max-height: 200px;
        width: auto; height: auto;
        border-radius: 10px; cursor: pointer;
        display: block; object-fit: cover;
      }

      /* Timestamp & Status */
      .wc-time-row {
        display: flex; align-items: center; gap: 4px;
        margin-top: 3px; padding: 0 4px;
      }
      .wc-time {
        font-size: 10px; color: var(--wc-text-muted);
        white-space: nowrap;
      }
      .wc-status {
        font-size: 10px; color: var(--wc-text-muted);
        display: flex; align-items: center;
      }
      .wc-status.seen { color: var(--wc-primary); }

      /* ── Typing indicator ── */
      #wc-typing {
        display: none; align-items: center; gap: 8px;
        padding: 0 12px 8px;
      }
      .wc-typing-dots { display: flex; gap: 4px; align-items: center; }
      .wc-typing-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--wc-text-muted);
        animation: wc-bounce 1.3s infinite;
      }
      .wc-typing-dot:nth-child(2) { animation-delay: 0.15s; }
      .wc-typing-dot:nth-child(3) { animation-delay: 0.30s; }
      @keyframes wc-bounce { 0%,80%,100%{transform:translateY(0);} 40%{transform:translateY(-5px);} }
      .wc-typing-text { font-size: 11px; color: var(--wc-text-muted); }

      /* ── Image preview bar ── */
      #wc-preview-bar {
        background: var(--wc-surface);
        border-top: 1px solid var(--wc-border);
        padding: 8px 12px;
        display: none; align-items: center; gap: 10px;
      }
      #wc-preview-bar img { height: 44px; border-radius: 6px; }
      #wc-preview-bar span {
        font-size: 11px; color: var(--wc-text-muted); flex: 1;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
      }
      #wc-remove-preview {
        background: #ef4444; border: none; border-radius: 50%;
        width: 20px; height: 20px; color: #fff; cursor: pointer;
        font-size: 12px; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }

      /* ── Input bar ── */
      #wc-input-bar {
        background: var(--wc-surface);
        border-top: 1px solid var(--wc-border);
        padding: 10px 12px;
        display: none; align-items: flex-end; gap: 8px; flex-shrink: 0;
      }
      #wc-text-input {
        flex: 1; background: var(--wc-surface2);
        border: 1.5px solid var(--wc-border);
        border-radius: 22px; padding: 9px 15px;
        color: var(--wc-text); font-size: 13.5px;
        resize: none; min-height: 40px; max-height: 110px;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        line-height: 1.45;
      }
      #wc-text-input:focus {
        border-color: var(--wc-primary);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
      }
      #wc-text-input::placeholder { color: var(--wc-text-muted); }

      .wc-icon-btn {
        width: 38px; height: 38px; border-radius: 50%;
        border: none; background: var(--wc-surface2);
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--wc-text-muted);
        transition: background 0.2s, color 0.2s, transform 0.1s;
        flex-shrink: 0;
      }
      .wc-icon-btn:hover  { background: var(--wc-primary); color: #fff; }
      .wc-icon-btn:active { transform: scale(0.92); }
      #wc-send-btn { background: var(--wc-primary); color: #fff; }
      #wc-send-btn:hover { background: var(--wc-primary-dark); }

      /* send btn send animation */
      #wc-send-btn.wc-sending { animation: wc-send-pop 0.2s ease; }
      @keyframes wc-send-pop {
        0%   { transform: scale(1); }
        50%  { transform: scale(0.85); }
        100% { transform: scale(1); }
      }

      /* ── Day separator ── */
      .wc-day-sep {
        text-align: center; font-size: 10px; color: var(--wc-text-muted);
        margin: 4px 0; display: flex; align-items: center; gap: 8px;
      }
      .wc-day-sep::before, .wc-day-sep::after {
        content: ''; flex: 1; height: 1px; background: var(--wc-border);
      }

      /* ── Image lightbox ── */
      #wc-lightbox {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.88); z-index: 2147483648;
        align-items: center; justify-content: center;
      }
      #wc-lightbox img { max-width: 90vw; max-height: 90vh; border-radius: 10px; }
      #wc-lightbox.show { display: flex; }
      #wc-lb-close {
        position: fixed; top: 16px; right: 16px;
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.12); border: none; border-radius: 50%;
        color: #fff; font-size: 20px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s;
      }
      #wc-lb-close:hover { background: rgba(255,255,255,0.22); }

      /* ── Responsive ── */
      @media (max-width: 450px) {
        #wc-wrapper { 
          bottom: 16px; right: 16px; left: 16px; 
          align-items: stretch;
          gap: 8px;
        }
        #wc-window { 
          width: 100% !important; 
          height: calc(100dvh - 90px); 
          max-height: calc(100dvh - 90px);
          bottom: 68px; 
          position: absolute; 
          right: 0; left: 0;
          border-radius: 16px;
          transform: translateY(20px) scale(0.95);
        }
        #wc-wrapper.wc-open #wc-window {
          transform: translateY(0) scale(1);
        }
        #wc-toggle { 
          align-self: flex-end; 
          width: 54px; height: 54px;
        }
        body.wc-open-mobile {
          overflow: hidden;
        }
      }

      /* ── System Message ── */
      .wc-msg-row.system { justify-content: center; }
      .wc-bubble.system {
        background: var(--wc-surface2);
        color: var(--wc-text-muted);
        font-size: 11px;
        text-align: center;
        border-radius: 12px;
        padding: 6px 16px;           /* Improved padding */
        border: 1px solid var(--wc-border);
        max-width: 90%;
      }

      /* ── Stacking Logic ── */
      .wc-msg-row.wc-stacked {
        margin-top: -8px;
      }
      .wc-msg-row.wc-stacked .wc-msg-avatar-sm {
        visibility: hidden;
      }
      .wc-msg-row.wc-stacked.visitor .wc-bubble {
        border-top-right-radius: 4px;
      }
      .wc-msg-row.wc-stacked.agent .wc-bubble {
        border-top-left-radius: 4px;
      }
      .wc-msg-row.wc-has-next .wc-time {
        display: none;
      }
      .wc-msg-row:not(.wc-stacked) + .wc-msg-row:not(.wc-stacked) {
        margin-top: 4px;
      }

      /* ── Reopen Banner ── */
      #wc-reopen-banner {
        background: rgba(99,102,241,0.1);
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid var(--wc-border);
        display: none;
      }
      #wc-reopen-banner span { font-size: 13px; color: var(--wc-text); margin-bottom: 10px; display: block; }

      .wc-btn-sm {
        padding: 8px 24px;
        font-size: 13px;
        width: auto;
        display: inline-block;
        border-radius: 20px;
        font-weight: 700;
        background: var(--wc-primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
      }
      
      .wc-blocked-msg {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
        padding: 8px;
        font-size: 12px;
        text-align: center;
        display: none;
      }

      /* ── Emoji Only ── */
      .wc-bubble.wc-emoji-only {
        background: transparent !important;
        border: none !important;
        font-size: 42px;
        padding: 4px 0;
        line-height: 1.2;
        box-shadow: none !important;
      }
    `;
    const style = document.createElement('style');
    style.textContent = css;
    document.head.appendChild(style);
  }

  // ── DOM Building ────────────────────────────────────────────────────────────
  function buildWidget() {
    const wrapper = document.createElement('div');
    wrapper.id = 'wc-wrapper';
    wrapper.innerHTML = `
      <div id="wc-lightbox">
        <button id="wc-lb-close">✕</button>
        <img id="wc-lb-img" src="" alt="Preview">
      </div>
      <div id="wc-window">
        <div id="wc-header">
          <div class="wc-avatar">💬</div>
          <div class="wc-header-info">
            <div class="wc-header-name">Support Team</div>
            <div class="wc-header-status">
              <span class="wc-status-dot"></span> Online — typically replies instantly
            </div>
          </div>
          <button id="wc-sound-btn" title="Toggle sound">
            <svg id="wc-sound-icon" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072M12 6v12m0 0l-4-4m4 4l4-4M6.343 17.657A8 8 0 0117.657 6.343"/>
            </svg>
          </button>
        </div>

        <div id="wc-reopen-banner">
          <span>This conversation has ended.</span>
          <button class="wc-btn wc-btn-sm" id="wc-reopen-btn">Reopen Chat</button>
        </div>

        <div id="wc-prechat">
          <svg width="50" height="50" fill="none" viewBox="0 0 24 24" stroke="#6366f1" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
          </svg>
          <h3>Chat with Us! 👋</h3>
          <p>Enter your name and we'll connect you with our team right away.</p>
          <div class="wc-input-group">
            <label for="wc-name-input">Your Name</label>
            <input id="wc-name-input" class="wc-input" type="text" placeholder="e.g. John Doe" autocomplete="name">
          </div>
          <button class="wc-btn" id="wc-start-btn">Start Chat →</button>
        </div>

        <div id="wc-messages"></div>

        <div id="wc-typing">
          <div class="wc-typing-dots">
            <div class="wc-typing-dot"></div>
            <div class="wc-typing-dot"></div>
            <div class="wc-typing-dot"></div>
          </div>
          <span class="wc-typing-text">Support is typing…</span>
        </div>

        <div id="wc-preview-bar">
          <img id="wc-preview-img" src="" alt="">
          <span id="wc-preview-name"></span>
          <button id="wc-remove-preview">✕</button>
        </div>

        <div id="wc-input-bar">
          <textarea id="wc-text-input" placeholder="Type a message…" rows="1"></textarea>
          <label class="wc-icon-btn" for="wc-file-input" title="Attach image">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </label>
          <input type="file" id="wc-file-input" accept="image/*" style="display:none">
          <button id="wc-send-btn" class="wc-icon-btn" title="Send">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
          </button>
        </div>

        <div class="wc-blocked-msg" id="wc-blocked-msg">
          Message sending is disabled for this chat.
        </div>

        </div>
      </div>

      <button id="wc-toggle" aria-label="Toggle chat">
        <svg class="wc-icon-chat" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg class="wc-icon-close" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span id="wc-badge"></span>
      </button>
    `;
    document.body.appendChild(wrapper);
  }

  // ── Event Binding ─────────────────────────────────────────────────────────
  function bindEvents() {
    const toggle = document.getElementById('wc-toggle');
    const startBtn = document.getElementById('wc-start-btn');
    const nameInput = document.getElementById('wc-name-input');
    const textInput = document.getElementById('wc-text-input');
    const sendBtn = document.getElementById('wc-send-btn');
    const fileInput = document.getElementById('wc-file-input');
    const rmPreview = document.getElementById('wc-remove-preview');
    const lb = document.getElementById('wc-lightbox');
    const lbClose = document.getElementById('wc-lb-close');
    const soundBtn = document.getElementById('wc-sound-btn');

    // Toggle chat window
    toggle.addEventListener('click', () => {
      // Unlock audio on first interaction (required by browsers)
      getAudioCtx();
      isOpen = !isOpen;
      const wrapper = document.getElementById('wc-wrapper');
      wrapper.classList.toggle('wc-open', isOpen);

      // Handle mobile scroll lock
      if (window.innerWidth <= 450) {
        document.body.classList.toggle('wc-open-mobile', isOpen);
      }

      if (isOpen) {
        hideBadge();
        setTimeout(() => {
          if (sessionId) document.getElementById('wc-text-input').focus();
          else nameInput.focus();
        }, 200);
      }
      sendHeartbeat();
    });

    // Sound toggle
    soundBtn.addEventListener('click', () => {
      soundEnabled = !soundEnabled;
      soundBtn.classList.toggle('muted', !soundEnabled);
      soundBtn.title = soundEnabled ? 'Mute sounds' : 'Unmute sounds';
      updateSoundIcon();
    });

    // Reopen button
    document.getElementById('wc-reopen-btn').addEventListener('click', async () => {
      const res = await apiFetch('reopen_session', { session_id: sessionId });
      if (res.success) {
        pollNow(); // Trigger immediate poll to update UI
      }
    });

    startBtn.addEventListener('click', startChat);
    nameInput.addEventListener('keydown', e => { if (e.key === 'Enter') startChat(); });

    sendBtn.addEventListener('click', sendMessage);
    textInput.addEventListener('keydown', e => {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });
    textInput.addEventListener('input', () => {
      textInput.style.height = 'auto';
      textInput.style.height = Math.min(textInput.scrollHeight, 110) + 'px';
    });

    fileInput.addEventListener('change', () => {
      const file = fileInput.files[0];
      if (!file) return;
      uploadPreview = file;
      const url = URL.createObjectURL(file);
      document.getElementById('wc-preview-img').src = url;
      document.getElementById('wc-preview-name').textContent = file.name;
      document.getElementById('wc-preview-bar').style.display = 'flex';
    });

    rmPreview.addEventListener('click', clearPreview);

    // Lightbox on image click
    document.getElementById('wc-messages').addEventListener('click', e => {
      if (e.target.tagName === 'IMG' && e.target.closest('.wc-bubble')) openLightbox(e.target.src);
    });
    lbClose.addEventListener('click', () => lb.classList.remove('show'));
    lb.addEventListener('click', e => { if (e.target === lb) lb.classList.remove('show'); });
  }

  function updateSoundIcon() {
    const icon = document.getElementById('wc-sound-icon');
    if (!icon) return;
    if (soundEnabled) {
      icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072M12 6v12m-6-6h.01M6.343 17.657A8 8 0 0117.657 6.343"/>`;
    } else {
      icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15zM17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>`;
    }
  }

  function openLightbox(src) {
    document.getElementById('wc-lb-img').src = src;
    document.getElementById('wc-lightbox').classList.add('show');
  }

  function clearPreview() {
    uploadPreview = null;
    document.getElementById('wc-file-input').value = '';
    document.getElementById('wc-preview-bar').style.display = 'none';
  }

  // ── Chat Start ─────────────────────────────────────────────────────────────
  async function startChat() {
    const nameInput = document.getElementById('wc-name-input');
    const name = nameInput.value.trim();
    if (!name) {
      nameInput.style.borderColor = '#ef4444';
      nameInput.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
      nameInput.focus();
      return;
    }
    nameInput.style.borderColor = '';
    nameInput.style.boxShadow = '';

    const fp = getFingerprint();
    visitorName = name;
    localStorage.setItem('wc_visitor_name', name);

    const btn = document.getElementById('wc-start-btn');
    btn.textContent = 'Connecting…';
    btn.disabled = true;

    const res = await apiFetch('start_session', { fp, name });
    btn.textContent = 'Start Chat →';
    btn.disabled = false;

    if (res.session_id) {
      sessionId = res.session_id;
      localStorage.setItem('wc_session_id', sessionId);
      showChatUI();
      if (res.new) {
        appendMessage({
          id: 0,
          sender: 'agent', message_type: 'text',
          message: `Hi ${name}! 👋 Welcome! How can we help you today?`,
          created_at: new Date().toISOString()
        }, false); // don't play sound for welcome message
      } else {
        firstMsgId = null;
        hasMoreMessages = true;
        await loadAllMessages();
      }
      startPolling();
      startHeartbeat();
      document.getElementById('wc-text-input').focus();
    }
  }

  async function fetchSettings() {
    try {
      const res = await apiFetch('get_settings');
      if (res.settings) {
        const root = document.documentElement;
        for (const key in res.settings) {
          root.style.setProperty('--pref-' + key.replace(/_/g, '-'), res.settings[key]);
        }
        document.body.classList.add('wc-customized');
      }
    } catch (e) { }
  }

  // Scroll listener for lazy loading
  function initScrollListener() {
    const msgContainer = document.getElementById('wc-messages');
    msgContainer.addEventListener('scroll', () => {
      if (msgContainer.scrollTop < 50 && hasMoreMessages && !isLoadingMore) {
        loadAllMessages();
      }
    });
  }

  function showChatUI() {
    document.getElementById('wc-prechat').style.display = 'none';
    document.getElementById('wc-messages').style.display = 'flex';
    document.getElementById('wc-input-bar').style.display = 'flex';
  }

  // ── Session Resume ─────────────────────────────────────────────────────────
  async function tryResumeSession() {
    if (!sessionId) return;
    const res = await apiFetch('get_messages', null, 'GET');
    if (res.messages) {
      showChatUI();
      res.messages.forEach(m => {
        appendMessage(m, false);
        const row = document.getElementById('wc-messages').lastElementChild;
        if (row) row.setAttribute('data-msg-id', m.id);
      });
      scrollToBottom();
      startPolling();
      startHeartbeat();
    } else {
      sessionId = null;
      localStorage.removeItem('wc_session_id');
    }
  }

  async function handleSessionExpired() {
    stopPolling();
    sessionId = null;
    localStorage.removeItem('wc_session_id');
    lastMsgId = 0;

    // Clear message UI
    document.getElementById('wc-messages').innerHTML = '';

    if (visitorName) {
      // Auto-reconnect with same name
      const fp = getFingerprint();
      const res = await apiFetch('start_session', { fp, name: visitorName });
      if (res.session_id) {
        sessionId = res.session_id;
        localStorage.setItem('wc_session_id', sessionId);

        appendMessage({
          id: 0,
          sender: 'system', message_type: 'text',
          message: "Previous chat history has been cleared for privacy. You can start a new conversation.",
          created_at: new Date().toISOString()
        }, false);

        startPolling();
        startHeartbeat();
      }
    } else {
      // Back to pre-chat
      document.getElementById('wc-messages').style.display = 'none';
      document.getElementById('wc-input-bar').style.display = 'none';
      document.getElementById('wc-prechat').style.display = 'flex';
    }
  }

  // ── Load All Messages ──────────────────────────────────────────────────────
  async function loadAllMessages() {
    if (!sessionId || isLoadingMore || !hasMoreMessages) return;
    isLoadingMore = true;

    const urlParams = `action=get_messages&session_id=${sessionId}&limit=${MSG_LIMIT}` + (firstMsgId ? `&before_id=${firstMsgId}` : '');
    const res = await fetch(`${API}?${urlParams}`);
    const data = await res.json();

    if (data.messages && data.messages.length > 0) {
      const container = document.getElementById('wc-messages');
      const oldHeight = container.scrollHeight;

      data.messages.slice().reverse().forEach(msg => prependMessage(msg));

      if (!firstMsgId) {
        scrollToBottom();
        lastMsgId = Math.max(...data.messages.map(m => parseInt(m.id)));
      } else {
        container.scrollTop = container.scrollHeight - oldHeight;
      }

      firstMsgId = Math.min(...data.messages.map(m => parseInt(m.id)));
      if (data.messages.length < MSG_LIMIT) hasMoreMessages = false;
    } else {
      hasMoreMessages = false;
    }
    isLoadingMore = false;
  }

  // ── Send Message ───────────────────────────────────────────────────────────
  async function sendMessage() {
    if (!sessionId) return;
    const textInput = document.getElementById('wc-text-input');
    const sendBtn = document.getElementById('wc-send-btn');

    if (uploadPreview) {
      const fd = new FormData();
      fd.append('action', 'send_message');
      fd.append('session_id', sessionId);
      fd.append('image', uploadPreview);
      clearPreview();
      playSend();
      animateSendBtn();
      await fetch(API, { method: 'POST', body: fd });
    } else {
      const text = textInput.value.trim();
      if (!text) return;
      textInput.value = '';
      textInput.style.height = 'auto';
      playSend();
      animateSendBtn();
      await apiFetch('send_message', { message: text });
    }
    pollNow();
  }

  function animateSendBtn() {
    const btn = document.getElementById('wc-send-btn');
    btn.classList.add('wc-sending');
    setTimeout(() => btn.classList.remove('wc-sending'), 200);
  }

  async function pollNow() {
    await pollMessages();
  }

  function startPolling() {
    if (pollTimer) return;
    pollTimer = setInterval(pollMessages, POLL_INTERVAL);
  }

  function stopPolling() {
    if (pollTimer) {
      clearInterval(pollTimer);
      pollTimer = null;
    }
  }

  async function pollMessages() {
    if (!sessionId || !isOpen) return;
    try {
      const data = await apiFetch('get_messages', { since: lastMsgId });

      if (data.error && data.error === 'Session not found') {
        handleSessionExpired();
        return;
      }

      // Handle status updates for existing messages
      if (data.messages) {
        data.messages.forEach(m => {
          const existing = document.querySelector(`.wc-msg-row[data-msg-id="${m.id}"]`);
          if (existing) {
            const statusEl = existing.querySelector('.wc-status');
            if (statusEl && m.status) {
              statusEl.className = `wc-status ${m.status}`;
              statusEl.title = m.status;
              if (m.status === 'delivered' || m.status === 'seen') {
                statusEl.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12l5 5L15 7M10 17l5 5L22 10"/></svg>';
              }
            }
          }
        });
      }

      if (data.messages && data.messages.length) {
        let hasNew = false;
        data.messages.forEach(m => {
          const mid = parseInt(m.id) || 0;
          if (mid > lastMsgId) {
            appendMessage(m, true);
            lastMsgId = mid;
            if (m.sender === 'agent' && !isOpen) showBadge();
            hasNew = true;
          }
        });
        if (hasNew) scrollToBottom();
      }

      if (data.session) {
        const isClosed = data.session.status === 'closed';
        const isBlocked = parseInt(data.session.is_blocked) === 1;

        document.getElementById('wc-reopen-banner').style.display = isClosed ? 'block' : 'none';
        document.getElementById('wc-text-input').disabled = (isClosed || isBlocked);
        document.getElementById('wc-text-input').placeholder = isClosed ? 'Chat is closed' : (isBlocked ? 'Chat blocked' : 'Type a message…');
        document.getElementById('wc-blocked-msg').style.display = isBlocked ? 'block' : 'none';

        document.getElementById('wc-send-btn').style.opacity = (isClosed || isBlocked) ? '0.5' : '1';
        document.getElementById('wc-send-btn').style.pointerEvents = (isClosed || isBlocked) ? 'none' : 'all';
      }

      if (data.agent) {
        const statusText = document.querySelector('.wc-header-status');
        const statusDot = document.querySelector('.wc-status-dot');
        if (statusText && statusDot) {
          if (data.agent.viewing) {
            statusText.innerHTML = '<span class="wc-status-dot"></span> Support is viewing your chat';
            statusDot.style.animation = 'wc-pulse 2s infinite';
            statusDot.style.background = '#4ade80';
          } else if (data.agent.online) {
            statusText.innerHTML = '<span class="wc-status-dot"></span> Online — typically replies instantly';
            statusDot.style.animation = 'wc-pulse 2s infinite';
            statusDot.style.background = '#4ade80';
          } else {
            statusText.innerHTML = '<span class="wc-status-dot" style="background:#94a3b8"></span> Away — we\'ll be back soon';
            statusDot.style.animation = 'none';
            statusDot.style.background = '#94a3b8';
          }
        }
      }
    } catch (e) { }
  }

  function prependMessage(msg) {
    const container = document.getElementById('wc-messages');
    const row = buildMessageRow(msg);
    container.insertBefore(row, container.firstChild);
  }

  function buildMessageRow(msg) {
    const isVisitor = msg.sender === 'visitor';
    const isSystem = msg.sender === 'system';
    const time = formatTime(msg.created_at);
    const initials = isVisitor ? (visitorName ? visitorName.charAt(0) : 'V') : 'S';

    let content = '';
    let isEmojiOnly = false;

    if (msg.message_type === 'image' && msg.file_path) {
      content = `<img src="${BASE_URL}/${msg.file_path}" alt="${escHtml(msg.file_name || 'image')}" loading="lazy">`;
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

    if (isSystem) {
      row.className = 'wc-msg-row system';
      row.innerHTML = `<div class="wc-bubble system">${content.replace(/<br>/g, ' ')}</div>`;
    } else {
      row.className = `wc-msg-row ${isVisitor ? 'visitor' : 'agent'}`;

      let statusHtml = '';
      if (isVisitor) {
        const status = msg.status || 'sent';
        let icon = '';
        if (status === 'sent') icon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12l5 5L20 7"/></svg>';
        else if (status === 'delivered' || status === 'seen') icon = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12l5 5L15 7M10 17l5 5L22 10"/></svg>';
        statusHtml = `<div class="wc-status ${status}" title="${status}">${icon}</div>`;
      }

      row.innerHTML = `
        <div class="wc-msg-avatar-sm ${isVisitor ? 'wc-av-visitor' : ''}">${initials.toUpperCase()}</div>
        <div class="wc-msg-col">
          <div class="wc-bubble ${isVisitor ? 'visitor' : 'agent'}${isEmojiOnly ? ' wc-emoji-only' : ''}">${content}</div>
          <div class="wc-time-row">
            <span class="wc-time">${time}</span>
            ${statusHtml}
          </div>
        </div>
      `;
    }
    return row;
  }

  // ── Render Message ─────────────────────────────────────────────────────────
  function appendMessage(msg, playSound) {
    const container = document.getElementById('wc-messages');
    const row = buildMessageRow(msg);

    // Stacking logic
    const lastRow = container.lastElementChild;
    if (lastRow && !lastRow.classList.contains('system') && msg.sender !== 'system') {
      const lastSender = lastRow.classList.contains('visitor') ? 'visitor' : 'agent';
      if (lastSender === msg.sender) {
        const lastTime = parseInt(lastRow.getAttribute('data-time'));
        const currentTime = new Date(msg.created_at).getTime();
        if (currentTime - lastTime < 120000) {
          row.classList.add('wc-stacked');
          lastRow.classList.add('wc-has-next');
        }
      }
    }

    container.appendChild(row);

    if (playSound) {
      if (msg.sender === 'visitor') playSend();
      else playReceive();
    }
  }

  // ── Helpers ────────────────────────────────────────────────────────────────
  function scrollToBottom() {
    const c = document.getElementById('wc-messages');
    requestAnimationFrame(() => { c.scrollTop = c.scrollHeight; });
  }

  function showBadge() {
    const badge = document.getElementById('wc-badge');
    badge.classList.add('visible');
    const cur = parseInt(badge.textContent || '0');
    badge.textContent = cur + 1;
    playReceive();
  }

  function hideBadge() {
    const badge = document.getElementById('wc-badge');
    badge.classList.remove('visible');
    badge.textContent = '';
  }

  function formatTime(ts) {
    if (!ts) return '';
    try {
      return new Date(ts).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    } catch { return ''; }
  }

  function escHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  async function apiFetch(action, body, method) {
    method = method || 'POST';
    const headers = { 'Content-Type': 'application/json' };
    if (sessionId) headers['X-Session-ID'] = sessionId;
    const opts = { method, headers };
    const url = `${API}?action=${action}`;
    if (method === 'POST' && body) opts.body = JSON.stringify(body);
    try {
      const res = await fetch(url, opts);
      return await res.json();
    } catch (e) { return {}; }
  }

  // ── Initialization ────────────────────────────────────────────────────────
  (async function init() {
    injectStyles();
    buildWidget();
    bindEvents();
    initScrollListener();
    await fetchSettings();
    await tryResumeSession();
  })();
})();
