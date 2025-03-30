{{-- 
    In your main Blade view file (e.g., products/index.blade.php)
    Make sure $categories is passed from your controller 
--}}
@php
    use App\Models\Category;
    // Assuming $categories is fetched in the controller and passed to the view
    // $categories = $categories ?? Category::all(); // Fetch if not passed (Use with caution in views)
    $storeUrl = route('admin.products.store');
@endphp

{{-- ********** ALPINE.JS MODAL COMPONENT (Add Product Only) ********** --}}
<div
    x-data="{
        isOpen: false,
        categories: {{ Js::from($categories ?? []) }},
        storeUrl: '{{ $storeUrl }}',
        modalTitle: 'Add New Product',       // Hardcoded
        submitButtonText: 'Add Product',    // Hardcoded
        formAction: '{{ $storeUrl }}',      // Hardcoded
        // imagePreviewUrl: null, // Not needed with multi-image uploader
        formData: {
            product_name: '',
            description: '',
            price: null,
            category_id: '',
            // product_images will be handled by the uploader component directly
        },
        
        // Helper function inside x-data for resetting main form data
        resetFormData() {
            this.formData.product_name = '';
            this.formData.description = '';
            this.formData.price = null;
            this.formData.category_id = '';
            // Note: Image uploader state reset is handled separately in the open handler
        },

        // Image change handler is now inside the imageUploader component
    }"
    x-on:open-product-modal.window="
        resetFormData(); // Reset main form fields

        // --- Explicitly Reset Image Uploader State ---
        const uploaderElement = document.getElementById('addProductModal')?.querySelector('[x-data^=imageUploader]');
        if (uploaderElement) {
            const uploader = Alpine.$data(uploaderElement); // Get uploader instance using Alpine's magic property
            if (uploader) {
                // Revoke any existing blob URLs from a previous aborted attempt
                uploader.cleanupObjectURLs(); 
                
                // Clear the uploader's internal state
                uploader.selectedFiles = [];
                uploader.imagePreviewUrls = [];
                uploader.currentSlideIndex = 0;
                
                // Clear the actual file input element
                if (uploader.$refs.fileInput) {
                    uploader.$refs.fileInput.value = null; 
                }
            }
        }
        // --- End Image Uploader Reset ---

        isOpen = true;
        $nextTick(() => { // Focus first input
            const nameInput = document.getElementById('product_name');
            if(nameInput) nameInput.focus();
        });
    "
    x-show="isOpen"
    x-on:keydown.escape.window="isOpen = false"
    id="addProductModal" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    style="display: none;"
    x-cloak
