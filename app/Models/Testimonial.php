<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_position',
        'client_company',
        'content',
        'rating',
        'avatar',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&background=2563EB&color=fff&size=128';
    }

    public function getStarsHtmlAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating
                ? '<svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>'
                : '<svg class="w-5 h-5 text-gray-600 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>';
        }
        return $stars;
    }
}
