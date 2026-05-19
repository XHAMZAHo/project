@extends('layouts.admin')

@section('title', $client->name)
@section('page-title', 'Client <span>Profile</span>')

@section('content')

<div style="display:grid;grid-template-columns:320px 1fr;gap:22px;align-items:start;">

    {{-- Profile Card --}}
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="admin-card" style="text-align:center;">
            <div style="width:80px;height:80px;border-radius:50%;
                        background:linear-gradient(135deg,#1d4ed8,#3b82f6);
                        display:flex;align-items:center;justify-content:center;
                        font-weight:900;font-size:32px;color:#fff;
                        margin:0 auto 16px;
                        box-shadow:0 0 30px rgba(37,99,235,0.4);">
                {{ strtoupper(substr($client->name,0,1)) }}
            </div>
            <h2 style="font-size:20px;font-weight:800;color:#fff;margin-bottom:4px;">{{ $client->name }}</h2>
            <p style="font-size:13px;color:var(--text-muted);">{{ $client->email }}</p>
            @if($client->phone)
            <p style="font-size:13px;color:var(--text-muted);margin-top:4px;">{{ $client->phone }}</p>
            @endif
            <div style="margin-top:18px;padding-top:18px;border-top:1px solid var(--border);">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div style="background:rgba(37,99,235,0.07);border-radius:10px;padding:12px;">
                        <div style="font-size:22px;font-weight:800;color:#3b82f6;">{{ $projects->count() }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">Projects</div>
                    </div>
                    <div style="background:rgba(16,185,129,0.07);border-radius:10px;padding:12px;">
                        <div style="font-size:22px;font-weight:800;color:#34d399;">{{ $projects->where('status','completed')->count() }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Account Info</div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Member Since</div>
                    <div style="font-size:13.5px;color:#e2e8f0;font-weight:500;">{{ $client->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Role</div>
                    <span class="badge {{ $client->is_admin ? 'badge-done' : 'badge-new' }}">
                        {{ $client->is_admin ? 'Admin' : 'Client' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Quick Actions</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="mailto:{{ $client->email }}" class="btn-ghost" style="justify-content:center;">
                    <i class="fas fa-envelope"></i> Send Email
                </a>
                <a href="{{ route('admin.invoices.create', ['client_name' => $client->name, 'client_email' => $client->email]) }}" class="btn-ghost" style="justify-content:center;">
                    <i class="fas fa-file-invoice"></i> Create Invoice
                </a>
                <a href="{{ route('admin.clients.index') }}" class="btn-ghost" style="justify-content:center;">
                    <i class="fas fa-arrow-left"></i> Back to Clients
                </a>
            </div>
        </div>
    </div>

    {{-- Projects History --}}
    <div class="admin-card">
        <div class="section-heading">
            <div class="accent-line"></div> Project History
            <span style="margin-left:auto;font-size:12px;color:var(--text-muted);">{{ $projects->count() }} total</span>
        </div>

        @forelse($projects as $project)
        <div style="background:var(--bg-card2);border:1px solid var(--border);border-radius:12px;padding:16px;margin-bottom:12px;transition:all .25s;"
             onmouseover="this.style.borderColor='rgba(37,99,235,0.35)'"
             onmouseout="this.style.borderColor='var(--border)'">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                <div>
                    <div style="font-size:15px;font-weight:700;color:#fff;">{{ $project->title }}</div>
                    @if($project->description)
                    <div style="font-size:12.5px;color:var(--text-muted);margin-top:3px;">{{ Str::limit($project->description, 80) }}</div>
                    @endif
                </div>
                <div style="display:flex;gap:8px;align-items:center;flex-shrink:0;margin-left:16px;">
                    @if($project->is_featured)
                    <span style="background:rgba(234,179,8,0.12);color:#fbbf24;font-size:10px;padding:2px 8px;border-radius:6px;">
                        <i class="fas fa-star"></i> Featured
                    </span>
                    @endif
                    @if($project->status === 'active')
                        <span class="badge badge-active">In Progress</span>
                    @elseif($project->status === 'completed')
                        <span class="badge badge-done">Completed</span>
                    @elseif($project->status === 'pending')
                        <span class="badge badge-pending">New</span>
                    @else
                        <span class="badge badge-new">{{ ucfirst($project->status) }}</span>
                    @endif
                </div>
            </div>
            <div style="display:flex;gap:16px;font-size:12px;color:var(--text-muted);">
                <span><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $project->created_at->format('M Y') }}</span>
                @if($project->url)
                <a href="{{ $project->url }}" target="_blank" style="color:#60a5fa;text-decoration:none;">
                    <i class="fas fa-link"></i> {{ $project->url }}
                </a>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:50px;color:var(--text-muted);">
            <i class="fas fa-folder-open" style="font-size:32px;display:block;margin-bottom:10px;opacity:0.3;"></i>
            No projects found for this client.
        </div>
        @endforelse
    </div>

</div>

@endsection
