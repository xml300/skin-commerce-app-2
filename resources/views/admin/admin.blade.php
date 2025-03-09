@include('layouts.admin.admin.header')

<div class="container mx-auto p-4 md:p-8 lg:p-10">
  <header class="mb-8 flex flex-col md:flex-row justify-between items-center">
    <div class="mb-4 md:mb-0">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
        Admin Panel - Product Management
      </h1>
    </div>

    <!-- Dark Mode Toggle Switch -->
    <div class="flex items-center space-x-2">
      <label for="darkModeToggle" class="text-gray-700 dark:text-gray-300"
        >Dark Mode</label
      >
      <input
        type="checkbox"
        id="darkModeToggle"
        class="appearance-none w-10 h-5 bg-gray-300 dark:bg-gray-600 rounded-full peer cursor-pointer relative"
      />
      <span
        class="absolute left-1 top-1 bg-white dark:bg-gray-800 rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-blue-500"
      ></span>
    </div>
  </header>

  <section>
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
        Product List
      </h2>
      <button
        id="addProductButton"
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800"
        type="button"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 inline-block align-middle mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add Product
      </button>
    </div>

    <div
      id="productList"
      class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto"
    >
      <table class="min-w-full leading-normal">
        <thead>
          <tr>
            <th
              class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
            >
              Name
            </th>
            <th
              class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
            >
              Price
            </th>
            <th
              class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
            >
              Category
            </th>
            <th
              class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody id="productTableBody">
          <!-- Product rows will be inserted here by JavaScript -->
        </tbody>
      </table>
    </div>
  </section>

  <!-- Product Modal -->
  <div id="addProductModal" class="fixed z-10 inset-0 overflow-y-auto hidden items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-screen">
        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                Add New Product <!-- Changed dynamically by JS -->
              </h3>
              <div class="mt-4">
                <form
                  id="addProductForm"
                  class="mb-4"
                >
                  <input type="hidden" name="product_id" id="product_id_input" value=""> <!-- Hidden input for product ID when editing -->
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                      for="product_name"
                    >
                      Product Name
                    </label>
                    <input
                      class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      id="product_name"
                      name="product_name"
                      type="text"
                      placeholder="Enter product name"
                      required
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                      for="description"
                    >
                      Description
                    </label>
                    <textarea
                      class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      id="description"
                      name="description"
                      placeholder="Enter product description"
                      rows="3"
                      required
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                      for="price"
                    >
                      Price
                    </label>
                    <div class="relative">
                      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400">
                        <span>₦</span>
                      </div>
                      <input
                        class="shadow-sm appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="price"
                        name="price"
                        type="number"
                        step="0.01"
                        placeholder="Enter price"
                        required
                      />
                    </div>
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                      for="category_id"
                    >
                      Category
                    </label>
                    <select name="category_id" id="category_id"
                    class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                        <option value="" selected>Select Category</option>
                        @foreach($categories as $element)
                            <option value="${element['category_id'] }">
                                ${element['category_name'] }
                            </option>
                        @endforeach
                    </select>
                  </div>
                  <div class="flex flex-col space-y-2">
                    <label for="image-upload" class="block text-sm font-bold  text-gray-700 dark:text-gray-200">
                      Upload Product Image
                    </label>
                    <div id="prod_img_container" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-md">
                      <div class="space-y-1 text-center bg-gray-900 p-2 rounded-md">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4V12a4 4 0 014-4h16m24 0h-8m-4-4v8m32 4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 0h.02M24 16h.02m-8 8h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                          <label for="image-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload a file</span>
                            <input id="image-upload" name="image-upload" type="file" class="sr-only">
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
          <button
            id="modalAddProductButton"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-blue-700 dark:hover:bg-blue-800"
            type="button"
          >
            Add Product <!-- Changed dynamically by JS -->
          </button>
          <button
            id="modalCancelButton"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:border-gray-500"
            type="button"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const productForm = document.getElementById("addProductForm");
    const productTableBody = document.getElementById("productTableBody");
    const darkModeToggle = document.getElementById("darkModeToggle");
    const htmlElement = document.documentElement; // Get the HTML element

    const addProductButton = document.getElementById("addProductButton");
    const addProductModal = document.getElementById("addProductModal");
    const modalCancelButton = document.getElementById("modalCancelButton");
    const modalAddProductButton = document.getElementById("modalAddProductButton");
    const modalTitle = document.getElementById("modal-title");
    const productIdInput = document.getElementById("product_id_input");

    const productImageContainer = document.querySelector("#prod_img_container");
    const productImage = document.querySelector("input[type='file']");

    let editingProductId = null; // Variable to track if we are in edit mode

    productImage.addEventListener("change", () => {
        const blob = new Blob([productImage.files[0]]);
        const url = URL.createObjectURL(blob);
        productImageContainer.style.backgroundImage = `url(${url})`;

    })


    // Function to set dark mode based on preference
    const setDarkMode = (isDark) => {
      // ... (Dark mode function - no changes needed) ...
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

    // Check for saved preference in localStorage or system preference
    const savedDarkMode = localStorage.getItem("darkMode");
    if (savedDarkMode === "enabled") {
      setDarkMode(true);
    } else if (savedDarkMode === "disabled") {
      setDarkMode(false);
    } else if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
      // If no saved preference, check system preference
      setDarkMode(true); // Default to dark if system prefers dark and no saved preference
    } else {
      setDarkMode(false); // Default to light if no preference and system prefers light
    }

    // Toggle dark mode on checkbox change
    darkModeToggle.addEventListener("change", () => {
      setDarkMode(darkModeToggle.checked);
    });

    // Function to fetch and display products
    const fetchProducts = async () => {
      try {
        const response = await fetch("/api/products");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const products = await response.json();
        displayProducts(products);
      } catch (error) {
        console.error("Error fetching products:", error);
        productTableBody.innerHTML =
          '<tr><td colspan="4" class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 dark:text-gray-300 text-center">Failed to load products.</td></tr>'; // Reduced padding in table cell
      }
    };

    // Function to display products in the table
    const displayProducts = (products) => {
      productTableBody.innerHTML = "";
      if (products.length === 0) {
        productTableBody.innerHTML =
          '<tr><td colspan="4" class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 dark:text-gray-300 text-center">No products added yet.</td></tr>'; // Reduced padding in table cell
        return;
      }
      products.forEach((product) => {
        const row = productTableBody.insertRow();
        row.innerHTML = `
                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">${product['product_name'] }</td> <!-- Reduced padding in table cell -->
                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">${product['price'] }</td> <!-- Reduced padding in table cell -->
                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">${product['category_name'] }</td> <!-- Reduced padding in table cell -->
                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm"> <!-- Reduced padding in table cell -->
                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md mr-2 edit-btn dark:bg-yellow-700 dark:hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1" data-product-id="${product['product_id'] }">Edit</button> <!-- Improved button styling with focus ring and rounded corners -->
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md delete-btn dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" data-product-id="${product['product_id'] }">Delete</button> <!-- Improved button styling with focus ring and rounded corners -->
                        </td>
                    `;
      });
      attachActionListeners();
    };

    const attachActionListeners = () => {
      productTableBody.addEventListener("click", async (event) => {
        if (event.target.classList.contains("delete-btn")) {
          const productId = event.target.dataset.productId;
          if (confirm("Are you sure you want to delete this product?")) {
            await deleteProduct(productId);
          }
        } else if (event.target.classList.contains("edit-btn")) {
          const productId = event.target.dataset.productId;
          editingProductId = productId; // Set editingProductId
          openEditModal(productId); // Open modal for editing
        }
      });
    };

    const deleteProduct = async (productId) => {
      try {
        const response = await fetch(`/api/admin/products/${productId}`, {
          method: "DELETE",
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        console.log(`Product ID ${productId} deleted successfully.`);
        fetchProducts();
      } catch (error) {
        console.error("Error deleting product:", error);
        alert("Failed to delete product.");
      }
    };

    // **NEW FUNCTION: Open Edit Modal and Populate Form**
    const openEditModal = async (productId) => {
        modalTitle.textContent = "Edit Product"; // Change modal title
        modalAddProductButton.textContent = "Save Changes"; // Change button text
        addProductModal.classList.remove('hidden');
        addProductModal.classList.add('flex');
        productIdInput.value = productId; // Set hidden input value

        try {
            const response = await fetch(`/api/products/${productId}`); // Fetch product details
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const product = await response.json();
            // Populate form fields with product data
            document.getElementById("product_name").value = product.product_name;
            document.getElementById("description").value = product.description;
            document.getElementById("price").value = product.price;
            document.getElementById("category_id").value = product.category_id;
            // **Image handling for edit - for MVP, you might skip pre-filling image upload, or implement logic to show current image if available**
            // For now, leaving image upload as is - user can re-upload if they want to change it.
        } catch (error) {
            console.error("Error fetching product for edit:", error);
            alert("Failed to fetch product details for editing.");
            closeModal(); // Close modal if fetch fails
        }
    };


    const closeModal = () => {
        addProductModal.classList.add('hidden');
        addProductModal.classList.remove('flex');
        productForm.reset(); // Clear form fields
        editingProductId = null; // Reset editingProductId
        modalTitle.textContent = "Add New Product"; // Reset modal title for "Add" mode
        modalAddProductButton.textContent = "Add Product"; // Reset button text for "Add" mode
        productIdInput.value = ""; // Clear hidden product_id input
    };


    modalAddProductButton.addEventListener("click", async (event) => {
      event.preventDefault();

      const formData = new FormData(productForm);
      const productData = {};
      formData.forEach((value, key) => {
        productData[key] = value;
      });

      try {
        let response;
        if (editingProductId) {
            // **EDIT MODE: Send PUT request**
            response = await fetch(`/api/admin/products/${editingProductId}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(productData),
            });
        } else {
            // **ADD MODE: Send POST request (existing logic)**
            response = await fetch("/api/admin/products", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(productData),
            });
        }


        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log( editingProductId ? "Product updated successfully:" : "Product added successfully:", result);
        alert(editingProductId ? "Product updated successfully!" : "Product added successfully!");
        productForm.reset();
        closeModal(); // Hide modal after submit/update
        fetchProducts();
      } catch (error) {
        console.error(editingProductId ? "Error updating product:" : "Error adding product:", error);
        alert(editingProductId ? "Failed to update product. Please check console for details." : "Failed to add product. Please check console for details.");
      }
    });

    addProductButton.addEventListener('click', () => {
        editingProductId = null; // Reset to add mode
        modalTitle.textContent = "Add New Product"; // Ensure modal title is "Add"
        modalAddProductButton.textContent = "Add Product"; // Ensure button is "Add"
        productIdInput.value = ""; // Clear hidden product_id input
        addProductModal.classList.remove('hidden');
        addProductModal.classList.add('flex');
    });

    modalCancelButton.addEventListener('click', () => {
        closeModal();
    });


    fetchProducts();
  });
</script>

@include('layouts.admin.admin.footer')