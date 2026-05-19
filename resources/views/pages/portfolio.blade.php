@extends('layouts.app')
@section('title', __('site.portfolio'))
@section('content')

{{-- Hero --}}
<section class="relative pt-36 pb-20 overflow-hidden" style="background: #080d1e;">
    <div class="absolute inset-0 opacity-20"
         style="background: radial-gradient(ellipse at top center, #2563eb 0%, transparent 60%);"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <div class="section-badge mb-4" data-aos="fade-down">{{ __('site.portfolio') }}</div>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-5" data-aos="fade-up">
            {{ __('site.portfolio_title') }}
        </h1>
        <p class="text-slate-400 text-lg" data-aos="fade-up" data-aos-delay="100">
            {{ __('site.portfolio_subtitle') }}
        </p>
    </div>
</section>

{{-- Filter + Grid --}}
<section class="py-24" style="background: #03040e;">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Filter Tabs --}}
        <div class="flex flex-wrap gap-3 justify-center mb-14" data-aos="fade-up">
            @foreach(['all','web','app','system'] as $filter)
            <button onclick="filterProjects('{{ $filter }}')"
                    id="filter-{{ $filter }}"
                    class="filter-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300
                           {{ $filter === 'all' ? 'active-filter' : '' }}">
                @switch($filter)
                    @case('all')    {{ __('site.all') }}      @break
                    @case('web')    {{ __('site.websites') }}  @break
                    @case('app')    {{ __('site.apps') }}      @break
                    @case('system') {{ __('site.systems') }}   @break
                @endswitch
            </button>
            @endforeach
        </div>

        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="projects-grid">
            @forelse($projects as $i => $project)
            <div class="portfolio-card relative rounded-2xl overflow-hidden group cursor-pointer project-item"
                 data-type="{{ $project->category ?? 'web' }}"
                 style="border: 1px solid rgba(26,86,240,0.1); aspect-ratio: 4/3;"
                 data-aos="fade-up" data-aos-delay="{{ ($i % 6) * 80 }}"
                 onclick="openModal('{{ addslashes($project->title) }}','{{ addslashes($project->description ?? '') }}','{{ $project->image_url }}','{{ $project->url ?? '#' }}')">
                <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80'">
                <div class="portfolio-overlay absolute inset-0 flex flex-col items-end justify-end p-5"
                     style="background: linear-gradient(0deg, rgba(5,8,16,0.95) 0%, rgba(5,8,16,0.3) 60%, transparent 100%);">
                    <h3 class="text-white font-bold text-base mb-2">{{ $project->title }}</h3>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($project->technologies->take(3) as $tech)
                        <span class="text-xs px-2.5 py-0.5 rounded-full"
                              style="background:rgba(26,86,240,0.2); border:1px solid rgba(26,86,240,0.3); color:#3b82f6;">
                            {{ $tech->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                {{-- Hover overlay --}}
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"
                     style="background: rgba(26,86,240,0.08);">
                    <span class="text-sky-400 font-bold text-sm tracking-wide">{{ __('site.view_project') }} →</span>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20">
                <div class="text-6xl mb-4">🚀</div>
                <p class="text-slate-400">{{ app()->getLocale()==='ar' ? 'قريباً سيتم إضافة مشاريع رائعة!' : 'Amazing projects coming soon!' }}</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($projects->hasPages())
        <div class="mt-12 flex justify-center" data-aos="fade-up">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</section>

{{-- Modal --}}
<div id="proj-modal" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 hidden"
     onclick="if(event.target===this)closeModal()">
    <div class="absolute inset-0" style="background:rgba(0,0,0,0.85); backdrop-filter:blur(8px);"></div>
    <div class="relative glass-dark rounded-2xl w-full max-w-2xl overflow-hidden"
         style="border:1px solid rgba(26,86,240,0.2); max-height:90vh; overflow-y:auto;">
        <button onclick="closeModal()"
                class="absolute top-4 end-4 z-10 w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-white"
                style="background:rgba(255,255,255,0.05);">✕</button>
        <img id="m-img" src="" alt="" class="w-full aspect-video object-cover">
        <div class="p-8">
            <h3 id="m-title" class="text-2xl font-black text-white mb-3"></h3>
            <p id="m-desc" class="text-slate-400 leading-relaxed mb-6"></p>
            <a id="m-link" href="#" target="_blank" class="btn-glow inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold text-sm">
                {{ __('site.view_project') }} →
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filter
function filterProjects(type) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active-filter'));
    document.getElementById('filter-' + type).classList.add('active-filter');
    document.querySelectorAll('.project-item').forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
function openModal(title, desc, img, url) {
    document.getElementById('m-title').textContent = title;
    document.getElementById('m-desc').textContent  = desc;
    document.getElementById('m-img').src  = img;
    document.getElementById('m-link').href = url;
    document.getElementById('proj-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('proj-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });
</script>
<style>
.filter-btn {
    border: 1px solid rgba(26,86,240,0.2);
    color: #94a3b8;
    background: rgba(26,86,240,0.04);
}
.filter-btn:hover, .filter-btn.active-filter {
    background: rgba(26,86,240,0.15);
    border-color: rgba(26,86,240,0.5);
    color: #3b82f6;
    box-shadow: 0 0 20px rgba(26,86,240,0.2);
}
</style>
@endpush

@endsection
