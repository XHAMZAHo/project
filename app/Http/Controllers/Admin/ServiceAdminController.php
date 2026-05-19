<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceAdminController extends Controller
{
    public function index()
    {
        $services = Service::ordered()->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_ar'      => 'required|string|max:200',
            'title_en'      => 'required|string|max:200',
            'description_ar'=> 'nullable|string',
            'description_en'=> 'nullable|string',
            'features_ar'   => 'nullable|string',
            'features_en'   => 'nullable|string',
            'icon'          => 'nullable|string|max:100',
            'color'         => 'nullable|string|max:20',
            'price'         => 'nullable|numeric|min:0',
            'price_max'     => 'nullable|numeric|min:0',
            'price_type'    => 'required|in:fixed,range,custom',
            'delivery_days' => 'nullable|string|max:50',
            'category'      => 'nullable|string|max:100',
            'is_active'     => 'boolean',
            'is_featured'   => 'boolean',
            'sort_order'    => 'nullable|integer',
        ]);

        // Parse features from textarea (one per line) to JSON
        if (!empty($data['features_ar'])) {
            $data['features_ar'] = json_encode(array_filter(array_map('trim', explode("\n", $data['features_ar']))));
        }
        if (!empty($data['features_en'])) {
            $data['features_en'] = json_encode(array_filter(array_map('trim', explode("\n", $data['features_en']))));
        }

        $data['slug']        = Str::slug($request->title_en);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title_ar'      => 'required|string|max:200',
            'title_en'      => 'required|string|max:200',
            'description_ar'=> 'nullable|string',
            'description_en'=> 'nullable|string',
            'features_ar'   => 'nullable|string',
            'features_en'   => 'nullable|string',
            'icon'          => 'nullable|string|max:100',
            'color'         => 'nullable|string|max:20',
            'price'         => 'nullable|numeric|min:0',
            'price_max'     => 'nullable|numeric|min:0',
            'price_type'    => 'required|in:fixed,range,custom',
            'delivery_days' => 'nullable|string|max:50',
            'category'      => 'nullable|string|max:100',
            'is_active'     => 'boolean',
            'is_featured'   => 'boolean',
            'sort_order'    => 'nullable|integer',
        ]);

        if (!empty($data['features_ar'])) {
            $data['features_ar'] = json_encode(array_filter(array_map('trim', explode("\n", $data['features_ar']))));
        }
        if (!empty($data['features_en'])) {
            $data['features_en'] = json_encode(array_filter(array_map('trim', explode("\n", $data['features_en']))));
        }

        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        return response()->json(['active' => $service->is_active]);
    }
}
