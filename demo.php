<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebChat Demo — Live Chat Plugin Demo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', system-ui, sans-serif; background: #0a0f1e; color: #f1f5f9; min-height: 100vh; }

    /* Hero nav */
    nav {
      display: flex;
      align-items: center;
      padding: 18px 48px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
      backdrop-filter: blur(12px);
      position: sticky; top: 0; z-index: 100;
      background: rgba(10,15,30,0.8);
    }
    .nav-logo { display: flex; align-items: center; gap: 10px; }
    .nav-logo-icon {
      width: 34px; height: 34px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
    }
    .nav-logo-text { font-size: 18px; font-weight: 800; letter-spacing: -0.4px; }
    .nav-links { display: flex; gap: 28px; margin-left: auto; align-items: center; }
    .nav-links a { font-size: 14px; color: #94a3b8; text-decoration: none; transition: color 0.2s; font-weight: 500; }
    .nav-links a:hover { color: #f1f5f9; }
    .nav-links .btn-nav {
      padding: 8px 20px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      border-radius: 8px;
      font-weight: 600;
      box-shadow: 0 4px 14px rgba(99,102,241,0.35);
    }
    .nav-links .btn-nav:hover { color: #fff; opacity: 0.9; }

    /* Hero */
    .hero {
      text-align: center;
      padding: 100px 24px 80px;
      position: relative;
      overflow: hidden;
    }
    .hero-bg-1 {
      position: absolute; width: 600px; height: 600px;
      border-radius: 50%; background: radial-gradient(circle, rgba(99,102,241,0.2), transparent 70%);
      top: -100px; left: 50%; transform: translateX(-50%);
      pointer-events: none;
    }
    .hero-tag {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(99,102,241,0.15);
      border: 1px solid rgba(99,102,241,0.3);
      padding: 5px 14px;
      border-radius: 99px;
      font-size: 12px; font-weight: 600;
      color: #a5b4fc;
      margin-bottom: 24px;
    }
    .hero-tag .dot { width: 6px; height: 6px; border-radius: 50%; background: #6366f1; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    h1.hero-title {
      font-size: clamp(40px, 7vw, 76px);
      font-weight: 900;
      letter-spacing: -2px;
      line-height: 1.05;
      margin-bottom: 20px;
    }
    .gradient-text {
      background: linear-gradient(135deg, #6366f1, #a78bfa, #06b6d4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-sub {
      font-size: 18px;
      color: #94a3b8;
      max-width: 560px;
      margin: 0 auto 40px;
      line-height: 1.7;
      font-weight: 400;
    }
    .hero-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .btn-primary {
      padding: 14px 32px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s;
      box-shadow: 0 8px 28px rgba(99,102,241,0.4);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(99,102,241,0.5); }
    .btn-outline {
      padding: 14px 32px;
      border: 1px solid rgba(99,102,241,0.4);
      color: #a5b4fc;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-outline:hover { background: rgba(99,102,241,0.1); }

    /* Features */
    .features {
      max-width: 1100px;
      margin: 0 auto;
      padding: 60px 24px 80px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .feature-card {
      background: rgba(30,41,59,0.5);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 20px;
      padding: 28px;
      transition: transform 0.2s, border-color 0.2s;
    }
    .feature-card:hover { transform: translateY(-4px); border-color: rgba(99,102,241,0.3); }
    .feature-icon {
      width: 48px; height: 48px;
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 18px;
    }
    .feature-card h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
    .feature-card p { font-size: 14px; color: #94a3b8; line-height: 1.6; }

    /* Code snippet */
    .code-section {
      max-width: 760px;
      margin: 0 auto 80px;
      padding: 0 24px;
      text-align: center;
    }
    .code-section h2 { font-size: 32px; font-weight: 800; margin-bottom: 10px; letter-spacing: -0.5px; }
    .code-section p { color: #94a3b8; margin-bottom: 28px; font-size: 15px; }
    .code-block {
      background: #0d1117;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 16px;
      padding: 24px;
      text-align: left;
      position: relative;
      overflow: hidden;
    }
    .code-block::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, #6366f1, #a78bfa, #06b6d4);
    }
    .code-block pre {
      font-family: 'SF Mono', 'Fira Code', monospace;
      font-size: 13px;
      color: #e2e8f0;
      line-height: 1.8;
      overflow-x: auto;
    }
    .code-block .comment { color: #64748b; }
    .code-block .tag { color: #f472b6; }
    .code-block .attr { color: #60a5fa; }
    .code-block .val { color: #4ade80; }
    .copy-code-btn {
      position: absolute;
      top: 14px; right: 14px;
      background: rgba(99,102,241,0.15);
      border: 1px solid rgba(99,102,241,0.3);
      border-radius: 7px;
      padding: 5px 12px;
      font-size: 11px;
      color: #a5b4fc;
      cursor: pointer;
      font-family: inherit;
      transition: all 0.2s;
    }
    .copy-code-btn:hover { background: rgba(99,102,241,0.3); }

    /* Footer */
    footer {
      border-top: 1px solid rgba(255,255,255,0.06);
      padding: 30px 48px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }
    footer .footer-logo { font-size: 15px; font-weight: 700; color: #64748b; }
    footer p { font-size: 12px; color: #475569; }
  </style>
</head>
<body>

<nav>
  <div class="nav-logo">
    <div class="nav-logo-icon">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
    </div>
    <span class="nav-logo-text">WebChat</span>
  </div>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#embed">Embed</a>
    <a href="admin/index.php" class="btn-nav">🎛 Admin Panel</a>
  </div>
</nav>

<section class="hero">
  <div class="hero-bg-1"></div>
  <div class="hero-tag"><span class="dot"></span> Live Demo Active</div>
  <h1 class="hero-title">
    Chat with your visitors,<br>
    <span class="gradient-text">in real time.</span>
  </h1>
  <p class="hero-sub">
    A complete live chat solution. Embed the widget on any page, and respond from the admin dashboard. Supports text and images.
  </p>
  <div class="hero-actions">
    <a href="admin/index.php" class="btn-primary">Open Admin Dashboard →</a>
    <a href="#embed" class="btn-outline">View embed code</a>
  </div>
</section>

<section class="features" id="features">
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(99,102,241,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#6366f1" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
      </svg>
    </div>
    <h3>Real-Time Messaging</h3>
    <p>Messages sync every 2 seconds between visitor and agent — no page reloads, no delays.</p>
  </div>
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(6,182,212,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#06b6d4" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
    </div>
    <h3>Image Sharing</h3>
    <p>Both visitors and agents can attach and send photos up to 10MB in any conversation.</p>
  </div>
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(16,185,129,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#10b981" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
      </svg>
    </div>
    <h3>Visitor Identification</h3>
    <p>Pre-chat form captures visitor name. Each browser gets a unique persistent session ID.</p>
  </div>
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(245,158,11,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
      </svg>
    </div>
    <h3>Agent Dashboard</h3>
    <p>Manage all conversations from one panel. See unread counts, visitor IP, and session history.</p>
  </div>
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(239,68,68,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#ef4444" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
      </svg>
    </div>
    <h3>One-Line Embed</h3>
    <p>Add the chat widget to any website with a single &lt;script&gt; tag. No framework needed.</p>
  </div>
  <div class="feature-card">
    <div class="feature-icon" style="background:rgba(139,92,246,0.15)">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#8b5cf6" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2a2 2 0 002 2zM12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707"/>
      </svg>
    </div>
    <h3>Mobile Responsive</h3>
    <p>Both the widget and the admin panel work beautifully on phones, tablets, and desktops.</p>
  </div>
</section>

<section class="code-section" id="embed">
  <h2>Embed in 1 line</h2>
  <p>Copy this snippet and paste it before the &lt;/body&gt; tag on any webpage.</p>
  <div class="code-block">
    <button class="copy-code-btn" id="copy-btn">Copy</button>
    <pre id="embed-code"><span class="comment">&lt;!-- WebChat Live Support Widget --&gt;</span>
<span class="tag">&lt;script</span> <span class="attr">src</span>=<span class="val">"</span><span class="val" id="script-src-val">...</span><span class="val">"</span> <span class="attr">defer</span><span class="tag">&gt;&lt;/script&gt;</span></pre>
  </div>
</section>

<footer>
  <div class="footer-logo">⚡ WebChat</div>
  <p>Built on PHP + MySQL + vanilla JS · No external dependencies</p>
</footer>

<script>
  // Update the displayed code and copy logic based on current location
  const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^/]*$/, '');
  const scriptUrl = baseUrl + '/widget/webchat.js';
  document.getElementById('script-src-val').textContent = scriptUrl;

  document.getElementById('copy-btn').addEventListener('click', function() {
    const code = `<!-- WebChat Live Support Widget -->\n<script src="${scriptUrl}" defer><\/script>`;
    navigator.clipboard.writeText(code).then(() => {
      this.textContent = 'Copied!';
      setTimeout(() => this.textContent = 'Copy', 2000);
    });
  });
</script>

<!-- The widget itself for demo purposes -->
<script src="widget/webchat.js" defer></script>
</body>
</html>
