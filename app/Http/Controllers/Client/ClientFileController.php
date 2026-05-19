<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientFileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = ProjectFile::with(['project', 'uploader']);

        if ($user->isClient()) {
            $query->whereHas('project', fn($q) => $q->where('user_id', $user->id));
        }

        $files = $query->latest()->paginate(20);

        return view('client.files.index', compact('files'));
    }

    public function upload(Request $request, Project $project)
    {
        $request->validate([
            'file'        => 'required|file|max:20480', // 20MB max
            'description' => 'nullable|string|max:255',
        ]);

        $uploaded = $request->file('file');
        $path     = $uploaded->store("files/{$project->id}", 'local');

        ProjectFile::create([
            'project_id'    => $project->id,
            'uploaded_by'   => auth()->id(),
            'original_name' => $uploaded->getClientOriginalName(),
            'stored_path'   => $path,
            'disk'          => 'local',
            'mime_type'     => $uploaded->getMimeType(),
            'size_bytes'    => $uploaded->getSize(),
            'description'   => $request->description,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function download(ProjectFile $file)
    {
        // Authorize
        $user = auth()->user();
        if ($user->isClient() && $file->project->user_id !== $user->id) {
            abort(403);
        }

        return Storage::disk($file->disk)->download($file->stored_path, $file->original_name);
    }

    public function destroy(ProjectFile $file)
    {
        $user = auth()->user();
        if ($user->isClient() && $file->uploaded_by !== $user->id) {
            abort(403);
        }

        Storage::disk($file->disk)->delete($file->stored_path);
        $file->delete();

        return back()->with('success', 'File deleted.');
    }
}
