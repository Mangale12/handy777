<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chats · {{ config('app.name', 'AB Gaming') }}</title>
    <style>
        :root { --blue:#246bfe; --blue-dark:#7448f5; --pink:#f0449d; --ink:#172033; --muted:#65708a; --line:#dfe5f0; }
        * { box-sizing:border-box; }
        html, body { min-height:100%; margin:0; }
        body { position:relative; display:grid; place-items:center; padding:24px; color:var(--ink); background:radial-gradient(circle at 8% 0%, rgba(36,107,254,.12), transparent 28rem),radial-gradient(circle at 92% 8%, rgba(240,68,157,.11), transparent 26rem),#f4f7fb; font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif; }
        body::before { position:fixed; z-index:-1; inset:0; content:""; background-image:var(--background-image); background-position:center; background-size:cover; opacity:.08; pointer-events:none; }
        .shell { position:relative; isolation:isolate; width:min(100%,520px); overflow:hidden; border:1px solid rgba(223,229,240,.9); border-radius:28px; background:rgba(255,255,255,.82); box-shadow:0 24px 70px rgba(35,48,86,.16); }
        .shell::before { position:absolute; z-index:0; inset:0; content:""; background-image:var(--background-image); background-position:center; background-size:cover; opacity:.13; pointer-events:none; }
        .shell > * { position:relative; z-index:1; }
        .hero { padding:34px 34px 28px; color:#fff; background:linear-gradient(135deg,rgba(23,31,61,.94),rgba(45,44,113,.94) 58%,rgba(111,54,166,.92)),var(--background-image); background-position:center center; background-size:cover; text-align:center; }
        .home-link { display:inline-flex; align-items:center; gap:6px; margin-bottom:18px; padding:7px 12px; border:1px solid rgba(255,255,255,.4); border-radius:999px; color:#fff; background:rgba(255,255,255,.12); font-size:12px; font-weight:750; text-decoration:none; }
        .home-link:hover { background:rgba(255,255,255,.2); }
        .brand { display:grid; width:58px; height:58px; margin:0 auto 28px; padding:4px; place-items:center; border:1px solid rgba(255,255,255,.45); border-radius:18px; background:rgba(255,255,255,.16); box-shadow:inset 0 1px rgba(255,255,255,.3),0 8px 22px rgba(36,107,254,.2); overflow:hidden; }
        .brand img { width:100%; height:100%; border-radius:13px; object-fit:cover; }
        h1 { margin:0 0 10px; font-size:30px; letter-spacing:-.04em; }
        .hero p { margin:0; color:rgba(255,255,255,.82); line-height:1.55; }
        .body { padding:28px 34px 34px; background:rgba(255,255,255,.62); }
        .eyebrow { margin:0 0 8px; color:var(--blue); font-size:12px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }
        .body h2 { margin:0 0 8px; font-size:21px; letter-spacing:-.03em; }
        .hint { margin:0 0 22px; color:var(--muted); font-size:14px; line-height:1.5; }
        .user-card { display:grid; grid-template-columns:48px 1fr; gap:12px; align-items:center; margin-bottom:20px; padding:14px; border:1px solid #dbeafe; border-radius:16px; background:#f8fbff; }
        .user-avatar { display:grid; width:48px; height:48px; place-items:center; border-radius:50%; color:#fff; background:linear-gradient(135deg,var(--blue),var(--purple,#7448f5),var(--pink)); font-weight:800; }
        .user-card strong { display:block; font-size:15px; }
        .user-card small { display:block; margin-top:3px; overflow:hidden; color:var(--muted); text-overflow:ellipsis; white-space:nowrap; }
        .user-meta { grid-column:1 / -1; display:flex; flex-wrap:wrap; gap:7px; margin-top:2px; }
        .user-meta span { padding:5px 8px; border-radius:999px; color:#475467; background:#eef4ff; font-size:11px; }
        label { display:block; margin-bottom:8px; color:#344054; font-size:13px; font-weight:700; }
        input { width:100%; height:46px; padding:0 12px; border:1px solid var(--line); border-radius:11px; outline:0; color:var(--ink); background:rgba(255,255,255,.9); font:inherit; transition:border-color .2s,box-shadow .2s; }
        input:focus { border-color:var(--blue); box-shadow:0 0 0 4px rgba(24,119,242,.12); }
        .error { margin:8px 0 0; color:#b42318; font-size:13px; }
        button { width:100%; height:46px; margin-top:18px; border:0; border-radius:11px; color:#fff; background:linear-gradient(100deg,var(--blue),var(--blue-dark),var(--pink)); font:inherit; font-weight:750; cursor:pointer; box-shadow:0 8px 18px rgba(91,73,231,.22); transition:filter .2s,transform .1s; }
        button:hover { filter:brightness(1.08); }
        button:active { transform:translateY(1px); }
        .privacy { margin:18px 0 0; color:#98a2b3; font-size:12px; text-align:center; }
        @media (max-width:520px) { body { padding:0; } .shell { min-height:100vh; border:0; border-radius:0; } .hero,.body { padding-left:24px; padding-right:24px; } }
    </style>
</head>
<body>
    <main class="shell" style="--background-image: url('{{ asset('images/abgaming.jpeg') }}');">
        <section class="hero">
            <a class="home-link" href="{{ route('homePage') }}" aria-label="Back to home">← Home</a>
            <div class="brand" aria-hidden="true"><img src="{{ asset('images/abgaming.jpeg') }}" alt="AB Gaming"></div>
            <h1>Welcome to support</h1>
            <p>Start a private conversation with the AB Gaming support team.</p>
        </section>

        <section class="body">
            @if ($user)
                <p class="eyebrow">Signed-in account</p>
                <h2>Continue as {{ $user->full_name }}</h2>
                <p class="hint">Your support chat will use the details saved in your registration form.</p>
                <div class="user-card">
                    <span class="user-avatar">{{ strtoupper(substr($user->full_name ?: 'U', 0, 1)) }}</span>
                    <span><strong>{{ $user->full_name }}</strong><small>{{ $user->email }}</small></span>
                    <span class="user-meta">
                        @if ($user->number)<span>{{ $user->number }}</span>@endif
                        @if ($user->game_id)<span>Game ID: {{ $user->game_id }}</span>@endif
                    </span>
                </div>
            @else
                <p class="eyebrow">Secure account lookup</p>
                <h2>Find your account</h2>
                <p class="hint">Enter the email used on your form so the support team can see the correct account details.</p>
            @endif

            <form method="POST" action="{{ route('chat.submit') }}">
                @csrf
                @unless ($user)
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                @else
                    <input type="hidden" name="email" value="{{ $user->email }}">
                @endunless
                <button type="submit">Open support chat</button>
            </form>
            <p class="privacy">Your account information is only used to connect this conversation.</p>
        </section>
    </main>
</body>
</html>
