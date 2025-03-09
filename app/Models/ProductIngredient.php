<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    use HasFactory;

    protected $table = 'productingredients';
    protected $primaryKey = ['product_id', 'ingredient_id'];
    public $incrementing = false; // Composite primary key, not auto-incrementing
    public $timestamps = false; // Assuming no timestamps columns

    protected $fillable = [
        'product_id',
        'ingredient_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
}