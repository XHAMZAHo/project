<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'description', 'quantity', 'unit_price', 'subtotal',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'float',
        'subtotal'   => 'float',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted(): void
    {
        static::saving(function (InvoiceItem $item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }
}
