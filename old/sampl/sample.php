<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebChat - Demo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --bg: #0f172a;
            --surface: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
            -webkit-text-size-adjust: 100%;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        header {
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 6px;
        }

        .hero {
            padding: 60px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(1.75rem, 8vw, 3rem);
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            word-wrap: break-word;
        }

        .hero p {
            font-size: 1rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
            cursor: pointer;
            font-size: 14px;
            min-width: 140px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-outline {
            border: 1px solid var(--surface);
            color: var(--text);
        }

        .features {
            padding: 40px 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: 20px;
        }

        .feature-card {
            background: var(--surface);
            padding: 24px;
            border-radius: 16px;
            text-align: left;
        }

        .feature-card h3 {
            margin-bottom: 12px;
            font-size: 1.25rem;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        footer {
            padding: 40px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        @media (max-width: 600px) {
            .hero { padding: 40px 0; }
            .btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <div class="logo-icon"></div>
                AB Gaming Chat
            </div>
        </header>

        <section class="hero">
            <h1>Welcome</h1>
            <p>A simple, powerful chat widget for AB GAming. Connect with visitors instantly and improve conversions.</p>
            <div class="btn-group">
                <a href="#" class="btn btn-primary">Start Demo</a>
                <a href="#" class="btn btn-outline">Learn More</a>
            </div>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Fast & Reliable</h3>
                <p>Loads instantly without Having facebook .</p>
            </div>
          
            <div class="feature-card">
                <h3>Secure</h3>
                <p>End-to-end encryption for all your conversations.</p>
            </div>
        </section>

        <footer>
            <p>&copy; 2026 AB Gaming. Works on all devices.</p>
        </footer>
    </div>

    <script src="widget/webchat.js" defer></script>
</body>
</html>