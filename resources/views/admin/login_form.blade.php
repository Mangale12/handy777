@extends('admin.login')

@section('content')
    <section class="admin-auth-content" aria-label="Administrator sign in">
        <aside class="admin-auth-brand">
            <div class="admin-brand-copy">
                <div class="admin-brand-mark" aria-hidden="true">AB</div>
                <p class="admin-brand-kicker">AB Gaming control center</p>
                <h1>Run your game room with confidence.</h1>
                <p class="admin-brand-description">
                    Manage players, games, balances, reports, and support conversations from one secure dashboard.
                </p>
            </div>
            <div class="admin-brand-footer">Secure administrator access</div>
        </aside>

        <section class="admin-auth-form-panel">
            <div class="admin-auth-form">
                <p class="admin-auth-eyebrow">Welcome back</p>
                <h2>Sign in</h2>
                <p class="admin-auth-subtitle">Use your administrator account to continue to the dashboard.</p>

                @if ($errors->any())
                    <div class="admin-auth-alert" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('message'))
                    <div class="admin-auth-alert" role="status" style="border-color:#bbf7d0;color:#166534;background:#f0fdf4;">
                        <span aria-hidden="true">✓</span>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                <form id="admin-login-form" method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="admin-auth-field">
                        <label for="email">Email address</label>
                        <div class="admin-input-wrap">
                            <svg class="admin-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 5 7-5" />
                            </svg>
                            <input
                                class="admin-auth-input"
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="admin@example.com"
                                autocomplete="username"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                            <span class="admin-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-auth-field">
                        <label for="password">Password</label>
                        <div class="admin-input-wrap">
                            <svg class="admin-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="4" y="10" width="16" height="10" rx="2" />
                                <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3" />
                            </svg>
                            <input
                                class="admin-auth-input admin-password-input"
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button class="admin-password-toggle" id="toggle-password" type="button" aria-label="Show password" aria-pressed="false">
                                <svg id="password-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                                    <circle cx="12" cy="12" r="2.5" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="admin-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-auth-options">
                        <div class="admin-auth-remember">
                            <input id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember me</label>
                        </div>
                        <a class="admin-auth-forgot" href="{{ route('admin.login.change_password') }}">Forgot password?</a>
                    </div>

                    <button class="admin-auth-submit" id="admin-login-submit" type="submit">
                        <span class="admin-submit-label">Sign in to dashboard</span>
                        <span class="admin-submit-spinner" aria-hidden="true"></span>
                    </button>
                </form>

                <p class="admin-auth-note">Your administrator session is protected with encrypted authentication.</p>
            </div>
        </section>
    </section>

    <script>
        (() => {
            const password = document.getElementById('password');
            const toggle = document.getElementById('toggle-password');
            const eye = document.getElementById('password-eye');
            const form = document.getElementById('admin-login-form');
            const submit = document.getElementById('admin-login-submit');

            if (password && toggle && eye) {
                toggle.addEventListener('click', () => {
                    const isVisible = password.type === 'text';
                    password.type = isVisible ? 'password' : 'text';
                    toggle.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
                    toggle.setAttribute('aria-pressed', String(!isVisible));
                    eye.innerHTML = isVisible
                        ? '<path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 5.2A9.7 9.7 0 0 1 12 5c6 0 9.5 7 9.5 7a17.6 17.6 0 0 1-3.2 3.9M6.3 6.3C3.8 8 2.5 12 2.5 12s3.5 7 9.5 7c1.3 0 2.5-.3 3.5-.8"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/>';
                });
            }

            if (form && submit) {
                form.addEventListener('submit', () => {
                    submit.disabled = true;
                    submit.classList.add('is-loading');
                });
            }
        })();
    </script>
@endsection
