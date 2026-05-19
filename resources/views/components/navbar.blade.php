<nav id="et-navbar" class="grid-bg">
    <style>
        /* Navbar Logo Wrapper */
        .et-logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        #et-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
            filter: invert(1) hue-rotate(180deg);
            mix-blend-mode: screen;
            transition: filter 0.3s, mix-blend-mode 0.3s;
        }
        /* Light mode adjustments if needed */
        html.light #et-logo {
            filter: none !important;
            mix-blend-mode: normal !important;
        }
    </style>
    <div style="max-width:1280px; margin:0 auto; padding:0 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; height:72px;">

            {{-- ── Logo ── --}}
            <a href="{{ route('home') }}" style="display:flex; align-items:center; flex-shrink:0; text-decoration:none;">
                <div class="et-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH" id="et-logo">
                </div>
            </a>

            {{-- ── Desktop Nav ── --}}
            <div class="et-desktop-nav" style="display:flex; align-items:center; gap:36px;">
                <a href="{{ route('home') }}"      class="et-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('site.home') }}</a>
                <a href="{{ route('services') }}"  class="et-nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">{{ __('site.services') }}</a>
                <a href="{{ route('portfolio') }}" class="et-nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}">{{ __('site.portfolio') }}</a>
                <a href="{{ route('about') }}"     class="et-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">{{ __('site.about') }}</a>
                <a href="{{ route('contact') }}"   class="et-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('site.contact') }}</a>
            </div>

            {{-- ── Actions ── --}}
            <div class="et-desktop-nav" style="display:flex; align-items:center; gap:10px;">

                {{-- Language --}}
                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                   style="padding:7px 14px; border-radius:8px; border:1px solid rgba(26,86,240,0.25);
                          background:rgba(26,86,240,0.06); color:#94a3b8; font-size:12.5px;
                          font-weight:600; text-decoration:none; transition:all 0.3s;"
                   onmouseover="this.style.borderColor='rgba(26,86,240,0.5)';this.style.color='#3b82f6'"
                   onmouseout="this.style.borderColor='rgba(26,86,240,0.25)';this.style.color='#94a3b8'">
                    <i class="fas fa-globe" style="font-size:11px; margin-inline-end:5px;"></i>
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'ع' }}
                </a>

                {{-- Dark/Light Mode --}}
                <button class="et-mode-btn" onclick="toggleMode()" title="Toggle Mode">
                    <i id="mode-icon" class="fas fa-moon"></i>
                </button>

                {{-- Auth Links --}}
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <a href="{{ route('admin.dashboard') }}" class="btn-ghost" style="padding:8px 16px; font-size:13px;">
                            <i class="fas fa-th-large" style="font-size:11px;"></i>
                            {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                        </a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="btn-ghost" style="padding:8px 16px; font-size:13px;">
                            <i class="fas fa-user" style="font-size:11px;"></i>
                            {{ app()->getLocale() === 'ar' ? 'حسابي' : 'My Account' }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       style="padding:8px 16px; border-radius:10px; border:1px solid rgba(26,86,240,0.25);
                              background:rgba(26,86,240,0.06); color:#94a3b8; font-size:13px; font-weight:600;
                              text-decoration:none; display:flex; align-items:center; gap:6px; transition:all 0.3s;"
                       onmouseover="this.style.borderColor='rgba(26,86,240,0.5)';this.style.color='#3b82f6'"
                       onmouseout="this.style.borderColor='rgba(26,86,240,0.25)';this.style.color='#94a3b8'">
                        <i class="fas fa-sign-in-alt" style="font-size:11px;"></i>
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Login' }}
                    </a>
                @endauth

                {{-- CTA --}}
                <a href="{{ route('contact') }}" class="btn-primary" style="padding:9px 20px; font-size:13px; border-radius:10px;">
                    {{ __('site.start_project') }}
                </a>
            </div>

            {{-- ── Hamburger (Mobile) ── --}}
            <button id="et-hamburger"
                    onclick="toggleMobileMenu()"
                    style="display:none; flex-direction:column; gap:5px; padding:8px; background:none; border:none; cursor:pointer;"
                    aria-label="Menu">
                <span class="et-bar" style="display:block; width:22px; height:2px; background:#94a3b8; border-radius:2px; transition:all 0.3s;"></span>
                <span class="et-bar" style="display:block; width:22px; height:2px; background:#94a3b8; border-radius:2px; transition:all 0.3s;"></span>
                <span class="et-bar" style="display:block; width:22px; height:2px; background:#94a3b8; border-radius:2px; transition:all 0.3s;"></span>
            </button>
        </div>
    </div>

    {{-- ── Mobile Menu ── --}}
    <div id="et-mobile-menu"
         style="display:none; background:rgba(3,4,14,0.98); backdrop-filter:blur(20px);
                border-top:1px solid rgba(26,86,240,0.1); padding:20px;">
        <div style="display:flex; flex-direction:column; gap:4px; max-width:480px; margin:0 auto;">
            <a href="{{ route('home') }}"      class="et-nav-link" style="padding:12px 0; border-bottom:1px solid rgba(26,86,240,0.07);">{{ __('site.home') }}</a>
            <a href="{{ route('services') }}"  class="et-nav-link" style="padding:12px 0; border-bottom:1px solid rgba(26,86,240,0.07);">{{ __('site.services') }}</a>
            <a href="{{ route('portfolio') }}" class="et-nav-link" style="padding:12px 0; border-bottom:1px solid rgba(26,86,240,0.07);">{{ __('site.portfolio') }}</a>
            <a href="{{ route('about') }}"     class="et-nav-link" style="padding:12px 0; border-bottom:1px solid rgba(26,86,240,0.07);">{{ __('site.about') }}</a>
            <a href="{{ route('contact') }}"   class="et-nav-link" style="padding:12px 0;">{{ __('site.contact') }}</a>

            <div style="margin-top:16px; display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                   style="padding:9px 16px; border-radius:8px; border:1px solid rgba(26,86,240,0.25);
                          background:rgba(26,86,240,0.06); color:#94a3b8; font-size:13px;
                          font-weight:600; text-decoration:none;">
                    <i class="fas fa-globe" style="margin-inline-end:5px;"></i>
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'ع' }}
                </a>
                <button class="et-mode-btn" onclick="toggleMode()">
                    <i id="mode-icon-mobile" class="fas fa-moon"></i>
                </button>
                @guest
                    <a href="{{ route('login') }}" class="btn-ghost" style="flex:1; justify-content:center; padding:9px 16px; font-size:13px;">
                        <i class="fas fa-sign-in-alt"></i>
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Login' }}
                    </a>
                @endguest
                <a href="{{ route('contact') }}" class="btn-primary" style="flex:1; justify-content:center; padding:9px 16px; font-size:13px; border-radius:10px;">
                    {{ __('site.start_project') }}
                </a>
            </div>
        </div>
    </div>
