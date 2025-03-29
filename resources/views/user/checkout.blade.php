@extends('layouts.user.user_dashboard')
@section('title', 'Checkout')

@section('content')
  <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <header class="mb-16">
    <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">
      Checkout
    </h1>
    </header>

    <div class="lg:grid lg:grid-cols-2 lg:gap-16">
    <section class="mb-12 lg:mb-0">
      <form id="checkoutForm" action="{{ route('order.place') }}" method="POST">
      @csrf

      <div class="mb-0">
        <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-0">
        Step <span id="stepNumber">1</span> of 4
        </h2>
      </div>

      
      <div id="step1" class="checkout-step">
        <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
        <h2 class="text-xl font-semibold text-warm-black dark:text-warm-white mb-8">
          Shipping Information
        </h2>
        <div class="mb-8">
          <label for="name"
          class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Full
          Name</label>
          <input type="text" id="name" name="name"
          value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name  }}"
          class="form-input shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required />
        </div>
        <div class="mb-8">
          <label for="email"
          class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Email
          Address</label>
          <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
          class="form-input shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required />
        </div>
        <div class="mb-10">
          <label for="address"
          class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Shipping
          Address</label>
          <textarea id="address" name="shipping_address" rows="4"
          class="form-textarea shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required placeholder="Enter your full shipping address"></textarea>
        </div>
        
        <div class="mb-8">
          <label for="phone"
          class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Phone
          Number</label>
          <input type="tel" id="phone" name="phone"
          class="form-input shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200"
          required placeholder="Enter your phone number" />
        </div>
        <button type="button"
          class="next-step-button mt-6 block w-full text-center bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker">
          Next: Shipping Method
        </button>
        </div>
      </div>

      
      <div id="step2" class="checkout-step hidden">
        <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
        <h2 class="text-xl font-semibold text-warm-black dark:text-warm-white mb-8">
          Shipping Method
        </h2>
        <div class="mb-6">
          <div class="flex items-center mb-2">
          <input id="shippingStandard" type="radio" value="standard" name="shipping_method"
            class="form-radio h-5 w-5 text-muted-sage-green focus:ring-muted-sage-green border-gray-300 rounded"
            checked>
          <label for="shippingStandard" class="ml-3 text-sm font-medium text-warm-black dark:text-warm-white">
            Standard Shipping (Simulated) - ₦0.00
          </label>
          </div>
          <div class="flex items-center">
          <input id="shippingExpress" type="radio" value="express" name="shipping_method"
            class="form-radio h-5 w-5 text-muted-sage-green focus:ring-muted-sage-green border-gray-300 rounded">
          <label for="shippingExpress" class="ml-3 text-sm font-medium text-warm-black dark:text-warm-white">
            Express Shipping (Simulated) - ₦1,000.00
          </label>
          </div>
        </div>
        <div class="flex justify-between mt-8">
          <button type="button"
          class="prev-step-button text-muted-sage-green dark:text-antique-gold hover:text-muted-sage-green-darker dark:hover:text-antique-gold-darker font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200">
          Previous: Shipping Info
          </button>
          <button type="button"
          class="next-step-button bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker">
          Next: Payment Info
          </button>
        </div>
        </div>
      </div>

      
      <div id="step3" class="checkout-step hidden">
        <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
        <h2 class="text-xl font-semibold text-warm-black dark:text-warm-white mb-8">
          Payment Information
        </h2>
        <div class="mb-6">
          <label for="paymentMethod"
          class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">Payment
          Method</label>
          <select id="paymentMethod" name="payment_method"
          class="form-select shadow-sm appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200">
          <option value="paystack">Paystack</option> 
          
          
          
          </select>
        </div>

        <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker mb-6">
          Secure payment powered by Paystack. You will be redirected to Paystack to complete your payment.
        </p>

        <div class="flex justify-between mt-8">
          <button type="button"
          class="prev-step-button text-muted-sage-green dark:text-antique-gold hover:text-muted-sage-green-darker dark:hover:text-antique-gold-darker font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200">
          Previous: Shipping Method
          </button>
          <button type="button"
          class="next-step-button bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker">
          Next: Review Order
          </button>
        </div>
        </div>
      </div>

      
      <div id="step4" class="checkout-step hidden">
        <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
        <h2 class="text-xl font-semibold text-warm-black dark:text-warm-white mb-8">
          Review Order
        </h2>
        <ul id="orderSummaryItems" class="mb-8">
          @foreach ($orderItems as $item)
        <li class="flex justify-between py-4 border-b border-soft-sand-beige dark:border-muted-sage-green">
        <div class="flex items-center">
        <img class="w-20 h-20 object-cover rounded-xl mr-5"
        src="{{  asset('images/' . 'demo' . ($item->id % 4 + 1) . '.jpg') }}"
        alt="{{ $item->product_name }}">
        <div>
        <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white">{{ $item->product_name }}
        </h4>
        <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Quantity:
          {{ $item->quantity }}
        </p>
        </div>
        </div>
        <span class="item-total text-warm-black dark:text-warm-white"
        data-item-price="{{ $item->price * $item->quantity }}">₦{{ number_format($item->price * $item->quantity, 2) }}</span>
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
          <span id="orderShipping" class="text-muted-sage-green dark:text-muted-sage-green-darker">₦0.00</span>
        </div>
        <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-8 flex justify-between">
          <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
          <span id="orderTotal"
          class="text-xl font-bold text-warm-black dark:text-warm-white">₦{{ number_format($orderSubtotal, 2) }}</span>
        </div>
        <div class="flex justify-between mt-8">
          <button type="button"
          class="prev-step-button text-muted-sage-green dark:text-antique-gold hover:text-muted-sage-green-darker dark:hover:text-antique-gold-darker font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200">
          Previous: Payment Info
          </button>
          <button id="placeOrderButton" type="submit"
          class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker">
          Place Order (Simulated)
          </button>
        </div>
        </div>
      </div>


      
      <div id="loadingIndicator" class="hidden mt-4 text-center">
        <svg class="animate-spin h-5 w-5 mx-auto text-muted-sage-green" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
        </svg>
        <p>Processing...</p>
      </div>
      
      <div id="successMessage"
        class="hidden mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
        role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">Your order has been placed (simulated).</span>
      </div>

      
      <div id="errorMessage"
        class="hidden fixed top-0 left-0 w-full bg-rose-100 border-b-2 border-rose-300 text-rose-700 px-4 py-3 shadow-md z-50 transition-transform duration-300 transform translate-y-[-100%] dark:bg-rose-800 dark:border-rose-700 dark:text-rose-100"
        role="alert">
        <div class="container mx-auto flex justify-between items-center">
        <div>
          <strong class="font-bold dark:text-rose-50">Error!</strong>
          <span class="block sm:inline text-sm text-gray-700 ml-1 dark:text-gray-300">
          
          (See details below)
          </span>
          <ul id="errorList" class="list-disc list-inside mt-2 font-semibold dark:text-rose-50">
          
          </ul>
        </div>
        <button id="closeErrorMessage" type="button"
          class="text-rose-500 hover:text-rose-700 focus:outline-none dark:text-rose-300 dark:hover:text-rose-100">
          <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"></path>
          </svg>
        </button>
        </div>
      </div>
      </form>
    </section>

    <section>
      <div class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
      <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-8">
        Order Summary
      </h2>
      <ul id="orderSummarySidebarItems" class="mb-8"> 
        @foreach ($orderItems as $item)
      <li class="flex justify-between py-4 border-b border-soft-sand-beige dark:border-muted-sage-green">
      <div class="flex items-center">
        <img class="w-20 h-20 object-cover rounded-xl mr-5"
        src="{{  asset('images/' . 'demo' . ($item->id % 4 + 1) . '.jpg') }}" alt="{{ $item->product_name }}">
        <div>
        <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white">{{ $item->product_name }}</h4>
        <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Quantity:
        {{ $item->quantity }}
        </p>
        </div>
      </div>
      <span class="item-total text-warm-black dark:text-warm-white"
        data-item-price="{{ $item->price * $item->quantity }}">₦{{ number_format($item->price * $item->quantity, 2) }}</span>
      </li>
    @endforeach
      </ul>
      <div class="flex justify-between mb-4">
        <span class="font-medium text-muted-sage-green dark:text-muted-sage-green-darker">Subtotal:</span>
        <span id="orderSidebarSubtotal"
        class="text-muted-sage-green dark:text-muted-sage-green-darker">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      <div class="flex justify-between mb-5">
        <span class="font-medium text-muted-sage-green dark:text-muted-sage-green-darker">Shipping:</span>
        <span id="orderSidebarShipping" class="text-muted-sage-green dark:text-muted-sage-green-darker">₦0.00</span>
        
      </div>
      <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-8 flex justify-between">
        <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
        <span id="orderSidebarTotal"
        class="text-xl font-bold text-warm-black dark:text-warm-white">₦{{ number_format($orderSubtotal, 2) }}</span>
      </div>
      </div>
    </section>
    </div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const checkoutSteps = document.querySelectorAll('.checkout-step');
    const nextStepButtons = document.querySelectorAll('.next-step-button');
    const prevStepButtons = document.querySelectorAll('.prev-step-button');
    const placeOrderButton = document.getElementById("placeOrderButton");
    const checkoutForm = document.getElementById("checkoutForm");
    const loadingIndicator = document.getElementById("loadingIndicator");
    const successMessage = document.getElementById("successMessage");
    const errorMessage = document.getElementById("errorMessage");
    const errorList = document.getElementById("errorList");
    const stepNumberSpan = document.getElementById('stepNumber');

    const orderSubtotalSpan = document.getElementById('orderSubtotal');
    const orderShippingSpan = document.getElementById('orderShipping');
    const orderTotalSpan = document.getElementById('orderTotal');
    const shippingStandardRadio = document.getElementById('shippingStandard');
    const shippingExpressRadio = document.getElementById('shippingExpress');

    
    const orderSidebarSubtotalSpan = document.getElementById('orderSidebarSubtotal');
    const orderSidebarShippingSpan = document.getElementById('orderSidebarShipping');
    const orderSidebarTotalSpan = document.getElementById('orderSidebarTotal');

    const closeErrorMessageButton = document.getElementById("closeErrorMessage"); 


    document.querySelector("form#checkoutForm").addEventListener("submit", function (event) {
      localStorage.removeItem("cartCount");
    });
      
    let currentStep = 1;

    function showStep(stepIndex) {
      checkoutSteps.forEach((step, index) => {
      step.classList.toggle('hidden', index + 1 !== stepIndex);
      });
      stepNumberSpan.textContent = stepIndex;
    }

    function updateOrderSummary() {
      const numFmt = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
      });
      let subtotal = parseFloat("{{ $orderSubtotal }}");
      let shippingCost = 0;

      if (shippingExpressRadio.checked) {
      shippingCost = 1000; 
      }

      orderShippingSpan.textContent = `₦${numFmt.format(shippingCost).slice(1)}`;
      orderSidebarShippingSpan.textContent = `₦${numFmt.format(shippingCost).slice(1)}`; 
      const total = subtotal + shippingCost;
      orderTotalSpan.textContent = `₦${numFmt.format(total).slice(1)}`;
      orderSidebarTotalSpan.textContent = `₦${numFmt.format(total).slice(1)}`; 
    }

    
    showStep(currentStep);
    updateOrderSummary(); 

    
    nextStepButtons.forEach(button => {
      button.addEventListener('click', function () {
      if (currentStep < checkoutSteps.length) {
        
        if (currentStep === 1) {
        if (!validateStep1()) return;
        } else if (currentStep === 3) {
        if (!validateStep3()) return; 
        }

        currentStep++;
        showStep(currentStep);
        if (currentStep === 4) { 
        updateOrderSummary();
        }
      }
      });
    });

    
    prevStepButtons.forEach(button => {
      button.addEventListener('click', function () {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
      }
      });
    });

    
    shippingStandardRadio.addEventListener('change', updateOrderSummary);
    shippingExpressRadio.addEventListener('change', updateOrderSummary);


    function validateStep1() {
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const address = document.getElementById('address').value;
      const phone = document.getElementById('phone').value;

      let isValid = true;
      let errors = [];

      if (!name) {
      isValid = false;
      errors.push("Name is required.");
      }
      if (!email) {
      isValid = false;
      errors.push("Email is required.");
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      isValid = false;
      errors.push("Invalid email format.");
      }
      if (!address) {
      isValid = false;
      errors.push("Shipping address is required.");
      }
      if (!phone) {
      isValid = false;
      errors.push("Phone number is required.");
      } else if (!/^\d+$/.test(phone)) {
      isValid = false;
      errors.push("Invalid phone number format.  Use only digits.");
      }

      if (!isValid) {
      errorList.innerHTML = '';
      errors.forEach(error => {
        const li = document.createElement("li");
        li.textContent = error;
        errorList.appendChild(li);
      });
      slideInErrorMessage(); 
      return false;
      }
      return true;
    }

    function validateStep3() {
      return true;
    }


    function slideInErrorMessage() {
      errorMessage.classList.remove("hidden");
      
      void errorMessage.offsetWidth;
      errorMessage.classList.remove("translate-y-[-100%]"); 
      setTimeout(() => {
      slideOutErrorMessage();
      }, 6 * 1000);
    }

    function slideOutErrorMessage() {
      errorMessage.classList.add("translate-y-[-100%]"); 
      setTimeout(() => { errorMessage.classList.add("hidden"); }, 300); 
    }

    closeErrorMessageButton.addEventListener('click', slideOutErrorMessage);


    placeOrderButton.addEventListener("click", function (event) {
      
      successMessage.classList.add("hidden");
      errorMessage.classList.add("hidden");
      errorList.innerHTML = ''; 

      
      if (!validateStep1() || !validateStep3()) { //Example: Re-validate step 1 and 3 before final submit
      return; 
      }

      
      
      
      
      
      
      
      
      
      

      
      placeOrderButton.classList.add("hidden");
      loadingIndicator.classList.remove("hidden");
    });

    });
  </script>
@endsection