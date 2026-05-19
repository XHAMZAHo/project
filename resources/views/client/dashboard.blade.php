@extends('layouts.client')

@section('title', 'لوحة التحكم')
@section('page_title', 'لوحة التحكم')

@section('content')

{{-- ═══ Welcome Banner ═══ --}}
<div style="
    background: linear-gradient(135deg, rgba(29,78,216,0.15) 0%, rgba(37,99,235,0.06) 60%, transparent 100%);
    border: 1px solid rgba(37,99,235,0.2);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    position: relative;
    overflow: hidden;
">
    <div style="position:absolute;left:-60px;top:-60px;width:200px;height:200px;
        background:radial-gradient(circle,rgba(37,99,235,0.12) 0%,transparent 70%);
        pointer-events:none;"></div>

    <div>
        <div style="font-size:13px;color:#94a3b8;font-weight:600;margin-bottom:6px;">
            {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
        </div>
        <h2 style="font-size:24px;font-weight:900;color:#fff;margin-bottom:6px;">
            أهلاً وسهلاً، {{ explode(' ', auth()->user()->name)[0] }} 👋
        </h2>
        <p style="color:#94a3b8;font-size:14px;font-weight:500;">
            يسعدنا تواجدك — هنا ملخص شامل لحسابك ومشاريعك
        </p>
    </div>

    <a href="https://wa.me/966511946443?text={{ urlencode('مرحباً، أود تقديم طلب خدمة جديد') }}"
       target="_blank"
       style="
           display:inline-flex;align-items:center;gap:10px;
           padding:14px 24px;
           background:linear-gradient(135deg,rgba(37,211,102,0.15),rgba(37,211,102,0.06));
           border:1px solid rgba(37,211,102,0.35);
           border-radius:14px;color:#25d366;text-decoration:none;
           font-weight:800;font-size:15px;white-space:nowrap;
           transition:all 0.3s;flex-shrink:0;
       "
       onmouseover="this.style.background='rgba(37,211,102,0.2)'"
       onmouseout="this.style.background='linear-gradient(135deg,rgba(37,211,102,0.15),rgba(37,211,102,0.06))'">
        <i class="fab fa-whatsapp" style="font-size:20px;"></i>
        طلب خدمة جديدة
    </a>
</div>

{{-- ═══ Stats Grid ═══ --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">

    {{-- Total Projects --}}
    <div style="
        background:#080d1a;border:1px solid rgba(37,99,235,0.15);
        border-radius:16px;padding:22px 24px;
        display:flex;align-items:center;gap:16px;
        transition:border-color 0.3s;
    "
    onmouseover="this.style.borderColor='rgba(37,99,235,0.4)'"
    onmouseout="this.style.borderColor='rgba(37,99,235,0.15)'">
        <div style="
            width:48px;height:48px;border-radius:12px;
            background:linear-gradient(135deg,rgba(37,99,235,0.2),rgba(59,130,246,0.1));
            border:1px solid rgba(37,99,235,0.3);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        ">
            <i class="fas fa-rocket" style="color:#60a5fa;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:28px;font-weight:900;color:#fff;line-height:1;">{{ $stats['total_projects'] }}</div>
            <div style="font-size:12px;color:#64748b;font-weight:600;margin-top:4px;">إجمالي المشاريع</div>
        </div>
    </div>

    {{-- Active Projects --}}
    <div style="
        background:#080d1a;border:1px solid rgba(37,99,235,0.15);
        border-radius:16px;padding:22px 24px;
        display:flex;align-items:center;gap:16px;
        transition:border-color 0.3s;
    "
    onmouseover="this.style.borderColor='rgba(37,99,235,0.4)'"
    onmouseout="this.style.borderColor='rgba(37,99,235,0.15)'">
        <div style="
            width:48px;height:48px;border-radius:12px;
            background:linear-gradient(135deg,rgba(16,185,129,0.2),rgba(16,185,129,0.08));
            border:1px solid rgba(16,185,129,0.3);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        ">
            <i class="fas fa-spinner" style="color:#34d399;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:28px;font-weight:900;color:#34d399;line-height:1;">{{ $stats['active_projects'] }}</div>
            <div style="font-size:12px;color:#64748b;font-weight:600;margin-top:4px;">مشاريع نشطة</div>
        </div>
    </div>

    {{-- Pending Amount --}}
    <div style="
        background:#080d1a;border:1px solid rgba(37,99,235,0.15);
        border-radius:16px;padding:22px 24px;
        display:flex;align-items:center;gap:16px;
        transition:border-color 0.3s;
    "
    onmouseover="this.style.borderColor='rgba(37,99,235,0.4)'"
    onmouseout="this.style.borderColor='rgba(37,99,235,0.15)'">
        <div style="
            width:48px;height:48px;border-radius:12px;
            background:linear-gradient(135deg,rgba(245,158,11,0.2),rgba(245,158,11,0.08));
            border:1px solid rgba(245,158,11,0.3);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        ">
            <i class="fas fa-file-invoice-dollar" style="color:#fbbf24;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:900;color:#fbbf24;line-height:1;">{{ number_format($stats['pending_amount'], 0) }}</div>
            <div style="font-size:12px;color:#64748b;font-weight:600;margin-top:4px;">مبالغ معلقة (ر.س)</div>
        </div>
    </div>

    {{-- Unread Messages --}}
    <div style="
        background:#080d1a;border:1px solid rgba(37,99,235,0.15);
        border-radius:16px;padding:22px 24px;
        display:flex;align-items:center;gap:16px;
        transition:border-color 0.3s;
    "
    onmouseover="this.style.borderColor='rgba(37,99,235,0.4)'"
    onmouseout="this.style.borderColor='rgba(37,99,235,0.15)'">
        <div style="
            width:48px;height:48px;border-radius:12px;
            background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(139,92,246,0.08));
            border:1px solid rgba(139,92,246,0.3);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        ">
            <i class="fas fa-comments" style="color:#a78bfa;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:28px;font-weight:900;color:#a78bfa;line-height:1;">{{ $stats['unread_messages'] }}</div>
            <div style="font-size:12px;color:#64748b;font-weight:600;margin-top:4px;">رسائل غير مقروءة</div>
        </div>
    </div>

</div>

{{-- ═══ Main Grid ═══ --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- Recent Projects --}}
    <div class="client-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;box-shadow:0 0 8px rgba(59,130,246,0.6);"></div>
                <h2 style="font-size:16px;font-weight:800;color:#fff;">آخر المشاريع</h2>
            </div>
            <a href="{{ route('client.projects.index') }}"
               style="font-size:12px;color:#60a5fa;text-decoration:none;font-weight:700;
               padding:5px 12px;border:1px solid rgba(37,99,235,0.3);border-radius:8px;
               transition:all 0.2s;"
               onmouseover="this.style.background='rgba(37,99,235,0.1)'"
               onmouseout="this.style.background='transparent'">
                عرض الكل ←
            </a>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;">
            @forelse($projects as $project)
                <div style="
                    display:flex;align-items:center;justify-content:space-between;
                    padding:14px 16px;border-radius:12px;
                    background:#0c1220;border:1px solid rgba(37,99,235,0.12);
                    transition:border-color 0.2s;
                "
                onmouseover="this.style.borderColor='rgba(37,99,235,0.3)'"
                onmouseout="this.style.borderColor='rgba(37,99,235,0.12)'">
                    <div style="flex:1;min-width:0;">
                        <div style="font-weight:700;color:#fff;font-size:14px;
                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $project->title }}
                        </div>
                        <div style="font-size:11px;color:#64748b;margin-top:3px;">
                            الحالة:
                            <span style="color:#60a5fa;font-weight:700;">
                                @switch($project->status)
                                    @case('active') جارٍ التنفيذ @break
                                    @case('completed') مكتمل @break
                                    @case('pending') قيد الانتظار @break
                                    @case('cancelled') ملغي @break
                                    @default {{ $project->status }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('client.projects.show', $project) }}"
                       class="btn-secondary" style="margin-right:12px;white-space:nowrap;">
                        التفاصيل
                    </a>
                </div>
            @empty
                <div style="text-align:center;padding:32px;color:#475569;">
                    <i class="fas fa-rocket" style="font-size:32px;margin-bottom:12px;opacity:0.3;display:block;"></i>
                    <div style="font-size:14px;font-weight:600;">لا توجد مشاريع بعد</div>
                    <div style="font-size:12px;margin-top:4px;color:#334155;">تواصل معنا لبدء مشروعك</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Invoices --}}
    <div class="client-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:8px;height:8px;border-radius:50%;background:#f59e0b;box-shadow:0 0 8px rgba(245,158,11,0.6);"></div>
                <h2 style="font-size:16px;font-weight:800;color:#fff;">آخر الفواتير</h2>
            </div>
            <a href="{{ route('client.invoices.index') }}"
               style="font-size:12px;color:#60a5fa;text-decoration:none;font-weight:700;
               padding:5px 12px;border:1px solid rgba(37,99,235,0.3);border-radius:8px;
               transition:all 0.2s;"
               onmouseover="this.style.background='rgba(37,99,235,0.1)'"
               onmouseout="this.style.background='transparent'">
                عرض الكل ←
            </a>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;">
            @forelse($invoices as $invoice)
                <div style="
                    display:flex;align-items:center;justify-content:space-between;
                    padding:14px 16px;border-radius:12px;
                    background:#0c1220;border:1px solid rgba(37,99,235,0.12);
                    transition:border-color 0.2s;
                "
                onmouseover="this.style.borderColor='rgba(37,99,235,0.3)'"
                onmouseout="this.style.borderColor='rgba(37,99,235,0.12)'">
                    <div style="flex:1;min-width:0;">
                        <div style="font-weight:700;color:#fff;font-size:14px;">
                            {{ $invoice->invoice_number }}
                        </div>
                        <div style="font-size:13px;color:#94a3b8;margin-top:3px;font-weight:600;">
                            {{ $invoice->currency_symbol ?? 'ر.س' }}{{ number_format($invoice->total, 0) }}
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;margin-right:10px;">
                        <span class="status-badge status-{{ $invoice->status }}">
                            @switch($invoice->status)
                                @case('paid') مدفوعة @break
                                @case('pending') معلقة @break
                                @case('overdue') متأخرة @break
                                @default {{ $invoice->status }}
                            @endswitch
                        </span>
                        @if($invoice->status !== 'paid')
                            <a href="{{ route('client.invoices.pay', $invoice) }}"
                               class="btn-primary" style="padding:7px 14px;font-size:12px;">
                                دفع
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:32px;color:#475569;">
                    <i class="fas fa-file-invoice" style="font-size:32px;margin-bottom:12px;opacity:0.3;display:block;"></i>
                    <div style="font-size:14px;font-weight:600;">لا توجد فواتير</div>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ═══ Quick Actions Banner ═══ --}}
