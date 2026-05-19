<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __('Login') }} | ELEVA TECH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{ font-family:{{ app()->getLocale()==='ar'?"'Cairo'":"'Inter'" }},sans-serif; }
body{background:#03040e;min-height:100vh;display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;}

/* Animated BG */
.orb{position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;}
.orb1{width:600px;height:600px;background:radial-gradient(circle,rgba(26,86,240,0.16),transparent);top:-200px;left:-200px;animation:fl1 9s ease-in-out infinite;}
.orb2{width:500px;height:500px;background:radial-gradient(circle,rgba(18,65,192,0.1),transparent);bottom:-200px;right:-200px;animation:fl2 11s ease-in-out infinite;}
@keyframes fl1{0%,100%{transform:translate(0,0);}50%{transform:translate(50px,40px);}}
@keyframes fl2{0%,100%{transform:translate(0,0);}50%{transform:translate(-40px,-50px);}}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(26,86,240,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(26,86,240,0.04) 1px,transparent 1px);background-size:55px 55px;z-index:0;}

.wrapper{position:relative;z-index:10;width:100%;max-width:480px;padding:20px;}

.card{background:rgba(8,13,30,0.88);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(26,86,240,0.22);border-radius:28px;padding:48px 40px;box-shadow:0 30px 80px rgba(0,0,0,0.6),inset 0 1px 0 rgba(255,255,255,0.04),0 0 0 1px rgba(26,86,240,0.05);}

