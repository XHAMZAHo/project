@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard <span>Overview</span>')

@push('styles')
<style>
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:24px;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;}
.g3{display:grid;grid-template-columns:2fr 1fr;gap:20px;}
@media(max-width:1200px){.g4{grid-template-columns:repeat(2,1fr);}}
@media(max-width:768px){.g4,.g2,.g3{grid-template-columns:1fr !important;}}

.act-item{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid rgba(26,86,240,0.07);}
.act-item:last-child{border-bottom:none;}
.act-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
.act-title{font-size:13px;color:#e2e8f0;font-weight:500;}
.act-sub{font-size:11.5px;color:var(--muted);margin-top:2px;}

.prog-bar{height:5px;border-radius:5px;background:rgba(26,86,240,0.1);margin-top:7px;overflow:hidden;}
.prog-fill{height:100%;border-radius:5px;background:linear-gradient(90deg,#1a56f0,#3b82f6);transition:width 1.2s ease;}

.quick-action{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:12px;border:1px solid rgba(26,86,240,0.12);background:rgba(26,86,240,0.04);cursor:pointer;text-decoration:none;transition:all .25s;}
.quick-action:hover{background:rgba(26,86,240,0.1);border-color:rgba(26,86,240,0.3);transform:translateX(4px);}
[dir="rtl"] .quick-action:hover{transform:translateX(-4px);}
.quick-action .qi{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
</style>
@endpush

@section('content')

{{-- ── Stat Cards ── --}}
<div class="g4">
    <div class="stat-card blue">
        <div class="si blue"><i class="fas fa-users"></i></div>
        <div class="sv">{{ $stats['total_clients'] }}</div>
        <div class="sl">{{ app()->getLocale()==='ar'?'إجمالي العملاء':'Total Clients' }}</div>
        <div class="sc up"><i class="fas fa-arrow-up"></i> +12% {{ app()->getLocale()==='ar'?'هذا الشهر':'this month' }}</div>
    </div>
    <div class="stat-card red">
        <div class="si red"><i class="fas fa-inbox"></i></div>
        <div class="sv">{{ $stats['new_leads'] }}</div>
        <div class="sl">{{ app()->getLocale()==='ar'?'طلبات جديدة':'New Leads' }}</div>
        <div class="sc up"><i class="fas fa-arrow-up"></i> +5 {{ app()->getLocale()==='ar'?'اليوم':'today' }}</div>
    </div>
    <div class="stat-card green">
        <div class="si green"><i class="fas fa-folder-open"></i></div>
        <div class="sv">{{ $stats['active_projects'] }}</div>
        <div class="sl">{{ app()->getLocale()==='ar'?'مشاريع نشطة':'Active Projects' }}</div>
        <div class="sc up"><i class="fas fa-arrow-up"></i> 2 {{ app()->getLocale()==='ar'?'تنتهي هذا الأسبوع':'due this week' }}</div>
    </div>
    <div class="stat-card purple">
        <div class="si purple"><i class="fas fa-dollar-sign"></i></div>
        <div class="sv">${{ number_format($stats['monthly_revenue']) }}</div>
        <div class="sl">{{ app()->getLocale()==='ar'?'الإيرادات الشهرية':'Monthly Revenue' }}</div>
        <div class="sc up"><i class="fas fa-arrow-up"></i> +18% {{ app()->getLocale()==='ar'?'مقارنة بالشهر الماضي':'vs last month' }}</div>
    </div>
</div>

{{-- ── Charts ── --}}
<div class="g2">
    <div class="adm-card">
        <div class="sec-head">
            <div class="ac"></div>
            {{ app()->getLocale()==='ar'?'الطلبات شهريًا':'Leads per Month' }}
        </div>
        <canvas id="leadsChart" height="200"></canvas>
    </div>
    <div class="adm-card">
        <div class="sec-head">
            <div class="ac"></div>
            {{ app()->getLocale()==='ar'?'توزيع المشاريع':'Project Status' }}
        </div>
        <div style="display:flex;align-items:center;justify-content:center;gap:30px;flex-wrap:wrap;padding-top:10px;">
            <canvas id="statusChart" height="180" width="180" style="max-width:180px;"></canvas>
            <div id="status-legend" style="display:flex;flex-direction:column;gap:10px;"></div>
        </div>
    </div>
</div>

{{-- ── Leads + Sidebar ── --}}
<div class="g3">

    {{-- Recent Leads Table --}}
    <div class="adm-card">
        <div class="sec-head">
            <div class="ac"></div>
            {{ app()->getLocale()==='ar'?'أحدث الطلبات':'Recent Leads' }}
            <a href="{{ route('admin.leads.index') }}" class="btn-ghost-adm" style="margin-inline-start:auto;font-size:11px;">
                {{ app()->getLocale()==='ar'?'عرض الكل':'View All' }} <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}"></i>
            </a>
        </div>
        <table class="adm-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale()==='ar'?'العميل':'Client' }}</th>
                    <th>{{ app()->getLocale()==='ar'?'الخدمة':'Service' }}</th>
                    <th>{{ app()->getLocale()==='ar'?'الميزانية':'Budget' }}</th>
                    <th>{{ app()->getLocale()==='ar'?'الحالة':'Status' }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLeads as $lead)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1241c0,#1a56f0);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr($lead->name,0,1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;color:#e2e8f0;font-size:13px;">{{ $lead->name }}</div>
                                <div style="font-size:11px;color:var(--muted);">{{ $lead->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;">{{ $lead->service_type_label }}</td>
                    <td style="font-size:12.5px;">{{ $lead->budget ? '$'.$lead->budget : '—' }}</td>
                    <td>
                        @if($lead->status==='pending')     <span class="badge b-pend">New</span>
                        @elseif($lead->status==='in_progress') <span class="badge b-act">In Progress</span>
                        @elseif($lead->status==='completed')   <span class="badge b-done">Done</span>
                        @else <span class="badge b-rej">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.leads.show',$lead) }}" class="btn-ghost-adm" style="padding:5px 10px;font-size:11px;">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:36px;">
                    {{ app()->getLocale()==='ar'?'لا يوجد طلبات بعد':'No leads yet.' }}
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Sidebar: Messages + Quick Actions --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Recent Messages --}}
        <div class="adm-card">
            <div class="sec-head">
                <div class="ac"></div>
                {{ app()->getLocale()==='ar'?'آخر الرسائل':'Recent Messages' }}
            </div>
            @forelse($recentMessages as $msg)
            <div class="act-item">
                <div class="act-icon" style="background:rgba(26,86,240,0.12);color:#60a5fa;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="act-title">{{ $msg->name }}</div>
                    <div class="act-sub">{{ Str::limit($msg->message ?? $msg->subject, 42) }}</div>
                    <div class="act-sub" style="margin-top:3px;color:#374151;">{{ $msg->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:13px;text-align:center;padding:20px 0;">
                {{ app()->getLocale()==='ar'?'لا توجد رسائل':'No messages yet.' }}
            </p>
            @endforelse
        </div>

        {{-- Quick Actions --}}
        <div class="adm-card">
            <div class="sec-head"><div class="ac"></div>{{ app()->getLocale()==='ar'?'إجراءات سريعة':'Quick Actions' }}</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('admin.invoices.create') }}" class="quick-action">
                    <div class="qi" style="background:rgba(26,86,240,0.12);color:#3b82f6;"><i class="fas fa-file-invoice"></i></div>
                    <span style="color:#e2e8f0;font-size:13px;font-weight:500;">{{ app()->getLocale()==='ar'?'إنشاء فاتورة':'Create Invoice' }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}" style="margin-inline-start:auto;color:var(--muted);font-size:10px;"></i>
                </a>
                <a href="{{ route('admin.projects.create') }}" class="quick-action">
                    <div class="qi" style="background:rgba(16,185,129,0.12);color:#34d399;"><i class="fas fa-plus-circle"></i></div>
                    <span style="color:#e2e8f0;font-size:13px;font-weight:500;">{{ app()->getLocale()==='ar'?'مشروع جديد':'New Project' }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}" style="margin-inline-start:auto;color:var(--muted);font-size:10px;"></i>
                </a>
                <a href="{{ route('admin.leads.index') }}" class="quick-action">
                    <div class="qi" style="background:rgba(239,68,68,0.12);color:#f87171;"><i class="fas fa-inbox"></i></div>
                    <span style="color:#e2e8f0;font-size:13px;font-weight:500;">{{ app()->getLocale()==='ar'?'مراجعة الطلبات':'Review Leads' }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}" style="margin-inline-start:auto;color:var(--muted);font-size:10px;"></i>
                </a>
                <a href="{{ route('admin.clients.index') }}" class="quick-action">
                    <div class="qi" style="background:rgba(139,92,246,0.12);color:#a78bfa;"><i class="fas fa-users"></i></div>
                    <span style="color:#e2e8f0;font-size:13px;font-weight:500;">{{ app()->getLocale()==='ar'?'إدارة العملاء':'Manage Clients' }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale()==='ar'?'left':'right' }}" style="margin-inline-start:auto;color:var(--muted);font-size:10px;"></i>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Leads Bar Chart ──
const leadsCtx = document.getElementById('leadsChart').getContext('2d');
const leadsData = @json($leadsPerMonth);
new Chart(leadsCtx,{
    type:'bar',
    data:{
        labels:leadsData.map(d=>{const m=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];return m[parseInt(d.month)-1]||d.month;}),
        datasets:[{label:'Leads',data:leadsData.map(d=>d.total),backgroundColor:'rgba(26,86,240,0.25)',borderColor:'#1a56f0',borderWidth:2,borderRadius:8,hoverBackgroundColor:'rgba(26,86,240,0.45)'}]
    },
    options:{
        responsive:true,
        plugins:{legend:{display:false}},
        scales:{
            x:{grid:{color:'rgba(26,86,240,0.05)'},ticks:{color:'#64748b',font:{size:11}}},
            y:{grid:{color:'rgba(26,86,240,0.05)'},ticks:{color:'#64748b',stepSize:1,font:{size:11}},beginAtZero:true}
        }
    }
});

// ── Status Donut ──
const sCtx = document.getElementById('statusChart').getContext('2d');
const sData = @json($projectStatus);
const sColors={active:'#1a56f0',completed:'#10b981',pending:'#f59e0b',archived:'#6b7280'};
const labels=sData.map(d=>d.status.charAt(0).toUpperCase()+d.status.slice(1));
const values=sData.map(d=>d.total);
const colors=sData.map(d=>sColors[d.status]||'#6b7280');
new Chart(sCtx,{
    type:'doughnut',
    data:{labels,datasets:[{data:values,backgroundColor:colors,borderColor:'#080d1e',borderWidth:3,hoverOffset:6}]},
    options:{responsive:false,cutout:'70%',plugins:{legend:{display:false}}}
});
const lg=document.getElementById('status-legend');
labels.forEach((l,i)=>{
    lg.innerHTML+=`<div style="display:flex;align-items:center;gap:8px;"><div style="width:9px;height:9px;border-radius:50%;background:${colors[i]};flex-shrink:0;"></div><span style="font-size:12px;color:#94a3b8;">${l}</span><span style="font-size:13px;font-weight:700;color:#e2e8f0;margin-inline-start:4px;">${values[i]}</span></div>`;
});

// ── Animate progress bars ──
setTimeout(()=>{
    document.querySelectorAll('.prog-fill').forEach(el=>{
        el.style.width=el.dataset.width||'0%';
    });
},500);
</script>
@endpush
