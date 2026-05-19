<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'client_name',
        'image',
        'url',
        'is_featured',
        'status',
        'category',
        'completed_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'completed_at' => 'date',
    ];

    // Auto-generate slug from title
    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // External URL (Unsplash, CDN, etc.)
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            // Local public/images/ directory
            if (file_exists(public_path('images/' . $this->image))) {
                return asset('images/' . $this->image);
            }
            // Storage directory
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        return asset('images/project-placeholder.jpg');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeReview($query)
    {
        return $query->where('status', 'review');
    }
}
