@extends('layouts.client')

@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page_title', 'Invoice Details')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('client.invoices.index') }}" class="w-10 h-10 rounded-xl bg-blue-900/20 border border-blue-500/30 text-blue-400 flex items-center justify-center hover:bg-blue-800/40 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white">{{ $invoice->invoice_number }}</h1>
        <span class="status-badge status-{{ $invoice->status }} capitalize">
            {{ $invoice->status }}
        </span>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('client.invoices.download', $invoice) }}" class="btn-secondary">
            <i class="fas fa-download"></i> Download PDF
        </a>
        @if($invoice->status !== 'paid')
            <a href="{{ route('client.invoices.pay', $invoice) }}" class="btn-primary">
                <i class="fas fa-credit-card"></i> Pay Now
            </a>
        @endif
    </div>
</div>

<div class="client-card p-0 overflow-hidden">
    <!-- Invoice Header -->
    <div class="p-8 border-b border-blue-900/30 bg-gradient-to-br from-[#0f1424] to-[#0b0f1e]">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-2xl font-bold text-white tracking-wider mb-1">ELEVA TECH</div>
                <div class="text-slate-400 text-sm">Professional Web Services</div>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-400">Amount Due</div>
                <div class="text-4xl font-black text-blue-400">{{ $invoice->currency_symbol }}{{ number_format($invoice->total, 2) }}</div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-8 mt-12">
            <div>
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Billed To:</div>
                <div class="text-white font-medium">{{ $invoice->client_name }}</div>
                <div class="text-slate-400 text-sm">{{ $invoice->client_email }}</div>
                @if($invoice->client_phone)
                    <div class="text-slate-400 text-sm">{{ $invoice->client_phone }}</div>
                @endif
            </div>
            <div class="text-right">
                <div class="mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-2">Issue Date:</span>
                    <span class="text-white font-medium">{{ $invoice->created_at->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-2">Due Date:</span>
                    <span class="text-white font-medium">{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'Upon Receipt' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="p-8">
        <table class="w-full text-left mb-8">
            <thead>
                <tr class="border-b border-blue-900/30">
                    <th class="pb-3 font-semibold text-slate-400 uppercase text-xs tracking-wider">Description</th>
                    <th class="pb-3 font-semibold text-slate-400 uppercase text-xs tracking-wider text-center">Qty</th>
                    <th class="pb-3 font-semibold text-slate-400 uppercase text-xs tracking-wider text-right">Price</th>
                    <th class="pb-3 font-semibold text-slate-400 uppercase text-xs tracking-wider text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-900/10">
                @foreach($invoice->items as $item)
                <tr>
                    <td class="py-4">
                        <div class="font-medium text-white">{{ $item->description }}</div>
                    </td>
                    <td class="py-4 text-center text-slate-300">{{ $item->quantity }}</td>
                    <td class="py-4 text-right text-slate-300">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-4 text-right font-bold text-white">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-end">
            <div class="w-64 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Subtotal</span>
                    <span class="text-white">{{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                @if($invoice->tax_rate > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Tax ({{ $invoice->tax_rate }}%)</span>
                    <span class="text-white">{{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-blue-900/30">
                    <span class="text-white">Total</span>
                    <span class="text-blue-400">{{ $invoice->currency_symbol }}{{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        @if($invoice->notes)
        <div class="mt-8 pt-8 border-t border-blue-900/30">
            <h4 class="text-sm font-bold text-white mb-2">Notes</h4>
            <p class="text-sm text-slate-400">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
