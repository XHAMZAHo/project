<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class EmailOtp extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'attempts'   => 'integer',
    ];

    // ── Constants ──────────────────────────────────────────────────────────
    public const EXPIRY_MINUTES  = 5;
    public const MAX_ATTEMPTS    = 5;
    public const RESEND_COOLDOWN = 60; // seconds between resends

    // ── Relationships ──────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /** Check if this OTP is still within its validity window. */
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /** Check if the user has exceeded maximum allowed attempts. */
    public function isLocked(): bool
    {
        return $this->attempts >= self::MAX_ATTEMPTS;
    }

    /** Verify the given plain-text OTP against the stored hash. */
    public function verify(string $plainOtp): bool
    {
        return hash('sha256', $plainOtp) === $this->otp;
    }

    /** Increment failed attempt counter. */
    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    // ── Static Factories ───────────────────────────────────────────────────

    /**
     * Generate a new 6-digit OTP for the given user.
     * Deletes any previous OTPs for that user first.
     */
    public static function generateFor(User $user): array
    {
        // Clean up old OTPs
        self::where('user_id', $user->id)->delete();

        $plain = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $record = self::create([
            'user_id'    => $user->id,
            'otp'        => hash('sha256', $plain),
            'attempts'   => 0,
            'expires_at' => Carbon::now()->addMinutes(self::EXPIRY_MINUTES),
        ]);

        return ['plain' => $plain, 'record' => $record];
    }

    /**
     * Get the active (non-expired, non-locked) OTP for a user ID.
     */
    public static function activeFor(int $userId): ?self
    {
        return self::where('user_id', $userId)
            ->where('expires_at', '>', Carbon::now())
            ->where('attempts', '<', self::MAX_ATTEMPTS)
            ->latest()
            ->first();
    }
}
