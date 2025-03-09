@include('layouts.user.header', ['title' => 'Skincare Shop - Order Confirmation'])

<main class="container mx-auto p-4 md:p-8 lg:p-10 h-[75vh] flex items-center justify-center">
  <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-8 text-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
      Order Confirmed!
    </h2>
    <p class="text-gray-700 dark:text-gray-300 mb-6">
      Thank you for your order. Your simulated order has been placed.
    </p>
    <a
      href="/"
      class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 dark:bg-blue-700 dark:hover:bg-blue-800"
      >Back to Home</a
    >
  </div>
</main>

@include('layouts.user.footer')