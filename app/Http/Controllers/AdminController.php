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
        $products = Product::paginate(10);
        $categories = Category::all();
        $totalRevenue = Order::sum('total_amount');
        $totalOrders = Order::count();
        $newCustomers = User::whereMonth('created_at', Carbon::now()->month)->count();
        $productsInStock = Product::sum('stock_quantity');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $topSellingProduct = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->first();

        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.admin', compact("totalRevenue", "totalOrders", "newCustomers", "productsInStock", "averageOrderValue", "topSellingProduct", "recentOrders", "products", "categories"));
    }


    public function products(Request $request): View
    {
              // Start base query, eager load category to avoid N+1 issues
              $query = Product::with('category')->latest(); // Order by newest first, for example

              // Filter by Category
              if ($request->filled('category')) { // Check if 'category' exists and is not empty
                  $query->where('category_id', $request->input('category'));
              }
      
              // Filter by Search Term
              if ($request->filled('search')) { // Check if 'search' exists and is not empty
                  $searchTerm = $request->input('search');
                  $query->where(function ($q) use ($searchTerm) {
                      $q->where('product_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%"); // Optional: search description too
                      // Add other searchable fields if needed
                      // ->orWhere('sku', 'LIKE', "%{$searchTerm}%");
                  });
              }
      
              // Paginate the results
              // Make sure to use a reasonable number per page
              $products = $query->paginate(10); // Get paginated results 
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function productDetails($productId)
    {
        $product = Product::where('id', $productId)->first();
        return view('admin.product_details', compact('product'));
    }

    public function productEdit($productId)
    {
        $product = Product::where('id', $productId)->first();
        $categories = Category::all();

        return view('admin.product_edit', compact('product', 'categories'));
    }

    public function orders(): View
    {
        $orders = Order::latest()->paginate(10);
        $customers = User::where('user_type', 0)->orWhereNull('user_type')->get();
        return view('admin.orders', compact('orders', 'customers'));
    }

    public function orderDetails($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        return view('admin.order_details', compact('order'));
    }

    public function orderEdit($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        return view('admin.order_edit', compact('order'));
    }

    public function orderUpdate(Request $request)
    {
        $request->validate([
            'order_status' => 'required|string|max:255'
        ]);

        $order = Order::where('id', $request->input('id'))->first();
        $order->order_status = $request->input('order_status');
        $order->save();

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    public function orderDelete($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function customers(Request $request): View
    {
        $search = $request->input('search');
        $users = null;

        if ($search == null || $search == '') {
            $users = User::where(function ($query) {
                $query->where('user_type', 0)
                    ->orWhereNull('user_type');
            })
                ->withCount('orders')
                ->latest()
                ->paginate(8);
        } else {
            $users = User::where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            })
                ->where(function ($query) {
                    $query->where('user_type', 0)
                        ->orWhereNull('user_type');
                })
                ->withCount('orders')
                ->latest()
                ->paginate(8);
            ;
        }

        return view('admin.customers', compact('users'));
    }

    public function customerDetails($userId)
    {
        $customer = User::where('id', $userId)->first();
        return view('admin.customer_details', compact('customer'));
    }

    public function customerEdit($userId)
    {
        $customer = User::where('id', $userId)->first();
        return view('admin.customer_edit', compact('customer'));
    }

    public function customerUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'is_active' => 'required|numeric|min:0'
        ]);

        $customer = User::where('id', $request->input('id'))->first();
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone');


        if ($request->has('password') && $request->has('password_confirmation')) {
            if ($request->input('password') != $request->input('password_confirmation')) {
                return redirect()->back()->with('error', 'Passwords do not match.');
            }
            $customer->password = Hash::make($request->input('password'));
        }
        $customer->save();

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }


    public function customerDelete($userId)
    {
        $user = User::where('id', $userId)->first();
        $user->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }


    public function categories(): View
    {
        $categories = Category::withCount('products')
            ->latest('id')
            ->paginate(10);


        return view('admin.categories', compact(
            'categories'
        ));
    }


    public function reports(): View
    {
        $today = Carbon::today();
        $last30Days = Carbon::today()->subDays(30);
        $last90Days = Carbon::today()->subDays(90);


        $salesOverview = Order::where('created_at', '>=', $last30Days)
            ->select(
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->first();

        $totalRevenueLast30Days = $salesOverview->total_revenue ?? 0;
        $totalOrdersLast30Days = $salesOverview->total_orders ?? 0;


        $previous30DaysStart = Carbon::today()->subDays(60);
        $previous30DaysEnd = Carbon::today()->subDays(30);
        $previousSalesOverview = Order::whereBetween('created_at', [$previous30DaysStart, $previous30DaysEnd])
            ->select(DB::raw('SUM(total_amount) as total_revenue'))
            ->first();
        $previousRevenue = $previousSalesOverview->total_revenue ?? 0;

        $revenueComparisonPercent = ($previousRevenue > 0) ? (($totalRevenueLast30Days - $previousRevenue) / $previousRevenue) * 100 : 0;

        $averageOrderValue = ($totalOrdersLast30Days > 0) ? $totalRevenueLast30Days / $totalOrdersLast30Days : 0;


        $salesTrendData = Order::where('created_at', '>=', Carbon::today()->subMonths(9))

            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->select(
                DB::raw('created_at as month'),
                DB::raw('SUM(total_amount) as monthly_revenue')
            )
            ->get();


        $topSellingProducts = OrderItem::whereHas('order', function ($query) use ($last30Days) {
            $query->where('created_at', '>=', $last30Days);
        })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('product_id')
            ->orderBy(DB::raw('SUM(quantity)'), 'DESC')
            ->take(5)
            ->select('product_id', DB::raw('SUM(quantity) as total_sold_quantity'), DB::raw('SUM(products.price * quantity) as total_revenue'))
            ->with('product:id,product_name')
            ->get();


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



        $customerDemographics = [];



        $lowStockThreshold = 10;
        $lowStockProducts = Product::where('stock_quantity', '<=', $lowStockThreshold)
            ->where('stock_quantity', '>=', 0)
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
            'category_name' => 'required|string|max:255|unique:categories',
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
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
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
            'product_name' => 'required|string|unique:products,product_name',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'nullable|string',
            'category_id' => 'required|integer',
            'product_images' => 'nullable|array',
            'product_images.*' => 'file|mimes:jpeg,png,jpg|max:2048'
        ], [
            'product_images.*.max' => 'Your product images must not exceed 2MB in size.',
            'product_images.*.file' => 'Each item in the images must be a file.',
            'product_images.*.mimes' => 'Each image must be a JPEG, PNG, or JPG file.'
        ]);

       
        $products = Product::all();
        $productData = [
            'id' => $products->max('id') + 1,
            'product_name' => $validatedData['product_name'],
            'description' => $validatedData['description'],
            'brand_id' => 1,
            'category_id' => intval($validatedData['category_id']),
            'price' => floatval($validatedData['price']),
            'stock_quantity' => 0,
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString(),
        ];

        if($request->has("status")){
            $productData['status'] = $validatedData["status"];
        }


        $productImages = [];
        $i=0;
        foreach($validatedData['product_images'] as $image){
            $filename = "product_image_$i." . $image->getClientOriginalExtension();
            $productImages[] = [
                'product_id' => $productData['id'],
                'image_url' => $image->storeAs('uploads', $filename, 'public')
            ];
            $i++;
        }

        Product::create($productData);
        ProductImage::insert($productImages);
        return redirect()->back()->with('success', 'Product created successfully.');
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
            'status' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg|max:2048'
        ]);


        $product = Product::where("id", "=", $productId)->first();

        if (!$product) {
            return redirect()->back();
        }

        $product->product_name = $validatedData['product_name'];
        $product->description = $validatedData['description'];
        $product->price = floatval($validatedData['price']);
        $product->category_id = intval($validatedData['category_id']);
        $product->status = $validatedData['status'];
        $product->save();
      
        if($request->has('delete_images')){
            $del_array = json_decode($request->delete_images);
            ProductImage::where('product_id', $productId)
                ->whereIn('id', $del_array)
                ->delete();
        }

        if ($request->has('images')) {
            $productImages = [];
            $i=0;
            foreach($validatedData['images'] as $image){
                $filename = "product_image_$i." . $image->getClientOriginalExtension();
                $productImages[] = [
                    'product_id' => $productId,
                    'image_url' => $image->storeAs('uploads', $filename, 'public')
                ];
                $i++;
            }
            ProductImage::insert($productImages);
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

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);


        $user->first_name = $validatedData['name'];


        if ($user->email !== $validatedData['email']) {
            $user->email = $validatedData['email'];
        }


        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }


            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();


        return redirect()->route('admin.profile')->with('status', 'profile-updated');
    }

    public function pass_update(Request $request)
    {
        $user = $request->user();


        $validated = $request->validateWithBag('updatePassword', [

            'current_password' => ['required', 'string', 'current_password'],

            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);


        $user->password = Hash::make($validated['password']);
        $user->save();

        Auth::logoutOtherDevices($validated['current_password']);
        return redirect()->route('admin.profile')->with('status', 'password-updated');
    }

}