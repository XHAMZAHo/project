@extends('layouts.client')

@section('title', 'Invoices')
@section('page_title', 'My Invoices')

@section('content')
<div class="client-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Invoice</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Date</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Due Date</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Amount</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Status</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-900/10">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-[#0f1424] transition">
                        <td class="py-4 px-4">
                            <div class="font-bold text-white">{{ $invoice->invoice_number }}</div>
                            <div class="text-xs text-slate-500">{{ $invoice->items->count() }} items</div>
                        </td>
                        <td class="py-4 px-4 text-sm text-slate-300">{{ $invoice->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-4 text-sm text-slate-300">
                            <span class="{{ $invoice->status === 'overdue' ? 'text-red-400' : '' }}">
                                {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 font-bold text-white">{{ $invoice->currency_symbol }}{{ number_format($invoice->total, 2) }}</td>
                        <td class="py-4 px-4">
                            <span class="status-badge status-{{ $invoice->status }} capitalize">{{ $invoice->status }}</span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('client.invoices.show', $invoice) }}" class="w-8 h-8 rounded-lg bg-blue-900/20 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('client.invoices.download', $invoice) }}" class="w-8 h-8 rounded-lg bg-emerald-900/20 text-emerald-400 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition" title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($invoice->status !== 'paid')
                                    <a href="{{ route('client.invoices.pay', $invoice) }}" class="btn-primary py-1.5 px-3 text-xs">Pay</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
