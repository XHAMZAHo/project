@extends('layouts.admin')

@section('title', 'Projects Kanban')
@section('page-title', 'Projects <span>Kanban Board</span>')

@push('styles')
<style>
.kanban-wrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    align-items: start;
}
@media(max-width:1100px){ .kanban-wrapper{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:640px) { .kanban-wrapper{ grid-template-columns: 1fr; } }

.kanban-col {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    min-height: 480px;
}
.kanban-col-header {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
}
.kanban-col-title {
    font-size: 13px; font-weight: 700; color: #fff;
    flex: 1;
}
.kanban-count {
    background: rgba(37,99,235,0.15);
    color: #60a5fa;
    font-size: 11px; font-weight: 700;
    padding: 2px 8px; border-radius: 100px;
}
.kanban-cards { padding: 12px; display: flex; flex-direction: column; gap: 10px; }

.kanban-card {
    background: var(--bg-card2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px;
    cursor: grab;
    transition: all 0.25s;
    position: relative;
}
.kanban-card:hover {
    border-color: rgba(37,99,235,0.35);
    box-shadow: 0 8px 30px rgba(0,0,0,0.35);
    transform: translateY(-2px);
}
.kanban-card.dragging {
    opacity: 0.4;
    cursor: grabbing;
}
.card-stripe {
    position: absolute; top:0; left:0;
    height: 3px; width: 100%; border-radius: 12px 12px 0 0;
}
.card-title { font-size:13.5px; font-weight:700; color:#fff; margin-top:6px; }
.card-client { font-size:11.5px; color:var(--text-muted); margin-top:3px; }
.card-progress { margin-top:10px; }
.card-prog-label { display:flex; justify-content:space-between; font-size:11px; color:var(--text-muted); margin-bottom:4px; }
.prog-track { height:4px; background:rgba(37,99,235,0.1); border-radius:4px; overflow:hidden; }
.prog-fill  { height:100%; border-radius:4px; }

.col-pending  .kanban-col-header { border-top: 2px solid #f59e0b; }
.col-active   .kanban-col-header { border-top: 2px solid #3b82f6; }
.col-review   .kanban-col-header { border-top: 2px solid #8b5cf6; }
.col-completed .kanban-col-header { border-top: 2px solid #10b981; }

.drop-zone { min-height: 60px; border-radius: 10px; transition: background .2s; }
.drop-zone.drag-over { background: rgba(37,99,235,0.08); border: 2px dashed rgba(37,99,235,0.35); }
</style>
@endpush

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;">
    <div>
        <h2 style="font-size:22px;font-weight:800;color:#fff;">Project Board</h2>
        <p style="color:var(--text-muted);font-size:13px;margin-top:3px;">Drag cards between columns to update status</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> New Project
    </a>
</div>

<div class="kanban-wrapper">

    @foreach(['pending'=>['New','#f59e0b','fas fa-clock'],'active'=>['In Progress','#3b82f6','fas fa-spinner'],'review'=>['Review','#8b5cf6','fas fa-eye'],'completed'=>['Completed','#10b981','fas fa-check-circle']] as $col=>[$label,$color,$icon])
    <div class="kanban-col col-{{ $col }}" data-col="{{ $col }}">
        <div class="kanban-col-header">
            <i class="{{ $icon }}" style="color:{{ $color }};font-size:13px;"></i>
            <div class="kanban-col-title">{{ $label }}</div>
            <span class="kanban-count">{{ $columns[$col]->count() }}</span>
        </div>
        <div class="kanban-cards drop-zone" id="col-{{ $col }}">
            @foreach($columns[$col] as $project)
            <div class="kanban-card" draggable="true" data-id="{{ $project->id }}" data-col="{{ $col }}">
                <div class="card-stripe" style="background:{{ $color }};"></div>
                <div class="card-title">{{ $project->title }}</div>
                <div class="card-client"><i class="fas fa-user" style="font-size:10px;margin-right:4px;"></i>{{ $project->client_name }}</div>
                @if($project->url)
                <div style="margin-top:6px;">
                    <a href="{{ $project->url }}" target="_blank" style="font-size:11px;color:#60a5fa;text-decoration:none;">
                        <i class="fas fa-link" style="font-size:10px;"></i> {{ $project->url }}
                    </a>
                </div>
                @endif
                <div style="margin-top:10px;display:flex;gap:6px;">
                    @if($project->is_featured)
                    <span style="background:rgba(234,179,8,0.12);color:#fbbf24;font-size:10px;padding:2px 8px;border-radius:6px;">
                        <i class="fas fa-star"></i> Featured
                    </span>
                    @endif
                    <span style="font-size:10px;color:var(--text-muted);">{{ $project->created_at->format('M d') }}</span>
                </div>
                <div style="margin-top:10px;display:flex;gap:6px;justify-content:flex-end;">
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete project?')">
                        @csrf @method('DELETE')
                        <button style="background:none;border:none;color:#f87171;cursor:pointer;font-size:12px;" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

</div>

@endsection

@push('scripts')
<script>
// ── Drag & Drop Kanban ──
let dragged = null;

document.querySelectorAll('.kanban-card').forEach(card => {
    card.addEventListener('dragstart', () => {
        dragged = card;
        setTimeout(() => card.classList.add('dragging'), 0);
    });
    card.addEventListener('dragend', () => {
        card.classList.remove('dragging');
    });
});

document.querySelectorAll('.drop-zone').forEach(zone => {
    zone.addEventListener('dragover', e => {
        e.preventDefault();
        zone.classList.add('drag-over');
    });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        if (dragged) {
            const newCol = zone.closest('.kanban-col').dataset.col;
            const projectId = dragged.dataset.id;
            zone.appendChild(dragged);
            dragged.dataset.col = newCol;
            // AJAX status update
            fetch(`/admin/projects/${projectId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newCol })
            });
            // Update counts
            document.querySelectorAll('.kanban-col').forEach(col => {
                const count = col.querySelector('.drop-zone').children.length;
                col.querySelector('.kanban-count').textContent = count;
            });
        }
    });
});
</script>
@endpush
