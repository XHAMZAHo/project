<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('technologies')->latest()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $technologies = Technology::orderBy('name')->get();

        return view('admin.projects.create', compact('technologies'));
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured');

        $project = Project::create($data);

        if (!empty($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $technologies = Technology::orderBy('name')->get();
        $project->load('technologies');

        return view('admin.projects.edit', compact('project', 'technologies'));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        $project->update($data);

        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->technologies()->detach();
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
