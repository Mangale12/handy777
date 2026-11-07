@extends('newLayout.layouts.newLayout')

@section('title', 'Dashboard')

@section('content')
@php
    $user = auth()->user();
    $isAdmin = strtolower((string) ($user->role ?? '')) === 'admin';
    $canChat = in_array(strtolower((string) ($user->role ?? '')), ['admin', 'cashier'], true);
    $balance = (float) data_get($total, 'load', 0);
    $tip = (float) data_get($total, 'tip', 0);
    $redeem = (float) data_get($total, 'redeem', 0);
    $refer = (float) data_get($total, 'refer', 0);
@endphp

<style>
    .dashboard-page {
        padding: 8px 0 34px;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        min-height: 190px;
        padding: 30px 34px;
        border-radius: 22px;
        background: linear-gradient(135deg, #15274a 0%, #254b9b 56%, #7448f5 100%);
        box-shadow: 0 16px 40px rgba(35, 65, 137, .18);
        color: #fff;
    }

    .dashboard-hero::before,
    .dashboard-hero::after {
        position: absolute;
        border-radius: 50%;
        content: '';
        pointer-events: none;
    }

    .dashboard-hero::before {
        width: 280px;
        height: 280px;
        right: -90px;
        top: -150px;
        background: rgba(255, 255, 255, .11);
    }

    .dashboard-hero::after {
        width: 180px;
        height: 180px;
        right: 120px;
        bottom: -130px;
        background: rgba(255, 255, 255, .08);
    }

    .dashboard-hero-content {
        position: relative;
        z-index: 1;
        max-width: 720px;
    }

    .dashboard-eyebrow {
        margin-bottom: 10px;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .dashboard-hero h1 {
        margin: 0 0 8px;
        color: #fff;
        font-size: clamp(1.75rem, 3vw, 2.45rem);
        font-weight: 700;
    }

    .dashboard-hero p {
        max-width: 560px;
        margin: 0;
        color: rgba(255, 255, 255, .78);
        font-size: 15px;
    }

    .dashboard-hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .dashboard-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 0 16px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 10px;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: background .2s ease, transform .2s ease;
    }

    .dashboard-action:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, .22);
        color: #fff;
    }

    .dashboard-action-primary {
        border-color: #fff;
        background: #fff;
        color: #254b9b;
    }

    .dashboard-action-primary:hover {
        background: #f4f7ff;
        color: #254b9b;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-top: 22px;
    }

    .dashboard-stat-card,
    .dashboard-panel {
        border: 1px solid #e8edf6;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(34, 52, 86, .06);
    }

    .dashboard-stat-card {
        position: relative;
        overflow: hidden;
        min-height: 138px;
        padding: 20px;
    }

    .dashboard-stat-card::after {
        position: absolute;
        width: 90px;
        height: 90px;
        right: -24px;
        bottom: -42px;
        border-radius: 50%;
        background: var(--stat-soft);
        content: '';
    }

    .dashboard-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dashboard-stat-label {
        margin: 0;
        color: #7a8499;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .dashboard-stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--stat-soft);
        color: var(--stat-color);
        font-size: 16px;
    }

    .dashboard-stat-value {
        position: relative;
        z-index: 1;
        margin: 18px 0 0;
        color: #17233d;
        font-size: 25px;
        font-weight: 700;
    }

    .dashboard-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(280px, .8fr);
        gap: 22px;
        margin-top: 22px;
    }

    .dashboard-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 22px;
        border-bottom: 1px solid #edf0f6;
    }

    .dashboard-panel-title {
        margin: 0;
        color: #17233d;
        font-size: 16px;
        font-weight: 700;
    }

    .dashboard-panel-subtitle {
        margin: 4px 0 0;
        color: #8992a5;
        font-size: 12px;
    }

    .dashboard-panel-link {
        color: #315ed8;
        font-size: 12px;
        font-weight: 700;
    }

    .dashboard-panel-link:hover {
        color: #7448f5;
    }

    .dashboard-games {
        padding: 6px 22px 12px;
    }

    .dashboard-game-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f2f7;
    }

    .dashboard-game-row:last-child {
        border-bottom: 0;
    }

    .dashboard-game-info {
        display: flex;
        align-items: center;
        min-width: 0;
        gap: 12px;
    }

    .dashboard-game-mark {
        display: inline-flex;
        flex: 0 0 38px;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #eef3ff;
        color: #315ed8;
        font-size: 14px;
        font-weight: 800;
    }

    .dashboard-game-name {
        overflow: hidden;
        margin: 0;
        color: #25304b;
        font-size: 14px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dashboard-game-status {
        margin: 3px 0 0;
        color: #8b95a8;
        font-size: 11px;
    }

    .dashboard-game-balance {
        flex: 0 0 auto;
        color: #1b8a5a;
        font-size: 13px;
        font-weight: 700;
    }

    .dashboard-empty {
        padding: 28px 0;
        color: #8992a5;
        font-size: 13px;
        text-align: center;
    }

    .dashboard-quick-links {
        display: grid;
        gap: 10px;
        padding: 18px 22px 22px;
    }

    .dashboard-quick-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 14px;
        border: 1px solid #edf0f6;
        border-radius: 12px;
        color: #25304b;
        font-size: 13px;
        font-weight: 600;
        transition: border-color .2s ease, background .2s ease, transform .2s ease;
    }

    .dashboard-quick-link:hover {
        transform: translateX(2px);
        border-color: #cdd9fb;
        background: #f7f9ff;
        color: #315ed8;
    }

    .dashboard-quick-link i:first-child {
        width: 22px;
        color: #315ed8;
        text-align: center;
    }

    @media (max-width: 1199px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .dashboard-page {
            padding-top: 0;
        }

        .dashboard-hero {
            padding: 24px 22px;
            border-radius: 18px;
        }

        .dashboard-main-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 520px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-panel-header,
        .dashboard-games,
        .dashboard-quick-links {
            padding-left: 16px;
            padding-right: 16px;
        }

        .dashboard-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="dashboard-page">
    <section class="dashboard-hero">
        <div class="dashboard-hero-content">
            <div class="dashboard-eyebrow">Control center</div>
            <h1>Welcome back, {{ $user->name ?? 'there' }}.</h1>
            <p>Keep an eye on your platform activity and jump straight to the tools you use most.</p>

            <div class="dashboard-hero-actions">
                @if ($canChat)
                    <a class="dashboard-action dashboard-action-primary" href="{{ route('admin.chat') }}">
                        <i class="fa fa-comments" aria-hidden="true"></i>
                        Open chat
                    </a>
                @endif
                <a class="dashboard-action" href="{{ route('gamers') }}">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    View gamers
                </a>
            </div>
        </div>
    </section>

    <section class="dashboard-stats" aria-label="Dashboard statistics">
        @if ($isAdmin)
            <article class="dashboard-stat-card" style="--stat-color:#315ed8;--stat-soft:#edf2ff;">
                <div class="dashboard-stat-top">
                    <p class="dashboard-stat-label">Total balance</p>
                    <span class="dashboard-stat-icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                </div>
                <p class="dashboard-stat-value">${{ number_format($balance, 2) }}</p>
            </article>

            <article class="dashboard-stat-card" style="--stat-color:#9c5bd6;--stat-soft:#f5edff;">
                <div class="dashboard-stat-top">
                    <p class="dashboard-stat-label">Total tip</p>
                    <span class="dashboard-stat-icon"><i class="fa fa-gift" aria-hidden="true"></i></span>
                </div>
                <p class="dashboard-stat-value">${{ number_format($tip, 2) }}</p>
            </article>

            <article class="dashboard-stat-card" style="--stat-color:#1b8a5a;--stat-soft:#eaf9f1;">
                <div class="dashboard-stat-top">
                    <p class="dashboard-stat-label">Total redeem</p>
                    <span class="dashboard-stat-icon"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                </div>
                <p class="dashboard-stat-value">${{ number_format($redeem, 2) }}</p>
            </article>

            <article class="dashboard-stat-card" style="--stat-color:#dd8a24;--stat-soft:#fff5e7;">
                <div class="dashboard-stat-top">
                    <p class="dashboard-stat-label">Total profit</p>
                    <span class="dashboard-stat-icon"><i class="fa fa-line-chart" aria-hidden="true"></i></span>
                </div>
                <p class="dashboard-stat-value">${{ number_format($balance - $redeem, 2) }}</p>
            </article>

            <article class="dashboard-stat-card" style="--stat-color:#315ed8;--stat-soft:#edf2ff;">
                <div class="dashboard-stat-top">
                    <p class="dashboard-stat-label">Total referral</p>
                    <span class="dashboard-stat-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                </div>
                <p class="dashboard-stat-value">${{ number_format($refer, 2) }}</p>
            </article>
        @endif

        <article class="dashboard-stat-card" style="--stat-color:#e45c74;--stat-soft:#fff0f3;">
            <div class="dashboard-stat-top">
                <p class="dashboard-stat-label">Cloud gamers</p>
                <span class="dashboard-stat-icon"><i class="fa fa-users" aria-hidden="true"></i></span>
            </div>
            <p class="dashboard-stat-value">{{ number_format((int) $formCount) }}</p>
        </article>
    </section>

    <section class="dashboard-main-grid">
        <article class="dashboard-panel">
            <div class="dashboard-panel-header">
                <div>
                    <h2 class="dashboard-panel-title">Active games</h2>
                    <p class="dashboard-panel-subtitle">Currently available game accounts</p>
                </div>
                <a class="dashboard-panel-link" href="{{ route('games') }}">Manage games <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>

            <div class="dashboard-games">
                @forelse ($games as $game)
                    @php
                        $gameName = $game->name ?: ($game->title ?: 'Game');
                        $gameInitial = strtoupper(substr($gameName, 0, 1));
                    @endphp
                    <div class="dashboard-game-row">
                        <div class="dashboard-game-info">
                            <span class="dashboard-game-mark">{{ $gameInitial }}</span>
                            <div>
                                <p class="dashboard-game-name">{{ $gameName }}</p>
                                <p class="dashboard-game-status"><i class="fa fa-circle text-success" aria-hidden="true"></i> Active</p>
                            </div>
                        </div>
                        <span class="dashboard-game-balance">${{ number_format((float) ($game->balance ?? 0), 2) }}</span>
                    </div>
                @empty
                    <div class="dashboard-empty">No active games found.</div>
                @endforelse
            </div>
        </article>

        <article class="dashboard-panel">
            <div class="dashboard-panel-header">
                <div>
                    <h2 class="dashboard-panel-title">Quick actions</h2>
                    <p class="dashboard-panel-subtitle">Get where you need to go</p>
                </div>
            </div>

            <div class="dashboard-quick-links">
                <a class="dashboard-quick-link" href="{{ route('gamers') }}">
                    <span><i class="fa fa-users" aria-hidden="true"></i> Manage gamers</span>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
                <a class="dashboard-quick-link" href="{{ route('games') }}">
                    <span><i class="fa fa-gamepad" aria-hidden="true"></i> Manage games</span>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
                @if ($canChat)
                    <a class="dashboard-quick-link" href="{{ route('admin.chat') }}">
                        <span><i class="fa fa-comments" aria-hidden="true"></i> Open admin chat</span>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </article>
    </section>
</div>
@endsection
