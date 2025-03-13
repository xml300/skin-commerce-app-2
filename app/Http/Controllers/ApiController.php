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

    public function storeProduct(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'product_images' => 'nullable|array', // Adjust validation as needed for images
        ]);

        $products = Product::all();
        $productData = [
            'id' => $products->max("id") + 1,
            'product_name' => $validatedData['product_name'],
            'description' => $validatedData['description'],
            'brand_id' => 1, // Static brand ID
            'category_id' => intval($validatedData['category_id']),
            'price' => floatval($validatedData['price']),
            'stock_quantity' => 0, // Static stock quantity
            'rating_average' => 0.0, // Static rating
            'review_count' => 0,    // Static review count
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString(),
        ];
        Product::create($productData);
       
        return response()->json([], 200);
    }


    public function deleteProduct(string $productID): JsonResponse
    {
        $product = Product::where("id", "=", $productID)->first();
        if(!$product){
            return response()->json([], 404);
        }
        $product->delete();
        return response()->json([], 200);
    }

    public function updateProduct(Request $request, string $productId): JsonResponse
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'image-upload' => 'nullable|string'
        ]);

        $product = Product::where("id", "=", $productId)->first();

        if (!$product) {
            return response()->json([], 404);
        }

        dd($validatedData);

        $product->product_name = $validatedData['product_name'];
        $product->description = $validatedData['description'];
        $product->price = floatval($validatedData['price']);
        $product->category_id = intval($validatedData['category_id']);
        $product->save();

        if ($validatedData['image-upload'] != "") {
            $productImagesData = [
                "product_id" => $product->id,
                "image_url" => $validatedData['image-upload']
            ];
            ProductImage::create($productImagesData);
        }

        return response()->json(['message' => "Product with ID {$productId} updated successfully.", 'updatedProduct' => $product], 200); 
    }
}