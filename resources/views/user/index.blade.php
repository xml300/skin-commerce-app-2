
@extends('layouts.user.user_dashboard')
@section('title', 'Homepage')

@section("content")
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <section class="mb-16">
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">Featured Products</h2>
        <div id="featuredProducts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            @forelse ($featuredProducts as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col"> 
                    <a href="/product/{{ Crypt::encrypt($product->id) }}" class="block flex flex-col flex-grow"> 
                        <div class="aspect-w-4 aspect-h-3">
                            <img class="w-full h-48 object-cover rounded-t-xl" src="{{ $product->productImages->count() > 0 ? asset('storage/'.$product->productImages->get(0)->image_url) : asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                        <div class="p-4 flex flex-col flex-grow"> 
                            <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2 flex-grow">{{ $product->product_name }}</h3> 
                            <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium mt-auto">₦{{ number_format($product->price, 2) }}</p> 
                        </div>
                    </a>
                </div>
            @empty
                
                <div class="col-span-full text-center py-12"> 
                    <h3 class="mt-2 text-xl font-medium text-muted-sage-green dark:text-muted-sage-green-darker">
                        No Featured Products Yet
                    </h3>
                    <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                        Check back soon to see our highlighted items!
                    </p>
                    
                
                </div>
            @endforelse
        </div>
    </section>
 

    
    <section class="mb-16">
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">Shop by Category</h2>
        <div class="flex max-w-full gap-4 overflow-x-auto pb-4 custom-scrollbar">
            
            @forelse ($categories as $category)
                <div class="min-w-[120px] flex-shrink-0"> 
                    <a href="/products?category={{ $category->category_name }}" class="block bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold rounded-lg shadow-md text-center p-4 transition-colors duration-200 h-full flex items-center justify-center"> 
                        <p class="text-warm-black dark:text-warm-white font-medium">{{ ucfirst($category->category_name) }}</p>
                    </a>
                </div>
            @empty
                 
                <div class="text-center py-4 w-full">
                    <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                        No product categories available right now.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    
    <section class="mb-16"> 
        <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">New Arrivals</h2>
        <div id="newArrivals" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
             
            @forelse ($newProducts as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col"> 
                    <a href="/product/{{ Crypt::encrypt($product->id) }}" class="block flex flex-col flex-grow"> 
                        <div class="aspect-w-4 aspect-h-3">
                            <img class="w-full h-48 object-cover rounded-t-xl" src="{{ $product->productImages->count() > 0 ? asset('storage/'.$product->productImages->get(0)->image_url) : asset( 'images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                        <div class="p-4 flex flex-col flex-grow"> 
                            <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2 flex-grow">{{ $product->product_name }}</h3> 
                            <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium mt-auto">₦{{ number_format($product->price, 2) }}</p> 
                        </div>
                    </a>
                </div>
            @empty
                
                <div class="col-span-full text-center py-12"> 
                     <h3 class="mt-2 text-xl font-medium text-muted-sage-green dark:text-muted-sage-green-darker">
                        No New Arrivals Currently
                    </h3>
                    <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                        We're always adding new items, please check back later!
                    </p>
                </div>
            @endforelse
        </div>
    </section>
 

</main>
@endsection