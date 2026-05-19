@extends('layouts.client')

@section('title', 'Payment Cancelled')
@section('page_title', 'Payment Cancelled')

@section('content')
<div class="max-w-2xl mx-auto client-card text-center py-16 mt-10">
    <div class="w-24 h-24 bg-red-900/20 border-2 border-red-500/50 text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
        <i class="fas fa-times"></i>
    </div>
    <h2 class="text-3xl font-bold text-white mb-4">Payment Cancelled</h2>
    <p class="text-slate-400 text-lg mb-8">The payment process was interrupted or cancelled. No charges were made to your account.</p>
    
    <div class="flex justify-center gap-4">
        <a href="{{ route('client.invoices.index') }}" class="btn-primary">
            Back to Invoices
        </a>
        <a href="{{ route('client.dashboard') }}" class="btn-secondary">
            Dashboard
        </a>
    </div>
</div>
@endsection
