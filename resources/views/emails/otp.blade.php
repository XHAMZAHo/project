<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Verification Code | ELEVA TECH</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: #080d1e; font-family: 'Inter', Arial, sans-serif; -webkit-font-smoothing: antialiased; }
  .wrapper { max-width: 600px; margin: 0 auto; padding: 40px 20px; }

  /* Header */
  .header { text-align: center; margin-bottom: 32px; }
  .logo-box {
    display: inline-flex; align-items: center; gap: 10px;
    background: #0f1629; border: 1px solid rgba(26,86,240,0.3);
    border-radius: 14px; padding: 12px 24px; margin-bottom: 20px;
  }
  .logo-text { font-size: 22px; font-weight: 900; letter-spacing: 0.1em; color: #3b82f6; }
  .logo-dot  { width: 8px; height: 8px; border-radius: 50%; background: #1a56f0; }

  /* Main card */
  .card {
    background: linear-gradient(145deg, #0c1228, #0f1834);
    border: 1px solid rgba(26,86,240,0.2);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.5);
  }

  /* Card top bar */
  .card-bar {
    height: 4px;
    background: linear-gradient(90deg, #1241c0, #1a56f0, #3b82f6, #60a5fa);
  }

  .card-body { padding: 48px 48px 40px; }

  /* Shield icon */
  .shield-wrap {
    width: 72px; height: 72px; border-radius: 20px; margin: 0 auto 28px;
    background: linear-gradient(135deg, rgba(26,86,240,0.15), rgba(59,130,246,0.08));
    border: 1px solid rgba(26,86,240,0.25);
    display: flex; align-items: center; justify-content: center;
  }
  .shield-wrap svg { width: 36px; height: 36px; }

  /* Text */
  .greeting { font-size: 24px; font-weight: 700; color: #f1f5f9; margin-bottom: 12px; text-align: center; }
  .subtitle  { font-size: 15px; color: #94a3b8; line-height: 1.7; text-align: center; margin-bottom: 36px; }

  /* OTP box */
  .otp-section { text-align: center; margin-bottom: 36px; }
  .otp-label { font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: #475569; text-transform: uppercase; margin-bottom: 16px; }
  .otp-box {
    display: inline-block;
    background: linear-gradient(135deg, rgba(26,86,240,0.12), rgba(59,130,246,0.06));
    border: 2px solid rgba(26,86,240,0.4);
    border-radius: 18px;
    padding: 20px 40px;
    position: relative;
  }
  .otp-code {
    font-size: 48px; font-weight: 800; letter-spacing: 0.25em;
    background: linear-gradient(135deg, #60a5fa, #3b82f6, #1a56f0);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; display: block;
  }
  .otp-glow {
    position: absolute; inset: 0; border-radius: 18px;
    box-shadow: 0 0 40px rgba(26,86,240,0.15);
    pointer-events: none;
  }
  .expiry-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25);
    border-radius: 100px; padding: 6px 14px;
    font-size: 12px; color: #f59e0b; font-weight: 600; margin-top: 14px;
  }

  /* Divider */
  .divider { height: 1px; background: rgba(26,86,240,0.1); margin: 32px 0; }

  /* Info row */
  .info-row { display: flex; gap: 16px; margin-bottom: 28px; }
  .info-card {
    flex: 1; background: rgba(26,86,240,0.05); border: 1px solid rgba(26,86,240,0.12);
    border-radius: 14px; padding: 16px; text-align: center;
  }
  .info-card-icon { font-size: 20px; margin-bottom: 8px; }
  .info-card-title { font-size: 12px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px; }
  .info-card-desc  { font-size: 11px; color: #64748b; line-height: 1.5; }

  /* Security note */
  .security-note {
    background: rgba(248,113,113,0.06); border: 1px solid rgba(248,113,113,0.15);
    border-radius: 14px; padding: 16px 20px;
    display: flex; gap: 12px; align-items: flex-start; margin-bottom: 28px;
  }
  .security-note svg { flex-shrink: 0; margin-top: 1px; }
  .security-note p { font-size: 12.5px; color: #94a3b8; line-height: 1.6; }
  .security-note strong { color: #f87171; }

  /* Footer */
  .footer { text-align: center; padding: 28px 48px; border-top: 1px solid rgba(26,86,240,0.08); }
  .footer p { font-size: 12px; color: #475569; line-height: 1.7; }
  .footer a { color: #3b82f6; text-decoration: none; }
  .copyright { margin-top: 20px; font-size: 11px; color: #334155; }

  @media (max-width: 520px) {
    .card-body { padding: 32px 24px 28px; }
    .otp-code { font-size: 36px; }
    .info-row { flex-direction: column; }
    .footer { padding: 24px 24px; }
  }
</style>
</head>
<body>
<div class="wrapper">

  <!-- Logo header -->
  <div class="header">
    <div class="logo-box">
      <div class="logo-dot"></div>
      <span class="logo-text">ELEVA TECH</span>
      <div class="logo-dot"></div>
    </div>
  </div>

  <!-- Main card -->
  <div class="card">
    <div class="card-bar"></div>
    <div class="card-body">

      <!-- Shield icon -->
      <div class="shield-wrap">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L3.5 5.5V11C3.5 15.8 7.2 20.3 12 21.5C16.8 20.3 20.5 15.8 20.5 11V5.5L12 2Z" stroke="#3b82f6" stroke-width="1.5" stroke-linejoin="round"/>
          <path d="M9 12L11 14L15 10" stroke="#60a5fa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <!-- Text -->
      <h1 class="greeting">Verify Your Email Address</h1>
      <p class="subtitle">
        Hello, <strong style="color:#e2e8f0;">{{ $user->name }}</strong>! 👋<br>
        Use the code below to complete your ELEVA TECH account verification.
      </p>

      <!-- OTP -->
      <div class="otp-section">
        <div class="otp-label">Your One-Time Password</div>
        <div class="otp-box">
          <span class="otp-code">{{ $otp }}</span>
          <div class="otp-glow"></div>
        </div>
        <br>
        <span class="expiry-badge">
          ⏱ Expires in {{ $expiryMinutes }} minutes
        </span>
      </div>

      <div class="divider"></div>

      <!-- Info cards -->
      <div class="info-row">
        <div class="info-card">
          <div class="info-card-icon">🔒</div>
          <div class="info-card-title">Secure</div>
          <div class="info-card-desc">This code is encrypted and one-time use only</div>
        </div>
        <div class="info-card">
          <div class="info-card-icon">⚡</div>
          <div class="info-card-title">Fast</div>
          <div class="info-card-desc">Enter this code within {{ $expiryMinutes }} minutes</div>
        </div>
        <div class="info-card">
          <div class="info-card-icon">🛡️</div>
          <div class="info-card-title">Protected</div>
          <div class="info-card-desc">Limited attempts to prevent abuse</div>
        </div>
      </div>

      <!-- Security warning -->
      <div class="security-note">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#f87171" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <p>
          <strong>Never share this code with anyone.</strong> ELEVA TECH will never ask you for your OTP.
          If you did not request this code, please ignore this email — your account is safe.
        </p>
      </div>

    </div><!-- /.card-body -->

    <!-- Footer -->
    <div class="footer">
      <p>
        This email was sent to <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br>
        because a new account was created on <strong style="color:#cbd5e1;">ELEVA TECH</strong>.
      </p>
      <p class="copyright">
        &copy; {{ date('Y') }} ELEVA TECH · All rights reserved<br>
        <a href="#">Privacy Policy</a> &nbsp;·&nbsp; <a href="#">Terms of Service</a>
      </p>
    </div>

  </div><!-- /.card -->

</div><!-- /.wrapper -->
</body>
</html>
