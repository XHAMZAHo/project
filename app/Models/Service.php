<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Service extends Model
{
    protected $fillable = [
        'slug','title_ar','title_en','description_ar','description_en',
        'features_ar','features_en','icon','color','price','price_max',
        'price_type','delivery_days','category','is_active','is_featured',
        'sort_order','image',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'price'       => 'decimal:2',
        'price_max'   => 'decimal:2',
    ];

    // ── Accessors ──────────────────────────────────────────────────────────
    public function title(): Attribute
    {
        return Attribute::get(fn() => app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en);
    }

    public function description(): Attribute
    {
        return Attribute::get(fn() => app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en);
    }

    public function featuresArray(): Attribute
    {
        return Attribute::get(function () {
            $raw = app()->getLocale() === 'ar' ? $this->features_ar : $this->features_en;
            if (!$raw) return [];
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        });
    }

    public function priceLabel(): Attribute
    {
        return Attribute::get(function () {
            $ar = app()->getLocale() === 'ar';
            if ($this->price_type === 'custom') return $ar ? 'حسب الطلب' : 'Custom Quote';
            if ($this->price_type === 'range' && $this->price_max) {
                return number_format($this->price, 0) . ' - ' . number_format($this->price_max, 0) . ' ' . ($ar ? 'ر.س' : 'SAR');
            }
            if ($this->price) return number_format($this->price, 0) . ' ' . ($ar ? 'ر.س' : 'SAR');
            return $ar ? 'حسب الطلب' : 'Custom Quote';
        });
    }

    // ── Scopes ─────────────────────────────────────────────────────────────
    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
    public function scopeOrdered($q)  { return $q->orderBy('sort_order')->orderBy('id'); }

    // ── Relations ──────────────────────────────────────────────────────────
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
