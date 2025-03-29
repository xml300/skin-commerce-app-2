<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    use HasFactory;

    protected $table = 'skin_types';
    public $timestamps = false; 

    protected $fillable = [
        'skin_type_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductSkinTypes', 'skin_type_id', 'product_id');
    }
}