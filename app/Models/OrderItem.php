<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','service_id','service_title','price','quantity','subtotal','notes',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()   { return $this->belongsTo(Order::class); }
    public function service() { return $this->belongsTo(Service::class); }
}
