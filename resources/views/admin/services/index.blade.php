@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'الخدمات' : 'Services')
@section('page-title', app()->getLocale()==='ar' ? 'إدارة الخدمات' : 'Manage Services')

@section('content')
<div class="adm-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <h2 class="sec-head" style="margin:0;"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'جميع الخدمات' : 'All Services' }}</h2>
        <a href="{{ route('admin.services.create') }}" class="btn-adm">
            <i class="fas fa-plus"></i> {{ app()->getLocale()==='ar' ? 'إضافة خدمة جديدة' : 'Add New Service' }}
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale()==='ar' ? 'الخدمة' : 'Service' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'السعر' : 'Price' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الترتيب' : 'Sort Order' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:rgba(26,86,240,0.1);display:flex;align-items:center;justify-content:center;color:{{ $service->color }};">
                                <i class="{{ $service->icon }}"></i>
                            </div>
                            <div>
                                <p style="font-weight:600;color:#fff;">{{ $service->title }}</p>
                                <p style="font-size:11px;color:var(--muted);">{{ $service->category ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{ $service->price_label }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        <button onclick="toggleService({{ $service->id }})" id="btn-toggle-{{ $service->id }}" class="badge {{ $service->is_active ? 'b-act' : 'b-rej' }}" style="border:none;cursor:pointer;">
                            {{ $service->is_active ? (app()->getLocale()==='ar' ? 'نشط' : 'Active') : (app()->getLocale()==='ar' ? 'معطل' : 'Inactive') }}
                        </button>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn-ghost-adm" style="color:#60a5fa;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد؟' : 'Are you sure?' }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-ghost-adm" style="color:#f87171;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:var(--muted);">{{ app()->getLocale()==='ar' ? 'لا توجد خدمات مضافة.' : 'No services found.' }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $services->links('pagination::tailwind') }}
    </div>
</div>

@push('scripts')
<script>
async function toggleService(id) {
    try {
        const res = await fetch(`/admin/services/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        const btn = document.getElementById(`btn-toggle-${id}`);
        if(data.active) {
            btn.className = 'badge b-act';
            btn.textContent = '{{ app()->getLocale()==='ar' ? "نشط" : "Active" }}';
        } else {
            btn.className = 'badge b-rej';
            btn.textContent = '{{ app()->getLocale()==='ar' ? "معطل" : "Inactive" }}';
        }
    } catch(e) {
        alert('Error toggling status');
    }
}
</script>
@endpush
@endsection
