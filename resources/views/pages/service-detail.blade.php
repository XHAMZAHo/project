@extends('layouts.app')

@php
$services = [
    'web-development' => [
        'title'    => 'Web Development',
        'headline' => 'We Build Websites That Convert Visitors Into Clients',
        'sub'      => 'Not just beautiful — strategically engineered to generate leads, close deals, and scale your business.',
        'icon'     => 'fas fa-code',
        'color'    => '#3b82f6',
        'features' => [
            ['icon'=>'fas fa-bolt',         'title'=>'Lightning Fast',     'desc'=>'Sub-2s load times with optimized assets and CDN delivery.'],
            ['icon'=>'fas fa-mobile-alt',    'title'=>'Mobile First',      'desc'=>'Pixel-perfect on every screen size, from phone to 4K.'],
            ['icon'=>'fas fa-search',        'title'=>'SEO Optimized',     'desc'=>'Built-in schema, meta strategy, and Core Web Vitals tuning.'],
            ['icon'=>'fas fa-shield-alt',    'title'=>'Enterprise Security','desc'=>'HTTPS, CSRF protection, and hardened server config.'],
            ['icon'=>'fas fa-chart-line',    'title'=>'Analytics Ready',   'desc'=>'GA4, Meta Pixel, and heatmap integration from day one.'],
            ['icon'=>'fas fa-sync-alt',      'title'=>'Easy CMS',          'desc'=>'Manage your content without touching a line of code.'],
        ],
        'steps' => ['Discovery & Strategy','UI/UX Wireframes','Frontend Development','Backend & CMS','Testing & QA','Launch & Support'],
        'packages' => [
            ['name'=>'Starter','price'=>'$499','pages'=>'5 Pages','features'=>['Responsive Design','Contact Form','Basic SEO','1 Month Support'],'popular'=>false],
            ['name'=>'Professional','price'=>'$1,299','pages'=>'15 Pages','features'=>['Custom UI/UX','CMS Integration','Advanced SEO','Blog/Portfolio','3 Months Support'],'popular'=>true],
            ['name'=>'Enterprise','price'=>'$2,999+','pages'=>'Unlimited','features'=>['Full Custom Build','E-Commerce Ready','API Integrations','Multi-language','12 Months Support'],'popular'=>false],
        ],
    ],
    'ui-ux-design' => [
        'title'    => 'UI/UX Design',
        'headline' => 'Designs That Make Users Stay — and Come Back',
        'sub'      => 'We craft interfaces that feel effortless. Every pixel is intentional. Every interaction is delightful.',
        'icon'     => 'fas fa-pen-ruler',
        'color'    => '#8b5cf6',
        'features' => [
            ['icon'=>'fas fa-user-check',    'title'=>'User Research',     'desc'=>'Deep understanding of your users before a single wireframe.'],
            ['icon'=>'fas fa-layer-group',   'title'=>'Design Systems',    'desc'=>'Scalable component libraries for consistent UI at any scale.'],
            ['icon'=>'fas fa-magic',         'title'=>'Micro-animations',  'desc'=>'Subtle motion that communicates and delights.'],
            ['icon'=>'fas fa-universal-access','title'=>'Accessibility',   'desc'=>'WCAG-compliant designs that work for everyone.'],
            ['icon'=>'fas fa-vials',         'title'=>'A/B Testing Ready', 'desc'=>'Hypothesis-driven design with measurable outcomes.'],
            ['icon'=>'fas fa-comments',      'title'=>'Collaborative',     'desc'=>'Figma-based workflow with real-time client collaboration.'],
        ],
        'steps' => ['Research & Audit','Information Architecture','Wireframing','Visual Design','Prototype & Test','Handoff'],
        'packages' => [
            ['name'=>'Basic','price'=>'$299','pages'=>'3 Screens','features'=>['Wireframes','1 Revision Round','Figma File'],'popular'=>false],
            ['name'=>'Standard','price'=>'$799','pages'=>'10 Screens','features'=>['Full Design System','Interactive Prototype','3 Revision Rounds','Dev Handoff'],'popular'=>true],
            ['name'=>'Premium','price'=>'$1,799+','pages'=>'Unlimited','features'=>['Full Product Design','User Testing','Motion Design','Design Sprint'],'popular'=>false],
        ],
    ],
    'system-development' => [
        'title'    => 'System Development',
        'headline' => 'Custom Systems That Power Your Entire Operation',
        'sub'      => 'ERPs, CRMs, dashboards, APIs — we engineer the backbone of your business.',
        'icon'     => 'fas fa-server',
        'color'    => '#10b981',
        'features' => [
            ['icon'=>'fas fa-database',      'title'=>'Scalable Architecture','desc'=>'Designed to handle 10x growth without re-engineering.'],
            ['icon'=>'fas fa-plug',          'title'=>'API Integration',    'desc'=>'Connect with any third-party service or legacy system.'],
            ['icon'=>'fas fa-lock',          'title'=>'Role-based Access',  'desc'=>'Granular permissions for every user type in your org.'],
            ['icon'=>'fas fa-chart-bar',     'title'=>'Real-time Dashboard','desc'=>'Live KPIs and analytics at your fingertips.'],
            ['icon'=>'fas fa-robot',         'title'=>'Automation',         'desc'=>'Eliminate manual work with smart workflow automation.'],
            ['icon'=>'fas fa-cloud',         'title'=>'Cloud Deployment',   'desc'=>'Docker + cloud-native, deployed globally in minutes.'],
        ],
        'steps' => ['Requirements Analysis','System Architecture','Database Design','Backend Development','Frontend Dashboard','Deployment & Training'],
        'packages' => [
            ['name'=>'Module','price'=>'$1,499','pages'=>'1 Module','features'=>['Single Feature Module','API Endpoints','Admin Panel','3 Months Support'],'popular'=>false],
            ['name'=>'Full System','price'=>'$4,999','pages'=>'Full System','features'=>['Complete Custom System','Multi-role Auth','Reporting','6 Months Support'],'popular'=>true],
            ['name'=>'Enterprise','price'=>'Custom','pages'=>'Enterprise','features'=>['Full ERP/CRM','Integrations','SLA','Dedicated Team'],'popular'=>false],
        ],
    ],
];
$s = $services[$service] ?? $services['web-development'];
@endphp

