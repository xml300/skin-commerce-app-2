@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

@section('content')

{{-- Alpine component wrapper --}}
<div x-data="categoryManager(
        '{{ route('admin.categories.store') }}',
        '{{ url('admin/categories') }}/', {{-- Base URL for edit/delete --}}
        '{{ csrf_token() }}'
    )">

    {{-- Page Header: Title and Add Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Category Management
        </h1>
        {{-- Add New Category Button --}}
        <button type="button" @click="openAddModal()"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Category
        </button>
    </div>

    {{-- Category List Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        {{-- Table Container for Responsiveness --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-3/4">Name</th>
                        <th scope="col" class="px-6 py-3 text-center">Products</th> {{-- Optional: Product Count --}}
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            {{-- Name --}}
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ ucfirst($category->category_name) }}
                            </td>
                             {{-- Product Count (Example - Requires eager loading 'products_count') --}}
                             <td class="px-6 py-4 text-center">
                                {{ $category->products_count ?? 'N/A' }} {{-- Display count if loaded --}}
                            </td>
                            {{-- Action Buttons --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-4"> {{-- Increased space slightly --}}
                                    {{-- Edit Action --}}
                                    <button type="button"
                                            @click="openEditModal({{ $category->id }}, '{{ e($category->category_name) }}')"
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-150"
                                            title="Edit Category">
                                        <i class="fas fa-pencil-alt fa-fw"></i> {{-- fa-fw for fixed width --}}
                                    </button>
                                    {{-- Delete Action --}}
                                    <button type="button"
                                            @click="openDeleteModal({{ $category->id }})"
                                            class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-150"
                                            title="Delete Category">
                                        <i class="fas fa-trash-alt fa-fw"></i> {{-- fa-fw for fixed width --}}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- State when no categories are found --}}
                        <tr>
                            <td colspan="3" {{-- Adjust colspan --}} class="text-center px-6 py-16">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-tags fa-3x mb-4"></i>
                                    <p class="text-xl font-medium mb-1">No Categories Found</p>
                                    <p class="text-sm">There are currently no categories to display.</p>
                                    <button type="button" @click="openAddModal()" class="mt-4 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                         Add First Category
                                     </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> {{-- End overflow-x-auto --}}

         {{-- Pagination (Optional) --}}
        @if ($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $categories->links() }} {{-- Ensure pagination views are styled for Tailwind --}}
            </div>
        @endif

    </div> {{-- End Card --}}

    {{-- Category Modal for Add/Edit (Alpine Controlled) --}}
    <div x-show="isAddEditModalOpen"
         style="display: none;" {{-- Hide initially to prevent flash, Alpine takes over --}}
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed z-50 inset-0 overflow-y-auto flex items-center justify-center"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         @keydown.escape.window="closeAddEditModal()">

        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div x-show="isAddEditModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeAddEditModal()" {{-- Close on overlay click --}}
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-60 transition-opacity" aria-hidden="true"></div>

             {{-- This element is to trick the browser into centering the modal contents. --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            {{-- Modal panel --}}
            <div x-show="isAddEditModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="absolute top-[30vh] left-0 ml-[35vw] inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                {{-- Using $refs.categoryForm for submission via Alpine if needed, otherwise standard submit --}}
                <form x-ref="categoryForm" :action="formActionUrl" method="POST">
                    @csrf
                    {{-- Method spoofing for PUT request (Edit) --}}
                    <template x-if="isEditing">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    {{-- Hidden input to potentially carry ID if needed by backend (though URL usually sufficient) --}}
                    <input type="hidden" name="category_id" :value="editingCategory.id">

                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            {{-- Icon --}}
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-tag text-indigo-600 dark:text-indigo-300"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title"
                                    x-text="isEditing ? 'Edit Category' : 'Add New Category'">
                                    {{-- Title will be set by Alpine --}}
                                </h3>
                                <div class="mt-4">
                                    {{-- Category Name Input --}}
                                    <label for="category_name_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Category Name <span class="text-red-500">*</span>
                                    </label>
                                    {{-- Use x-model for two-way binding --}}
                                    <input type="text" name="category_name" id="category_name_modal"
                                           x-model="editingCategory.name"
                                           class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           placeholder="e.g., Electronics" required
                                           x-ref="categoryNameInput" {{-- Add x-ref to focus --}}
                                           >
                                    {{-- Optional: Add validation error display here using Laravel errors or Alpine state --}}
                                     @error('category_name') {{-- Example Laravel error --}}
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Footer Buttons --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                        <button type="submit" {{-- Standard form submit --}}
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm"
                                x-text="isEditing ? 'Save Changes' : 'Add Category'">
                            {{-- Button text will be set by Alpine --}}
                        </button>
                        <button type="button" @click="closeAddEditModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-500 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal (Alpine Controlled) --}}
    <div x-show="isDeleteModalOpen"
         style="display: none;" {{-- Hide initially --}}
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed z-50 inset-0 overflow-y-auto flex items-center justify-center"
         aria-labelledby="delete-modal-title" role="dialog" aria-modal="true"
         @keydown.escape.window="closeDeleteModal()">

        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
             {{-- Background overlay --}}
            <div x-show="isDeleteModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeDeleteModal()" {{-- Close on overlay click --}}
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-60 transition-opacity" aria-hidden="true"></div>

            {{-- This element is to trick the browser into centering the modal contents. --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            {{-- Modal panel --}}
            <div x-show="isDeleteModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="delete-modal-title">
                                Delete Category
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Are you sure you want to delete this category? This action cannot be undone. Associated products might also be affected.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                 {{-- Modal Footer Buttons --}}
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                    {{-- The button now triggers the submission of the hidden delete form --}}
                    <button type="button" @click="$refs.deleteForm.submit()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" @click="closeDeleteModal()"
                           class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-500 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form for handling the DELETE request --}}
    <form x-ref="deleteForm" method="POST" :action="deleteActionUrl" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div> {{-- End Alpine component wrapper --}}


{{-- Alpine.js Logic --}}
<script>
    function categoryManager(addUrl, baseUrl, csrfToken) {
        return {
            // State Properties
            isAddEditModalOpen: false,
            isDeleteModalOpen: false,
            isEditing: false,
            editingCategory: { id: null, name: '' },
            categoryToDeleteId: null,
            // URLs (initialized from Blade)
            addUrl: addUrl,
            baseUrl: baseUrl, // e.g., 'http://.../admin/categories/'
            csrfToken: csrfToken,

            // Computed Property for dynamic form action URL
            get formActionUrl() {
                return this.isEditing ? `${this.baseUrl}${this.editingCategory.id}` : this.addUrl;
            },

            // Computed Property for dynamic delete form action URL
            get deleteActionUrl() {
                return this.categoryToDeleteId ? `${this.baseUrl}${this.categoryToDeleteId}` : '#';
            },

            // Methods
            openAddModal() {
                this.isEditing = false;
                this.editingCategory = { id: null, name: '' }; // Reset
                this.isAddEditModalOpen = true;
                // Use $nextTick to ensure the input is visible before focusing
                this.$nextTick(() => {
                    this.$refs.categoryNameInput.focus();
                });
            },

            openEditModal(id, name) {
                this.isEditing = true;
                this.editingCategory = { id: id, name: name };
                this.isAddEditModalOpen = true;
                this.$nextTick(() => {
                    this.$refs.categoryNameInput.focus();
                     this.$refs.categoryNameInput.select(); // Optional: select text
                });
            },

            closeAddEditModal() {
                this.isAddEditModalOpen = false;
                // Optionally reset state after transition ends if needed, but often not necessary
                // setTimeout(() => {
                //     if (!this.isAddEditModalOpen) { // Check if it wasn't reopened quickly
                //         this.editingCategory = { id: null, name: '' };
                //         this.isEditing = false;
                //     }
                // }, 300); // Match transition duration
            },

            openDeleteModal(id) {
                this.categoryToDeleteId = id;
                this.isDeleteModalOpen = true;
            },

            closeDeleteModal() {
                this.isDeleteModalOpen = false;
                 // Optionally reset ID after transition
                // setTimeout(() => {
                //     if (!this.isDeleteModalOpen) {
                //         this.categoryToDeleteId = null;
                //     }
                // }, 300);
            }

            // Note: The form submissions (add/edit/delete) are handled by standard HTML form submissions.
            // Alpine is used here to manage the UI state (modal visibility, dynamic content) before submission.
        }
    }

     // Handle potential validation errors on page load (if using redirects with errors)
    document.addEventListener('alpine:init', () => {
        // If Laravel redirects back with validation errors for 'category_name',
        // and it was an 'edit' attempt, you might want to automatically reopen the edit modal.
        // This requires passing back information about which category was being edited.
        // Example (requires modification based on how you handle errors):
        @if ($errors->has('category_name') && old('category_id'))
            // Find the Alpine component instance (tricky without specific IDs)
            // A simpler approach might be to just show the modal if there's *any* category_name error
            // and rely on 'old()' to repopulate the data correctly inside the modal.
            // If you always redirect to the index, this is simpler:
            const manager = Alpine.find(document.querySelector('[x-data]')); // Find the first component
            if (manager) {
                const oldId = parseInt('{{ old('category_id') }}');
                const oldName = '{{ old('category_name') }}';
                 // Check if the '_method' was PUT, indicating an edit attempt
                const wasEditing = '{{ old('_method') }}' === 'PUT';

                if (wasEditing && oldId) {
                     manager.openEditModal(oldId, oldName);
                 } else if (!wasEditing) {
                    // If it was an add attempt with errors
                    manager.openAddModal();
                    // Repopulate name if needed (though x-model with old() might handle this)
                    manager.editingCategory.name = oldName;
                 }
            }
        @endif
    });

</script>
@endsection