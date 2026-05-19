<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $columns = [
            'pending'    => Project::where('status', 'pending')->with('user')->latest()->get(),
            'active'     => Project::where('status', 'active')->with('user')->latest()->get(),
            'review'     => Project::where('status', 'review')->with('user')->latest()->get(),
            'completed'  => Project::where('status', 'completed')->with('user')->latest()->get(),
        ];
        return view('admin.projects.kanban', compact('columns'));
    }

    public function create(Request $request)
    {
        $lead = $request->filled('lead_id')
            ? ServiceRequest::find($request->lead_id)
            : null;
        return view('admin.projects.create', compact('lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,active,review,completed,archived',
        ]);

        $data = $request->only('title','client_name','description','status','url','is_featured');
        $data['is_featured'] = $request->boolean('is_featured');

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function updateStatus(Request $request, Project $project)
    {
        $request->validate(['status' => 'required|in:pending,active,review,completed,archived']);
        $project->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }
}
