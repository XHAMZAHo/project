<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    protected static function booted(): void
    {
        static::creating(function (Technology $technology) {
            if (empty($technology->slug)) {
                $technology->slug = Str::slug($technology->name);
            }
        });
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
