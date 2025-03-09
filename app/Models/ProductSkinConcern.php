<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSkinConcern extends Model
{
    use HasFactory;

    protected $table = 'productskinconcerns';
    protected $primaryKey = ['product_id', 'skin_concern_id'];
    public $incrementing = false; // Composite primary key, not auto-incrementing
    public $timestamps = false; // Assuming no timestamps columns

    protected $fillable = [
        'product_id',
        'skin_concern_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function skinConcern()
    {
        return $this->belongsTo(SkinConcern::class, 'skin_concern_id');
    }
}