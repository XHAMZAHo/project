@extends('layouts.app')
@section('title', __('site.home'))
@section('meta_description', __('site.hero_subtitle'))
@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<section id="hero" style="position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;overflow:hidden;background:#03040e;">
    <canvas id="particles-canvas" style="position:absolute;inset:0;z-index:0;pointer-events:none;"></canvas>
    <div class="glow-orb" style="width:500px;height:500px;top:-100px;left:-100px;background:radial-gradient(circle,rgba(26,86,240,0.15),transparent);z-index:0;"></div>
    <div class="glow-orb" style="width:400px;height:400px;bottom:-50px;right:-50px;background:radial-gradient(circle,rgba(26,86,240,0.1),transparent);z-index:0;"></div>

    <div style="position:relative;z-index:10;text-align:center;padding:0 20px;max-width:900px;margin:0 auto;padding-top:96px;">

        <div class="section-badge" data-aos="fade-down" style="margin-bottom:24px;">
            <i class="fas fa-bolt" style="color:#1a56f0;font-size:10px;"></i>
            {{ app()->getLocale()==='ar' ? 'نحو مستقبل رقمي أذكى' : 'Towards a Smarter Digital Future' }}
        </div>

        <h1 class="et-heading" data-aos="fade-up" data-aos-delay="100"
            style="font-size:clamp(2.8rem,8vw,5.5rem);margin-bottom:24px;line-height:1.05;">
            <span style="display:block;color:#fff;">
                {{ app()->getLocale()==='ar' ? 'نصنع' : 'We Build' }}
            </span>
            <span class="gradient-text-white" style="display:block;">
                {{ app()->getLocale()==='ar' ? 'مستقبلك الرقمي' : 'Your Digital Future' }}
            </span>
        </h1>

        <p style="color:#64748b;font-size:clamp(1rem,2.5vw,1.2rem);max-width:600px;margin:0 auto 40px;line-height:1.8;"
           data-aos="fade-up" data-aos-delay="200">
            {{ __('site.hero_subtitle') }}
        </p>

        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('contact') }}" class="btn-primary animate-pulse-glow" style="padding:14px 32px;font-size:15px;border-radius:14px;">
                <i class="fas fa-rocket"></i>
                {{ __('site.start_project') }}
            </a>
            <a href="{{ route('portfolio') }}" class="btn-ghost" style="padding:14px 32px;font-size:15px;border-radius:14px;">
                {{ __('site.our_work') }}
                <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}"></i>
            </a>
        </div>

        {{-- Scroll --}}
        <div style="margin-top:64px;display:flex;flex-direction:column;align-items:center;gap:6px;animation:bounce 2s infinite;" data-aos="fade-up" data-aos-delay="500">
            <span style="color:#374151;font-size:10px;letter-spacing:.2em;text-transform:uppercase;">Scroll</span>
            <i class="fas fa-chevron-down" style="color:#1a56f0;font-size:13px;"></i>
        </div>
    </div>
</section>

{{-- ═══════════════ STATS ═══════════════ --}}
<section style="padding:80px 20px;background:#030609;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(26,86,240,0.04),transparent);pointer-events:none;"></div>
    <div style="max-width:1100px;margin:0 auto;position:relative;">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
            @foreach([
                ['150','+',__('site.projects_done'),'fas fa-folder-open'],
                ['80', '+',__('site.happy_clients'), 'fas fa-users'],
                ['98', '%',__('site.success_rate'),  'fas fa-chart-line'],
                ['5',  '+',__('site.years_exp'),      'fas fa-star'],
            ] as [$t,$s,$l,$ic])
            <div class="glass" style="border-radius:20px;padding:32px 20px;text-align:center;" data-aos="fade-up">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(26,86,240,0.12);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="{{ $ic }}" style="color:#1a56f0;font-size:18px;"></i>
                </div>
                <div class="stat-number" style="font-size:2.8rem;"
                     data-counter data-target="{{ $t }}" data-suffix="{{ $s }}">0{{ $s }}</div>
                <p style="color:#64748b;font-size:13px;margin-top:6px;">{{ $l }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ SERVICES ═══════════════ --}}
