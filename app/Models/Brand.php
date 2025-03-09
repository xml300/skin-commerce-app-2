<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    public $timestamps = false; // Assuming no timestamps columns

    protected $fillable = [
        'brand_name',
        'brand_logo',
        'brand_description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}