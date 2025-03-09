<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Product;

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
        $categories = json_decode(file_get_contents(database_path('seeders/data/categories.json')), true);
        return response()->json($categories);
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

        $products = collect(json_decode(file_get_contents(database_path('seeders/data/products.json')), true));

        $productData = [
            'product_id' => $products->max('product_id') + 1,
            'product_name' => $validatedData['product_name'],
            'description' => $validatedData['description'],
            'ingredients' => [ // Static ingredients from original code
                "Water", "Hyaluronic Acid", "Glycerin", "Propanediol", "Sodium Hyaluronate", "Panthenol (Vitamin B5)", "Ceramides", "Phenoxyethanol", "Ethylhexylglycerin"
            ],
            'skin_types' => ["dry", "combination", "sensitive", "normal"], // Static skin types
            'skin_concerns' => ["dryness", "fine lines", "dehydration", "aging"], // Static skin concerns
            'brand_id' => 1, // Static brand ID
            'category_id' => intval($validatedData['category_id']),
            'price' => floatval($validatedData['price']),
            'stock_quantity' => 150, // Static stock quantity
            'product_images' => $validatedData['product_images'] ?? [], // Use provided or default to empty array
            'product_videos' => [], // Static empty array
            'rating_average' => 4.7, // Static rating
            'review_count' => 75,    // Static review count
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString(),
        ];

        $newProducts = $products->push($productData)->values()->toArray();
        file_put_contents(database_path('seeders/data/products.json'), json_encode($newProducts, JSON_PRETTY_PRINT));

        return response()->json([], 200);
    }


    public function deleteProduct(string $productID): JsonResponse
    {
        $products = collect(json_decode(file_get_contents(database_path('seeders/data/products.json')), true));
        $newProducts = $products->filter(function ($product) use ($productID) {
            return $product['product_id'] != intval($productID);
        })->values()->toArray();

        file_put_contents(database_path('seeders/data/products.json'), json_encode($newProducts, JSON_PRETTY_PRINT));
        return response()->json([], 200);
    }

    public function updateProduct(Request $request, string $productId): JsonResponse
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'image-upload' => 'nullable|string', // Assuming image-upload is a URL string
        ]);

        $products = collect(json_decode(file_get_contents(database_path('seeders/data/products.json')), true));
        $productIndex = $products->search(function ($product) use ($productId) {
            return $product['product_id'] == intval($productId);
        });

        if ($productIndex === false) {
            return response()->json(['error' => 'Product not found for editing.'], 404);
        }

        $products[$productIndex] = array_merge($products[$productIndex], [
            'product_name' => $validatedData['product_name'],
            'description' => $validatedData['description'],
            'price' => floatval($validatedData['price']),
            'category_id' => intval($validatedData['category_id']),
            'product_images' => [$validatedData['image-upload'] ?? ''], // Use provided or default to empty array
        ]);

        file_put_contents(database_path('seeders/data/products.json'), json_encode($products->values()->toArray(), JSON_PRETTY_PRINT));

        return response()->json(['message' => "Product with ID {$productId} updated successfully.", 'updatedProduct' => $products[$productIndex]], 200);
    }
}