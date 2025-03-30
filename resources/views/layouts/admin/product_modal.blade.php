@php
    use App\Models\Category;
    
    
    $storeUrl = route('admin.products.store');
@endphp


<div
    x-data="{
        isOpen: false,
        categories: {{ Js::from($categories ?? []) }},
        storeUrl: '{{ $storeUrl }}',
        modalTitle: 'Add New Product',       
        submitButtonText: 'Add Product',    
        formAction: '{{ $storeUrl }}',      
        
        formData: {
            product_name: '',
            description: '',
            price: null,
            category_id: '',
            
        },
        
        
        resetFormData() {
            this.formData.product_name = '';
            this.formData.description = '';
            this.formData.price = null;
            this.formData.category_id = '';
            
        },

        
    }"
    x-on:open-product-modal.window="
        resetFormData(); 

        
        const uploaderElement = document.getElementById('addProductModal')?.querySelector('[x-data^=imageUploader]');
        if (uploaderElement) {
            const uploader = Alpine.$data(uploaderElement); 
            if (uploader) {
                
                uploader.cleanupObjectURLs(); 
                
                
                uploader.selectedFiles = [];
                uploader.imagePreviewUrls = [];
                uploader.currentSlideIndex = 0;
                
                
                if (uploader.$refs.fileInput) {
                    uploader.$refs.fileInput.value = null; 
                }
            }
        }
        

        isOpen = true;
        $nextTick(() => { 
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

        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

        
        <div
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700"
             
        >
             
            <form id="productForm" method="POST" :action="formAction" enctype="multipart/form-data">
                @csrf 
                
                
                
                
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:px-6 sm:pt-6 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        
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

                
                <div class="px-4 py-5 sm:p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                    
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

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
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

                    
                    <div 
                        
                        x-data="imageUploader({ maxFiles: 5 })" 
                        @alpine:updated="updateFileInput" 
                        x-init="init()"
                    >
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Product Images 
                            
                            <span class="text-red-500">*</span> 
                            <span class="text-xs text-gray-500" x-text="maxFiles ? `(${displayImages.length}/${maxFiles} files)` : `(${displayImages.length} files)`"></span>
                        </label>

                        <div class="flex flex-col space-y-3"> 
                            
                            <div class="relative w-full max-h-40 aspect-video rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500 overflow-hidden">
                                
                                
                                <div x-show="displayImages.length === 0" class="text-center p-4">
                                     <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                    <span class="text-sm mt-2 block">Image Preview</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 mt-1 block">Upload images using the button below.</span>
                                </div>

                                
                                <div x-show="displayImages.length > 0" class="absolute inset-0 flex transition-transform duration-300 ease-in-out" :style="{ transform: `translateX(-${currentSlideIndex * 100}%)` }">
                                    <template x-for="(image, index) in displayImages" :key="image.tempId"> 
                                        <div class="w-full h-full flex-shrink-0 relative group p-1"> 
                                            <img 
                                                :src="image.url" 
                                                alt="Image preview" 
                                                class="w-full h-full object-contain rounded-md" 
                                            > 
                                            
                                            <button 
                                                type="button" 
                                                @click="removeImage(index)"
                                                class="absolute top-2 right-2 bg-black bg-opacity-40 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 focus:ring-offset-gray-800 hover:bg-opacity-60"
                                                aria-label="Remove image"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            
                                        </div>
                                    </template>
                                </div>

                                
                                <template x-if="displayImages.length > 1">
                                    <div>
                                        
                                        <button 
                                            type="button" @click="prevSlide"
                                            :disabled="currentSlideIndex === 0"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 text-white p-1.5 rounded-full hover:bg-opacity-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                            aria-label="Previous image"
                                        >
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        
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
                                        name="product_images[]" 
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

                            

                            
                            @error('product_images') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @for ($i = 0; $i < ($errors->get('product_images.*') ? count(old('product_images', [])) : 0); $i++)
                                @error("product_images.$i") <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @endfor
                        </div>

                        
                        <script>
                        function imageUploader(config) {
                            return {
                                maxFiles: config.maxFiles || null, 
                                selectedFiles: [], 
                                imagePreviewUrls: [], 
                                currentSlideIndex: 0,
                                _nextTempId: 1, 
                                _uid: null, 

                                
                                get displayImages() {
                                    return this.imagePreviewUrls.map((url, index) => ({
                                        
                                        tempId: `new-${this.selectedFiles[index].name}-${index}-${this._nextTempId++}`, 
                                        url: url,
                                        file: this.selectedFiles[index], 
                                        
                                    }));
                                },

                                init() {
                                    
                                    window.addEventListener('beforeunload', () => this.cleanupObjectURLs());
                                    
                                    this._uid = Math.random().toString(36).substring(7); 
                                    
                                    this.currentSlideIndex = 0;
                                    this.$nextTick(() => this.scrollThumbnailIntoView(this.currentSlideIndex));
                                },

                                handleFileChange(event) {
                                    const files = Array.from(event.target.files);
                                    if (!files.length) return;

                                    const currentTotal = this.displayImages.length;
                                    
                                    const availableSlots = this.maxFiles ? this.maxFiles - currentTotal : Infinity;
                                    
                                    let filesAddedCount = 0;
                                    let firstNewIndex = -1; 

                                    files.slice(0, availableSlots).forEach(file => {
                                        
                                        if (file.type.startsWith('image/')) {
                                            
                                            const isDuplicate = this.selectedFiles.some(existingFile => 
                                                existingFile.name === file.name && existingFile.size === file.size
                                            );
                                            if (!isDuplicate) {
                                                const url = URL.createObjectURL(file);
                                                this.imagePreviewUrls.push(url);
                                                this.selectedFiles.push(file);
                                                if (firstNewIndex === -1) {
                                                    
                                                    firstNewIndex = this.imagePreviewUrls.length - 1; 
                                                }
                                                filesAddedCount++;
                                            } else {
                                                console.warn(`Skipping duplicate file: ${file.name}`);
                                                
                                            }
                                        } else {
                                            console.warn(`Skipping non-image file: ${file.name}`);
                                            
                                        }
                                    });

                                    
                                    event.target.value = null; 

                                    
                                    if (filesAddedCount > 0 && firstNewIndex !== -1) {
                                        this.goToSlide(firstNewIndex); 
                                    }

                                    
                                    this.updateFileInputState();
                                },

                                removeImage(index) {
                                    
                                    if (index < 0 || index >= this.imagePreviewUrls.length) return;

                                    const deletedUrl = this.imagePreviewUrls[index];
                                    
                                    
                                    this.imagePreviewUrls.splice(index, 1);
                                    this.selectedFiles.splice(index, 1); 

                                    
                                    this.$nextTick(() => {
                                        if (deletedUrl) {
                                            URL.revokeObjectURL(deletedUrl);
                                        }
                                    });

                                    
                                    const newTotalImages = this.displayImages.length; 
                                    let newIndex = this.currentSlideIndex;

                                    if (newTotalImages === 0) {
                                        newIndex = 0; 
                                    } else if (index < this.currentSlideIndex) {
                                        newIndex = this.currentSlideIndex - 1; 
                                    } else if (index === this.currentSlideIndex) {
                                        
                                        newIndex = Math.min(index, newTotalImages - 1); 
                                    } 
                                    
                                    newIndex = Math.max(0, Math.min(newIndex, newTotalImages - 1)); 

                                    this.currentSlideIndex = newIndex; 
                                    this.goToSlide(newIndex); 

                                    
                                    this.updateFileInputState();
                                },
                                
                                

                                cleanupObjectURLs() {
                                    console.log('Cleaning up blob URLs...');
                                    this.imagePreviewUrls.forEach(url => URL.revokeObjectURL(url));
                                },

                                
                                updateFileInputState() {
                                    
                                    const dataTransfer = new DataTransfer();
                                    this.selectedFiles.forEach(file => dataTransfer.items.add(file));
                                    
                                    
                                    if(this.$refs.fileInput) {
                                        this.$refs.fileInput.files = dataTransfer.files;
                                        console.log(this.$refs.fileInput);
                                    }
                                },

                                
                                updateFileInput() {
                                    this.$nextTick(() => this.updateFileInputState());
                                },

                                
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
                                    
                                    if (index >= 0 && index < totalImages) {
                                        this.currentSlideIndex = index;
                                        
                                        this.scrollThumbnailIntoView(index);
                                    } else if (totalImages === 0) {
                                        
                                        this.currentSlideIndex = 0;
                                    }
                                },

                                
                                scrollThumbnailIntoView(index) {
                                    this.$nextTick(() => { 
                                        const thumbnailStrip = this.$refs.thumbnailStrip;
                                        
                                        const thumbnailButton = this.$refs[`thumbnail-${index}`];
                                        
                                        if (thumbnailStrip && thumbnailButton) {
                                            const stripRect = thumbnailStrip.getBoundingClientRect();
                                            const thumbRect = thumbnailButton.getBoundingClientRect();

                                            let scrollOffset = thumbnailStrip.scrollLeft;
                                            const scrollPadding = 10; 

                                            
                                            if (thumbRect.left < stripRect.left) {
                                                scrollOffset -= (stripRect.left - thumbRect.left + scrollPadding);
                                            } 
                                            
                                            else if (thumbRect.right > stripRect.right) {
                                                scrollOffset += (thumbRect.right - stripRect.right + scrollPadding);
                                            }
                                            
                                            
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

                </div> 

                
                <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-600">
                    
                    <button type="submit" id="modalSubmitButton"
                        x-text="submitButtonText"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Add Product
                    </button>
                    
                    <button type="button" id="modalCancelButton" @click="isOpen = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Cancel
                    </button>
                </div>
            </form> 
        </div> 
    </div> 
</div> 

<style>
    /* Ensure smooth transitions for x-show */
    [x-cloak] { display: none !important; }
</style>