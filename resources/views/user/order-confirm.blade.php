@extends('layouts.user.user_dashboard')
@section("title", 'Stara - Order Confirmation')

@section('content')
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[75vh] flex items-center justify-center">
  <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10 text-center">
    <div class="mb-10">
        <i class="fa-regular fa-circle-check text-7xl text-muted-sage-green dark:text-antique-gold mb-6"></i>
    </div>
    <h2 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">
      Order Confirmed!
    </h2>
    <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker mb-10">
      Thank you for your order. Your simulated order has been placed.
    </p>
    <a
      href="/"
      class="inline-block bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker"
      >Back to Home
    </a>
  </div>
</main>
@endsection