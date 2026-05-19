@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'تفاصيل الطلب' : 'Order Details')
@section('page-title', app()->getLocale()==='ar' ? 'تفاصيل الطلب' : 'Order Details')

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

    {{-- Main Order Details --}}
    <div>
        <div class="adm-card" style="margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <h2 class="sec-head" style="margin:0;"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'الطلب' : 'Order' }} {{ $order->order_number }}</h2>
                <span class="badge {{ $order->statusColor() }}" style="font-size:12px;padding:4px 12px;">{{ $order->statusLabel() }}</span>
            </div>

            <table class="adm-table" style="margin-bottom:24px;">
                <thead>
                    <tr>
                        <th>{{ app()->getLocale()==='ar' ? 'الخدمة' : 'Service' }}</th>
                        <th>{{ app()->getLocale()==='ar' ? 'الكمية' : 'Quantity' }}</th>
                        <th>{{ app()->getLocale()==='ar' ? 'السعر' : 'Price' }}</th>
                        <th>{{ app()->getLocale()==='ar' ? 'الإجمالي' : 'Subtotal' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="color:#fff;font-weight:600;">{{ $item->service_title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price > 0 ? number_format($item->price, 2) : (app()->getLocale()==='ar' ? 'تسعير' : 'Quote') }}</td>
                        <td style="color:#60a5fa;font-weight:700;">{{ $item->subtotal > 0 ? number_format($item->subtotal, 2) : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display:flex;justify-content:flex-end;border-top:1px solid var(--border);padding-top:16px;">
                <div style="width:300px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                        <span style="color:var(--dim);">{{ app()->getLocale()==='ar'?'المجموع الفرعي':'Subtotal' }}:</span>
                        <span style="color:#fff;">{{ $order->subtotal > 0 ? number_format($order->subtotal, 2) : '-' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:800;color:#3b82f6;border-top:1px solid var(--border);padding-top:10px;">
                        <span>{{ app()->getLocale()==='ar'?'الإجمالي':'Total' }}:</span>
                        <span>{{ $order->total > 0 ? number_format($order->total, 2) . ' ' . (app()->getLocale()==='ar'?'ر.س':'SAR') : (app()->getLocale()==='ar'?'حسب الطلب':'Custom Quote') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="adm-card">
            <h3 class="sec-head"><div class="ac"></div> {{ app()->getLocale()==='ar'?'ملاحظات العميل':'Customer Notes' }}</h3>
            <p style="color:#cbd5e1;line-height:1.7;background:var(--bg-base);padding:16px;border-radius:10px;border:1px solid var(--border);">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div>
        <div class="adm-card" style="margin-bottom:24px;">
            <h3 class="sec-head"><div class="ac"></div> {{ app()->getLocale()==='ar'?'تغيير الحالة':'Update Status' }}</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;margin-bottom:16px;">
                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>{{ app()->getLocale()==='ar'?'قيد الانتظار':'Pending' }}</option>
                    <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>{{ app()->getLocale()==='ar'?'مؤكد':'Confirmed' }}</option>
                    <option value="in_progress" {{ $order->status=='in_progress'?'selected':'' }}>{{ app()->getLocale()==='ar'?'قيد التنفيذ':'In Progress' }}</option>
                    <option value="completed" {{ $order->status=='completed'?'selected':'' }}>{{ app()->getLocale()==='ar'?'مكتمل':'Completed' }}</option>
                    <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>{{ app()->getLocale()==='ar'?'ملغي':'Cancelled' }}</option>
                </select>
                <button type="submit" class="btn-adm" style="width:100%;justify-content:center;">{{ app()->getLocale()==='ar'?'تحديث الحالة':'Update Status' }}</button>
            </form>
        </div>

        <div class="adm-card">
            <h3 class="sec-head"><div class="ac"></div> {{ app()->getLocale()==='ar'?'بيانات العميل':'Customer Info' }}</h3>
            <div style="margin-bottom:16px;">
                <p style="color:var(--dim);font-size:11px;text-transform:uppercase;">{{ app()->getLocale()==='ar'?'الاسم':'Name' }}</p>
                <p style="color:#fff;font-weight:600;">{{ $order->customer_name }}</p>
            </div>
            <div style="margin-bottom:16px;">
                <p style="color:var(--dim);font-size:11px;text-transform:uppercase;">{{ app()->getLocale()==='ar'?'الجوال':'Phone' }}</p>
                <p style="color:#fff;font-weight:600;">
                    @if($order->customer_phone)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->customer_phone) }}" target="_blank" style="color:#25d366;text-decoration:none;"><i class="fab fa-whatsapp"></i> {{ $order->customer_phone }}</a>
                    @else
                    -
                    @endif
                </p>
            </div>
            <div style="margin-bottom:16px;">
                <p style="color:var(--dim);font-size:11px;text-transform:uppercase;">{{ app()->getLocale()==='ar'?'البريد':'Email' }}</p>
                <p style="color:#fff;font-weight:600;">
                    @if($order->customer_email)
                    <a href="mailto:{{ $order->customer_email }}" style="color:#60a5fa;text-decoration:none;">{{ $order->customer_email }}</a>
                    @else
                    -
                    @endif
                </p>
            </div>
            <div>
                <p style="color:var(--dim);font-size:11px;text-transform:uppercase;">{{ app()->getLocale()==='ar'?'تاريخ الطلب':'Date' }}</p>
                <p style="color:#fff;font-weight:600;">{{ $order->created_at->format('Y-m-d h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
