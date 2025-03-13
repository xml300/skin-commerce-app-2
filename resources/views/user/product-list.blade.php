@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Products') {{-- Assuming 'Stara' is the brand name --}}

@section('content')
<main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]"> {{-- Consistent padding, min-height for viewport coverage --}}
    <header class="mb-12"> {{-- Increased margin bottom for better spacing --}}
        <h1 class="text-3xl font-bold text-warm-black dark:text-warm-white mb-4">All Products</h1> {{-- Heading style consistent with typography guidelines, increased margin bottom --}}
        <p class="text-lg text-warm-black dark:text-muted-sage-green">Browse our wide range of skincare products.</p> {{-- Slightly larger paragraph text, muted accent color --}}
    </header>

    <section id="productFilter" class="mb-8 flex items-center gap-4"> {{-- Using gap instead of space-x for better spacing in flexbox --}}
        <label for="categoryFilter" class="text-warm-black dark:text-warm-white font-semibold text-lg">Filter by Category:</label> {{-- Label styling --}}
        <div class="relative">
            <select id="categoryFilter"
                class="block appearance-none w-full bg-warm-white dark:bg-warm-black border border-soft-sand-beige dark:border-muted-sage-green text-warm-black dark:text-warm-white py-2 px-3 pr-8 rounded-lg leading-tight focus:outline-none focus:border-muted-sage-green focus:ring-2 focus:ring-muted-sage-green transition-colors duration-200"> {{-- Rounded corners updated to `rounded-lg`, added transition for focus states --}}
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_name }}" {{ $category->category_name == $currentCategory ? "selected" : "" }}>{{ strtoupper(substr($category->category_name, 0, 1)) . substr($category->category_name, 1) }}</option> {{-- Category options --}}
                @endforeach
            </select>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-warm-black dark:text-muted-sage-green">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true"> {{-- Added aria-hidden to the SVG icon --}}
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </section>

    <section id="productList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"> {{-- Responsive grid layout --}}
        @foreach($products as $product)
        <div class="bg-warm-white dark:bg-warm-black rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200"> {{-- Added `hover:shadow-lg` and transition for product card hover effect --}}
                    <a href="/product/{{ $product->id }}">
                        <div class="aspect-w-4 aspect-h-3 h-48"> {{-- Using aspect ratio container to maintain image proportions, **added fixed height h-48 here to ensure uniformity** --}}
                            <img class="w-full h-full object-cover" src="{{  asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-warm-black dark:text-warm-white">{{ $product->product_name }}</h3> {{-- Product name --}}
                            <p class="text-warm-black dark:text-muted-sage-green">₦{{ number_format($product->price, 2) }}</p> {{-- Price --}}
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