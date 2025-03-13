@extends('layouts.user.user_dashboard')
@section('title')
    Stara - Cart</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]"> {{-- Consistent padding and min-height --}}
        <header class="mb-12"> {{-- Increased margin bottom for better spacing --}}
            <h1 class="text-3xl font-bold text-warm-black dark:text-warm-white mb-4">Shopping Cart</h1> {{-- Heading style and margin --}}
        </header>

        <section id="cartItemsSection" class="mb-12"> {{-- Increased margin bottom for section spacing --}}
            <div id="cartItemsContainer" class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg overflow-hidden"> {{-- Cart container styling --}}
                <table class="min-w-full table-fixed leading-normal"> {{-- `table-fixed` for consistent layout --}}
                    <thead class="bg-soft-sand-beige dark:bg-warm-black"> {{-- Header background color --}}
                        <tr>
                            <th
                                class="px-6 py-3 border-b border-soft-sand-beige dark:border-muted-sage-green text-left text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider"> {{-- Increased px for padding --}}
                                Product</th>
                            <th
                                class="px-6 py-3 border-b border-soft-sand-beige dark:border-muted-sage-green text-left text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider"> {{-- Increased px for padding --}}
                                Price</th>
                            <th
                                class="px-6 py-3 border-b border-soft-sand-beige dark:border-muted-sage-green text-center text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider"> {{-- Increased px for padding, centered text --}}
                                Quantity</th>
                            <th
                                class="px-6 py-3 border-b border-soft-sand-beige dark:border-muted-sage-green text-right text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider"> {{-- Increased px for padding, right-aligned text --}}
                                Total</th>
                            <th
                                class="px-6 py-3 border-b border-soft-sand-beige dark:border-muted-sage-green text-right text-sm font-semibold text-warm-black dark:text-warm-white uppercase tracking-wider"> {{-- Increased px for padding, right-aligned text --}}
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <!-- Cart items will be loaded here by JavaScript -->
                        @foreach ($cartItems as $item)
                            <tr class="hover:bg-soft-sand-beige/50 dark:hover:bg-warm-black/50 transition-colors duration-100"> {{-- Hover effect on rows --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-warm-black dark:text-warm-white"> {{-- Increased px for padding --}}
                                    <div class="flex items-center">
                                        <div class="mr-4"> {{-- Increased mr for spacing --}}
                                            <img class="w-20 h-20 object-cover rounded" {{-- Increased image size --}}
                                                src="{{ asset('images/' . 'demo' . ($item->product_id % 4 + 1) . '.jpg') }}"
                                                alt="{{ $item->product_name }}">
                                        </div>
                                        <div>{{ $item->product_name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-warm-black dark:text-warm-white"> {{-- Increased px for padding --}}
                                    ₦{{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-warm-black dark:text-warm-white text-center"> {{-- Increased px for padding, centered text --}}
                                    <div class="flex items-center justify-center">
                                        <button onclick="updateQuantity({{ $item->product_id }}, -1)" aria-label="Decrease Quantity" {{-- Added aria-label for accessibility --}}
                                            class="quantity-btn bg-soft-sand-beige dark:bg-muted-sage-green hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold-darker text-warm-black dark:text-warm-white font-bold py-2 px-3 rounded-l-md focus:outline-none transition-colors duration-200">-</button> {{-- Updated button styles and added transition --}}
                                        <input type="number" disabled
                                            class="quantity-input shadow-sm appearance-none border border-soft-sand-beige dark:border-muted-sage-green rounded-none w-16 py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:shadow-outline text-center"
                                            min="1" value="{{ $item->quantity }}" data-product-id="{{ $item->product_id }}"
                                            data-product-price="{{ $item->price }}" aria-label="Product Quantity"> {{-- Added aria-label for accessibility --}}
                                        <button onclick="updateQuantity({{ $item->product_id }}, 1)" aria-label="Increase Quantity" {{-- Added aria-label for accessibility --}}
                                            class="quantity-btn bg-soft-sand-beige dark:bg-muted-sage-green hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold-darker text-warm-black dark:text-warm-white font-bold py-2 px-3 rounded-r-md focus:outline-none transition-colors duration-200">+</button> {{-- Updated button styles and added transition --}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-warm-black dark:text-warm-white text-right"> {{-- Increased px for padding, right-aligned text --}}
                                    ₦<span class="total-class"
                                        id="total_{{ $item->product_id }}">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium"> {{-- Increased px for padding, right-aligned text --}}
                                    <button onclick="removeItem({{ $item->product_id }})" aria-label="Remove Item" {{-- Added aria-label for accessibility --}}
                                        class="remove-btn text-muted-sage-green hover:text-muted-sage-green-darker dark:text-muted-sage-green dark:hover:text-antique-gold-darker transition-colors duration-200">Remove</button> {{-- Updated button style and added transition --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="cartTableFooter" class="bg-soft-sand-beige dark:bg-warm-black">
                        <tr>
                            <td colspan="5" class="px-6 py-3"></td> {{-- Empty cell for spacing --}}
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div id="emptyCartMessage" class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg p-8 text-center {{ count($cartItems) > 0 ? 'hidden' : '' }}"> {{-- Padding and conditional hidden class --}}
                <p class="text-lg text-warm-black dark:text-warm-white mb-4">Your cart is empty.</p> {{-- Larger text and margin --}}
                <a href="/products"
                    class="inline-block bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-bold py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 dark:bg-antique-gold dark:text-warm-black dark:hover:bg-antique-gold-darker transition-colors duration-200">Shop {{-- Updated button style and padding, added transition --}}
                    Now</a>
            </div>
        </section>

        <section id="cartSummarySection" class="bg-warm-white dark:bg-warm-black shadow-md rounded-lg p-8"> {{-- Padding increased --}}
            <h2 class="text-xl font-semibold text-warm-black dark:text-warm-white mb-6">Order Summary</h2> {{-- Increased margin bottom --}}
            <div class="flex justify-between mb-3"> {{-- Reduced margin bottom --}}
                <span class="font-semibold text-warm-black dark:text-warm-white">Subtotal:</span>
                <span class="text-warm-black dark:text-warm-white">₦<span
                        id="cartSubtotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="flex justify-between mb-3"> {{-- Reduced margin bottom --}}
                <span class="font-semibold text-warm-black dark:text-warm-white">Shipping:</span>
                <span class="text-warm-black dark:text-warm-white">Calculated at checkout</span>
            </div>
            <div class="border-t border-soft-sand-beige dark:border-muted-sage-green pt-6 flex justify-between"> {{-- Increased pt --}}
                <span class="text-xl font-bold text-warm-black dark:text-warm-white">Total:</span>
                <span class="text-xl font-bold text-warm-black dark:text-warm-white">₦<span
                        id="cartTotal">{{ number_format($cartSubTotal, 2) }}</span></span>
            </div>
            <div class="mt-8"> {{-- Increased mt --}}
                <a href="/checkout" id="checkoutButton"
                    class="block text-center bg-antique-gold hover:bg-antique-gold-darker text-warm-black font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-antique-gold focus:ring-offset-1 transition-colors duration-200 dark:bg-muted-sage-green dark:text-warm-white dark:hover:bg-muted-sage-green-darker"> {{-- Updated button style and padding, using antique gold as primary, and muted sage green for dark mode, added transition --}}
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
                if (cartTableBody.querySelectorAll('tr').length > 0) { // Check if table has rows (cart items)
                    cartItemsContainer.classList.remove('hidden');
                    cartSummarySection.classList.remove('hidden');
                    emptyCartMessage.classList.add('hidden');
                } else {
                    cartItemsContainer.classList.add('hidden');
                    cartSummarySection.classList.add('hidden');
                    emptyCartMessage.classList.remove('hidden');
                }
            };

            updateCartVisibility(); // Initial visibility check


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
                cartItemRow.remove(); // Remove the row from the DOM
                changeLog = { productId: productId };
                cartChanges.remove.push(changeLog);
                localStorage.setItem("cartChanges", JSON.stringify(cartChanges));
                updateCartVisibility(); // Update visibility after removing item
            };

        });
    </script>
@endsection