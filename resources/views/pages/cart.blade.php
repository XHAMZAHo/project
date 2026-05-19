@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'سلة التسوق' : 'Shopping Cart')
@section('content')

<section style="min-height:100vh;padding:120px 20px 60px;background:#03040e;">
<div style="max-width:1100px;margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:14px;">
        <div>
            <div class="section-badge" style="margin-bottom:10px;">
                🛒 {{ app()->getLocale()==='ar' ? 'سلة التسوق' : 'Shopping Cart' }}
            </div>
            <h1 class="et-heading" style="font-size:2rem;color:#fff;">
                {{ app()->getLocale()==='ar' ? 'طلباتك المختارة' : 'Your Selected Services' }}
            </h1>
        </div>
        @if(!empty($cart))
        <form method="POST" action="{{ route('cart.clear') }}">
            @csrf
            <button type="submit" class="btn-ghost" style="padding:9px 18px;font-size:13px;color:#f87171;border-color:rgba(239,68,68,0.3);">
                <i class="fas fa-trash"></i>
                {{ app()->getLocale()==='ar' ? 'إفراغ السلة' : 'Clear Cart' }}
            </button>
        </form>
        @endif
    </div>

    {{-- Alerts --}}
    @if(session('cart_success'))
    <div class="flash-ok" style="margin-bottom:24px;">
        <i class="fas fa-check-circle"></i> {{ session('cart_success') }}
    </div>
    @endif
    @if(session('cart_error'))
    <div class="flash-err" style="margin-bottom:24px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('cart_error') }}
    </div>
    @endif

    @if(empty($cart))
    {{-- Empty State --}}
    <div style="text-align:center;padding:100px 20px;background:rgba(26,86,240,0.04);border:1px solid rgba(26,86,240,0.12);border-radius:24px;">
        <div style="font-size:64px;margin-bottom:20px;">🛒</div>
        <h2 style="color:#fff;font-size:24px;font-weight:700;margin-bottom:12px;">
            {{ app()->getLocale()==='ar' ? 'سلتك فارغة' : 'Your cart is empty' }}
        </h2>
        <p style="color:#64748b;margin-bottom:32px;">
            {{ app()->getLocale()==='ar' ? 'اختر خدمة أو أكثر لإضافتها إلى سلتك' : 'Browse our services and add them to your cart' }}
        </p>
        <a href="{{ route('services') }}" class="btn-primary" style="padding:13px 32px;border-radius:12px;">
            <i class="fas fa-th-large"></i>
            {{ app()->getLocale()==='ar' ? 'تصفح الخدمات' : 'Browse Services' }}
        </a>
    </div>

    @else
    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

        {{-- Cart Items --}}
        <div>
            @foreach($cart as $key => $item)
            <div class="glass" id="cart-item-{{ $loop->index }}"
                 style="border-radius:18px;padding:22px;margin-bottom:16px;display:flex;align-items:center;gap:18px;border:1px solid rgba(26,86,240,0.12);"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">

                {{-- Icon --}}
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(26,86,240,0.12);border:1px solid rgba(26,86,240,0.2);
                            display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                    <i class="{{ $item['icon'] ?? 'fas fa-cogs' }}" style="color:#1a56f0;"></i>
                </div>

                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <h3 style="color:#fff;font-weight:700;font-size:15px;margin-bottom:4px;">{{ $item['service_title'] }}</h3>
                    <p style="color:#1a56f0;font-weight:600;font-size:14px;">
                        @if($item['price_type'] === 'custom' || !$item['price'])
                            {{ app()->getLocale()==='ar' ? 'حسب الطلب' : 'Custom Quote' }}
                        @else
                            {{ number_format($item['price'], 0) }} {{ app()->getLocale()==='ar' ? 'ر.س' : 'SAR' }}
                        @endif
                    </p>
                </div>

                {{-- Remove --}}
                <form method="POST" action="{{ route('cart.remove', $key) }}"
                      onsubmit="return confirm('{{ app()->getLocale()==='ar' ? 'حذف من السلة؟' : 'Remove from cart?' }}')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        style="width:36px;height:36px;border-radius:9px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);
                               color:#f87171;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;">
                        <i class="fas fa-times" style="font-size:13px;"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="glass" style="border-radius:20px;padding:28px;border:1px solid rgba(26,86,240,0.15);position:sticky;top:90px;" data-aos="fade-left">
            <h3 style="color:#fff;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-receipt" style="color:#1a56f0;"></i>
                {{ app()->getLocale()==='ar' ? 'ملخص الطلب' : 'Order Summary' }}
            </h3>

            @foreach($cart as $item)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(26,86,240,0.08);">
                <span style="color:#94a3b8;font-size:13px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item['service_title'] }}</span>
                <span style="color:#fff;font-weight:600;font-size:13px;flex-shrink:0;">
                    @if($item['price_type'] === 'custom' || !$item['price'])
                        <span style="color:#f59e0b;font-size:11px;">{{ app()->getLocale()==='ar' ? 'تسعير' : 'Quote' }}</span>
                    @else
                        {{ number_format($item['price'], 0) }}
                    @endif
                </span>
            </div>
            @endforeach

            <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 0 0;margin-top:4px;">
                <span style="color:#fff;font-weight:700;font-size:15px;">{{ app()->getLocale()==='ar' ? 'الإجمالي' : 'Total' }}</span>
                <span style="color:#1a56f0;font-weight:800;font-size:18px;">
                    {{ $total > 0 ? number_format($total, 0) . ' ' . (app()->getLocale()==='ar' ? 'ر.س' : 'SAR') : (app()->getLocale()==='ar' ? 'حسب الطلب' : 'Custom') }}
                </span>
            </div>

            <a href="{{ route('cart.checkout') }}" class="btn-primary animate-pulse-glow"
               style="width:100%;text-align:center;padding:14px;border-radius:12px;font-size:15px;font-weight:700;margin-top:20px;display:block;">
                <i class="fab fa-whatsapp"></i>
                {{ app()->getLocale()==='ar' ? 'إتمام الطلب عبر واتساب' : 'Complete via WhatsApp' }}
            </a>

            <a href="{{ route('services') }}" style="display:block;text-align:center;margin-top:14px;color:#64748b;font-size:13px;text-decoration:none;">
                ← {{ app()->getLocale()==='ar' ? 'إضافة خدمة أخرى' : 'Add another service' }}
            </a>
        </div>
    </div>
    @endif

</div>
</section>

@push('scripts')
<script>
document.querySelectorAll('button[type="submit"]').forEach(btn => {
    btn.addEventListener('mouseenter', () => btn.style.background = 'rgba(239,68,68,0.2)');
    btn.addEventListener('mouseleave', () => btn.style.background = 'rgba(239,68,68,0.1)');
});
</script>
@endpush

@endsection
