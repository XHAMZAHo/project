@extends('layouts.client')

@section('title', 'My Projects')
@section('page_title', 'My Projects')

@section('content')
<div class="space-y-8">
    @foreach(['active', 'review', 'completed'] as $status)
        @if(isset($projects[$status]) && $projects[$status]->count() > 0)
            <div>
                <h2 class="text-xl font-bold text-white mb-4 capitalize flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full 
                        @if($status==='active') bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)]
                        @elseif($status==='review') bg-amber-500 shadow-[0_0_10px_rgba(245,158,11,0.8)]
                        @else bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)] @endif">
                    </span>
                    {{ $status }} Projects
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects[$status] as $project)
                        <div class="client-card flex flex-col h-full group hover:-translate-y-1 transition-all duration-300">
                            <div class="h-40 rounded-lg overflow-hidden mb-4 relative bg-blue-900/20 border border-blue-500/20">
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0b0f1e] to-transparent"></div>
                            </div>
                            
                            <h3 class="text-lg font-bold text-white mb-2">{{ $project->title }}</h3>
                            <p class="text-sm text-slate-400 mb-4 flex-1 line-clamp-2">{{ Str::limit(strip_tags($project->description), 100) }}</p>
                            
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($project->technologies->take(3) as $tech)
                                    <span class="px-2 py-1 text-[10px] uppercase tracking-wider bg-blue-900/30 text-blue-300 rounded border border-blue-500/20">{{ $tech->name }}</span>
                                @endforeach
                            </div>
                            
                            <a href="{{ route('client.projects.show', $project) }}" class="btn-secondary w-full justify-center">View Project Details</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    @if($projects->isEmpty())
        <div class="client-card text-center py-16">
            <div class="w-20 h-20 bg-blue-900/20 border border-blue-500/30 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No Projects Yet</h3>
            <p class="text-slate-400">You don't have any projects associated with your account currently.</p>
        </div>
    @endif
</div>
@endsection
