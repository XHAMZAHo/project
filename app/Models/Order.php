<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number','user_id','customer_name','customer_email','customer_phone',
        'notes','subtotal','total','status','payment_status','whatsapp_sent',
        'admin_notes','confirmed_at','completed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'subtotal'     => 'decimal:2',
        'total'        => 'decimal:2',
    ];

    // ── Status Labels ───────────────────────────────────────────────────────
    public function statusLabel(): string
    {
        $ar = app()->getLocale() === 'ar';
        return match($this->status) {
            'pending'     => $ar ? 'قيد الانتظار' : 'Pending',
            'confirmed'   => $ar ? 'مؤكد'         : 'Confirmed',
            'in_progress' => $ar ? 'قيد التنفيذ'  : 'In Progress',
            'completed'   => $ar ? 'مكتمل'         : 'Completed',
            'cancelled'   => $ar ? 'ملغي'           : 'Cancelled',
            default       => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'     => 'b-pend',
            'confirmed'   => 'b-act',
            'in_progress' => 'b-new',
            'completed'   => 'b-done',
            'cancelled'   => 'b-rej',
            default       => 'b-new',
        };
    }

    // ── WhatsApp Message ────────────────────────────────────────────────────
    public function whatsappMessage(): string
    {
        $ar    = app()->getLocale() === 'ar';
        $items = $this->items->map(fn($i) => "• {$i->service_title} — {$i->price} " . ($ar ? 'ر.س' : 'SAR'))->implode("\n");

        if ($ar) {
            return "مرحباً، أود تأكيد طلبي:\n\n" .
                   "الاسم: {$this->customer_name}\n" .
                   "رقم الطلب: #{$this->order_number}\n\n" .
                   "الخدمات:\n{$items}\n\n" .
                   "الإجمالي: {$this->total} ر.س\n\n" .
                   ($this->notes ? "ملاحظات: {$this->notes}" : '');
        }

        return "Hello, I'd like to confirm my order:\n\n" .
               "Name: {$this->customer_name}\n" .
               "Order #: {$this->order_number}\n\n" .
               "Services:\n{$items}\n\n" .
               "Total: {$this->total} SAR\n\n" .
               ($this->notes ? "Notes: {$this->notes}" : '');
    }

    // ── Boot ────────────────────────────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(substr(uniqid(), -6));
        });
    }

    // ── Relations ───────────────────────────────────────────────────────────
    public function user()  { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
}
