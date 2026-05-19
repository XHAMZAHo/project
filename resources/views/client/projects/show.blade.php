@extends('layouts.client')

@section('title', $project->title)
@section('page_title', 'Project Details')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('client.projects.index') }}" class="w-10 h-10 rounded-xl bg-blue-900/20 border border-blue-500/30 text-blue-400 flex items-center justify-center hover:bg-blue-800/40 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-white">{{ $project->title }}</h1>
    <span class="status-badge status-{{ $project->status === 'active' ? 'pending' : 'paid' }} capitalize ml-auto">
        {{ $project->status }}
    </span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Project Info -->
        <div class="client-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 blur-[80px] rounded-full pointer-events-none"></div>
            
            <h2 class="text-lg font-bold text-white mb-4">Project Overview</h2>
            <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed">
                {!! nl2br(e($project->description)) !!}
            </div>
            
            <div class="mt-6 pt-6 border-t border-blue-900/30 grid grid-cols-2 gap-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Started</div>
                    <div class="font-medium text-white">{{ $project->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Completed</div>
                    <div class="font-medium text-white">{{ $project->completed_at ? $project->completed_at->format('M d, Y') : 'In Progress' }}</div>
                </div>
            </div>
        </div>

        <!-- Technologies -->
        @if($project->technologies->isNotEmpty())
        <div class="client-card">
            <h2 class="text-lg font-bold text-white mb-4">Technologies Used</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($project->technologies as $tech)
                    <div class="flex items-center gap-2 bg-[#0f1424] border border-blue-900/30 rounded-lg px-4 py-2">
                        @if($tech->icon_class)
                            <i class="{{ $tech->icon_class }} text-blue-400 text-lg"></i>
                        @endif
                        <span class="text-sm font-medium text-slate-200">{{ $tech->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-8">
        <!-- Live Link -->
        @if($project->url)
        <div class="client-card border-blue-500/50 bg-blue-900/10">
            <h2 class="text-lg font-bold text-white mb-4">Project URL</h2>
            <a href="{{ $project->url }}" target="_blank" class="btn-primary w-full justify-center">
                <i class="fas fa-external-link-alt"></i> Visit Live Site
            </a>
        </div>
        @endif

        <!-- Project Files Widget -->
        <div class="client-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-white">Project Files</h2>
                <span class="text-xs font-bold bg-blue-900/50 text-blue-400 px-2 py-1 rounded">{{ $project->files->count() }}</span>
            </div>
            
            <div class="space-y-3 mb-4 max-h-64 overflow-y-auto pr-2">
                @forelse($project->files as $file)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-[#0f1424] border border-blue-900/30 group">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-8 h-8 rounded bg-blue-900/20 text-blue-400 flex items-center justify-center shrink-0">
                                <i class="{{ $file->icon_class }}"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-sm font-medium text-white truncate">{{ $file->original_name }}</div>
                                <div class="text-xs text-slate-500">{{ $file->human_size }}</div>
                            </div>
                        </div>
                        <a href="{{ route('file.download', $file) }}" class="text-slate-400 hover:text-blue-400 transition ml-2">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6 text-sm text-slate-500">No files uploaded yet.</div>
                @endforelse
            </div>

            <!-- Upload Form -->
            <form action="{{ route('client.files.upload', $project) }}" method="POST" enctype="multipart/form-data" class="pt-4 border-t border-blue-900/30">
                @csrf
                <div class="relative border-2 border-dashed border-blue-900/50 rounded-lg p-4 text-center hover:border-blue-500/50 transition bg-[#0f1424]">
                    <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('file-name').textContent = this.files[0].name">
                    <i class="fas fa-cloud-upload-alt text-2xl text-blue-400 mb-2"></i>
                    <div class="text-sm text-slate-300 font-medium mb-1">Click or drag file to upload</div>
                    <div id="file-name" class="text-xs text-slate-500">Max size 20MB</div>
                </div>
                <button type="submit" class="btn-secondary w-full justify-center mt-3 text-sm py-2">Upload File</button>
            </form>
        </div>
    </div>
</div>
@endsection
