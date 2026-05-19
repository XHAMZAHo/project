@extends('layouts.admin')
@section('title', $invoice->invoice_number)
@section('page-title', 'Invoice <span>{{ $invoice->invoice_number }}</span>')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

    {{-- Main Invoice --}}
    <div class="admin-card" style="background:linear-gradient(135deg,#0b0f1e,#0f1424);">

        {{-- Header --}}
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:36px;flex-wrap:wrap;gap:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                    <div style="width:42px;height:42px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:12px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:16px;color:#fff;box-shadow:0 0 20px rgba(37,99,235,0.4);">ET</div>
                    <div>
                        <div style="font-size:17px;font-weight:800;color:#fff;letter-spacing:.08em;">ELEVA TECH</div>
                        <div style="font-size:11px;color:var(--text-muted);letter-spacing:.1em;">WEB & SYSTEM SOLUTIONS</div>
                    </div>
                </div>
            </div>
            <div style="text-align:{{ $isAr ? 'left' : 'right' }};">
                <div style="font-size:28px;font-weight:900;color:#3b82f6;letter-spacing:.04em;">{{ $invoice->invoice_number }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ $isAr ? 'تاريخ الإنشاء' : 'Issued' }}: {{ $invoice->created_at->format('d M Y') }}</div>
                @if($invoice->due_date)
                <div style="font-size:12px;color:{{ $invoice->status==='overdue'?'#f87171':'var(--text-muted)' }};margin-top:2px;">
                    {{ $isAr ? 'تاريخ الاستحقاق' : 'Due' }}: {{ $invoice->due_date->format('d M Y') }}
                </div>
                @endif
            </div>
        </div>

        {{-- Client info --}}
        <div style="background:rgba(37,99,235,0.06);border:1px solid var(--border);border-radius:12px;padding:18px;margin-bottom:28px;">
            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:10px;">{{ $isAr ? 'فاتورة إلى' : 'Bill To' }}</div>
            <div style="font-size:16px;font-weight:700;color:#fff;margin-bottom:4px;">{{ $invoice->client_name }}</div>
            @if($invoice->client_email) <div style="font-size:13px;color:var(--text-muted);">{{ $invoice->client_email }}</div> @endif
            @if($invoice->client_phone) <div style="font-size:13px;color:var(--text-muted);">{{ $invoice->client_phone }}</div> @endif
        </div>

        {{-- Items Table --}}
        <table style="width:100%;border-collapse:collapse;margin-bottom:24px;">
            <thead>
                <tr style="border-bottom:2px solid var(--border);">
                    <th style="text-align:start;padding:10px 12px;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;">{{ $isAr ? 'الوصف' : 'Description' }}</th>
                    <th style="text-align:center;padding:10px 12px;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;">{{ $isAr ? 'الكمية' : 'Qty' }}</th>
                    <th style="text-align:end;padding:10px 12px;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;">{{ $isAr ? 'السعر' : 'Price' }}</th>
                    <th style="text-align:end;padding:10px 12px;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;">{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr style="border-bottom:1px solid rgba(37,99,235,0.06);">
                    <td style="padding:14px 12px;color:#e2e8f0;font-size:13.5px;">{{ $item->description }}</td>
                    <td style="padding:14px 12px;text-align:center;color:var(--text-dim);">{{ $item->quantity }}</td>
                    <td style="padding:14px 12px;text-align:end;color:var(--text-dim);">{{ $invoice->currency_symbol }} {{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding:14px 12px;text-align:end;font-weight:600;color:#e2e8f0;">{{ $invoice->currency_symbol }} {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div style="display:flex;justify-content:flex-end;">
            <div style="width:280px;">
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:13.5px;border-bottom:1px solid rgba(37,99,235,0.08);">
                    <span style="color:var(--text-muted);">{{ $isAr ? 'المجموع الفرعي' : 'Subtotal' }}</span>
                    <span style="color:#e2e8f0;">{{ $invoice->currency_symbol }} {{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:13.5px;border-bottom:1px solid rgba(37,99,235,0.08);">
                    <span style="color:var(--text-muted);">{{ $isAr ? 'ضريبة القيمة المضافة' : 'VAT' }} ({{ $invoice->tax_rate }}%)</span>
                    <span style="color:#f59e0b;">{{ $invoice->currency_symbol }} {{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:14px 0 6px;font-size:20px;font-weight:900;">
                    <span style="color:#fff;">{{ $isAr ? 'الإجمالي' : 'TOTAL' }}</span>
                    <span style="color:#34d399;">{{ $invoice->currency_symbol }} {{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        @if($invoice->notes)
        <div style="background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:14px;margin-top:24px;">
            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:7px;">{{ $isAr ? 'ملاحظات' : 'Notes' }}</div>
            <p style="font-size:13px;color:#94a3b8;line-height:1.65;">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Actions Sidebar --}}
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'الحالة' : 'Status' }}</div>
            @php
                $bc = ['paid'=>'badge-done','pending'=>'badge-pending','overdue'=>'badge-rejected','cancelled'=>'badge-new'];
                $bl = ['paid'=>($isAr?'مدفوعة':'Paid'),'pending'=>($isAr?'انتظار':'Pending'),'overdue'=>($isAr?'متأخرة':'Overdue'),'cancelled'=>($isAr?'ملغاة':'Cancelled')];
            @endphp
            <span class="badge {{ $bc[$invoice->status] ?? 'badge-new' }}" style="font-size:14px;padding:6px 16px;">{{ $bl[$invoice->status] ?? $invoice->status }}</span>
            @if($invoice->paid_at)
            <div style="font-size:12px;color:var(--text-muted);margin-top:8px;"><i class="fas fa-check-circle" style="color:#34d399;"></i> {{ $isAr ? 'دُفعت بتاريخ' : 'Paid on' }} {{ $invoice->paid_at->format('d M Y') }}</div>
            @endif
        </div>

        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'الإجراءات' : 'Actions' }}</div>
            <div style="display:flex;flex-direction:column;gap:10px;">

                {{-- PDF Download --}}
                <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank" class="btn-primary" style="justify-content:center;">
                    <i class="fas fa-file-pdf"></i> {{ $isAr ? 'تحميل PDF' : 'Download PDF' }}
                </a>



                {{-- Update Status --}}
                <form method="POST" action="{{ route('admin.invoices.update-status', $invoice) }}" style="display:flex;gap:8px;margin-top:10px;">
                    @csrf @method('PATCH')
                    <select name="status" class="form-input" style="padding:6px 10px;font-size:12px;background:rgba(37,99,235,0.05);border:1px solid rgba(37,99,235,0.2);color:#e2e8f0;border-radius:6px;flex:1;">
                        <option value="pending" {{ $invoice->status==='pending'?'selected':'' }}>{{ $isAr?'قيد الانتظار':'Pending' }}</option>
                        <option value="paid" {{ $invoice->status==='paid'?'selected':'' }}>{{ $isAr?'مدفوعة':'Paid' }}</option>
                        <option value="overdue" {{ $invoice->status==='overdue'?'selected':'' }}>{{ $isAr?'متأخرة':'Overdue' }}</option>
                        <option value="cancelled" {{ $invoice->status==='cancelled'?'selected':'' }}>{{ $isAr?'ملغاة':'Cancelled' }}</option>
                    </select>
                    <button type="submit" class="btn-primary" style="padding:6px 12px;font-size:12px;">{{ $isAr?'تحديث':'Update' }}</button>
                </form>

                {{-- Delete --}}
                <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}" onsubmit="return confirm('{{ $isAr ? 'حذف هذه الفاتورة؟' : 'Delete this invoice?' }}')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-ghost" style="width:100%;justify-content:center;border-color:rgba(239,68,68,0.3);color:#f87171;">
                        <i class="fas fa-trash"></i> {{ $isAr ? 'حذف' : 'Delete' }}
                    </button>
                </form>

                <a href="{{ route('admin.invoices.index') }}" class="btn-ghost" style="justify-content:center;margin-top:4px;">
                    <i class="fas fa-arrow-{{ $isAr?'right':'left' }}"></i> {{ $isAr ? 'عودة' : 'Back' }}
                </a>
            </div>
        </div>

        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'ملخص' : 'Summary' }}</div>
            <div style="font-size:13px;color:var(--text-muted);margin-bottom:6px;">{{ $isAr ? 'عدد البنود' : 'Items' }}: <span style="color:#e2e8f0;font-weight:600;">{{ $invoice->items->count() }}</span></div>
            <div style="font-size:13px;color:var(--text-muted);margin-bottom:6px;">{{ $isAr ? 'العملة' : 'Currency' }}: <span style="color:#e2e8f0;font-weight:600;">{{ $invoice->currency }}</span></div>
            <div style="font-size:13px;color:var(--text-muted);">{{ $isAr ? 'تاريخ الإنشاء' : 'Created' }}: <span style="color:#e2e8f0;font-weight:600;">{{ $invoice->created_at->format('d M Y') }}</span></div>
        </div>
    </div>

</div>
@endsection
