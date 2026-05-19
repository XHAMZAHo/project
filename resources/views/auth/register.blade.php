<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __('Register') }} | ELEVA TECH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{ font-family:{{ app()->getLocale()==='ar'?"'Cairo'":"'Inter'" }},sans-serif; }
body{background:#03040e;min-height:100vh;display:flex;align-items:center;justify-content:center;overflow-x:hidden;position:relative;padding:20px 0;}

/* Animated BG */
.orb{position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;}
.orb1{width:600px;height:600px;background:radial-gradient(circle,rgba(26,86,240,0.16),transparent);top:-200px;left:-200px;animation:fl1 9s ease-in-out infinite;}
.orb2{width:500px;height:500px;background:radial-gradient(circle,rgba(18,65,192,0.1),transparent);bottom:-200px;right:-200px;animation:fl2 11s ease-in-out infinite;}
.orb3{width:350px;height:350px;background:radial-gradient(circle,rgba(59,130,246,0.08),transparent);top:50%;left:50%;transform:translate(-50%,-50%);animation:fl1 14s ease-in-out infinite reverse;}
@keyframes fl1{0%,100%{transform:translate(0,0);}50%{transform:translate(50px,40px);}}
@keyframes fl2{0%,100%{transform:translate(0,0);}50%{transform:translate(-40px,-50px);}}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(26,86,240,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(26,86,240,0.04) 1px,transparent 1px);background-size:55px 55px;z-index:0;}

.wrapper{position:relative;z-index:10;width:100%;max-width:520px;padding:20px;}

.card{background:rgba(8,13,30,0.88);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(26,86,240,0.22);border-radius:28px;padding:44px 40px;box-shadow:0 30px 80px rgba(0,0,0,0.6),inset 0 1px 0 rgba(255,255,255,0.04),0 0 0 1px rgba(26,86,240,0.05);}

