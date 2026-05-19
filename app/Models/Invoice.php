<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'client_name', 'client_email', 'client_phone',
        'user_id', 'subtotal', 'tax_rate', 'tax_amount', 'total',
        'currency', 'status', 'notes', 'due_date', 'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'subtotal' => 'float',
        'tax_rate' => 'float',
        'tax_amount' => 'float',
        'total'    => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recalculate(): void
    {
        $subtotal = $this->items->sum('subtotal');
        $tax      = round($subtotal * ($this->tax_rate / 100), 2);
        $this->update([
            'subtotal'   => $subtotal,
            'tax_amount' => $tax,
            'total'      => $subtotal + $tax,
        ]);
    }

    public static function nextNumber(): string
    {
        $year  = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'INV-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid'      => '#10b981',
            'pending'   => '#f59e0b',
            'overdue'   => '#ef4444',
            'cancelled' => '#6b7280',
            default     => '#6b7280',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'Paid',
            'pending'   => 'Pending',
            'overdue'   => 'Overdue',
            'cancelled' => 'Cancelled',
            default     => ucfirst($this->status),
        };
    }

    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency) {
            'SAR' => 'ر.س',
            'USD' => '$',
            'EUR' => '€',
            'AED' => 'د.إ',
            default => $this->currency,
        };
    }
}
