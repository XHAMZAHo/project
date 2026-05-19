@extends('layouts.admin')

@section('title', 'View Message')
@section('page_title', 'Contact Message Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.contacts.index') }}" class="text-gray-500 hover:text-blue-600 transition flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Messages
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $contact->subject }}</h2>
            <div class="text-sm text-gray-500 mt-1">Received on {{ $contact->created_at->format('l, M d, Y \a\t h:i A') }}</div>
        </div>
        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this message?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded transition" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
    
    <div class="p-6 border-b border-gray-100 bg-gray-50 flex gap-6">
        <div>
            <div class="text-xs text-gray-500 uppercase font-semibold mb-1">From</div>
            <div class="font-medium text-gray-800">{{ $contact->name }}</div>
        </div>
        <div>
            <div class="text-xs text-gray-500 uppercase font-semibold mb-1">Email Address</div>
            <a href="mailto:{{ $contact->email }}" class="font-medium text-blue-600 hover:underline">{{ $contact->email }}</a>
        </div>
        @if($contact->phone)
        <div>
            <div class="text-xs text-gray-500 uppercase font-semibold mb-1">Phone Number</div>
            <a href="tel:{{ $contact->phone }}" class="font-medium text-gray-800 hover:text-blue-600">{{ $contact->phone }}</a>
        </div>
        @endif
    </div>

    <div class="p-6">
        <div class="text-xs text-gray-500 uppercase font-semibold mb-3">Message Content</div>
        <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
    </div>
    
    <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-reply mr-2"></i> Reply via Email
        </a>
    </div>
</div>
@endsection
