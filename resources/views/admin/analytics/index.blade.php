@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-title', 'Analytics <span>& Insights</span>')

@push('styles')
<style>
.analytics-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:24px; }
.charts-row { display:grid; grid-template-columns:2fr 1fr; gap:20px; }
@media(max-width:1000px){ .analytics-grid{grid-template-columns:1fr 1fr;} .charts-row{grid-template-columns:1fr;} }
@media(max-width:600px)  { .analytics-grid{grid-template-columns:1fr;} }

.big-stat {
    text-align:center; padding:28px 20px;
    background:var(--bg-card); border:1px solid var(--border); border-radius:16px;
}
.big-stat-val { font-size:38px; font-weight:900; color:#fff; line-height:1; }
.big-stat-label { font-size:12.5px; color:var(--text-muted); margin-top:8px; }

.conv-ring {
    position:relative; width:140px; height:140px; margin:0 auto 16px;
}
.conv-pct {
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    font-size:26px; font-weight:900; color:#fff;
}
</style>
@endpush

@section('content')

{{-- Summary --}}
<div class="analytics-grid">
    <div class="big-stat" style="border-top:2px solid #3b82f6;">
        <div class="big-stat-val" style="color:#3b82f6;">{{ $stats['total_leads'] }}</div>
        <div class="big-stat-label">Total Leads Received</div>
    </div>
    <div class="big-stat" style="border-top:2px solid #10b981;">
        <div class="big-stat-val" style="color:#10b981;">{{ $conversionRate }}%</div>
        <div class="big-stat-label">Lead → Client Conversion</div>
    </div>
    <div class="big-stat" style="border-top:2px solid #8b5cf6;">
        <div class="big-stat-val" style="color:#8b5cf6;">{{ $stats['active_projects'] }}</div>
        <div class="big-stat-label">Active Projects Now</div>
    </div>
</div>

<div class="charts-row">

    {{-- Monthly trend --}}
    <div class="admin-card">
        <div class="section-heading"><div class="accent-line"></div> Monthly Leads (Last 12 Months)</div>
        <canvas id="monthlyChart" height="260"></canvas>
    </div>

    {{-- Services breakdown --}}
    <div class="admin-card">
        <div class="section-heading"><div class="accent-line"></div> Leads by Service</div>
        <canvas id="serviceChart" height="220" width="220" style="margin:0 auto;display:block;"></canvas>
        <div id="service-legend" style="display:flex;flex-direction:column;gap:8px;margin-top:16px;"></div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Monthly line chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyData = @json($monthly);

new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: monthlyData.map(d => d.month),
        datasets: [{
            label: 'Leads',
            data: monthlyData.map(d => d.total),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.12)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(37,99,235,0.05)' }, ticks: { color: '#64748b' } },
            y: { grid: { color: 'rgba(37,99,235,0.05)' }, ticks: { color: '#64748b', stepSize: 1 }, beginAtZero: true }
        }
    }
});

// Service pie chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
const serviceData = @json($byService);
const serviceColors = ['#3b82f6','#10b981','#8b5cf6','#f59e0b','#ef4444'];
const serviceLabels = {
    web_design: 'Web Design', web_development: 'Web Development',
    mobile_app: 'Mobile App', custom_system: 'Custom System'
};

new Chart(serviceCtx, {
    type: 'doughnut',
    data: {
        labels: serviceData.map(d => serviceLabels[d.service_type] || d.service_type),
        datasets: [{
            data: serviceData.map(d => d.total),
            backgroundColor: serviceColors,
            borderColor: '#0b0f1e',
            borderWidth: 3,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: false, cutout: '65%',
        plugins: { legend: { display: false } }
    }
});

// Legend
const legend = document.getElementById('service-legend');
serviceData.forEach((d, i) => {
    legend.innerHTML += `<div style="display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:10px;height:10px;border-radius:50%;background:${serviceColors[i]};"></div>
            <span style="font-size:12.5px;color:#94a3b8;">${serviceLabels[d.service_type] || d.service_type}</span>
        </div>
        <span style="font-size:13px;font-weight:700;color:#e2e8f0;">${d.total}</span>
    </div>`;
});
</script>
@endpush
