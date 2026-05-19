@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'إضافة خدمة' : 'Add Service')
@section('page-title', app()->getLocale()==='ar' ? 'إضافة خدمة جديدة' : 'Add New Service')

@section('content')
<div class="adm-card" style="max-width:900px;margin:0 auto;">
    <h2 class="sec-head"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'بيانات الخدمة' : 'Service Details' }}</h2>

    <form method="POST" action="{{ route('admin.services.store') }}">
        @csrf

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الاسم (بالعربية) *':'Title (AR) *' }}</label>
                <input type="text" name="title_ar" value="{{ old('title_ar') }}" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الاسم (بالإنجليزية) *':'Title (EN) *' }}</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الوصف (بالعربية)':'Description (AR)' }}</label>
                <textarea name="description_ar" rows="3" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('description_ar') }}</textarea>
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الوصف (بالإنجليزية)':'Description (EN)' }}</label>
                <textarea name="description_en" rows="3" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('description_en') }}</textarea>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'المميزات (بالعربية - سطر لكل ميزة)':'Features (AR - one per line)' }}</label>
                <textarea name="features_ar" rows="4" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('features_ar') }}</textarea>
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'المميزات (بالإنجليزية - سطر لكل ميزة)':'Features (EN - one per line)' }}</label>
                <textarea name="features_en" rows="4" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('features_en') }}</textarea>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الأيقونة (FontAwesome)':'Icon (FontAwesome)' }}</label>
                <input type="text" name="icon" value="{{ old('icon', 'fas fa-cogs') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'اللون المميّز':'Color' }}</label>
                <input type="color" name="color" value="{{ old('color', '#1a56f0') }}" style="width:100%;height:46px;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:4px;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'التصنيف':'Category' }}</label>
                <input type="text" name="category" value="{{ old('category') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        <h3 style="color:#fff;font-size:14px;font-weight:700;margin:30px 0 16px;border-top:1px solid var(--border);padding-top:20px;">{{ app()->getLocale()==='ar'?'التسعير والخيارات':'Pricing & Options' }}</h3>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'نوع التسعير':'Pricing Type' }}</label>
                <select name="price_type" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;appearance:none;">
                    <option value="fixed" {{ old('price_type')=='fixed'?'selected':'' }}>{{ app()->getLocale()==='ar'?'ثابت':'Fixed' }}</option>
                    <option value="range" {{ old('price_type')=='range'?'selected':'' }}>{{ app()->getLocale()==='ar'?'متغير (من - إلى)':'Range' }}</option>
                    <option value="custom" {{ old('price_type')=='custom'?'selected':'' }}>{{ app()->getLocale()==='ar'?'حسب الطلب':'Custom Quote' }}</option>
                </select>
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'السعر الأساسي':'Base Price' }}</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الحد الأقصى (في حال المتغير)':'Max Price (for range)' }}</label>
                <input type="number" step="0.01" name="price_max" value="{{ old('price_max') }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:30px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'مدة التنفيذ':'Delivery Days' }}</label>
                <input type="text" name="delivery_days" value="{{ old('delivery_days') }}" placeholder="e.g. 3-5 Days" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'ترتيب العرض':'Sort Order' }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div style="display:flex;flex-direction:column;gap:14px;padding-top:28px;">
                <label style="display:flex;align-items:center;gap:10px;color:#fff;font-size:13px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:18px;height:18px;">
                    {{ app()->getLocale()==='ar'?'خدمة مفعلة':'Active Service' }}
                </label>
                <label style="display:flex;align-items:center;gap:10px;color:#fff;font-size:13px;cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width:18px;height:18px;">
                    {{ app()->getLocale()==='ar'?'مميزة (في الرئيسية)':'Featured (Home Page)' }}
                </label>
            </div>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:16px;margin-bottom:20px;color:#f87171;">
            <ul style="margin:0;padding-inline-start:20px;">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:20px;">
            <a href="{{ route('admin.services.index') }}" class="btn-ghost-adm">{{ app()->getLocale()==='ar'?'إلغاء':'Cancel' }}</a>
            <button type="submit" class="btn-adm"><i class="fas fa-save"></i> {{ app()->getLocale()==='ar'?'حفظ الخدمة':'Save Service' }}</button>
        </div>

    </form>
</div>
@endsection
