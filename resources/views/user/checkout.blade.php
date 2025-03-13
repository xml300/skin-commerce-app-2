@extends('layouts.user.user_dashboard')
@section('title', 'Stara - Checkout')

@section('content')
  <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]"> {{-- Consistent padding and min-height --}}
    <header class="mb-12"> {{-- Increased margin bottom for better spacing --}}
    <h1 class="text-3xl font-bold text-warm-black dark:text-warm-white mb-4"> {{-- Heading style and margin --}}
      Checkout
    </h1>
    </header>

    <div class="lg:grid lg:grid-cols-2 lg:gap-8"> {{-- Using grid for two-column layout on larger screens --}}
    <section class="mb-8 lg:mb-0"> {{-- Margin bottom for mobile, removed on larger screens --}}
      <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg p-8"> {{-- Increased padding --}}
      <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-6"> {{-- Increased font size and margin --}}
        Shipping Information
      </h2>
      <form id="checkoutForm" action="{{ route('order.place') }}" method="POST">
        @csrf
        <div class="mb-6"> {{-- Increased margin bottom --}}
        <label for="name" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2">Name</label> {{-- Updated label style --}}
        <input type="text" id="name" name="name"
          value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name  }}"
          class="form-input shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" {{-- Applied form-input class and rounded corners, transition --}}
          disabled required />
        </div>
        <div class="mb-6"> {{-- Increased margin bottom --}}
        <label for="email" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2">Email Address</label> {{-- Updated label style --}}
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
          class="form-input shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" {{-- Applied form-input class and rounded corners, transition --}}
          required />
        </div>
        <div class="mb-8"> {{-- Increased margin bottom --}}
        <label for="address" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2">Shipping Address</label> {{-- Updated label style --}}
        <textarea id="address" name="shipping_address" rows="3"
          class="form-textarea shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" {{-- Applied form-textarea class and rounded corners, transition --}}
          required placeholder="Your shipping address"></textarea> {{-- Added placeholder --}}
        </div>
      </div>
    </section>

    <section>
      <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg p-8"> {{-- Increased padding --}}
      <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-6"> {{-- Increased font size and margin --}}
        Order Summary
      </h2>
      <ul id="orderSummaryItems" class="mb-6"> {{-- Increased margin bottom --}}
        <!-- Order summary items will be loaded here by JavaScript -->
        @foreach ($orderItems as $item)
      <li class="flex justify-between py-3 border-b border-soft-sand-beige dark:border-muted-sage-green"> {{-- Increased py for spacing --}}
      <div class="flex items-center">
        <img class="w-16 h-16 object-cover rounded mr-4" {{-- Increased image size and margin --}}
        src="{{  asset('images/' . 'demo' . ($item->id % 4 + 1) . '.jpg') }}" alt="{{ $item->product_name }}">
        <span class="text-warm-black dark:text-warm-white">{{ $item->product_name }} x {{ $item->quantity }}</span>
      </div>
      <span class="text-warm-black dark:text-warm-white">₦{{ number_format($item->price * $item->quantity, 2) }}</span>
      </li>
    @endforeach
      </ul>
      <div class="flex justify-between mb-3"> {{-- Reduced margin bottom --}}
        <span class="font-semibold text-warm-black dark:text-warm-white">Subtotal:</span>
        <span id="orderSubtotal"
        class="text-warm-black dark:text-warm-white">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <div class="flex justify-between mb-4"> {{-- Increased margin bottom --}}
        <span class="font-semibold text-warm-black dark:text-warm-white">Shipping:</span>
        <span class="text-warm-black dark:text-warm-white">₦0.00 (Simulated)</span>
      </div>
      <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-6 flex justify-between"> {{-- Increased pt --}}
        <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
        <span id="orderTotal"
        class="text-xl font-bold text-warm-black dark:text-warm-white">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <button id="placeOrderButton" type="submit"
        class="mt-8 block w-full text-center bg-antique-gold hover:bg-antique-gold-darker text-warm-black font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-antique-gold focus:ring-offset-1 transition-colors duration-200 dark:bg-muted-sage-green dark:text-warm-white dark:hover:bg-muted-sage-green-darker"> {{-- Updated button style to antique gold, transition --}}
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