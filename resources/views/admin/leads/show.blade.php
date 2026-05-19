@extends('layouts.admin')

@section('title', 'Lead #'.$lead->id)
@section('page-title', 'Lead <span>Details</span>')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:22px;align-items:start;">

    {{-- Main info --}}
    <div style="display:flex;flex-direction:column;gap:18px;">

        {{-- Client card --}}
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Client Information</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Full Name</div>
                    <div style="font-weight:700;color:#fff;font-size:16px;">{{ $lead->name }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Email</div>
                    <a href="mailto:{{ $lead->email }}" style="color:#60a5fa;font-size:14px;">{{ $lead->email }}</a>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Phone</div>
                    <div style="color:#e2e8f0;">{{ $lead->phone ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Service Requested</div>
                    <span style="background:rgba(37,99,235,0.15);color:#60a5fa;padding:4px 12px;border-radius:8px;font-size:12.5px;font-weight:600;">
                        {{ $lead->service_type_label }}
                    </span>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Budget</div>
                    <div style="color:#34d399;font-weight:700;font-size:18px;">{{ $lead->budget ? '$'.number_format($lead->budget) : 'Not specified' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Submitted</div>
                    <div style="color:#e2e8f0;">{{ $lead->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($lead->description)
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Project Description</div>
            <p style="color:#94a3b8;font-size:14px;line-height:1.8;">{{ $lead->description }}</p>
        </div>
        @endif

        {{-- Notes --}}
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Internal Notes</div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $lead->status }}">
                <textarea name="notes" rows="5"
                    placeholder="Add internal notes about this lead..."
                    style="width:100%;background:rgba(37,99,235,0.05);border:1px solid var(--border);
                           border-radius:10px;padding:14px;color:#e2e8f0;font-size:13.5px;
                           resize:vertical;outline:none;font-family:'Inter',sans-serif;">{{ $lead->notes }}</textarea>
                <button type="submit" class="btn-primary" style="margin-top:12px;">
                    <i class="fas fa-save"></i> Save Notes
                </button>
            </form>
        </div>
    </div>

    {{-- Sidebar actions --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Status update --}}
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Update Status</div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="notes" value="{{ $lead->notes }}">
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach(['pending'=>['New','badge-new'],'in_progress'=>['Contacted','badge-active'],'completed'=>['Approved','badge-done'],'cancelled'=>['Rejected','badge-rejected']] as $val=>[$label,$cls])
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;
                                  padding:11px 14px;border-radius:10px;border:1px solid var(--border);
                                  background:{{ $lead->status===$val ? 'rgba(37,99,235,0.1)' : 'transparent' }};
                                  transition:all .2s;">
                        <input type="radio" name="status" value="{{ $val }}" {{ $lead->status===$val ? 'checked' : '' }}
                               style="accent-color:var(--blue);">
                        <span class="badge {{ $cls }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <button type="submit" class="btn-primary" style="width:100%;margin-top:14px;justify-content:center;">
                    <i class="fas fa-check"></i> Update Status
                </button>
            </form>
        </div>

        {{-- Convert to Project --}}
        <div class="admin-card" style="border-color:rgba(16,185,129,0.25);">
            <div style="font-size:13px;font-weight:700;color:#34d399;margin-bottom:10px;">
                <i class="fas fa-rocket"></i> Convert to Project
            </div>
            <p style="font-size:12px;color:var(--text-muted);margin-bottom:14px;line-height:1.6;">
                Convert this lead into an active project in your projects board.
            </p>
            <a href="{{ route('admin.projects.create', ['lead_id' => $lead->id]) }}" class="btn-primary" style="width:100%;justify-content:center;background:linear-gradient(135deg,#059669,#10b981);">
                <i class="fas fa-plus"></i> Create Project
            </a>
        </div>

        {{-- Quick contact --}}
        <div class="admin-card">
            <div class="section-heading"><div class="accent-line"></div> Quick Actions</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="mailto:{{ $lead->email }}" class="btn-ghost" style="justify-content:center;">
                    <i class="fas fa-envelope"></i> Send Email
                </a>
                @if($lead->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/','',$lead->phone) }}" target="_blank" class="btn-ghost" style="justify-content:center;color:#25d366;border-color:rgba(37,211,102,0.3);">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                @endif
                <a href="{{ route('admin.leads.index') }}" class="btn-ghost" style="justify-content:center;">
                    <i class="fas fa-arrow-left"></i> Back to Leads
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
