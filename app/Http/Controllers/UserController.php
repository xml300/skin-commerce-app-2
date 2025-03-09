<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        $categories = Category::all();
        $title = 'Skincare Shop - homepage';
        return view('user.index', compact("title", "products", "categories"));
    }

    public function products(Request $request): View
    {
        $products = Product::join("categories", "products.category_id", "categories.id")->get();
        $categories = Category::all();
        if(!is_null($request->category)){
            $category = $request->category;
            $products = $products->where("category_name", "=",$category);
        }
        $title = 'Skincare Shop - Products';
        $currentCategory = $request->category;
        return view('user.product-list', compact('title', "products", "categories", "currentCategory"));
    }

    public function productDetails(string $productId): View
    {
        return view('user.product-details', ['title' => 'Skincare Shop - Product Details']);
    }

    public function cart(): View
    {
        return view('user.cart', ['title' => 'Skincare Shop - Cart']);
    }

    public function checkout(): View
    {
        return view('user.checkout', ['title' => 'Skincare Shop - Checkout']);
    }

    public function orderConfirmation(): View
    {
        return view('user.order-confirm', ['title' => 'Skincare Shop - Order Confirmation']);
    }
}