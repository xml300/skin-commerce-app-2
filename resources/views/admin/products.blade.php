@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

@section('content')
    {{-- Page Header: Title and Add Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Product Management
        </h1>
        {{-- Add New Product Button (links to create page) --}}
        <button id="addProductButton"
            type="button" {{-- Assuming a route named 'admin.products.create' --}}
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Product
        </button>

    </div>

    {{-- Product List Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        {{-- Optional: Card Header for Filters/Search --}}
        {{-- <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white whitespace-nowrap">All Products</h3>
            <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2"> --}}
                {{-- Filter Dropdown (Example) --}}
                {{-- <select class="block w-full sm:w-auto border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">All Categories</option> --}}
                    {{-- @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach --}}
                {{-- </select> --}}
                 {{-- Search Input --}}
                {{-- <div class="relative w-full sm:w-64">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                         <i class="fas fa-search text-gray-400"></i>
                     </span>
                     <input type="search" placeholder="Search products..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                 </div>
            </div>
        </div> --}}

        {{-- Table Container for Responsiveness --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3">Image</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col" class="px-6 py-3 text-right">Price</th>
                        <th scope="col" class="px-6 py-3 text-center">Stock</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through products --}}
                    @forelse($products as $product) {{-- Assuming you pass $products from controller --}}
                        <tr x-data="{}" class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            {{-- Image --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $product->image_url ?? asset('images/placeholder_product.png') }}" {{-- Use accessor or placeholder --}}
                                     alt="{{ $product->product_name }}"
                                     class="h-12 w-12 object-cover rounded-md shadow-sm bg-gray-200 dark:bg-gray-600">
                            </td>
                            {{-- Name --}}
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $product->product_name }}
                                {{-- Optional: Description Snippet --}}
                                {{-- <p class="text-xs text-gray-500 dark:text-gray-400 truncate w-64">{{ $product->description }}</p> --}}
                            </td>
                            {{-- Category --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $product->category->category_name ?? 'N/A' }} {{-- Assumes category relationship loaded --}}
                            </td>
                            {{-- Price --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                            ₦{{ number_format($product->price, 2) }}
                            </td>
                            {{-- Stock --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @php
                                    $stock = $product->stock_quantity ?? 0;
                                    $stockColor = match (true) {
                                        $stock <= 0 => 'text-red-600 dark:text-red-400 font-semibold',
                                        $stock <= 10 => 'text-yellow-600 dark:text-yellow-400 font-semibold',
                                        default => 'text-green-600 dark:text-green-400',
                                    };
                                @endphp
                                <span class="{{ $stockColor }}">{{ $stock }}</span>
                            </td>
                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    // Assuming a status field like 'published', 'draft', 'archived'
                                    $status = strtolower($product->status ?? 'draft');
                                    $statusBadge = match($status) {
                                        'published' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                        'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                        'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            {{-- Action Buttons --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                     {{-- View Action (Optional) --}}
                                    <a href="{{ route('admin.products.details', $product->id) }}" {{-- Example route to frontend view --}}
                                       target="_blank" {{-- Open in new tab --}}
                                       class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-150"
                                       title="View on Storefront">
                                        <i class="fas fa-external-link-alt fa-fw"></i>
                                    </a>
                                    {{-- Edit Action --}}
                                    <a href="{{ route('admin.products.edit', $product->id) }}" {{-- Route to admin edit page --}}
                                       class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-150"
                                       title="Edit Product">
                                        <i class="fas fa-pencil-alt fa-fw"></i>
                                    </a>
                                    {{-- Delete Action --}}
                                    
                                    <button type="button"
        {{-- Dispatch an event with the product's ID and name --}}
        @click="console.log('Delete button clicked. ID:', {{ $product->id }});
            $dispatch('open-delete-confirm-modal', {
            id: {{ $product->id }},
            name: '{{ e(addslashes($product->product_name)) }}'
        })"
        class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-150"
        title="Delete Product">
    <i class="fas fa-trash-alt fa-fw"></i>
</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- State when no products are found --}}
                        <tr>
                            <td colspan="7" {{-- Adjust colspan based on the number of columns --}} class="text-center px-6 py-16">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-box-open fa-4x mb-4"></i>
                                    <p class="text-xl font-medium mb-1">No Products Found</p>
                                    <p class="text-sm mb-4">There are currently no products listed.</p>
                                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> {{-- End overflow-x-auto --}}

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $products->links() }} {{-- Ensure pagination views are styled for Tailwind --}}
            </div>
        @endif

    </div> {{-- End Card --}}

    @include('layouts.admin.product_modal')
    @include('layouts.admin.delete_product_modal')

@endsection

{{-- Tips
4. Pagination Views: Publish and customize Laravel's pagination views for Tailwind: `php artisan vendor:publish --tag=laravel-pagination`
--}}

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