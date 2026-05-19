<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequestRequest;
use App\Models\ServiceRequest;

class ServiceRequestController extends Controller
{
    public function store(StoreServiceRequestRequest $request)
    {
        ServiceRequest::create($request->validated());

        return back()->with('success', 'Your service request has been submitted successfully! Our team will contact you within 24 hours.');
    }

    // Admin methods
    public function index()
    {
        $serviceRequests = ServiceRequest::latest()->paginate(15);
        $pendingCount = ServiceRequest::pending()->count();

        return view('admin.service-requests.index', compact('serviceRequests', 'pendingCount'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        return view('admin.service-requests.show', compact('serviceRequest'));
    }

    public function update(ServiceRequest $serviceRequest)
    {
        $validated = request()->validate([
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],
        ]);

        $serviceRequest->update($validated);

        return back()->with('success', 'Status updated successfully.');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();

        return redirect()->route('admin.service-requests.index')
            ->with('success', 'Service request deleted successfully.');
    }
}
