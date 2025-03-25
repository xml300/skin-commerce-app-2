@extends('layouts.user.user_dashboard')
@section('title', 'homepage')

@section("content")
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-16">
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">Featured Products {{ Auth::user()->user_type }}</h2>
        <div id="featuredProducts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
                    <a href="/product/{{ Crypt::encrypt($product->id) }}" class="block">
                        <div class="aspect-w-4 aspect-h-3">
                            <img class="w-full h-48 object-cover rounded-t-xl" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2">{{ $product->product_name }}</h3>
                            <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-16">
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">Shop by Category</h2>
        <div class="flex max-w-full gap-4 overflow-x-auto pb-4 custom-scrollbar">
            @foreach ($categories as $category)
                <div class="min-w-[120px]">
                    <a href="/products?category={{ $category->category_name }}" class="block bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold rounded-lg shadow-md text-center p-4 transition-colors duration-200">
                        <p class="text-warm-black dark:text-warm-white font-medium">{{ ucfirst($category->category_name) }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">New Arrivals</h2>
        <div id="newArrivals" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
                    <a href="/product/{{ Crypt::encrypt($product->id) }}" class="block">
                        <div class="aspect-w-4 aspect-h-3">
                            <img class="w-full h-48 object-cover rounded-t-xl" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2">{{ $product->product_name }}</h3>
                            <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium">₦{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection