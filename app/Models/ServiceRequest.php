<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_type',
        'budget',
        'description',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400">Pending</span>',
            'in_progress' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400">In Progress</span>',
            'completed' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400">Completed</span>',
            'cancelled' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400">Cancelled</span>',
            default => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500/20 text-gray-400">Unknown</span>',
        };
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return match ($this->service_type) {
            'web_design' => 'Web Design',
            'web_development' => 'Web Development',
            'mobile_app' => 'Mobile App',
            'custom_system' => 'Custom System',
            default => $this->service_type,
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
