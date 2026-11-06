<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AB Gaming registration">
    <title>@yield('title', 'AB Gaming')</title>
    <link rel="icon" href="{{ asset('images/abgaming.jpeg') }}" type="image/jpeg">
    <style>
        :root {
            --ink: #172033;
            --muted: #65708a;
            --line: #dfe5f0;
            --surface: #ffffff;
            --background: #f4f7fb;
            --blue: #246bfe;
            --purple: #7448f5;
            --pink: #f0449d;
            --shadow: 0 18px 50px rgba(35, 48, 86, .12);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-width: 320px;
            background:
                radial-gradient(circle at 8% 0%, rgba(36, 107, 254, .12), transparent 28rem),
                radial-gradient(circle at 92% 8%, rgba(240, 68, 157, .11), transparent 26rem),
                var(--background);
            color: var(--ink);
            font: 16px/1.5 Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a { color: inherit; }
        button, input, select { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }

        .site-shell { min-height: 100vh; }
        .site-header,
        .page-container,
        .site-footer {
            width: min(1120px, calc(100% - 32px));
            margin-inline: auto;
        }

        .site-header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 20px;
            padding: 22px 0;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-size: 1.05rem;
            font-weight: 800;
            text-decoration: none;
            grid-column: 2;
            justify-self: center;
        }

        .brand img {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 8px 22px rgba(36, 107, 254, .2);
        }

        .support-link {
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 9px 15px;
            color: var(--blue);
            background: rgba(255, 255, 255, .75);
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
            grid-column: 3;
            justify-self: end;
        }

        .support-link:hover { border-color: var(--blue); background: var(--surface); }
        .page-container { padding: 28px 0 56px; }

        .registration-layout {
            display: grid;
            grid-template-columns: minmax(0, .82fr) minmax(0, 1.18fr);
            gap: 28px;
            align-items: stretch;
        }

        .intro-panel,
        .registration-card,
        .services-section {
            border: 1px solid rgba(223, 229, 240, .9);
            border-radius: 26px;
            background: rgba(255, 255, 255, .9);
            box-shadow: var(--shadow);
        }

        .intro-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            position: relative;
            isolation: isolate;
            padding: 38px;
            background: linear-gradient(145deg, #171f3d 0%, #2d2c71 58%, #6f36a6 100%);
            color: #fff;
        }

        .intro-panel::before {
            position: absolute;
            z-index: 0;
            inset: 0;
            content: "";
            background-image: var(--intro-image);
            background-position: center;
            background-size: cover;
            filter: saturate(1.3);
            mix-blend-mode: screen;
            opacity: .17;
        }

        .intro-panel > * { position: relative; z-index: 1; }

        .eyebrow {
            margin: 0 0 10px;
            color: #b8c8ff;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        .intro-panel h1 { margin: 0; font-size: clamp(2rem, 4vw, 3.35rem); line-height: 1.05; }
        .intro-panel p { max-width: 34rem; margin: 18px 0 0; color: #d9ddf3; }
        .intro-list { display: grid; gap: 12px; margin: 28px 0 0; padding: 0; list-style: none; color: #eef0ff; }
        .intro-list li::before { content: "✓"; display: inline-block; width: 24px; color: #70e1c1; font-weight: 800; }

        .registration-card {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: clamp(22px, 4vw, 40px);
            background: rgba(255, 255, 255, .82);
        }

        .registration-card::before {
            position: absolute;
            z-index: 0;
            inset: 0;
            content: "";
            background-image: var(--intro-image);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            filter: saturate(1.25);
            opacity: .24;
        }

        .registration-card > * { position: relative; z-index: 1; }

        .card-heading { margin-bottom: 24px; }
        .card-heading h2 { margin: 0; font-size: clamp(1.45rem, 3vw, 2rem); }
        .card-heading p { margin: 6px 0 0; color: var(--muted); }

        .form-alert {
            margin-bottom: 22px;
            padding: 12px 14px;
            border: 1px solid #ffc5d0;
            border-radius: 12px;
            background: #fff2f4;
            color: #b4233c;
        }

        .form-alert ul { margin: 0; padding-left: 20px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .field { display: grid; gap: 7px; }
        .field-wide { grid-column: 1 / -1; }
        .field label { color: #313b52; font-size: .88rem; font-weight: 750; }
        .field label span { color: #d52b59; }
        .field input,
        .field select {
            width: 100%;
            height: 46px;
            min-height: 46px;
            max-width: 100%;
            border: 1px solid var(--line);
            border-radius: 11px;
            outline: 0;
            padding: 10px 12px;
            color: var(--ink);
            background: #fbfcff;
            line-height: 24px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .field input:focus,
        .field select:focus { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 4px rgba(36, 107, 254, .12); }
        .field small { color: var(--muted); font-size: .78rem; }
        .captcha-box { display: grid; gap: 12px; margin-top: 22px; padding-top: 22px; border-top: 1px solid var(--line); }
        .captcha-tools { display: flex; align-items: center; gap: 12px; }
        #captcha_image { width: 135px; height: 50px; border: 1px solid var(--line); border-radius: 8px; background: #556c8a; }
        .refresh-button { border: 0; border-radius: 9px; padding: 10px 13px; color: #fff; background: #303b58; cursor: pointer; }
        .refresh-button:hover { background: var(--blue); }
        .captcha-input { max-width: 180px; text-transform: uppercase; letter-spacing: .18em; text-align: center; }
        .captcha-error { margin: 0; color: #c52c48; font-size: .85rem; }
        .is-hidden { display: none; }
        .submit-button {
            width: 100%;
            margin-top: 22px;
            border: 0;
            border-radius: 12px;
            padding: 13px 18px;
            color: #fff;
            background: linear-gradient(100deg, var(--blue), var(--purple), var(--pink));
            box-shadow: 0 10px 20px rgba(91, 73, 231, .22);
            font-weight: 800;
            cursor: pointer;
        }

        .submit-button:disabled { opacity: .65; cursor: wait; }
        .services-section { margin-top: 28px; padding: clamp(22px, 4vw, 34px); }
        .section-heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 18px; }
        .section-heading h2 { margin: 0; font-size: 1.45rem; }
        .section-heading p { margin: 0; color: var(--muted); font-size: .9rem; }
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 14px; }
        .service-card { overflow: hidden; border: 1px solid var(--line); border-radius: 15px; background: #fbfcff; text-decoration: none; }
        .service-card img,
        .service-placeholder { display: block; width: 100%; height: 130px; object-fit: cover; background: linear-gradient(135deg, #e8edff, #fbe7f1); }
        .service-placeholder { display: grid; place-items: center; color: var(--purple); font-size: 2rem; font-weight: 900; }
        .service-card strong { display: block; padding: 11px 13px; font-size: .92rem; }
        .site-footer { padding: 0 0 28px; color: var(--muted); font-size: .82rem; text-align: center; }

        @media (max-width: 820px) {
            .registration-layout { grid-template-columns: 1fr; }
            .intro-panel { padding: 30px; }
        }

        @media (max-width: 560px) {
            .site-header, .page-container, .site-footer { width: min(100% - 22px, 1120px); }
            .site-header { padding: 14px 0; }
            .brand img { width: 44px; height: 44px; }
            .brand span { display: none; }
            .support-link { padding: 8px 11px; font-size: .8rem; }
            .page-container { padding-top: 14px; }
            .intro-panel, .registration-card, .services-section { border-radius: 20px; }
            .intro-panel, .registration-card { padding: 22px; }
            .form-grid { grid-template-columns: 1fr; gap: 15px; }
            .field-wide { grid-column: auto; }
            .section-heading { display: block; }
            .section-heading p { margin-top: 4px; }
        }
    </style>
</head>
<body>
    <div class="site-shell">
        <header class="site-header">
            <a class="brand" href="{{ route('homePage') }}">
                <img src="{{ asset('images/abgaming.jpeg') }}" alt="AB Gaming">
                <span>AB Gaming</span>
            </a>
            <a class="support-link" href="{{ route('chat') }}">Support chat</a>
        </header>

        @yield('content')

        <footer class="site-footer">© {{ date('Y') }} AB Gaming. All rights reserved.</footer>
    </div>
</body>
</html>
