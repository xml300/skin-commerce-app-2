<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\User;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Product;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        // Validate the login request data
        $credentials = $request->validate([
            'username' => 'required|string', // Or 'email' if you want to allow login by email
            'password' => 'required|string',
        ]);

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended('/dashboard'); // Redirect to dashboard or intended URL after login
        }

        // Authentication failed
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.', // Or 'email'
        ])->onlyInput('username'); // Keep the username input for convenience
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ];

        // 2. Validate the request data using $request->validate()
        $validatedData = $request->validate($rules);


        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'billing_address' => $request->billing_address,
            'phone_number' => $request->phone_number,
        ]);

        // Optionally, log the user in after registration
        Auth::login($user);
        $request->session()->regenerate(); // Prevent session fixation

        return redirect()->route('dashboard'); // Redirect to dashboard or a welcome page
    }

    // Example logout function (you might need this as well)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect to homepage or login page after logout
    }
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