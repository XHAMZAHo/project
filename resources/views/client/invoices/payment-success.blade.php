@extends('layouts.client')

@section('title', 'Payment Success')
@section('page_title', 'Payment Successful')

@section('content')
<div class="max-w-2xl mx-auto client-card text-center py-16 mt-10">
    <div class="w-24 h-24 bg-emerald-900/20 border-2 border-emerald-500/50 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
        <i class="fas fa-check"></i>
    </div>
    <h2 class="text-3xl font-bold text-white mb-4">Payment Received!</h2>
    <p class="text-slate-400 text-lg mb-8">Thank you for your payment. Your invoice has been marked as paid and a receipt has been emailed to you.</p>
    
    <a href="{{ route('client.dashboard') }}" class="btn-primary">
        Return to Dashboard
    </a>
</div>
@endsection