<section style="padding:96px 20px;background:#080d1e;">
    <div style="max-width:1280px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:64px;">
            <div class="section-badge" data-aos="fade-down">{{ __('site.services') }}</div>
            <h2 class="et-heading" style="font-size:clamp(2rem,5vw,3rem);margin-top:16px;margin-bottom:12px;" data-aos="fade-up">
                {{ __('site.services_title') }}
            </h2>
            <p style="color:#64748b;max-width:500px;margin:0 auto;" data-aos="fade-up" data-aos-delay="100">{{ __('site.services_subtitle') }}</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            @php
            $services = [
                ['🌐','fas fa-globe',    __('site.web_design'),   __('site.web_design_desc'),   '#1a56f0'],
                ['📱','fas fa-mobile-alt',__('site.mobile_apps'), __('site.mobile_apps_desc'),  '#3b82f6'],
                ['⚙️','fas fa-cogs',     __('site.systems_dev'),  __('site.systems_dev_desc'),  '#1241c0'],
                ['🎨','fas fa-paint-brush',__('site.ui_ux'),      __('site.ui_ux_desc'),        '#7c3aed'],
                ['🤖','fas fa-brain',    __('site.ai_solutions'), __('site.ai_solutions_desc'), '#0284c7'],
                ['🔒','fas fa-shield-alt',app()->getLocale()==='ar'?'الأمن السيبراني':'Cybersecurity',app()->getLocale()==='ar'?'حماية متكاملة لأنظمتك من التهديدات الرقمية':'Complete protection for your systems from digital threats','#059669'],
            ];
            @endphp
            @foreach($services as $i=>[$em,$ic,$title,$desc,$clr])
            <div class="service-card" data-aos="fade-up" data-aos-delay="{{ $i*70 }}"
                 onclick="window.location='{{ route('services') }}'">
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);
                            display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:24px;
                            transition:all .3s;">
                    {{ $em }}
                </div>
                <h3 style="font-weight:700;font-size:17px;color:var(--text-primary);margin-bottom:10px;">{{ $title }}</h3>
                <p style="color:#64748b;font-size:13.5px;line-height:1.7;margin-bottom:18px;">{{ $desc }}</p>
                <span style="color:#1a56f0;font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:6px;transition:gap .3s;">
                    {{ __('site.learn_more') }}
                    <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}" style="font-size:11px;"></i>
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ PORTFOLIO ═══════════════ --}}
@if($featuredProjects->count())
<section style="padding:96px 20px;background:#03040e;">
    <div style="max-width:1280px;margin:0 auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:64px;flex-wrap:wrap;">
            <div>
                <div class="section-badge" data-aos="fade-right">{{ __('site.portfolio') }}</div>
                <h2 class="et-heading" style="font-size:clamp(2rem,5vw,3rem);margin-top:16px;" data-aos="fade-right" data-aos-delay="100">
                    {{ __('site.portfolio_title') }}
                </h2>
            </div>
            <a href="{{ route('portfolio') }}" class="btn-ghost" data-aos="fade-left">
                {{ __('site.view_all') }} <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}"></i>
            </a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
            @foreach($featuredProjects as $i=>$p)
            <div class="portfolio-card" style="border-radius:20px;overflow:hidden;border:1px solid rgba(26,86,240,0.1);
                         aspect-ratio:4/3;position:relative;cursor:pointer;background:#080d1e;"
                 data-aos="fade-up" data-aos-delay="{{ $i*80 }}"
                 onclick="openModal({{ $p->id }},'{{ addslashes($p->title) }}','{{ addslashes($p->description??'') }}','{{ $p->image_url }}','{{ $p->url??'#' }}')">
                <img src="{{ $p->image_url }}" alt="{{ $p->title }}"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;">
                <div class="portfolio-overlay" style="position:absolute;inset:0;background:rgba(3,4,14,0.88);backdrop-filter:blur(4px);
                             display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:20px;text-align:center;">
                    <h3 style="color:#fff;font-weight:700;font-size:16px;">{{ $p->title }}</h3>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;justify-content:center;">
                        @foreach($p->technologies->take(3) as $tech)
                        <span style="background:rgba(26,86,240,0.2);border:1px solid rgba(26,86,240,0.3);color:#3b82f6;
                                     font-size:11px;padding:3px 10px;border-radius:100px;">{{ $tech->name }}</span>
                        @endforeach
                    </div>
                    <span style="color:#3b82f6;font-size:12px;font-weight:600;">{{ __('site.view_project') }} →</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ TESTIMONIALS ═══════════════ --}}