<div style="
    margin-top:20px;
    background:linear-gradient(135deg,rgba(37,211,102,0.06),rgba(37,211,102,0.02));
    border:1px solid rgba(37,211,102,0.2);
    border-radius:16px;padding:20px 24px;
    display:flex;align-items:center;justify-content:space-between;gap:16px;
">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="
            width:44px;height:44px;border-radius:12px;
            background:rgba(37,211,102,0.12);border:1px solid rgba(37,211,102,0.25);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        ">
            <i class="fab fa-whatsapp" style="color:#25d366;font-size:20px;"></i>
        </div>
        <div>
            <div style="font-size:15px;font-weight:800;color:#fff;">هل تريد طلب خدمة جديدة؟</div>
            <div style="font-size:12px;color:#64748b;margin-top:2px;">تواصل معنا مباشرة عبر واتساب وسنتولى الأمر فوراً</div>
        </div>
    </div>
    <a href="https://wa.me/966511946443?text={{ urlencode('مرحباً، أود تقديم طلب خدمة جديد من بوابة العميل') }}"
       target="_blank"
       class="btn-primary"
       style="background:linear-gradient(135deg,#128c3e,#25d366);box-shadow:0 0 20px rgba(37,211,102,0.3);white-space:nowrap;">
        <i class="fab fa-whatsapp"></i>
        تواصل الآن
    </a>
</div>

@endsection
