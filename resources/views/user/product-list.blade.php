{{-- resources/views/user/products/index.blade.php --}}
@extends('layouts.user.user_dashboard')
@section('title', 'Products')

@section('content')
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[75vh]">
    <header class="mb-16">
        <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">All Products</h1>
        <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker">Explore our curated collection of skincare essentials.</p>
    </header>

    <section id="productFilter" class="mb-10">
        <h2 class="text-lg font-medium text-warm-black dark:text-warm-white mb-4">Filter by Category</h2>
        <div class="flex max-w-full gap-3 overflow-x-auto pb-2 custom-scrollbar">
            <a href="/products"
               class="category-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                      bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold
                      text-warm-black dark:text-warm-white hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ $currentCategory == null ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : '' }}"
                      data-category="">
                All Categories
            </a>
            @foreach ($categories as $category)
                <a href="/products?category={{ $category->category_name }}"
                   class="category-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                          bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold
                          text-warm-black dark:text-warm-white hover:text-warm-black dark:hover:text-warm-white
                          transition-colors duration-200 shadow-md hover:shadow-lg
                          {{ $category->category_name == $currentCategory ? 'bg-muted-sage-green-darker! dark:bg-antique-gold! text-warm-white! dark:text-warm-black! font-semibold' : '' }}"
                   data-category="{{ $category->category_name }}">
                    {{ ucfirst($category->category_name) }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Use @forelse to handle empty product list --}}
    <section id="productList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col"> {{-- Added flex flex-col --}}
            <a href="/product/{{ Crypt::encrypt($product->id) }}" class="block flex flex-col flex-grow"> {{-- Added flex flex-col flex-grow --}}
                <div class="aspect-w-4 aspect-h-3">
                    <img class="w-full h-48 object-cover rounded-t-xl" src="{{$product->productImages->count() > 0  ? asset('storage/'.$product->productImages->get(0)->image_url) : asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                        alt="{{ $product->product_name }}">
                </div>
                <div class="p-4 flex flex-col flex-grow"> {{-- Added flex flex-col flex-grow --}}
                    <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2 flex-grow">{{ $product->product_name }}</h3> {{-- Added flex-grow --}}
                    <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium mt-auto">₦{{ number_format($product->price, 2) }}</p> {{-- Added mt-auto --}}
                </div>
            </a>
        </div>
        @empty
            {{-- This content will be shown if $products is empty --}}
            <div class="col-span-full text-center py-16"> {{-- Span all columns --}}
                {{-- Optional: Add an icon here e.g., using FontAwesome or Heroicons --}}
                {{-- <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> ... </svg> --}}
                <h3 class="mt-2 text-xl font-medium text-muted-sage-green dark:text-muted-sage-green-darker">
                    No Products Found
                </h3>
                <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                    @if($currentCategory)
                        There are currently no products available in the '{{ ucfirst($currentCategory) }}' category.
                    @else
                        There are currently no products available. Please check back later.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="/products"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-warm-white bg-muted-sage-green-darker hover:bg-muted-sage-green dark:bg-antique-gold dark:hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-muted-sage-green">
                        {{-- Optional Icon --}}
                        {{-- <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" /> </svg> --}}
                        View All Products
                    </a>
                </div>
            </div>
        @endforelse
    </section>

    {{-- Only show pagination if there are products to paginate --}}
    @if ($products->hasPages())
    <section class="py-8"> {{-- Increased padding --}}
            {{ $products->links() }}
        </section>
    @endif

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryFilterButtons = document.querySelectorAll('.category-filter-button');

        categoryFilterButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedCategory = this.dataset.category;
                let url = "/products";
                if (selectedCategory) {
                    url += "?category=" + selectedCategory;
                }
                window.location.href = url;
            });
        });
    });
</script>
@endsection