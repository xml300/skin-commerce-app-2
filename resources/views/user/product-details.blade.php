@extends('layouts.user.user_dashboard')
@section('title', 'Product Details')

@push('styles')
    {{-- GLightbox CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <style>
        /* Style for the active thumbnail */
        .thumbnail-link.active-thumbnail {
            border-color: #8A9A5B; /* Muted Sage Green */
            box-shadow: 0 0 0 2px #8A9A5B;
        }
        .dark .thumbnail-link.active-thumbnail {
             border-color: #C3B091; /* Antique Gold */
             box-shadow: 0 0 0 2px #C3B091;
        }
        /* Ensure consistent aspect ratio for thumbnails and main image */
        .thumbnail-link img, #mainProductImage {
            aspect-ratio: 1 / 1; /* Make images square */
            object-fit: cover;   /* Cover the area, cropping if needed */
            width: 100%;
            height: 100%;
        }
        /* Add transition for main image fade */
        #mainProductImage {
             transition: opacity 0.3s ease-in-out;
        }
    </style>
@endpush

@section('content')

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Product Details Section --}}
        <div id="productDetail" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md overflow-hidden mb-12">
            <div class="md:grid md:grid-cols-2 md:gap-8 lg:gap-12"> {{-- Adjusted gap --}}
                {{-- Image Gallery Section --}}
                <div class="p-4 md:p-6 lg:p-8">
                    @php
                        // Determine all available images, including fallback
                        $allImages = collect();
                        if ($product->productImages->count() > 0) {
                            // Add actual product images
                            foreach ($product->productImages as $img) {
                                $allImages->push((object)[
                                    'url' => asset('storage/'.$img->image_url),
                                    'alt_text' => "Image of {$product->product_name}" // Add alt text if available from DB
                                ]);
                            }
                        } else {
                            // Add the single fallback demo image
                            $allImages->push((object)[
                                'url' => asset('images/'.'demo'.($product->id % 4 + 1).'.jpg'),
                                'alt_text' => "Demo image for {$product->product_name}"
                            ]);
                        }
                        $firstImageUrl = $allImages->first()->url;
                        $firstImageAlt = $allImages->first()->alt_text;
                    @endphp

                    {{-- Main Image Display --}}
                    <div class="aspect-w-1 aspect-h-1 mb-4 rounded-lg overflow-hidden border border-soft-sand-beige dark:border-muted-sage-green">
                        <a href="{{ $firstImageUrl }}"
                           id="mainProductImageLink"
                           class="glightbox block w-full h-full" {{-- Added block, w-full, h-full --}}
                           data-gallery="product-gallery"
                           aria-label="View larger image">
                            <img id="mainProductImage"
                                class="w-full h-full object-cover" {{-- Ensure cover and dimensions --}}
                                src="{{ $firstImageUrl }}"
                                alt="{{ $firstImageAlt }}">
                        </a>
                    </div>

                    {{-- Thumbnails --}}
                    @if ($allImages->count() > 1)
                        <div id="productThumbnails" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-4 lg:grid-cols-5 gap-2">
                            @foreach($allImages as $index => $image)
                                <a href="{{ $image->url }}" {{-- Keep href for accessibility/fallback --}}
                                   class="thumbnail-link block border-2 border-transparent rounded-md overflow-hidden cursor-pointer hover:border-muted-sage-green dark:hover:border-antique-gold focus:outline-none focus:border-muted-sage-green dark:focus:border-antique-gold transition-all duration-200 {{ $index == 0 ? 'active-thumbnail' : '' }}"
                                   data-full-src="{{ $image->url }}"
                                   data-alt-text="{{ $image->alt_text }}"
                                   aria-label="View image {{ $index + 1 }}"
                                   onclick="updateMainImage(event, this)"> {{-- Call JS function on click --}}
                                    <img class="w-full h-full object-cover" {{-- Ensure cover and dimensions --}}
                                         src="{{ $image->url }}"
                                         alt="Thumbnail {{ $index + 1 }} for {{ $product->product_name }}">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Info Section --}}
                <div class="px-6 pb-8 pt-0 md:py-10 md:px-8 lg:px-12 flex flex-col justify-center"> {{-- Adjusted padding --}}
                     <h1 class="text-3xl lg:text-4xl font-semibold text-warm-black dark:text-warm-white mb-3 lg:mb-4">
                        {{ $product->product_name }}
                    </h1>
                    <div class="mb-4 lg:mb-6">
                        <span
                            class="rounded-full px-3 py-1 text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker bg-muted-sage-green-darker/30 dark:bg-muted-sage-green/20">{{ ucfirst($product->category()->first()->category_name) }}</span>
                    </div>
                    <p class="text-base lg:text-lg text-muted-sage-green dark:text-muted-sage-green-darker leading-relaxed mb-6 lg:mb-8">
                        {{ $product->description }}
                    </p>
                    <p class="text-2xl lg:text-3xl font-semibold text-warm-black dark:text-warm-white mb-6 lg:mb-8">
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8 items-stretch sm:items-center"> {{-- Adjusted spacing and alignment --}}
                            <div class="flex items-center justify-center border border-soft-sand-beige dark:border-muted-sage-green rounded-lg h-12"> {{-- Fixed height --}}
                                <button type="button" onclick="changeQuantity(-1)" aria-label="Decrease Quantity"
                                class="quantity-btn text-2xl text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker dark:hover:text-antique-gold font-bold px-3 py-2 focus:outline-none transition-colors duration-200 rounded-l-lg h-full">-</button>
                                <input type="number" readonly
                                    class="quantity-input shadow-sm appearance-none py-2 border-l border-r border-soft-sand-beige dark:border-muted-sage-green w-16 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none text-center align-middle h-full"
                                    name="quantity" min="1" value="{{ $cartQuantity ?? 1 }}"
                                    aria-label="Product Quantity">
                                <button type="button" onclick="changeQuantity(1)" aria-label="Increase Quantity"
                                    class="quantity-btn text-2xl text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker dark:hover:text-antique-gold font-bold px-3 py-2 focus:outline-none transition-colors duration-200 rounded-r-lg h-full">+</button>
                            </div>
                            <button type="submit"
                                class="cart-btn flex-grow sm:flex-grow-0 bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200 h-12"> {{-- Fixed height --}}
                                Add to Cart
                            </button>
                        </div>
                    </form>
                     {{-- Removed Ingredients placeholder --}}
                </div>
            </div>
        </div>

        {{-- Reviews Section (kept commented out as per original) --}}
        {{-- <div id="reviewsSection" class="..."> ... </div> --}}

    </main>


    {{-- GLightbox JS --}}
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        let lightbox; // Make lightbox accessible globally within the script

        document.addEventListener('DOMContentLoaded', function () {
            // Keep existing cart button logic if needed
             const cartButton = document.querySelector(".cart-btn");
             if (cartButton) {
                cartButton.addEventListener("click", () => {
                    localStorage.removeItem("cartCount");
                });
             }

             // Initialize GLightbox
             lightbox = GLightbox({
                 selector: '.glightbox', // Target links for the main image lightbox
                 touchNavigation: true,
                 loop: true,
                 // You can add more options here if needed
             });

            // --- Quantity adjustment logic (no changes needed here) ---
            const quantityInput = document.querySelector('input[name="quantity"].quantity-input');

             if (quantityInput) {
                if (parseInt(quantityInput.value) < 1 || isNaN(parseInt(quantityInput.value))) {
                    quantityInput.value = 1;
                }
             }
             // Using changeQuantity function below
             // --- End Quantity Logic ---

        }); // End DOMContentLoaded

         // Function to update the main image when a thumbnail is clicked
        function updateMainImage(event, thumbnailElement) {
            event.preventDefault(); // Prevent default link behavior

            const mainProductImage = document.getElementById('mainProductImage');
            const mainProductImageLink = document.getElementById('mainProductImageLink');
            const thumbnails = document.querySelectorAll('.thumbnail-link');

            const fullSrc = thumbnailElement.getAttribute('data-full-src');
            const altText = thumbnailElement.getAttribute('data-alt-text'); // Get alt text

            // Add fade effect
            mainProductImage.style.opacity = '0';

            setTimeout(() => {
                // Update the main image src and alt
                mainProductImage.src = fullSrc;
                mainProductImage.alt = altText; // Update alt text

                // Update the main image link href (so GLightbox opens the correct image)
                mainProductImageLink.href = fullSrc;

                // Update active thumbnail state
                thumbnails.forEach(thumb => thumb.classList.remove('active-thumbnail'));
                thumbnailElement.classList.add('active-thumbnail');

                // Fade in the new image
                mainProductImage.style.opacity = '1';

                 // Optional: If GLightbox instance needs updating after changing the main link's href
                 // This might be needed if the gallery structure changes dynamically in complex ways,
                 // but usually updating the href is sufficient for this setup.
                 // if (lightbox) {
                 //    lightbox.reload();
                 // }

            }, 150); // Adjust timing to match CSS transition duration
        }

        // Updated quantity function
        function changeQuantity(change) {
            const quantityInput = document.querySelector('input[name="quantity"].quantity-input');
            let currentValue = parseInt(quantityInput.value);
            let newValue = currentValue + change;

            if (newValue >= 1) { // Ensure quantity doesn't go below 1
                quantityInput.value = newValue;
            } else {
                quantityInput.value = 1; // Reset to 1 if attempt to go below
            }
        }
    </script>
@endsection