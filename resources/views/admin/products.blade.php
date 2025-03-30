@extends('layouts.admin.admin_dashboard')

@section('content')

    <section x-data="{}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Product Management
        </h1>

        <button @click="$dispatch('open-product-modal', { mode: 'add' })" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">

        <i class="fas fa-plus mr-2 -ml-1"></i>
        Add New Product
        </button>

    </section>


    <section class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        
        <form method="GET" action="{{ request()->url() }}">
            <section
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white whitespace-nowrap">All Products</h3>
                <section class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2">
                    
                    <select
                        name="category" 
                        onchange="this.form.submit()" 
                        class="block w-full sm:w-auto px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @if(request('category') == $category->id) selected @endif 
                            >
                                {{ ucfirst($category->category_name) }}
                            </option>
                        @endforeach
                    </select> 

                    
                    <section class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="search"
                               name="search" 
                               placeholder="Search products..."
                               value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </section>
                </section>
            </section>
        </form>
        


        <div class="overflow-x-auto">
            
            <table id="productTable" class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
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
                 
                <tbody id="productTableBody">

                    @forelse($products as $product)
                        
                        <tr id="product-row-{{ $product->id }}" x-data="{}"
                            class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">

                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $product->productImages->get(0) ? asset('storage/'.$product->productImages->get(0)->image_url) : asset('images/stara-logo.jpg') }}"
                                    alt="{{ $product->product_name }}"
                                    class="h-12 w-12 object-cover rounded-md shadow-sm bg-gray-200 dark:bg-gray-600">
                            </td>

                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $product->product_name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $product->category->category_name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                ₦{{ number_format($product->price, 2) }}
                            </td>

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

                            <td class="px-6 py-4 text-center">
                                @php
                                    $status = strtolower($product->status ?? 'draft');
                                    $statusBadge = match ($status) {
                                        'published' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                        'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                        'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                    };
                                @endphp
                                <span
                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                    
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-6 py-16">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-box-open fa-4x mb-4"></i>
                                    
                                    @if(request('search') || request('category'))
                                        <p class="text-xl font-medium mb-1">No Products Match Your Filters</p>
                                        <p class="text-sm mb-4">Try adjusting your search or category selection.</p>
                                        <a href="{{ request()->url() }}" 
                                            class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                            Clear Filters
                                        </a>
                                    @else
                                        <p class="text-xl font-medium mb-1">No Products Found</p>
                                        <p class="text-sm mb-4">There are currently no products listed.</p>
                                        <a href="{{ route('admin.products.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Add Your First Product
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        
        @if ($products->hasPages())
             
            <div id="paginationContainer" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $products->appends(request()->query())->links() }} 
            </div>
        @endif
    </section>

    @push('modals')
        @include('layouts.admin.product_modal')
        @include('layouts.admin.delete_product_modal')
    @endpush

@endsection


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

            const clearFormErrors = () => { /* ... (implementation unchanged) ... */
                if (formErrorsContainer) {
                    formErrorsContainer.innerHTML = '';
                    formErrorsContainer.classList.add('hidden');
                }
                productForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                productForm.querySelectorAll('.error-message').forEach(el => el.remove());
             };

            const openModal = (isEdit = false, productData = null) => { /* ... (implementation unchanged) ... */
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

                    
                    
                    
                    productForm.action = `/admin/products/${productData.id}`; 
                     
                    

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

            window.closeModal = () => { /* ... (implementation unchanged) ... */
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
                 productImageInput.addEventListener("change", () => { /* ... (implementation unchanged) ... */
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
        });
    </script>
@endpush