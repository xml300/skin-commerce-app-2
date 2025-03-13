@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Product Details')

@section('content')
    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]"> {{-- Consistent padding and min-height --}}
        <div id="productDetail" class="bg-warm-white dark:bg-warm-black rounded-lg shadow-md overflow-hidden"> {{-- Product detail container --}}
            <div class="md:grid md:grid-cols-2 md:gap-8"> {{-- Using grid for two-column layout on medium screens and above, added gap --}}
                <div>
                    <div class="aspect-w-1 aspect-h-1"> {{-- Enforce 1:1 aspect ratio for image, making it square and uniform --}}
                        <img class="w-full h-120 object-cover rounded-tl-lg rounded-tr-lg md:rounded-tr-none md:rounded-bl-lg" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}" {{-- Rounded corners - top on mobile, left on desktop --}}
                            alt="{{ $product->product_name }}">
                    </div>
                </div>
                <div class="p-6 md:py-8 md:px-10 flex flex-col justify-center"> {{-- Padding in content area, adjusted for desktop --}}
                    <h1 class="text-3xl font-bold text-warm-black dark:text-warm-white mb-3">{{ $product->product_name }}</h1> {{-- Larger heading, reduced margin --}}
                    <p class="text-lg text-warm-black dark:text-muted-sage-green mb-6">{{ $product->description }}</p> {{-- Slightly larger description, increased margin --}}
                    <p class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-6"> {{-- Larger price text, increased margin --}}
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4"> {{-- Added margin to form --}}
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <input type="number" name="quantity" value="1" hidden>
                    <button
                        type="submit"
                        class="cart-btn bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-warm-black dark:text-muted-sage-green dark:hover:text-warm-white dark:hover:bg-antique-gold transition-colors duration-200"> {{-- Added transition for button hover --}}
                        Add to Cart
                    </button>
                    </form>
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