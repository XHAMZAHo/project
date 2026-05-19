<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'ELEVA TECH — نحوّل أفكارك إلى حلول رقمية ذكية واحترافية')">
    <meta name="keywords" content="ELEVA TECH, تطوير مواقع, تطبيقات الجوال, ذكاء اصطناعي, تقنية">
    <meta property="og:title"       content="@yield('title', 'ELEVA TECH') | ELEVA TECH">
    <meta property="og:description" content="@yield('meta_description', 'ELEVA TECH — نحوّل أفكارك إلى حلول رقمية ذكية')">
    <meta property="og:type"        content="website">
    <title>@yield('title', 'ELEVA TECH') | ELEVA TECH</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif;
        }
        body {
            background: #03040e;
            color: #f1f5f9;
            overflow-x: hidden;
        }
        html.light body {
            background: #f0f4ff;
            color: #0f172a;
        }

        /* Particles canvas */
        #particles-canvas {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* Glow orb */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(80px);
        }

        /* Smooth pulse glow on CTA */
        @keyframes pulse-glow {
            0%,100% { box-shadow: 0 0 25px rgba(26,86,240,0.5); }
            50%      { box-shadow: 0 0 55px rgba(26,86,240,0.85); }
        }
        .animate-pulse-glow { animation: pulse-glow 2.5s ease-in-out infinite; }

        /* Grid background - dark mode only */
        .grid-bg {
            background-image:
                linear-gradient(rgba(26,86,240,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(26,86,240,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        /* Remove grid lines completely in light mode */
        html.light .grid-bg {
            background-image: none;
        }
        /* Fix loading logo in light mode */
        html.light #et-loading-logo {
            filter: none !important;
            mix-blend-mode: normal !important;
        }
    </style>

    @stack('styles')

    {{-- Dark Mode: apply saved preference BEFORE render --}}
    <script>
        (function () {
            const saved = localStorage.getItem('et-mode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const useDark = saved === 'dark' || (!saved && prefersDark) || saved === null;
            if (!useDark) {
                document.documentElement.classList.add('light');
            }
            // default is dark (no class needed since CSS defaults to dark)
        })();
    </script>
</head>
<body class="antialiased">

    {{-- ══ LOADING SCREEN ══ --}}
    <div id="et-loading">
        <div style="position:relative; margin-bottom:28px;">
            <span style="display:inline-flex;align-items:center;border-radius:14px;padding:10px 20px;">
                <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH" id="et-loading-logo"
                     style="height:50px; width:auto; filter:invert(1) hue-rotate(180deg); mix-blend-mode:screen;">
            </span>
        </div>
        <div class="et-loader"></div>
        <p style="margin-top:20px; font-size:11px; letter-spacing:0.18em; text-transform:uppercase; color:#475569;">
            ...LOADING
        </p>
    </div>

    {{-- ══ CURSOR GLOW (desktop only) ══ --}}
    <div id="et-cursor"></div>

    {{-- ══ NAVBAR ══ --}}
    @include('components.navbar')

    {{-- ══ MAIN CONTENT ══ --}}
    <main>
        @yield('content')
    </main>

    {{-- ══ FOOTER ══ --}}
    @include('components.footer')

    {{-- ══ CHATBOT ══ --}}
    @include('components.chatbot')

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
    // ── Loading Screen ──
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('et-loading').classList.add('out');
        }, 900);
    });

    // ── Cursor Glow ──
    const etCursor = document.getElementById('et-cursor');
    document.addEventListener('mousemove', e => {
        etCursor.style.left = e.clientX + 'px';
        etCursor.style.top  = e.clientY + 'px';
    });

    // ── AOS ──
    AOS.init({
        duration: 750,
        once: true,
        easing: 'ease-out-cubic',
        offset: 50,
    });

    // ── GSAP ──
    if (typeof gsap !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    // ── Navbar Scroll ──
    const etNavbar = document.getElementById('et-navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            etNavbar?.classList.add('scrolled');
        } else {
            etNavbar?.classList.remove('scrolled');
        }
    }, { passive: true });

    // ── Dark/Light Mode Toggle ──
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

    // ── Counter Animation ──
    function animateCounter(el) {
        const target   = +el.dataset.target;
        const suffix   = el.dataset.suffix || '';
        const duration = 2000;
        const steps    = 60;
        const inc      = target / steps;
        let current    = 0;
        let frame      = 0;
        const timer = setInterval(() => {
            frame++;
            current = Math.min(current + inc, target);
            el.textContent = Math.floor(current) + suffix;
            if (frame >= steps) clearInterval(timer);
        }, duration / steps);
    }
    const counterObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting && !e.target.dataset.counted) {
                e.target.dataset.counted = '1';
                animateCounter(e.target);
            }
        });
    }, { threshold: 0.5 });
    document.querySelectorAll('[data-counter]').forEach(el => counterObs.observe(el));
    </script>

    @stack('scripts')
</body>
</html>
