{{-- Delete Confirmation Modal --}}
<div
    x-data="{
        showConfirmModal: false,
        productToDeleteId: null,
        productToDeleteName: '',
        deleteFormAction: ''
    }"
    x-on:open-delete-confirm-modal.window="
        showConfirmModal = true;
        productToDeleteId = $event.detail.id;
        productToDeleteName = $event.detail.name;
        deleteFormAction = `{{ url('api/admin/products') }}/${$event.detail.id}`;
        $nextTick(() => {
            document.getElementById('deleteProductForm').action = deleteFormAction;
        });
    "
    x-show="showConfirmModal"
    x-on:keydown.escape.window="showConfirmModal = false"
    style="display: none;"
    {{-- MODIFIED: Added flexbox centering classes and padding --}}
    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
    aria-labelledby="confirm-modal-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Modal Backdrop (remains the same) --}}
    <div x-show="showConfirmModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 transition-opacity"
         aria-hidden="true" @click="showConfirmModal = false" {{-- Added @click to backdrop to close --}} ></div>

    {{-- Modal Panel --}}
    <div x-show="showConfirmModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         {{-- MODIFIED: Removed alignment/margin classes no longer needed with flex parent --}}
         class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full"
         {{-- Removed @click.away here as the backdrop click handles closing now --}}
         >

        {{-- Modal Content (Header, Body, Footer - remains the same) --}}
        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                {{-- Warning Icon --}}
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle h-6 w-6 text-red-600 dark:text-red-400" aria-hidden="true"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    {{-- Modal Title --}}
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="confirm-modal-title">
                        Delete Product
                    </h3>
                    {{-- Confirmation Text --}}
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Are you sure you want to delete the product
                            "<strong class="font-semibold" x-text="productToDeleteName"></strong>"?
                            This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer with Actions (remains the same) --}}
        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
            {{-- Delete Button --}}
            <form method="POST" class="inline-block" id="deleteProductForm" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            {{-- Cancel Button --}}
            <button @click="showConfirmModal = false" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-500 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>

    </div> {{-- End Modal Panel --}}
</div>
{{-- End Delete Confirmation Modal --}}