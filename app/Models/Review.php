<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    public $timestamps = false; // Review table has review_date instead of created_at/updated_at
    const CREATED_AT = 'review_date';
    const UPDATED_AT = null; // If no updated_at equivalent

    protected $fillable = [
        'review_id', // If you want to allow manual assignment of review_id
        'user_id',
        'product_id',
        'rating',
        'review_text',
        'review_date',
        'is_approved',
    ];

    protected $casts = [
        'review_date' => 'datetime',
        'is_approved' => 'boolean', // or 'integer' if TINYINT(1)
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}