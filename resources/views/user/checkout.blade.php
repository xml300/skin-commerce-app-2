@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Checkout')

@section('content')
  <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
    <header class="mb-8">
    <h1 class="text-3xl font-bold text-green-900 dark:text-white mb-2">
      Checkout
    </h1>
    </header>

    <div class="lg:flex lg:space-x-8">
    <section class="lg:w-1/2 mb-8 lg:mb-0">
      <div class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-green-900 dark:text-white mb-4">
        Shipping Information
      </h2>
      <form id="checkoutForm">
        <div class="mb-4">
        <label for="name" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">Name</label>
        <input type="text" id="name" name="name"
          class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-black leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
          required />
        </div>
        <div class="mb-4">
        <label for="email" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">Email</label>
        <input type="email" id="email" name="email"
          class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-black leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
          required />
        </div>
        <div class="mb-6">
        <label for="address" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">Address</label>
        <textarea id="address" name="address" rows="3"
          class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-black leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
          required></textarea>
        </div>
      </form>
      </div>
    </section>

    <section class="lg:w-1/2">
      <div class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-green-900 dark:text-white mb-4">
        Order Summary
      </h2>
      <ul id="orderSummaryItems" class="mb-4">
        <!-- Order summary items will be loaded here by JavaScript -->
        @foreach ($orderItems as $item)
      <li class="flex justify-between py-2 border-b border-green-200 dark:border-green-600">
      <div class="flex items-center">
      <img class="w-12 h-12 object-cover rounded mr-2" src="{{  asset('images/'.'demo'.($item->id % 4 + 1).'.jpg') }}"
      alt="{{ $item->product_name }}">
        <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
      </div>
      <span>₦{{ number_format($item->price * $item->quantity, 2) }}</span>
      </li>
    @endforeach
      </ul>
      <div class="flex justify-between mb-2">
        <span class="font-semibold text-green-800 dark:text-gray-300">Subtotal:</span>
        <span id="orderSubtotal" class="text-green-700 dark:text-gray-300">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <div class="flex justify-between mb-4">
        <span class="font-semibold text-green-800 dark:text-gray-300">Shipping:</span>
        <span class="text-green-700 dark:text-gray-300">₦0.00 (Simulated)</span>
      </div>
      <div class="border-t border-green-200 dark:border-green-600 pt-4 flex justify-between">
        <span class="text-xl font-bold text-green-900 dark:text-white">Total:</span>
        <span id="orderTotal" class="text-xl font-bold text-green-900 dark:text-white">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <button id="placeOrderButton"
        class="mt-6 block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-black dark:border-1 dark:border-green-700 dark:text-green-700 dark:hover:border-green-800 dark:hover:text-white dark:hover:bg-green-800">
        Place Order (Simulated)
      </button>
      </div>
    </section>
    </div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const orderSummaryItemsList = document.getElementById("orderSummaryItems");
    const orderSubtotalSpan = document.getElementById("orderSubtotal");
    const orderTotalSpan = document.getElementById("orderTotal");
    const placeOrderButton = document.getElementById("placeOrderButton");

    let cartItems = JSON.parse(localStorage.getItem("cart") || "[]");

    
    placeOrderButton.addEventListener("click", () => {
      alert(
      "Simulating order placement.\n\nOrder Details:\n" +
      JSON.stringify(cartItems) +
      "\nTotal: ₦" +
      orderTotalSpan.textContent.split("₦")[1] +
      "\n\nThank you for your simulated order!"
      );
      localStorage.removeItem("cart"); // Clear cart after simulated order
      updateCartCounter(); // Update cart counter in header to 0
      window.location.href = "/order-confirmation"; // Redirect to order confirmation page
    });

    });
  </script>
@endsection