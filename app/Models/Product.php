<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primary = 'id';
    public $timestamps = true; // Assuming created_at and updated_at columns exist

    protected $fillable = [
        'id',
        'product_id', // If you want to allow manual assignment of product_id
        'product_name',
        'description',
        'brand_id',
        'category_id',
        'price',
        'stock_quantity',
        'rating_average',
        'review_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating_average' => 'decimal:2',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ProductIngredients', 'product_id', 'ingredient_id');
    }

    public function skinTypes()
    {
        return $this->belongsToMany(SkinType::class, 'ProductSkinTypes', 'product_id', 'skin_type_id');
    }

    public function skinConcerns()
    {
        return $this->belongsToMany(SkinConcern::class, 'ProductSkinConcerns', 'product_id', 'skin_concern_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function productVideos()
    {
        return $this->hasMany(ProductVideo::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
}