</nav>


<style>
    @media (max-width: 900px) {
        .et-desktop-nav { display: none !important; }
        #et-hamburger   { display: flex !important; }
    }
    html.light #et-mobile-menu {
        background: rgba(240,244,255,0.98);
        border-top-color: rgba(26,86,240,0.1);
    }
</style>


<script>
function toggleMobileMenu() {
    const menu = document.getElementById('et-mobile-menu');
    const btn  = document.getElementById('et-hamburger');
    const bars = btn.querySelectorAll('.et-bar');
    const isOpen = menu.style.display === 'block';

    menu.style.display = isOpen ? 'none' : 'block';

    if (!isOpen) {
        bars[0].style.transform = 'translateY(7px) rotate(45deg)';
        bars[0].style.background = '#1a56f0';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'translateY(-7px) rotate(-45deg)';
        bars[2].style.background = '#1a56f0';
    } else {
        bars.forEach(b => { b.style.transform = ''; b.style.opacity = ''; b.style.background = '#94a3b8'; });
    }
}

// Sync mobile mode icon
function updateModeIcon() {
    const isLight = document.documentElement.classList.contains('light');
    ['mode-icon', 'mode-icon-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.className = isLight ? 'fas fa-sun' : 'fas fa-moon';
    });
}
document.addEventListener('DOMContentLoaded', updateModeIcon);
</script>
