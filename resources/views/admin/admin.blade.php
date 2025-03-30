@extends('layouts.admin.admin_dashboard')

@section('content')



    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
        Dashboard Overview
    </h1>


    
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-6 mb-8">
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


                </div>
            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-800/50 rounded-lg p-3">
                    <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalOrders }}</dd>

                </div>
            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-800/50 rounded-lg p-3">
                    <i class="fas fa-users text-yellow-600 dark:text-yellow-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">New Customers</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $newCustomers }}</dd>

                </div>
            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-red-100 dark:bg-red-800/50 rounded-lg p-3">
                    <i class="fas fa-box-open text-red-600 dark:text-red-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Products in Stock</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $productsInStock }}</dd>

                </div>
            </div>
        </div>


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

                </div>
            </div>
        </div>


        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg p-5">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-800/50 rounded-lg p-3">
                    <i class="fas fa-star text-orange-600 dark:text-orange-400 text-xl w-6 h-6 text-center"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Top Selling Product</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white truncate"
                        title="{{ $topSellingProduct ? $topSellingProduct->product_name : 'N/A' }}">
                        {{ $topSellingProduct ? $topSellingProduct->product_name : 'N/A' }}
                    </dd>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $topSellingProduct ? $topSellingProduct->order_items_count . ' units sold' : '' }}
                    </p>
                </div>
            </div>
        </div>

    </section>


    <section class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Recent Orders
            </h2>
            <a href="{{ route('admin.orders') }}"
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                View All Orders →
            </a>
        </div>
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Order ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Customer</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentOrders as $order)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">


                                                    #{{ strtoupper(substr(Crypt::encrypt($order->id), 0, 20)) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $order->user->fullName() ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">

                                                    @php
                                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100'; 
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
                             <span
                                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                        {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    ₦{{ number_format($order->total_amount, 2) }}
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    No recent orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <section>
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Product List
            </h2>

            <a href="{{ route('admin.products') }}"
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                View All Products →
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Price (₦)</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody"
                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($products as $product)
                            <tr id="product-row-{{ $product->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $product->product_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $product->category->category_name ?? 'N/A' }}
                                </td>
                                <td x-data="{}" class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">

                                    <a href="{{ route('admin.products.details', $product->id) }}" target="_blank"
                                        class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-150"
                                        title="View on Storefront">
                                        <i class="fas fa-external-link-alt fa-fw"></i>
                                    </a>

                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-150"
                                        title="Edit Product">
                                        <i class="fas fa-pencil-alt fa-fw"></i>
                                    </a>
                                    
                                    <button type="button" @click="console.log('Delete button clicked. ID:', {{ $product->id }});
                                        $dispatch('open-delete-confirm-modal', {
                                            id: {{ $product->id }},
                                            name: '{{ e(addslashes($product->product_name)) }}'
                                        })"
                                        class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-150"
                                        title="Delete Product">
                                        <i class="fas fa-trash-alt fa-fw"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    No products found. Add one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 px-6 pb-4">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection

@push('modals')
    @include('layouts.admin.delete_product_modal')
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            const addProductModal = document.getElementById("addProductModal");
            const productForm = document.getElementById("addProductForm");
            const modalTitle = document.getElementById("modal-title");
            const modalSubmitButton = document.getElementById("modalAddProductButton"); 
            const modalCancelButton = document.getElementById("modalCancelButton");
            const productIdInput = document.getElementById("product_id_input"); 
            const productImageContainer = document.getElementById("prod_img_container");
            const productImagePlaceholder = document.getElementById("prod_img_placeholder");
            const productImageInput = document.getElementById("product_image");
            const currentImagePathInput = document.getElementById("current_image_path"); 
            const currentImageDisplay = document.getElementById("current_image_display"); 
            const formErrorsContainer = document.getElementById("formErrors"); 

            
            const addProductButton = document.getElementById("addProductButton"); 
            const productTableBody = document.getElementById("productTableBody"); 

            
            let editingProductId = null; 

            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            
            const clearFormErrors = () => {
                if (formErrorsContainer) {
                    formErrorsContainer.innerHTML = '';
                    formErrorsContainer.classList.add('hidden');
                }
                
                productForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                productForm.querySelectorAll('.error-message').forEach(el => el.remove());
            };



            
            const openModal = (isEdit = false, productData = null) => {
                clearFormErrors(); 
                productForm.reset(); 
                editingProductId = null;
                productIdInput.value = "";
                currentImagePathInput.value = "";
                currentImageDisplay.textContent = "";
                productImageContainer.style.backgroundImage = 'none'; 
                productImagePlaceholder.classList.remove('hidden'); 

                
                const existingMethodInput = productForm.querySelector('input[name="_method"]');
                if (existingMethodInput) {
                    existingMethodInput.remove();
                }

                if (isEdit && productData) {
                    
                    editingProductId = productData.id;
                    modalTitle.textContent = "Edit Product";
                    modalSubmitButton.textContent = "Save Changes";
                    productIdInput.value = productData.id;

                    
                    document.getElementById("product_name").value = productData.product_name || '';
                    document.getElementById("description").value = productData.description || '';
                    document.getElementById("price").value = productData.price || '';
                    document.getElementById("category_id").value = productData.category_id || '';

                    
                    if (productData.image_url) { 
                        productImageContainer.style.backgroundImage = `url(${productData.image_url})`;
                        productImagePlaceholder.classList.add('hidden');
                        
                        currentImagePathInput.value = productData.image_path || productData.image_url; 
                        if (productData.image_url) {
                            const filename = productData.image_url.split('/').pop();
                            currentImageDisplay.textContent = `Current: ${filename}`; 
                        }
                    }

                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT'; 
                    productForm.appendChild(methodInput);

                    
                    productForm.action = `/api/admin/products/${productData.id}`; 
                } else {
                    
                    modalTitle.textContent = "Add New Product";
                    modalSubmitButton.textContent = "Add Product";
                    productForm.action = `{{ route('admin.products.store') }}`; 
                }

                
                if (addProductModal) {
                    addProductModal.classList.remove('hidden');
                    addProductModal.classList.add('flex'); 
                    console.log("Modal opened for", isEdit ? `edit (ID: ${productData?.id})` : "add");
                }
            };

            
            window.closeModal = () => { 
                if (addProductModal) {
                    addProductModal.classList.add('hidden');
                    addProductModal.classList.remove('flex');
                    console.log("Modal closed");
                }
                
                clearFormErrors();
                productForm.reset();
                editingProductId = null;
                productIdInput.value = "";
                currentImagePathInput.value = "";
                currentImageDisplay.textContent = "";
                productImageContainer.style.backgroundImage = 'none';
                productImagePlaceholder.classList.remove('hidden');
                
                const existingMethodInput = productForm.querySelector('input[name="_method"]');
                if (existingMethodInput) {
                    existingMethodInput.remove();
                }
                
                productForm.action = `{{ route('admin.products.store') }}`;
            };

            
            if (productImageInput && productImageContainer && productImagePlaceholder) {
                productImageInput.addEventListener("change", () => {
                    const file = productImageInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            productImageContainer.style.backgroundImage = `url(${e.target.result})`;
                            productImagePlaceholder.classList.add('hidden'); 
                        }
                        reader.readAsDataURL(file);
                        currentImageDisplay.textContent = ''; 
                    } else {
                        
                        const currentImageUrl = currentImagePathInput.value;
                        if (editingProductId && currentImageUrl) {
                            productImageContainer.style.backgroundImage = `url(${currentImageUrl})`; 
                            productImagePlaceholder.classList.add('hidden');
                            currentImageDisplay.textContent = `Current: ${currentImageUrl.split('/').pop()}`;
                        } else {
                            productImageContainer.style.backgroundImage = 'none'; 
                            productImagePlaceholder.classList.remove('hidden'); 
                            currentImageDisplay.textContent = '';
                        }
                    }
                });
            }

            
            if (addProductButton) {
                addProductButton.addEventListener('click', () => {
                    openModal(false); 
                });
            }

            
            if (modalCancelButton) {
                modalCancelButton.addEventListener('click', closeModal);
            }

            
            if (productForm) {
                productForm.addEventListener('submit', async function (event) {
                    clearFormErrors(); 
                    modalSubmitButton.disabled = true; 
                    modalSubmitButton.textContent = 'Processing...'; 
                });
            }


            
            if (productTableBody) {
                productTableBody.addEventListener("click", async (event) => {
                    const editButton = event.target.closest(".edit-btn");
                    const deleteButton = event.target.closest(".delete-btn");

                    
                    if (editButton) {
                        const productId = editButton.dataset.productId;
                        console.log("Edit button clicked for product ID:", productId);
                        editButton.disabled = true; 

                        try {
                            
                            const response = await fetch(`/api/products/${productId}`, { 
                                headers: { 'Accept': 'application/json' }
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            const productData = await response.json();
                            console.log("Fetched product data:", productData);
                            openModal(true, productData); 

                        } catch (error) {
                            console.error("Error fetching product for edit:", error);
                            alert("Failed to load product data. Please check the console and API endpoint.");
                            
                        } finally {
                            editButton.disabled = false; 
                        }
                    }

                    
                    else if (deleteButton) {
                        const productId = deleteButton.dataset.productId;
                        console.log("Delete button clicked for product ID:", productId);

                        if (confirm("Are you sure you want to delete this product? This action cannot be undone.")) {
                            deleteButton.disabled = true; 
                            try {
                                if (!csrfToken) throw new Error("CSRF token not found!");

                                
                                const response = await fetch(`/api/products/${productId}`, { 
                                    method: "DELETE",
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json',
                                    }
                                });

                                if (response.ok) {
                                    
                                    const row = document.getElementById(`product-row-${productId}`);
                                    if (row) row.remove();
                                    console.log("Product deleted successfully");
                                    
                                    
                                    alert('Product deleted successfully.'); 

                                } else {
                                    const errorData = await response.json().catch(() => ({})); 
                                    const errorMessage = errorData.message || `Server responded with status: ${response.status}`;
                                    throw new Error(errorMessage);
                                }
                            } catch (error) {
                                console.error("Error deleting product:", error);
                                alert(`Failed to delete product: ${error.message}`);
                                
                            } finally {
                                deleteButton.disabled = false; 
                            }
                        }
                    }
                });
            }

            
            /*
            function showFlashMessage(type, message) {
                const container = document.querySelector('.space-y-4'); 
                if (!container) return;

                
                container.querySelectorAll('.dynamic-flash').forEach(el => el.remove());

                const alertDiv = document.createElement('div');
                alertDiv.className = `dynamic-flash relative rounded-lg p-4 text-sm border mb-4`; 
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
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http:
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                `;

                container.prepend(alertDiv); 

                 
                 
            }
            */

        });
    </script>
@endpush