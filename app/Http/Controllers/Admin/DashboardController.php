<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Project;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients'    => User::where('is_admin', false)->count(),
            'new_leads'        => ServiceRequest::where('status', 'pending')->count(),
            'active_projects'  => Project::where('status', 'active')->count(),
            'monthly_revenue'  => 12500, // placeholder – replace with Invoice model sum later
        ];

        // Leads per month (last 6 months)
        $leadsPerMonth = ServiceRequest::select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('count(*) as total')
            )
            ->whereRaw("created_at >= date('now','-6 months')")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Project status distribution
        $projectStatus = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Recent activities
        $recentLeads    = ServiceRequest::latest()->take(5)->get();
        $recentMessages = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'leadsPerMonth', 'projectStatus',
            'recentLeads', 'recentMessages'
        ));
    }
}
