<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinConcern extends Model
{
    use HasFactory;

    protected $table = 'skin_concerns';
    public $timestamps = false; 

    protected $fillable = [
        'skin_concern_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductSkinConcerns', 'skin_concern_id', 'product_id');
    }
}