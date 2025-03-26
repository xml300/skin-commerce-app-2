@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout file --}}

@section('content')



  <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
         Dashboard Overview
     </h1>


    <!-- Dashboard Overview Section -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-6 mb-8">
        {{-- Adjusted grid columns for potentially more cards --}}

        {{-- Card 1: Total Revenue --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-800/50 rounded-lg p-3">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Revenue</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                        ₦{{ number_format($totalRevenue, 2) }}
                    </dd>
                    {{-- Optional: Comparison text --}}
                    {{-- <p class="text-xs text-green-600 dark:text-green-400 mt-1">+15% vs last month</p> --}}
                </div>
            </div>
        </div>

        {{-- Card 2: Total Orders --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-800/50 rounded-lg p-3">
                    <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalOrders }}</dd>
                    {{-- <p class="text-xs text-green-600 dark:text-green-400 mt-1">+8% vs last month</p> --}}
                </div>
            </div>
        </div>

        {{-- Card 3: New Customers --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-800/50 rounded-lg p-3">
                    <i class="fas fa-users text-yellow-600 dark:text-yellow-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">New Customers</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $newCustomers }}</dd>
                     {{-- <p class="text-xs text-green-600 dark:text-green-400 mt-1">+22% vs last month</p> --}}
                </div>
            </div>
        </div>

        {{-- Card 4: Products in Stock --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-red-100 dark:bg-red-800/50 rounded-lg p-3">
                    <i class="fas fa-box-open text-red-600 dark:text-red-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Products in Stock</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $productsInStock }}</dd>
                    {{-- <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Updated recently</p> --}}
                </div>
            </div>
        </div>

        {{-- Card 5: Average Order Value --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-800/50 rounded-lg p-3">
                    <i class="fas fa-percentage text-purple-600 dark:text-purple-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Average Order Value</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                        ₦{{ number_format($averageOrderValue, 2) }}
                    </dd>
                     {{-- <p class="text-xs text-red-600 dark:text-red-400 mt-1">-2% vs last month</p> --}}
                </div>
            </div>
        </div>

        {{-- Card 6: Top Selling Product --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-800/50 rounded-lg p-3">
                    <i class="fas fa-star text-orange-600 dark:text-orange-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Top Selling Product</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white truncate" title="{{ $topSellingProduct ? $topSellingProduct->product_name : 'N/A' }}">
                        {{ $topSellingProduct ? $topSellingProduct->product_name : 'N/A' }}
                    </dd>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $topSellingProduct ? $topSellingProduct->order_items_count . ' units sold' : '' }}
                    </p>
                </div>
            </div>
        </div>

    </section>

    {{-- Recent Orders Section --}}
    <section class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Recent Orders
            </h2>
            <a href="{{ route('admin.orders') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                View All Orders →
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                     {{-- Use a shorter, non-encrypted ID for display if preferred, or keep encryption --}}
                                     {{-- #{{ $order->id }} --}}
                                     #{{ strtoupper(substr(Crypt::encrypt($order->id),0, 20)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $order->user->fullName() ?? 'N/A' }} {{-- Safer access with null coalesce --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $order->created_at->format('M d, Y') }} {{-- More readable date format --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{-- Status Badge Example - Customize colors as needed --}}
                                    @php
                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100'; // Default
                                        if ($order->order_status == 'completed') {
                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100';
                                        } elseif ($order->order_status == 'processing') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100';
                                        } elseif ($order->order_status == 'pending') {
                                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100';
                                        } elseif ($order->order_status == 'cancelled' || $order->order_status == 'failed') {
                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100';
                                        }
                                    @endphp
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    ₦{{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    No recent orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Product List Section --}}
    <section>
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Product List
            </h2>
            {{-- Use primary color (Indigo) for Add button --}}
            <a href="{{ route('admin.products') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                View All Products →
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price (₦)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($products as $product)
                            <tr id="product-row-{{ $product->id }}"> {{-- Add unique ID to row for easy removal/update --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $product->product_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $product->category->category_name ?? 'N/A' }} {{-- Assuming relationship is 'category' --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                     {{-- Edit Button --}}
                                    <button
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:bg-yellow-700 dark:text-yellow-100 dark:hover:bg-yellow-600 dark:focus:ring-offset-gray-800 edit-btn"
                                        data-product-id="{{ $product->id }}">
                                        <i class="fas fa-pencil-alt w-3 h-3 mr-1"></i> Edit
                                    </button>
                                     {{-- DELETE Button (Using JS/API approach) --}}
                                     {{-- If sticking with form submit, keep the form --}}
                                    {{-- <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-700 dark:text-red-100 dark:hover:bg-red-600 dark:focus:ring-offset-gray-800">
                                            <i class="fas fa-trash-alt w-3 h-3 mr-1"></i> Delete
                                        </button>
                                     </form> --}}

                                     {{-- JS-Based Delete Button --}}
                                    <button type="button"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-700 dark:text-red-100 dark:hover:bg-red-600 dark:focus:ring-offset-gray-800 delete-btn"
                                        data-product-id="{{ $product->id }}">
                                        <i class="fas fa-trash-alt w-3 h-3 mr-1"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                             <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    No products found. Add one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             {{-- Optional: Add Pagination Links if you paginate products --}}
             <div class="mt-4 px-6 pb-4">
                 {{ $products->links() }}
             </div>
        </div>
    </section>

    @include('layouts.admin.product_modal')
@endsection

@push('scripts') {{-- Or include directly in a <script> tag after the modal --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Modal Elements ---
        const addProductModal = document.getElementById("addProductModal");
        const productForm = document.getElementById("addProductForm");
        const modalTitle = document.getElementById("modal-title");
        const modalSubmitButton = document.getElementById("modalAddProductButton"); // Changed ID for clarity
        const modalCancelButton = document.getElementById("modalCancelButton");
        const productIdInput = document.getElementById("product_id_input"); // Hidden input for ID
        const productImageContainer = document.getElementById("prod_img_container");
        const productImagePlaceholder = document.getElementById("prod_img_placeholder");
        const productImageInput = document.getElementById("product_image");
        const currentImagePathInput = document.getElementById("current_image_path"); // Hidden input for existing image path
        const currentImageDisplay = document.getElementById("current_image_display"); // Paragraph to show current image name
        const formErrorsContainer = document.getElementById("formErrors"); // Div to display form errors

        // --- Main Page Elements ---
        const addProductButton = document.getElementById("addProductButton"); // Button to open modal for adding
        const productTableBody = document.getElementById("productTableBody"); // Table body for event delegation

        // --- State ---
        let editingProductId = null; // Track if we are editing

        // --- CSRF Token ---
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // --- Helper to clear form errors ---
        const clearFormErrors = () => {
            if (formErrorsContainer) {
                formErrorsContainer.innerHTML = '';
                formErrorsContainer.classList.add('hidden');
            }
            // Clear individual field errors (optional, depends on your error handling style)
            productForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            productForm.querySelectorAll('.error-message').forEach(el => el.remove());
        };

       

        // --- Function to Open Modal ---
        const openModal = (isEdit = false, productData = null) => {
            clearFormErrors(); // Clear errors when opening
            productForm.reset(); // Clear previous form data
            editingProductId = null;
            productIdInput.value = "";
            currentImagePathInput.value = "";
            currentImageDisplay.textContent = "";
            productImageContainer.style.backgroundImage = 'none'; // Clear preview
            productImagePlaceholder.classList.remove('hidden'); // Show placeholder

            // Remove existing _method input if present
            const existingMethodInput = productForm.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
            }

            if (isEdit && productData) {
                // --- EDIT MODE ---
                editingProductId = productData.id;
                modalTitle.textContent = "Edit Product";
                modalSubmitButton.textContent = "Save Changes";
                productIdInput.value = productData.id;

                // Populate standard fields
                document.getElementById("product_name").value = productData.product_name || '';
                document.getElementById("description").value = productData.description || '';
                document.getElementById("price").value = productData.price || '';
                document.getElementById("category_id").value = productData.category_id || '';

                // Handle existing image preview and path
                if (productData.image_url) { // Assuming your API returns image_url
                    productImageContainer.style.backgroundImage = `url(${productData.image_url})`;
                    productImagePlaceholder.classList.add('hidden');
                    // Store the path/filename to potentially keep it if no new image is uploaded
                    currentImagePathInput.value = productData.image_path || productData.image_url; // Store path/filename
                     if (productData.image_url) {
                         const filename = productData.image_url.split('/').pop();
                         currentImageDisplay.textContent = `Current: ${filename}`; // Display filename
                     }
                }

                // Add method spoofing for PUT/PATCH request
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT'; // Or PUT, depending on your API/routes
                productForm.appendChild(methodInput);

                // Update form action URL for editing
                productForm.action = `/api/admin/products/${productData.id}`; // <<< ADJUST API ROUTE
            } else {
                // --- ADD MODE ---
                modalTitle.textContent = "Add New Product";
                modalSubmitButton.textContent = "Add Product";
                productForm.action = `{{ route('admin.products.store') }}`; // Use Blade route helper for default
            }

            // Show the modal
            if (addProductModal) {
                addProductModal.classList.remove('hidden');
                addProductModal.classList.add('flex'); // Use flex for centering layout
                console.log("Modal opened for", isEdit ? `edit (ID: ${productData?.id})` : "add");
            }
        };

        // --- Function to Close Modal ---
        window.closeModal = () => { // Make global if using onclick="closeModal()" in HTML
            if (addProductModal) {
                addProductModal.classList.add('hidden');
                addProductModal.classList.remove('flex');
                console.log("Modal closed");
            }
            // Reset form state completely
            clearFormErrors();
            productForm.reset();
            editingProductId = null;
            productIdInput.value = "";
            currentImagePathInput.value = "";
            currentImageDisplay.textContent = "";
            productImageContainer.style.backgroundImage = 'none';
            productImagePlaceholder.classList.remove('hidden');
            // Remove _method input if it exists
            const existingMethodInput = productForm.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
            }
            // Reset action to default store action
            productForm.action = `{{ route('admin.products.store') }}`;
        };

        // --- Image Preview Handler ---
        if (productImageInput && productImageContainer && productImagePlaceholder) {
            productImageInput.addEventListener("change", () => {
                const file = productImageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        productImageContainer.style.backgroundImage = `url(${e.target.result})`;
                        productImagePlaceholder.classList.add('hidden'); // Hide placeholder
                    }
                    reader.readAsDataURL(file);
                    currentImageDisplay.textContent = ''; // Clear current image text
                } else {
                    // Revert or clear preview
                    const currentImageUrl = currentImagePathInput.value;
                    if (editingProductId && currentImageUrl) {
                         productImageContainer.style.backgroundImage = `url(${currentImageUrl})`; // Restore existing
                         productImagePlaceholder.classList.add('hidden');
                         currentImageDisplay.textContent = `Current: ${currentImageUrl.split('/').pop()}`;
                    } else {
                        productImageContainer.style.backgroundImage = 'none'; // Clear
                        productImagePlaceholder.classList.remove('hidden'); // Show placeholder
                        currentImageDisplay.textContent = '';
                    }
                }
            });
        }

        // --- Event Listener for "Add Product" Button ---
        if (addProductButton) {
            addProductButton.addEventListener('click', () => {
                openModal(false); // Open in 'Add' mode
            });
        }

        // --- Event Listener for Modal Cancel Button ---
        if (modalCancelButton) {
            modalCancelButton.addEventListener('click', closeModal);
        }

        // --- Form Submission Handler (AJAX) ---
        if (productForm) {
            productForm.addEventListener('submit', async function(event) {
                clearFormErrors(); // Clear previous errors
                modalSubmitButton.disabled = true; // Prevent double clicks
                modalSubmitButton.textContent = 'Processing...'; // Indicate processing
            });
        }


        // --- Event Delegation for Table Edit/Delete Buttons ---
        if (productTableBody) {
            productTableBody.addEventListener("click", async (event) => {
                const editButton = event.target.closest(".edit-btn");
                const deleteButton = event.target.closest(".delete-btn");

                // --- EDIT ACTION ---
                if (editButton) {
                    const productId = editButton.dataset.productId;
                    console.log("Edit button clicked for product ID:", productId);
                    editButton.disabled = true; // Prevent double clicks while fetching

                    try {
                        // Fetch existing product data from an API endpoint
                        const response = await fetch(`/api/products/${productId}`, { // <<< ADJUST API ROUTE
                             headers: { 'Accept': 'application/json' }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const productData = await response.json();
                        console.log("Fetched product data:", productData);
                        openModal(true, productData); // Open modal in 'Edit' mode

                    } catch (error) {
                        console.error("Error fetching product for edit:", error);
                        alert("Failed to load product data. Please check the console and API endpoint.");
                        // Optionally show a flash message instead of alert
                    } finally {
                        editButton.disabled = false; // Re-enable button
                    }
                }

                // --- DELETE ACTION ---
                else if (deleteButton) {
                    const productId = deleteButton.dataset.productId;
                    console.log("Delete button clicked for product ID:", productId);

                    if (confirm("Are you sure you want to delete this product? This action cannot be undone.")) {
                        deleteButton.disabled = true; // Prevent double clicks
                        try {
                            if (!csrfToken) throw new Error("CSRF token not found!");

                            // Send DELETE request to API endpoint
                            const response = await fetch(`/api/products/${productId}`, { // <<< ADJUST API ROUTE
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                }
                            });

                            if (response.ok) {
                                // Remove the row from the table visually
                                const row = document.getElementById(`product-row-${productId}`);
                                if (row) row.remove();
                                console.log("Product deleted successfully");
                                // Optionally show a success flash message dynamically
                                // showFlashMessage('success', 'Product deleted successfully.');
                                alert('Product deleted successfully.'); // Simple feedback

                            } else {
                                const errorData = await response.json().catch(() => ({})); // Gracefully handle non-JSON
                                const errorMessage = errorData.message || `Server responded with status: ${response.status}`;
                                throw new Error(errorMessage);
                            }
                        } catch (error) {
                            console.error("Error deleting product:", error);
                            alert(`Failed to delete product: ${error.message}`);
                            // Optionally show error flash message
                        } finally {
                            deleteButton.disabled = false; // Re-enable button
                        }
                    }
                }
            });
        }

        // --- Optional: Function to dynamically show flash message ---
        /*
        function showFlashMessage(type, message) {
            const container = document.querySelector('.space-y-4'); // Adjust selector if needed
            if (!container) return;

            // Remove existing dynamic messages if any
            container.querySelectorAll('.dynamic-flash').forEach(el => el.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `dynamic-flash relative rounded-lg p-4 text-sm border mb-4`; // Base classes
            alertDiv.setAttribute('role', 'alert');
            alertDiv.setAttribute('x-data', '{ show: true }');
            alertDiv.setAttribute('x-show', 'show');
            alertDiv.setAttribute('x-transition:leave', 'transition ease-in duration-300');
            alertDiv.setAttribute('x-transition:leave-start', 'opacity-100');
            alertDiv.setAttribute('x-transition:leave-end', 'opacity-0');

            let bgColor, textColor, borderColor, iconClass, title;

            switch (type) {
                case 'success':
                    bgColor = 'bg-green-100 dark:bg-green-900/60';
                    textColor = 'text-green-700 dark:text-green-200';
                    borderColor = 'border-green-200 dark:border-green-700';
                    title = 'Success!';
                    break;
                case 'error':
                    bgColor = 'bg-red-100 dark:bg-red-900/60';
                    textColor = 'text-red-700 dark:text-red-200';
                    borderColor = 'border-red-200 dark:border-red-700';
                    title = 'Error!';
                    break;
                // Add cases for 'warning', 'info'
                default:
                    bgColor = 'bg-blue-100 dark:bg-blue-900/60';
                    textColor = 'text-blue-700 dark:text-blue-200';
                    borderColor = 'border-blue-200 dark:border-blue-700';
                    title = 'Info:';
            }

            alertDiv.classList.add(bgColor, textColor, borderColor);

            alertDiv.innerHTML = `
                <span class="font-medium">${title}</span> ${message}
                <button @click="show = false; $el.parentNode.remove()" type="button" class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8 ${bgColor} ${textColor.replace('text-', 'hover:text-')} ${textColor.replace('dark:text-', 'dark:hover:text-white')} focus:ring-${type === 'error' ? 'red' : (type === 'success' ? 'green' : 'blue')}-400" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            `;

            container.prepend(alertDiv); // Add message to the top

             // If you dynamically added an Alpine component, you need to initialize it
             // This might require more advanced Alpine setup or simply relying on page reload
        }
        */

    });// End DOMContentLoaded
</script>
@endpush