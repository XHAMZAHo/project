@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'تم استلام طلبك!' : 'Order Received!')
@section('content')
<section style="min-height:100vh;padding:120px 20px 60px;background:#03040e;display:flex;align-items:center;justify-content:center;">
<div style="max-width:600px;width:100%;text-align:center;" data-aos="zoom-in">

    {{-- Success Animation --}}
    <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,rgba(37,211,102,0.2),rgba(37,211,102,0.08));border:2px solid rgba(37,211,102,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 28px;animation:pulse 2s infinite;">
        <i class="fas fa-check" style="color:#25d366;font-size:40px;"></i>
    </div>

    <div class="section-badge" style="margin-bottom:16px;background:rgba(37,211,102,0.1);border-color:rgba(37,211,102,0.3);">
        <i class="fas fa-check-circle" style="color:#25d366;"></i>
        {{ app()->getLocale()==='ar' ? 'تم استلام طلبك' : 'Order Received' }}
    </div>

    <h1 class="et-heading" style="font-size:2rem;color:#fff;margin-bottom:14px;">
        {{ app()->getLocale()==='ar' ? 'شكراً لك! 🎉' : 'Thank You! 🎉' }}
    </h1>

    <p style="color:#64748b;font-size:15px;line-height:1.8;margin-bottom:8px;">
        {{ app()->getLocale()==='ar'
            ? 'تم تسجيل طلبك بنجاح. اضغط الزر أدناه للتواصل معنا عبر واتساب لإتمام التفاصيل.'
            : 'Your order has been registered. Click below to connect with us via WhatsApp to finalize the details.' }}
    </p>

    @if(!empty($data['order_number']))
    <p style="color:#1a56f0;font-weight:700;font-size:14px;margin-bottom:32px;">
        {{ app()->getLocale()==='ar' ? 'رقم الطلب:' : 'Order #:' }} {{ $data['order_number'] }}
    </p>
    @endif

    {{-- WhatsApp CTA --}}
    @if(!empty($data['wa_url']))
    <a href="{{ $data['wa_url'] }}" target="_blank" rel="noopener"
       style="display:inline-flex;align-items:center;gap:12px;padding:16px 36px;background:linear-gradient(135deg,#128c7e,#25d366);color:#fff;font-weight:700;font-size:16px;border-radius:16px;text-decoration:none;box-shadow:0 0 30px rgba(37,211,102,0.35);transition:all .3s;margin-bottom:20px;"
       onmouseenter="this.style.transform='translateY(-2px)';this.style.boxShadow='0 0 50px rgba(37,211,102,0.5)'"
       onmouseleave="this.style.transform='';this.style.boxShadow='0 0 30px rgba(37,211,102,0.35)'">
        <i class="fab fa-whatsapp" style="font-size:24px;"></i>
        {{ app()->getLocale()==='ar' ? 'فتح واتساب الآن' : 'Open WhatsApp Now' }}
    </a>
    @endif

    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:12px;">
        <a href="{{ route('services') }}" class="btn-ghost" style="padding:12px 24px;border-radius:12px;">
            {{ app()->getLocale()==='ar' ? 'تصفح خدمات أخرى' : 'Browse More Services' }}
        </a>
        <a href="{{ route('home') }}" class="btn-ghost" style="padding:12px 24px;border-radius:12px;">
            {{ app()->getLocale()==='ar' ? 'الصفحة الرئيسية' : 'Back to Home' }}
        </a>
    </div>
</div>
</section>
@push('styles')
<style>
@keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(37,211,102,0.3)} 70%{box-shadow:0 0 0 20px rgba(37,211,102,0)} }
</style>
@endpush
@endsection