@section('title', $s['title'])

@push('styles')
<style>
    :root { --accent: {{ $s['color'] }}; }

    /* Hero */
    .sd-hero {
        min-height: 92vh;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
        background: radial-gradient(ellipse at 60% 40%, rgba(37,99,235,0.13) 0%, transparent 60%),
                    radial-gradient(ellipse at 20% 80%, rgba(239,68,68,0.07) 0%, transparent 50%),
                    #050810;
        padding: 120px 24px 80px;
        text-align: center;
    }
    .sd-hero-content { position: relative; z-index: 2; max-width: 820px; margin: 0 auto; }
    .sd-badge { display:inline-flex; align-items:center; gap:8px; padding:6px 18px;
        background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.3);
        border-radius:100px; font-size:12px; color:var(--accent); letter-spacing:.1em;
        text-transform:uppercase; margin-bottom:24px; }
    .sd-h1 { font-size: clamp(32px,5vw,62px); font-weight:900; color:#fff; line-height:1.1;
        margin-bottom:22px; }
    .sd-h1 span { background:linear-gradient(135deg,var(--accent),#fff);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .sd-sub { font-size:17px; color:#94a3b8; max-width:620px; margin:0 auto 40px; line-height:1.7; }
    .sd-cta { display:inline-flex; align-items:center; gap:10px; padding:16px 36px;
        background:linear-gradient(135deg,#1d4ed8,#3b82f6);
        border-radius:14px; color:#fff; font-size:16px; font-weight:700;
        text-decoration:none; box-shadow:0 0 40px rgba(37,99,235,0.4);
        transition:all .3s; }
    .sd-cta:hover { box-shadow:0 0 70px rgba(37,99,235,0.65); transform:translateY(-3px); color:#fff; }
    .sd-cta-ghost { display:inline-flex; align-items:center; gap:8px; padding:15px 28px;
        border:1px solid rgba(37,99,235,0.35); border-radius:14px; color:#94a3b8;
        font-size:15px; text-decoration:none; transition:all .3s; }
    .sd-cta-ghost:hover { border-color:var(--accent); color:#fff; }

    /* Sticky CTA */
    .sticky-cta { position:fixed; bottom:28px; right:28px; z-index:9000;
        display:flex; flex-direction:column; align-items:flex-end; gap:12px; }
    .sticky-cta-btn { padding:13px 22px; border-radius:50px;
        background:linear-gradient(135deg,#1d4ed8,#3b82f6);
        color:#fff; font-weight:700; font-size:13.5px; text-decoration:none;
        box-shadow:0 0 30px rgba(37,99,235,0.5); transition:all .3s;
        display:flex; align-items:center; gap:8px; }
    .sticky-cta-btn:hover { box-shadow:0 0 55px rgba(37,99,235,0.7); transform:scale(1.04); color:#fff; }
    .wa-btn { width:52px; height:52px; border-radius:50%;
        background:#25d366; display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:22px; text-decoration:none;
        box-shadow:0 0 24px rgba(37,211,102,0.45); transition:all .3s; }
    .wa-btn:hover { transform:scale(1.1); color:#fff; }

    /* Sections */
    .sd-section { padding: 90px 24px; }
    .sd-container { max-width:1140px; margin:0 auto; }
    .sd-section-tag { display:inline-block; padding:4px 16px;
        background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.3);
        border-radius:100px; color:var(--accent); font-size:11px;
        letter-spacing:.12em; text-transform:uppercase; margin-bottom:14px; }
    .sd-section-title { font-size:clamp(26px,3.5vw,40px); font-weight:800; color:#fff; margin-bottom:14px; }
    .sd-section-sub { font-size:15px; color:#64748b; max-width:540px; line-height:1.7; }

    /* Features grid */
    .feat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-top:50px; }
    @media(max-width:900px){ .feat-grid{grid-template-columns:repeat(2,1fr);} }
    @media(max-width:560px){ .feat-grid{grid-template-columns:1fr;} }
    .feat-card { background:#0b0f1e; border:1px solid rgba(37,99,235,0.15);
        border-radius:16px; padding:26px; transition:all .35s; }
    .feat-card:hover { border-color:var(--accent); transform:translateY(-5px);
        box-shadow:0 12px 40px rgba(0,0,0,0.4), 0 0 30px rgba(37,99,235,0.12); }
    .feat-icon { width:48px; height:48px; border-radius:12px;
        background:rgba(37,99,235,0.12); display:flex; align-items:center;
        justify-content:center; font-size:20px; color:var(--accent);
        margin-bottom:16px; transition:all .35s; }
    .feat-card:hover .feat-icon { background:var(--accent); color:#fff;
        box-shadow:0 0 25px rgba(37,99,235,0.4); }
    .feat-title { font-size:15px; font-weight:700; color:#fff; margin-bottom:7px; }
    .feat-desc { font-size:13px; color:#64748b; line-height:1.65; }

    /* Before/After */
    .ba-wrapper { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:50px; }
    @media(max-width:700px){ .ba-wrapper{grid-template-columns:1fr;} }
    .ba-card { border-radius:16px; overflow:hidden; position:relative; }
    .ba-label { position:absolute; top:16px; left:16px; padding:5px 14px;
        border-radius:100px; font-size:12px; font-weight:700; }
    .ba-before { background:#0b0f1e; border:1px solid rgba(239,68,68,0.2); }
    .ba-after  { background:#0b0f1e; border:1px solid rgba(16,185,129,0.3); }
    .ba-content { padding:50px 28px 28px; }
    .ba-item { display:flex; align-items:center; gap:10px; margin-bottom:10px;
        font-size:13.5px; }

    /* Process */
    .process-steps { display:flex; flex-wrap:wrap; gap:0; margin-top:50px; position:relative; }
    .process-step { flex:1; min-width:160px; text-align:center; padding:0 16px; position:relative; }
    .process-step::after { content:''; position:absolute; top:28px; right:-1px;
        width:calc(100% - 56px); height:2px;
        background:linear-gradient(90deg,rgba(37,99,235,0.4),rgba(37,99,235,0.1));
        left:56px; display:block; }
    .process-step:last-child::after { display:none; }
    .step-num { width:56px; height:56px; border-radius:50%; margin:0 auto 16px;
        background:linear-gradient(135deg,#1d4ed8,#3b82f6);
        display:flex; align-items:center; justify-content:center;
        font-size:18px; font-weight:900; color:#fff;
        box-shadow:0 0 24px rgba(37,99,235,0.4); }
    .step-title { font-size:13px; font-weight:600; color:#e2e8f0; }

    /* Pricing */
    .pricing-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:50px; }
    @media(max-width:900px){ .pricing-grid{grid-template-columns:1fr;} }
    .pricing-card { background:#0b0f1e; border:1px solid rgba(37,99,235,0.15);
        border-radius:20px; padding:32px 28px; position:relative; transition:all .3s; }
    .pricing-card.popular { border-color:rgba(37,99,235,0.5);
        box-shadow:0 0 50px rgba(37,99,235,0.15); }
    .pricing-card:hover { transform:translateY(-6px); }
    .popular-badge { position:absolute; top:-14px; left:50%; transform:translateX(-50%);
        background:linear-gradient(135deg,#1d4ed8,#3b82f6); color:#fff;
        font-size:11px; font-weight:700; padding:4px 16px; border-radius:100px;
        white-space:nowrap; }
    .pkg-name { font-size:14px; font-weight:600; color:#64748b; margin-bottom:10px; }
    .pkg-price { font-size:40px; font-weight:900; color:#fff; line-height:1; margin-bottom:5px; }
    .pkg-price span { font-size:16px; color:#64748b; font-weight:400; }
    .pkg-pages { font-size:13px; color:#64748b; margin-bottom:22px;
        padding-bottom:22px; border-bottom:1px solid rgba(37,99,235,0.12); }
    .pkg-feat { display:flex; align-items:center; gap:10px;
        font-size:13.5px; color:#94a3b8; margin-bottom:11px; }
    .pkg-feat i { color:#34d399; font-size:12px; }
    .pkg-btn { display:block; text-align:center; margin-top:26px;
        padding:12px; border-radius:12px; font-size:14px; font-weight:600;
        text-decoration:none; transition:all .3s; }
    .pkg-btn-solid { background:linear-gradient(135deg,#1d4ed8,#3b82f6); color:#fff;
        box-shadow:0 0 24px rgba(37,99,235,0.35); }
    .pkg-btn-solid:hover { box-shadow:0 0 45px rgba(37,99,235,0.6); color:#fff; }
    .pkg-btn-ghost { border:1px solid rgba(37,99,235,0.3); color:#64748b; }
    .pkg-btn-ghost:hover { border-color:var(--accent); color:#fff; }

    /* Stats */
    .stats-bar { display:grid; grid-template-columns:repeat(4,1fr); gap:20px;
        background:#0b0f1e; border:1px solid rgba(37,99,235,0.15);
        border-radius:20px; padding:36px; margin-top:50px; }
    @media(max-width:700px){ .stats-bar{grid-template-columns:1fr 1fr;} }
    .stat-item { text-align:center; }
    .stat-v { font-size:38px; font-weight:900;
        background:linear-gradient(135deg,var(--accent),#fff);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text; line-height:1; }
    .stat-l { font-size:13px; color:#64748b; margin-top:7px; }

    /* Final CTA */
    .final-cta { text-align:center; padding:100px 24px;
        background:radial-gradient(ellipse at 50% 50%, rgba(37,99,235,0.1) 0%, transparent 65%); }
</style>
@endpush

@section('content')

{{-- Sticky buttons --}}
<div class="sticky-cta">
    <a href="{{ route('contact') }}" class="sticky-cta-btn">
        <i class="fas fa-paper-plane"></i> Get Free Quote
    </a>
    <a href="https://wa.me/1234567890" target="_blank" class="wa-btn" title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

{{-- ── HERO ── --}}
<section class="sd-hero">
    <div class="sd-hero-content" data-aos="fade-up">
        <div class="sd-badge">
            <i class="{{ $s['icon'] }}"></i> {{ $s['title'] }}
        </div>
        <h1 class="sd-h1">{{ $s['headline'] }}</h1>
        <p class="sd-sub">{{ $s['sub'] }}</p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" class="sd-cta">
                <i class="fas fa-rocket"></i> Start Your Project
            </a>
            <a href="#pricing" class="sd-cta-ghost">
                <i class="fas fa-tags"></i> View Pricing
            </a>
        </div>
    </div>
</section>

{{-- ── FEATURES ── --}}
<section class="sd-section" style="background:#060912;" id="features">
    <div class="sd-container">
        <div data-aos="fade-up">
            <div class="sd-section-tag">Why Choose Us</div>
            <div class="sd-section-title">Everything You Need to Succeed</div>
            <p class="sd-section-sub">Every feature is built to directly impact your business outcomes — not just look good.</p>
        </div>
        <div class="feat-grid">
            @foreach($s['features'] as $i => $feat)
            <div class="feat-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="feat-icon"><i class="{{ $feat['icon'] }}"></i></div>
                <div class="feat-title">{{ $feat['title'] }}</div>
                <div class="feat-desc">{{ $feat['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── BEFORE / AFTER ── --}}
<section class="sd-section">
    <div class="sd-container">
        <div data-aos="fade-up" style="text-align:center;margin-bottom:0;">
            <div class="sd-section-tag">Transformation</div>
            <div class="sd-section-title">Before vs. After ELEVA TECH</div>
        </div>
        <div class="ba-wrapper" data-aos="fade-up" data-aos-delay="100">
            <div class="ba-card ba-before">
                <div class="ba-content">
                    <span class="ba-label" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3);">❌ Before</span>
                    @foreach(['Slow, outdated design','Poor mobile experience','Zero SEO visibility','No clear call-to-action','High bounce rate','Generic template look'] as $item)
                    <div class="ba-item" style="color:#64748b;">
                        <i class="fas fa-times" style="color:#ef4444;"></i> {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="ba-card ba-after">
                <div class="ba-content">
                    <span class="ba-label" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);">✅ After ELEVA</span>
                    @foreach(['Lightning-fast, modern UI','Flawless on all devices','Page 1 SEO ranking','Conversion-focused layout','Low bounce, high engagement','100% custom, brand-aligned'] as $item)
                    <div class="ba-item" style="color:#e2e8f0;">
                        <i class="fas fa-check" style="color:#10b981;"></i> {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── PROCESS ── --}}
<section class="sd-section" style="background:#060912;">
    <div class="sd-container">
        <div data-aos="fade-up" style="text-align:center;margin-bottom:0;">
            <div class="sd-section-tag">How We Work</div>
            <div class="sd-section-title">Our Proven Process</div>
            <p class="sd-section-sub" style="margin:0 auto;">Transparent, collaborative, and results-driven — from first call to launch day.</p>
        </div>
        <div class="process-steps" style="margin-top:60px;" data-aos="fade-up" data-aos-delay="100">
            @foreach($s['steps'] as $i => $step)
            <div class="process-step">
                <div class="step-num">{{ $i + 1 }}</div>
                <div class="step-title">{{ $step }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── PRICING ── --}}
<section class="sd-section" id="pricing">
    <div class="sd-container">
        <div data-aos="fade-up" style="text-align:center;">
            <div class="sd-section-tag">Pricing</div>
            <div class="sd-section-title">Transparent Packages</div>
            <p class="sd-section-sub" style="margin:0 auto;">No hidden fees. Pick the plan that fits your ambition.</p>
        </div>
        <div class="pricing-grid">
            @foreach($s['packages'] as $i => $pkg)
            <div class="pricing-card {{ $pkg['popular'] ? 'popular' : '' }}" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                @if($pkg['popular'])
                <div class="popular-badge">⭐ Most Popular</div>
                @endif
                <div class="pkg-name">{{ $pkg['name'] }}</div>
                <div class="pkg-price">{{ $pkg['price'] }} <span>/ project</span></div>
                <div class="pkg-pages">{{ $pkg['pages'] }}</div>
                @foreach($pkg['features'] as $feat)
                <div class="pkg-feat"><i class="fas fa-check-circle"></i> {{ $feat }}</div>
                @endforeach
                <a href="{{ route('client.services.order', $service) }}" class="pkg-btn {{ $pkg['popular'] ? 'pkg-btn-solid' : 'pkg-btn-ghost' }}">
                    Order Service
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── TRUST / STATS ── --}}
<section class="sd-section" style="background:#060912;">
    <div class="sd-container">
        <div data-aos="fade-up" style="text-align:center;">
            <div class="sd-section-tag">Our Track Record</div>
            <div class="sd-section-title">Numbers That Speak</div>
        </div>
        <div class="stats-bar" data-aos="fade-up" data-aos-delay="100">
            @foreach([['50+','Projects Delivered'],['100%','Client Satisfaction'],['3x','Avg. ROI Increase'],['24/7','Support Available']] as $stat)
            <div class="stat-item">
                <div class="stat-v" data-counter data-target="{{ preg_replace('/\D/','',$stat[0]) }}" data-suffix="{{ preg_replace('/[0-9]/','',$stat[0]) }}">{{ $stat[0] }}</div>
                <div class="stat-l">{{ $stat[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FINAL CTA ── --}}
<section class="final-cta">
    <div data-aos="fade-up">
        <div class="sd-section-tag" style="margin-bottom:18px;">Ready to Start?</div>
        <h2 style="font-size:clamp(28px,4vw,50px);font-weight:900;color:#fff;margin-bottom:16px;line-height:1.1;">
            Ready to Build <span style="background:linear-gradient(135deg,#2563eb,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Your Project?</span>
        </h2>
        <p style="font-size:16px;color:#64748b;margin-bottom:38px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
            Get a free consultation. No commitment required. We'll map out exactly what your project needs.
        </p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" class="sd-cta">
                <i class="fas fa-paper-plane"></i> Get a Free Quote
            </a>
            <a href="{{ route('portfolio') }}" class="sd-cta-ghost">
                <i class="fas fa-eye"></i> View Our Work
            </a>
        </div>
    </div>
</section>

@endsection
