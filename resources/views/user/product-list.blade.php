@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Products')

@section('content')
<main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-green-900 dark:text-white mb-2">All Products</h1>
        <p class="text-green-700 dark:text-gray-300">Browse our wide range of skincare products.</p>
    </header>

    <section id="productFilter" class="mb-8 flex items-center space-x-4">
        <label for="categoryFilter" class="text-green-800 dark:text-gray-300 font-semibold text-lg">Filter by Category:</label>
        <div class="relative">
            <select id="categoryFilter"
                class="block appearance-none w-full bg-white dark:bg-green-950 border border-green-300 dark:border-green-600 text-green-700 dark:text-white py-2 px-3 pr-8 rounded-2xl leading-tight focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_name }}" {{ $category->category_name == $currentCategory ? "selected" : "" }}>{{ strtoupper(substr($category->category_name, 0, 1)) . substr($category->category_name, 1) }}</option>
                @endforeach
            </select>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-green-700 dark:text-gray-300">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </section>

    <section id="productList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-gray-100 dark:bg-green-950 rounded-lg shadow-md overflow-hidden">
                    <a href="/product/{{ $product->id }}">
                        <img class="w-full h-48 object-cover" src="{{  asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                            alt="{{ $product->product_name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-green-800 dark:text-green-50">{{ $product->product_name }}</h3>
                            <p class="text-green-700 dark:text-green-300">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
        @endforeach
    </section>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryFilterDropdown = document.getElementById('categoryFilter');

        categoryFilterDropdown.addEventListener('change', function () {
            const selectedCategory = this.value;
            if (selectedCategory == "") {
                location.href = "/products";
            } else {
                location.href = "/products?category=" + selectedCategory;
            }
        });
    });
</script>
@endsection