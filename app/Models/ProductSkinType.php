<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSkinType extends Model
{
    use HasFactory;

    protected $table = 'product_skin_types';
    protected $primaryKey = ['product_id', 'skin_type_id'];
    public $incrementing = false; 
    public $timestamps = false; 

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