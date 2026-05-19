@extends('layouts.admin')

@section('title', 'Create Project')
@section('page-title', 'Create <span>Project</span>')

@section('content')
<div style="max-width:680px;">
    <div class="admin-card">
        <div class="section-heading"><div class="accent-line"></div> New Project</div>
        <form method="POST" action="{{ route('admin.projects.store') }}" style="display:flex;flex-direction:column;gap:18px;">
            @csrf

            @if($lead)
            <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.25);border-radius:10px;padding:12px 16px;font-size:13px;color:#34d399;">
                <i class="fas fa-link"></i> Converting lead from <strong>{{ $lead->name }}</strong> ({{ $lead->service_type_label }})
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px;">Project Title *</label>
                    <input type="text" name="title" value="{{ old('title', $lead?->name.' Project') }}" required
                        style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:#e2e8f0;font-size:13.5px;outline:none;">
                    @error('title')<span style="color:#f87171;font-size:11px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px;">Client Name *</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $lead?->name) }}" required
                        style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:#e2e8f0;font-size:13.5px;outline:none;">
                </div>
            </div>

            <div>
                <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px;">Description</label>
                <textarea name="description" rows="4"
                    style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:#e2e8f0;font-size:13.5px;outline:none;resize:vertical;font-family:'Inter',sans-serif;">{{ old('description', $lead?->description) }}</textarea>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px;">Status</label>
                    <select name="status" style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:#e2e8f0;font-size:13.5px;outline:none;">
                        <option value="pending">New</option>
                        <option value="active" selected>In Progress</option>
                        <option value="review">Review</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:6px;">Project URL</label>
                    <input type="url" name="url" value="{{ old('url') }}" placeholder="https://"
                        style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:#e2e8f0;font-size:13.5px;outline:none;">
                </div>
            </div>

            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px;color:var(--text-dim);">
                <input type="checkbox" name="is_featured" value="1" style="accent-color:var(--blue);width:16px;height:16px;">
                Mark as featured (show on homepage portfolio)
            </label>

            <div style="display:flex;gap:10px;padding-top:6px;">
                <button type="submit" class="btn-primary"><i class="fas fa-rocket"></i> Create Project</button>
                <a href="{{ route('admin.projects.index') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
