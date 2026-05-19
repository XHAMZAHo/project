<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('is_admin', false)
            ->withCount('projects')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        $projects = $client->projects()->latest()->get();
        return view('admin.clients.show', compact('client', 'projects'));
    }
}
