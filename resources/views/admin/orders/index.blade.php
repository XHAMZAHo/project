@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'طلبات الشراء' : 'Orders')
@section('page-title', app()->getLocale()==='ar' ? 'إدارة الطلبات' : 'Manage Orders')

@section('content')
<div class="adm-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <h2 class="sec-head" style="margin:0;"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'طلبات الشراء' : 'Orders' }}</h2>
        <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex;gap:10px;">
            <select name="status" style="background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:8px 14px;color:#fff;outline:none;" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale()==='ar'?'الكل':'All' }}</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ app()->getLocale()==='ar'?'قيد الانتظار':'Pending' }}</option>
                <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>{{ app()->getLocale()==='ar'?'مؤكد':'Confirmed' }}</option>
                <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>{{ app()->getLocale()==='ar'?'قيد التنفيذ':'In Progress' }}</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>{{ app()->getLocale()==='ar'?'مكتمل':'Completed' }}</option>
                <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>{{ app()->getLocale()==='ar'?'ملغي':'Cancelled' }}</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale()==='ar'?'بحث...':'Search...' }}" style="background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:8px 14px;color:#fff;outline:none;">
            <button type="submit" class="btn-adm" style="padding:8px 16px;"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale()==='ar' ? 'رقم الطلب' : 'Order #' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'العميل' : 'Customer' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الإجمالي' : 'Total' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'تاريخ الطلب' : 'Date' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'واتساب' : 'WhatsApp' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" style="color:#60a5fa;font-weight:600;text-decoration:none;">{{ $order->order_number }}</a></td>
                    <td>
                        <div style="font-weight:600;color:#fff;">{{ $order->customer_name }}</div>
                        @if($order->customer_phone)<div style="font-size:11px;color:var(--muted);">{{ $order->customer_phone }}</div>@endif
                    </td>
                    <td>{{ $order->total > 0 ? number_format($order->total, 2) . ' ' . (app()->getLocale()==='ar' ? 'ر.س' : 'SAR') : (app()->getLocale()==='ar' ? 'تسعير' : 'Quote') }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        @if($order->whatsapp_sent === 'yes')
                            <span class="badge b-act"><i class="fab fa-whatsapp" style="margin-inline-end:4px;"></i> {{ app()->getLocale()==='ar' ? 'تم الإرسال' : 'Sent' }}</span>
                        @else
                            <span class="badge b-pend">{{ app()->getLocale()==='ar' ? 'لم يرسل' : 'Not Sent' }}</span>
                        @endif
                    </td>
                    <td><span class="badge {{ $order->statusColor() }}">{{ $order->statusLabel() }}</span></td>
                    <td>
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-ghost-adm" style="color:#60a5fa;"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد؟' : 'Are you sure?' }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-ghost-adm" style="color:#f87171;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:var(--muted);">{{ app()->getLocale()==='ar' ? 'لا توجد طلبات.' : 'No orders found.' }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $orders->links('pagination::tailwind') }}
    </div>
</div>
@endsection
