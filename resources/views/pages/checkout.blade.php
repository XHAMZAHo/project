@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'إتمام الطلب' : 'Checkout')
@section('content')
<section style="min-height:100vh;padding:120px 20px 60px;background:#03040e;">
<div style="max-width:1100px;margin:0 auto;">

    <div style="text-align:center;margin-bottom:48px;" data-aos="fade-down">
        <div class="section-badge" style="margin-bottom:12px;">
            <i class="fab fa-whatsapp" style="color:#25d366;"></i>
            {{ app()->getLocale()==='ar' ? 'إتمام الطلب' : 'Complete Order' }}
        </div>
        <h1 class="et-heading" style="font-size:2.2rem;color:#fff;">
            {{ app()->getLocale()==='ar' ? 'أكمل بيانات طلبك' : 'Complete Your Order' }}
        </h1>
        <p style="color:#64748b;margin-top:10px;font-size:15px;">
            {{ app()->getLocale()==='ar'
                ? 'سيتم تحويلك إلى واتساب لإتمام التواصل والتأكيد'
                : "You'll be redirected to WhatsApp to confirm and discuss your order" }}
        </p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">

        <div class="glass" style="border-radius:24px;padding:36px;border:1px solid rgba(26,86,240,0.15);" data-aos="fade-right">
            <h3 style="color:#fff;font-weight:700;font-size:17px;margin-bottom:24px;">
                <i class="fas fa-user-circle" style="color:#1a56f0;"></i>
                {{ app()->getLocale()==='ar' ? 'بياناتك الشخصية' : 'Your Information' }}
            </h3>

            <form method="POST" action="{{ route('order.store') }}" id="checkout-form">
                @csrf

                @foreach([
                    ['customer_name',  app()->getLocale()==='ar'?'الاسم الكامل *':'Full Name *',       'text',  true,  app()->getLocale()==='ar'?'أدخل اسمك الكامل':'Enter your full name',  auth()->user()?->name ?? ''],
                    ['customer_email', app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address',  'email', false, 'example@email.com',  auth()->user()?->email ?? ''],
                    ['customer_phone', app()->getLocale()==='ar'?'رقم الجوال':'Phone Number',           'tel',   false, '+966 5X XXX XXXX',  ''],
                ] as [$name, $label, $type, $req, $ph, $val])
                <div style="margin-bottom:20px;">
                    <label style="display:block;color:#94a3b8;font-size:12px;font-weight:600;margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em;">
                        {{ $label }}
                    </label>
                    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $val) }}"
                           placeholder="{{ $ph }}" {{ $req?'required':'' }}
                           style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:12px;padding:13px 16px;color:#fff;font-size:14px;outline:none;font-family:inherit;transition:border-color .2s;"
                           onfocus="this.style.borderColor='#1a56f0'" onblur="this.style.borderColor='rgba(26,86,240,0.2)'">
                    @error($name)<p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>@enderror
                </div>
                @endforeach

                <div style="margin-bottom:24px;">
                    <label style="display:block;color:#94a3b8;font-size:12px;font-weight:600;margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em;">
                        {{ app()->getLocale()==='ar' ? 'ملاحظات إضافية' : 'Additional Notes' }}
                    </label>
                    <textarea name="notes" rows="4"
                              placeholder="{{ app()->getLocale()==='ar' ? 'أي تفاصيل إضافية...' : 'Any additional details...' }}"
                              style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:12px;padding:13px 16px;color:#fff;font-size:14px;outline:none;font-family:inherit;resize:vertical;min-height:90px;">{{ old('notes') }}</textarea>
                </div>

                <div style="background:rgba(37,211,102,0.08);border:1px solid rgba(37,211,102,0.2);border-radius:14px;padding:16px;margin-bottom:24px;display:flex;gap:12px;">
                    <i class="fab fa-whatsapp" style="color:#25d366;font-size:22px;flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <p style="color:#34d399;font-weight:600;font-size:13px;margin-bottom:4px;">
                            {{ app()->getLocale()==='ar' ? 'سيتم إرسال طلبك عبر واتساب' : 'Your order will be sent via WhatsApp' }}
                        </p>
                        <p style="color:#64748b;font-size:12px;line-height:1.6;">
                            {{ app()->getLocale()==='ar'
                                ? 'بعد الضغط على زر التأكيد ستنتقل إلى واتساب برسالة جاهزة تحتوي تفاصيل طلبك'
                                : "After clicking confirm you'll be taken to WhatsApp with a pre-filled order message" }}
                        </p>
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="btn-primary animate-pulse-glow"
                        style="width:100%;padding:16px;font-size:15px;font-weight:700;border-radius:14px;display:flex;align-items:center;justify-content:center;gap:10px;border:none;cursor:pointer;">
                    <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                    {{ app()->getLocale()==='ar' ? 'تأكيد الطلب عبر واتساب' : 'Confirm Order via WhatsApp' }}
                </button>
            </form>
        </div>

        <div style="position:sticky;top:90px;" data-aos="fade-left">
            <div class="glass" style="border-radius:20px;padding:26px;border:1px solid rgba(26,86,240,0.15);margin-bottom:14px;">
                <h3 style="color:#fff;font-weight:700;font-size:15px;margin-bottom:18px;">
                    <i class="fas fa-shopping-bag" style="color:#1a56f0;margin-inline-end:8px;"></i>
                    {{ app()->getLocale()==='ar' ? 'تفاصيل الطلب' : 'Order Details' }}
                </h3>
                @foreach($cart as $item)
                <div style="display:flex;justify-content:space-between;gap:8px;padding:10px 0;border-bottom:1px solid rgba(26,86,240,0.07);">
                    <div style="display:flex;align-items:center;gap:8px;min-width:0;">
                        <i class="{{ $item['icon'] ?? 'fas fa-cogs' }}" style="color:#1a56f0;font-size:12px;"></i>
                        <span style="color:#94a3b8;font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item['service_title'] }}</span>
                    </div>
                    <span style="color:#fff;font-weight:600;font-size:12px;flex-shrink:0;">
                        @if($item['price_type']==='custom'||!$item['price'])
                            <span style="color:#f59e0b;font-size:11px;">{{ app()->getLocale()==='ar'?'تسعير':'Quote' }}</span>
                        @else
                            {{ number_format($item['price'],0) }}
                        @endif
                    </span>
                </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding-top:14px;margin-top:4px;">
                    <span style="color:#fff;font-weight:700;">{{ app()->getLocale()==='ar'?'الإجمالي':'Total' }}</span>
                    <span style="color:#1a56f0;font-weight:800;font-size:18px;">
                        {{ $total>0?number_format($total,0).' '.(app()->getLocale()==='ar'?'ر.س':'SAR'):(app()->getLocale()==='ar'?'حسب الطلب':'Custom') }}
                    </span>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:rgba(26,86,240,0.05);border:1px solid rgba(26,86,240,0.1);border-radius:12px;">
                <i class="fas fa-shield-alt" style="color:#1a56f0;font-size:18px;"></i>
                <div>
                    <p style="color:#fff;font-size:12px;font-weight:600;">{{ app()->getLocale()==='ar'?'طلب آمن ومحمي':'Secure & Protected' }}</p>
                    <p style="color:#64748b;font-size:11px;">{{ app()->getLocale()==='ar'?'بياناتك محمية بالكامل':'Your data is fully protected' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@push('scripts')
<script>
document.getElementById('checkout-form').addEventListener('submit',function(){
    const btn=document.getElementById('submit-btn');
    btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> {{ app()->getLocale()==='ar' ? "جاري المعالجة..." : "Processing..." }}';
    btn.disabled=true;
});
</script>
@endpush
@endsection
