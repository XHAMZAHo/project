<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // For admin/staff testing — show all data; for real client — filter by user_id
        $isRealClient = $user->isClient();

        $projects = $isRealClient
            ? Project::where('user_id', $user->id)->latest()->take(5)->get()
            : Project::latest()->take(5)->get();

        $invoices = $isRealClient
            ? Invoice::where('user_id', $user->id)->latest()->take(5)->get()
            : Invoice::latest()->take(5)->get();

        $unreadMessages = Message::where('receiver_id', $user->id)->unread()->count();

        $stats = [
            'total_projects'  => $isRealClient ? Project::where('user_id', $user->id)->count() : Project::count(),
            'active_projects' => $isRealClient ? Project::where('user_id', $user->id)->where('status', 'active')->count()
                                               : Project::where('status', 'active')->count(),
            'total_invoices'  => $isRealClient ? Invoice::where('user_id', $user->id)->count() : Invoice::count(),
            'pending_amount'  => $isRealClient
                ? Invoice::where('user_id', $user->id)->whereIn('status', ['pending', 'overdue'])->sum('total')
                : Invoice::whereIn('status', ['pending', 'overdue'])->sum('total'),
            'unread_messages' => $unreadMessages,
        ];

        return view('client.dashboard', compact('projects', 'invoices', 'stats', 'unreadMessages'));
    }
}
