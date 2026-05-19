@extends('layouts.client')

@section('title', 'Files')
@section('page_title', 'All Project Files')

@section('content')
<div class="client-card">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-white">Files Across Projects</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">File Name</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Project</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Size</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Uploaded By</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30">Date</th>
                    <th class="py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-900/30 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-900/10">
                @forelse($files as $file)
                    <tr class="hover:bg-[#0f1424] transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-blue-900/20 text-blue-400 flex items-center justify-center shrink-0">
                                    <i class="{{ $file->icon_class }}"></i>
                                </div>
                                <div class="font-medium text-white truncate max-w-[200px]" title="{{ $file->original_name }}">{{ $file->original_name }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-blue-400 hover:underline">
                            <a href="{{ route('client.projects.show', $file->project) }}">{{ $file->project->title }}</a>
                        </td>
                        <td class="py-4 px-4 text-sm text-slate-300">{{ $file->human_size }}</td>
                        <td class="py-4 px-4 text-sm text-slate-300">
                            {{ $file->uploader->id === auth()->id() ? 'You' : $file->uploader->name }}
                        </td>
                        <td class="py-4 px-4 text-sm text-slate-300">{{ $file->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('file.download', $file) }}" class="w-8 h-8 rounded-lg bg-blue-900/20 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($file->uploaded_by === auth()->id())
                                    <form action="{{ route('client.files.destroy', $file) }}" method="POST" class="inline" onsubmit="return confirm('Delete this file?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-900/20 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">No files found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $files->links() }}
    </div>
</div>
@endsection
