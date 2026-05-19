<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'بوابة العميل') | ELEVA TECH</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:    #020408;
            --bg-nav:     #04070f;
            --bg-card:    #080d1a;
            --bg-card2:   #0c1220;
            --border:     rgba(37,99,235,0.15);
            --border-h:   rgba(37,99,235,0.4);
            --blue:       #2563eb;
            --blue-l:     #3b82f6;
            --blue-glow:  rgba(37,99,235,0.4);
            --text-dim:   #94a3b8;
            --text-muted: #64748b;
            --green:      #10b981;
            --amber:      #f59e0b;
        }

        body {
            background: var(--bg-base);
            color: #e2e8f0;
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif;
            direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
        }

        /* ─── Light Mode Overrides ─── */
        html.light body {
            --bg-base: #f4f7fc;
            --bg-nav: #ffffff;
            --bg-card: #ffffff;
            --bg-card2: #f8fafc;
            --border: rgba(37,99,235,0.12);
            --border-h: rgba(37,99,235,0.3);
            color: #0f172a;
        }
        html.light .header-title, html.light .sidebar-brand-text .title { color: #0f172a; }
        html.light .nav-link { color: #475569; }
        html.light .nav-link:hover { background: rgba(37,99,235,0.06); color: #2563eb; }
        html.light .nav-link.active { color: #fff; }
        html.light .logout-btn { color: #dc2626; }
        html.light .header-user { background: #f8fafc; border-color: rgba(37,99,235,0.15); }
        html.light .header-user .name { color: #0f172a; }
        html.light .sidebar-brand img { filter: none !important; }
        html.light .client-card { box-shadow: 0 4px 20px rgba(0,0,0,0.03); }

        /* ─── Layout ─── */
        .portal-layout { display: flex; height: 100vh; overflow: hidden; }

        /* ─── Sidebar ─── */
        .sidebar {
            width: 260px;
            background: var(--bg-nav);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(37,99,235,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand img { height: 36px; width: auto; object-fit: contain; }
        .sidebar-brand-text .title { font-weight: 800; font-size: 14px; color: #fff; }
        .sidebar-brand-text .sub { font-size: 10px; color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase; margin-top: 2px; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 12px 6px;
            margin-top: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--text-dim);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            position: relative;
        }
        .nav-link:hover {
            background: rgba(37,99,235,0.08);
            color: #fff;
        }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(59,130,246,0.08));
            border: 1px solid rgba(37,99,235,0.3);
            color: #fff;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            right: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--blue-l);
            border-radius: 3px 0 0 3px;
        }
        .nav-link i { width: 18px; text-align: center; font-size: 14px; }
        .nav-badge {
            margin-right: auto;
            background: var(--blue);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 100px;
        }

        .sidebar-footer { padding: 12px; border-top: 1px solid var(--border); }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: #f87171;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            transition: all 0.2s;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.08); }

        /* ─── Main ─── */
        .portal-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

        /* ─── Header ─── */
        .portal-header {
            height: 70px;
            background: rgba(4,7,15,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
        }
        .header-title { font-size: 18px; font-weight: 800; color: #fff; }

        .header-actions { display: flex; align-items: center; gap: 12px; }

        .header-wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: linear-gradient(135deg, rgba(37,211,102,0.15), rgba(37,211,102,0.08));
            border: 1px solid rgba(37,211,102,0.3);
            border-radius: 10px;
            color: #25d366;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.3s;
        }
        .header-wa-btn:hover {
            background: rgba(37,211,102,0.2);
            border-color: rgba(37,211,102,0.5);
            transform: translateY(-1px);
            color: #25d366;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: rgba(37,99,235,0.08);
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .header-user .avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; color: #fff;
        }
        .header-user .name { font-size: 13px; font-weight: 700; color: #fff; }

        /* ─── Content ─── */
        .portal-content { flex: 1; overflow-y: auto; padding: 28px; }

        /* ─── Cards ─── */
        .client-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            transition: border-color 0.3s;
        }
        .client-card:hover { border-color: var(--border-h); }

        /* ─── Buttons ─── */
        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 14px;
            box-shadow: 0 0 20px rgba(37,99,235,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 30px rgba(37,99,235,0.5); color: #fff; }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-dim);
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 13px;
        }
        .btn-secondary:hover { border-color: var(--blue); color: var(--blue-l); }

        /* ─── Status Badges ─── */
        .status-badge { padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .status-paid     { background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.2); }
        .status-pending  { background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }
        .status-active   { background: rgba(37,99,235,0.1);  color: #60a5fa; border: 1px solid rgba(37,99,235,0.2); }
        .status-completed{ background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.2); }
        .status-cancelled{ background: rgba(239,68,68,0.1);  color: #f87171; border: 1px solid rgba(239,68,68,0.2); }

        /* ─── Alerts ─── */
        .alert-success {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.25);
            color: #34d399;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            color: #f87171;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        /* ─── Mobile toggle ─── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .sidebar.open { display: flex; position: fixed; z-index: 100; height: 100vh; }
        }
    </style>
</head>
<body>
<div class="portal-layout">

    {{-- ═══════════════ SIDEBAR ═══════════════ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH"
                 style="filter: invert(1) hue-rotate(180deg);">
            <div class="sidebar-brand-text">
                <div class="title">{{ app()->getLocale() === 'ar' ? 'بوابة العميل' : 'Client Portal' }}</div>
                <div class="sub">ELEVA TECH</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">{{ app()->getLocale() === 'ar' ? 'القائمة الرئيسية' : 'Main Menu' }}</div>

            <a href="{{ route('client.dashboard') }}"
               class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Dashboard' }}
            </a>

            <a href="{{ route('client.projects.index') }}"
               class="nav-link {{ request()->routeIs('client.projects.*') ? 'active' : '' }}">
                <i class="fas fa-rocket"></i> {{ app()->getLocale() === 'ar' ? 'مشاريعي' : 'Projects' }}
            </a>

            <a href="{{ route('client.invoices.index') }}"
               class="nav-link {{ request()->routeIs('client.invoices.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> {{ app()->getLocale() === 'ar' ? 'الفواتير' : 'Invoices' }}
            </a>

            <a href="{{ route('client.messages.index') }}"
               class="nav-link {{ request()->routeIs('client.messages.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> {{ app()->getLocale() === 'ar' ? 'الرسائل' : 'Messages' }}
                @if(isset($unreadMessages) && $unreadMessages > 0)
                    <span class="nav-badge">{{ $unreadMessages }}</span>
                @endif
            </a>

            <a href="{{ route('client.files.index') }}"
               class="nav-link {{ request()->routeIs('client.files.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i> {{ app()->getLocale() === 'ar' ? 'الملفات' : 'Files' }}
            </a>

            <div class="sidebar-section-label" style="margin-top:16px;">{{ app()->getLocale() === 'ar' ? 'الحساب' : 'Account' }}</div>

            <a href="{{ route('client.profile.edit') }}"
               class="nav-link {{ request()->routeIs('client.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> {{ app()->getLocale() === 'ar' ? 'إعدادات الحساب' : 'Settings' }}
            </a>

            <a href="{{ route('home') }}" class="nav-link">
                <i class="fas fa-globe"></i> {{ app()->getLocale() === 'ar' ? 'زيارة الموقع' : 'Visit Site' }}
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════════════ MAIN ═══════════════ --}}
    <main class="portal-main">

        {{-- Header --}}
        <header class="portal-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <button onclick="document.getElementById('sidebar').classList.toggle('open')"
                        style="display:none;background:none;border:none;color:#94a3b8;font-size:18px;cursor:pointer;"
                        id="menu-toggle"><i class="fas fa-bars"></i></button>
                <h1 class="header-title">@yield('page_title', app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard')</h1>
            </div>

            <div class="header-actions">
                {{-- Toggles --}}
                <div style="display:flex;align-items:center;gap:6px;">
                    <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                       class="et-mode-btn" style="text-decoration:none;font-weight:700;font-size:12px;">
                        {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                    </a>
                    <button onclick="toggleMode()" class="et-mode-btn" id="mode-icon-btn">
                        <i id="mode-icon" class="fas fa-moon"></i>
                    </button>
                </div>

                {{-- WhatsApp Request Button --}}
                <a href="https://wa.me/966511946443?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أود تقديم طلب خدمة جديد' : 'Hello, I would like to request a service') }}"
                   target="_blank" class="header-wa-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'طلب خدمة' : 'Request Service' }}</span>
                </a>

                {{-- User Info --}}
                <div class="header-user">
                    <div class="avatar">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="portal-content">

            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script>
    // Mobile menu
    const mq = window.matchMedia('(max-width:768px)');
    function checkMQ(){
        const btn = document.getElementById('menu-toggle');
        if(btn) btn.style.display = mq.matches ? 'block' : 'none';
    }
    mq.addListener(checkMQ);
    checkMQ();

    // Dark/Light Mode
    (function () {
        const saved = localStorage.getItem('et-mode');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const useDark = saved === 'dark' || (!saved && prefersDark) || saved === null;
        if (!useDark) document.documentElement.classList.add('light');
    })();

    function toggleMode() {
        const html = document.documentElement;
        const isLight = html.classList.toggle('light');
        localStorage.setItem('et-mode', isLight ? 'light' : 'dark');
        updateModeIcon();
    }

    function updateModeIcon() {
        const isLight = document.documentElement.classList.contains('light');
        const icon = document.getElementById('mode-icon');
        if (icon) {
            icon.className = isLight ? 'fas fa-sun' : 'fas fa-moon';
        }
    }
    document.addEventListener('DOMContentLoaded', updateModeIcon);
</script>
</body>
</html>
