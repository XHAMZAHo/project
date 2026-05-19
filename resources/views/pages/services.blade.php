@extends('layouts.app')
@section('title', __('site.services'))
@section('content')

<section style="padding:120px 20px 60px;background:#080d1e;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at top,rgba(26,86,240,0.12),transparent 60%);pointer-events:none;"></div>
    <div style="max-width:800px;margin:0 auto;text-align:center;position:relative;">
        <div class="section-badge" data-aos="fade-down">{{ __('site.services') }}</div>
        <h1 class="et-heading" style="font-size:clamp(2rem,6vw,3.5rem);margin-top:16px;margin-bottom:14px;" data-aos="fade-up">
            {{ __('site.services_title') }}
        </h1>
        <p style="color:#64748b;font-size:16px;max-width:560px;margin:0 auto;" data-aos="fade-up" data-aos-delay="100">
            {{ __('site.services_subtitle') }}
        </p>
    </div>
</section>

<section style="padding:60px 20px 100px;background:#03040e;">
<div style="max-width:1280px;margin:0 auto;">

    {{-- Cart notification --}}
    @if(session('cart_success'))
    <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);border-radius:12px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:10px;color:#34d399;font-size:14px;" id="cart-alert">
        <i class="fas fa-check-circle"></i> {{ session('cart_success') }}
    </div>
    @endif

    {{-- Cart Indicator --}}
    <div style="display:flex;justify-content:flex-end;margin-bottom:28px;" data-aos="fade-left">
        <a href="{{ route('cart.index') }}" id="cart-indicator"
           style="display:inline-flex;align-items:center;gap:9px;padding:10px 20px;background:rgba(26,86,240,0.08);border:1px solid rgba(26,86,240,0.2);border-radius:12px;color:#3b82f6;text-decoration:none;font-size:13px;font-weight:600;transition:all .2s;"
           onmouseenter="this.style.background='rgba(26,86,240,0.15)'" onmouseleave="this.style.background='rgba(26,86,240,0.08)'">
            <i class="fas fa-shopping-cart"></i>
            {{ app()->getLocale()==='ar' ? 'السلة' : 'Cart' }}
            <span id="cart-count-badge"
                  style="background:#1a56f0;color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;min-width:20px;text-align:center;">
                {{ count(session('cart', [])) }}
            </span>
        </a>
    </div>

    @if($services->isEmpty())
    {{-- Fallback static services --}}
    @php
    $staticServices = [
        ['icon'=>'fas fa-globe','title_ar'=>'تطوير المواقع','title_en'=>'Web Development','desc_ar'=>'مواقع احترافية سريعة ومتجاوبة','desc_en'=>'Fast, responsive professional websites','feats_ar'=>['تصميم UI/UX','Front & Back-end','SEO','أداء عالي'],'feats_en'=>['UI/UX Design','Front & Back-end','SEO','High Performance'],'color'=>'#1a56f0','slug'=>'web-development','price'=>null],
        ['icon'=>'fas fa-mobile-alt','title_ar'=>'تطبيقات الجوال','title_en'=>'Mobile Apps','desc_ar'=>'تطبيقات iOS وAndroid باحترافية عالية','desc_en'=>'Professional iOS & Android apps','feats_ar'=>['React Native / Flutter','واجهات سلسة','تكامل APIs','نشر على المتاجر'],'feats_en'=>['React Native / Flutter','Smooth UI','API Integration','App Store Publishing'],'color'=>'#3b82f6','slug'=>'mobile-development','price'=>null],
        ['icon'=>'fas fa-cogs','title_ar'=>'تطوير الأنظمة','title_en'=>'Systems Development','desc_ar'=>'أنظمة إدارة ERP ونقاط البيع','desc_en'=>'ERP management & point of sale systems','feats_ar'=>['ERP','POS','تقارير','بوابات الدفع'],'feats_en'=>['ERP','POS','Reports','Payment Gateways'],'color'=>'#1241c0','slug'=>'system-development','price'=>null],
        ['icon'=>'fas fa-paint-brush','title_ar'=>'تصميم UI/UX','title_en'=>'UI/UX Design','desc_ar'=>'تصاميم عصرية تبهر المستخدم','desc_en'=>'Modern designs that impress users','feats_ar'=>['Wireframes','Prototypes','User Testing','توجيهات تصميمية'],'feats_en'=>['Wireframes','Prototypes','User Testing','Design Guidelines'],'color'=>'#7c3aed','slug'=>'ui-ux-design','price'=>null],
        ['icon'=>'fas fa-brain','title_ar'=>'حلول الذكاء الاصطناعي','title_en'=>'AI Solutions','desc_ar'=>'روبوتات وتحليلات ذكاء اصطناعي','desc_en'=>'AI chatbots and smart analytics','feats_ar'=>['تعلم آلي','معالجة لغة طبيعية','تحليل بيانات','روبوتات'],'feats_en'=>['Machine Learning','NLP','Data Analytics','Chatbots'],'color'=>'#0284c7','slug'=>'ai-solutions','price'=>null],
        ['icon'=>'fas fa-shield-alt','title_ar'=>'الأمن السيبراني','title_en'=>'Cybersecurity','desc_ar'=>'حماية أنظمتك من التهديدات','desc_en'=>'Protect your systems from threats','feats_ar'=>['اختبار الاختراق','مراجعة الأمن','SSL','مراقبة 24/7'],'feats_en'=>['Penetration Testing','Security Audit','SSL','24/7 Monitoring'],'color'=>'#059669','slug'=>'cybersecurity','price'=>null],
    ];
    @endphp
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;" class="services-grid">
        @foreach($staticServices as $i => $srv)
        <div class="service-card glass" style="border-radius:20px;padding:28px;display:flex;flex-direction:column;border:1px solid rgba(26,86,240,0.1);" data-aos="fade-up" data-aos-delay="{{ $i*70 }}">
            <div style="width:58px;height:58px;border-radius:16px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:22px;">
                <i class="{{ $srv['icon'] }}" style="color:{{ $srv['color'] }};"></i>
            </div>
            <h2 style="color:#fff;font-weight:800;font-size:18px;margin-bottom:10px;">{{ app()->getLocale()==='ar' ? $srv['title_ar'] : $srv['title_en'] }}</h2>
            <p style="color:#64748b;font-size:13.5px;line-height:1.7;margin-bottom:18px;">{{ app()->getLocale()==='ar' ? $srv['desc_ar'] : $srv['desc_en'] }}</p>
            <ul style="list-style:none;padding:0;margin:0 0 auto;space-y:6px;">
                @foreach((app()->getLocale()==='ar' ? $srv['feats_ar'] : $srv['feats_en']) as $feat)
                <li style="display:flex;align-items:center;gap:8px;color:#94a3b8;font-size:13px;padding:4px 0;">
                    <i class="fas fa-check-circle" style="color:#1a56f0;font-size:12px;"></i> {{ $feat }}
                </li>
                @endforeach
            </ul>
            <div style="margin-top:22px;padding-top:18px;border-top:1px solid rgba(26,86,240,0.08);display:flex;gap:10px;align-items:center;">
                <span style="color:#64748b;font-size:13px;flex:1;">{{ app()->getLocale()==='ar' ? 'حسب الطلب' : 'Custom Quote' }}</span>
                <a href="{{ route('contact') }}" class="btn-primary" style="padding:9px 18px;font-size:12px;border-radius:10px;">
                    {{ app()->getLocale()==='ar' ? 'استفسر' : 'Inquire' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @else
    {{-- DB-driven services with Add to Cart --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;" class="services-grid">
        @foreach($services as $i => $service)
        <div class="service-card glass" style="border-radius:20px;padding:28px;display:flex;flex-direction:column;border:1px solid rgba(26,86,240,0.1);" data-aos="fade-up" data-aos-delay="{{ $i*70 }}">
            <div style="width:58px;height:58px;border-radius:16px;background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:22px;">
                <i class="{{ $service->icon }}" style="color:{{ $service->color }};"></i>
            </div>
            <h2 style="color:#fff;font-weight:800;font-size:18px;margin-bottom:10px;">{{ $service->title }}</h2>
            <p style="color:#64748b;font-size:13.5px;line-height:1.7;margin-bottom:18px;">{{ $service->description }}</p>
            @if($service->features_array)
            <ul style="list-style:none;padding:0;margin:0 0 auto;">
                @foreach($service->features_array as $feat)
                <li style="display:flex;align-items:center;gap:8px;color:#94a3b8;font-size:13px;padding:4px 0;">
                    <i class="fas fa-check-circle" style="color:#1a56f0;font-size:12px;"></i> {{ $feat }}
                </li>
                @endforeach
            </ul>
            @endif
            <div style="margin-top:22px;padding-top:18px;border-top:1px solid rgba(26,86,240,0.08);display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="flex:1;">
                    <span style="color:#1a56f0;font-weight:700;font-size:15px;">{{ $service->price_label }}</span>
                    @if($service->delivery_days)
                    <p style="color:#64748b;font-size:11px;margin-top:2px;">
                        <i class="fas fa-clock" style="font-size:10px;"></i> {{ $service->delivery_days }}
                    </p>
                    @endif
                </div>
                <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <button type="submit" class="btn-primary add-to-cart-btn"
                            style="padding:9px 18px;font-size:12px;border-radius:10px;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:7px;"
                            data-service-id="{{ $service->id }}">
                        <i class="fas fa-cart-plus"></i>
                        {{ app()->getLocale()==='ar' ? 'أضف للسلة' : 'Add to Cart' }}
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- CTA --}}
    <div style="text-align:center;margin-top:64px;" data-aos="fade-up">
        <a href="{{ route('contact') }}" class="btn-primary" style="padding:14px 36px;font-size:15px;border-radius:14px;">
            <i class="fas fa-rocket"></i>
            {{ app()->getLocale()==='ar' ? 'ابدأ مشروعك الآن' : 'Start Your Project Now' }}
        </a>
    </div>

</div>
</section>

@push('scripts')
<script>
// AJAX Add to Cart
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('.add-to-cart-btn');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;

        try {
            const res = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ service_id: this.querySelector('[name=service_id]').value })
            });
            const data = await res.json();

            if (data.status === 'added') {
                btn.innerHTML = '<i class="fas fa-check"></i> {{ app()->getLocale()==='ar' ? 'تمت الإضافة' : 'Added!' }}';
                btn.style.background = 'linear-gradient(135deg,#059669,#10b981)';
                document.getElementById('cart-count-badge').textContent = data.count;
                setTimeout(() => { btn.innerHTML = original; btn.style.background = ''; btn.disabled = false; }, 2500);
            } else {
                btn.innerHTML = '<i class="fas fa-info-circle"></i> {{ app()->getLocale()==='ar' ? 'موجود مسبقاً' : 'Already Added' }}';
                btn.style.background = 'linear-gradient(135deg,#d97706,#f59e0b)';
                setTimeout(() => { btn.innerHTML = original; btn.style.background = ''; btn.disabled = false; }, 2000);
            }
        } catch(err) {
            btn.innerHTML = original;
            btn.disabled = false;
        }
    });
});

// Responsive grid
const s = document.createElement('style');
s.textContent = `
@media(max-width:1024px){.services-grid{grid-template-columns:repeat(2,1fr)!important;}}
@media(max-width:640px){.services-grid{grid-template-columns:1fr!important;}}
`;
document.head.appendChild(s);
</script>
@endpush
@endsection