>

    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

        {{-- Background overlay --}}
        <div 
            x-show="isOpen" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 transition-opacity" 
            aria-hidden="true"
            @click="isOpen = false"
        ></div>

        {{-- Centering trick --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

        {{-- Modal panel --}}
        <div
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700"
            {{-- @click.outside="isOpen = false" --}} 
        >
             {{-- Action is now hardcoded via Alpine's formAction --}}
            <form id="productForm" method="POST" :action="formAction" enctype="multipart/form-data">
                @csrf 
                {{-- No @method('PUT') needed --}}
                {{-- No hidden product ID needed --}}
                
                {{-- Modal Header --}}
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:px-6 sm:pt-6 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        {{-- Title is now hardcoded via Alpine's modalTitle --}}
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title" x-text="modalTitle">
                            Add New Product 
                        </h3>
                        <button type="button" @click="isOpen = false"
                            class="ml-3 p-1 -mr-1 -mt-1 text-gray-400 bg-transparent rounded-md hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="px-4 py-5 sm:p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                    {{-- Product Name --}}
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="product_name" id="product_name" required autocomplete="off"
                            x-model="formData.product_name"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                            placeholder="e.g., Wireless Keyboard">
                        @error('product_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                            x-model="formData.description"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                            placeholder="Provide details about the product..."></textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price and Category Grid --}}
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
                                    x-model.number="formData.price"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 pl-7 pr-4 py-2 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"
                                    placeholder="0.00">
                            </div>
                           @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                x-model="formData.category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 py-2 px-3 sm:text-sm">
                                <option value="" disabled>-- Select Category --</option>
                                <template x-for="category in categories" :key="category.id">
                                    <option :value="category.id" x-text="category.category_name"></option>
                                </template>
                                <template x-if="!categories || categories.length === 0">
                                     <option value="" disabled>No categories found</option>
                                </template>
                            </select>
                            @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Product Image Uploader (Simplified for Add Only) --}}
                    <div 
                        {{-- Removed 'existing' parameter --}}
                        x-data="imageUploader({ maxFiles: 5 })" 
                        @alpine:updated="updateFileInput" 
                        x-init="init()"
                    >
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Product Images 
                            {{-- Always show asterisk if images are required for new products --}}
                            <span class="text-red-500">*</span> 
                            <span class="text-xs text-gray-500" x-text="maxFiles ? `(${displayImages.length}/${maxFiles} files)` : `(${displayImages.length} files)`"></span>
                        </label>

                        <div class="flex flex-col space-y-3"> 
                            {{-- Main Preview Area --}}
                            <div class="relative w-full max-h-40 aspect-video rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500 overflow-hidden">
                                
                                {{-- Placeholder when no images --}}
                                <div x-show="displayImages.length === 0" class="text-center p-4">
                                     <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                    <span class="text-sm mt-2 block">Image Preview</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 mt-1 block">Upload images using the button below.</span>
                                </div>

                                {{-- Slides Container --}}
                                <div x-show="displayImages.length > 0" class="absolute inset-0 flex transition-transform duration-300 ease-in-out" :style="{ transform: `translateX(-${currentSlideIndex * 100}%)` }">
                                    <template x-for="(image, index) in displayImages" :key="image.tempId"> {{-- Use tempId as key --}}
                                        <div class="w-full h-full flex-shrink-0 relative group p-1"> 
                                            <img 
                                                :src="image.url" 
                                                alt="Image preview" 
                                                class="w-full h-full object-contain rounded-md" 
                                            > 
                                            {{-- Remove Button --}}
                                            <button 
                                                type="button" 
                                                @click="removeImage(index)"
                                                class="absolute top-2 right-2 bg-black bg-opacity-40 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 focus:ring-offset-gray-800 hover:bg-opacity-60"
                                                aria-label="Remove image"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            {{-- Removed 'New'/'Current' badge --}}
                                        </div>
                                    </template>
                                </div>

                                {{-- Prev/Next Buttons (Only if multiple images) --}}
                                <template x-if="displayImages.length > 1">
                                    <div>
                                        {{-- Previous Button --}}
                                        <button 
                                            type="button" @click="prevSlide"
                                            :disabled="currentSlideIndex === 0"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 text-white p-1.5 rounded-full hover:bg-opacity-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                            aria-label="Previous image"
                                        >
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        {{-- Next Button --}}
                                        <button 
                                            type="button" @click="nextSlide"
                                            :disabled="currentSlideIndex === displayImages.length - 1"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 text-white p-1.5 rounded-full hover:bg-opacity-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                            aria-label="Next image"
                                        >
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            {{-- Thumbnail Strip --}}
                            <div x-show="displayImages.length > 0" class="w-full">
                                <div 
                                    class="flex space-x-2 overflow-x-auto py-2 px-1 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800"
                                     x-ref="thumbnailStrip"
                                     >
                                    <template x-for="(image, index) in displayImages" :key="'thumb-' + image.tempId">
                                        <button
                                            type="button"
                                            @click="goToSlide(index)"
                                            :class="{ 
                                                'ring-2 ring-offset-2 ring-indigo-500 dark:ring-offset-gray-900': currentSlideIndex === index,
                                                'ring-1 ring-gray-300 dark:ring-gray-600 hover:ring-gray-400 dark:hover:ring-gray-500': currentSlideIndex !== index 
                                            }"
                                            class="flex-shrink-0 w-16 h-16 rounded-md bg-gray-100 dark:bg-gray-700 overflow-hidden focus:outline-none transition"
                                            :aria-label="'Go to image ' + (index + 1)"
                                            x-ref="`thumbnail-${index}`" 
                                        >
                                            <img :src="image.url" alt="Thumbnail" class="w-full h-full object-cover">
                                        </button>
                                    </template>
                                </div>
                            </div>

                            {{-- File Input Section --}}
                            <div class="flex items-start space-x-4 pt-1">
                                <label :for="'product_images_input_' + _uid"
                                    class="cursor-pointer inline-flex items-center py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 dark:focus-within:ring-offset-gray-800"
                                    :class="{ 'opacity-50 cursor-not-allowed': maxFiles && displayImages.length >= maxFiles }"
                                >
                                    <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-text="displayImages.length > 0 ? 'Add More' : 'Choose Files'">Choose Files</span>
                                    <input 
                                        :id="'product_images_input_' + _uid" 
                                        name="product_images[]" {{-- Name remains the same for backend --}}
                                        type="file" 
                                        class="sr-only"
                                        multiple 
                                        accept="image/png, image/jpeg, image/gif"
                                        @change="handleFileChange($event)"
                                        x-ref="fileInput"
                                        @click="maxFiles && displayImages.length >= maxFiles ? (event) => event.preventDefault() : () => null"
                                    
                                    >
                                </label>
                                <div class="flex-grow text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <p>Max file size: 2MB. PNG, JPG, GIF.</p>
                                    <p x-show="maxFiles && displayImages.length < maxFiles" x-text="`You can add ${maxFiles - displayImages.length} more file(s).`"></p>
                                    <p x-show="maxFiles && displayImages.length >= maxFiles" class="text-yellow-600 dark:text-yellow-500">Maximum number of files reached.</p>
                                </div>
                            </div>

                            {{-- Removed hidden inputs container for deletions --}}

                            {{-- Validation Errors (Keep this part) --}}
                            @error('product_images') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @for ($i = 0; $i < ($errors->get('product_images.*') ? count(old('product_images', [])) : 0); $i++)
                                @error("product_images.$i") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @endfor
                        </div>

                        {{-- Alpine JS Logic for Image Uploader (Simplified) --}}
                        <script>
                        function imageUploader(config) {
                            return {
                                maxFiles: config.maxFiles || null, 
                                selectedFiles: [], // Files selected by user
                                imagePreviewUrls: [], // Blob URLs for previews
                                currentSlideIndex: 0,
                                _nextTempId: 1, // Simple ID for new previews
                                _uid: null, // Unique ID for file input label

                                // Only display newly added images
                                get displayImages() {
                                    return this.imagePreviewUrls.map((url, index) => ({
                                        // Generate a temporary unique ID for keys/refs
                                        tempId: `new-${this.selectedFiles[index].name}-${index}-${this._nextTempId++}`, 
                                        url: url,
                                        file: this.selectedFiles[index], 
                                        // No 'isNew' needed, they are all new
                                    }));
                                },

                                init() {
                                    // Add listener to clean up blob URLs when navigating away
                                    window.addEventListener('beforeunload', () => this.cleanupObjectURLs());
                                    // Generate unique ID for associating label and input
                                    this._uid = Math.random().toString(36).substring(7); 
                                    // No existing images to load
                                    this.currentSlideIndex = 0;
                                    this.$nextTick(() => this.scrollThumbnailIntoView(this.currentSlideIndex));
                                },

                                handleFileChange(event) {
                                    const files = Array.from(event.target.files);
                                    if (!files.length) return;

                                    const currentTotal = this.displayImages.length;
                                    // Calculate how many more files can be added
                                    const availableSlots = this.maxFiles ? this.maxFiles - currentTotal : Infinity;
                                    
                                    let filesAddedCount = 0;
                                    let firstNewIndex = -1; 

                                    files.slice(0, availableSlots).forEach(file => {
                                        // Basic validation (can be enhanced)
                                        if (file.type.startsWith('image/')) {
                                            // Prevent adding the exact same file instance again
                                            const isDuplicate = this.selectedFiles.some(existingFile => 
                                                existingFile.name === file.name && existingFile.size === file.size
                                            );
                                            if (!isDuplicate) {
                                                const url = URL.createObjectURL(file);
                                                this.imagePreviewUrls.push(url);
                                                this.selectedFiles.push(file);
                                                if (firstNewIndex === -1) {
                                                    // Index where the first *new* file will appear
                                                    firstNewIndex = this.imagePreviewUrls.length - 1; 
                                                }
                                                filesAddedCount++;
                                            } else {
                                                console.warn(`Skipping duplicate file: ${file.name}`);
                                                // Optionally show user feedback
                                            }
                                        } else {
                                            console.warn(`Skipping non-image file: ${file.name}`);
                                            // Optionally show user feedback
                                        }
                                    });

                                    // Important: Clear the native file input value so the same file can be selected again if removed
                                    event.target.value = null; 

                                    // If new files were actually added, navigate to the first one
                                    if (filesAddedCount > 0 && firstNewIndex !== -1) {
                                        this.goToSlide(firstNewIndex); // Use goToSlide to handle scrolling
                                    }

                                    // Update the underlying file input to reflect the selectedFiles array
                                    this.updateFileInputState();
                                },

                                removeImage(index) {
                                    // Index corresponds directly to imagePreviewUrls and selectedFiles
                                    if (index < 0 || index >= this.imagePreviewUrls.length) return;

                                    const deletedUrl = this.imagePreviewUrls[index];
                                    
                                    // Remove from arrays
                                    this.imagePreviewUrls.splice(index, 1);
                                    this.selectedFiles.splice(index, 1); 

                                    // Revoke URL after potential DOM updates using it
                                    this.$nextTick(() => {
                                        if (deletedUrl) {
                                            URL.revokeObjectURL(deletedUrl);
                                        }
                                    });

                                    // Adjust slide index smartly
                                    const newTotalImages = this.displayImages.length; 
                                    let newIndex = this.currentSlideIndex;

                                    if (newTotalImages === 0) {
                                        newIndex = 0; // Reset if empty
                                    } else if (index < this.currentSlideIndex) {
                                        newIndex = this.currentSlideIndex - 1; // Adjust if image before current was removed
                                    } else if (index === this.currentSlideIndex) {
                                        // If we deleted the current one, go to the new one at that index, or the last one if it was the last
                                        newIndex = Math.min(index, newTotalImages - 1); 
                                    } 
                                    // If image *after* current was deleted, index stays same but needs bounds check
                                    newIndex = Math.max(0, Math.min(newIndex, newTotalImages - 1)); 

                                    this.currentSlideIndex = newIndex; // Set index first
                                    this.goToSlide(newIndex); // Then call goToSlide to handle scrolling

                                    // Update the underlying file input
                                    this.updateFileInputState();
                                },
                                
                                // Removed addHiddenInputForDeletion

                                cleanupObjectURLs() {
                                    console.log('Cleaning up blob URLs...');
                                    this.imagePreviewUrls.forEach(url => URL.revokeObjectURL(url));
                                },

                                // Helper to keep the actual <input type="file"> consistent with selectedFiles
                                updateFileInputState() {
                                    // Use DataTransfer to create a FileList
                                    const dataTransfer = new DataTransfer();
                                    this.selectedFiles.forEach(file => dataTransfer.items.add(file));
                                    
                                    // Assign the new FileList to the input
                                    if(this.$refs.fileInput) {
                                        this.$refs.fileInput.files = dataTransfer.files;
                                        console.log(this.$refs.fileInput);
                                    }
                                },

                                // Pass through to updateFileInputState on external updates if needed
                                updateFileInput() {
                                    this.$nextTick(() => this.updateFileInputState());
                                },

                                // --- Carousel Navigation ---
                                nextSlide() {
                                    const totalImages = this.displayImages.length;
                                    if (this.currentSlideIndex < totalImages - 1) {
                                        this.goToSlide(this.currentSlideIndex + 1);
                                    }
                                },
                                prevSlide() {
                                    if (this.currentSlideIndex > 0) {
                                        this.goToSlide(this.currentSlideIndex - 1);
                                    }
                                },
                                goToSlide(index) {
                                    const totalImages = this.displayImages.length;
                                    // Ensure index is valid before setting and scrolling
                                    if (index >= 0 && index < totalImages) {
                                        this.currentSlideIndex = index;
                                        // Scroll the corresponding thumbnail into view
                                        this.scrollThumbnailIntoView(index);
                                    } else if (totalImages === 0) {
                                        // Handle case where last image was removed
                                        this.currentSlideIndex = 0;
                                    }
                                },

                                // --- Thumbnail Scrolling Helper ---
                                scrollThumbnailIntoView(index) {
                                    this.$nextTick(() => { // Ensure DOM is updated
                                        const thumbnailStrip = this.$refs.thumbnailStrip;
                                        // Find the correct thumbnail button using its ref
                                        const thumbnailButton = this.$refs[`thumbnail-${index}`];
                                        
                                        if (thumbnailStrip && thumbnailButton) {
                                            const stripRect = thumbnailStrip.getBoundingClientRect();
                                            const thumbRect = thumbnailButton.getBoundingClientRect();

                                            let scrollOffset = thumbnailStrip.scrollLeft;
                                            const scrollPadding = 10; // Add some padding

                                            // Check if thumbnail is out of view to the left
                                            if (thumbRect.left < stripRect.left) {
                                                scrollOffset -= (stripRect.left - thumbRect.left + scrollPadding);
                                            } 
                                            // Check if thumbnail is out of view to the right
                                            else if (thumbRect.right > stripRect.right) {
                                                scrollOffset += (thumbRect.right - stripRect.right + scrollPadding);
                                            }
                                            
                                            // Apply the scroll smoothly
                                            thumbnailStrip.scrollTo({
                                            left: scrollOffset,
                                            behavior: 'smooth' 
                                            });
                                        }
                                    });
                                }
                            }
                        }
                        </script>

                        {{-- Scrollbar Styling --}}
                        <style>
                            .scrollbar-thin { scrollbar-width: thin; }
                            .scrollbar-thumb-gray-400::-webkit-scrollbar-thumb { background-color: #9ca3af; } 
                            .scrollbar-track-gray-200::-webkit-scrollbar-track { background-color: #e5e7eb; }
                            .dark .scrollbar-thumb-gray-600::-webkit-scrollbar-thumb { background-color: #4b5563; } 
                            .dark .scrollbar-track-gray-800::-webkit-scrollbar-track { background-color: #1f2937; } 
                            ::-webkit-scrollbar { height: 8px; } 
                            ::-webkit-scrollbar-thumb { border-radius: 4px; } 
                        </style>
                    </div>

                </div> {{-- End Modal Body --}}

                {{-- Modal Footer --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                    {{-- Submit Button - Text is now hardcoded via Alpine's submitButtonText --}}
                    <button type="submit" id="modalSubmitButton"
                        x-text="submitButtonText"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Add Product
                    </button>
                    {{-- Cancel Button --}}
                    <button type="button" id="modalCancelButton" @click="isOpen = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Cancel
                    </button>
                </div>
            </form> {{-- End Form --}}
        </div> {{-- End Modal Panel --}}
    </div> {{-- End Flex Container --}}
</div> {{-- End Alpine Component --}}

<style>
    /* Ensure smooth transitions for x-show */
    [x-cloak] { display: none !important; }
</style>