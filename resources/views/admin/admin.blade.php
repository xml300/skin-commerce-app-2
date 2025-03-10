@include('layouts.admin.header')

<div class="container mx-auto p-4 md:p-8 lg:p-10">
    <header class="mb-8 flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                Admin Panel - Product Management
            </h1>
        </div>

        <!-- Dark Mode Toggle Switch -->
        <div class="flex items-center space-x-2">
            <label for="darkModeToggle" class="text-gray-700 dark:text-gray-300">Dark Mode</label>
            <input type="checkbox" id="darkModeToggle"
                class="appearance-none w-10 h-5 bg-gray-300 dark:bg-gray-600 rounded-full peer cursor-pointer relative" />
            <span
                class="absolute left-1 top-1 bg-white dark:bg-gray-800 rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-blue-500"></span>
        </div>
    </header>

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

    <!-- Product Modal -->
    <div id="addProductModal" class="fixed z-10 inset-0 overflow-y-auto hidden items-center justify-center"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-screen">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Add New Product <!-- Changed dynamically by JS -->
                            </h3>
                            <div class="mt-4">
                                <form action="{{ route('admin.products.store') }}" method="POST" id="addProductForm"
                                    class="mb-4">
                                    @csrf
                                    <input type="hidden" name="product_id" id="product_id_input" value="">
                                    <!-- Hidden input for product ID when editing -->
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                            for="product_name">
                                            Product Name
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            id="product_name" name="product_name" type="text"
                                            placeholder="Enter product name" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                            for="description">
                                            Description
                                        </label>
                                        <textarea
                                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            id="description" name="description" placeholder="Enter product description"
                                            rows="3" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                            for="price">
                                            Price
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400">
                                                <span>₦</span>
                                            </div>
                                            <input
                                                class="shadow-sm appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                id="price" name="price" type="number" step="0.01"
                                                placeholder="Enter price" required />
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                            for="category_id">
                                            Category
                                        </label>
                                        <select name="category_id" id="category_id"
                                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                            <option value="" selected>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->category_id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex flex-col space-y-2">
                                        <label for="image-upload"
                                            class="block text-sm font-bold  text-gray-700 dark:text-gray-200">
                                            Upload Product Image
                                        </label>
                                        <div id="prod_img_container"
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-md">
                                            <div class="space-y-1 text-center bg-gray-900 p-2 rounded-md">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4V12a4 4 0 014-4h16m24 0h-8m-4-4v8m32 4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 0h.02M24 16h.02m-8 8h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="image-upload"
                                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="image-upload" name="image-upload" type="file"
                                                            class="sr-only">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PNG, JPG, GIF up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="modalAddProductButton" onclick="submitForm()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-blue-700 dark:hover:bg-blue-800"
                        type="button">
                        Add Product <!-- Changed dynamically by JS -->
                    </button>
                    <button id="modalCancelButton" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:border-gray-500"
                        type="button">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
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


        productTableBody.addEventListener("click", async(event) => {
            if (event.target.classList.contains("delete-btn")) {
                const productId = event.target.dataset.productId;
                if (confirm("Are you sure you want to delete this product?")) {
                    // Call delete function here - server side form submission for delete needs to be setup
                    // For now, simulating deleteProduct(productId);
                    try{
                    fetch("/api/admin/products" + productId, {
                        method: "DELETE"
                    });
                  }catch(e){
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


        const openEditModal = async(productId) => {
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

@include('layouts.admin.footer')