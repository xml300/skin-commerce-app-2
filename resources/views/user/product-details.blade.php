@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Product Details')

@section('content')
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="productDetail" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md overflow-hidden">
            <div class="md:grid md:grid-cols-2 md:gap-12">
                <div class="overflow-hidden"> {{-- Added overflow hidden to the image container to handle rounded corners properly --}}
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="w-full h-full object-cover rounded-tl-xl rounded-tr-xl md:rounded-tr-none md:rounded-bl-xl" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                            alt="{{ $product->product_name }}">
                    </div>
                </div>
                <div class="px-6 py-8 md:py-10 md:px-12 flex flex-col justify-center">
                    <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-4">{{ $product->product_name }}</h1>
                    <div class="mb-6">
                        <span class="rounded-full px-2 py-1 font-medium text-muted-sage-green dark:text-muted-sage-green-darker bg-muted-sage-green-darker/30 dark:bg-muted-sage-green/20">{{ ucfirst($product->category()->first()->category_name) }}</span> {{-- Example category, replace with actual category --}}
                    </div>
                    <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker leading-relaxed mb-8">{{ $product->description }}</p>
                    <p class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-8">
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <input type="number" name="quantity" value="1" hidden>
                        <div class="flex space-x-4 mb-8"> {{-- Added spacing for quantity and cart button --}}
                            <!-- <div class="relative">
                                <select
                                    class="block appearance-none w-full bg-warm-white dark:bg-warm-black border border-soft-sand-beige dark:border-muted-sage-green text-warm-black dark:text-warm-white py-2 px-3 pr-8 rounded-xl leading-tight focus:outline-none focus:border-muted-sage-green focus:ring-2 focus:ring-muted-sage-green transition-colors duration-200"
                                    id="quantity" name="quantity">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0  flex items-center px-2 text-warm-black dark:text-muted-sage-green">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div> {{-- Quantity select - consider re-adding if quantity selection is needed --}} -->
                            <button
                                type="submit"
                                class="cart-btn bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200"
                            >
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
    </script>
@endsection