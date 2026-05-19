<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | ET ELEVA TECH</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-base:     #03040a;
            --blue:        #2563eb;
            --blue-glow:   #3b82f6;
            --border:      rgba(37,99,235,0.18);
            --bg-card:     rgba(11, 15, 30, 0.7);
        }

        html { font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif; }
        
        body {
            background-color: var(--bg-base);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: absolute;
            top: -20%; left: -10%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 60%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -20%; right: -10%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 60%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), inset 0 0 20px rgba(37,99,235,0.05);
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 24px; color: #fff;
            box-shadow: 0 0 30px rgba(37,99,235,0.4);
            margin-bottom: 16px;
        }

        .brand-text {
            font-size: 20px; font-weight: 800; color: #fff; letter-spacing: 0.05em;
        }

        .lang-switcher {
            position: absolute;
            top: 24px;
            right: {{ app()->getLocale() === 'ar' ? 'auto' : '24px' }};
            left: {{ app()->getLocale() === 'ar' ? '24px' : 'auto' }};
            z-index: 100;
        }

        .lang-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            background: rgba(37,99,235,0.1);
            border: 1px solid var(--border);
            border-radius: 100px;
            color: #e2e8f0; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.2s;
        }
        .lang-btn:hover { background: rgba(37,99,235,0.2); color: #fff; border-color: var(--blue-glow); }
        
        [dir="rtl"] .text-right-rtl { text-align: right; }
    </style>
</head>
<body>

    <!-- Language Switcher -->
    <div class="lang-switcher">
        @if(app()->getLocale() === 'en')
            <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn">
                <i class="fas fa-globe"></i> العربية
            </a>
        @else
            <a href="{{ route('lang.switch', 'en') }}" class="lang-btn">
                <i class="fas fa-globe"></i> English
            </a>
        @endif
    </div>

    <div class="auth-container">
        <div class="logo-container">
            <a href="{{ route('home') }}" style="text-decoration: none; display: flex; flex-direction: column; align-items: center;">
                <div class="logo-icon">ET</div>
                <div class="brand-text">ELEVA TECH</div>
            </a>
            <p style="color: #94a3b8; font-size: 13px; margin-top: 8px;">{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول للوحة الإدارة' : 'Login to Admin Dashboard' }}</p>
        </div>

        <div class="glass-panel">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
