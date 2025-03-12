@extends('layouts.admin.admin_dashboard')
@section('content')
    <div class="container mx-auto p-4 md:p-8 lg:p-10">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                Reports & Analytics
            </h1>
        </header>

        <!-- Sales Overview Section -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
                Sales Overview
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                    <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Revenue (Last 30 Days)</dt>
                    <dd class="text-2xl font-bold text-green-600 dark:text-green-400">
                        ₦{{ number_format($totalRevenueLast30Days, 2) }}</dd>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Compared to previous 30 days:
                        {{ number_format($revenueComparisonPercent, 2) }}%</p>
                </div>
                <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                    <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Orders (Last 30 Days)</dt>
                    <dd class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ number_format($totalOrdersLast30Days) }}</dd>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Compared to previous 30 days: N/A% (Order comparison
                        not implemented)</p> {{-- Order comparison not implemented in controller yet --}}
                </div>
                <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                    <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Average Order Value (AOV)</dt>
                    <dd class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                        ₦{{ number_format($averageOrderValue, 2) }}</dd>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Trend: <span
                            class="text-green-500 dark:text-green-400"><i class="fas fa-arrow-up mr-1"></i> N/A (Trend
                            analysis not implemented)</span></p> {{-- Trend analysis not implemented --}}
                </div>
            </div>
            <div id="salesTrendChart" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Sales Trend (Last 9 Months)</h3>
                <p class="text-gray-600 dark:text-gray-400">Sales trend chart will be displayed here. (Placeholder for
                    Chart)</p>
                {{-- Sales Trend Chart (e.g., using Chart.js, ApexCharts) would go here --}}
                {{-- Example to pass data to JS chart (you'd need to set up your charting library): --}}
                {{--
                <canvas id="mySalesChart" width="400" height="150"></canvas>
                <script>
                    var salesData = @json($salesTrendData); // Pass PHP data to JavaScript
                    // ... Chart.js or ApexCharts code to render chart using salesData ...
                </script>
                --}}
            </div>
        </section>

        <!-- Product Performance Section -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
                Product Performance
            </h2>
            <div id="topSellingProducts" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Top Selling Products (Last 30 Days)
                </h3>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Product Name
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Sales Count
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Revenue
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSellingProducts as $productPerformance)
                            <tr>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ $productPerformance->product->product_name }}</td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ number_format($productPerformance->total_sold_quantity) }}</td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    ₦{{ number_format($productPerformance->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 text-center">
                                    No top selling products in the last 30 days.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Customer Insights Section -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
                Customer Insights
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div id="newVsReturningCustomers" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">New vs. Returning Customers
                        (Last 30 Days)</h3>
                    <p class="text-gray-600 dark:text-gray-400">Chart or data visualization for new vs. returning customers.
                        (Placeholder)</p>
                    {{-- Chart or Data Visualization for New vs. Returning Customers --}}
                    <div class="mt-4">
                        <p class="text-center">
                            <span
                                class="font-bold text-blue-500 dark:text-blue-400">{{ number_format($newCustomersPercentage, 1) }}%
                                New Customers</span> |
                            <span
                                class="font-bold text-green-500 dark:text-green-400">{{ number_format($returningCustomersPercentage, 1) }}%
                                Returning Customers</span>
                        </p>
                    </div>
                </div>
                <div id="customerDemographics" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Customer Demographics (Example -
                        Location)</h3>
                    <p class="text-gray-600 dark:text-gray-400">Table or chart showing customer demographics. (Placeholder)
                    </p>
                    {{-- Customer Demographics Chart or Table --}}
                    <ul class="mt-4 list-disc list-inside text-gray-700 dark:text-gray-300">
                        @forelse($customerDemographics as $demo)
                            <li>{{ $demo->customer_state }}: {{ number_format($demo->customer_count) }} Customers
                                ({{ number_format(($demo->customer_count / $totalCustomers) * 100, 1) }}%)</li>
                        @empty
                            <li>No customer demographic data available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>

        <!-- Inventory/Stock Reports (Example - you can add more sections) -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">
                Inventory Reports
            </h2>
            <div id="lowStockProducts" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Products with Low Stock</h3>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Product Name
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Current Stock
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Threshold
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                            <tr>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ $product->product_name }}</td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-red-600 dark:text-red-400">
                                    {{ number_format($product->stock_quantity) }}</td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ number_format($product->low_stock_threshold) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 text-center">
                                    No products with low stock currently.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Add more report sections as needed (e.g., Marketing Reports, etc.) --}}

    </div>
@endsection