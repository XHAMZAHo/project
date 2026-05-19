@extends('layouts.admin')
@section('title', app()->getLocale() === 'ar' ? 'إنشاء فاتورة' : 'Create Invoice')
@section('page-title', app()->getLocale() === 'ar' ? 'إنشاء <span>فاتورة جديدة</span>' : 'Create <span>New Invoice</span>')

@push('styles')
<style>
.form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 28px; margin-bottom: 20px; }
.form-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text-dim); margin-bottom: 7px; text-transform: uppercase; letter-spacing: .05em; }
.form-input {
    width: 100%;
    background: rgba(37,99,235,0.05);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 11px 14px;
    color: #e2e8f0; font-size: 13.5px;
    outline: none; transition: all .2s;
    font-family: inherit;
}
.form-input:focus { border-color: var(--blue-glow); background: rgba(37,99,235,0.1); box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
@media(max-width:700px){ .form-grid-2,.form-grid-3{ grid-template-columns:1fr; } }

/* Items table */
.items-table { width:100%; border-collapse:collapse; }
.items-table th { font-size:11px; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em; padding:8px 10px; border-bottom:1px solid var(--border); text-align:start; }
.items-table td { padding:8px 6px; vertical-align:middle; }
.items-table .form-input { padding:9px 12px; font-size:13px; }

.totals-box { background: rgba(37,99,235,0.05); border: 1px solid var(--border); border-radius: 12px; padding: 20px; }
.total-row { display:flex; justify-content:space-between; padding:6px 0; font-size:13.5px; }
.total-row.final { font-size:18px; font-weight:800; color:#fff; padding-top:14px; border-top:1px solid var(--border); margin-top:8px; }
.total-row span:first-child { color: var(--text-muted); }
</style>
@endpush

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp

@if($errors->any())
<div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;color:#f87171;font-size:13px;">
    <i class="fas fa-exclamation-circle"></i>
    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
</div>
@endif

<form method="POST" action="{{ route('admin.invoices.store') }}" id="invoice-form">
@csrf

<div style="display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start;">

    <div>
        {{-- Client Info --}}
        <div class="form-card">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'بيانات العميل' : 'Client Information' }}</div>
            <div class="form-grid-2" style="margin-bottom:14px;">
                <div>
                    <label class="form-label">{{ $isAr ? 'اسم العميل *' : 'Client Name *' }}</label>
                    <input name="client_name" class="form-input" value="{{ old('client_name', $prefilled['client_name'] ?? '') }}" required placeholder="{{ $isAr ? 'الاسم الكامل' : 'Full name' }}">
                </div>
                <div>
                    <label class="form-label">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</label>
                    <input name="client_email" type="email" class="form-input" value="{{ old('client_email', $prefilled['client_email'] ?? '') }}" placeholder="email@example.com" dir="ltr">
                </div>
            </div>
            <div class="form-grid-3">
                <div>
                    <label class="form-label">{{ $isAr ? 'رقم الهاتف' : 'Phone' }}</label>
                    <input name="client_phone" class="form-input" value="{{ old('client_phone') }}" placeholder="+966 5x xxx xxxx" dir="ltr">
                </div>
                <div>
                    <label class="form-label">{{ $isAr ? 'العملة' : 'Currency' }}</label>
                    <select name="currency" class="form-input">
                        @foreach(['SAR'=>'SAR - ريال سعودي','USD'=>'USD - Dollar','EUR'=>'EUR - Euro','AED'=>'AED - درهم'] as $k=>$v)
                        <option value="{{ $k }}" {{ old('currency','SAR')===$k?'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">{{ $isAr ? 'تاريخ الاستحقاق' : 'Due Date' }}</label>
                    <input name="due_date" type="date" class="form-input" value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}">
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="form-card">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'بنود الفاتورة' : 'Invoice Items' }}</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:45%;">{{ $isAr ? 'الوصف' : 'Description' }}</th>
                        <th style="width:12%;">{{ $isAr ? 'الكمية' : 'Qty' }}</th>
                        <th style="width:20%;">{{ $isAr ? 'سعر الوحدة' : 'Unit Price' }}</th>
                        <th style="width:18%;">{{ $isAr ? 'الإجمالي' : 'Subtotal' }}</th>
                        <th style="width:5%;"></th>
                    </tr>
                </thead>
                <tbody id="items-body">
                    <tr class="item-row">
                        <td><input name="items[0][description]" class="form-input" required placeholder="{{ $isAr ? 'وصف الخدمة' : 'Service description' }}"></td>
                        <td><input name="items[0][quantity]" type="number" min="1" value="1" class="form-input qty-input" required></td>
                        <td><input name="items[0][unit_price]" type="number" step="0.01" min="0" value="0" class="form-input price-input" required></td>
                        <td><input class="form-input subtotal-input" readonly style="color:#34d399;font-weight:700;" value="0.00"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="add-item" class="btn-ghost" style="margin-top:14px;width:100%;justify-content:center;">
                <i class="fas fa-plus"></i> {{ $isAr ? 'إضافة بند' : 'Add Item' }}
            </button>
        </div>

        {{-- Notes --}}
        <div class="form-card">
            <label class="form-label">{{ $isAr ? 'ملاحظات' : 'Notes' }}</label>
            <textarea name="notes" class="form-input" rows="3" placeholder="{{ $isAr ? 'ملاحظات إضافية...' : 'Additional notes...' }}">{{ old('notes') }}</textarea>
        </div>
    </div>

    {{-- Summary Sidebar --}}
    <div>
        <div class="form-card" style="position:sticky;top:88px;">
            <div class="section-heading"><div class="accent-line"></div> {{ $isAr ? 'ملخص الفاتورة' : 'Invoice Summary' }}</div>

            <div style="margin-bottom:16px;">
                <label class="form-label">{{ $isAr ? 'رقم الفاتورة' : 'Invoice Number' }}</label>
                <input class="form-input" value="{{ $number }}" readonly style="color:#3b82f6;font-weight:700;letter-spacing:.05em;">
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-label">{{ $isAr ? 'نسبة الضريبة %' : 'VAT Rate %' }}</label>
                <input name="tax_rate" type="number" step="0.01" min="0" max="100" class="form-input" value="{{ old('tax_rate',15) }}" id="tax-rate">
            </div>

            <div class="totals-box" style="margin-bottom:20px;">
                <div class="total-row">
                    <span>{{ $isAr ? 'المجموع الفرعي' : 'Subtotal' }}</span>
                    <span id="summary-subtotal" style="color:#e2e8f0;font-weight:600;">0.00</span>
                </div>
                <div class="total-row">
                    <span>{{ $isAr ? 'الضريبة' : 'VAT' }} (<span id="summary-rate">15</span>%)</span>
                    <span id="summary-tax" style="color:#f59e0b;font-weight:600;">0.00</span>
                </div>
                <div class="total-row final">
                    <span>{{ $isAr ? 'الإجمالي' : 'TOTAL' }}</span>
                    <span id="summary-total" style="color:#34d399;">0.00</span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:14px;font-size:15px;">
                <i class="fas fa-save"></i> {{ $isAr ? 'حفظ الفاتورة' : 'Save Invoice' }}
            </button>
            <a href="{{ route('admin.invoices.index') }}" class="btn-ghost" style="width:100%;justify-content:center;margin-top:10px;">
                {{ $isAr ? 'إلغاء' : 'Cancel' }}
            </a>
        </div>
    </div>

