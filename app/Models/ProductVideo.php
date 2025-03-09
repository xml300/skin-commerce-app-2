<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    use HasFactory;

    protected $table = 'productvideos';
    public $timestamps = false; // Assuming no timestamps columns

    protected $fillable = [
        'product_id',
        'video_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}