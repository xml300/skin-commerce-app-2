@php
    $searchQuery = request('q'); 
    $searchResults = [ 
        [
            'id' => 1,
            'image' => asset('images/product-placeholder.jpg'), 
            'title' => 'Hydrating Cleanser',
            'description' => 'A gentle cleanser that hydrates and cleanses...',
            'price' => '$25.00',
            'category' => 'Cleansers',
        ],
        [
            'id' => 2,
            'image' => asset('images/product-placeholder.jpg'), 
            'title' => 'Vitamin C Serum',
            'description' => 'Brighten your skin with our potent Vitamin C serum...',
            'price' => '$45.00',
            'category' => 'Serums',
        ],
        [
            'id' => 3,
            'image' => asset('images/product-placeholder.jpg'), 
            'title' => 'Daily Moisturizer',
            'description' => 'A lightweight moisturizer for daily hydration...',
            'price' => '$30.00',
            'category' => 'Moisturizers',
        ],
        
    ];
@endphp

@extends('layouts.user.user_dashboard') 

@section('title', 'Search Results for "' . $searchQuery . '"')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <section class="mb-8">
            <h1 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-4">Search Results for "<span
                    class="font-bold text-muted-sage-green dark:text-antique-gold">{{ $searchQuery }}</span>"</h1>
            <form action="/search" method="GET" role="search" class="mb-4">
                <label for="search-input" class="sr-only">Search products or content</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-warm-black dark:text-warm-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="search-input" name="q" value="{{ $searchQuery }}"
                        class="block w-full p-4 pl-10 text-sm text-warm-black dark:text-warm-white bg-warm-white dark:bg-warm-black border border-soft-sand-beige dark:border-muted-sage-green rounded-md focus:ring-muted-sage-green dark:focus:ring-antique-gold focus:border-muted-sage-green dark:focus:border-antique-gold"
                        placeholder="Refine your search..." aria-label="Refine your search...">
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-muted-sage-green dark:bg-antique-gold hover:bg-muted-sage-green-darker dark:hover:opacity-90 focus:ring-4 focus:outline-none focus:ring-muted-sage-green dark:focus:ring-antique-gold font-medium rounded-md text-sm px-4 py-2">Search</button>
                </div>
            </form>
        </section>

        <section>
            @if(count($products) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div key="{{ $product->id }}" class="bg-warm-white dark:bg-warm-black rounded-lg shadow-md overflow-hidden">
                            <a href="/product/{{ Crypt::encrypt($product->id) }}"
                                aria-label="View product details for {{ $product->product_name }}">
                                <img class="w-full h-48 object-cover object-center"
                                    src="{{ $product->productImages->count() > 0 ? asset('storage/'.$product->productImages->get(0)->image_url) : asset('images/' . 'demo' . ($product->id % 4 + 1) . '.jpg') }}"
                                    alt="{{ $product->product_name }}" title="{{ $product->product_name }}" loading="lazy">
                            </a>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-warm-black dark:text-warm-white mb-2">
                                    <a href="/product/{{ Crypt::encrypt($product->id) }}"
                                        class="hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200">
                                        {{ $product->product_name }}
                                    </a>
                                </h3>
                                <p class="text-warm-black dark:text-warm-white text-sm mb-3">
                                    {{ Str::limit($product->description, 50) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-muted-sage-green dark:text-antique-gold font-bold">₦{{ number_format($product->price, 2) }}</span>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                                        @if(Auth::user()->cart->where('product_id', $product->id)->count() == 0)
                                        <input type="number" name="quantity" value="1" hidden>
                                        @endif

                                        
                                        @if(Auth::user()->cart->where('product_id', $product->id)->count() > 0)
                                        <div
                                            class="flex items-center rounded-md border border-gray-300 dark:border-gray-700 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                                            <button type="button"
                                                class="px-3 py-2 rounded-l-md focus:outline-none hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                                                onclick="decrementValue(this)">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <input type="number" name="quantity" id="quantityInput" value="{{ Auth::user()->cart->where('product_id', $product->id)->first()->quantity }}" min="1"
                                                class="appearance-none w-16 text-center py-2 border-x border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-0 focus:shadow-none dark:bg-gray-900 dark:text-white"
                                                readonly 
                                                aria-label="quantity" />

                                            <button type="button"
                                                class="px-3 py-2 rounded-r-md focus:outline-none hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                                                onclick="incrementValue(this)">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        @endif

                                        <button type="submit" onclick="localStorage.removeItem('cartCount')"
                                            class="bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white hover:bg-muted-sage-green dark:hover:text-warm-black dark:hover:bg-antique-gold font-semibold py-2 px-3 rounded-md transition-colors duration-200"
                                            aria-label="Add {{ $product->product_name }} to cart">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                
                <div class="flex justify-center mt-8">
                    <button
                        class="bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white hover:bg-muted-sage-green dark:hover:text-antique-gold font-semibold py-2 px-4 rounded-md mr-2"
                        disabled>
                        Previous
                    </button>
                    <button
                        class="bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white hover:bg-muted-sage-green dark:hover:text-antique-gold font-semibold py-2 px-4 rounded-md">
                        Next
                    </button>
                </div>

            @else
                <div class="text-center py-10">
                    <i class="fa-solid fa-search-minus text-4xl text-soft-sand-beige dark:text-muted-sage-green mb-4"></i>
                    <p class="text-warm-black dark:text-warm-white text-lg font-semibold mb-2">No products found for "<span
                            class="font-bold text-muted-sage-green dark:text-antique-gold">{{ $searchQuery }}</span>"</p>
                    <p class="text-warm-black dark:text-warm-white text-md">Please try a different search term or browse our
                        products.</p>
                    <a href="/products"
                        class="inline-block mt-4 px-4 py-2 bg-muted-sage-green dark:bg-antique-gold text-warm-white dark:text-warm-black rounded-md hover:bg-muted-sage-green-darker dark:hover:opacity-90 transition-colors duration-200">
                        Browse Products
                    </a>
                </div>
            @endif
        </section>
    </div>
    <script>
        function incrementValue(button) {
            const input = button.parentNode.querySelector('input[type=number]');
            let value = parseInt(input.value, 10);
            value = isNaN(value) ? 1 : value;
            value++;
            input.value = value;
            
            
        }

        function decrementValue(button) {
            const input = button.parentNode.querySelector('input[type=number]');
            let value = parseInt(input.value, 10);
            value = isNaN(value) ? 1 : value;
            if (value > parseInt(input.min)) {
                value--;
                input.value = value;
                
                
            }
        }
    </script>
@endsection