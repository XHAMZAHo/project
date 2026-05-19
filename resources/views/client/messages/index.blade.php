@extends('layouts.client')

@section('title', 'Messages')
@section('page_title', 'Support Chat')

@section('content')
<div class="flex flex-col h-[calc(100vh-12rem)] max-h-[800px] client-card p-0 overflow-hidden">
    <!-- Chat Header -->
    <div class="p-4 border-b border-blue-900/30 bg-[#0f1424] flex items-center gap-4 shrink-0">
        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
            {{ $admin ? strtoupper(substr($admin->name, 0, 1)) : 'A' }}
        </div>
        <div>
            <div class="font-bold text-white">{{ $admin->name ?? 'Admin Support' }}</div>
            <div class="text-xs text-emerald-400 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Online
            </div>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6 flex flex-col" id="chat-container">
        <div class="text-center">
            <span class="text-xs bg-blue-900/20 text-blue-300 px-3 py-1 rounded-full border border-blue-500/20">Chat started</span>
        </div>
        
        @forelse($messages as $message)
            @if($message->sender_id === auth()->id())
                <!-- My Message -->
                <div class="flex justify-end">
                    <div class="max-w-[75%] bg-blue-600 text-white p-3 rounded-2xl rounded-tr-sm shadow-md">
                        <div class="text-sm">{{ $message->body }}</div>
                        <div class="text-[10px] text-blue-200 text-right mt-1">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @else
                <!-- Admin Message -->
                <div class="flex justify-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-900/50 flex items-center justify-center text-blue-400 shrink-0 text-sm border border-blue-500/30">
                        {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                    </div>
                    <div class="max-w-[75%] bg-[#0f1424] border border-blue-900/30 text-slate-200 p-3 rounded-2xl rounded-tl-sm shadow-md">
                        <div class="text-sm">{{ $message->body }}</div>
                        <div class="text-[10px] text-slate-500 mt-1">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endif
        @empty
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center text-slate-500">
                    <i class="fas fa-comments text-4xl mb-3 text-blue-900/50"></i>
                    <p>Send a message to start the conversation.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Input Area -->
    <div class="p-4 border-t border-blue-900/30 bg-[#0f1424] shrink-0">
        <form action="{{ route('client.messages.store') }}" method="POST" class="flex gap-3">
            @csrf
            <input type="text" name="body" required placeholder="Type your message..." class="flex-1 bg-black/20 border border-blue-900/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" autocomplete="off">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white w-12 h-12 rounded-xl flex items-center justify-center transition shadow-[0_0_15px_rgba(37,99,235,0.4)]">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // Auto-scroll to bottom
    const chat = document.getElementById('chat-container');
    chat.scrollTop = chat.scrollHeight;
</script>
@endsection
