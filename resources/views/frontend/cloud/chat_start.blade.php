@php
    $chatFullName = trim((string) ($user->full_name ?? ''));
    $chatFacebookName = trim((string) ($user->facebook_name ?? ''));
    $chatSupportName = 'AB Gaming Support';
    $chatUserInitial = strtoupper(substr($chatFullName ?: 'U', 0, 1));
    $chatSupportPhone = trim((string) config('app.support_phone', ''));
    $chatSupportPhoneHref = preg_replace('/[^0-9+]/', '', $chatSupportPhone);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover, interactive-widget=resizes-content">
    <title>{{ $chatSupportName }} · Chat Support</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="Connect with our support team instantly through our dedicated chat portal.">
    <!-- Theme color adapts to light/dark mode for status bar -->
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)" id="theme-color-light">
    <meta name="theme-color" content="#000000" media="(prefers-color-scheme: dark)" id="theme-color-dark">
    <style>
        :root {
            --ios-blue: #246bfe;
            --ios-purple: #7448f5;
            --ios-pink: #f0449d;
            --ios-gold: #ffb62e;
            --ios-gray: #ffffff;
            --ios-gray-text: #64708c;
            --ios-bg: #f4f7fb;
            --ios-surface: #eef1ff;
            --ios-border: #dfe5f0;
            --ios-text: #172033;
            --ios-bubble-visitor: linear-gradient(135deg, #246bfe 0%, #7448f5 100%);
            --ios-bubble-agent: #ffffff;
            --ios-bubble-visitor-text: #ffffff;
            --ios-bubble-agent-text: #000000;
            --ios-header-bg: linear-gradient(135deg, rgba(23,31,61,.96), rgba(45,44,113,.96) 58%, rgba(111,54,166,.94));
            
            --safe-top: env(safe-area-inset-top, 0px);
            --safe-bottom: env(safe-area-inset-bottom, 0px);
        }

        [data-theme="dark"] {
            --ios-bg: #080b18;
            --ios-surface: #151b33;
            --ios-border: #2a3760;
            --ios-text: #ffffff;
            --ios-gray: #151b33;
            --ios-bubble-agent: #151b33;
            --ios-bubble-agent-text: #ffffff;
            --ios-gray-text: #8e8e93;
            --ios-header-bg: linear-gradient(135deg, #062e67, #321575 58%, #71144e);
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
            background: radial-gradient(circle at 10% 0%, rgba(8,126,255,.14), transparent 34%), radial-gradient(circle at 90% 100%, rgba(233,43,159,.13), transparent 32%), var(--ios-bg);
            color: var(--ios-text);
            display: flex;
            flex-direction: column;
            line-height: 1.4;
            /* -webkit-fill-available covers older Safari that doesn't support dvh */
            min-height: -webkit-fill-available;
        }

        body::before {
            position: fixed;
            z-index: -1;
            inset: 0;
            content: "";
            background-image: var(--background-image);
            background-position: center;
            background-size: cover;
            opacity: .08;
            pointer-events: none;
        }

        /* ── Header ── */
        header {
            /* Uses CSS variable so dark mode is respected */
            background: var(--ios-header-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 0;
            padding-top: calc(var(--safe-top) + 12px);
            padding-bottom: 12px;
            padding-left: 16px;
            padding-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            flex-shrink: 0;
            box-shadow: 0 8px 24px rgba(23, 42, 106, .22);
        }

        .chat-logout-form {
            display: inline-flex;
        }

        .chat-header-actions {
            position: absolute;
            top: calc(var(--safe-top) + 14px);
            right: 12px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .user-details-toggle {
            display: inline-flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 50%;
            color: #fff;
            background: rgba(4, 17, 66, .2);
            cursor: pointer;
            backdrop-filter: blur(8px);
        }

        .user-details-toggle:hover,
        .user-details-toggle[aria-expanded="true"],
        .voice-call-toggle:hover {
            background: rgba(255,255,255,.24);
        }

        .voice-call-toggle {
            display: inline-flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 50%;
            color: #fff;
            background: rgba(4, 17, 66, .2);
            cursor: pointer;
            text-decoration: none;
            backdrop-filter: blur(8px);
        }

        .voice-call-toggle[aria-disabled="true"] {
            cursor: not-allowed;
            opacity: .62;
        }

        .user-details-toggle:focus-visible,
        .voice-call-toggle:focus-visible,
        .user-details-close:focus-visible,
        .chat-logout-btn:focus-visible,
        .chat-home-link:focus-visible {
            outline: 2px solid #fff;
            outline-offset: 2px;
        }

        .chat-home-link {
            position: absolute;
            top: calc(var(--safe-top) + 14px);
            left: 12px;
            z-index: 2;
            min-height: 30px;
            padding: 6px 10px;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 999px;
            color: #fff;
            background: rgba(4, 17, 66, .2);
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            backdrop-filter: blur(8px);
        }

        .chat-home-link:active {
            transform: scale(.96);
        }

        .chat-logout-btn {
            min-height: 30px;
            padding: 6px 10px;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 999px;
            color: #fff;
            background: rgba(4, 17, 66, .2);
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            backdrop-filter: blur(8px);
        }

        .chat-logout-btn:active {
            transform: scale(.96);
        }

        .agent-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
        }

        .agent-avatar {
            width: 46px;
            height: 46px;
            border: 3px solid rgba(255,255,255,.9);
            border-radius: 15px;
            background: #080b18;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 5px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(5, 12, 55, .28);
        }
        .agent-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .agent-name {
            max-width: 82vw;
            overflow: hidden;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-shadow: 0 1px 8px rgba(0,0,0,.18);
        }

        .agent-handle {
            max-width: 82vw;
            overflow: hidden;
            color: rgba(255,255,255,.78);
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ── Account details drawer ── */
        .user-details-layer {
            position: absolute;
            z-index: 250;
            inset: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .user-details-layer.is-open {
            visibility: visible;
            pointer-events: auto;
        }

        .user-details-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(4, 10, 30, .42);
            opacity: 0;
            transition: opacity .2s ease;
        }

        .user-details-layer.is-open .user-details-backdrop {
            opacity: 1;
        }

        .user-details-panel {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(320px, 88%);
            overflow-y: auto;
            padding: calc(var(--safe-top) + 18px) 20px calc(var(--safe-bottom) + 20px);
            color: var(--ios-text);
            background: rgba(255,255,255,.98);
            box-shadow: -12px 0 35px rgba(10, 20, 65, .2);
            transform: translateX(100%);
            transition: transform .24s ease;
        }

        [data-theme="dark"] .user-details-panel {
            background: rgba(15, 22, 48, .98);
        }

        .user-details-layer.is-open .user-details-panel {
            transform: translateX(0);
        }

        .user-details-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 22px;
        }

        .user-details-eyebrow {
            margin-bottom: 4px;
            color: var(--ios-blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .user-details-heading h2 {
            margin: 0;
            font-size: 20px;
            line-height: 1.2;
        }

        .user-details-close {
            display: inline-flex;
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 50%;
            color: var(--ios-gray-text);
            background: var(--ios-surface);
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
        }

        .user-details-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding: 14px;
            border: 1px solid var(--ios-border);
            border-radius: 15px;
            background: var(--ios-surface);
        }

        .user-details-avatar {
            display: inline-flex;
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, var(--ios-blue), var(--ios-purple), var(--ios-pink));
            font-size: 19px;
            font-weight: 800;
        }

        .user-details-profile strong,
        .user-details-profile small {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-details-profile strong { font-size: 15px; }
        .user-details-profile small { margin-top: 4px; color: var(--ios-gray-text); font-size: 12px; }

        .user-details-list {
            margin: 0;
        }

        .user-details-list > div {
            padding: 12px 0;
            border-bottom: 1px solid var(--ios-border);
        }

        .user-details-list dt {
            margin-bottom: 4px;
            color: var(--ios-gray-text);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .user-details-list dd {
            margin: 0;
            overflow-wrap: anywhere;
            font-size: 14px;
        }

        .agent-status {
            font-size: 11px;
            color: rgba(255,255,255,.86);
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
            position: relative;
            isolation: isolate;
            display: flex;
            flex-direction: column;
            flex: 1;
            /* min-height:0 is CRITICAL — without it, flex children won't shrink below their content size */
            min-height: 0;
            overflow: hidden;
        }

        .chat-wrapper::before {
            position: absolute;
            z-index: 0;
            inset: 0;
            content: "";
            background-image: var(--background-image);
            background-position: center;
            background-size: cover;
            opacity: .12;
            pointer-events: none;
        }

        .chat-wrapper > main { position: relative; z-index: 1; }
        .chat-wrapper > footer { z-index: 11; }

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
            background: linear-gradient(180deg, rgba(248,250,255,.84), rgba(235,241,255,.84));
        }

        [data-theme="dark"] main {
            background: linear-gradient(180deg, #0d1430, #080b18);
        }

        /* ── Pre-chat ── */
        #prechat-screen {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 20% 12%, rgba(36,107,254,.38), transparent 30%), radial-gradient(circle at 84% 84%, rgba(240,68,157,.34), transparent 34%), linear-gradient(145deg, rgba(6,21,47,.90), rgba(36,16,90,.90) 58%, rgba(107,18,78,.88)), var(--background-image);
            background-position: center;
            background-size: cover;
            z-index: 200;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            text-align: center;
        }

        #prechat-screen .welcome-desc {
            color: rgba(255,255,255,.78);
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            padding: 4px;
            border: 3px solid rgba(255,255,255,.8);
            border-radius: 24px;
            background: linear-gradient(135deg, var(--ios-blue), var(--ios-purple), var(--ios-pink));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 14px 34px rgba(74, 62, 224, .34);
        }

        .welcome-icon img {
            width: 100%;
            height: 100%;
            border-radius: 18px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            background: linear-gradient(90deg, var(--ios-blue), var(--ios-purple), var(--ios-pink));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
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
            background: var(--ios-bubble-visitor);
            color: var(--ios-bubble-visitor-text);
            box-shadow: 0 6px 16px rgba(64, 76, 210, .2);
            border-radius: 18px 18px 4px 18px;
        }

        .agent .bubble {
            background: var(--ios-bubble-agent);
            color: var(--ios-bubble-agent-text);
            border: 1px solid rgba(220,229,255,.9);
            box-shadow: 0 4px 14px rgba(41,65,133,.08);
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

        .chat-file-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: inherit;
            font-weight: 600;
            word-break: break-word;
            text-decoration: none;
        }

        .chat-file-link:hover {
            text-decoration: underline;
        }

        .file-caption {
            margin-top: 7px;
            white-space: pre-wrap;
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

        /* WhatsApp-style outgoing message state: one check = sent, two =
           delivered, blue two-check = seen. */
        .message-ticks {
            display: inline-block;
            margin-left: 8px;
            color: rgba(255,255,255,.78);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: -3px;
            line-height: 1;
            vertical-align: middle;
        }

        .message-ticks.delivered { color: rgba(255,255,255,.96); }
        .message-ticks.seen { color: #62d9ff; }

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
            background: rgba(255,255,255,.82);
            border-top: 1px solid rgba(220,229,255,.9);
            box-shadow: 0 -8px 24px rgba(41,65,133,.06);
            display: flex;
            align-items: flex-end;
            gap: 8px;
            /* Always visible at bottom */
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        [data-theme="dark"] footer,
        [data-theme="dark"] .input-container {
            background: rgba(15, 22, 48, .94);
        }

        .input-container {
            flex: 1;
            background: rgba(255,255,255,.92);
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
            color: var(--ios-purple);
            background: none;
            border: none;
            cursor: pointer;
            flex-shrink: 0;
        }

        .send-btn {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--ios-blue), var(--ios-purple));
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
                background: radial-gradient(circle at 14% 10%, rgba(8,126,255,.18), transparent 32%), radial-gradient(circle at 86% 90%, rgba(233,43,159,.18), transparent 34%), #eef2fb;
                align-items: center;
                justify-content: center;
            }
            .chat-wrapper {
                width: 400px;
                height: min(800px, 90vh);
                flex: none;
                background-color: var(--ios-bg);
                box-shadow: 0 24px 70px rgba(31,48,110,.22), 0 0 0 1px rgba(255,255,255,.8);
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
            pointer-events: none;
        }
        .preview-card {
            pointer-events: auto;
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

        #file-preview-name {
            display: none;
            max-width: 180px;
            color: var(--ios-text);
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

        .new-msg-pill {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: calc(var(--safe-bottom) + 72px);
            z-index: 30;
            background: var(--ios-blue);
            color: #fff;
            border: none;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 14px;
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
            display: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .new-msg-pill.show {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        #chat-error {
            position: absolute;
            right: 14px;
            bottom: calc(var(--safe-bottom) + 64px);
            left: 14px;
            z-index: 40;
            display: none;
            padding: 9px 12px;
            border: 1px solid rgba(255, 59, 48, .2);
            border-radius: 10px;
            color: #a51d18;
            background: rgba(255, 241, 240, .96);
            font-size: 12px;
            text-align: center;
            box-shadow: 0 5px 18px rgba(0,0,0,.12);
        }

        #chat-error.show { display: block; }
    </style>
</head>
<body>
    <div class="chat-wrapper" style="--background-image: url('{{ asset('images/abgaming.jpeg') }}');">
        <!-- Connection state; the email was already submitted on /chat. -->
        <div id="prechat-screen">
            <div class="welcome-icon">
                <img src="{{ asset('images/abgaming.jpeg') }}" alt="AB Gaming">
            </div>
            <h1 class="welcome-title">{{ $chatSupportName }}</h1>
            <p class="welcome-desc">Connecting your support chat…</p>
            <div id="chat-start-error" role="alert" style="display:none;color:#ff3b30;font-size:14px;margin-top:10px;text-align:center;"></div>
            <a id="chat-back-link" href="{{ route('chat') }}" style="display:none;margin-top:16px;color:#007aff;font-size:14px;text-decoration:none;">Return to email form</a>
        </div>

        <header>
            <a class="chat-home-link" href="{{ route('homePage') }}" aria-label="Back to home">← Home</a>
            <div class="chat-header-actions">
                @if ($chatSupportPhoneHref)
                    <a id="voice-call-button" class="voice-call-toggle" href="tel:{{ $chatSupportPhoneHref }}" aria-label="Call AB Gaming Support" title="Call AB Gaming Support">
                @else
                    <button id="voice-call-button" class="voice-call-toggle" type="button" aria-label="Voice call unavailable" aria-disabled="true" title="Voice calling is not configured">
                @endif
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                @if ($chatSupportPhoneHref)
                    </a>
                @else
                    </button>
                @endif
                <button id="user-details-toggle" class="user-details-toggle" type="button" aria-label="Show your account details" aria-controls="user-details-panel" aria-expanded="false" title="Show account details">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path stroke-linecap="round" d="M12 10.5v5M12 7.5h.01"></path>
                    </svg>
                </button>
                <form class="chat-logout-form" id="chat-logout-form" method="POST" action="{{ route('chat.logout') }}">
                    @csrf
                    <button class="chat-logout-btn" type="submit">Log out</button>
                </form>
            </div>
            <div class="agent-info">
                <div class="agent-avatar" id="agent-avatar-icon">
                    <img src="{{ asset('images/abgaming.jpeg') }}" alt="AB Gaming">
                </div>
                <div class="agent-name" id="agent-display-name">{{ $chatSupportName }}</div>
                <div class="agent-handle">Support conversation</div>
                <div class="agent-status">
                    <span class="status-dot"></span>
                    Online
                </div>
            </div>
        </header>

        <div id="user-details-layer" class="user-details-layer" aria-hidden="true">
            <div id="user-details-backdrop" class="user-details-backdrop"></div>
            <aside id="user-details-panel" class="user-details-panel" role="dialog" aria-modal="true" aria-labelledby="user-details-title" tabindex="-1">
                <div class="user-details-heading">
                    <div>
                        <div class="user-details-eyebrow">Your account</div>
                        <h2 id="user-details-title">User details</h2>
                    </div>
                    <button id="user-details-close" class="user-details-close" type="button" aria-label="Close user details">&times;</button>
                </div>

                <div class="user-details-profile">
                    <span class="user-details-avatar" aria-hidden="true">{{ $chatUserInitial }}</span>
                    <span>
                        <strong>{{ $chatFullName ?: 'Account holder' }}</strong>
                        <small>{{ $user->email }}</small>
                    </span>
                </div>

                <dl class="user-details-list">
                    @if ($chatFullName)
                        <div><dt>Full name</dt><dd>{{ $chatFullName }}</dd></div>
                    @endif
                    @if ($user->email)
                        <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                    @endif
                    @if ($user->number)
                        <div><dt>Phone</dt><dd>{{ $user->number }}</dd></div>
                    @endif
                    @if ($user->game_id)
                        <div><dt>Game ID</dt><dd>{{ $user->game_id }}</dd></div>
                    @endif
                    @if ($chatFacebookName)
                        <div><dt>Facebook</dt><dd>{{ $chatFacebookName }}</dd></div>
                    @endif
                </dl>
            </aside>
        </div>

        <main id="messages-container">
            <!-- Messages will be injected here -->
        </main>

        <button id="new-msg-pill" class="new-msg-pill" type="button"></button>

        <div id="preview-overlay">
            <div class="preview-card">
                <button class="remove-preview">&times;</button>
                <img id="image-preview" src="" alt="Selected Image">
                <span id="file-preview-name"></span>
            </div>
        </div>

        <footer>
            <button class="action-btn" id="attach-btn">
                <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
            <input type="file" id="file-input" accept="image/*,.avif,.bmp,.heic,.heif,.tif,.tiff,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip" style="display: none">
            
            <div class="input-container">
                <textarea id="message-input" placeholder="iMessage" rows="1"></textarea>
            </div>
            
            <button class="send-btn disabled" id="send-btn" title="Send">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </footer>
        <div id="chat-error" role="alert"></div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox">
        <button id="lightbox-close" aria-label="Close">&times;</button>
        <img id="lightbox-img" src="" alt="Full size">
    </div>

    <script>
        // ── Constants & State ──
        // All chat requests use the Laravel controller endpoint.
        const API = @json(route('api.chat'));
        const submittedEmail = @json($email ?? '');
        const submittedName = @json($user->full_name ?? '');
        let sessionId = localStorage.getItem('wc_session_id') || null;
        let visitorEmail = submittedEmail || localStorage.getItem('wc_visitor_email') || null;
        let visitorName = submittedName || localStorage.getItem('wc_visitor_name') || null;
        let lastMsgId = 0;
        let isPolling = false;
        let uploadFile = null;
        let unreadWhileScrolled = 0;
        let pollIntervalId = null;
        let heartbeatIntervalId = null;

        // ── DOM Elements ──
        const prechatScreen = document.getElementById('prechat-screen');
        const chatStartError = document.getElementById('chat-start-error');
        const chatBackLink = document.getElementById('chat-back-link');
        const messagesContainer = document.getElementById('messages-container');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const attachBtn = document.getElementById('attach-btn');
        const fileInput = document.getElementById('file-input');
        const previewOverlay = document.getElementById('preview-overlay');
        const imagePreview = document.getElementById('image-preview');
        const filePreviewName = document.getElementById('file-preview-name');
        const removePreview = document.querySelector('.remove-preview');
        const newMsgPill = document.getElementById('new-msg-pill');
        const chatError = document.getElementById('chat-error');
        const userDetailsToggle = document.getElementById('user-details-toggle');
        const userDetailsLayer = document.getElementById('user-details-layer');
        const userDetailsPanel = document.getElementById('user-details-panel');
        const userDetailsClose = document.getElementById('user-details-close');
        const userDetailsBackdrop = document.getElementById('user-details-backdrop');
        const voiceCallButton = document.getElementById('voice-call-button');
        let chatErrorTimer = null;

        function setUserDetailsOpen(open) {
            userDetailsLayer.classList.toggle('is-open', open);
            userDetailsLayer.setAttribute('aria-hidden', open ? 'false' : 'true');
            userDetailsToggle.setAttribute('aria-expanded', open ? 'true' : 'false');

            if (open) {
                userDetailsPanel.focus({ preventScroll: true });
            } else {
                userDetailsToggle.focus({ preventScroll: true });
            }
        }

        // ── Initialization ──
        function init() {
            // Fingerprint for session consistency. It must exist before the
            // automatic start request made after the /chat email form submits.
            if (!localStorage.getItem('wc_fp')) {
                const fp = Math.random().toString(36).substring(2, 15) + Date.now().toString(36);
                localStorage.setItem('wc_fp', fp);
            }

            // The email form at /chat has already been submitted. Start the
            // Laravel chat session with that email and skip the second welcome form.
            if (submittedEmail) {
                sessionId = null;
                visitorEmail = submittedEmail.trim().toLowerCase();
                visitorName = submittedName || visitorName || visitorEmail;
                startChat(visitorEmail);
            } else if (sessionId) {
                prechatScreen.style.display = 'none';
                startPolling();
            } else {
                showChatStartError('No email was submitted for this chat.');
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
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Session-ID': sessionId || '',
                        'X-Chat-Fingerprint': localStorage.getItem('wc_fp') || ''
                    },
                    body: JSON.stringify(body)
                });
                const contentType = response.headers.get('content-type') || '';
                const result = contentType.includes('application/json')
                    ? await response.json()
                    : { error: `Chat API returned HTTP ${response.status}` };

                if (!response.ok && !result.error) {
                    result.error = result.message || `Chat API returned HTTP ${response.status}`;
                }

                return result;
            } catch (error) {
                console.error('API Error:', error);
                return { error: 'Connection failed' };
            }
        }

        async function apiUpload(file, caption = '') {
            const formData = new FormData();
            formData.append('action', 'send_message');
            formData.append('file', file);
            if (caption) formData.append('message', caption);
            if (sessionId) formData.append('session_id', sessionId);

            try {
                const response = await fetch(API, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Session-ID': sessionId || '',
                        'X-Chat-Fingerprint': localStorage.getItem('wc_fp') || ''
                    },
                    body: formData
                });
                const contentType = response.headers.get('content-type') || '';
                const result = contentType.includes('application/json')
                    ? await response.json()
                    : {};
                if (!response.ok && !result.error) {
                    result.error = result.message || `File upload failed (HTTP ${response.status}).`;
                }
                return result;
            } catch (error) {
                console.error('Upload Error:', error);
                return { error: 'Upload failed' };
            }
        }

        // ── Actions ──
        async function startChat(emailOverride = '') {
            const providedEmail = typeof emailOverride === 'string' ? emailOverride : '';
            const email = (providedEmail || submittedEmail || visitorEmail || '').trim().toLowerCase();
            chatStartError.textContent = '';
            chatStartError.style.display = 'none';
            chatBackLink.style.display = 'none';
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showChatStartError('Please return to the email form and enter a valid email address.');
                return;
            }

            const fp = localStorage.getItem('wc_fp');
            const name = (visitorName || email).trim();
            const res = await apiFetch('start_session', {
                name,
                email,
                fp,
            });

            if (res.session_id) {
                sessionId = res.session_id;
                visitorEmail = email;
                visitorName = name;
                localStorage.setItem('wc_session_id', sessionId);
                localStorage.setItem('wc_visitor_email', visitorEmail);
                // Keep the legacy key for the existing widget/admin code.
                localStorage.setItem('wc_visitor_name', visitorName);
                
                prechatScreen.style.opacity = '0';
                setTimeout(() => {
                    prechatScreen.style.display = 'none';
                    startPolling();
                }, 300);
            } else {
                showChatStartError(res.error || 'Unable to start chat. Please try again.');
                console.error('Unable to start chat:', res.error || 'Unknown API error');
            }
        }

        function showChatStartError(message) {
            prechatScreen.style.display = 'flex';
            chatStartError.textContent = message;
            chatStartError.style.display = 'block';
            chatBackLink.style.display = 'inline-block';
        }

        async function sendMessage() {
            const text = messageInput.value.trim();
            if (!text && !uploadFile) return;

            let res;
            if (uploadFile) {
                res = await apiUpload(uploadFile, text);
            } else {
                res = await apiFetch('send_message', { message: text });
            }

            if (res.success) {
                if (uploadFile) clearPreview();
                messageInput.value = '';
                messageInput.style.height = 'auto';
                playSound('send');
                updateSendButton();
                pollMessages();
                return;
            }

            showChatError(getResponseError(res, 'The file could not be sent.'));

            if (isSessionNotFoundError(res)) {
                resetToWelcomeScreen();
            }
        }

        function getResponseError(res, fallback) {
            if (!res) return fallback;
            if (typeof res.error === 'string' && res.error.trim()) return res.error;
            if (typeof res.message === 'string' && res.message.trim()) return res.message;
            if (res.errors && typeof res.errors === 'object') {
                const firstError = Object.values(res.errors).flat()[0];
                if (firstError) return String(firstError);
            }
            return fallback;
        }

        function showChatError(message) {
            chatError.textContent = message;
            chatError.classList.add('show');
            clearTimeout(chatErrorTimer);
            chatErrorTimer = setTimeout(() => chatError.classList.remove('show'), 5000);
        }

        function isSessionNotFoundError(res) {
            if (!res || typeof res.error !== 'string') return false;
            return res.error.trim().toLowerCase() === 'session not found';
        }

        function resetToWelcomeScreen() {
            sessionId = null;
            lastMsgId = 0;
            isPolling = false;
            unreadWhileScrolled = 0;

            localStorage.removeItem('wc_session_id');

            if (pollIntervalId) {
                clearInterval(pollIntervalId);
                pollIntervalId = null;
            }
            if (heartbeatIntervalId) {
                clearInterval(heartbeatIntervalId);
                heartbeatIntervalId = null;
            }

            clearPreview();
            messagesContainer.innerHTML = '';
            messageInput.value = '';
            messageInput.style.height = 'auto';
            updateNewMessagePill();
            updateSendButton();

            showChatStartError('This chat session expired.');
        }

        function clearPreview() {
            uploadFile = null;
            fileInput.value = '';
            imagePreview.removeAttribute('src');
            imagePreview.style.display = 'block';
            filePreviewName.textContent = '';
            filePreviewName.style.display = 'none';
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
            if (pollIntervalId) clearInterval(pollIntervalId);
            if (heartbeatIntervalId) clearInterval(heartbeatIntervalId);

            pollMessages(true); // First poll
            pollIntervalId = setInterval(pollMessages, 3000);
            heartbeatIntervalId = setInterval(sendHeartbeat, 5000);
            
            // Unlock audio on first click
            document.body.addEventListener('click', () => getAudioCtx(), { once: true });
        }

        async function sendHeartbeat() {
            if (!sessionId) return;
            const res = await apiFetch('heartbeat', { is_viewing: 1 });
            if (isSessionNotFoundError(res)) {
                resetToWelcomeScreen();
            }
        }

        async function pollMessages(isFirst = false) {
            if (!sessionId || isPolling) return;
            isPolling = true;

            const res = await apiFetch('get_messages', { since: lastMsgId });
            isPolling = false;

            if (isSessionNotFoundError(res)) {
                resetToWelcomeScreen();
                return;
            }

            if (res.messages && res.messages.length > 0) {
                const newMessages = res.messages.filter(m => parseInt(m.id) > lastMsgId);
                
                if (newMessages.length > 0) {
                    const wasNearBottom = isNearBottom();
                    // Batch all new messages then render as a group
                    renderMessages(newMessages, isFirst);
                    lastMsgId = Math.max(...newMessages.map(m => parseInt(m.id)));
                    
                    if (!isFirst) {
                        const hasAgentMsg = newMessages.some(m => m.sender === 'agent');
                        if (hasAgentMsg) playSound('receive');

                        if (!wasNearBottom && hasAgentMsg) {
                            unreadWhileScrolled += newMessages.filter(m => m.sender === 'agent').length;
                            updateNewMessagePill();
                        } else if (wasNearBottom) {
                            unreadWhileScrolled = 0;
                            updateNewMessagePill();
                        }
                    }
                }
            }

            updateMessageStatuses(res.status_updates);
            
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

        function messageStatusMarkup(msg) {
            if (msg.sender !== 'visitor') return '';

            const status = ['sent', 'delivered', 'seen'].includes(msg.status)
                ? msg.status
                : 'sent';
            const ticks = status === 'sent' ? '✓' : '✓✓';
            const label = status === 'seen'
                ? 'Seen'
                : (status === 'delivered' ? 'Delivered' : 'Sent');

            return `<span class="message-ticks ${status}" title="${label}" aria-label="${label}">${ticks}</span>`;
        }

        function updateMessageStatuses(statusUpdates) {
            if (!Array.isArray(statusUpdates)) return;

            statusUpdates.forEach(update => {
                const row = Array.from(messagesContainer.querySelectorAll('.msg-row'))
                    .find(element => String(element.dataset.messageId) === String(update.id));
                const ticks = row && row.querySelector('.message-ticks');
                if (!ticks) return;

                const status = ['sent', 'delivered', 'seen'].includes(update.status)
                    ? update.status
                    : 'sent';
                const label = status === 'seen'
                    ? 'Seen'
                    : (status === 'delivered' ? 'Delivered' : 'Sent');
                ticks.className = `message-ticks ${status}`;
                ticks.textContent = status === 'sent' ? '✓' : '✓✓';
                ticks.title = label;
                ticks.setAttribute('aria-label', label);
            });
        }

        function renderMessages(history, isFirst = false) {
            // Near-bottom check BEFORE adding new nodes
            const nearBottom = isNearBottom();
            
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
                row.dataset.messageId = msg.id;
                if (senderChanged) row.setAttribute('data-sender-change', 'true');

                if (msg.sender === 'system') {
                    row.innerHTML = `<div class="system-msg">${msg.message}</div>`;
                } else {
                    let content = '';
                    let extraClass = '';
                    if (msg.message_type === 'image') {
                        const imageUrl = msg.file_url || msg.file_path || '';
                        const escapedSrc = imageUrl.replace(/'/g, "\\'");
                        content = `<img src="${imageUrl}" alt="Image" onclick="openLightbox('${escapedSrc}')">`;
                        if (msg.message) content += `<div class="file-caption">${formatMessage(msg.message)}</div>`;
                    } else if (msg.message_type === 'file' && (msg.file_url || msg.file_path)) {
                        const fileUrl = msg.file_url || msg.file_path || '';
                        const fileName = formatMessage(msg.file_name || 'Download file');
                        content = `<a class="chat-file-link" href="${escapeAttribute(fileUrl)}" target="_blank" rel="noopener" download>📎 ${fileName}</a>`;
                        if (msg.message) content += `<div class="file-caption">${formatMessage(msg.message)}</div>`;
                    } else {
                        if (isEmojiOnly(msg.message)) extraClass = ' emoji-only';
                        content = formatMessage(msg.message);
                    }
                    row.innerHTML = `<div class="bubble${extraClass}">${content}${messageStatusMarkup(msg)}</div>`;

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

        function isNearBottom() {
            return messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight - 120;
        }

        function updateNewMessagePill() {
            if (unreadWhileScrolled > 0) {
                const label = unreadWhileScrolled === 1 ? '1 new message' : `${unreadWhileScrolled} new messages`;
                newMsgPill.textContent = label;
                newMsgPill.classList.add('show');
            } else {
                newMsgPill.textContent = '';
                newMsgPill.classList.remove('show');
            }
        }

        function formatMessage(text) {
            if (!text) return '';
            return String(text)
                .replace(/[&<>'"]/g, character => ({
                    '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
                }[character]))
                .replace(/\n/g, '<br>');
        }

        function escapeAttribute(value) {
            return String(value || '').replace(/[&<>"']/g, character => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
            }[character]));
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
        if (voiceCallButton && voiceCallButton.getAttribute('aria-disabled') === 'true') {
            voiceCallButton.addEventListener('click', () => {
                showChatError('Voice calling is not configured yet.');
            });
        }

        userDetailsToggle.addEventListener('click', () => {
            setUserDetailsOpen(!userDetailsLayer.classList.contains('is-open'));
        });
        userDetailsClose.addEventListener('click', () => setUserDetailsOpen(false));
        userDetailsBackdrop.addEventListener('click', () => setUserDetailsOpen(false));
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && userDetailsLayer.classList.contains('is-open')) {
                setUserDetailsOpen(false);
            }
        });

        document.getElementById('chat-logout-form').addEventListener('submit', () => {
            ['wc_session_id', 'wc_visitor_email', 'wc_visitor_name', 'wc_fp'].forEach(key => {
                localStorage.removeItem(key);
            });
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
                if (file.size > 10 * 1024 * 1024) {
                    clearPreview();
                    alert('Files must be 10 MB or smaller.');
                    return;
                }
                uploadFile = file;
                const previewableImage = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
                    .includes((file.type || '').toLowerCase());
                if (previewableImage) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        filePreviewName.textContent = '';
                        filePreviewName.style.display = 'none';
                        previewOverlay.style.display = 'flex';
                        updateSendButton();
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.removeAttribute('src');
                    imagePreview.style.display = 'none';
                    filePreviewName.textContent = file.name;
                    filePreviewName.style.display = 'block';
                    previewOverlay.style.display = 'flex';
                    updateSendButton();
            }
            }
        });

        removePreview.addEventListener('click', clearPreview);

        newMsgPill.addEventListener('click', () => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            unreadWhileScrolled = 0;
            updateNewMessagePill();
        });

        messagesContainer.addEventListener('scroll', () => {
            if (isNearBottom() && unreadWhileScrolled > 0) {
                unreadWhileScrolled = 0;
                updateNewMessagePill();
            }
        });

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
