<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'shipping_status',
        'shipping_method',
        'shipping_fee',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'note'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
} 