@extends('layouts.user.user_dashboard')
@section('title')
    Stara - Cart</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-green-900 dark:text-white mb-2">Shopping Cart</h1>
        </header>

        <section id="cartItemsSection" class="mb-8">
            <div id="cartItemsContainer" class="bg-white dark:bg-green-950 shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">
                                Price</th>
                            <th
                                class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">
                                Quantity</th>
                            <th
                                class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <!-- Cart items will be loaded here by JavaScript -->
                        @foreach ($cartItems as $item)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-900 dark:text-gray-100">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <img class="w-16 h-16 object-cover rounded"
                                                src="{{ Storage::url('demo' . ($item->product_id % 4 + 1) . '.jpg') }}"
                                                alt="{{ $item->product_name }}">
                                        </div>
                                        <div>{{ $item->product_name }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">
                                    ₦{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">
                                    <div class="flex items-center justify-center">
                                        <button onclick="updateQuantity({{ $item->product_id }}, -1)"
                                            class="bg-green-200 dark:bg-green-700 hover:bg-green-300 dark:hover:bg-green-600 text-green-700 dark:text-white font-bold py-2 px-3 rounded-l-md focus:outline-none">-</button>
                                        <input type="number" disabled
                                            class=" shadow-sm appearance-none  border border-green-700 rounded-none w-16 py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:shadow-outline text-center quantity-input"
                                            min="1" value="{{ $item->quantity }}" data-product-id="{{ $item->product_id }}"
                                            data-product-price="{{ $item->price }}">
                                        <button onclick="updateQuantity({{ $item->product_id }}, 1)"
                                            class="bg-green-200 dark:bg-green-700 hover:bg-green-300 dark:hover:bg-green-600 text-green-700 dark:text-white font-bold py-2 px-3 rounded-r-md focus:outline-none">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">
                                    ₦<span class="total-class"
                                        id="total_{{ $item->product_id }}">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-right font-medium">
                                    <button onclick="removeItem({{ $item->product_id }})"
                                        class=" w-full h-8 flex items-center text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="emptyCartMessage" class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6 text-center hidden">
                <p class="text-green-700 dark:text-gray-300">Your cart is empty.</p>
                <a href="/products"
                    class="inline-block mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-black dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800">Shop
                    Now</a>
            </div>
        </section>

        <section id="cartSummarySection" class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-green-900 dark:text-white mb-4">Order Summary</h2>
            <div class="flex justify-between mb-2">
                <span class="font-semibold text-green-700 dark:text-gray-300">Subtotal:</span>
                <span class="text-green-700 dark:text-gray-300">₦<span
                        id="cartSubtotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="flex justify-between mb-4">
                <span class="font-semibold text-green-700 dark:text-gray-300">Shipping:</span>
                <span class="text-green-700 dark:text-gray-300">Calculated at checkout</span>
            </div>
            <div class="border-t border-green-200 dark:border-green-600 pt-4 flex justify-between">
                <span class="text-xl font-bold text-green-900 dark:text-white">Total:</span>
                <span class="text-xl font-bold text-green-900 dark:text-white">₦<span
                        id="cartTotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="mt-6">
                <a href="/checkout" id="checkoutButton"
                    class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800">
                    Proceed to Checkout
                </a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartSubtotalSpan = document.getElementById('cartSubtotal');
            const cartTotalSpan = document.getElementById('cartTotal');
            const cartChanges = { "update": [], "remove": [] };

            window.updateQuantity = (productId, change) => {
                const itemQuantity = document.querySelector(`input[data-product-id="${productId}"]`);
                const itemPrice = itemQuantity.getAttribute('data-product-price');
                const itemTotal = document.querySelector(`span#total_${productId}`);

                let clogIndex = cartChanges.update.findIndex(item => item.productId === productId);
                let changeLog = cartChanges.update[clogIndex];

                if (clogIndex == -1) {
                    changeLog = { productId: productId, quantityChange: Math.max(0, change) };
                    cartChanges.update.push(changeLog);
                } else {
                    cartChanges.update[clogIndex].quantityChange = Math.max(0, changeLog.quantityChange + change);
                }

                itemQuantity.value = Math.max(1, parseInt(itemQuantity.value) + change);

                itemTotal.textContent = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD"
                }).format(itemQuantity.value * itemPrice).slice(1);

                let totalPrice = 0;
                document.querySelectorAll("span.total-class").forEach(span => {
                    const price = parseFloat(span.textContent.replace(',', ''));
                    totalPrice += price;
                });
                cartSubtotalSpan.textContent = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD"
                }).format(totalPrice).slice(1);
                cartTotalSpan.textContent = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD"
                }).format(totalPrice).slice(1);

                localStorage.setItem("cartChanges", JSON.stringify(cartChanges));

                document.querySelectorAll("a").forEach(elem => {
                    elem.href = elem.getAttribute("href") + "?update-cart=" + encodeURI(JSON.stringify(cartChanges));
                });
            }


            window.removeItem = (productId) => {
                changeLog = { productId: productId };
                cartChanges.remove.push(changeLog);
                localStorage.setItem("cartChanges", JSON.stringify(cartChanges));

                document.querySelectorAll("a").forEach(elem => {
                    elem.href = elem.getAttribute("href") + "?update-cart=" + encodeURI(JSON.stringify(cartChanges));
                });
            };

        });
    </script>
@endsection