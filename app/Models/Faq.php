<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Faq extends Model
{
    protected $fillable = [
        'question_ar','question_en','answer_ar','answer_en','category','is_active','sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function question(): Attribute
    {
        return Attribute::get(fn() => app()->getLocale() === 'ar' ? $this->question_ar : $this->question_en);
    }

    public function answer(): Attribute
    {
        return Attribute::get(fn() => app()->getLocale() === 'ar' ? $this->answer_ar : $this->answer_en);
    }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order')->orderBy('id'); }
}
