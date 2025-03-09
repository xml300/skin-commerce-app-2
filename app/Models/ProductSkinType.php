<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSkinType extends Model
{
    use HasFactory;

    protected $table = 'productskintypes';
    protected $primaryKey = ['product_id', 'skin_type_id'];
    public $incrementing = false; // Composite primary key, not auto-incrementing
    public $timestamps = false; // Assuming no timestamps columns

    protected $fillable = [
        'product_id',
        'skin_type_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function skinType()
    {
        return $this->belongsTo(SkinType::class, 'skin_type_id');
    }
}