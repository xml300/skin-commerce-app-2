@extends('layouts.user.user_dashboard')
@section('title')
    Stara - Cart</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="mb-16">
            <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-6">Shopping Cart</h1>
        </header>

        <section id="cartItemsSection" class="mb-16">
            <div id="cartItemsContainer" class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl overflow-hidden">
                <table class="min-w-full table-fixed leading-normal">
                    <thead class="bg-soft-sand-beige dark:bg-warm-black">
                        <tr>
                            <th
                                class="px-6 py-4 border-b border-soft-sand-beige dark:border-muted-sage-green text-left text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-6 py-4 border-b border-soft-sand-beige dark:border-muted-sage-green text-left text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider">
                                Price</th>
                            <th
                                class="px-6 py-4 border-b border-soft-sand-beige dark:border-muted-sage-green text-center text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider">
                                Quantity</th>
                            <th
                                class="px-6 py-4 border-b border-soft-sand-beige dark:border-muted-sage-green text-right text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-6 py-4 border-b border-soft-sand-beige dark:border-muted-sage-green text-right text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        @foreach ($cartItems as $item)
                            <tr class="hover:bg-soft-sand-beige/50 dark:hover:bg-warm-black/50 transition-colors duration-100">
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-warm-black dark:text-warm-white">
                                    <div class="flex items-center">
                                        <div class="mr-5">
                                            <img class="w-24 h-24 object-cover rounded-xl"
                                                src="{{ asset('images/' . 'demo' . ($item->product_id % 4 + 1) . '.jpg') }}"
                                                alt="{{ $item->product_name }}">
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white">{{ $item->product_name }}</h4>
                                            {{-- <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Some descriptive text</p> --}} {{-- Example description, can be added if product details are needed in cart --}}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-warm-black dark:text-warm-white">
                                    ₦{{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-warm-black dark:text-warm-white text-center">
                                    <div class="flex items-center justify-center">
                                        <button onclick="updateQuantity({{ $item->product_id }}, -1)" aria-label="Decrease Quantity"
                                            class="quantity-btn bg-soft-sand-beige dark:bg-muted-sage-green hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold text-warm-black dark:text-warm-white font-bold py-2 px-3 rounded-l-xl focus:outline-none transition-colors duration-200">-</button>
                                        <input type="number" disabled
                                            class="quantity-input shadow-sm appearance-none border border-soft-sand-beige dark:border-muted-sage-green rounded-none w-16 py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:shadow-outline text-center"
                                            min="1" value="{{ $item->quantity }}" data-product-id="{{ $item->product_id }}"
                                            data-product-price="{{ $item->price }}" aria-label="Product Quantity">
                                        <button onclick="updateQuantity({{ $item->product_id }}, 1)" aria-label="Increase Quantity"
                                            class="quantity-btn bg-soft-sand-beige dark:bg-muted-sage-green hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold text-warm-black dark:text-warm-white font-bold py-2 px-3 rounded-r-xl focus:outline-none transition-colors duration-200">+</button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-warm-black dark:text-warm-white text-right">
                                    ₦<span class="total-class"
                                        id="total_{{ $item->product_id }}">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-medium">
                                    <button onclick="removeItem({{ $item->product_id }})" aria-label="Remove Item"
                                        class="remove-btn text-muted-sage-green dark:text-muted-sage-green-darker hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="cartTableFooter" class="bg-transparent"> {{-- Changed footer background to transparent --}}
                        <tr>
                            <td colspan="5" class="px-6 py-4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div id="emptyCartMessage" class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10 text-center {{ count($cartItems) > 0 ? 'hidden' : '' }}">
                <p class="text-lg text-warm-black dark:text-warm-white mb-6">Your cart is currently empty.</p>
                <a href="/products"
                    class="inline-block bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker transition-colors duration-200">Shop
                    Now</a>
            </div>
        </section>

        <section id="cartSummarySection" class="bg-warm-white dark:bg-warm-black shadow-md rounded-xl p-10">
            <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-8">Order Summary</h2>
            <div class="flex justify-between mb-4">
                <span class="font-medium text-warm-black dark:text-warm-white">Subtotal:</span>
                <span class="text-warm-black dark:text-warm-white">₦<span
                        id="cartSubtotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="flex justify-between mb-4">
                <span class="font-medium text-warm-black dark:text-warm-white">Shipping:</span>
                <span class="text-warm-black dark:text-warm-white">Calculated at checkout</span>
            </div>
            <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-8 flex justify-between">
                <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
                <span class="text-xl font-bold text-warm-black dark:text-warm-white">₦<span
                        id="cartTotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="mt-10">
                <a href="/checkout" id="checkoutButton"
                    class="block text-center bg-antique-gold hover:bg-antique-gold-darker text-warm-black font-bold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-antique-gold focus:ring-offset-1 transition-colors duration-200 dark:bg-muted-sage-green dark:text-warm-white dark:hover:bg-muted-sage-green-darker">
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
            const cartTableBody = document.getElementById('cartTableBody');
            const cartTableFooter = document.getElementById('cartTableFooter');
            const emptyCartMessage = document.getElementById('emptyCartMessage');


            const updateCartVisibility = () => {
                if (cartTableBody.querySelectorAll('tr').length > 0) {
                    cartItemsContainer.classList.remove('hidden');
                    cartSummarySection.classList.remove('hidden');
                    emptyCartMessage.classList.add('hidden');
                } else {
                    cartItemsContainer.classList.add('hidden');
                    cartSummarySection.classList.add('hidden');
                    emptyCartMessage.classList.remove('hidden');
                }
            };

            updateCartVisibility();


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
                    const price = parseFloat(span.textContent.replace(/,/g, ''));
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
            }


            document.querySelectorAll("a").forEach(elem => {
                elem.addEventListener('click', () => {
                    if(cartChanges.update.length > 0 || cartChanges.remove.length > 0){
                        elem.href = elem.getAttribute("href") + "?update-cart=" + encodeURI(JSON.stringify(cartChanges));
                        localStorage.removeItem("cartCount");
                    }
                });
            });

            window.removeItem = (productId) => {
                const cartItemRow = document.querySelector(`input[data-product-id="${productId}"]`).closest('tr');
                cartItemRow.remove();
                changeLog = { productId: productId };
                cartChanges.remove.push(changeLog);
                localStorage.setItem("cartChanges", JSON.stringify(cartChanges));
                updateCartVisibility();
            };

        });
    </script>
@endsection