<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $timestamps = false; 

    protected $fillable = [
        'category_name',
        'parent_category_id',
        'category_image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }
}