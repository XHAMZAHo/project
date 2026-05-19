@extends('layouts.admin')
@section('title', app()->getLocale() === 'ar' ? 'الفواتير' : 'Invoices')
@section('page-title', app()->getLocale() === 'ar' ? 'إدارة <span>الفواتير</span>' : 'Invoice <span>Management</span>')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px;">
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="fas fa-file-invoice"></i></div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-label">{{ $isAr ? 'إجمالي الفواتير' : 'Total Invoices' }}</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $stats['paid'] }}</div>
        <div class="stat-label">{{ $isAr ? 'مدفوعة' : 'Paid' }}</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
        <div class="stat-label">{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon purple"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-value">{{ number_format($stats['revenue'], 0) }}</div>
        <div class="stat-label">{{ $isAr ? 'الإيرادات المحصلة' : 'Total Revenue' }}</div>
    </div>
</div>

{{-- Toolbar --}}
<div class="admin-card" style="margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
        <input name="search" value="{{ request('search') }}" placeholder="{{ $isAr ? 'بحث...' : 'Search invoices...' }}"
               style="flex:1;min-width:200px;background:rgba(37,99,235,0.06);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:#e2e8f0;font-size:13px;outline:none;">
        <select name="status" style="background:rgba(37,99,235,0.06);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:#e2e8f0;font-size:13px;outline:none;">
            <option value="">{{ $isAr ? 'كل الحالات' : 'All Statuses' }}</option>
            <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</option>
            <option value="paid"      {{ request('status')==='paid'      ? 'selected':'' }}>{{ $isAr ? 'مدفوعة' : 'Paid' }}</option>
            <option value="overdue"   {{ request('status')==='overdue'   ? 'selected':'' }}>{{ $isAr ? 'متأخرة' : 'Overdue' }}</option>
            <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>{{ $isAr ? 'ملغاة' : 'Cancelled' }}</option>
        </select>
        <button type="submit" class="btn-primary"><i class="fas fa-search"></i> {{ $isAr ? 'بحث' : 'Search' }}</button>
        <a href="{{ route('admin.invoices.create') }}" class="btn-primary" style="background:linear-gradient(135deg,#10b981,#34d399);box-shadow:0 0 20px rgba(16,185,129,0.3);">
            <i class="fas fa-plus"></i> {{ $isAr ? 'فاتورة جديدة' : 'New Invoice' }}
        </a>
    </form>
</div>

{{-- Table --}}
<div class="admin-card">
    <div class="section-heading">
        <div class="accent-line"></div>
        {{ $isAr ? 'قائمة الفواتير' : 'All Invoices' }}
        <span style="margin-{{ $isAr ? 'right' : 'left' }}:auto;font-size:12px;color:var(--text-muted);">{{ $invoices->total() }} {{ $isAr ? 'فاتورة' : 'invoices' }}</span>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ $isAr ? 'رقم الفاتورة' : 'Invoice #' }}</th>
                <th>{{ $isAr ? 'العميل' : 'Client' }}</th>
                <th>{{ $isAr ? 'المبلغ' : 'Amount' }}</th>
                <th>{{ $isAr ? 'الضريبة' : 'VAT' }}</th>
                <th>{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                <th>{{ $isAr ? 'الحالة' : 'Status' }}</th>
                <th>{{ $isAr ? 'تاريخ الاستحقاق' : 'Due Date' }}</th>
                <th>{{ $isAr ? 'الإجراءات' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $inv)
            <tr>
                <td style="font-weight:700;color:#3b82f6;">{{ $inv->invoice_number }}</td>
                <td>
                    <div style="font-weight:600;color:#e2e8f0;">{{ $inv->client_name }}</div>
                    @if($inv->client_email)
                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $inv->client_email }}</div>
                    @endif
                </td>
                <td>{{ $inv->currency_symbol }} {{ number_format($inv->subtotal, 2) }}</td>
                <td>{{ $inv->tax_rate }}%</td>
                <td style="font-weight:700;color:#e2e8f0;">{{ $inv->currency_symbol }} {{ number_format($inv->total, 2) }}</td>
                <td>
                    @php
                        $badges = [
                            'paid'      => 'badge-done',
                            'pending'   => 'badge-pending',
                            'overdue'   => 'badge-rejected',
                            'cancelled' => 'badge-new',
                        ];
                        $labels = [
                            'paid'      => $isAr ? 'مدفوعة' : 'Paid',
                            'pending'   => $isAr ? 'انتظار' : 'Pending',
                            'overdue'   => $isAr ? 'متأخرة' : 'Overdue',
                            'cancelled' => $isAr ? 'ملغاة' : 'Cancelled',
                        ];
                    @endphp
                    <span class="badge {{ $badges[$inv->status] ?? 'badge-new' }}">{{ $labels[$inv->status] ?? $inv->status }}</span>
                </td>
                <td style="color:var(--text-muted);font-size:12.5px;">
                    {{ $inv->due_date ? $inv->due_date->format('d M Y') : '—' }}
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="{{ route('admin.invoices.show', $inv) }}" class="btn-ghost" style="padding:5px 10px;font-size:11px;" title="{{ $isAr ? 'عرض' : 'View' }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.invoices.pdf', $inv) }}" target="_blank" class="btn-ghost" style="padding:5px 10px;font-size:11px;" title="{{ $isAr ? 'تحميل PDF' : 'Download PDF' }}">
                            <i class="fas fa-file-pdf" style="color:#f87171;"></i>
                        </a>
                        @if($inv->status !== 'paid')
                        <form method="POST" action="{{ route('admin.invoices.update-status', $inv) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn-ghost" style="padding:5px 10px;font-size:11px;" title="{{ $isAr ? 'تأكيد الدفع' : 'Mark Paid' }}">
                                <i class="fas fa-check" style="color:#34d399;"></i>
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.invoices.destroy', $inv) }}" onsubmit="return confirm('{{ $isAr ? 'حذف هذه الفاتورة؟' : 'Delete this invoice?' }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-ghost" style="padding:5px 10px;font-size:11px;" title="{{ $isAr ? 'حذف' : 'Delete' }}">
                                <i class="fas fa-trash" style="color:#f87171;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;">
                <i class="fas fa-file-invoice" style="font-size:28px;display:block;margin-bottom:10px;opacity:0.3;"></i>
                {{ $isAr ? 'لا توجد فواتير بعد.' : 'No invoices yet.' }}
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">{{ $invoices->withQueryString()->links() }}</div>
</div>
@endsection
