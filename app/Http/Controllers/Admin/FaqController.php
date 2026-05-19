<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::ordered()->paginate(30);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_ar' => 'required|string|max:500',
            'question_en' => 'required|string|max:500',
            'answer_ar'   => 'required|string',
            'answer_en'   => 'required|string',
            'category'    => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question_ar' => 'required|string|max:500',
            'question_en' => 'required|string|max:500',
            'answer_ar'   => 'required|string',
            'answer_en'   => 'required|string',
            'category'    => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}
