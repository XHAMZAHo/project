@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'الإعدادات العامة' : 'General Settings')
@section('page-title', app()->getLocale()==='ar' ? 'إعدادات النظام' : 'System Settings')

@section('content')
<div class="adm-card" style="max-width:900px;margin:0 auto;">
    <h2 class="sec-head"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'تحديث إعدادات النظام' : 'Update System Settings' }}</h2>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PATCH')

        {{-- General Section --}}
        <h3 style="color:#60a5fa;font-size:14px;font-weight:700;margin-bottom:16px;">{{ app()->getLocale()==='ar'?'معلومات الموقع الأساسية':'Basic Website Info' }}</h3>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:30px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'اسم الموقع (عربي)':'Site Name (AR)' }}</label>
                <input type="text" name="site_name_ar" value="{{ old('site_name_ar', $settings['site_name_ar'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'اسم الموقع (إنجليزي)':'Site Name (EN)' }}</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'بريد التواصل':'Contact Email' }}</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'رقم واتساب (للطلبات)':'WhatsApp Number (for Orders)' }}</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="9665XXXXXXXX" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
                <small style="color:var(--muted);font-size:10.5px;">{{ app()->getLocale()==='ar'?'اكتب الرقم بالرمز الدولي بدون أصفار أو + (مثال: 96650000)':'Enter with country code, no + or 00 (e.g., 96650000)' }}</small>
            </div>
        </div>

        {{-- SEO Section --}}
        <h3 style="color:#60a5fa;font-size:14px;font-weight:700;margin-bottom:16px;padding-top:20px;border-top:1px solid var(--border);">{{ app()->getLocale()==='ar'?'إعدادات SEO':'SEO Settings' }}</h3>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:30px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'عنوان الصفحة (عربي)':'Meta Title (AR)' }}</label>
                <input type="text" name="meta_title_ar" value="{{ old('meta_title_ar', $settings['meta_title_ar'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'عنوان الصفحة (إنجليزي)':'Meta Title (EN)' }}</label>
                <input type="text" name="meta_title_en" value="{{ old('meta_title_en', $settings['meta_title_en'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div style="grid-column:1/-1;">
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'وصف الموقع (عربي)':'Meta Description (AR)' }}</label>
                <textarea name="meta_desc_ar" rows="3" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('meta_desc_ar', $settings['meta_desc_ar'] ?? '') }}</textarea>
            </div>
            <div style="grid-column:1/-1;">
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'وصف الموقع (إنجليزي)':'Meta Description (EN)' }}</label>
                <textarea name="meta_desc_en" rows="3" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('meta_desc_en', $settings['meta_desc_en'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- Social Links --}}
        <h3 style="color:#60a5fa;font-size:14px;font-weight:700;margin-bottom:16px;padding-top:20px;border-top:1px solid var(--border);">{{ app()->getLocale()==='ar'?'روابط التواصل الاجتماعي':'Social Links' }}</h3>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:30px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">Twitter / X URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:16px;margin-bottom:20px;color:#f87171;">
            <ul style="margin:0;padding-inline-start:20px;">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div style="text-align:end;">
            <button type="submit" class="btn-adm" style="padding:12px 30px;"><i class="fas fa-save"></i> {{ app()->getLocale()==='ar'?'حفظ الإعدادات':'Save Settings' }}</button>
        </div>
    </form>
</div>
@endsection
