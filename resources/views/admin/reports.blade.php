@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Reports & Analytics
        </h1>
        {{-- Optional: Date Range Selector / Export Button Placeholder --}}
        {{-- ... (Date/Export buttons as before) ... --}}
    </div>

    {{-- Sales Overview Section --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
            Sales Overview
        </h2>
        {{-- Key Metric Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
            {{-- Total Revenue Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 flex items-start space-x-4">
                {{-- ... (Card content as before) ... --}}
                 <div class="flex-shrink-0 bg-green-100 dark:bg-green-800/50 p-3 rounded-full">
                    <i class="fas fa-dollar-sign fa-lg text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Revenue (30d)</dt>
                    <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        ₦{{ number_format($totalRevenueLast30Days ?? 0, 2) }}
                    </dd>
                    @php
                        $revComparisonPercent = $revenueComparisonPercent ?? 0;
                        $revColor = $revComparisonPercent >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                        $revIcon = $revComparisonPercent >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                    @endphp
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span class="{{ $revColor }} font-medium">
                            <i class="fas {{ $revIcon }} mr-1"></i> {{ number_format(abs($revComparisonPercent), 1) }}%
                        </span>
                        vs prev 30d
                    </p>
                </div>
            </div>

            {{-- Total Orders Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 flex items-start space-x-4">
                {{-- ... (Card content as before) ... --}}
                 <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-800/50 p-3 rounded-full">
                    <i class="fas fa-shopping-cart fa-lg text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders (30d)</dt>
                    <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format($totalOrdersLast30Days ?? 0) }}
                    </dd>
                     <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                         <span class="text-gray-500 font-medium">N/A%</span> vs prev 30d
                    </p>
                </div>
            </div>

            {{-- Average Order Value Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 flex items-start space-x-4">
                {{-- ... (Card content as before) ... --}}
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-800/50 p-3 rounded-full">
                    <i class="fas fa-receipt fa-lg text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Avg. Order Value</dt>
                    <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                        ₦{{ number_format($averageOrderValue ?? 0, 2) }}
                    </dd>
                     <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                         <span class="text-gray-500 font-medium"><i class="fas fa-minus mr-1"></i> Trend N/A</span>
                    </p>
                </div>
            </div>
        </div>

       
    </section>

    {{-- Product Performance Section --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
            Product Performance
        </h2>
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
             {{-- ... (Table as before) ... --}}
             <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Selling Products (Last 30 Days)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3 text-center">Units Sold</th>
                            <th scope="col" class="px-6 py-3 text-right">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSellingProducts ?? [] as $productPerformance)
                            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $productPerformance->product->product_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ number_format($productPerformance->total_sold_quantity) }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    ₦{{ number_format($productPerformance->total_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-6 py-10 border-t border-gray-200 dark:border-gray-700">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                        <p>No top selling products data available.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>



    {{-- Inventory Reports Section --}}
    <section class="mb-8">
        {{-- ... (Low Stock Table as before) ... --}}
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
            Inventory Watchlist
        </h2>
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
             <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Low Stock Products</h3>
             </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                   <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3 text-center">Current Stock</th>
                            <th scope="col" class="px-6 py-3 text-center">Threshold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts ?? [] as $product)
                             <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $product->product_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-red-600 dark:text-red-400">
                                    {{ number_format($product->stock_quantity) }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ number_format($product->low_stock_threshold ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                               <td colspan="3" class="text-center px-6 py-10 border-t border-gray-200 dark:border-gray-700">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-check-circle fa-2x mb-2 text-green-500"></i>
                                        <p>No products currently below stock threshold.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection