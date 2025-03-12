<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(): View
    {
        $products = Product::join("categories", "products.category_id", "=", "categories.id")->get();
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
        // You would typically fetch products data here to pass to the view
        // Example: $products = Product::all();

        return view('admin.products');
    }

    public function orders(): View
    {
        // Fetch orders data if needed
        $orders = Order::with('user')
        ->orderBy('orders.id')
        ->get();

        return view('admin.orders', compact('orders')); // Assuming 'orders.blade.php'
    }

    public function customers(): View
    {
        // Fetch customers data
        // Example: $customers = Customer::paginate(30);

        return view('admin.customers'); // Assuming 'customers.blade.php'
    }



    public function categories(): View
    {
        $categories = Category::all(); // Fetch all categories from the database

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
            ->where('stock_quantity', '>', 0) // Exclude out of stock products if needed
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
            'lowStockProducts'
        ));
    }


    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories', // Example validation rules
        ]);

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }


    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id, // Ignore current category in unique rule
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

}