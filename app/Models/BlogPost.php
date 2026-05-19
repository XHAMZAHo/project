<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'category',
        'tags',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'tags'         => 'array',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/blog-placeholder.jpg');
    }

    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->body));
        $minutes = ceil($words / 200);
        return $minutes . ' min read';
    }
}
