@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'الأسئلة الشائعة' : 'FAQ')
@section('meta_description', app()->getLocale()==='ar' ? 'أسئلة متكررة حول خدمات إليفا تك' : 'Frequently asked questions about ELEVA TECH services')
@section('content')

{{-- Hero --}}
<section style="padding:120px 20px 60px;background:#080d1e;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at top,rgba(26,86,240,0.12),transparent 60%);pointer-events:none;"></div>
    <div style="max-width:800px;margin:0 auto;text-align:center;position:relative;">
        <div class="section-badge" data-aos="fade-down" style="margin-bottom:16px;">
            <i class="fas fa-question-circle" style="color:#1a56f0;"></i>
            FAQ
        </div>
        <h1 class="et-heading" style="font-size:clamp(2rem,6vw,3.5rem);margin-bottom:16px;" data-aos="fade-up">
            {{ app()->getLocale()==='ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}
        </h1>
        <p style="color:#64748b;font-size:16px;max-width:560px;margin:0 auto;" data-aos="fade-up" data-aos-delay="100">
            {{ app()->getLocale()==='ar'
                ? 'إجابات لأكثر الأسئلة شيوعاً حول خدماتنا وطريقة عملنا'
                : 'Answers to the most common questions about our services and how we work' }}
        </p>

        {{-- Search --}}
        <div style="margin-top:32px;position:relative;max-width:460px;margin-inline:auto;" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-search" style="position:absolute;top:50%;transform:translateY(-50%);inset-inline-start:16px;color:#64748b;font-size:14px;pointer-events:none;"></i>
            <input type="text" id="faq-search" placeholder="{{ app()->getLocale()==='ar' ? 'ابحث عن سؤال...' : 'Search questions...' }}"
                   style="width:100%;background:rgba(26,86,240,0.08);border:1px solid rgba(26,86,240,0.2);border-radius:14px;padding:13px 16px 13px 44px;color:#fff;font-size:14px;outline:none;font-family:inherit;"
                   oninput="filterFaqs(this.value)">
        </div>
    </div>
</section>

{{-- FAQ Sections --}}
<section style="padding:60px 20px 100px;background:#03040e;">
<div style="max-width:800px;margin:0 auto;">

    @if($faqs->isEmpty())
    <div style="text-align:center;padding:80px 20px;color:#64748b;">
        <i class="fas fa-question-circle" style="font-size:48px;margin-bottom:16px;display:block;"></i>
        <p>{{ app()->getLocale()==='ar' ? 'لا توجد أسئلة بعد' : 'No FAQs yet' }}</p>
    </div>
    @else

    @php
    $catLabels = [
        'general'   => ['ar' => 'عام', 'en' => 'General'],
        'services'  => ['ar' => 'الخدمات', 'en' => 'Services'],
        'payment'   => ['ar' => 'الدفع', 'en' => 'Payment'],
        'technical' => ['ar' => 'تقني', 'en' => 'Technical'],
    ];
    $locale = app()->getLocale();
    @endphp

    @foreach($faqs as $category => $items)
    <div class="faq-category" style="margin-bottom:48px;" data-aos="fade-up">
        @if($category)
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <div style="width:4px;height:20px;background:linear-gradient(to bottom,#1a56f0,#3b82f6);border-radius:4px;"></div>
            <h2 style="color:#fff;font-size:17px;font-weight:700;">
                {{ ($catLabels[$category][$locale] ?? ucfirst($category)) }}
            </h2>
        </div>
        @endif

        <div id="faq-list">
        @foreach($items as $i => $faq)
        <div class="faq-item" data-q="{{ strtolower(app()->getLocale()==='ar' ? $faq->question_ar : $faq->question_en) }}"
             style="border:1px solid rgba(26,86,240,0.12);border-radius:16px;margin-bottom:12px;overflow:hidden;background:rgba(8,13,30,0.5);transition:border-color .2s;"
             data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
            <button onclick="toggleFaq(this)"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 20px;background:none;border:none;cursor:pointer;text-align:start;color:#fff;font-size:14.5px;font-weight:600;font-family:inherit;">
                <span>{{ app()->getLocale()==='ar' ? $faq->question_ar : $faq->question_en }}</span>
                <i class="fas fa-plus" style="font-size:13px;color:#1a56f0;flex-shrink:0;transition:transform .3s;"></i>
            </button>
            <div class="faq-answer" style="max-height:0;overflow:hidden;transition:max-height .4s ease;padding:0 20px;">
                <p style="color:#94a3b8;font-size:14px;line-height:1.8;padding-bottom:20px;">
                    {{ app()->getLocale()==='ar' ? $faq->answer_ar : $faq->answer_en }}
                </p>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    @endforeach
    @endif

    {{-- CTA --}}
    <div class="glass" style="border-radius:20px;padding:36px;text-align:center;border:1px solid rgba(26,86,240,0.15);margin-top:20px;" data-aos="fade-up">
        <i class="fas fa-headset" style="color:#1a56f0;font-size:36px;margin-bottom:16px;display:block;"></i>
        <h3 style="color:#fff;font-weight:700;font-size:18px;margin-bottom:10px;">
            {{ app()->getLocale()==='ar' ? 'لم تجد ما تبحث عنه؟' : "Didn't find what you're looking for?" }}
        </h3>
        <p style="color:#64748b;font-size:14px;margin-bottom:24px;">
            {{ app()->getLocale()==='ar' ? 'فريقنا جاهز للإجابة على أي سؤال' : 'Our team is ready to answer any question' }}
        </p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" class="btn-primary" style="padding:12px 28px;border-radius:12px;">
                <i class="fas fa-envelope"></i>
                {{ app()->getLocale()==='ar' ? 'تواصل معنا' : 'Contact Us' }}
            </a>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','966500000000') }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.3);color:#25d366;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">
                <i class="fab fa-whatsapp"></i>
                WhatsApp
            </a>
        </div>
    </div>

</div>
</section>

@push('scripts')
<script>
function toggleFaq(btn) {
    const item   = btn.closest('.faq-item');
    const answer = item.querySelector('.faq-answer');
    const icon   = btn.querySelector('i');
    const open   = answer.style.maxHeight && answer.style.maxHeight !== '0px';

    // Close all
    document.querySelectorAll('.faq-answer').forEach(a => a.style.maxHeight = '0px');
    document.querySelectorAll('.faq-item button i').forEach(i => { i.style.transform=''; i.classList.replace('fa-minus','fa-plus'); });
    document.querySelectorAll('.faq-item').forEach(it => it.style.borderColor='rgba(26,86,240,0.12)');

    if (!open) {
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(45deg)';
        icon.classList.replace('fa-plus','fa-minus');
        item.style.borderColor = 'rgba(26,86,240,0.35)';
    }
}

function filterFaqs(q) {
    const term = q.toLowerCase().trim();
    document.querySelectorAll('.faq-item').forEach(item => {
        const question = item.dataset.q || '';
        item.style.display = (!term || question.includes(term)) ? '' : 'none';
    });
}
</script>
@endpush
@endsection
