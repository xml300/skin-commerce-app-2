@extends('layouts.admin.admin_dashboard')
@section('content')
    <div class="container mx-auto p-4 md:p-8 lg:p-10">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                Admin Dashboard {{-- General Dashboard Title --}}
            </h1>
        </header>

        <!-- Dashboard Overview Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Dashboard Cards with real data -->
            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Revenue</dt>
                        <dd class="text-2xl font-bold text-green-600 dark:text-green-400">
                            ₦{{ number_format($totalRevenue, 2) }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">+15% compared to last month</p> {{-- You'll
                        need to calculate and pass this comparison --}}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shopping-cart text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Orders</dt>
                        <dd class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalOrders }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">+8% compared to last month</p> {{-- You'll
                        need to calculate and pass this comparison --}}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">New Customers</dt>
                        <dd class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $newCustomers }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">+22% compared to last month</p> {{-- You'll
                        need to calculate and pass this comparison --}}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-box-open text-red-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Products in Stock</dt>
                        <dd class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $productsInStock }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Updated recently</p> {{-- You can update
                        this dynamically if needed --}}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-percentage text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Average Order Value</dt>
                        <dd class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            ₦{{ number_format($averageOrderValue, 2) }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">-2% compared to last month</p> {{-- You'll
                        need to calculate and pass this comparison --}}
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-star text-orange-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <dt class="text-lg font-semibold text-gray-700 dark:text-gray-300">Top Selling Product</dt>
                        <dd class="text-xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $topSellingProduct ? $topSellingProduct->product_name : 'N/A' }}</dd>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sales:
                            {{ $topSellingProduct ? $topSellingProduct->order_items_count . ' units this month' : 'N/A' }}
                        </p> {{-- Adjust text as needed --}}
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                    Recent Orders
                </h2>
                <a href="#" class="text-blue-500 dark:text-blue-400 hover:underline">View All Orders</a>
            </div>
            <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Customer
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Order Date
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    #ORDER{{ $order->id }}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ $order->user()->first()->fullName() }} {{-- Assuming you have a customer relationship
                                    --}}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ $order->created_at->format('Y-m-d') }}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm {{ $order->status_class }}">
                                    {{-- You might want to define status classes in your Order model --}}
                                    {{ ucfirst($order->order_status) }} {{-- Assuming you have a 'status' column --}}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    ₦{{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        @if ($recentOrders->isEmpty())
                            <tr>
                                <td colspan="5"
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 text-center">
                                    No recent orders.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                    Product List
                </h2>
                <button id="addProductButton"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 inline-block align-middle mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Product
                </button>
            </div>

            <div id="productList" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Name
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Price(₦)
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Category
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach ($products as $product)
                            <tr>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ $product->product_name }}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td
                                    class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                    {{ strtoupper(substr($product->category_name, 0, 1)) . substr($product->category_name, 1) }}
                                </td>
                                <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm">
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md mr-2 edit-btn dark:bg-yellow-700 dark:hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1"
                                        data-product-id="{{ $product->id }}">Edit</button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md delete-btn dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                                        data-product-id="{{ $product->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Product Modal (No changes needed here) -->


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const productForm = document.getElementById("addProductForm");
            const productTableBody = document.getElementById("productTableBody");
            const darkModeToggle = document.getElementById("darkModeToggle");
            const htmlElement = document.documentElement;

            const addProductButton = document.getElementById("addProductButton");
            const addProductModal = document.getElementById("addProductModal");
            const modalCancelButton = document.getElementById("modalCancelButton");
            const modalAddProductButton = document.getElementById("modalAddProductButton");
            const modalTitle = document.getElementById("modal-title");
            const productIdInput = document.getElementById("product_id_input");

            const productImageContainer = document.querySelector("#prod_img_container");
            const productImage = document.querySelector("input[type='file']");

            let editingProductId = null;

            productImage.addEventListener("change", () => {
                const blob = new Blob([productImage.files[0]]);
                const url = URL.createObjectURL(blob);
                productImageContainer.style.backgroundImage = `url(${url})`;

            })


            const setDarkMode = (isDark) => {
                if (isDark) {
                    htmlElement.classList.add("dark");
                    htmlElement.classList.remove("light");
                    localStorage.setItem("darkMode", "enabled");
                    darkModeToggle.checked = true;
                } else {
                    htmlElement.classList.remove("dark");
                    htmlElement.classList.add("light");
                    localStorage.setItem("darkMode", "disabled");
                    darkModeToggle.checked = false;
                }
            };


            const savedDarkMode = localStorage.getItem("darkMode");
            if (savedDarkMode === "enabled") {
                setDarkMode(true);
            } else if (savedDarkMode === "disabled") {
                setDarkMode(false);
            } else if (
                window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                setDarkMode(true);
            } else {
                setDarkMode(false);
            }


            darkModeToggle.addEventListener("change", () => {
                setDarkMode(darkModeToggle.checked);
            });


            productTableBody.addEventListener("click", async (event) => {
                if (event.target.classList.contains("delete-btn")) {
                    const productId = event.target.dataset.productId;
                    if (confirm("Are you sure you want to delete this product?")) {
                        // Call delete function here - server side form submission for delete needs to be setup
                        // For now, simulating deleteProduct(productId);
                        try {
                            fetch("/api/admin/products" + productId, {
                                method: "DELETE"
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                } else if (event.target.classList.contains("edit-btn")) {
                    const productId = event.target.dataset.productId;
                    console.log(productId, event.target);
                    editingProductId = productId;
                    openEditModal(productId); // Keep openEditModal function but adjust to fetch server-side data if needed
                }
            });


            const openEditModal = async (productId) => {
                modalTitle.textContent = "Edit Product";
                modalAddProductButton.textContent = "Save Changes";
                productIdInput.value = productId;

                // If you need to pre-fill data from server for edit modal, do an AJAX call here to fetch product details
                // and populate form fields. For now, keeping it as is, assuming form will be populated server-side or via different mechanism
                // Example:
                try {
                    const response = await fetch(`/api/products/${productId}`); // Example endpoint to get data for edit
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const product = await response.json();
                    document.getElementById("product_name").value = product.product_name;
                    document.getElementById("description").value = product.description;
                    document.getElementById("price").value = product.price;
                    document.getElementById("category_id").value = product.category_id;
                    addProductModal.classList.remove('hidden');
                    addProductModal.classList.add('flex');
                } catch (error) {
                    console.error("Error fetching product for edit:", error);
                    alert("Failed to fetch product details for editing.");
                    closeModal();
                }
            };


            window.closeModal = () => { // Make closeModal global for onclick
                addProductModal.classList.add('hidden');
                addProductModal.classList.remove('flex');
                productForm.reset();
                editingProductId = null;
                modalTitle.textContent = "Add New Product";
                modalAddProductButton.textContent = "Add Product";
                productIdInput.value = "";
                productImageContainer.style.backgroundImage = ``; // Clear image preview on close

            };

            window.submitForm = () => { // Make submitForm global for onclick
                // In Blade context, the form submission is handled by the form's action and method attributes.
                // No need for JavaScript form submission here if using standard form submission.
                // You might add JavaScript validation here if needed before form submits.

                // For now, just trigger form submit (if needed - onclick on button might be enough to submit form if type="button" is removed/changed to "submit" and form action/method is correctly set)
                // document.getElementById('addProductForm').submit(); // If you want to trigger form submit programmatically, though likely not needed.
                alert('Form submit triggered. Server-side handling needs to be implemented in Laravel controller.'); // Informational alert. Remove in production
            };


            addProductButton.addEventListener('click', () => {
                editingProductId = null;
                modalTitle.textContent = "Add New Product";
                modalAddProductButton.textContent = "Add Product";
                productIdInput.value = "";
                addProductModal.classList.remove('hidden');
                addProductModal.classList.add('flex');
                productImageContainer.style.backgroundImage = ``; // Clear image preview on add new button
            });

            modalCancelButton.addEventListener('click', () => {
                closeModal();
            });

        });
    </script>
@endsection