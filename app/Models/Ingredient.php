<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredients';
    public $timestamps = false; 

    protected $fillable = [
        'ingredient_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductIngredients', 'ingredient_id', 'product_id');
    }
}