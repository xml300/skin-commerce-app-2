@include('layouts.user.header', ['title' => 'Skincare Shop - Checkout'])

<main class="container mx-auto p-4 md:p-8 lg:p-10">
  <header class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
      Checkout
    </h1>
  </header>

  <div class="lg:flex lg:space-x-8">
    <section class="lg:w-1/2 mb-8 lg:mb-0">
      <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
          Shipping Information
        </h2>
        <form id="checkoutForm">
          <div class="mb-4">
            <label
              for="name"
              class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
              >Name</label
            >
            <input
              type="text"
              id="name"
              name="name"
              class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
          <div class="mb-4">
            <label
              for="email"
              class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
              >Email</label
            >
            <input
              type="email"
              id="email"
              name="email"
              class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
          <div class="mb-6">
            <label
              for="address"
              class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
              >Address</label
            >
            <textarea
              id="address"
              name="address"
              rows="3"
              class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required
            ></textarea>
          </div>
        </form>
      </div>
    </section>

    <section class="lg:w-1/2">
      <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
          Order Summary
        </h2>
        <ul id="orderSummaryItems" class="mb-4">
          <!-- Order summary items will be loaded here by JavaScript -->
          <li>Loading order items...</li>
        </ul>
        <div class="flex justify-between mb-2">
          <span class="font-semibold text-gray-700 dark:text-gray-300"
            >Subtotal:</span
          >
          <span id="orderSubtotal" class="text-gray-700 dark:text-gray-300"
            >₦0.00</span
          >
        </div>
        <div class="flex justify-between mb-4">
          <span class="font-semibold text-gray-700 dark:text-gray-300"
            >Shipping:</span
          >
          <span class="text-gray-700 dark:text-gray-300"
            >₦0.00 (Simulated)</span
          >
        </div>
        <div
          class="border-t border-gray-200 dark:border-gray-600 pt-4 flex justify-between"
        >
          <span class="text-xl font-bold text-gray-800 dark:text-white"
            >Total:</span
          >
          <span
            id="orderTotal"
            class="text-xl font-bold text-gray-800 dark:text-white"
            >₦0.00</span
          >
        </div>
        <button
          id="placeOrderButton"
          class="mt-6 block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 dark:bg-blue-700 dark:hover:bg-blue-800"
        >
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

    const displayOrderSummary = async () => {
      orderSummaryItemsList.innerHTML = "<li>Loading order items...</li>";
      if (cartItems.length === 0) {
        orderSummaryItemsList.innerHTML = "<li>Your cart is empty.</li>";
        orderSubtotalSpan.textContent = "₦0.00";
        orderTotalSpan.textContent = "₦0.00";
        placeOrderButton.disabled = true; // Disable place order button if cart is empty
        return;
      }
      placeOrderButton.disabled = false; // Enable button if cart has items
      orderSummaryItemsList.innerHTML = ""; // Clear loading message

      let subtotal = 0;

      for (const cartItem of cartItems) {
        try {
          const response = await fetch(`/api/products/${cartItem.productId}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const product = await response.json();
          const itemTotal = product.price * cartItem.quantity;
          subtotal += itemTotal;

          const listItem = document.createElement("li");
          listItem.classList.add(
            "flex",
            "justify-between",
            "py-2",
            "border-b",
            "border-gray-200",
            "dark:border-gray-600"
          );
          listItem.innerHTML = `
                            <div class="flex items-center">
                                <img src="${product['product_images'] }" alt="${product['product_name'] }" class="w-12 h-12 object-cover rounded mr-2">
                                <span>${product['product_name'] } x ${cartItem['quantity'] }</span>
                            </div>
                            <span>₦${itemTotal}</span>
                        `;
          orderSummaryItemsList.appendChild(listItem);
        } catch (error) {
          console.error(
            "Error fetching product details for order summary:",
            error
          );
          const errorItem = document.createElement("li");
          errorItem.classList.add("text-red-500", "dark:text-red-400");
          errorItem.textContent = "Error loading product details.";
          orderSummaryItemsList.appendChild(errorItem);
        }
      }

      orderSubtotalSpan.textContent = `₦${subtotal}`;
      orderTotalSpan.textContent = `₦${subtotal}`; // For MVP, total is same as subtotal
    };

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

    displayOrderSummary();
  });
</script>

@include('layouts.user.footer')