@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Product Details')

@section('content')
    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
        <div id="productDetail" class="bg-white dark:bg-green-950 rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <img class="w-full h-128 object-cover" src="{{ asset('images/'.'demo'.($product->id % 4 + 1).'.jpg') }}"
                        alt="{{ $product->product_name }}">
                </div>
                <div class="md:w-1/2 p-6 flex flex-col justify-center items-center">
                    <h1 class="text-2xl font-bold text-green-900 dark:text-white mb-2">{{ $product->product_name }}</h1>
                    <p class="text-green-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                    <p class="text-xl font-semibold text-green-900 dark:text-white mb-4">
                        ₦{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="number" name="product_id" value="{{ $product->id }}" hidden>
                        <input type="number" name="quantity" value="1" hidden>
                    <button
                        type="submit"
                        class="cart-btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-black dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800">
                        Add to Cart
                    </button>
                    </form>
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