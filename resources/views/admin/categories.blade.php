@extends('layouts.admin.admin_dashboard') 

@section('content')


<div x-data="categoryManager(
        '{{ route('admin.categories.store') }}',
        '{{ url('admin/categories') }}/', 
        '{{ csrf_token() }}'
    )">

    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Category Management
        </h1>
        
        <button type="button" @click="openAddModal()"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Category
        </button>
    </div>

    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-3/4">Name</th>
                        <th scope="col" class="px-6 py-3 text-center">Products</th> 
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ ucfirst($category->category_name) }}
                            </td>
                             
                             <td class="px-6 py-4 text-center">
                                {{ $category->products_count ?? 'N/A' }} 
                            </td>
                            
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-4"> 
                                    
                                    <button type="button"
                                            @click="openEditModal({{ $category->id }}, '{{ e($category->category_name) }}')"
                                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-150"
                                            title="Edit Category">
                                        <i class="fas fa-pencil-alt fa-fw"></i> 
                                    </button>
                                    
                                    <button type="button"
                                            @click="openDeleteModal({{ $category->id }})"
                                            class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-150"
                                            title="Delete Category">
                                        <i class="fas fa-trash-alt fa-fw"></i> 
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        
                        <tr>
                            <td colspan="3"  class="text-center px-6 py-16">
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
        </div> 

         
        @if ($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $categories->links() }} 
            </div>
        @endif

    </div> 

    
    <div x-show="isAddEditModalOpen"
         style="display: none;" 
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
            
            <div x-show="isAddEditModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeAddEditModal()" 
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-60 transition-opacity" aria-hidden="true"></div>

             
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            
            <div x-show="isAddEditModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="absolute top-[30vh] left-0 ml-[35vw] inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <form x-ref="categoryForm" :action="formActionUrl" method="POST">
                    @csrf
                    
                    <template x-if="isEditing">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <input type="hidden" name="category_id" :value="editingCategory.id">

                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-tag text-indigo-600 dark:text-indigo-300"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title"
                                    x-text="isEditing ? 'Edit Category' : 'Add New Category'">
                                    
                                </h3>
                                <div class="mt-4">
                                    
                                    <label for="category_name_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Category Name <span class="text-red-500">*</span>
                                    </label>
                                    
                                    <input type="text" name="category_name" id="category_name_modal"
                                           x-model="editingCategory.name"
                                           class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           placeholder="e.g., Electronics" required
                                           x-ref="categoryNameInput" 
                                           >
                                    
                                     @error('category_name') 
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm"
                                x-text="isEditing ? 'Save Changes' : 'Add Category'">
                            
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

    
    <div x-show="isDeleteModalOpen"
         style="display: none;" 
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
             
            <div x-show="isDeleteModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeDeleteModal()" 
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-60 transition-opacity" aria-hidden="true"></div>

            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            
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
                 
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                    
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

    
    <form x-ref="deleteForm" method="POST" :action="deleteActionUrl" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div> 



<script>
    function categoryManager(addUrl, baseUrl, csrfToken) {
        return {
            
            isAddEditModalOpen: false,
            isDeleteModalOpen: false,
            isEditing: false,
            editingCategory: { id: null, name: '' },
            categoryToDeleteId: null,
            
            addUrl: addUrl,
            baseUrl: baseUrl, 
            csrfToken: csrfToken,

            
            get formActionUrl() {
                return this.isEditing ? `${this.baseUrl}${this.editingCategory.id}` : this.addUrl;
            },

            
            get deleteActionUrl() {
                return this.categoryToDeleteId ? `${this.baseUrl}${this.categoryToDeleteId}` : '#';
            },

            
            openAddModal() {
                this.isEditing = false;
                this.editingCategory = { id: null, name: '' }; 
                this.isAddEditModalOpen = true;
                
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
                     this.$refs.categoryNameInput.select(); 
                });
            },

            closeAddEditModal() {
                this.isAddEditModalOpen = false;
                
                
                
                
                
                
                
            },

            openDeleteModal(id) {
                this.categoryToDeleteId = id;
                this.isDeleteModalOpen = true;
            },

            closeDeleteModal() {
                this.isDeleteModalOpen = false;
                 
                
                
                
                
                
            }

            
            
        }
    }

     
    document.addEventListener('alpine:init', () => {
        
        
        
        
        @if ($errors->has('category_name') && old('category_id'))
            
            
            
            
            const manager = Alpine.find(document.querySelector('[x-data]')); 
            if (manager) {
                const oldId = parseInt('{{ old('category_id') }}');
                const oldName = '{{ old('category_name') }}';
                 
                const wasEditing = '{{ old('_method') }}' === 'PUT';

                if (wasEditing && oldId) {
                     manager.openEditModal(oldId, oldName);
                 } else if (!wasEditing) {
                    
                    manager.openAddModal();
                    
                    manager.editingCategory.name = oldName;
                 }
            }
        @endif
    });

</script>
@endsection