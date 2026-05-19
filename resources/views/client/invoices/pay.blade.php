@extends('layouts.client')

@section('title', 'Pay Invoice')
@section('page_title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="client-card mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white mb-2">Payment Required</h2>
            <p class="text-slate-400">Please complete payment for Invoice {{ $invoice->invoice_number }} to proceed.</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-slate-400 mb-1">Amount Due</div>
            <div class="text-3xl font-bold text-blue-400">{{ $invoice->currency_symbol }}{{ number_format($invoice->total, 2) }}</div>
        </div>
    </div>

    <div class="client-card text-center py-12">
        <div class="w-20 h-20 bg-blue-900/20 border border-blue-500/30 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
            <i class="fab fa-stripe"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-4">Secure Credit Card Payment</h3>
        <p class="text-slate-400 max-w-md mx-auto mb-8">You will be redirected to Stripe's secure checkout to complete your transaction. ELEVA TECH does not store your card details.</p>
        
        <form action="{{ route('payment.checkout', $invoice) }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $invoice->pay_token }}">
            <button type="submit" class="btn-primary px-8 py-3 text-lg">
                <i class="fas fa-lock"></i> Pay {{ $invoice->currency_symbol }}{{ number_format($invoice->total, 2) }} via Stripe
            </button>
        </form>
    </div>
</div>
@endsection
