<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $invoice->invoice_number }}</title>
<style>
    body { font-family: 'xbriyaz', sans-serif; background: #ffffff; color: #334155; font-size: 11px; line-height: 1.5; margin: 0; padding: 0; }
    .container { width: 100%; max-width: 100%; padding: 40px 45px; }
    table { width: 100%; border-collapse: collapse; }
    td { vertical-align: top; }

    /* Header */
    .header-table { margin-top: 10px; margin-bottom: 40px; }
    .brand-title { font-size: 26px; font-weight: bold; color: #0f172a; letter-spacing: 1px; }
    .brand-sub { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }
    
    .invoice-title-wrapper { text-align: right; position: relative; }
    .invoice-title-en { font-size: 42px; color: #e2e8f0; font-weight: normal; letter-spacing: 2px; line-height: 1; }
    .invoice-title-ar-box { position: absolute; top: 22px; right: 0; text-align: right; }
    .invoice-title-ar { font-size: 18px; font-weight: bold; color: #3b82f6; }
    .invoice-title-ar-sub { font-size: 12px; color: #94a3b8; }

    /* Info Grid */
    .info-table { margin-bottom: 40px; }
    .info-label-en { font-size: 8px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
    .info-label-ar { font-size: 10px; color: #94a3b8; }
    .info-val { font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 3px; }
    .info-sub { font-size: 11px; color: #3b82f6; margin-top: 2px; }
    .info-sub2 { font-size: 11px; color: #64748b; margin-top: 2px; }

    .status-badge { display: inline-block; border: 1.5px solid #f59e0b; color: #f59e0b; padding: 4px 12px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; margin-top: 5px; }
    .status-badge.paid { border-color: #10b981; color: #10b981; }

    /* Items Table */
    .items-wrapper { margin-bottom: 30px; }
    .items-table { border-collapse: separate; border-spacing: 0 4px; }
    .items-table th { padding: 8px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
    
    .th-col-1 { border-top: 2px solid #3b82f6; }
    .th-col-2 { border-top: 1px solid #e2e8f0; text-align: center !important; }
    .th-col-3 { border-top: 1px solid #e2e8f0; text-align: right !important; }
    .th-col-4 { border-top: 1px solid #e2e8f0; text-align: right !important; }
    
    .items-table td { padding: 12px 10px; border-top: 2px solid #ffffff; border-bottom: 2px solid #ffffff; }
    .items-table tbody tr.item-row td { background: #ffffff; }
    .items-table tbody tr.spacer-row td { background: #f8fafc; }
    
    .th-en { font-size: 8px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
    .th-ar { font-size: 10px; color: #94a3b8; }

    .td-val { font-size: 12px; color: #334155; }
    .td-val-bold { font-size: 13px; font-weight: bold; color: #0f172a; }

    /* Totals */
    .totals-table { width: 340px; margin-bottom: 40px; }
    .totals-table td { padding: 6px 15px; font-size: 12px; }
    .totals-table td.lbl { color: #64748b; text-align: left; }
    .totals-table td.val { font-weight: bold; color: #0f172a; text-align: right; font-size: 13px; }
    .totals-table td.lbl-ar { font-size: 10px; color: #94a3b8; display: block; }

    .total-due-box { background: #0f172a; color: #ffffff; border-radius: 4px; }
    .total-due-box td { padding: 14px 15px; border-bottom: none; }
    .total-due-box td.lbl { color: #cbd5e1; font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .total-due-box td.lbl-ar { color: #94a3b8; font-size: 10px; display: block; }
    .total-due-box td.val { font-size: 20px; color: #ffffff; font-weight: bold; }

    .clear { clear: both; }

    /* Notes */
    .notes-box { width: 55%; background: #ffffff; border-left: 3px solid #3b82f6; padding: 12px 15px; margin-bottom: 40px; }
    .notes-title-en { font-size: 8px; font-weight: bold; color: #2563eb; text-transform: uppercase; }
    .notes-title-ar { font-size: 10px; color: #2563eb; font-weight: bold; }
    .notes-text { font-size: 10px; color: #64748b; margin-top: 4px; }

    /* Signatures & QR */
    .sig-table { width: 100%; margin-bottom: 30px; }
    .sig-box { width: 30%; }
    .sig-title-en { font-size: 8px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
    .sig-title-ar { font-size: 10px; color: #94a3b8; }
    .sig-line { border-bottom: 1px solid #e2e8f0; height: 35px; margin-bottom: 5px; }
    .sig-sub { font-size: 9px; color: #cbd5e1; text-transform: uppercase; }

    .qr-box { width: 20%; text-align: center; }
    .qr-container { width: 80px; height: 80px; border: 1.5px dashed #cbd5e1; display: inline-block; padding: 5px; text-align: center; }
    
    /* Footer */
    .footer { position: absolute; bottom: 30px; left: 45px; right: 45px; border-top: 1px solid #f1f5f9; padding-top: 15px; }
    .footer-table { width: 100%; }
    .footer-table td { font-size: 9px; color: #94a3b8; }
    .footer-brand { font-weight: bold; color: #2563eb; }
    .footer-center { text-align: center; }
    .footer-center-ar { font-size: 10px; display: block; }
    .footer-right { text-align: right; }
    
    /* Helpers */
    .en-text { direction: ltr; display: inline-block; }
    .ar-text { direction: rtl; display: inline-block; }
</style>
</head>
<body dir="ltr">

<!-- Top Bar using absolute table instead of divs with float to prevent mPDF timeout -->
<table style="width: 100%; height: 6px; position: absolute; top: 0; left: 0; padding: 0; margin: 0; border: none; border-collapse: collapse;">
    <tr>
        <td style="width: 25%; background: #0f172a; height: 6px; padding: 0; border: none;"></td>
        <td style="width: 50%; background: #2563eb; height: 6px; padding: 0; border: none;"></td>
        <td style="width: 25%; background: #60a5fa; height: 6px; padding: 0; border: none;"></td>
    </tr>
</table>

<div class="container">

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 50%; text-align: left;">
                <div class="brand-title">ELEVA TECH</div>
                <div class="brand-sub">WEB & SYSTEM SOLUTIONS</div>
            </td>
            <td style="width: 50%; text-align: right;">
                <div class="invoice-title-wrapper">
                    <div class="invoice-title-en">INVOICE</div>
                    <div class="invoice-title-ar-box">
                        <div class="invoice-title-ar" lang="ar" dir="rtl">فاتورة</div>
                        <div class="invoice-title-ar-sub" lang="ar" dir="rtl">فاتورة ضريبية</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Info Grid -->
    <table class="info-table" dir="ltr">
        <tr>
            <!-- Billed To -->
            <td style="width: 25%; text-align: left;">
                <div class="info-label-en">BILLED TO</div>
                <div class="info-label-ar" lang="ar" dir="rtl">فاتورة إلى</div>
                <div class="info-val">{{ $invoice->client_name }}</div>
                @if($invoice->client_email)<div class="info-sub">{{ $invoice->client_email }}</div>@endif
                @if($invoice->client_phone)<div class="info-sub2">{{ $invoice->client_phone }}</div>@endif
            </td>
            <!-- Invoice Number -->
            <td style="width: 25%; text-align: left;">
                <div class="info-label-en">INVOICE NUMBER</div>
                <div class="info-label-ar" lang="ar" dir="rtl">رقم الفاتورة</div>
                <div class="info-val" style="color: #3b82f6;">{{ $invoice->invoice_number }}</div>
            </td>
            <!-- Dates -->
            <td style="width: 25%; text-align: left;">
                <div class="info-label-en">DATE OF ISSUE</div>
                <div class="info-label-ar" lang="ar" dir="rtl">تاريخ الإصدار</div>
                <div class="info-val">{{ $invoice->created_at->format('d M Y') }}</div>
                <div style="height: 10px;"></div>
                <div class="info-label-en">DUE DATE</div>
                <div class="info-label-ar" lang="ar" dir="rtl">تاريخ الاستحقاق</div>
                <div class="info-val">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'N/A' }}</div>
            </td>
            <!-- Status -->
            <td style="width: 25%; text-align: left;">
                <div class="info-label-en">STATUS</div>
                <div class="info-label-ar" lang="ar" dir="rtl">الحالة</div>
                <div class="status-badge {{ $invoice->status === 'paid' ? 'paid' : '' }}">
                    <span class="en-text">{{ strtoupper($invoice->status) }}</span>
                    <span class="ar-text" lang="ar" dir="rtl" style="margin-left: 5px;">{{ $invoice->status === 'paid' ? 'مدفوعة' : 'قيد الانتظار' }}</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <div class="items-wrapper" dir="ltr">
        <table class="items-table">
            <thead>
                <tr>
                    <th class="th-col-1" style="width: 45%;">
                        <div class="th-en">SERVICE DESCRIPTION</div>
                        <div class="th-ar" lang="ar" dir="rtl">وصف الخدمة</div>
                    </th>
                    <th class="th-col-2" style="width: 15%;">
                        <div class="th-en">QTY</div>
                        <div class="th-ar" lang="ar" dir="rtl">الكمية</div>
                    </th>
                    <th class="th-col-3" style="width: 20%;">
                        <div class="th-en">UNIT PRICE</div>
                        <div class="th-ar" lang="ar" dir="rtl">سعر الوحدة</div>
                    </th>
                    <th class="th-col-4" style="width: 20%;">
                        <div class="th-en">AMOUNT</div>
                        <div class="th-ar" lang="ar" dir="rtl">المبلغ</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr class="item-row">
                    <td class="td-val-bold" style="text-align: left;">
                        {{ $item->description }}<br>
                        <span style="font-weight: normal; color: #94a3b8; font-size: 10px;" lang="ar" dir="rtl">تصميم وتطوير موقع</span>
                    </td>
                    <td class="center td-val" style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="right td-val" style="text-align: right;">{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                    <td class="right td-val-bold" style="text-align: right;">{{ $invoice->currency }} {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
                
                @for($i = count($invoice->items); $i < 4; $i++)
                <tr class="spacer-row">
                    <td style="color: transparent;">-</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Totals Area wrapped in a table to align right natively -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <table class="totals-table" dir="ltr" align="right">
                    <tr>
                        <td class="lbl">
                            <span class="en-text">Subtotal</span><br>
                            <span class="lbl-ar" lang="ar" dir="rtl">المجموع الفرعي</span>
                        </td>
                        <td class="val">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">
                            <span class="en-text">VAT ({{ $invoice->tax_rate }}%)</span><br>
                            <span class="lbl-ar" lang="ar" dir="rtl">ضريبة القيمة المضافة</span>
                        </td>
                        <td class="val" style="color: #dc2626;">{{ $invoice->currency }} {{ number_format($invoice->tax_amount, 2) }}</td>
                    </tr>
                    <tr class="total-due-box">
                        <td class="lbl">
                            <span class="en-text">TOTAL DUE</span><br>
                            <span class="lbl-ar" lang="ar" dir="rtl">الإجمالي المستحق</span>
                        </td>
                        <td class="val">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="clear"></div>

    <!-- Notes -->
    <div class="notes-box" dir="ltr">
        <div class="notes-title-en">NOTES & PAYMENT TERMS &nbsp;&nbsp;<span class="notes-title-ar" lang="ar" dir="rtl">ملاحظات وشروط الدفع</span></div>
        <div class="notes-text" lang="ar" dir="rtl">{{ $invoice->notes ?: 'Payment due within 14 days. Ref: ' . $invoice->invoice_number }}</div>
    </div>

    <!-- Signatures & QR -->
    <table class="sig-table" dir="ltr">
        <tr>
            <!-- Signature 1 -->
            <td class="sig-box" style="text-align: left;">
                <div class="sig-title-en">AUTHORIZED SIGNATURE</div>
                <div class="sig-title-ar" lang="ar" dir="rtl">توقيع معتمد</div>
                <div class="sig-line"></div>
                <div class="sig-sub">ELEVA TECH</div>
            </td>
            <td style="width: 5%;"></td>
            <!-- Signature 2 -->
            <td class="sig-box" style="text-align: left;">
                <div class="sig-title-en">CLIENT SIGNATURE</div>
                <div class="sig-title-ar" lang="ar" dir="rtl">توقيع العميل</div>
                <div class="sig-line"></div>
                <div class="sig-sub">{{ $invoice->client_name }}</div>
            </td>
            <td style="width: 20%;"></td>
            <!-- QR Code -->
            <td class="qr-box">
                <div class="sig-title-en">BARCODE / QR</div>
                <div class="sig-title-ar" lang="ar" dir="rtl">رمز الاستجابة السريعة</div>
                <div style="height: 5px;"></div>
                <div class="qr-container">
                    <barcode code="{{ route('admin.invoices.pdf', $invoice) }}" type="QR" size="0.8" error="M" disableborder="1" />
                </div>
            </td>
        </tr>
    </table>

</div>

<!-- Footer -->
<div class="footer" dir="ltr">
    <table class="footer-table">
        <tr>
            <td style="width: 33%; text-align: left;"><span class="footer-brand">ELEVA TECH</span></td>
            <td style="width: 33%;" class="footer-center">
                Thank you for your business!<br>
                <span class="footer-center-ar" lang="ar" dir="rtl">شكراً لثقتكم بنا</span>
            </td>
            <td style="width: 33%;" class="footer-right">
                elevatech.com | contact@elevatech.com
            </td>
        </tr>
    </table>
</div>

</body>
</html>
