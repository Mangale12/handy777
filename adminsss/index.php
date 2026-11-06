<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebChat Admin — Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background: #0a0f1e;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }
    /* animated bg orbs */
    .bg-orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.3;
      pointer-events: none;
    }
    .bg-orb-1 { width: 500px; height: 500px; background: #6366f1; top: -100px; right: -100px; animation: orb-float 8s ease-in-out infinite; }
    .bg-orb-2 { width: 400px; height: 400px; background: #8b5cf6; bottom: -100px; left: -100px; animation: orb-float 10s ease-in-out infinite reverse; }
    .bg-orb-3 { width: 300px; height: 300px; background: #06b6d4; top: 50%; left: 40%; animation: orb-float 12s ease-in-out infinite 3s; }
    @keyframes orb-float { 0%,100%{transform:translateY(0) scale(1);} 50%{transform:translateY(-30px) scale(1.05);} }

    .login-card {
      background: rgba(30,41,59,0.7);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid rgba(99,102,241,0.2);
      border-radius: 24px;
      padding: 48px 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05) inset;
      position: relative;
      z-index: 10;
    }
    .login-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
    }
    .logo-icon {
      width: 48px; height: 48px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 8px 24px rgba(99,102,241,0.4);
    }
    .logo-text h1 { font-size: 22px; font-weight: 800; color: #f1f5f9; letter-spacing: -0.5px; }
    .logo-text p { font-size: 12px; color: #94a3b8; font-weight: 400; }

    .login-title { font-size: 26px; font-weight: 700; color: #f1f5f9; margin-bottom: 6px; }
    .login-sub { font-size: 14px; color: #94a3b8; margin-bottom: 32px; }

    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
    .form-group .input-wrap { position: relative; }
    .form-group .input-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #64748b; pointer-events: none; }
    .form-group input {
      width: 100%;
      background: rgba(15,23,42,0.6);
      border: 1px solid rgba(100,116,139,0.3);
      border-radius: 12px;
      padding: 12px 14px 12px 44px;
      color: #f1f5f9;
      font-size: 14px;
      font-family: inherit;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }
    .form-group input::placeholder { color: #475569; }

    .btn-login {
      width: 100%;
      padding: 13px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      font-family: inherit;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
      box-shadow: 0 8px 24px rgba(99,102,241,0.35);
      margin-top: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-login:hover { opacity: 0.9; box-shadow: 0 12px 32px rgba(99,102,241,0.45); }
    .btn-login:active { transform: scale(0.98); }
    .btn-login:disabled { opacity: 0.6; cursor: not-allowed; }

    .error-msg {
      display: none;
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.3);
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      color: #f87171;
      margin-bottom: 16px;
    }
    .error-msg.show { display: block; }

    .login-footer { text-align: center; font-size: 12px; color: #475569; margin-top: 24px; }

    .spinner {
      width: 18px; height: 18px;
      border: 2px solid rgba(255,255,255,0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      display: none;
    }
    .btn-login.loading .spinner { display: block; }
    .btn-login.loading .btn-text { display: none; }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>
</head>
<body>
  <div class="bg-orb bg-orb-1"></div>
  <div class="bg-orb bg-orb-2"></div>
  <div class="bg-orb bg-orb-3"></div>

  <div class="login-card">
    <div class="login-logo">
      <div class="logo-icon">
        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
      </div>
      <div class="logo-text">
        <h1>WebChat</h1>
        <p>Live Support Platform</p>
      </div>
    </div>

    <div class="login-title">Welcome back 👋</div>
    <div class="login-sub">Sign in to your agent dashboard</div>

    <div class="error-msg" id="errorMsg"></div>

    <form id="loginForm">
      <div class="form-group">
        <label for="username">Username</label>
        <div class="input-wrap">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <input type="text" id="username" name="username" placeholder="admin" autocomplete="username" required>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
        </div>
      </div>
      <button type="submit" class="btn-login" id="loginBtn">
        <span class="btn-text">Sign In →</span>
        <div class="spinner"></div>
      </button>
    </form>

  </div>

  <script>
    // Check if already logged in
    fetch('../api/auth.php?action=check')
      .then(r => r.json())
      .then(d => { if (d.logged_in) window.location.href = 'dashboard.php'; });

    document.getElementById('loginForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = document.getElementById('loginBtn');
      const errMsg = document.getElementById('errorMsg');
      errMsg.classList.remove('show');
      btn.classList.add('loading');
      btn.disabled = true;

      try {
        const res = await fetch('../api/auth.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'login',
            username: document.getElementById('username').value.trim(),
            password: document.getElementById('password').value
          })
        });
        const data = await res.json();
        if (data.success) {
          window.location.href = 'dashboard.php';
        } else {
          errMsg.textContent = data.error || 'Invalid credentials';
          errMsg.classList.add('show');
        }
      } catch (err) {
        errMsg.textContent = 'Connection error. Please try again.';
        errMsg.classList.add('show');
      }

      btn.classList.remove('loading');
      btn.disabled = false;
    });
  </script>
</body>
</html>
