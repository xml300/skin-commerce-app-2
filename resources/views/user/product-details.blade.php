@extends('layouts.user.user_dashboard')
@section('title', 'Product Details')

@section('content')

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Product Details Section --}}
        <div id="productDetail" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md overflow-hidden mb-12"> {{-- Added mb-12 for spacing --}}
            <div class="md:grid md:grid-cols-2 md:gap-12">
                <div class="overflow-hidden">
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="w-full h-full object-cover rounded-tl-xl rounded-tr-xl md:rounded-tr-none md:rounded-bl-xl"
                            src="{{ asset('images/' . 'demo' . ($product->id % 4 + 1) . '.jpg') }}"
                            alt="{{ $product->product_name }}">
                    </div>
                </div>
                <div class="px-6 py-8 md:py-10 md:px-12 flex flex-col justify-center">
                    <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-4">
                        {{ $product->product_name }}
                    </h1>
                    <div class="mb-6">
                        <span
                            class="rounded-full px-2 py-1 font-medium text-muted-sage-green dark:text-muted-sage-green-darker bg-muted-sage-green-darker/30 dark:bg-muted-sage-green/20">{{ ucfirst($product->category()->first()->category_name) }}</span>
                    </div>
                    <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker leading-relaxed mb-8">
                        {{ $product->description }}
                    </p>
                    <p class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-8">
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <div class="flex space-x-4 mb-8">
                            <div class="flex items-center justify-center">
                                <button type="button" onclick="incrementOrDecrementQuantity(-1)" aria-label="Decrease Quantity"
                                class="text-3xl quantity-btn text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker rounded-xl dark:hover:text-antique-gold font-bold pr-2! pb-2.5 p-0 rounded-r-xl focus:outline-none transition-colors duration-200">-</button>
                                <input type="number" readonly
                                    class="quantity-input shadow-sm appearance-none py-3 px-1 pl-4! border border-soft-sand-beige dark:border-muted-sage-green rounded-lg w-16 p-0 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:shadow-outline text-center align-middle"
                                    name="quantity" min="1" value="{{ $cartQuantity ?? 1 }}"
                                    aria-label="Product Quantity">
                                <button type="button" onclick="incrementOrDecrementQuantity(1)" aria-label="Increase Quantity"
                                    class="text-3xl quantity-btn text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker rounded-xl dark:hover:text-antique-gold font-bold pl-2! pb-3 p-0 rounded-r-xl focus:outline-none transition-colors duration-200">+</button>
                            </div>
                            <button type="submit"
                                class="cart-btn bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                     {{-- Removed Ingredients placeholder --}}
                </div>
            </div>
        </div>

        {{-- Reviews Section Start --}}
        {{-- <div id="reviewsSection" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-6">Customer Reviews</h2>

            <!-- Display Existing Reviews -->
            <div class="mb-8 space-y-6">
                @forelse ($product->reviews()->latest()->take(5)->get() as $review)
                    <div class="border-b border-soft-sand-beige dark:border-muted-sage-green/30 pb-4">
                        <div class="flex items-center mb-2">
                            <span class="font-semibold text-warm-black dark:text-warm-white mr-3">{{ $review->user->fullName() ?? 'Anonymous' }}</span>
                            <div class="flex text-yellow-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 fill-current text-gray-300 dark:text-gray-600" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-auto">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-muted-sage-green dark:text-muted-sage-green-darker">{{ $review->review_text }}</p>
                    </div>
                @empty
                    <p class="text-muted-sage-green dark:text-muted-sage-green-darker">No reviews yet. Be the first to review this product!</p>
                @endforelse
                <!-- Optional: Add link to see all reviews if you implement pagination -->
                @if($product->reviews()->count() > 5)
                    <a href="#" class="text-muted-sage-green hover:text-muted-sage-green-darker dark:text-muted-sage-green-darker dark:hover:text-antique-gold font-medium">See all reviews</a>
                @endif
            </div>

            <!-- Review Submission Form -->
            @auth
                <div class="mt-8 border-t border-soft-sand-beige dark:border-muted-sage-green/30 pt-8">
                    <h3 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-4">Leave a Review</h3>
                    {{-- Include if you have session status for success messages --}}
                    {{-- @if (session('review_success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                            {{ session('review_success') }}
                        </div>
                    @endif --}}
                     {{-- Include if you have validation errors --}}
                    {{-- @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif 

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <label for="rating" class="block mb-2 text-sm font-medium text-warm-black dark:text-warm-white">Rating</label>
                            <select name="rating" id="rating" required
                                class="w-full md:w-1/4 p-2 border border-soft-sand-beige dark:border-muted-sage-green rounded-lg bg-white dark:bg-warm-black text-warm-black dark:text-warm-white focus:ring-muted-sage-green focus:border-muted-sage-green dark:focus:ring-antique-gold dark:focus:border-antique-gold">
                                <option value="">Select a rating</option>
                                <option value="5">5 Stars - Excellent</option>
                                <option value="4">4 Stars - Very Good</option>
                                <option value="3">3 Stars - Good</option>
                                <option value="2">2 Stars - Fair</option>
                                <option value="1">1 Star - Poor</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block mb-2 text-sm font-medium text-warm-black dark:text-warm-white">Your Review</label>
                            <textarea name="comment" id="comment" rows="4" required
                                class="w-full p-2 border border-soft-sand-beige dark:border-muted-sage-green rounded-lg bg-white dark:bg-warm-black text-warm-black dark:text-warm-white focus:ring-muted-sage-green focus:border-muted-sage-green dark:focus:ring-antique-gold dark:focus:border-antique-gold"
                                placeholder="Share your thoughts about the product..."></textarea>
                        </div>

                        <button type="submit"
                            class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-2 px-5 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200">
                            Submit Review
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-8 border-t border-soft-sand-beige dark:border-muted-sage-green/30 pt-8 text-center">
                     <p class="text-muted-sage-green dark:text-muted-sage-green-darker">
                        You must be <a href="{{ route('login') }}" class="text-muted-sage-green-darker dark:text-antique-gold hover:underline font-medium">logged in</a> to leave a review.
                    </p>
                </div>
            @endauth
        </div> --}}
        {{-- Reviews Section End --}}

    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Keep existing cart button logic if needed
             const cartButton = document.querySelector(".cart-btn");
             if (cartButton) {
                cartButton.addEventListener("click", () => {
                    localStorage.removeItem("cartCount");
                });
             }

             // Quantity adjustment logic
             const quantityInput = document.querySelector('input[name="quantity"].quantity-input');
             const decreaseButton = document.querySelector('.quantity-btn[aria-label="Decrease Quantity"]');
             const increaseButton = document.querySelector('.quantity-btn[aria-label="Increase Quantity"]');

             if (quantityInput && decreaseButton && increaseButton) {
                // Ensure initial value is at least 1
                if (parseInt(quantityInput.value) < 1 || isNaN(parseInt(quantityInput.value))) {
                    quantityInput.value = 1;
                }

                decreaseButton.addEventListener('click', () => changeQuantity(-1));
                increaseButton.addEventListener('click', () => changeQuantity(1));
             }

        });

        // Updated quantity function to handle min value and button reference
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

        // Original function kept for potential other uses, but changeQuantity is preferred now
        function incrementOrDecrementQuantity(change) {
            console.warn("incrementOrDecrementQuantity is deprecated, use changeQuantity instead if possible.");
             const quantity = document.querySelector('input[name="quantity"].quantity-input');
             let newValue = parseInt(quantity.value) + change;
              if (newValue >= 1) { // Ensure quantity doesn't go below 1
                quantity.value = newValue;
            } else {
                quantity.value = 1; // Reset to 1 if attempt to go below
            }
        }
    </script>
@endsection