@if($testimonials->count())
<section style="padding:96px 20px;background:#080d1e;">
    <div style="max-width:1280px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:64px;">
            <div class="section-badge" data-aos="fade-down">{{ __('site.testimonials_title') }}</div>
            <h2 class="et-heading" style="font-size:clamp(2rem,5vw,3rem);margin-top:16px;" data-aos="fade-up">{{ __('site.testimonials_title') }}</h2>
        </div>
        <div class="swiper testimonials-swiper" data-aos="fade-up" data-aos-delay="150">
            <div class="swiper-wrapper" style="padding-bottom:48px;">
                @foreach($testimonials as $t)
                <div class="swiper-slide">
                    <div class="glass" style="border-radius:20px;padding:28px;margin:0 8px;">
                        <div style="display:flex;gap:3px;margin-bottom:14px;">
                            @for($s=1;$s<=5;$s++)
                            <i class="fas fa-star" style="font-size:12px;color:{{ $s<=$t->rating?'#f59e0b':'#1f2937' }};"></i>
                            @endfor
                        </div>
                        <p style="color:#94a3b8;font-size:13.5px;line-height:1.8;margin-bottom:20px;">"{{ $t->content }}"</p>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $t->avatar_url }}" alt="{{ $t->client_name }}"
                                 style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid rgba(26,86,240,0.3);">
                            <div>
                                <p style="color:#fff;font-weight:600;font-size:13px;">{{ $t->client_name }}</p>
                                <p style="color:#1a56f0;font-size:11px;">{{ $t->client_position }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ CTA ═══════════════ --}}
<section style="padding:100px 20px;background:#03040e;position:relative;overflow:hidden;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:300px;
                background:radial-gradient(ellipse,rgba(26,86,240,0.12),transparent);pointer-events:none;"></div>
    <div style="max-width:760px;margin:0 auto;text-align:center;position:relative;z-index:1;">
        <div class="section-badge" data-aos="fade-down" style="margin-bottom:24px;">
            🚀 {{ __('site.start_project') }}
        </div>
        <h2 class="et-heading" style="font-size:clamp(2rem,6vw,3.5rem);margin-bottom:20px;" data-aos="fade-up">
            {{ __('site.cta_title') }}
        </h2>
        <p style="color:#64748b;font-size:16px;margin-bottom:40px;line-height:1.8;" data-aos="fade-up" data-aos-delay="100">
            {{ __('site.cta_subtitle') }}
        </p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('contact') }}" class="btn-primary animate-pulse-glow" style="padding:15px 36px;font-size:15px;border-radius:14px;">
                {{ __('site.get_quote') }}
            </a>
            <a href="{{ route('services') }}" class="btn-ghost" style="padding:15px 36px;font-size:15px;border-radius:14px;">
                {{ __('site.view_services') }}
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════ PROJECT MODAL ═══════════════ --}}
<div id="project-modal" style="display:none;position:fixed;inset:0;z-index:99000;align-items:center;justify-content:center;padding:20px;"
     onclick="if(event.target===this)closeModal()">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.85);backdrop-filter:blur(8px);"></div>
    <div style="position:relative;background:#080d1e;border:1px solid rgba(26,86,240,0.2);border-radius:24px;
                width:100%;max-width:680px;max-height:88vh;overflow-y:auto;z-index:1;">
        <button onclick="closeModal()" style="position:absolute;top:16px;right:16px;z-index:2;
                background:rgba(255,255,255,0.08);border:none;color:#94a3b8;width:32px;height:32px;
                border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;">✕</button>
        <img id="modal-img" src="" alt="" style="width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:24px 24px 0 0;">
        <div style="padding:32px;">
            <h3 id="modal-title" style="font-size:22px;font-weight:900;color:#fff;margin-bottom:12px;"></h3>
            <p id="modal-desc" style="color:#64748b;line-height:1.8;margin-bottom:24px;"></p>
            <a id="modal-link" href="#" target="_blank" class="btn-primary" style="padding:10px 24px;font-size:13px;border-radius:10px;">
                {{ __('site.view_project') }} <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Particles ──
