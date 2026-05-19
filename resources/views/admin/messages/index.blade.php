@extends('layouts.admin')
@section('title', app()->getLocale() === 'ar' ? 'المراسلات' : 'Messages')
@section('page-title', app()->getLocale() === 'ar' ? 'المراسلات مع العملاء' : 'Client Messages')

@push('styles')
<style>
.msg-layout {
    display: flex;
    gap: 20px;
    height: calc(100vh - 140px);
}
.clients-list {
    width: 320px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.client-item {
    padding: 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--dim);
    transition: all 0.2s;
}
.client-item:hover, .client-item.active {
    background: rgba(26,86,240,0.06);
}
.client-item.active {
    border-right: 3px solid var(--et-blue);
}
[dir="ltr"] .client-item.active {
    border-right: none;
    border-left: 3px solid var(--et-blue);
}
.c-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, #1241c0, #1a56f0);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 14px;
    flex-shrink: 0;
}
.c-info { flex: 1; overflow: hidden; }
.c-name { font-size: 14px; font-weight: 700; color: #e2e8f0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.c-unread {
    background: #ef4444; color: #fff; font-size: 10px; font-weight: 800;
    padding: 2px 6px; border-radius: 100px;
}

.chat-box {
    flex: 1;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.chat-head {
    padding: 16px 24px;
    border-bottom: 1px solid var(--border);
    background: rgba(26,86,240,0.03);
    display: flex; align-items: center; gap: 12px;
}
.chat-head-name { font-size: 16px; font-weight: 800; color: #fff; }
.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.msg {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 16px;
    font-size: 13.5px;
    line-height: 1.6;
    position: relative;
}
.msg.received {
    align-self: flex-start;
    background: rgba(26,86,240,0.1);
    border: 1px solid var(--border);
    border-bottom-right-radius: 4px;
    color: #e2e8f0;
}
[dir="ltr"] .msg.received {
    border-bottom-right-radius: 16px;
    border-bottom-left-radius: 4px;
}
.msg.sent {
    align-self: flex-end;
    background: linear-gradient(135deg, #1241c0, #1a56f0);
    color: #fff;
    border-bottom-left-radius: 4px;
}
[dir="ltr"] .msg.sent {
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 4px;
}
.msg-time {
    font-size: 10px; opacity: 0.7; margin-top: 6px; display: block;
    text-align: end;
}

.chat-foot {
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    background: rgba(26,86,240,0.02);
}
.chat-input-wrapper {
    display: flex; gap: 12px;
}
.chat-input {
    flex: 1;
    background: var(--bg-base);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px 16px;
    color: #fff;
    font-size: 14px;
    font-family: inherit;
    resize: none;
    outline: none;
}
.chat-input:focus { border-color: var(--et-blue); }
.chat-send-btn {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1241c0, #1a56f0);
    color: #fff;
    border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 16px;
    flex-shrink: 0;
}
.chat-send-btn:hover { transform: scale(1.05); box-shadow: 0 0 20px rgba(26,86,240,0.5); }

/* Light mode overrides */
html.light-adm .c-name { color: #0f172a; }
html.light-adm .msg.received { color: #334155; }
html.light-adm .chat-head-name { color: #0f172a; }
html.light-adm .chat-input { color: #0f172a; }
</style>
@endpush

@section('content')
<div class="msg-layout">
    <div class="clients-list">
        @forelse($clients as $c)
            <a href="{{ route('admin.messages.index', ['client_id' => $c->id]) }}" class="client-item {{ $selectedClient && $selectedClient->id === $c->id ? 'active' : '' }}">
                <div class="c-avatar">{{ mb_substr($c->name, 0, 1) }}</div>
                <div class="c-info">
                    <div class="c-name">{{ $c->name }}</div>
                </div>
                @if($c->unread_count > 0)
                    <div class="c-unread">{{ $c->unread_count }}</div>
                @endif
            </a>
        @empty
            <div style="padding: 24px; text-align: center; color: var(--muted); font-size: 13px;">
                {{ app()->getLocale() === 'ar' ? 'لا يوجد محادثات بعد.' : 'No conversations yet.' }}
            </div>
        @endforelse
    </div>

    <div class="chat-box">
        @if($selectedClient)
            <div class="chat-head">
                <div class="c-avatar">{{ mb_substr($selectedClient->name, 0, 1) }}</div>
                <div class="chat-head-name">{{ $selectedClient->name }}</div>
            </div>
            
            <div class="chat-body" id="chatBody">
                @forelse($messages as $msg)
                    <div class="msg {{ $msg->sender_id === auth()->id() ? 'sent' : 'received' }}">
                        {{ $msg->body }}
                        <span class="msg-time">{{ $msg->created_at->format('h:i A') }}</span>
                    </div>
                @empty
                    <div style="text-align:center; color: var(--muted); margin-top: auto; margin-bottom: auto;">
                        {{ app()->getLocale() === 'ar' ? 'ابدأ المحادثة الآن.' : 'Start the conversation.' }}
                    </div>
                @endforelse
            </div>

            <div class="chat-foot">
                <form action="{{ route('admin.messages.store') }}" method="POST" class="chat-input-wrapper">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $selectedClient->id }}">
                    <input type="text" name="body" class="chat-input" placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب رسالتك هنا...' : 'Type your message...' }}" required autocomplete="off">
                    <button type="submit" class="chat-send-btn"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        @else
            <div style="flex: 1; display: flex; align-items: center; justify-content: center; color: var(--muted); flex-direction: column; gap: 12px;">
                <i class="fas fa-comments" style="font-size: 48px; opacity: 0.2;"></i>
                <div>{{ app()->getLocale() === 'ar' ? 'اختر عميلاً لعرض المحادثة' : 'Select a client to view conversation' }}</div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const cb = document.getElementById('chatBody');
    if(cb) cb.scrollTop = cb.scrollHeight;
</script>
@endpush