/* Logo */
.logo-area{display:flex;flex-direction:column;align-items:center;margin-bottom:28px;}
.logo-wrap{
    display:flex;align-items:center;justify-content:center;
    transition:all .3s;
}
.logo-img{height:46px;width:auto;filter:invert(1) hue-rotate(180deg);transition:filter .3s;}
.logo-title{font-size:20px;font-weight:900;letter-spacing:.1em;background:linear-gradient(135deg,#fff,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;display:none;}
.logo-sub{font-size:11.5px;color:#475569;margin-top:4px;letter-spacing:.08em;}

/* Header badge */
.register-badge{display:flex;align-items:center;justify-content:center;gap:8px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);border-radius:100px;padding:6px 16px;font-size:12px;color:#3b82f6;font-weight:600;margin-bottom:22px;width:fit-content;margin-inline:auto;}

/* Form */
.form-group{margin-bottom:16px;}
.form-label{display:block;font-size:12.5px;font-weight:600;color:#94a3b8;margin-bottom:7px;}
.input-wrap{position:relative;}
.input-icon{position:absolute;top:50%;transform:translateY(-50%);color:#475569;font-size:13px;pointer-events:none;}
[dir="ltr"] .input-icon{left:14px;}
[dir="rtl"] .input-icon{right:14px;}
.form-input{width:100%;background:rgba(26,86,240,0.07);border:1px solid rgba(26,86,240,0.2);border-radius:12px;padding:12px 16px;color:#e2e8f0;font-size:14px;font-family:inherit;outline:none;transition:all .25s;}
[dir="ltr"] .form-input.has-icon{padding-left:40px;}
[dir="rtl"] .form-input.has-icon{padding-right:40px;}
.form-input:focus{border-color:#1a56f0;background:rgba(26,86,240,0.12);box-shadow:0 0 0 3px rgba(26,86,240,0.12);}
.form-input::placeholder{color:#374151;}
.err{color:#f87171;font-size:11.5px;margin-top:5px;display:flex;align-items:center;gap:4px;}

/* Password strength */
.pw-strength{margin-top:7px;display:flex;gap:4px;align-items:center;}
.pw-bar{height:3px;flex:1;border-radius:3px;background:rgba(26,86,240,0.1);transition:all .3s;}
.pw-bar.weak{background:#f87171;}
.pw-bar.medium{background:#f59e0b;}
.pw-bar.strong{background:#34d399;}
.pw-label{font-size:11px;color:#64748b;min-width:50px;text-align:end;}

/* Eye toggle */
.eye-toggle{position:absolute;top:50%;transform:translateY(-50%);color:#475569;font-size:13px;cursor:pointer;transition:color .2s;background:none;border:none;padding:0;}
[dir="ltr"] .eye-toggle{right:14px;}
[dir="rtl"] .eye-toggle{left:14px;}
.eye-toggle:hover{color:#3b82f6;}

/* Two column row */
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}

/* Divider */
.divider{display:flex;align-items:center;gap:12px;margin:18px 0;color:#374151;font-size:11.5px;}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:rgba(26,86,240,0.12);}

/* Terms */
.terms-row{display:flex;align-items:flex-start;gap:8px;margin-bottom:18px;}
.terms-row input[type="checkbox"]{accent-color:#1a56f0;margin-top:2px;flex-shrink:0;}
.terms-row label{font-size:12px;color:#64748b;line-height:1.6;}
.terms-row a{color:#3b82f6;text-decoration:none;}
.terms-row a:hover{color:#60a5fa;}

/* Submit */
.btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#1241c0,#1a56f0,#3b82f6);color:#fff;font-size:14.5px;font-weight:700;font-family:inherit;border:none;border-radius:13px;cursor:pointer;box-shadow:0 0 28px rgba(26,86,240,0.45);transition:all .3s;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-submit:hover{box-shadow:0 0 50px rgba(26,86,240,0.7);transform:translateY(-2px);}
.btn-submit:active{transform:translateY(0);}
.btn-submit:disabled{opacity:0.6;cursor:not-allowed;transform:none;}

/* Benefits */
.benefits{display:flex;gap:16px;margin-bottom:22px;flex-wrap:wrap;}
.benefit-item{display:flex;align-items:center;gap:6px;font-size:11.5px;color:#64748b;}
.benefit-item i{color:#34d399;font-size:10px;}

/* Lang bar */
.lang-bar{display:flex;justify-content:center;margin-bottom:22px;}
.lang-toggle{display:flex;background:rgba(26,86,240,0.08);border:1px solid rgba(26,86,240,0.18);border-radius:100px;overflow:hidden;}
.lang-opt{padding:7px 18px;font-size:12px;font-weight:600;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:5px;transition:all .2s;}
.lang-opt.on{background:linear-gradient(135deg,rgba(26,86,240,0.5),rgba(59,130,246,0.3));color:#fff;}

.back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:18px;font-size:12.5px;color:#475569;text-decoration:none;transition:color .2s;}
.back-link:hover{color:#e2e8f0;}

/* Steps indicator */
.steps{display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:24px;}
.step-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;transition:all .3s;}
.step-dot.active{background:linear-gradient(135deg,#1241c0,#1a56f0);color:#fff;box-shadow:0 0 12px rgba(26,86,240,0.5);}
.step-dot.done{background:rgba(52,211,153,0.2);color:#34d399;border:1px solid rgba(52,211,153,0.3);}
.step-dot.pending{background:rgba(26,86,240,0.08);color:#475569;border:1px solid rgba(26,86,240,0.15);}
.step-line{width:40px;height:2px;background:rgba(26,86,240,0.12);}
.step-line.done{background:rgba(52,211,153,0.3);}

/* Mode toggle button */
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
html.light body{background:#f0f4ff;}
html.light .card{background:rgba(255,255,255,0.95);border-color:rgba(26,86,240,0.15);}
html.light .logo-wrap{background:#fff;border-color:rgba(26,86,240,0.12);}
html.light .logo-img{filter:none;}
html.light .form-input{background:rgba(26,86,240,0.04);border-color:rgba(26,86,240,0.15);color:#0f172a;}
html.light .form-label{color:#334155;}
html.light .mode-toggle-btn{background:rgba(255,255,255,0.9);color:#475569;}

@media(max-width:500px){
  .card{padding:30px 20px;}
  .form-row-2{grid-template-columns:1fr;}
}
</style>
</head>
<body>
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>

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
                <div class="logo-sub">
                    {{ app()->getLocale()==='ar'?'إنشاء حساب جديد':'Create New Account' }}
                </div>
            </a>
        </div>

        {{-- Badge --}}
        <div class="register-badge">
            <i class="fas fa-user-plus" style="font-size:10px;"></i>
            {{ app()->getLocale()==='ar'?'انضم إلى عائلة ELEVA TECH':'Join the ELEVA TECH Family' }}
        </div>

        {{-- Benefits --}}
        <div class="benefits">
            <div class="benefit-item">
                <i class="fas fa-check-circle"></i>
                {{ app()->getLocale()==='ar'?'متابعة مشاريعك':'Track Projects' }}
            </div>
            <div class="benefit-item">
                <i class="fas fa-check-circle"></i>
                {{ app()->getLocale()==='ar'?'فواتير إلكترونية':'Digital Invoices' }}
            </div>
            <div class="benefit-item">
                <i class="fas fa-check-circle"></i>
                {{ app()->getLocale()==='ar'?'دعم مباشر':'Direct Support' }}
            </div>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
        <div style="background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);border-radius:12px;padding:12px 16px;margin-bottom:18px;">
            @foreach($errors->all() as $error)
            <p class="err" style="margin:0;"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf

            {{-- Name + Phone row --}}
            <div class="form-row-2">
                {{-- Full Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">
                        {{ app()->getLocale()==='ar'?'الاسم الكامل':'Full Name' }}
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               class="form-input has-icon"
                               placeholder="{{ app()->getLocale()==='ar'?'محمد عبدالله':'John Doe' }}"
                               required autofocus autocomplete="name">
                    </div>
                    @error('name')<p class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label for="phone" class="form-label">
                        {{ app()->getLocale()==='ar'?'رقم الجوال (اختياري)':'Phone (Optional)' }}
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                               class="form-input has-icon"
                               placeholder="+966 5x xxx xxxx"
                               autocomplete="tel" dir="ltr">
                    </div>
                </div>
            </div>

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
                           required autocomplete="username" dir="ltr">
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
                           required autocomplete="new-password" dir="ltr"
                           oninput="checkStrength(this.value)">
                    <button type="button" class="eye-toggle" onclick="togglePw('password','eye1')" tabindex="-1">
                        <i id="eye1" class="fas fa-eye"></i>
                    </button>
                </div>
                {{-- Strength meter --}}
                <div class="pw-strength" id="pw-strength-wrap" style="display:none;">
                    <div class="pw-bar" id="bar1"></div>
                    <div class="pw-bar" id="bar2"></div>
                    <div class="pw-bar" id="bar3"></div>
                    <span class="pw-label" id="pw-label"></span>
                </div>
                @error('password')<p class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    {{ app()->getLocale()==='ar'?'تأكيد كلمة المرور':'Confirm Password' }}
                </label>
                <div class="input-wrap">
                    <i class="fas fa-shield-alt input-icon"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-input has-icon" placeholder="••••••••"
                           required autocomplete="new-password" dir="ltr"
                           oninput="checkMatch()">
                    <button type="button" class="eye-toggle" onclick="togglePw('password_confirmation','eye2')" tabindex="-1">
                        <i id="eye2" class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="err" id="match-err" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ app()->getLocale()==='ar'?'كلمتا المرور غير متطابقتين':'Passwords do not match' }}
                </p>
            </div>

            {{-- Already registered? --}}
            @if(Route::has('login'))
            <p style="text-align:center;font-size:12.5px;color:#475569;margin-bottom:18px;">
                {{ app()->getLocale()==='ar'?'لديك حساب بالفعل؟':'Already have an account?' }}
                <a href="{{ route('login') }}" style="color:#3b82f6;text-decoration:none;font-weight:600;">
                    {{ app()->getLocale()==='ar'?'تسجيل الدخول':'Log In' }}
                </a>
            </p>
            @endif

            <button type="submit" class="btn-submit" id="submit-btn">
                <i class="fas fa-user-plus"></i>
                {{ app()->getLocale()==='ar'?'إنشاء الحساب':'Create Account' }}
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider">
            <span>{{ app()->getLocale()==='ar'?'أو':'or' }}</span>
        </div>

        {{-- WhatsApp CTA --}}
        <a href="https://wa.me/966500000000" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px;
                  background:rgba(37,211,102,0.08);border:1px solid rgba(37,211,102,0.2);border-radius:13px;
                  color:#25d366;font-size:13.5px;font-weight:600;text-decoration:none;
                  transition:all .25s;"
           onmouseover="this.style.background='rgba(37,211,102,0.14)'"
           onmouseout="this.style.background='rgba(37,211,102,0.08)'">
            <i class="fab fa-whatsapp" style="font-size:16px;"></i>
            {{ app()->getLocale()==='ar'?'تواصل معنا عبر واتساب':'Contact us via WhatsApp' }}
        </a>

        <p style="text-align:center;margin-top:14px;font-size:11px;color:#374151;line-height:1.7;">
            {{ app()->getLocale()==='ar'
                ? 'بإنشاء الحساب، أنت توافق على شروط الاستخدام وسياسة الخصوصية'
                : 'By creating an account, you agree to our Terms of Service & Privacy Policy' }}
        </p>
    </div>

    <a href="{{ route('home') }}" class="back-link">
        <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'right':'left' }}"></i>
        {{ app()->getLocale()==='ar'?'العودة للموقع':'Back to website' }}
    </a>
</div>

<script>
const IS_AR = '{{ app()->getLocale() }}' === 'ar';

// Toggle password visibility
function togglePw(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fas fa-eye-slash';
    } else {
        inp.type = 'password';
        ico.className = 'fas fa-eye';
    }
}

// Password strength checker
function checkStrength(val) {
    const wrap = document.getElementById('pw-strength-wrap');
    const label = document.getElementById('pw-label');
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'flex';

    // Reset
    bars.forEach(b => { b.className = 'pw-bar'; });

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val)) score++;

    if (score === 1) {
        bars[0].classList.add('weak');
        label.textContent = IS_AR ? 'ضعيفة' : 'Weak';
        label.style.color = '#f87171';
    } else if (score === 2) {
        bars[0].classList.add('medium'); bars[1].classList.add('medium');
        label.textContent = IS_AR ? 'متوسطة' : 'Medium';
        label.style.color = '#f59e0b';
    } else {
        bars.forEach(b => b.classList.add('strong'));
        label.textContent = IS_AR ? 'قوية' : 'Strong';
        label.style.color = '#34d399';
    }
}

// Match check
function checkMatch() {
    const p1 = document.getElementById('password').value;
    const p2 = document.getElementById('password_confirmation').value;
    const err = document.getElementById('match-err');
    if (p2 && p1 !== p2) {
        err.style.display = 'flex';
    } else {
        err.style.display = 'none';
    }
}

// Submit loading state
document.getElementById('register-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('submit-btn');
    const p1 = document.getElementById('password').value;
    const p2 = document.getElementById('password_confirmation').value;
    if (p1 !== p2) { e.preventDefault(); return; }
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (IS_AR ? 'جارٍ الإنشاء...' : 'Creating...');
});

// Floating label animation
document.querySelectorAll('.form-input').forEach(inp => {
    inp.addEventListener('focus', () => { inp.style.borderColor = '#1a56f0'; });
    inp.addEventListener('blur',  () => { if (!inp.matches(':focus')) inp.style.borderColor = ''; });
});
</script>
</body>
</html>