</div>
</form>
@endsection

@push('scripts')
<script>
let rowIndex = 1;

function calcRow(row) {
    const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const sub   = qty * price;
    row.querySelector('.subtotal-input').value = sub.toFixed(2);
}

function updateSummary() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(r => {
        subtotal += parseFloat(r.querySelector('.subtotal-input').value) || 0;
    });
    const rate = parseFloat(document.getElementById('tax-rate').value) || 0;
    const tax  = subtotal * rate / 100;
    document.getElementById('summary-subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('summary-tax').textContent      = tax.toFixed(2);
    document.getElementById('summary-total').textContent    = (subtotal + tax).toFixed(2);
    document.getElementById('summary-rate').textContent     = rate;
}

document.getElementById('items-body').addEventListener('input', function(e) {
    const row = e.target.closest('.item-row');
    if (row) { calcRow(row); updateSummary(); }
});

document.getElementById('tax-rate').addEventListener('input', updateSummary);

document.getElementById('add-item').addEventListener('click', function() {
    const tbody = document.getElementById('items-body');
    const i = rowIndex++;
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.innerHTML = `
        <td><input name="items[${i}][description]" class="form-input" required placeholder="{{ $isAr ? 'وصف الخدمة' : 'Service description' }}"></td>
        <td><input name="items[${i}][quantity]" type="number" min="1" value="1" class="form-input qty-input" required></td>
        <td><input name="items[${i}][unit_price]" type="number" step="0.01" min="0" value="0" class="form-input price-input" required></td>
        <td><input class="form-input subtotal-input" readonly style="color:#34d399;font-weight:700;" value="0.00"></td>
        <td><button type="button" onclick="this.closest('.item-row').remove();updateSummary();" style="background:none;border:none;color:#f87171;cursor:pointer;font-size:16px;"><i class="fas fa-times"></i></button></td>
    `;
    tbody.appendChild(tr);
});
</script>
@endpush
