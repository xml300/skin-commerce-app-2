@php
    use App\Models\Category;
    
    $categories = Category::all();
@endphp


<!-- Product Add/Edit Modal -->
<div id="addProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto" {{-- Starts hidden --}}
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

        <!-- Background overlay -->
        {{-- Added transition for smoother appearance --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900/80 transition-opacity" aria-hidden="true"
            onclick="closeModal()"> {{-- Added onclick to close --}}
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

        <!-- Modal Panel -->
        {{-- Added transitions for panel appearance --}}
        <div
            class="absolute top-0 left-0 ml-[35vw] inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-scroll shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700">

            {{-- Form starts here, encompassing header, body, and footer actions --}}
            {{-- Default action is store, JS will update for edit --}}
            <form id="addProductForm" method="POST" action="{{ route('admin.products.store') }}"
                enctype="multipart/form-data">
                @csrf {{-- CSRF Protection --}}
                {{-- Method spoofing for EDIT ('PUT') will be added via JavaScript --}}
                <input type="hidden" name="product_id" id="product_id_input" value=""> {{-- Hidden input for product ID
                during edit --}}

                {{-- Modal Header --}}
                <div
                    class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:px-6 sm:pt-6 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start"> {{-- Changed items-center to items-start for better
                        alignment with multiline titles --}}
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Add New Product {{-- Title updated dynamically by JS --}}
                        </h3>
                        {{-- Close Button --}}
                        <button type="button" onclick="closeModal()"
                            class="ml-3 p-1 -mr-1 -mt-1 text-gray-400 bg-transparent rounded-md hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body (Form Fields) --}}
                {{-- Added max-height and scroll for long forms --}}
                <div class="px-4 py-5 sm:p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                    {{-- Product Name --}}
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="product_name" id="product_name" required autocomplete="off"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                            placeholder="e.g., Wireless Keyboard">
                        {{-- Error display placeholder (if using Laravel validation) --}}
                        {{-- @error('product_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        --}}
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                            placeholder="Provide details about the product..."></textarea>
                        {{-- @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        --}}
                    </div>

                    {{-- Grid for Price and Category --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price (₦) <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₦</span>
                                </div>
                                <input type="number" name="price" id="price" step="0.01" min="0" required
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 pl-7 pr-4 py-2 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                                    placeholder="0.00">
                            </div>
                            {{-- @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror --}}
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 sm:text-sm">
                                <option value="" disabled selected>-- Select Category --</option>
                                {{-- Assuming $categories is passed from controller --}}
                                @isset($categories)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                @else
                                    {{-- Fallback if $categories isn't available --}}
                                    <option value="" disabled>Error: Categories not loaded</option>
                                @endisset
                            </select>
                            {{-- @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            --}}
                        </div>
                    </div>

                    {{-- Product Image --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Product Image
                        </label>
                        <div class="flex items-center space-x-4">
                            {{-- Image Preview Container --}}
                            <div id="prod_img_container"
                                class="flex-shrink-0 w-24 h-24 rounded-md bg-gray-100 dark:bg-gray-700 border border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center text-gray-400 dark:text-gray-500 bg-cover bg-center"
                                style="background-image: none;" {{-- Style updated by JS --}}>
                                {{-- Placeholder Icon/Text (shown when no image via JS or default) --}}
                                <div id="prod_img_placeholder" class="text-center">
                                    <svg class="mx-auto h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    <span class="text-xs mt-1 block">Preview</span>
                                </div>
                            </div>
                            {{-- Upload Button/Input Section --}}
                            <div class="flex-grow">
                                <label for="product_image"
                                    class="cursor-pointer inline-flex items-center py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 dark:focus-within:ring-offset-gray-800">

                                    <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400 dark:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <span>Choose File</span>
                                    <input id="product_image" name="product_image" type="file" class="sr-only"
                                        accept="image/png, image/jpeg, image/gif">
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max file size: 2MB. Allowed
                                    types: PNG, JPG, GIF.</p>
                                {{-- Hidden field to store path of existing image during edit (populated by JS) --}}
                                <input type="hidden" name="current_image" id="current_image_path">
                                {{-- Display area for current image filename during edit (populated by JS) --}}
                                <p id="current_image_display"
                                    class="text-xs text-gray-500 dark:text-gray-400 mt-1 break-all"></p>
                            </div>
                        </div>
                        {{-- @error('product_image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        --}}
                    </div>

                </div> {{-- End Modal Body --}}

                {{-- Modal Footer (Action Buttons) --}}
                <div
                    class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                    {{-- Submit Button --}}
                    <button type="submit" id="modalAddProductButton"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Add Product {{-- Text updated dynamically by JS --}}
                    </button>
                    {{-- Cancel Button --}}
                    <button type="button" id="modalCancelButton" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Cancel
                    </button>
                </div>
            </form> {{-- End of form --}}
        </div> {{-- End Modal Panel --}}
    </div> {{-- End Centering Container --}}
</div> {{-- End Modal Main Container --}}