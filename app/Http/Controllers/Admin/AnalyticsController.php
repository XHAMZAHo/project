<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Project;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Leads by service type
        $byService = ServiceRequest::select('service_type', DB::raw('count(*) as total'))
            ->groupBy('service_type')->get();

        // Conversion (pending→completed)
        $totalLeads     = ServiceRequest::count();
        $convertedLeads = ServiceRequest::where('status','completed')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100) : 0;

        // Monthly leads (last 12 months)
        $monthly = ServiceRequest::select(
                DB::raw("strftime('%Y-%m', created_at) as month"),
                DB::raw('count(*) as total')
            )
            ->whereRaw("created_at >= date('now','-12 months')")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Summary stats
        $stats = [
            'total_leads'       => $totalLeads,
            'conversion_rate'   => $conversionRate,
            'active_projects'   => Project::where('status','active')->count(),
            'total_clients'     => User::where('is_admin',false)->count(),
            'messages'          => Contact::count(),
        ];

        return view('admin.analytics.index', compact(
            'byService','conversionRate','monthly','stats'
        ));
    }
}
