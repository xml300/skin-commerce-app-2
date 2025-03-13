@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Products')

@section('content')
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[75vh]">
    <header class="mb-16">
        <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">All Products</h1>
        <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker">Explore our curated collection of skincare essentials.</p>
    </header>

    <section id="productFilter" class="mb-10">
        <h2 class="text-lg font-medium text-warm-black dark:text-warm-white mb-4">Filter by Category</h2>
        <div class="flex max-w-full gap-3 overflow-x-auto pb-2 custom-scrollbar"> {{-- Horizontal scrollable container for categories --}}
            <a href="/products"
               class="category-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                      bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold
                      text-warm-black dark:text-warm-white hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ $currentCategory == null ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : '' }}"
                      data-category=""> {{-- "All Categories" button --}}
                All Categories
            </a>
            @foreach ($categories as $category)
                <a href="/products?category={{ $category->category_name }}"
                   class="category-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                          bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold
                          text-warm-black dark:text-warm-white hover:text-warm-black dark:hover:text-warm-white
                          transition-colors duration-200 shadow-md hover:shadow-lg
                          {{ $category->category_name == $currentCategory ? 'bg-muted-sage-green-darker! dark:bg-antique-gold! text-warm-white! dark:text-warm-black! font-semibold' : '' }}"
                   data-category="{{ $category->category_name }}"> {{-- Category buttons --}}
                    {{ ucfirst($category->category_name) }}
                </a>
            @endforeach
        </div>
    </section>

    <section id="productList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
            <a href="/product/{{ $product->id }}" class="block">
                <div class="aspect-w-4 aspect-h-3">
                    <img class="w-full h-48 object-cover rounded-t-xl" src="{{  asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                        alt="{{ $product->product_name }}">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-2">{{ $product->product_name }}</h3>
                    <p class="text-muted-sage-green dark:text-muted-sage-green-darker font-medium">₦{{ number_format($product->price, 2) }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryFilterButtons = document.querySelectorAll('.category-filter-button');

        categoryFilterButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default link behavior
                const selectedCategory = this.dataset.category;
                let url = "/products";
                if (selectedCategory) {
                    url += "?category=" + selectedCategory;
                }
                window.location.href = url; // Navigate to the filtered URL
            });
        });
    });
</script>
@endsection