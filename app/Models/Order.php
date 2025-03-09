<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $timestamps = true; // Assuming created_at and updated_at columns exist

    protected $fillable = [
        'order_id', // If you want to allow manual assignment of order_id
        'user_id',
        'order_date',
        'order_status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'total_amount',
        'shipping_cost',
        'discount_applied',
        'tracking_number',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_applied' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}