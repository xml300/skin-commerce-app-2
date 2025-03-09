@include('layouts.user.header', ['title' => 'Skincare Shop - Product Details'])

    <main class="container mx-auto p-4 md:p-8 lg:p-10 min-h-[75vh]">
        <div id="productDetail" class="bg-white dark:bg-green-950 rounded-lg shadow-md overflow-hidden">
            <!-- Product details will be loaded here by JavaScript -->
            <div class="p-6">Loading product details...</div>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productDetailContainer = document.getElementById('productDetail');
            const productId = window.location.pathname.split('/').pop(); // Extract product ID from URL
            const addToCart = (productId) => {
                console.log(productId);
                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const existingItemIndex = cart.findIndex(item => item.productId === productId);
                cart.forEach(item => console.log(item, item.productId))
                console.log(cart, existingItemIndex, productId);
                if (existingItemIndex > -1) {
                    cart[existingItemIndex].quantity += 1;
                } else {
                    cart.push({ productId: productId, quantity: 1 });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCounter(); // Update cart counter in header
                alert('Product added to cart!'); // Basic feedback
            };


            const fetchProduct = async () => {
                try {
                    const response = await fetch(`/api/products/${productId}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const product = await response.json();
                    displayProduct(product);
                    document.querySelector(".cart-btn").addEventListener("click", () => {
                        addToCart(product.id);
                    })
                } catch (error) {
                    console.error('Error fetching product details:', error);
                    productDetailContainer.innerHTML = '<div class="p-6">Failed to load product details.</div>';
                }
            };

            const displayProduct = (product) => {
                productDetailContainer.innerHTML = `
                    <div class="md:flex">
                        <div class="md:w-1/2">
                            <img class="w-full h-full object-cover" src="${product['product_images'] }" alt="${product['product_name'] }">
                        </div>
                        <div class="md:w-1/2 p-6">
                            <h1 class="text-2xl font-bold text-green-900 dark:text-white mb-2">${product['product_name'] }</h1>
                            <p class="text-green-700 dark:text-gray-300 mb-4">${product['description'] }</p>
                            <p class="text-xl font-semibold text-green-900 dark:text-white mb-4">₦${product['price'] }</p>
                            <button class="cart-btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-black dark:text-green-700 dark:hover:text-white dark:hover:bg-green-800">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                `;
            };


            fetchProduct();
        });
    </script>

@include('layouts.user.footer')