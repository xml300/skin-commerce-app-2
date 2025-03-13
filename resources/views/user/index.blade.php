@extends('layouts.user.user_dashboard')
@section('title', 'Stara - homepage') {{-- Assuming 'Stara' is the correct brand name based on the Color Palette Doc --}}

@section("content")
<main class="container mx-auto p-4 md:p-8 lg:p-10"> {{-- Consistent padding based on spacing scale --}}
    <section class="mb-12"> {{-- Margin bottom for section spacing --}}
        <h2 class="text-2xl font-bold text-warm-black dark:text-warm-white mb-4">Featured Products</h2> {{-- Heading style consistent with typography guidelines --}}
        <div id="featuredProducts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"> {{-- Responsive grid layout for product listings --}}
            @foreach ($products as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-lg shadow-md overflow-hidden"> {{-- Product card styling with rounded corners and shadow --}}
                    <a href="/product/{{ $product->id }}">
                        <img class="w-full h-48 object-cover" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                            alt="{{ $product->product_name }}"> {{-- Product image, ensure aspect ratio is maintained if needed, consider aspect-ratio plugin --}}
                        <div class="p-4"> {{-- Padding inside product card --}}
                            <h3 class="font-semibold text-warm-black dark:text-warm-white">{{ $product->product_name }}</h3> {{-- Product name styling --}}
                            <p class="text-warm-black dark:text-muted-sage-green">₦{{ number_format($product->price, 2) }}</p> {{-- Price styling, muted accent color for price --}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-12"> {{-- Margin bottom for section spacing --}}
        <h2 class="text-2xl font-bold text-warm-black dark:text-warm-white mb-4">Shop by Category</h2> {{-- Heading style consistent with typography guidelines --}}
        <div class="flex max-w-screen gap-4 justify-between overflow-x-scroll custom-scrollbar"> {{-- Horizontal scrolling category list for mobile --}}
            @foreach ($categories as $category)
                <div class="flex-1 p-4 bg-soft-sand-beige hover:bg-muted-sage-green dark:bg-warm-black dark:hover:bg-antique-gold rounded-lg shadow-md text-center"> {{-- Category box styling, using accent/secondary colors for background and hover --}}
                    <a href="/products?category={{ $category->category_name }}" class="block text-warm-black dark:text-warm-white">{{ strtoupper(substr($category->category_name, 0, 1)) . substr($category->category_name, 1) }}</a> {{-- Category link styling --}}
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="text-2xl font-bold text-warm-black dark:text-warm-white mb-4">New Arrivals</h2> {{-- Heading style consistent with typography guidelines --}}
        <div id="newArrivals" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"> {{-- Responsive grid layout for new arrivals --}}
            @foreach ($products as $product)
                <div class="bg-warm-white dark:bg-warm-black rounded-lg shadow-md overflow-hidden"> {{-- Product card styling consistent with Featured Products --}}
                    <a href="/product/{{ $product->id }}">
                    <img class="w-full h-48 object-cover" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                    alt="{{ $product->product_name }}"> {{-- Product image --}}
                        <div class="p-4"> {{-- Padding inside product card --}}
                            <h3 class="font-semibold text-warm-black dark:text-warm-white">{{ $product->product_name }}</h3> {{-- Product name styling --}}
                            <p class="text-warm-black dark:text-muted-sage-green">₦{{ number_format($product->price, 2) }}</p> {{-- Price styling --}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection

{{--
Accessibility Checklist Reminder:

- Color Contrast: Verify text and interactive elements against background colors using a contrast checker to meet WCAG guidelines.
    - Ensure sufficient contrast for:
        - Warm Black text on Warm White background.
        - Warm White text on Warm Black background (if used in other areas).
        - Accent colors used for text or interactive elements against background colors.

- Semantic HTML: Ensure proper use of semantic HTML5 elements for structure and screen reader accessibility.
- Keyboard Navigation: Test all interactive elements for keyboard focus and logical tab order. Ensure focus states are visually clear.
- ARIA Attributes:  If more complex interactive elements are added (e.g., carousels, dropdowns, modals), implement ARIA attributes to enhance screen reader experience.

Tailwind CSS v4 Considerations:

- Theme Customization: Ensure `tailwind.config.js` is correctly configured with the refined color palette, typography, and spacing scale from the design documents.
- Responsive Breakpoints: Test responsiveness across all defined breakpoints (sm, md, lg, xl) to ensure optimal layout on different screen sizes.
- Utility Classes:  Maintain consistency in using Tailwind utility classes for styling. Avoid inline styles.
- Plugins: Consider if additional Tailwind CSS v4 plugins (like Typography, Aspect Ratio, Forms, Container Queries) can further enhance the design and development process based on the design document recommendations.
--}}