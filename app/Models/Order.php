<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $timestamps = true; 

    protected $fillable = [
        'order_id', 
        'user_id',
        'order_status',
        'shipping_address',
        'shipping_method',
        'billing_address',
        'payment_method',
        'payment_status',
        'total_amount',
        'shipping_cost',
        'discount_applied',
        'tracking_number',
    ];

    protected $casts = [
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