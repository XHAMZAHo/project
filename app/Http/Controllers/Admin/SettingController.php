<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allKeyed();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string|max:20',
            'site_name'       => 'required|string|max:100',
            'site_name_ar'    => 'required|string|max:100',
            'contact_email'   => 'required|email|max:150',
            'meta_title_ar'   => 'nullable|string|max:200',
            'meta_title_en'   => 'nullable|string|max:200',
            'meta_desc_ar'    => 'nullable|string|max:300',
            'meta_desc_en'    => 'nullable|string|max:300',
            'instagram_url'   => 'nullable|url|max:300',
            'twitter_url'     => 'nullable|url|max:300',
            'linkedin_url'    => 'nullable|url|max:300',
        ]);

        $keys = [
            'whatsapp_number','site_name','site_name_ar','contact_email',
            'meta_title_ar','meta_title_en','meta_desc_ar','meta_desc_en',
            'instagram_url','twitter_url','linkedin_url',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        // Clear all setting cache
        Cache::flush();

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم حفظ الإعدادات.' : 'Settings saved successfully.');
    }
}
