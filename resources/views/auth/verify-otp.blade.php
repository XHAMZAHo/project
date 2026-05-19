<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('Verify Email') }} | ELEVA TECH</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{font-family:{{ app()->getLocale()==='ar'?"'Cairo'":"'Inter'" }},sans-serif;}
body{background:#03040e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;position:relative;overflow-x:hidden;}

/* Animated background */
.orb{position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;}
.orb1{width:600px;height:600px;background:radial-gradient(circle,rgba(26,86,240,0.15),transparent);top:-200px;left:-200px;animation:fl1 9s ease-in-out infinite;}
.orb2{width:500px;height:500px;background:radial-gradient(circle,rgba(59,130,246,0.09),transparent);bottom:-200px;right:-200px;animation:fl2 11s ease-in-out infinite;}
@keyframes fl1{0%,100%{transform:translate(0,0);}50%{transform:translate(50px,40px);}}
@keyframes fl2{0%,100%{transform:translate(0,0);}50%{transform:translate(-40px,-50px);}}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(26,86,240,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(26,86,240,0.04) 1px,transparent 1px);background-size:55px 55px;z-index:0;}

.wrapper{position:relative;z-index:10;width:100%;max-width:480px;}

/* Card */
.card{background:rgba(8,13,30,0.9);backdrop-filter:blur(28px);border:1px solid rgba(26,86,240,0.22);border-radius:28px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,0.6);}
.card-bar{height:3px;background:linear-gradient(90deg,#1241c0,#1a56f0,#3b82f6,#60a5fa);}
.card-body{padding:40px 40px 36px;}

/* Logo */
.logo-area{text-align:center;margin-bottom:28px;}
.logo-wrap{display:inline-flex;align-items:center;gap:8px;background:#0f1629;border:1px solid rgba(26,86,240,0.25);border-radius:12px;padding:9px 20px;margin-bottom:10px;}
.logo-text{font-size:18px;font-weight:900;letter-spacing:.1em;background:linear-gradient(135deg,#fff,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

/* Shield icon */
.shield-wrap{width:72px;height:72px;border-radius:20px;margin:0 auto 24px;background:linear-gradient(135deg,rgba(26,86,240,0.15),rgba(59,130,246,0.06));border:1px solid rgba(26,86,240,0.25);display:flex;align-items:center;justify-content:center;animation:pulse-shield 3s ease-in-out infinite;}
@keyframes pulse-shield{0%,100%{box-shadow:0 0 0 0 rgba(26,86,240,0.3);}50%{box-shadow:0 0 0 12px rgba(26,86,240,0);}}

.card-title{font-size:22px;font-weight:800;color:#f1f5f9;text-align:center;margin-bottom:8px;}
.card-sub{font-size:13.5px;color:#64748b;text-align:center;line-height:1.7;margin-bottom:28px;}
.email-highlight{color:#3b82f6;font-weight:600;}

/* Countdown timer */
.timer-box{background:rgba(26,86,240,0.07);border:1px solid rgba(26,86,240,0.18);border-radius:14px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.timer-label{font-size:12px;color:#64748b;font-weight:500;}
.timer-display{display:flex;align-items:center;gap:6px;font-size:18px;font-weight:800;color:#f59e0b;font-variant-numeric:tabular-nums;}
.timer-display.expired{color:#f87171;}
.timer-dot{animation:blink 1s step-end infinite;}
@keyframes blink{50%{opacity:0;}}

/* OTP inputs */
.otp-inputs{display:flex;gap:10px;justify-content:center;margin-bottom:8px;}
.otp-digit{width:52px;height:60px;background:rgba(26,86,240,0.07);border:2px solid rgba(26,86,240,0.2);border-radius:14px;text-align:center;font-size:26px;font-weight:800;color:#e2e8f0;font-family:inherit;outline:none;transition:all .2s;caret-color:#3b82f6;}
.otp-digit:focus{border-color:#1a56f0;background:rgba(26,86,240,0.14);box-shadow:0 0 0 3px rgba(26,86,240,0.15);}
.otp-digit.filled{border-color:rgba(26,86,240,0.5);background:rgba(26,86,240,0.12);}
.otp-digit.error-digit{border-color:rgba(248,113,113,0.6);background:rgba(248,113,113,0.07);animation:shake .4s ease;}
@keyframes shake{0%,100%{transform:translateX(0);}20%,60%{transform:translateX(-5px);}40%,80%{transform:translateX(5px);}}

/* Hidden real input for form submit */
#otp-hidden{display:none;}

/* Error / success / info alerts */
.alert{border-radius:12px;padding:12px 16px;font-size:13px;margin-bottom:16px;display:flex;align-items:flex-start;gap:10px;line-height:1.5;}
.alert-error{background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);color:#fca5a5;}
.alert-success{background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);color:#6ee7b7;}
.alert-info{background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);color:#93c5fd;}

/* Buttons */
.btn-verify{width:100%;padding:14px;background:linear-gradient(135deg,#1241c0,#1a56f0,#3b82f6);color:#fff;font-size:14.5px;font-weight:700;font-family:inherit;border:none;border-radius:13px;cursor:pointer;box-shadow:0 0 28px rgba(26,86,240,0.4);transition:all .3s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:20px;}
.btn-verify:hover{box-shadow:0 0 50px rgba(26,86,240,0.65);transform:translateY(-2px);}
.btn-verify:disabled{opacity:.5;cursor:not-allowed;transform:none;}

.btn-resend{width:100%;padding:11px;background:transparent;border:1px solid rgba(26,86,240,0.2);color:#64748b;font-size:13px;font-weight:600;font-family:inherit;border-radius:12px;cursor:pointer;transition:all .25s;margin-top:12px;}
.btn-resend:hover:not(:disabled){border-color:rgba(26,86,240,0.4);color:#94a3b8;background:rgba(26,86,240,0.06);}
.btn-resend:disabled{opacity:.4;cursor:not-allowed;}

/* Progress dots */
.progress-dots{display:flex;justify-content:center;gap:6px;margin-bottom:24px;}
.dot{width:8px;height:8px;border-radius:50%;}
.dot.done{background:rgba(52,211,153,0.6);}
.dot.active{background:#1a56f0;box-shadow:0 0 8px rgba(26,86,240,0.6);}
.dot.pending{background:rgba(26,86,240,0.15);}

.back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:18px;font-size:12.5px;color:#475569;text-decoration:none;transition:color .2s;}
.back-link:hover{color:#e2e8f0;}

/* Attempt indicator */
.attempts-bar{margin-top:8px;display:flex;gap:4px;justify-content:center;}
.attempt-dot{width:7px;height:7px;border-radius:50%;background:rgba(248,113,113,0.15);transition:background .3s;}
.attempt-dot.used{background:#f87171;}

/* Light mode */
html.light body{background:#f0f4ff;}
html.light .card{background:rgba(255,255,255,0.95);border-color:rgba(26,86,240,0.15);}
html.light .otp-digit{background:rgba(26,86,240,0.04);color:#0f172a;}
html.light .card-title{color:#0f172a;}
html.light .timer-box{background:rgba(26,86,240,0.04);}

@media(max-width:480px){
  .card-body{padding:28px 20px 24px;}
  .otp-digit{width:44px;height:54px;font-size:22px;}
  .otp-inputs{gap:8px;}
}
</style>
</head>
<body>
<div class="orb orb1"></div>
<div class="orb orb2"></div>

<div class="wrapper">
<div class="card">
  <div class="card-bar"></div>
  <div class="card-body">

    {{-- Logo --}}
    <div class="logo-area">
      <a href="{{ route('home') }}" style="text-decoration:none;">
        <div class="logo-wrap">
          <i class="fas fa-bolt" style="color:#3b82f6;font-size:14px;"></i>
          <span class="logo-text">ELEVA TECH</span>
        </div>
      </a>
    </div>

    {{-- Progress dots --}}
    <div class="progress-dots">
      <div class="dot done" title="Registration"></div>
      <div class="dot active" title="Verification"></div>
      <div class="dot pending" title="Dashboard"></div>
    </div>

    {{-- Shield --}}
    <div class="shield-wrap">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
        <path d="M12 2L3.5 5.5V11C3.5 15.8 7.2 20.3 12 21.5C16.8 20.3 20.5 15.8 20.5 11V5.5L12 2Z" stroke="#3b82f6" stroke-width="1.5" stroke-linejoin="round"/>
        <path d="M9 12L11 14L15 10" stroke="#60a5fa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <h1 class="card-title">
      {{ app()->getLocale()==='ar' ? 'تحقق من بريدك الإلكتروني' : 'Verify Your Email' }}
    </h1>
    <p class="card-sub">
      {{ app()->getLocale()==='ar' ? 'أرسلنا رمز تحقق مكون من 6 أرقام إلى' : 'We sent a 6-digit verification code to' }}<br>
      <span class="email-highlight" id="user-email">
        {{ session('pending_otp_email', __('your email address')) }}
      </span>
    </p>

    {{-- Alerts --}}
    @if(session('resent'))
      <div class="alert alert-success">
        <i class="fas fa-check-circle" style="margin-top:2px;flex-shrink:0;"></i>
        <span>{{ session('resent') }}</span>
      </div>
    @endif
    @if(session('info'))
      <div class="alert alert-info">
        <i class="fas fa-info-circle" style="margin-top:2px;flex-shrink:0;"></i>
        <span>{{ session('info') }}</span>
      </div>
    @endif
    @if($errors->any())
      <div class="alert alert-error" id="error-alert">
        <i class="fas fa-exclamation-circle" style="margin-top:2px;flex-shrink:0;"></i>
        <span>{{ $errors->first('otp') }}</span>
      </div>
    @endif

    {{-- Countdown timer --}}
    <div class="timer-box">
      <span class="timer-label">
        <i class="fas fa-clock" style="margin-inline-end:5px;"></i>
        {{ app()->getLocale()==='ar' ? 'ينتهي الرمز خلال' : 'Code expires in' }}
      </span>
      <div class="timer-display" id="timer">
        <span id="timer-min">05</span>
        <span class="timer-dot">:</span>
        <span id="timer-sec">00</span>
      </div>
    </div>

    {{-- OTP Form --}}
    <form method="POST" action="{{ route('otp.verify') }}" id="otp-form">
      @csrf
      <input type="hidden" name="otp" id="otp-hidden">

      {{-- 6 digit boxes --}}
      <div class="otp-inputs" id="otp-inputs">
        @for($i=0;$i<6;$i++)
          <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                 class="otp-digit" id="digit-{{$i}}"
                 autocomplete="{{ $i===0?'one-time-code':'off' }}"
                 @if($i===0) autofocus @endif>
        @endfor
      </div>

      {{-- Attempt indicator dots --}}
      <div class="attempts-bar" id="attempts-bar">
        @for($i=0;$i<5;$i++)
          <div class="attempt-dot" id="attempt-{{$i}}"></div>
        @endfor
      </div>

      <button type="submit" class="btn-verify" id="submit-btn" disabled>
        <i class="fas fa-shield-check"></i>
        {{ app()->getLocale()==='ar' ? 'تحقق من الرمز' : 'Verify Code' }}
      </button>
    </form>

    {{-- Resend form --}}
    <form method="POST" action="{{ route('otp.resend') }}" id="resend-form">
      @csrf
      <button type="submit" class="btn-resend" id="resend-btn" disabled>
        <i class="fas fa-rotate-right"></i>
        <span id="resend-text">
          {{ app()->getLocale()==='ar' ? 'إعادة الإرسال متاحة بعد' : 'Resend available in' }}
          <strong id="resend-countdown">60s</strong>
        </span>
      </button>
    </form>

  </div>{{-- /.card-body --}}
</div>{{-- /.card --}}

<a href="{{ route('register') }}" class="back-link">
  <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'right':'left' }}"></i>
  {{ app()->getLocale()==='ar' ? 'العودة للتسجيل' : 'Back to Registration' }}
</a>
</div>{{-- /.wrapper --}}

<script>
const IS_AR = '{{ app()->getLocale() }}' === 'ar';
const digits = Array.from(document.querySelectorAll('.otp-digit'));
const hiddenInput = document.getElementById('otp-hidden');
const submitBtn  = document.getElementById('submit-btn');
const resendBtn  = document.getElementById('resend-btn');

// ── OTP digit logic ──────────────────────────────────────────────────────
digits.forEach((input, idx) => {
  input.addEventListener('input', (e) => {
    let val = e.target.value.replace(/\D/g,'');
    input.value = val.slice(-1);
    if (val && idx < 5) digits[idx+1].focus();
    syncHidden();
    if (val) input.classList.add('filled');
    else input.classList.remove('filled');
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace') {
      if (!input.value && idx > 0) { digits[idx-1].focus(); digits[idx-1].value=''; digits[idx-1].classList.remove('filled'); }
      syncHidden();
    }
    if (e.key === 'ArrowLeft' && idx > 0) digits[idx-1].focus();
    if (e.key === 'ArrowRight' && idx < 5) digits[idx+1].focus();
  });

  // Paste support
  input.addEventListener('paste', (e) => {
    e.preventDefault();
    const pasted = (e.clipboardData||window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
    pasted.split('').forEach((ch, i) => {
      if (digits[i]) { digits[i].value=ch; digits[i].classList.add('filled'); }
    });
    const nextFocus = Math.min(pasted.length, 5);
    digits[nextFocus].focus();
    syncHidden();
  });
});

function syncHidden() {
  const code = digits.map(d=>d.value).join('');
  hiddenInput.value = code;
  submitBtn.disabled = code.length < 6;
}

// Shake on error
@if($errors->any())
digits.forEach(d => { d.classList.add('error-digit'); d.value=''; });
setTimeout(()=> digits.forEach(d => d.classList.remove('error-digit')), 500);
digits[0].focus();
@endif

// ── Countdown (5 minutes) ────────────────────────────────────────────────
let totalSec = 5 * 60;
const timerEl = document.getElementById('timer');
const minEl   = document.getElementById('timer-min');
const secEl   = document.getElementById('timer-sec');

const timerInterval = setInterval(() => {
  totalSec--;
  if (totalSec < 0) {
    clearInterval(timerInterval);
    timerEl.classList.add('expired');
    minEl.textContent = '00'; secEl.textContent = '00';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-clock"></i> ' + (IS_AR ? 'انتهت صلاحية الرمز' : 'Code Expired');
    return;
  }
  const m = String(Math.floor(totalSec/60)).padStart(2,'0');
  const s = String(totalSec % 60).padStart(2,'0');
  minEl.textContent = m;
  secEl.textContent = s;
}, 1000);

// ── Resend cooldown (60s) ────────────────────────────────────────────────
let resendSec = 60;
const resendText = document.getElementById('resend-countdown');
const resendInterval = setInterval(() => {
  resendSec--;
  if (resendSec <= 0) {
    clearInterval(resendInterval);
    resendBtn.disabled = false;
    resendBtn.querySelector('span').innerHTML =
      IS_AR ? '<i class="fas fa-rotate-right"></i> إعادة إرسال الرمز' : '<i class="fas fa-rotate-right"></i> Resend Code';
    return;
  }
  resendText.textContent = resendSec + 's';
}, 1000);

// ── Submit loading state ─────────────────────────────────────────────────
document.getElementById('otp-form').addEventListener('submit', function() {
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (IS_AR?'جارٍ التحقق...':'Verifying...');
});
document.getElementById('resend-form').addEventListener('submit', function() {
  resendBtn.disabled = true;
  resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (IS_AR?'جارٍ الإرسال...':'Sending...');
});
</script>
</body>
</html>
