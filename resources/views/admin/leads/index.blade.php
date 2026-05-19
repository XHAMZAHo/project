@extends('layouts.admin')

@section('title', 'Leads')
@section('page-title', 'Leads <span>Management</span>')

@push('styles')
<style>
.filter-bar { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; align-items:center; }
.filter-bar input, .filter-bar select {
    background: var(--bg-card); border:1px solid var(--border);
    border-radius:10px; padding:9px 14px; color:#e2e8f0;
    font-size:13px; outline:none; transition:border-color 0.2s;
}
.filter-bar input:focus, .filter-bar select:focus { border-color:var(--blue); }
.filter-bar select option { background:#0b0f1e; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;">
    <div>
        <h2 style="font-size:22px;font-weight:800;color:#fff;">Client Leads</h2>
        <p style="color:var(--text-muted);font-size:13px;margin-top:3px;">All incoming service requests & inquiries</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="filter-bar">
    <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" style="width:240px;">
    <select name="status">
        <option value="">All Statuses</option>
        <option value="pending"     {{ request('status')=='pending'     ? 'selected':'' }}>New</option>
        <option value="in_progress" {{ request('status')=='in_progress' ? 'selected':'' }}>Contacted</option>
        <option value="completed"   {{ request('status')=='completed'   ? 'selected':'' }}>Approved</option>
        <option value="cancelled"   {{ request('status')=='cancelled'   ? 'selected':'' }}>Rejected</option>
    </select>
    <select name="service">
        <option value="">All Services</option>
        <option value="web_design"      {{ request('service')=='web_design'      ? 'selected':'' }}>Web Design</option>
        <option value="web_development" {{ request('service')=='web_development' ? 'selected':'' }}>Web Development</option>
        <option value="mobile_app"      {{ request('service')=='mobile_app'      ? 'selected':'' }}>Mobile App</option>
        <option value="custom_system"   {{ request('service')=='custom_system'   ? 'selected':'' }}>Custom System</option>
    </select>
    <button type="submit" class="btn-primary" style="padding:9px 16px;">
        <i class="fas fa-search"></i> Filter
    </button>
    @if(request()->anyFilled(['search','status','service']))
        <a href="{{ route('admin.leads.index') }}" class="btn-ghost">Clear</a>
    @endif
</form>

{{-- Table --}}
<div class="admin-card" style="padding:0;overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Service</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Received</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
            <tr>
                <td style="color:var(--text-muted);font-size:12px;">#{{ $lead->id }}</td>
                <td>
                    <div style="font-weight:600;color:#e2e8f0;">{{ $lead->name }}</div>
                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $lead->email }}</div>
                    @if($lead->phone)
                    <div style="font-size:11px;color:var(--text-muted);">{{ $lead->phone }}</div>
                    @endif
                </td>
                <td>
                    <span style="background:rgba(37,99,235,0.1);color:#60a5fa;padding:3px 10px;border-radius:8px;font-size:12px;">
                        {{ $lead->service_type_label }}
                    </span>
                </td>
                <td style="color:#34d399;font-weight:600;">{{ $lead->budget ? '$'.number_format($lead->budget) : '—' }}</td>
                <td>
                    @if($lead->status === 'pending')
                        <span class="badge badge-new">New</span>
                    @elseif($lead->status === 'in_progress')
                        <span class="badge badge-active">Contacted</span>
                    @elseif($lead->status === 'completed')
                        <span class="badge badge-done">Approved</span>
                    @else
                        <span class="badge badge-rejected">Rejected</span>
                    @endif
                </td>
                <td style="color:var(--text-muted);font-size:12px;">{{ $lead->created_at->format('M d, Y') }}</td>
                <td style="text-align:right;">
                    <div style="display:flex;gap:6px;justify-content:flex-end;">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="btn-ghost" style="padding:6px 12px;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Delete this lead?')">
                            @csrf @method('DELETE')
                            <button class="btn-ghost" style="padding:6px 12px;color:#f87171;border-color:rgba(239,68,68,0.3);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:50px;color:var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;opacity:0.3;"></i>
                    No leads found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($leads->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--border);">
        {{ $leads->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
