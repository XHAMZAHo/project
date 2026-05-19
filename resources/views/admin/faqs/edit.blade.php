@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'تعديل سؤال' : 'Edit FAQ')
@section('page-title', app()->getLocale()==='ar' ? 'تعديل السؤال' : 'Edit FAQ')

@section('content')
<div class="adm-card" style="max-width:800px;margin:0 auto;">
    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
        @csrf @method('PATCH')

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'السؤال (بالعربية) *':'Question (AR) *' }}</label>
                <input type="text" name="question_ar" value="{{ old('question_ar', $faq->question_ar) }}" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'السؤال (بالإنجليزية) *':'Question (EN) *' }}</label>
                <input type="text" name="question_en" value="{{ old('question_en', $faq->question_en) }}" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:20px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الإجابة (بالعربية) *':'Answer (AR) *' }}</label>
                <textarea name="answer_ar" rows="4" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('answer_ar', $faq->answer_ar) }}</textarea>
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'الإجابة (بالإنجليزية) *':'Answer (EN) *' }}</label>
                <textarea name="answer_en" rows="4" required style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;resize:vertical;">{{ old('answer_en', $faq->answer_en) }}</textarea>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:30px;">
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'التصنيف':'Category' }}</label>
                <select name="category" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;appearance:none;">
                    <option value="general" {{ old('category', $faq->category)=='general'?'selected':'' }}>{{ app()->getLocale()==='ar'?'عام':'General' }}</option>
                    <option value="services" {{ old('category', $faq->category)=='services'?'selected':'' }}>{{ app()->getLocale()==='ar'?'الخدمات':'Services' }}</option>
                    <option value="payment" {{ old('category', $faq->category)=='payment'?'selected':'' }}>{{ app()->getLocale()==='ar'?'الدفع':'Payment' }}</option>
                    <option value="technical" {{ old('category', $faq->category)=='technical'?'selected':'' }}>{{ app()->getLocale()==='ar'?'تقني':'Technical' }}</option>
                </select>
            </div>
            <div>
                <label style="display:block;color:var(--dim);font-size:12px;font-weight:600;margin-bottom:8px;">{{ app()->getLocale()==='ar'?'ترتيب العرض':'Sort Order' }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" style="width:100%;background:var(--bg-base);border:1px solid var(--border);border-radius:10px;padding:12px 14px;color:#fff;outline:none;">
            </div>
        </div>

        <label style="display:flex;align-items:center;gap:10px;color:#fff;font-size:13px;cursor:pointer;margin-bottom:20px;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} style="width:18px;height:18px;">
            {{ app()->getLocale()==='ar'?'مفعل':'Active' }}
        </label>

        @if($errors->any())
        <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:16px;margin-bottom:20px;color:#f87171;">
            <ul style="margin:0;padding-inline-start:20px;">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div style="display:flex;justify-content:flex-end;gap:12px;">
            <a href="{{ route('admin.faqs.index') }}" class="btn-ghost-adm">{{ app()->getLocale()==='ar'?'إلغاء':'Cancel' }}</a>
            <button type="submit" class="btn-adm"><i class="fas fa-save"></i> {{ app()->getLocale()==='ar'?'حفظ التعديلات':'Save Changes' }}</button>
        </div>
    </form>
</div>
@endsection
