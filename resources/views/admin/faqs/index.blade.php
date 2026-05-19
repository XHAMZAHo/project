@extends('layouts.admin')
@section('title', app()->getLocale()==='ar' ? 'الأسئلة الشائعة' : 'FAQs')
@section('page-title', app()->getLocale()==='ar' ? 'إدارة الأسئلة الشائعة' : 'Manage FAQs')

@section('content')
<div class="adm-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <h2 class="sec-head" style="margin:0;"><div class="ac"></div> {{ app()->getLocale()==='ar' ? 'الأسئلة الشائعة' : 'FAQs' }}</h2>
        <a href="{{ route('admin.faqs.create') }}" class="btn-adm">
            <i class="fas fa-plus"></i> {{ app()->getLocale()==='ar' ? 'إضافة سؤال جديد' : 'Add New FAQ' }}
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale()==='ar' ? 'السؤال' : 'Question' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'التصنيف' : 'Category' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الترتيب' : 'Order' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale()==='ar' ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>
                        <p style="font-weight:600;color:#fff;margin-bottom:4px;">{{ Str::limit($faq->question_ar, 50) }}</p>
                        <p style="font-size:12px;color:var(--dim);">{{ Str::limit($faq->question_en, 50) }}</p>
                    </td>
                    <td>{{ $faq->category ?? '-' }}</td>
                    <td>{{ $faq->sort_order }}</td>
                    <td>
                        <span class="badge {{ $faq->is_active ? 'b-act' : 'b-rej' }}">
                            {{ $faq->is_active ? (app()->getLocale()==='ar' ? 'نشط' : 'Active') : (app()->getLocale()==='ar' ? 'معطل' : 'Inactive') }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn-ghost-adm" style="color:#60a5fa;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale()==='ar' ? 'هل أنت متأكد؟' : 'Are you sure?' }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-ghost-adm" style="color:#f87171;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:var(--muted);">{{ app()->getLocale()==='ar' ? 'لا توجد أسئلة مضافة.' : 'No FAQs found.' }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $faqs->links('pagination::tailwind') }}
    </div>
</div>
@endsection
