@extends('layouts.user.user_dashboard')
@section('title', 'Product Details')

@section('content')
 
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="productDetail" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md overflow-hidden">
            <div class="md:grid md:grid-cols-2 md:gap-12">
                <div class="overflow-hidden"> {{-- Added overflow hidden to the image container to handle rounded corners
                    properly --}}
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
                        {{-- Example category, replace with actual category --}}
                    </div>
                    <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker leading-relaxed mb-8">
                        {{ $product->description }}
                    </p>
                    <p class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-8">
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <div class="flex space-x-4 mb-8"> {{-- Added spacing for quantity and cart button --}}
                            <div class="flex items-center justify-center">
                                <button type="button" onclick="incrementOrDecrementQuantity(-1)" aria-label="Decrease Quantity"
                                class="text-3xl quantity-btn  text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker  rounded-xl   dark:hover:text-antique-gold  font-bold pr-2! pb-2.5 p-0 rounded-r-xl focus:outline-none transition-colors duration-200">-</button>
                                <input type="number" readonly
                                    class="quantity-input shadow-sm appearance-none py-3 px-1 pl-4!  border border-soft-sand-beige dark:border-muted-sage-green rounded-lg w-16  p-0 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:shadow-outline text-center align-middle"
                                    name="quantity" min="1" value="1"
                                    aria-label="Product Quantity">
                                <button type="button" onclick="incrementOrDecrementQuantity(1)" aria-label="Increase Quantity"
                                    class="text-3xl quantity-btn  text-warm-black dark:text-warm-white hover:text-muted-sage-green-darker  rounded-xl   dark:hover:text-antique-gold  font-bold pl-2! pb-3 p-0 rounded-r-xl focus:outline-none transition-colors duration-200">+</button>
                            </div> {{-- Quantity select - consider re-adding if quantity selection is needed --}}
                            <button type="submit"
                                class="cart-btn bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                   
                    <!-- <div class="border-t border-soft-sand-beige dark:border-warm-black pt-8"> {{-- Added border separator --}}
                                <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-4">Ingredients</h4>
                                <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker leading-relaxed">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod velit eu nisi aliquet, eu eleifend libero aliquet. ... (sample ingredients text)
                                </p>
                            </div> -->
                    {{-- Add more product details, specifications, or review sections here if needed --}}
                </div>
            </div>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector(".cart-btn").addEventListener("click", () => {
                localStorage.removeItem("cartCount");
            });

        });

        function incrementOrDecrementQuantity(change) {
            const quantity = document.querySelector('input[name="quantity"].quantity-input');
            console.log(quantity, quantity.value);
            quantity.value = parseInt(quantity.value) + change
        }
    </script>
@endsection