(function(){
    const c=document.getElementById('particles-canvas');
    if(!c) return;
    const ctx=c.getContext('2d');
    let W=c.width=window.innerWidth, H=c.height=window.innerHeight;
    const pts=Array.from({length:70},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.2+.3,dx:(Math.random()-.5)*.35,dy:(Math.random()-.5)*.35,a:Math.random()*.5+.08}));
    function draw(){
        ctx.clearRect(0,0,W,H);
        pts.forEach(p=>{
            ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
            ctx.fillStyle=`rgba(26,86,240,${p.a})`; ctx.fill();
            p.x+=p.dx; p.y+=p.dy;
            if(p.x<0||p.x>W) p.dx*=-1;
            if(p.y<0||p.y>H) p.dy*=-1;
        });
        pts.forEach((a,i)=>pts.slice(i+1).forEach(b=>{
            const d=Math.hypot(a.x-b.x,a.y-b.y);
            if(d<110){ ctx.beginPath(); ctx.moveTo(a.x,a.y); ctx.lineTo(b.x,b.y);
                ctx.strokeStyle=`rgba(26,86,240,${.06*(1-d/110)})`; ctx.lineWidth=.5; ctx.stroke(); }
        }));
        requestAnimationFrame(draw);
    }
    draw();
    window.addEventListener('resize',()=>{ W=c.width=window.innerWidth; H=c.height=window.innerHeight; });
})();

// ── Service card hover icon scale ──
document.querySelectorAll('.service-card').forEach(card=>{
    const icon=card.querySelector('div');
    card.addEventListener('mouseenter',()=>{ if(icon) icon.style.transform='scale(1.12)'; });
    card.addEventListener('mouseleave',()=>{ if(icon) icon.style.transform=''; });
});

// ── Portfolio hover ──
document.querySelectorAll('.portfolio-card').forEach(card=>{
    const img=card.querySelector('img');
    card.addEventListener('mouseenter',()=>{ if(img) img.style.transform='scale(1.08)'; });
    card.addEventListener('mouseleave',()=>{ if(img) img.style.transform=''; });
});

// ── Testimonials Swiper ──
if(document.querySelector('.testimonials-swiper')){
    new Swiper('.testimonials-swiper',{slidesPerView:1,spaceBetween:24,loop:true,autoplay:{delay:4500,disableOnInteraction:false},
        pagination:{el:'.swiper-pagination',clickable:true},breakpoints:{640:{slidesPerView:2},1024:{slidesPerView:3}}});
}

// ── Modal ──
function openModal(id,title,desc,img,url){
    document.getElementById('modal-title').textContent=title;
    document.getElementById('modal-desc').textContent=desc||'';
    document.getElementById('modal-img').src=img;
    document.getElementById('modal-link').href=url;
    const m=document.getElementById('project-modal');
    m.style.display='flex'; document.body.style.overflow='hidden';
}
function closeModal(){
    document.getElementById('project-modal').style.display='none';
    document.body.style.overflow='';
}
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeModal(); });

// ── Responsive grids ──
const style=document.createElement('style');
style.textContent=`
@media(max-width:1024px){ section [style*="grid-template-columns:repeat(3"]{grid-template-columns:repeat(2,1fr)!important;} }
@media(max-width:640px){ section [style*="grid-template-columns:repeat(3"]{grid-template-columns:1fr!important;}
    section [style*="grid-template-columns:repeat(4"]{grid-template-columns:repeat(2,1fr)!important;} }
html.light section[style*="background:#03040e"],html.light section[style*="background:#030609"],html.light section[style*="background:#080d1e"]
    {background:#f0f4ff!important;}
`;
document.head.appendChild(style);
</script>
@endpush
