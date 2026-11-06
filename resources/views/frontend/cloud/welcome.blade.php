@extends('frontend.cloud.main')

@section('title', 'Register | AB Gaming')

@section('content')
    @php
        $accounts = \App\Models\Account::where('status', 'active')->get();
        $states = [
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
            'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
            'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii',
            'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa',
            'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine',
            'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota',
            'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska',
            'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico',
            'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio',
            'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island',
            'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas',
            'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington',
            'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming',
        ];
    @endphp

    <main class="page-container">
        <div class="registration-layout" style="--intro-image: url('{{ asset('images/abgaming.jpeg') }}');">
            <section class="intro-panel">
                <p class="eyebrow">Start playing today</p>
                <h1>Welcome to AB Gaming</h1>
                <p>Complete the short registration form and our team will connect your account with the right games and support.</p>
                <ul class="intro-list">
                    <li>Fast account registration</li>
                    <li>Dedicated support when you need it</li>
                    <li>Clear account and game details</li>
                </ul>
            </section>

            <section class="registration-card">
                <div class="card-heading">
                    <h2>Create your account</h2>
                    <p>Enter your details carefully. Fields marked with <strong>*</strong> are required.</p>
                </div>

                @if ($errors->any())
                    <div class="form-alert" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="regForm" action="{{ route('forms.stores') }}" method="POST">
                    @csrf
                    <input type="hidden" name="time_zone" id="time_zone" value="{{ old('time_zone') }}">

                    <div class="form-grid">
                        <div class="field">
                            <label for="full_name">Full name <span>*</span></label>
                            <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Eve Adam" maxlength="20" autocomplete="name" required>
                        </div>

                        <div class="field">
                            <label for="number">Phone number <span>*</span></label>
                            <input id="number" type="tel" name="number" value="{{ old('number') }}" placeholder="5551234567" maxlength="10" autocomplete="tel" required>
                            <small>Use a 10-digit phone number.</small>
                        </div>

                        <div class="field">
                            <label for="mail">State <span>*</span></label>
                            <select id="mail" name="mail" required>
                                <option value="" disabled {{ old('mail') ? '' : 'selected' }}>Select state</option>
                                @foreach ($states as $code => $state)
                                    <option value="{{ $code }}" {{ old('mail') === $code ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="r_id">Referral ID</label>
                            <input id="r_id" type="text" name="r_id" value="{{ old('r_id') }}" placeholder="Optional" maxlength="15" autocomplete="off">
                        </div>

                        <div class="field">
                            <label for="email">Email address <span>*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                        </div>

                        <div class="field">
                            <label for="facebook_name">Facebook name <span>*</span></label>
                            <input id="facebook_name" type="text" name="facebook_name" value="{{ old('facebook_name') }}" placeholder="Your Facebook name" maxlength="50" autocomplete="off" required>
                        </div>

                        <div class="field field-wide">
                            <label for="account">Game account <span>*</span></label>
                            <select id="account" class="game-select" name="account" required>
                                <option value="" disabled {{ old('account') ? '' : 'selected' }}>Select a game account</option>
                                @forelse ($accounts as $account)
                                    <option value="{{ $account->id }}" data-title="{{ $account->title }}" {{ (string) old('account') === (string) $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                @empty
                                    <option value="" disabled>No active accounts available</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="field field-wide">
                            <label for="game_id">Game ID <span>*</span></label>
                            <input id="game_id" type="text" name="game_id" value="{{ old('game_id') }}" placeholder="Enter your game ID" minlength="7" maxlength="15" autocomplete="off" required>
                            <small>Selecting a game account adds its prefix automatically; you can finish the ID in the box.</small>
                        </div>
                    </div>

                    <div class="captcha-box">
                        <label for="captcha_token"><strong>Security check <span>*</span></strong></label>
                        <div class="captcha-tools">
                            <img id="captcha_image" src="{{ url('captcha_image.php') }}?{{ mt_rand() }}" alt="Captcha code">
                            <button class="refresh-button" id="refresh-captcha" type="button">Refresh</button>
                        </div>
                        <input class="captcha-input" id="captcha_token" type="text" name="captcha_token" placeholder="Enter code" maxlength="4" minlength="4" autocomplete="off" required>
                        <p class="captcha-error is-hidden" id="captcha-error" role="alert">Captcha invalid. Please try again.</p>
                    </div>

                    <button class="submit-button" id="submit-button" type="submit">Submit registration</button>
                </form>
            </section>
        </div>

        @if ($accounts->isNotEmpty())
            <section class="services-section">
                <div class="section-heading">
                    <h2>Our services</h2>
                    <p>Choose the account that matches your game.</p>
                </div>
                <div class="service-grid">
                    @foreach ($accounts as $account)
                        @if ($account->game_url)
                            <a class="service-card" href="{{ $account->game_url }}" target="_blank" rel="noopener">
                        @else
                            <div class="service-card">
                        @endif
                            @if ($account->image)
                                <img src="{{ asset('public/uploads/'.$account->image) }}" alt="{{ $account->name }}">
                            @else
                                <div class="service-placeholder" aria-hidden="true">{{ strtoupper(substr($account->name, 0, 1)) }}</div>
                            @endif
                            <strong>{{ $account->name }}</strong>
                        @if ($account->game_url)
                            </a>
                        @else
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('regForm');
            const account = document.getElementById('account');
            const gameId = document.getElementById('game_id');
            const timeZone = document.getElementById('time_zone');
            const captchaImage = document.getElementById('captcha_image');
            const captchaInput = document.getElementById('captcha_token');
            const captchaError = document.getElementById('captcha-error');
            const refreshButton = document.getElementById('refresh-captcha');
            const submitButton = document.getElementById('submit-button');
            const captchaUrl = @json(url('captcha_image.php'));
            const checkCaptchaUrl = @json(route('checkCaptcha'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            if (timeZone && !timeZone.value) {
                timeZone.value = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
            }

            account.addEventListener('change', function () {
                const title = account.options[account.selectedIndex]?.dataset.title;
                if (title) {
                    gameId.value = title + '_';
                    gameId.focus();
                }
            });

            refreshButton.addEventListener('click', function () {
                captchaImage.src = captchaUrl + '?' + Date.now();
                captchaInput.value = '';
                captchaError.classList.add('is-hidden');
            });

            captchaInput.addEventListener('input', function () {
                captchaError.classList.add('is-hidden');
            });

            form.addEventListener('submit', async function (event) {
                if (!form.reportValidity()) return;
                event.preventDefault();
                submitButton.disabled = true;

                try {
                    const response = await fetch(checkCaptchaUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ captcha: captchaInput.value }),
                    });
                    const result = await response.json();

                    if (result === true || result === 'true') {
                        HTMLFormElement.prototype.submit.call(form);
                        return;
                    }

                    captchaError.classList.remove('is-hidden');
                    captchaInput.focus();
                    captchaImage.src = captchaUrl + '?' + Date.now();
                } catch (error) {
                    captchaError.textContent = 'Could not verify the captcha. Please try again.';
                    captchaError.classList.remove('is-hidden');
                }

                submitButton.disabled = false;
            });
        });
    </script>
@endsection
