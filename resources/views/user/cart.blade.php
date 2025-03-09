@include('layouts.user.header', ['title' => 'Skincare Shop - Cart'])

    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-green-900 dark:text-white mb-2">Shopping Cart</h1>
        </header>

        <section id="cartItemsSection" class="mb-8">
            <div id="cartItemsContainer" class="bg-white dark:bg-green-900 shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                            <th class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 border-b-2 border-green-200 bg-green-100 dark:bg-green-800 text-left text-sm font-semibold text-green-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <!-- Cart items will be loaded here by JavaScript -->
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-500 dark:text-gray-300">Loading cart items...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="emptyCartMessage" class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6 text-center hidden">
                <p class="text-green-700 dark:text-gray-300">Your cart is empty.</p>
                <a href="/products" class="inline-block mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-black dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800">Shop Now</a>
            </div>
        </section>

        <section id="cartSummarySection" class="bg-white dark:bg-green-950 shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-green-900 dark:text-white mb-4">Order Summary</h2>
            <div class="flex justify-between mb-2">
                <span class="font-semibold text-green-700 dark:text-gray-300">Subtotal:</span>
                <span id="cartSubtotal" class="text-green-700 dark:text-gray-300">₦0.00</span>
            </div>
            <div class="flex justify-between mb-4">
                <span class="font-semibold text-green-700 dark:text-gray-300">Shipping:</span>
                <span class="text-green-700 dark:text-gray-300">Calculated at checkout</span>
            </div>
            <div class="border-t border-green-200 dark:border-green-600 pt-4 flex justify-between">
                <span class="text-xl font-bold text-green-900 dark:text-white">Total:</span>
                <span id="cartTotal" class="text-xl font-bold text-green-900 dark:text-white">₦0.00</span>
            </div>
            <div class="mt-6">
                <a href="/checkout" id="checkoutButton" class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800">
                    Proceed to Checkout
                </a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartTableBody = document.getElementById('cartTableBody');
            const cartItemsContainer = document.getElementById('cartItemsContainer');
            const emptyCartMessage = document.getElementById('emptyCartMessage');
            const cartSubtotalSpan = document.getElementById('cartSubtotal');
            const cartTotalSpan = document.getElementById('cartTotal');
            const checkoutButton = document.getElementById('checkoutButton');

            let cartItems = JSON.parse(localStorage.getItem('cart') || '[]');

            const displayCartItems = async () => {
                let cartItems = JSON.parse(localStorage.getItem('cart') || '[]');
                cartTableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-500 dark:text-gray-300">Loading cart items...</td></tr>';
                if (cartItems.length === 0) {
                    cartItemsContainer.classList.add('hidden');
                    emptyCartMessage.classList.remove('hidden');
                    cartSubtotalSpan.textContent = '₦0.00';
                    cartTotalSpan.textContent = '₦0.00';
                    checkoutButton.classList.add('hidden');
                    cartTableBody.innerHTML = ''; // Clear loading message if cart is empty after initial load
                    updateCartCounter(); // Update cart counter in header to 0
                    return;
                }

                emptyCartMessage.classList.add('hidden');
                cartItemsContainer.classList.remove('hidden');
                checkoutButton.classList.remove('hidden');
                cartTableBody.innerHTML = ''; // Clear loading message

                let subtotal = 0;

                for (const cartItem of cartItems) {
                    try {
                        const response = await fetch(`/api/products/${cartItem.productId}`);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const product = await response.json();
                        console.log(product, cartItem);
                        const itemTotal = product.price * cartItem.quantity;
                        subtotal += itemTotal;

                        const row = cartTableBody.insertRow();
                        row.innerHTML = `
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-green-900 dark:text-gray-100">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <img src="${product['product_images'] }" alt="${product['product_name'] }" class="w-16 h-16 object-cover rounded">
                                    </div>
                                    <div>${product['product_name'] }</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">₦${product['price']}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">
                                <div class="flex items-center justify-center">
                                    <button onclick="updateQuantity(${product['id'] }, -1)" class="bg-green-200 dark:bg-green-700 hover:bg-green-300 dark:hover:bg-green-600 text-green-700 dark:text-white font-bold py-1 px-2 rounded-l-md focus:outline-none">-</button>
                                    <input type="number" class="shadow-sm appearance-none border border-green-300 rounded-none w-16 py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:shadow-outline text-center quantity-input" min="1" value="${cartItem['quantity'] }" data-product-id="${product['product_id'] }">
                                    <button onclick="updateQuantity(${product['id'] }, 1)" class="bg-green-200 dark:bg-green-700 hover:bg-green-300 dark:hover:bg-green-600 text-green-700 dark:text-white font-bold py-1 px-2 rounded-r-md focus:outline-none">+</button>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-green-700 dark:text-gray-300">₦${itemTotal}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-right font-medium">
                                <button onclick="removeItem(${product['id'] })" class=" w-full h-8 flex items-center text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600">Remove</button>
                            </td>
                        `;
                    } catch (error) {
                        console.error('Error fetching product details for cart item:', error);
                        row.innerHTML = `<td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-red-500 dark:text-red-400">Error loading product details.</td>`;
                    }
                }

                cartSubtotalSpan.textContent = `₦${subtotal}`;
                cartTotalSpan.textContent = `₦${subtotal}`; // For MVP, total is same as subtotal
                updateCartCounter(); // Update cart counter in header
            };

            window.updateQuantity = (productId, change) => {
                console.log(productId, change);
                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const itemIndex = cart.findIndex(item => item.productId === productId);
                if (itemIndex > -1) {
                    let newQuantity = cart[itemIndex].quantity + change;
                    if (newQuantity < 1) newQuantity = 1; // Minimum quantity is 1 for MVP
                    cart[itemIndex].quantity = newQuantity;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    displayCartItems(); // Re-render cart
                }
            };

            window.removeItem = (productId) => {
                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                cart = cart.filter(item => item.productId !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                displayCartItems(); // Re-render cart
            };

            displayCartItems();
        });
    </script>

@include('layouts.user.footer')