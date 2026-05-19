<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Billable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
        'role',         // admin | staff | client
        'company',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    // ── Role helpers ──────────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->is_admin || $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'  => 'Administrator',
            'staff'  => 'Staff',
            'client' => 'Client',
            default  => ucfirst($this->role),
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        $initials = urlencode(strtoupper(substr($this->name, 0, 1)));
        return "https://ui-avatars.com/api/?name={$initials}&background=1d4ed8&color=fff&size=80";
    }

    // ── Relationships ─────────────────────────────────────────────────
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function projectFiles(): HasMany
    {
        return $this->hasMany(ProjectFile::class, 'uploaded_by');
    }
}