/* Logo */
.logo-area{display:flex;flex-direction:column;align-items:center;margin-bottom:32px;}
.logo-wrap{
    display:flex;align-items:center;justify-content:center;
    transition:all .3s;
}
/* invert(1) = black→white | hue-rotate(180deg) = blue stays blue */
.logo-img{height:46px;width:auto;filter:invert(1) hue-rotate(180deg);transition:filter .3s;}
.logo-title{font-size:20px;font-weight:900;letter-spacing:.1em;background:linear-gradient(135deg,#fff,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;display:none;} /* Hidden as logo contains text */
.logo-sub{font-size:11.5px;color:#475569;margin-top:4px;letter-spacing:.08em;}

/* Light mode */
html.light body{background:#f0f4ff;}
html.light .card{background:rgba(255,255,255,0.95);border-color:rgba(26,86,240,0.15);box-shadow:0 20px 60px rgba(26,86,240,0.08);}
html.light .logo-wrap{background:#fff;border-color:rgba(26,86,240,0.12);}
html.light .logo-img{filter:none;mix-blend-mode:normal;}
html.light .logo-title{background:linear-gradient(135deg,#0f172a,#1a56f0);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
html.light .form-input{background:rgba(26,86,240,0.04);border-color:rgba(26,86,240,0.15);color:#0f172a;}
html.light .form-input::placeholder{color:#94a3b8;}
html.light .form-label{color:#334155;}
html.light .remember{color:#475569;}
html.light .back-link{color:#64748b;}
html.light .back-link:hover{color:#0f172a;}
html.light .lang-opt{color:#475569;}
html.light .tab-btn{color:#475569;}
html.light .tab-btn:not(.active):hover{color:#1e293b;}
html.light .status-ok{background:rgba(16,185,129,0.08);}

/* Mode toggle button (floating) */
.mode-toggle-btn{
    position:fixed;top:18px;
    inset-inline-end:18px;
    width:40px;height:40px;
    border-radius:11px;
    background:rgba(26,86,240,0.1);
    border:1px solid rgba(26,86,240,0.2);
    color:#94a3b8;
    font-size:15px;
    cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:all .25s;
    z-index:200;
}
.mode-toggle-btn:hover{background:rgba(26,86,240,0.2);color:#3b82f6;}
html.light .mode-toggle-btn{background:rgba(255,255,255,0.9);border-color:rgba(26,86,240,0.2);color:#475569;}

/* Tab switcher */
.tab-row{display:flex;background:rgba(26,86,240,0.07);border:1px solid rgba(26,86,240,0.15);border-radius:14px;padding:4px;margin-bottom:28px;}
.tab-btn{flex:1;padding:10px;border-radius:10px;border:none;background:transparent;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:7px;}
.tab-btn.active{background:linear-gradient(135deg,#1241c0,#1a56f0);color:#fff;box-shadow:0 4px 20px rgba(26,86,240,0.4);}
.tab-btn:not(.active):hover{color:#e2e8f0;}

/* Form */
.form-group{margin-bottom:18px;}
.form-label{display:block;font-size:12.5px;font-weight:600;color:#94a3b8;margin-bottom:8px;}
.input-wrap{position:relative;}
.input-icon{position:absolute;top:50%;transform:translateY(-50%);color:#475569;font-size:13px;pointer-events:none;}
[dir="ltr"] .input-icon{left:14px;}
[dir="rtl"] .input-icon{right:14px;}
.form-input{width:100%;background:rgba(26,86,240,0.07);border:1px solid rgba(26,86,240,0.2);border-radius:12px;padding:13px 16px;color:#e2e8f0;font-size:14px;font-family:inherit;outline:none;transition:all .25s;}
[dir="ltr"] .form-input.has-icon{padding-left:40px;}
[dir="rtl"] .form-input.has-icon{padding-right:40px;}
.form-input:focus{border-color:#1a56f0;background:rgba(26,86,240,0.12);box-shadow:0 0 0 3px rgba(26,86,240,0.12);}
.form-input::placeholder{color:#374151;}
.err{color:#f87171;font-size:11.5px;margin-top:5px;display:flex;align-items:center;gap:4px;}

.form-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;margin-top:4px;}
.remember{display:flex;align-items:center;gap:7px;font-size:12.5px;color:#64748b;cursor:pointer;}
.remember input{accent-color:#1a56f0;}
.forgot{font-size:12.5px;color:#3b82f6;text-decoration:none;transition:color .2s;}
.forgot:hover{color:#60a5fa;}

.btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#1241c0,#1a56f0,#3b82f6);color:#fff;font-size:14.5px;font-weight:700;font-family:inherit;border:none;border-radius:13px;cursor:pointer;box-shadow:0 0 28px rgba(26,86,240,0.45);transition:all .3s;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-submit:hover{box-shadow:0 0 50px rgba(26,86,240,0.7);transform:translateY(-2px);}
.btn-submit:active{transform:translateY(0);}

.status-ok{background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);border-radius:10px;padding:10px 14px;color:#34d399;font-size:12.5px;margin-bottom:18px;}

/* Lang bar */
.lang-bar{display:flex;justify-content:center;margin-bottom:22px;}
.lang-toggle{display:flex;background:rgba(26,86,240,0.08);border:1px solid rgba(26,86,240,0.18);border-radius:100px;overflow:hidden;}
.lang-opt{padding:7px 18px;font-size:12px;font-weight:600;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:5px;transition:all .2s;}
.lang-opt.on{background:linear-gradient(135deg,rgba(26,86,240,0.5),rgba(59,130,246,0.3));color:#fff;}

.back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:18px;font-size:12.5px;color:#475569;text-decoration:none;transition:color .2s;}
.back-link:hover{color:#e2e8f0;}

@media(max-width:500px){.card{padding:32px 22px;}}
</style>
</head>
<body>
<!-- Dark/Light Mode Toggle -->
<button class="mode-toggle-btn" onclick="toggleLoginMode()" id="login-mode-btn" title="Toggle Mode">
    <i id="login-mode-icon" class="fas fa-moon"></i>
</button>
<div class="orb orb1"></div>
<div class="orb orb2"></div>

<div class="wrapper">
    {{-- Language --}}
    <div class="lang-bar">
        <div class="lang-toggle">
            <a href="{{ route('lang.switch','ar') }}" class="lang-opt {{ app()->getLocale()==='ar'?'on':'' }}">
                <i class="fas fa-globe" style="font-size:10px;"></i> العربية
            </a>
            <a href="{{ route('lang.switch','en') }}" class="lang-opt {{ app()->getLocale()==='en'?'on':'' }}">
                <i class="fas fa-globe" style="font-size:10px;"></i> English
            </a>
        </div>
    </div>

    <div class="card">
        {{-- Logo --}}
        <div class="logo-area">
            <a href="{{ route('home') }}" style="display:flex;flex-direction:column;align-items:center;text-decoration:none;">
                <div class="logo-wrap">
                    <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH" class="logo-img">
                </div>
                <div class="logo-title">ELEVA TECH</div>
                <div class="logo-sub" id="login-subtitle">
                    {{ app()->getLocale()==='ar'?'تسجيل دخول العملاء':'Client Login' }}
                </div>
            </a>
        </div>

        {{-- Tab Switcher --}}
        <div class="tab-row">
            <button class="tab-btn active" id="tab-client" onclick="switchTab('client')">
                <i class="fas fa-user" style="font-size:11px;"></i>
                {{ app()->getLocale()==='ar'?'العميل':'Client' }}
            </button>
            <button class="tab-btn" id="tab-admin" onclick="switchTab('admin')">
                <i class="fas fa-shield-alt" style="font-size:11px;"></i>
                {{ app()->getLocale()==='ar'?'الأدمن':'Admin' }}
            </button>
        </div>

        @if(session('status'))
            <div class="status-ok"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf
            <input type="hidden" name="login_type" id="login_type" value="client">

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    {{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }}
                </label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-input has-icon"
                           placeholder="you@example.com"
                           required autofocus autocomplete="username" dir="ltr">
                </div>
                @error('email')<p class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">
                    {{ app()->getLocale()==='ar'?'كلمة المرور':'Password' }}
                </label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" type="password" name="password"
                           class="form-input has-icon" placeholder="••••••••"
                           required autocomplete="current-password" dir="ltr">
                </div>
                @error('password')<p class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="form-row">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember_me">
                    {{ app()->getLocale()==='ar'?'تذكرني':'Remember me' }}
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">
                    {{ app()->getLocale()==='ar'?'نسيت كلمة المرور؟':'Forgot password?' }}
                </a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i>
                {{ app()->getLocale()==='ar'?'تسجيل الدخول':'Log In' }}
            </button>
        </form>

        {{-- Register Link --}}
        @if(Route::has('register'))
        <p style="text-align:center;margin-top:18px;font-size:12.5px;color:#475569;">
            {{ app()->getLocale()==='ar'?'ليس لديك حساب؟':'Don\'t have an account?' }}
            <a href="{{ route('register') }}" style="color:#3b82f6;text-decoration:none;font-weight:600;">
                {{ app()->getLocale()==='ar'?'إنشاء حساب':'Sign up' }}
            </a>
        </p>
        @endif
    </div>

    <a href="{{ route('home') }}" class="back-link">
        <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'right':'left' }}"></i>
        {{ app()->getLocale()==='ar'?'العودة للموقع':'Back to website' }}
    </a>
</div>

<script>
const IS_AR = '{{ app()->getLocale() }}' === 'ar';

// ── Login mode toggle ──
(function(){
    const saved = localStorage.getItem('et-login-mode');
    if (saved === 'light') document.documentElement.classList.add('light');
    updateLoginModeIcon();
})();
function toggleLoginMode() {
    const isLight = document.documentElement.classList.toggle('light');
    localStorage.setItem('et-login-mode', isLight ? 'light' : 'dark');
    updateLoginModeIcon();
}
function updateLoginModeIcon() {
    const isLight = document.documentElement.classList.contains('light');
    const icon = document.getElementById('login-mode-icon');
    if (icon) icon.className = isLight ? 'fas fa-sun' : 'fas fa-moon';
}

// ── Tab Switcher ──
function switchTab(type) {
    document.getElementById('tab-client').classList.toggle('active', type === 'client');
    document.getElementById('tab-admin').classList.toggle('active', type === 'admin');
    document.getElementById('login_type').value = type;
    document.getElementById('login-subtitle').textContent =
        type === 'client'
            ? (IS_AR ? 'تسجيل دخول العملاء' : 'Client Login')
            : (IS_AR ? 'لوحة تحكم الأدمن' : 'Admin Control Panel');
}
</script>
</body>
</html>
