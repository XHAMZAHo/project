<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Project::with('technologies');

        if ($user->isClient()) {
            $query->where('user_id', $user->id);
        }

        $projects = $query->latest()->get()->groupBy('status');

        return view('client.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorizeClientAccess($project);

        $project->load(['technologies', 'files.uploader']);

        return view('client.projects.show', compact('project'));
    }

    private function authorizeClientAccess(Project $project): void
    {
        $user = auth()->user();
        if ($user->isClient() && $project->user_id !== $user->id) {
            abort(403);
        }
    }
}
