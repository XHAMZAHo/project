<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
        'price_monthly',
        'price_yearly',
        'features',
        'max_projects',
        'max_clients',
        'max_invoices',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'features'      => 'array',
        'price_monthly' => 'float',
        'price_yearly'  => 'float',
        'is_active'     => 'boolean',
        'is_featured'   => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getYearlySavingsAttribute(): float
    {
        return round(($this->price_monthly * 12) - $this->price_yearly, 2);
    }

    public function getYearlySavingsPercentAttribute(): int
    {
        if ($this->price_monthly <= 0) return 0;
        return (int) round((($this->price_monthly * 12 - $this->price_yearly) / ($this->price_monthly * 12)) * 100);
    }
}
