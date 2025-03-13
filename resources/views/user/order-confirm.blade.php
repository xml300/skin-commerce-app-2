@extends('layouts.user.user_dashboard')
@section("title", 'Stara - Order Confirmation')

@section('content')
<main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh] flex items-center justify-center"> {{-- Consistent padding, min-height and flex for centering --}}
  <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg p-8 text-center"> {{-- Updated background color to Stara palette, padding --}}
    <div class="mb-8"> {{-- Added margin bottom for spacing --}}
        <i class="fa-regular fa-circle-check text-6xl text-muted-sage-green dark:text-antique-gold mb-4"></i> {{-- Added a success icon, using font-awesome and Stara accent colors, margin bottom --}}
    </div>
    <h2 class="text-3xl font-bold text-warm-black dark:text-warm-white mb-4"> {{-- Updated heading style to Stara, increased font size, margin bottom --}}
      Order Confirmed!
    </h2>
    <p class="text-lg text-warm-black dark:text-muted-sage-green mb-8"> {{-- Updated paragraph style to Stara, increased font size, margin bottom --}}
      Thank you for your order. Your simulated order has been placed.
    </p>
    <a
      href="/"
      class="inline-block bg-antique-gold hover:bg-antique-gold-darker text-warm-black font-bold py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-antique-gold focus:ring-offset-1 transition-colors duration-200 dark:bg-muted-sage-green dark:text-warm-white dark:hover:bg-muted-sage-green-darker" {{-- Updated button style to Stara palette (antique gold primary, muted sage green dark mode), added transition, increased padding --}}
      >Back to Home
    </a>
  </div>
</main>
@endsection