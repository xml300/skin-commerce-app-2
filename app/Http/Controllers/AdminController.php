<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $products = Product::join("categories",  "products.category_id", "=", "categories.id")->get();
        $categories = Category::all();
        return view('admin.admin', compact("products", "categories"));
    }
}