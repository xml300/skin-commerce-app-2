@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Checkout')

@section('content')
  <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <header class="mb-16">
    <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">
      Checkout
    </h1>
    </header>

    <div class="lg:grid lg:grid-cols-2 lg:gap-16">
    <section class="mb-12 lg:mb-0">
      <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
      <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-8">
        Shipping Information
      </h2>
      <form id="checkoutForm" action="{{ route('order.place') }}" method="POST">
        @csrf
        <div class="mb-8">
        <label for="name" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Full Name</label>
        <input type="text" id="name" name="name"
          value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name  }}"
          class="form-input shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          disabled required />
        </div>
        <div class="mb-8">
        <label for="email" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Email Address</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
          class="form-input shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required />
        </div>
        <div class="mb-10">
        <label for="address" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Shipping Address</label>
        <textarea id="address" name="shipping_address" rows="4"
          class="form-textarea shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required placeholder="Enter your full shipping address"></textarea>
        </div>
      </div>
    </section>

    <section>
      <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
      <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-8">
        Order Summary
      </h2>
      <ul id="orderSummaryItems" class="mb-8">
        @foreach ($orderItems as $item)
      <li class="flex justify-between py-4 border-b border-soft-sand-beige dark:border-muted-sage-green">
      <div class="flex items-center">
        <img class="w-20 h-20 object-cover rounded-xl mr-5"
        src="{{  asset('images/' . 'demo' . ($item->id % 4 + 1) . '.jpg') }}" alt="{{ $item->product_name }}">
        <div>
          <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white">{{ $item->product_name }}</h4>
          <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Quantity: {{ $item->quantity }}</p> {{-- Added quantity display in order summary --}}
        </div>
      </div>
      <span class="text-warm-black dark:text-warm-white">₦{{ number_format($item->price * $item->quantity, 2) }}</span>
      </li>
    @endforeach
      </ul>
      <div class="flex justify-between mb-4">
        <span class="font-medium text-muted-sage-green dark:text-muted-sage-green-darker">Subtotal:</span>
        <span id="orderSubtotal"
        class="text-muted-sage-green dark:text-muted-sage-green-darker">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <div class="flex justify-between mb-5">
        <span class="font-medium text-muted-sage-green dark:text-muted-sage-green-darker">Shipping:</span>
        <span class="text-muted-sage-green dark:text-muted-sage-green-darker">₦0.00 (Simulated)</span>
      </div>
      <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-8 flex justify-between">
        <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
        <span id="orderTotal"
        class="text-xl font-bold text-warm-black dark:text-warm-white">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <button id="placeOrderButton" type="submit"
        class="mt-10 block w-full text-center bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker">
        Place Order (Simulated)
      </button>
      </form>
      </div>
    </section>
    </div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const placeOrderButton = document.getElementById("placeOrderButton");

    placeOrderButton.addEventListener("click", () => {
      localStorage.removeItem('cartCount');
    });

    });
  </script>
@endsection