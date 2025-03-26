<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Settings\GeneralSettings;


use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index(): View
    {
        $products = Product::join("categories", "products.category_id", "=", "categories.id")->paginate(10);
        $categories = Category::all();


        $totalRevenue = Order::sum('total_amount'); // Assuming 'total_amount' is the order total column
        $totalOrders = Order::count();
        $newCustomers = User::whereMonth('created_at', Carbon::now()->month)->count();
        $productsInStock = Product::sum('stock_quantity'); // Assuming 'stock_quantity' column
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $topSellingProduct = Product::withCount('orderItems') // Assuming relationship with order items
            ->orderBy('order_items_count', 'desc')
            ->first();

        // Get Recent Orders (Example - get the 5 latest orders)
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.admin', compact("totalRevenue", "totalOrders", "newCustomers", "productsInStock", "averageOrderValue", "topSellingProduct", "recentOrders", "products", "categories"));
    }


    public function products(): View
    {
        $products = Product::with('category')->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function productDetails($productId){
        $product = Product::where('id', $productId)->first();
        return view('admin.product_details', compact('product'));
    }
    
    public function productEdit($productId){
        $product = Product::where('id', $productId)->first();
        $categories = Category::all();

        return view('admin.product_edit', compact('product','categories'));
    }

    public function orders(): View
    {
        $orders = Order::with('user')->latest()->paginate(10);
        $customers = User::where('user_type', 0)->orWhereNull('user_type')->get();
        return view('admin.orders', compact('orders', 'customers')); // Assuming 'orders.blade.php'
    }

    public function orderDetails($orderId){
        $order = Order::where('id', $orderId)->first();
        return view('admin.order_details', compact('order'));
    }

    public function orderEdit($orderId){
        $order = Order::where('id', $orderId)->first();
        return view('admin.order_edit', compact('order'));
    }

    public function orderUpdate(Request $request){
        $request->validate([
            'order_status' => 'required|string|max:255'
        ]);

        $order = Order::where('id', $request->input('id'))->first();
        $order->order_status = $request->input('order_status');
        $order->save();

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    public function orderDelete($orderId){
        $order = Order::where('id', $orderId)->first();
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function customers(): View
    {
        $users = User::where('user_type', '=', 0)
            ->orWhereNull('user_type')
            ->withCount('orders')        // Loads 'orders_count' attribute
            ->latest()                   // Order by latest registration
            ->paginate(8);              // Paginate results

        return view('admin.customers', compact('users')); // Assuming 'customers.blade.php'
    }

    public function customerDetails($userId){
        $customer = User::where('id', $userId)->first();
        return view('admin.customer_details', compact('customer'));
    }

    public function customerEdit($userId){
        $customer = User::where('id', $userId)->first();
        return view('admin.customer_edit', compact('customer'));
    }

    public function customerUpdate(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'is_active' => 'required|numeric|min:0'
        ]);

        $customer = User::where('id', $request->input('id'))->first();
        if(!$customer){
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone');
        // $customer->status = $request->input('is_active');

        if($request->has('password') && $request->has('password_confirmation')){
            if($request->input('password') != $request->input('password_confirmation')){
                return redirect()->back()->with('error', 'Passwords do not match.');
            }
            $customer->password = Hash::make($request->input('password'));  
        } 
        $customer->save();

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }  
    
    
    public function customerDelete($userId){
        $user = User::where('id', $userId)->first();
        $user->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }


    public function categories(): View
    {
        $categories = Category::withCount('products')
            ->latest('id')
            ->paginate(10); // Or however many you want


        return view('admin.categories', compact(
            'categories'
        ));
    }


    public function reports(): View
    {
        $today = Carbon::today();
        $last30Days = Carbon::today()->subDays(30);
        $last90Days = Carbon::today()->subDays(90);

        // 1. Sales Overview Data (Last 30 Days)
        $salesOverview = Order::where('created_at', '>=', $last30Days)
            ->select(
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->first();

        $totalRevenueLast30Days = $salesOverview->total_revenue ?? 0;
        $totalOrdersLast30Days = $salesOverview->total_orders ?? 0;

        // Calculate previous 30 days for comparison
        $previous30DaysStart = Carbon::today()->subDays(60);
        $previous30DaysEnd = Carbon::today()->subDays(30);
        $previousSalesOverview = Order::whereBetween('created_at', [$previous30DaysStart, $previous30DaysEnd])
            ->select(DB::raw('SUM(total_amount) as total_revenue'))
            ->first();
        $previousRevenue = $previousSalesOverview->total_revenue ?? 0;

        $revenueComparisonPercent = ($previousRevenue > 0) ? (($totalRevenueLast30Days - $previousRevenue) / $previousRevenue) * 100 : 0;

        $averageOrderValue = ($totalOrdersLast30Days > 0) ? $totalRevenueLast30Days / $totalOrdersLast30Days : 0;

        // 2. Sales Trend Data (Last 9 Months - monthly revenue)
        $salesTrendData = Order::where('created_at', '>=', Carbon::today()->subMonths(9))
            // ->groupBy(DB::raw('TO_CHAR(created_at, \'YYYY MM\')'))
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->select(
                DB::raw('created_at as month'),
                DB::raw('SUM(total_amount) as monthly_revenue')
            )
            ->get();

        // 3. Top Selling Products (Last 30 Days)
        $topSellingProducts = OrderItem::whereHas('order', function ($query) use ($last30Days) {
            $query->where('created_at', '>=', $last30Days);
        })
            ->join('products', 'orderitems.product_id', '=', 'products.id')
            ->groupBy('product_id')
            ->orderBy(DB::raw('SUM(quantity)'), 'DESC')
            ->take(5) // Get top 5 products
            ->select('product_id', DB::raw('SUM(quantity) as total_sold_quantity'), DB::raw('SUM(products.price * quantity) as total_revenue'))
            ->with('product:id,product_name') // Eager load product name
            ->get();

        // 4. New vs. Returning Customers (Last 30 Days)
        $newVsReturningCustomers = User::where('users.created_at', '>=', $last30Days)
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('orders.user_id')
            ->select(
                DB::raw('SUM(CASE WHEN orders.created_at > ? THEN 1 ELSE 0 END) as returning_customers'),
                DB::raw('SUM(CASE WHEN orders.created_at <= ? THEN 1 ELSE 0 END) as new_customers')
            )
            ->setBindings([
                Carbon::now()->subMonths(1),
                Carbon::now()->subMonths(1),
                null
            ])
            ->first();

        $newCustomersCount = $newVsReturningCustomers->new_customers ?? 0;
        $returningCustomersCount = $newVsReturningCustomers->returning_customers ?? 0;
        $totalCustomers = $newCustomersCount + $returningCustomersCount;
        $newCustomersPercentage = ($totalCustomers > 0) ? ($newCustomersCount / $totalCustomers) * 100 : 0;
        $returningCustomersPercentage = ($totalCustomers > 0) ? ($returningCustomersCount / $totalCustomers) * 100 : 0;


        // 5. Customer Demographics (Example - Top 3 Locations, adjust based on your customer data)
        $customerDemographics = [];


        // 6. Low Stock Products (Example - products with stock less than threshold)
        $lowStockThreshold = 10;
        $lowStockProducts = Product::where('stock_quantity', '<=', $lowStockThreshold)
            ->where('stock_quantity', '>=', 0) // Exclude out of stock products if needed
            ->get();


        return view('admin.reports', compact(
            'totalRevenueLast30Days',
            'totalOrdersLast30Days',
            'revenueComparisonPercent',
            'averageOrderValue',
            'salesTrendData',
            'topSellingProducts',
            'newCustomersPercentage',
            'returningCustomersPercentage',
            'customerDemographics',
            'lowStockThreshold',
            'lowStockProducts'
        ));
    }


    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories', // Example validation rules
        ]);

        $categoryData = [
            'id' => Category::max('id') + 1,
            'category_name' => $validatedData['category_name']
        ];
        Category::create($categoryData);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }


    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id, // Ignore current category in unique rule
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    public function storeProduct(Request $request)
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
            'id' => $products->count() + 1,
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
        return redirect()->back();
    }


    public function deleteProduct(string $productID)
    {
        $product = Product::where("id", "=", $productID)->first();
        if (!$product) {
            return redirect()->back();
        }
        $product->delete();
        return redirect()->back();
    }

    public function updateProduct(Request $request, string $productId)
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
            return redirect()->back();
        }

        $product->product_name = $validatedData['product_name'];
        $product->description = $validatedData['description'];
        $product->price = floatval($validatedData['price']);
        $product->category_id = intval($validatedData['category_id']);
        $product->save();

        if ($request->has('image-upload')) {
            $productImagesData = [
                "product_id" => $product->id,
                "image_url" => $validatedData['image-upload']
            ];
            ProductImage::create($productImagesData);
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        // Update name
        $user->first_name = $validatedData['name'];

        // Update email only if it has actually changed
        if ($user->email !== $validatedData['email']) {
            $user->email = $validatedData['email'];
        }

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the new avatar in 'storage/app/public/avatars' and get the path
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // Redirect back to the profile edit page with a success status message
        return redirect()->route('admin.profile')->with('status', 'profile-updated');
    }

    public function pass_update(Request $request)
    {
        $user = $request->user();

        // Validate using a specific error bag ('updatePassword') to match the form's error display
        $validated = $request->validateWithBag('updatePassword', [
            // 'current_password' rule checks against the authenticated user's current password hash
            'current_password' => ['required', 'string', 'current_password'],
            // 'password' uses default rules (length, etc.) and ensures 'password_confirmation' matches
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        // Update the user's password with the new hashed password
        $user->password = Hash::make($validated['password']);
        $user->save();

        Auth::logoutOtherDevices($validated['current_password']); // Requires password confirmation
        return redirect()->route('admin.profile')->with('status', 'password-updated');
    }

}