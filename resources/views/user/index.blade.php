@include('layouts.user.header', ['title' => 'Skincare Shop - homepage'])

<main class="container mx-auto p-4 md:p-8 lg:p-10">
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-4">Featured Products</h2>
        <div id="featuredProducts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-gray-100 dark:bg-green-950 rounded-lg shadow-md overflow-hidden">
                    <a href="/product/{{ $product->id }}">
                        <img class="w-full h-48 object-cover" src="{{ $product->product_images }}"
                            alt="{{ $product->product_name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-green-800 dark:text-green-50">{{ $product->product_name }}</h3>
                            <p class="text-green-700 dark:text-green-300">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-4">Shop by Category</h2>
        <div class="flex max-w-screen gap-4 justify-between overflow-x-scroll custom-scrollbar">
            @foreach ($categories as $category)
                <div class="flex-1 p-4 bg-green-200 hover:bg-green-400 dark:bg-green-950 dark:hover:bg-green-800 rounded-lg shadow-md text-center">
                    <a href="/products?category={{ $category->category_name }}" class="block text-green-800 dark:text-green-50">{{ strtoupper(substr($category->category_name, 0, 1)) . substr($category->category_name, 1) }}</a>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-4">New Arrivals</h2>
        <div id="newArrivals" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-gray-100 dark:bg-green-950 rounded-lg shadow-md overflow-hidden">
                    <a href="/product/{{ $product->id }}">
                        <img class="w-full h-48 object-cover" src="{{ $product->product_images }}"
                            alt="{{ $product->product_name }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-green-800 dark:text-green-50">{{ $product->product_name }}</h3>
                            <p class="text-green-700 dark:text-green-300">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</main>
@include('layouts.user.footer')