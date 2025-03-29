<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{
    public function products(Request $request): JsonResponse
    {
        $categories = Category::all();
        $products = Product::join("categories", "products.category_id", "=", "categories.id")->get();

        $categoryFilter = $request->query('category');
        if ($categoryFilter) {
            $lowerCaseCategory = strtolower($categoryFilter);
            $products = $products->where("category_name", "=", $lowerCaseCategory);
        }
        return response()->json($products->values()->toArray());
    }

    public function product(string $productID): JsonResponse
    {
        $product = Product::join("categories", "products.category_id", "=", "categories.id")
            ->where("products.id", "=", $productID)
            ->first();

        return response()->json($product);
    }

    public function categories(): JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories->values()->toArray());
    }
}