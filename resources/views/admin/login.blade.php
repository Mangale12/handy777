<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#090b19">
    <title>@yield('title', 'Admin Login') · {{ config('app.name', 'AB Gaming') }}</title>

    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}">
    <style>
        :root {
            --login-blue: #39b9ff;
            --login-purple: #8c52ff;
            --login-pink: #f0449d;
            --login-ink: #172033;
            --login-muted: #667085;
            --login-line: #e5e7eb;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body.admin-auth-body {
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--login-ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #090b19;
        }

        .admin-auth-shell {
            position: relative;
            isolation: isolate;
            display: grid;
            min-height: 100vh;
            place-items: center;
            padding: 32px 20px;
            overflow: hidden;
        }

        .admin-auth-shell::before {
            position: absolute;
            z-index: -2;
            inset: 0;
            content: "";
            background-image: url('{{ asset('images/abgaming.jpeg') }}');
            background-position: center;
            background-size: cover;
            transform: scale(1.04);
            filter: saturate(1.12) contrast(1.04);
        }

        .admin-auth-shell::after {
            position: absolute;
            z-index: -1;
            inset: 0;
            content: "";
            background:
                radial-gradient(circle at 18% 20%, rgba(57, 185, 255, .28), transparent 30%),
                radial-gradient(circle at 85% 80%, rgba(240, 68, 157, .22), transparent 34%),
                linear-gradient(115deg, rgba(5, 8, 23, .88), rgba(11, 13, 39, .67) 50%, rgba(9, 11, 25, .9));
        }

        .admin-auth-content {
            display: grid;
            width: min(100%, 1040px);
            min-height: 620px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 30px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 28px 90px rgba(0, 0, 0, .38), 0 2px 0 rgba(255, 255, 255, .18) inset;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .admin-auth-brand {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 620px;
            padding: 48px;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(8, 13, 42, .75), rgba(33, 17, 76, .62)),
                url('{{ asset('images/abgaming.jpeg') }}') center / cover;
        }

        .admin-auth-brand::after {
            position: absolute;
            right: -90px;
            bottom: -125px;
            width: 290px;
            height: 290px;
            content: "";
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgba(255, 255, 255, .04), 0 0 0 58px rgba(255, 255, 255, .035);
        }

        .admin-brand-copy,
        .admin-brand-footer {
            position: relative;
            z-index: 1;
        }

        .admin-brand-mark {
            display: grid;
            width: 70px;
            height: 70px;
            margin-bottom: 34px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .42);
            border-radius: 22px;
            color: #fff;
            background: linear-gradient(145deg, rgba(57, 185, 255, .9), rgba(140, 82, 255, .88), rgba(240, 68, 157, .82));
            box-shadow: 0 14px 35px rgba(0, 0, 0, .23), 0 0 0 7px rgba(255, 255, 255, .08);
            font-size: 27px;
            font-weight: 900;
            letter-spacing: -.1em;
        }

        .admin-brand-kicker {
            margin: 0 0 12px;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .admin-auth-brand h1 {
            max-width: 410px;
            margin: 0;
            font-size: clamp(36px, 4vw, 58px);
            font-weight: 850;
            letter-spacing: -.065em;
            line-height: .98;
        }

        .admin-brand-description {
            max-width: 390px;
            margin: 22px 0 0;
            color: rgba(255, 255, 255, .78);
            font-size: 15px;
            line-height: 1.7;
        }

        .admin-brand-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, .7);
            font-size: 12px;
        }

        .admin-brand-footer::before {
            width: 8px;
            height: 8px;
            content: "";
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 5px rgba(74, 222, 128, .14);
        }

        .admin-auth-form-panel {
            display: flex;
            align-items: center;
            padding: 48px clamp(28px, 5vw, 72px);
            background: rgba(255, 255, 255, .95);
        }

        .admin-auth-form {
            width: 100%;
            max-width: 390px;
            margin: 0 auto;
        }

        .admin-auth-eyebrow {
            margin: 0 0 10px;
            color: #7250ed;
            font-size: 12px;
            font-weight: 850;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .admin-auth-form h2 {
            margin: 0;
            color: var(--login-ink);
            font-size: 34px;
            font-weight: 850;
            letter-spacing: -.055em;
        }

        .admin-auth-subtitle {
            margin: 11px 0 30px;
            color: var(--login-muted);
            font-size: 14px;
            line-height: 1.55;
        }

        .admin-auth-alert {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            color: #991b1b;
            background: #fff1f2;
            font-size: 13px;
            line-height: 1.45;
        }

        .admin-auth-field {
            margin-bottom: 19px;
        }

        .admin-auth-field label,
        .admin-auth-remember label {
            display: block;
            margin: 0 0 8px;
            color: #344054;
            font-size: 13px;
            font-weight: 750;
        }

        .admin-input-wrap {
            position: relative;
        }

        .admin-input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            width: 18px;
            height: 18px;
            color: #98a2b3;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .admin-auth-input {
            width: 100%;
            height: 50px;
            padding: 0 15px 0 46px;
            border: 1px solid var(--login-line);
            border-radius: 13px;
            outline: 0;
            color: var(--login-ink);
            background: #fff;
            box-shadow: 0 3px 12px rgba(16, 24, 40, .03);
            font: inherit;
            transition: border-color .2s, box-shadow .2s;
        }

        .admin-auth-input::placeholder {
            color: #98a2b3;
        }

        .admin-auth-input:focus {
            border-color: #7c5cf1;
            box-shadow: 0 0 0 4px rgba(124, 92, 241, .12);
        }

        .admin-password-input {
            padding-right: 52px;
        }

        .admin-password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            display: grid;
            width: 34px;
            height: 34px;
            padding: 0;
            place-items: center;
            border: 0;
            border-radius: 9px;
            color: #667085;
            background: transparent;
            cursor: pointer;
            transform: translateY(-50%);
            transition: color .2s, background .2s;
        }

        .admin-password-toggle:hover,
        .admin-password-toggle:focus-visible {
            color: #6548d9;
            background: #f1efff;
            outline: 0;
        }

        .admin-password-toggle svg {
            width: 18px;
            height: 18px;
        }

        .admin-field-error {
            display: block;
            margin-top: 7px;
            color: #b42318;
            font-size: 12px;
        }

        .admin-auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 4px 0 25px;
        }

        .admin-auth-remember {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .admin-auth-remember label {
            margin: 0;
            color: #667085;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .admin-auth-remember input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #7250ed;
            cursor: pointer;
        }

        .admin-auth-forgot {
            color: #6548d9;
            font-size: 13px;
            font-weight: 750;
            text-decoration: none;
        }

        .admin-auth-forgot:hover {
            color: #4c30bb;
            text-decoration: underline;
        }

        .admin-auth-submit {
            display: inline-flex;
            width: 100%;
            height: 52px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(110deg, #246bfe, #7448f5 58%, #c13bd4);
            box-shadow: 0 12px 25px rgba(103, 79, 224, .25);
            font: inherit;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .02em;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s, filter .2s;
        }

        .admin-auth-submit:hover {
            filter: brightness(1.06);
            box-shadow: 0 15px 30px rgba(103, 79, 224, .34);
            transform: translateY(-1px);
        }

        .admin-auth-submit:focus-visible {
            outline: 3px solid rgba(36, 107, 254, .25);
            outline-offset: 3px;
        }

        .admin-auth-submit:disabled {
            cursor: wait;
            opacity: .75;
            transform: none;
        }

        .admin-auth-submit .admin-submit-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .45);
            border-top-color: #fff;
            border-radius: 50%;
            animation: admin-login-spin .7s linear infinite;
        }

        .admin-auth-submit.is-loading .admin-submit-spinner {
            display: inline-block;
        }

        .admin-auth-note {
            margin: 25px 0 0;
            color: #98a2b3;
            font-size: 12px;
            line-height: 1.5;
            text-align: center;
        }

        @keyframes admin-login-spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 760px) {
            .admin-auth-shell {
                padding: 16px;
            }

            .admin-auth-content {
                display: block;
                min-height: 0;
                border-radius: 24px;
            }

            .admin-auth-brand {
                min-height: 260px;
                padding: 30px;
            }

            .admin-brand-mark {
                width: 54px;
                height: 54px;
                margin-bottom: 22px;
                border-radius: 17px;
                font-size: 21px;
            }

            .admin-auth-brand h1 {
                font-size: 38px;
            }

            .admin-brand-description {
                display: none;
            }

            .admin-brand-footer {
                margin-top: 28px;
            }

            .admin-auth-form-panel {
                padding: 34px 26px 30px;
            }
        }

        @media (max-width: 420px) {
            .admin-auth-shell {
                padding: 0;
            }

            .admin-auth-content {
                min-height: 100vh;
                border: 0;
                border-radius: 0;
            }

            .admin-auth-brand {
                min-height: 235px;
                border-radius: 0;
            }

            .admin-auth-form-panel {
                min-height: calc(100vh - 235px);
                padding: 32px 22px;
            }

            .admin-auth-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>
</head>

<body class="admin-auth-body">
    <main class="admin-auth-shell">
        @yield('content')
    </main>
</body>

</html>
