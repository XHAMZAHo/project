<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('service')) {
            $query->where('service_type', $request->service);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            });
        }

        $leads = $query->paginate(15);
        return view('admin.leads.index', compact('leads'));
    }

    public function show(ServiceRequest $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function update(Request $request, ServiceRequest $lead)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes'  => 'nullable|string',
        ]);

        $lead->update($request->only('status', 'notes'));
        return back()->with('success', 'Lead updated successfully.');
    }

    public function destroy(ServiceRequest $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted.');
    }
}
