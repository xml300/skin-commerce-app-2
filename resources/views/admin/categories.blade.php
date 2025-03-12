@extends('layouts.admin.admin_dashboard')
@section('content')
            <div class="container mx-auto p-4 md:p-8 lg:p-10">
                <header class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                        Category Management
                    </h1>
                </header>

                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                            Category List
                        </h2>
                        <button id="addNewCategoryButton" onclick="openCategoryModal()"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 inline-block align-middle mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add New Category
                        </button>
                    </div>

                    <div id="categoryList" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="w-4/5 px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-4 py-3 border-b-2 border-gray-200 bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100">
                                            {{ strtoupper(substr($category->category_name, 0, 1)). substr($category->category_name, 1) }}
                                        </td>
                                        <td class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm">
                                            <button onclick="openEditCategoryModal({{ $category->id }}, '{{ $category->category_name }}')"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-md mr-2 edit-btn dark:bg-yellow-700 dark:hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1">Edit</button>
                                            <button onclick="confirmDeleteCategory({{ $category->id }})"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md delete-btn dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 border-b border-gray-200 bg-white dark:bg-gray-700 text-sm text-gray-500 text-center">No categories available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Category Modal for Add/Edit -->
                <div id="categoryModal" class="fixed z-10 inset-0 overflow-y-auto hidden items-center justify-center"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <div
                            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="categoryModalTitle">
                                            Add New Category
                                        </h3>
                                        <div class="mt-4">
                                            <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="category_id" id="category_id_input" value="">
                                                <div class="mb-4">
                                                    <label for="category_name" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">
                                                        Category Name
                                                    </label>
                                                    <input type="text" name="category_name" id="category_name"
                                                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Enter category name" required>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" onclick="submitCategoryForm()"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-blue-700 dark:hover:bg-blue-800"
                                    id="modalSubmitButton">
                                    Add Category
                                </button>
                                <button type="button" onclick="closeCategoryModal()"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:border-gray-500"
                                    id="modalCancelButton">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal (Example - you can use a simpler confirm dialog) -->
                <div id="deleteCategoryModal" class="fixed z-10 inset-0 overflow-y-auto hidden items-center justify-center"
                    aria-labelledby="delete-modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <div
                            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938-9.77a2.624 2.624 0 015.016-.556 2.624 2.624 0 01-.556 5.016l-9.77 6.938a2.624 2.624 0 01-5.016.556 2.624 2.624 0 01.556-5.016l6.938-9.77z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="delete-modal-title">
                                            Delete Category
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Are you sure you want to delete this category? This action cannot be undone.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button id="confirmDeleteButton" type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-red-700 dark:hover:bg-red-800">
                                    Delete
                                </button>
                                <button type="button" onclick="closeDeleteCategoryModal()"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:border-gray-500"
                                    id="cancelDeleteButton">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

<script>
    let editingCategoryId = null;
    let categoryToDeleteId = null;

    function openCategoryModal() {
        editingCategoryId = null;
        document.getElementById('categoryModalTitle').textContent = 'Add New Category';
        document.getElementById('modalSubmitButton').textContent = 'Add Category';
        document.getElementById('categoryForm').action = "{{ route('admin.categories.store') }}";
        document.getElementById('category_name').value = ''; // Clear input field
        document.getElementById('category_id_input').value = ''; // Clear hidden input
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    }

    function openEditCategoryModal(categoryId, categoryName) {
        editingCategoryId = categoryId;
        document.getElementById('categoryModalTitle').textContent = 'Edit Category';
        document.getElementById('modalSubmitButton').textContent = 'Save Changes';
        document.getElementById('categoryForm').action = `/admin/categories/${categoryId}`; // Set route for update
        document.getElementById('category_name').value = categoryName;
        document.getElementById('category_id_input').value = categoryId; // Set hidden input to category ID for update
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    }


    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryModal').classList.remove('flex');
        editingCategoryId = null;
    }

    function submitCategoryForm() {
        const form = document.getElementById('categoryForm');
        const categoryId = document.getElementById('category_id_input').value;
        if (editingCategoryId) {
            // For Edit, append method spoofing for PUT request if needed
            let methodInput = document.createElement('input');
            methodInput.setAttribute('type', 'hidden');
            methodInput.setAttribute('name', '_method');
            methodInput.setAttribute('value', 'PUT');
            form.appendChild(methodInput);
        }
        form.submit();
    }

    function confirmDeleteCategory(categoryId) {
        categoryToDeleteId = categoryId;
        document.getElementById('deleteCategoryModal').classList.remove('hidden');
        document.getElementById('deleteCategoryModal').classList.add('flex');
    }

    function closeDeleteCategoryModal() {
        document.getElementById('deleteCategoryModal').classList.add('hidden');
        document.getElementById('deleteCategoryModal').classList.remove('flex');
        categoryToDeleteId = null;
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        if (categoryToDeleteId) {
            // Create and submit a form for delete
            let form = document.createElement('form');
            form.action = `/admin/categories/${categoryToDeleteId}`;
            form.method = 'POST';
            let csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = "{{ csrf_token() }}";
            form.appendChild(csrfInput);
            let methodInput = document.createElement('input');
            methodInput.setAttribute('type', 'hidden');
            methodInput.setAttribute('name', '_method');
            methodInput.setAttribute('value', 'DELETE');
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
        closeDeleteCategoryModal(); // Close modal after submission (or cancellation)
    });

    document.getElementById('cancelDeleteButton').addEventListener('click', closeDeleteCategoryModal);


</script>
@endsection