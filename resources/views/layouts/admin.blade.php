<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') | ELEVA TECH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
:root{
    --sb-w:260px; --sb-col:68px;
    --bg-base:#03040e; --bg-nav:#060a14; --bg-card:#080d1e; --bg-card2:#0d1428;
    --et-blue:#1a56f0; --et-glow:#3b82f6;
    --border:rgba(26,86,240,0.16);
    --muted:#64748b; --dim:#94a3b8;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{ font-family:{{ app()->getLocale()==='ar'?"'Cairo'":"'Inter'" }},sans-serif; }
body{background:var(--bg-base);color:#e2e8f0;overflow-x:hidden;}
::-webkit-scrollbar{width:4px;height:4px;}
::-webkit-scrollbar-track{background:var(--bg-nav);}
::-webkit-scrollbar-thumb{background:var(--et-blue);border-radius:4px;}

/* ── SIDEBAR ── */
#adm-sb{
    position:fixed;top:0;left:0;height:100vh;width:var(--sb-w);
    background:var(--bg-nav);border-inline-end:1px solid var(--border);
    display:flex;flex-direction:column;transition:all .3s cubic-bezier(.4,0,.2,1);z-index:1000;overflow:hidden;
}
[dir="rtl"] #adm-sb{left:auto;right:0;}
#adm-sb.col{width:var(--sb-col);}

.sb-logo{display:flex;align-items:center;gap:12px;padding:18px 16px;border-bottom:1px solid var(--border);min-height:72px;white-space:nowrap;}
.sb-logo-wrap{
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
    transition:all .3s;
}
.sb-logo-img{height:36px;width:auto;filter:invert(1) hue-rotate(180deg);}
#adm-sb.col .sb-logo-wrap{opacity:0;width:0;overflow:hidden;padding:0;border:none;}
.sb-badge{background:linear-gradient(135deg,#1241c0,#1a56f0);color:#fff;font-size:9px;font-weight:800;padding:2px 8px;border-radius:100px;letter-spacing:.1em;text-transform:uppercase;transition:opacity .2s;}
#adm-sb.col .sb-badge{opacity:0;width:0;overflow:hidden;}
.sb-et-icon{width:36px;height:36px;background:linear-gradient(135deg,#1241c0,#1a56f0);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:12px;color:#fff;box-shadow:0 0 18px rgba(26,86,240,0.45);flex-shrink:0;}

.sb-nav{flex:1;overflow-y:auto;padding:10px 0;}
.sb-group{font-size:9px;font-weight:700;color:var(--muted);letter-spacing:.15em;text-transform:uppercase;padding:14px 16px 5px;white-space:nowrap;overflow:hidden;transition:opacity .2s;}
#adm-sb.col .sb-group{opacity:0;}

.sb-link{display:flex;align-items:center;gap:11px;padding:9px 16px;margin:2px 8px;border-radius:10px;color:var(--dim);text-decoration:none;font-size:13.5px;font-weight:500;transition:all .2s;white-space:nowrap;position:relative;border:1px solid transparent;}
.sb-link i{width:18px;text-align:center;font-size:14px;flex-shrink:0;}
.sb-link span{overflow:hidden;transition:opacity .2s;}
#adm-sb.col .sb-link span{opacity:0;width:0;overflow:hidden;}
.sb-link:hover{background:rgba(26,86,240,0.1);color:#fff;}
.sb-link.on{background:linear-gradient(135deg,rgba(26,86,240,0.22),rgba(59,130,246,0.08));color:#fff;border-color:rgba(26,86,240,0.28);box-shadow:inset 0 0 20px rgba(26,86,240,0.06);}
.sb-link.on i{color:var(--et-glow);}

.sb-badge-count{margin-inline-start:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;flex-shrink:0;}
#adm-sb.col .sb-badge-count{display:none;}

.sb-foot{padding:10px 8px;border-top:1px solid var(--border);}
.sb-user{display:flex;align-items:center;gap:9px;padding:9px;border-radius:10px;background:rgba(26,86,240,0.05);border:1px solid var(--border);}
.sb-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#1241c0,#1a56f0);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#fff;flex-shrink:0;}
.sb-uinfo{overflow:hidden;transition:opacity .2s;white-space:nowrap;}
.sb-uinfo .n{font-size:12px;font-weight:600;color:#e2e8f0;}
.sb-uinfo .r{font-size:10.5px;color:var(--muted);}
#adm-sb.col .sb-uinfo{opacity:0;width:0;}

/* ── TOPBAR ── */
#adm-top{
    position:fixed;top:0;left:var(--sb-w);right:0;height:72px;
    background:rgba(6,10,20,0.88);backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);
    border-bottom:1px solid var(--border);
    display:flex;align-items:center;padding:0 28px;gap:14px;
    z-index:900;transition:all .3s cubic-bezier(.4,0,.2,1);
}
[dir="rtl"] #adm-top{left:0;right:var(--sb-w);}
#adm-top.col{left:var(--sb-col);}
[dir="rtl"] #adm-top.col{right:var(--sb-col);left:0;}

#sb-toggle{width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;background:rgba(26,86,240,0.08);border:1px solid var(--border);color:var(--dim);cursor:pointer;transition:all .2s;}
#sb-toggle:hover{background:rgba(26,86,240,0.18);color:#fff;}

.top-title{font-size:17px;font-weight:700;color:#fff;flex:1;}
.top-title span{color:var(--et-glow);}

.top-actions{display:flex;align-items:center;gap:9px;}
.top-btn{width:36px;height:36px;border-radius:9px;background:rgba(26,86,240,0.07);border:1px solid var(--border);color:var(--dim);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:all .2s;text-decoration:none;}
.top-btn:hover{background:rgba(26,86,240,0.18);color:#fff;}
.notif-dot{position:absolute;top:6px;right:6px;width:8px;height:8px;background:#ef4444;border-radius:50%;box-shadow:0 0 6px #ef4444;}
.lang-btn-adm{display:flex;align-items:center;gap:5px;padding:7px 13px;border-radius:9px;background:rgba(26,86,240,0.07);border:1px solid var(--border);color:var(--dim);font-size:12px;font-weight:600;text-decoration:none;transition:all .2s;}
.lang-btn-adm:hover{background:rgba(26,86,240,0.18);color:#fff;}

/* Notif dropdown */
.notif-drop{position:absolute;top:50px;right:0;width:310px;background:var(--bg-card2);border:1px solid var(--border);border-radius:14px;box-shadow:0 20px 60px rgba(0,0,0,0.5);display:none;z-index:1100;overflow:hidden;}
[dir="rtl"] .notif-drop{right:auto;left:0;}
.notif-drop.open{display:block;}
.notif-head{padding:13px 16px;border-bottom:1px solid var(--border);font-size:13px;font-weight:700;color:#fff;}
.notif-item{padding:11px 16px;border-bottom:1px solid rgba(26,86,240,0.06);display:flex;gap:11px;align-items:flex-start;}
.notif-item:last-child{border-bottom:none;}
.n-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;margin-top:5px;}
.notif-item p{font-size:12.5px;color:#cbd5e1;line-height:1.5;}
.notif-item time{font-size:11px;color:var(--muted);}

/* ── MAIN ── */
#adm-main{margin-inline-start:var(--sb-w);margin-top:72px;min-height:calc(100vh - 72px);padding:28px;transition:all .3s cubic-bezier(.4,0,.2,1);}
#adm-main.col{margin-inline-start:var(--sb-col);}

/* Cards */
.adm-card{background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:24px;}
.stat-card{background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:22px;position:relative;overflow:hidden;transition:all .3s;}
.stat-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;}
.stat-card.blue::before{background:linear-gradient(90deg,#1a56f0,#3b82f6);}
.stat-card.red::before{background:linear-gradient(90deg,#ef4444,#f97316);}
.stat-card.green::before{background:linear-gradient(90deg,#10b981,#34d399);}
.stat-card.purple::before{background:linear-gradient(90deg,#8b5cf6,#a78bfa);}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 14px 40px rgba(0,0,0,0.4);}
.si{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:19px;margin-bottom:14px;}
.si.blue{background:rgba(26,86,240,0.14);color:#3b82f6;}
.si.red{background:rgba(239,68,68,0.14);color:#f87171;}
.si.green{background:rgba(16,185,129,0.14);color:#34d399;}
.si.purple{background:rgba(139,92,246,0.14);color:#a78bfa;}
.sv{font-size:28px;font-weight:800;color:#fff;line-height:1;}
.sl{font-size:12.5px;color:var(--muted);margin-top:6px;}
.sc{font-size:11px;margin-top:9px;display:flex;align-items:center;gap:4px;}
.sc.up{color:#34d399;} .sc.dn{color:#f87171;}

.sec-head{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:9px;margin-bottom:18px;}
.sec-head .ac{width:4px;height:17px;background:linear-gradient(to bottom,#1a56f0,#3b82f6);border-radius:4px;}

.adm-table{width:100%;border-collapse:collapse;}
.adm-table th{font-size:10.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;padding:9px 13px;border-bottom:1px solid var(--border);text-align:start;}
.adm-table td{padding:12px 13px;border-bottom:1px solid rgba(26,86,240,0.06);font-size:13px;color:#cbd5e1;vertical-align:middle;}
.adm-table tr:last-child td{border-bottom:none;}
.adm-table tr:hover td{background:rgba(26,86,240,0.03);}

.badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:100px;font-size:10.5px;font-weight:600;}
.b-new{background:rgba(26,86,240,0.14);color:#60a5fa;border:1px solid rgba(26,86,240,0.28);}
.b-pend{background:rgba(234,179,8,0.12);color:#fbbf24;border:1px solid rgba(234,179,8,0.24);}
.b-act{background:rgba(16,185,129,0.12);color:#34d399;border:1px solid rgba(16,185,129,0.24);}
.b-done{background:rgba(139,92,246,0.12);color:#a78bfa;border:1px solid rgba(139,92,246,0.24);}
.b-rej{background:rgba(239,68,68,0.12);color:#f87171;border:1px solid rgba(239,68,68,0.24);}

.btn-adm{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;background:linear-gradient(135deg,#1241c0,#1a56f0);color:#fff;font-size:12.5px;font-weight:600;border:none;cursor:pointer;box-shadow:0 0 18px rgba(26,86,240,0.3);transition:all .3s;text-decoration:none;}
.btn-adm:hover{box-shadow:0 0 32px rgba(26,86,240,0.55);transform:translateY(-1px);color:#fff;}
.btn-ghost-adm{display:inline-flex;align-items:center;gap:6px;padding:7px 13px;border-radius:9px;background:transparent;border:1px solid var(--border);color:var(--dim);font-size:12px;cursor:pointer;transition:all .2s;text-decoration:none;}
.btn-ghost-adm:hover{border-color:var(--et-blue);color:var(--et-glow);}

/* Overlay */
#sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:999;}
#sb-overlay.vis{display:block;}

/* Flash */
.flash-ok{background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.28);border-radius:11px;padding:11px 16px;margin-bottom:20px;color:#34d399;font-size:13px;display:flex;align-items:center;gap:9px;}
.flash-err{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.28);border-radius:11px;padding:11px 16px;margin-bottom:20px;color:#f87171;font-size:13px;display:flex;align-items:center;gap:9px;}

/* Top title span styling */
.top-title span{color:var(--et-glow);}

/* Light mode for admin */
html.light-adm{--bg-base:#f0f4ff;--bg-nav:#fff;--bg-card:#fff;--bg-card2:#f8faff;--border:rgba(26,86,240,0.12);--muted:#64748b;--dim:#334155;}
html.light-adm body{background:var(--bg-base);color:#0f172a;}
html.light-adm #adm-sb{background:var(--bg-nav);border-color:var(--border);}
html.light-adm #adm-top{background:rgba(255,255,255,0.9);border-color:var(--border);}
html.light-adm #adm-main{}
html.light-adm .adm-card,.html.light-adm .admin-card{background:#fff;border-color:rgba(26,86,240,0.12);}
html.light-adm .stat-card{background:#fff;border-color:rgba(26,86,240,0.12);}
html.light-adm .sb-link{color:#475569;}
html.light-adm .sb-link:hover{background:rgba(26,86,240,0.06);color:#0f172a;}
html.light-adm .sb-logo-wrap{background:#f0f4ff;}
html.light-adm .sb-logo-img{filter:none !important;}
html.light-adm .sv,.html.light-adm .sec-head{color:#0f172a;}
html.light-adm .adm-table td{color:#334155;}
html.light-adm .adm-table th{color:#64748b;}
html.light-adm .top-title{color:#0f172a;}
html.light-adm .sb-uinfo .n{color:#0f172a;}

@media(max-width:768px){
    #adm-sb{left:-300px;transition:left .3s;}
    [dir="rtl"] #adm-sb{left:auto;right:-300px;transition:right .3s;}
    #adm-sb.mob{left:0;}
    [dir="rtl"] #adm-sb.mob{right:0;}
    #adm-top{left:0!important;right:0!important;}
    #adm-main{margin-inline-start:0!important;padding:16px;}
}
</style>
@stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside id="adm-sb">
    <div class="sb-logo">
        <div class="sb-et-icon">ET</div>
        <div class="sb-logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH" class="sb-logo-img">
        </div>
        <span class="sb-badge">Admin</span>
    </div>

    <nav class="sb-nav">
        @php $ar = app()->getLocale()==='ar'; @endphp
        <div class="sb-group">{{ $ar?'عام':'Overview' }}</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard')?'on':'' }}">
            <i class="fas fa-th-large"></i><span>{{ $ar?'لوحة التحكم':'Dashboard' }}</span>
        </a>
        <a href="{{ route('admin.analytics') }}" class="sb-link {{ request()->routeIs('admin.analytics')?'on':'' }}">
            <i class="fas fa-chart-line"></i><span>{{ $ar?'التحليلات':'Analytics' }}</span>
        </a>

        <div class="sb-group">{{ $ar?'الخدمات والطلبات':'Services & Orders' }}</div>
        <a href="{{ route('admin.services.index') }}" class="sb-link {{ request()->routeIs('admin.services*')?'on':'' }}">
            <i class="fas fa-th-large"></i><span>{{ $ar?'الخدمات':'Services' }}</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sb-link {{ request()->routeIs('admin.orders*')?'on':'' }}">
            <i class="fas fa-shopping-cart"></i><span>{{ $ar?'طلبات الشراء':'Orders' }}</span>
            @php $newOrders=\App\Models\Order::where('status','pending')->count(); @endphp
            @if($newOrders>0)<span class="sb-badge-count">{{ $newOrders }}</span>@endif
        </a>

        <div class="sb-group">{{ $ar?'الأعمال':'Business' }}</div>
        <a href="{{ route('admin.leads.index') }}" class="sb-link {{ request()->routeIs('admin.leads*')?'on':'' }}">
            <i class="fas fa-inbox"></i><span>{{ $ar?'استفسارات عامة':'Leads' }}</span>
            @php $nl=\App\Models\ServiceRequest::where('status','pending')->count(); @endphp
            @if($nl>0)<span class="sb-badge-count">{{ $nl }}</span>@endif
        </a>
        <a href="{{ route('admin.projects.index') }}" class="sb-link {{ request()->routeIs('admin.projects*')?'on':'' }}">
            <i class="fas fa-folder-open"></i><span>{{ $ar?'المشاريع':'Projects' }}</span>
        </a>
        <a href="{{ route('admin.clients.index') }}" class="sb-link {{ request()->routeIs('admin.clients*')?'on':'' }}">
            <i class="fas fa-users"></i><span>{{ $ar?'العملاء':'Clients' }}</span>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="sb-link {{ request()->routeIs('admin.messages*')?'on':'' }}">
            <i class="fas fa-comments"></i><span>{{ $ar?'مراسلات العملاء':'Client Messages' }}</span>
            @php $nm=\App\Models\Message::where('receiver_id',auth()->id())->where('is_read',false)->count(); @endphp
            @if($nm>0)<span class="sb-badge-count">{{ $nm }}</span>@endif
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="sb-link {{ request()->routeIs('admin.invoices*')?'on':'' }}">
            <i class="fas fa-file-invoice-dollar"></i><span>{{ $ar?'الفواتير':'Invoices' }}</span>
        </a>

        <div class="sb-group">{{ $ar?'المحتوى':'Content' }}</div>
        <a href="{{ route('admin.testimonials.index') }}" class="sb-link {{ request()->routeIs('admin.testimonials*')?'on':'' }}">
            <i class="fas fa-star"></i><span>{{ $ar?'التقييمات':'Testimonials' }}</span>
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="sb-link {{ request()->routeIs('admin.faqs*')?'on':'' }}">
            <i class="fas fa-question-circle"></i><span>{{ $ar?'الأسئلة الشائعة':'FAQs' }}</span>
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="sb-link {{ request()->routeIs('admin.contacts*')?'on':'' }}">
            <i class="fas fa-envelope"></i><span>{{ $ar?'رسائل التواصل':'Messages' }}</span>
        </a>

        <div class="sb-group">{{ $ar?'الإعدادات':'Settings' }}</div>
        <a href="{{ route('admin.settings.index') }}" class="sb-link {{ request()->routeIs('admin.settings*')?'on':'' }}">
            <i class="fas fa-cog"></i><span>{{ $ar?'إعدادات النظام':'System Settings' }}</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="sb-link">
            <i class="fas fa-user-cog"></i><span>{{ $ar?'الملف الشخصي':'Profile' }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-link" style="background:none;border:none;cursor:pointer;width:100%;text-align:start;">
                <i class="fas fa-sign-out-alt" style="color:#f87171;"></i><span>{{ $ar?'تسجيل الخروج':'Logout' }}</span>
            </button>
        </form>
    </nav>

    <div class="sb-foot">
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name??'A',0,1)) }}</div>
            <div class="sb-uinfo">
                <div class="n">{{ auth()->user()->name??'Admin' }}</div>
                <div class="r">{{ $ar?'مدير النظام':'Administrator' }}</div>
            </div>
        </div>
    </div>
</aside>

<div id="sb-overlay"></div>

{{-- Topbar --}}
<header id="adm-top">
    <button id="sb-toggle" title="Toggle Sidebar">
        <i class="fas fa-bars" style="font-size:13px;"></i>
    </button>
    <div class="top-title">@yield('page-title','Dashboard')</div>
    <div class="top-actions">
        @if(app()->getLocale()==='en')
            <a href="{{ route('lang.switch','ar') }}" class="lang-btn-adm"><i class="fas fa-globe"></i> العربية</a>
        @else
            <a href="{{ route('lang.switch','en') }}" class="lang-btn-adm"><i class="fas fa-globe"></i> English</a>
        @endif

        {{-- Day/Night Toggle --}}
        <button onclick="toggleAdminMode()" id="adm-mode-btn" class="top-btn" title="Toggle Mode">
            <i id="adm-mode-icon" class="fas fa-moon" style="font-size:13px;"></i>
        </button>


            <button class="top-btn" id="notif-btn" title="Notifications">
                <i class="fas fa-bell" style="font-size:13px;"></i>
                <span class="notif-dot"></span>
            </button>
            <div class="notif-drop" id="notif-drop">
                <div class="notif-head">{{ $ar?'الإشعارات':'Notifications' }} <span style="color:var(--muted);font-weight:400;">(3)</span></div>
                <div class="notif-item"><div class="n-dot" style="background:#3b82f6;"></div><div><p>{{ $ar?'طلب جديد من':'New lead from' }} <strong>Ahmed Al-Rashidi</strong></p><time>2 min ago</time></div></div>
                <div class="notif-item"><div class="n-dot" style="background:#10b981;"></div><div><p>{{ $ar?'مشروع':'Project' }} <strong>E-Commerce</strong> {{ $ar?'مكتمل':'completed' }}</p><time>1 hr ago</time></div></div>
                <div class="notif-item"><div class="n-dot" style="background:#f59e0b;"></div><div><p>{{ $ar?'فاتورة':'Invoice' }} <strong>#INV-009</strong> {{ $ar?'مدفوعة':'paid' }}</p><time>3 hr ago</time></div></div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="top-btn" title="View Site" target="_blank">
            <i class="fas fa-external-link-alt" style="font-size:12px;"></i>
        </a>
    </div>
</header>

{{-- Main --}}
<main id="adm-main">
    @if(session('success'))
    <div class="flash-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="flash-err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @yield('content')
</main>

<script>
// ── Admin Mode Toggle ──
(function(){
    const saved = localStorage.getItem('et-adm-mode');
    if (saved === 'light') document.documentElement.classList.add('light-adm');
    updateAdmModeIcon();
})();
function toggleAdminMode(){
    const isLight = document.documentElement.classList.toggle('light-adm');
    localStorage.setItem('et-adm-mode', isLight ? 'light' : 'dark');
    updateAdmModeIcon();
}
function updateAdmModeIcon(){
    const isLight = document.documentElement.classList.contains('light-adm');
    const icon = document.getElementById('adm-mode-icon');
    if (icon) icon.className = isLight ? 'fas fa-sun' : 'fas fa-moon';
}

const adSb=document.getElementById('adm-sb');
const adTop=document.getElementById('adm-top');
const adMain=document.getElementById('adm-main');
const adOvl=document.getElementById('sb-overlay');
const adTog=document.getElementById('sb-toggle');
let collapsed=localStorage.getItem('sb-col')==='true';

function applyState(){
    if(window.innerWidth<=768){
        [adSb,adTop,adMain].forEach(el=>{ el.classList.remove('col'); });
        return;
    }
    adSb.classList.toggle('col',collapsed);
    adTop.classList.toggle('col',collapsed);
    adMain.classList.toggle('col',collapsed);
}
adTog.addEventListener('click',()=>{
    if(window.innerWidth<=768){
        adSb.classList.toggle('mob');
        adOvl.classList.toggle('vis');
    } else {
        collapsed=!collapsed;
        localStorage.setItem('sb-col',collapsed);
        applyState();
    }
});
adOvl.addEventListener('click',()=>{ adSb.classList.remove('mob'); adOvl.classList.remove('vis'); });
applyState();
window.addEventListener('resize',applyState);

document.getElementById('notif-btn').addEventListener('click',e=>{
    e.stopPropagation();
    document.getElementById('notif-drop').classList.toggle('open');
});
document.addEventListener('click',()=>{ document.getElementById('notif-drop').classList.remove('open'); });
</script>
@stack('scripts')
</body>
</html>
