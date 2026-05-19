<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>{{ __('Select Language') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{background:#03040a;min-height:100vh;display:flex;align-items:center;justify-content:center;font-family:'Cairo','Inter',sans-serif;}
body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse at 50% 30%,rgba(37,99,235,0.12) 0%,transparent 60%);pointer-events:none;}
.card{background:rgba(11,15,30,0.9);border:1px solid rgba(37,99,235,0.2);border-radius:24px;padding:48px 40px;max-width:440px;width:100%;text-align:center;box-shadow:0 30px 80px rgba(0,0,0,0.5);}
.logo{width:56px;height:56px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:16px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:20px;color:#fff;box-shadow:0 0 30px rgba(37,99,235,0.4);margin:0 auto 16px;}
h2{font-size:22px;font-weight:900;color:#fff;margin-bottom:8px;}
p{font-size:14px;color:#64748b;margin-bottom:36px;line-height:1.6;}
.inv-num{font-size:13px;background:rgba(37,99,235,0.1);border:1px solid rgba(37,99,235,0.3);border-radius:8px;padding:5px 14px;color:#3b82f6;display:inline-block;margin-bottom:28px;font-weight:700;}
.lang-cards{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;}
.lang-card{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:24px 16px;border-radius:16px;border:2px solid rgba(37,99,235,0.2);background:rgba(37,99,235,0.05);cursor:pointer;text-decoration:none;transition:all .25s;}
.lang-card:hover{border-color:#3b82f6;background:rgba(37,99,235,0.15);transform:translateY(-3px);box-shadow:0 12px 40px rgba(37,99,235,0.2);}
.lang-flag{font-size:36px;}
.lang-name{font-size:15px;font-weight:700;color:#fff;}
.lang-dir{font-size:11px;color:#64748b;}
.back-btn{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#64748b;text-decoration:none;transition:color .2s;margin-top:4px;}
.back-btn:hover{color:#e2e8f0;}
</style>
</head>
<body>
<div class="card">
    <div class="logo">ET</div>
    <h2>اختر لغة الفاتورة</h2>
    <p>Select the language for generating the invoice PDF</p>
    <div class="inv-num">{{ $invoice->invoice_number }}</div>
    <div class="lang-cards">
        <a href="{{ route('admin.invoices.pdf', [$invoice, 'lang' => 'ar']) }}" class="lang-card">
            <div class="lang-flag">🇸🇦</div>
            <div class="lang-name">العربية</div>
            <div class="lang-dir">RTL — من اليمين</div>
        </a>
        <a href="{{ route('admin.invoices.pdf', [$invoice, 'lang' => 'en']) }}" class="lang-card">
            <div class="lang-flag">🇺🇸</div>
            <div class="lang-name">English</div>
            <div class="lang-dir">LTR — Left to Right</div>
        </a>
    </div>
    <a href="{{ route('admin.invoices.show', $invoice) }}" class="back-btn">
        <i class="fas fa-arrow-right"></i> العودة للفاتورة / Back to Invoice
    </a>
</div>
</body>
</html>
