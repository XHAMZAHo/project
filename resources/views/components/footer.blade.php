<footer style="background:#03040e; border-top:1px solid rgba(26,86,240,0.1);">
    <div style="max-width:1280px;margin:0 auto;padding:64px 20px 32px;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:48px;">

            {{-- Brand --}}
            <div>
                <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;margin-bottom:20px;text-decoration:none;">
                    <div style="display:flex; align-items:center; justify-content:center; transition:all .3s;">
                        <img src="{{ asset('images/logo.png') }}" alt="ELEVA TECH" class="footer-logo"
                             style="height:40px;width:auto;filter:invert(1) hue-rotate(180deg);mix-blend-mode:screen;transition:filter .3s, mix-blend-mode .3s;">
                    </div>
                </a>
                <p style="color:#64748b;font-size:13.5px;line-height:1.8;max-width:320px;margin-bottom:24px;">
                    {{ __('site.footer_desc') }}
                </p>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="https://wa.me/966511946443" target="_blank"
                       style="width:38px;height:38px;border-radius:10px;border:1px solid rgba(26,86,240,0.2);
                              background:rgba(26,86,240,0.06);display:flex;align-items:center;justify-content:center;
                              color:#94a3b8;text-decoration:none;transition:all .3s;font-size:15px;"
                       onmouseover="this.style.background='rgba(34,197,94,0.15)';this.style.borderColor='rgba(34,197,94,0.4)';this.style.color='#22c55e'"
                       onmouseout="this.style.background='rgba(26,86,240,0.06)';this.style.borderColor='rgba(26,86,240,0.2)';this.style.color='#94a3b8'">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/elevatech___" target="_blank"
                       style="width:38px;height:38px;border-radius:10px;border:1px solid rgba(26,86,240,0.2);
                              background:rgba(26,86,240,0.06);display:flex;align-items:center;justify-content:center;
                              color:#94a3b8;text-decoration:none;transition:all .3s;font-size:15px;"
                       onmouseover="this.style.background='rgba(236,72,153,0.12)';this.style.borderColor='rgba(236,72,153,0.3)';this.style.color='#ec4899'"
                       onmouseout="this.style.background='rgba(26,86,240,0.06)';this.style.borderColor='rgba(26,86,240,0.2)';this.style.color='#94a3b8'">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="mailto:Elevatech2027@gmail.com"
                       style="width:38px;height:38px;border-radius:10px;border:1px solid rgba(26,86,240,0.2);
                              background:rgba(26,86,240,0.06);display:flex;align-items:center;justify-content:center;
                              color:#94a3b8;text-decoration:none;transition:all .3s;font-size:14px;"
                       onmouseover="this.style.background='rgba(26,86,240,0.15)';this.style.borderColor='rgba(26,86,240,0.45)';this.style.color='#3b82f6'"
                       onmouseout="this.style.background='rgba(26,86,240,0.06)';this.style.borderColor='rgba(26,86,240,0.2)';this.style.color='#94a3b8'">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 style="color:#1a56f0;font-size:11px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;margin-bottom:20px;">
                    {{ __('site.quick_links') }}
                </h3>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['home',      __('site.home')],
                        ['services',  __('site.services')],
                        ['portfolio', __('site.portfolio')],
                        ['about',     __('site.about')],
                        ['contact',   __('site.contact')],
                    ] as [$r,$l])
                    <li>
                        <a href="{{ route($r) }}"
                           style="color:#64748b;font-size:13.5px;text-decoration:none;display:flex;align-items:center;gap:8px;transition:color .3s;"
                           onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#64748b'">
                            <i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}" style="font-size:9px;color:#1a56f0;"></i>
                            {{ $l }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 style="color:#1a56f0;font-size:11px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;margin-bottom:20px;">
                    {{ __('site.contact') }}
                </h3>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:14px;">
                    <li style="display:flex;align-items:flex-start;gap:10px;">
                        <div style="width:28px;height:28px;border-radius:8px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <i class="fab fa-whatsapp" style="color:#22c55e;font-size:12px;"></i>
                        </div>
                        <a href="https://wa.me/966511946443" target="_blank" style="color:#64748b;font-size:13px;text-decoration:none;direction:ltr;display:inline-block;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#64748b'">+966 51 194 6443</a>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:10px;">
                        <div style="width:28px;height:28px;border-radius:8px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <i class="fas fa-envelope" style="color:#3b82f6;font-size:11px;"></i>
                        </div>
                        <a href="mailto:Elevatech2027@gmail.com" style="color:#64748b;font-size:13px;text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#64748b'">Elevatech2027@gmail.com</a>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:10px;">
                        <div style="width:28px;height:28px;border-radius:8px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <i class="fab fa-instagram" style="color:#ec4899;font-size:12px;"></i>
                        </div>
                        <a href="https://www.instagram.com/elevatech___" target="_blank" style="color:#64748b;font-size:13px;text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#64748b'">@elevatech___</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom --}}
        <div style="margin-top:48px;padding-top:24px;border-top:1px solid rgba(26,86,240,0.08);
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="color:#374151;font-size:13px;">© {{ date('Y') }} ELEVA TECH. {{ __('site.all_rights') }}.</p>
            <div style="display:flex;gap:20px;">
                <a href="#" style="color:#374151;font-size:13px;text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#374151'">{{ __('site.privacy') }}</a>
                <a href="#" style="color:#374151;font-size:13px;text-decoration:none;" onmouseover="this.style.color='#3b82f6'" onmouseout="this.style.color='#374151'">{{ __('site.terms') }}</a>
            </div>
        </div>
    </div>

    <style>
        html.light footer { background:#0f172a !important; }
        html.light .footer-logo { filter: invert(1) brightness(0.5) sepia(1) hue-rotate(180deg) saturate(2) !important; mix-blend-mode: multiply !important; }
        @media(max-width:768px){
            footer > div > div:first-child > div:first-child { grid-template-columns:1fr !important; }
        }
    </style>

    <style>
        @media(max-width:768px){
            footer .ft-grid { grid-template-columns:1fr !important; }
        }
    </style>
</footer>
<style>
footer div[style*="grid-template-columns:2fr"] {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 48px;
}
@media(max-width:900px){
    footer div[style*="grid-template-columns:2fr"] {
        grid-template-columns: 1fr 1fr !important;
    }
}
@media(max-width:600px){
    footer div[style*="grid-template-columns:2fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
