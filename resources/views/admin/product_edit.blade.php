@extends('layouts.admin.admin_dashboard') {{-- Adjust this to your actual layout file --}}

@section('title', 'Edit Product: ' . $product->product_name)

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            {{-- Breadcrumbs --}}
            <nav class="text-sm mb-1 text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                        <i class="fas fa-angle-right mx-2"></i>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.products') }}" class="hover:text-indigo-600">Products</a>
                        <i class="fas fa-angle-right mx-2"></i>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.products.details', $product->id) }}"
                            class="hover:text-indigo-600">{{ Str::limit($product->product_name, 30) }}</a>
                        <i class="fas fa-angle-right mx-2"></i>
                    </li>
                    <li class="text-gray-700 dark:text-gray-300" aria-current="page">
                        Edit
                    </li>
                </ol>
            </nav>

            {{-- Page Title --}}
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-pencil-alt text-xl text-gray-500 dark:text-gray-400"></i>
                Edit Product
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update the details for '{{ $product->product_name }}'.
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center space-x-2 flex-wrap gap-2">
            <a href="{{ route('admin.products.details', $product->id) }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-eye mr-2 -ml-1"></i>
                View Details
            </a>
        </div>
    </div>

    {{-- Edit Form --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (Product Info, Pricing) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Product Information Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Product Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Product Name --}}
                        <div>
                            <label for="product_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="product_name" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}" required
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('product_name') border-red-500 @enderror">
                            @error('product_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea id="description" name="description" rows="6"
                                class="p-3 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Provide a detailed description of the
                                product.</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Pricing & Inventory Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Pricing & Inventory
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                        {{-- Regular Price --}}
                        <div>
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Regular Price (₦)
                                <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" step="0.01" min="0" required
                                value="{{ old('price', $product->price) }}"
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sale Price --}}
                        <div>
                            <label for="sale_price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sale Price
                                (₦)</label>
                            <input type="number" id="sale_price" name="sale_price" step="0.01" min="0"
                                value="{{ old('sale_price', $product->sale_price) }}" placeholder="Optional"
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('sale_price') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank if not on sale.</p>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock Quantity --}}
                        <div class="sm:col-span-2">
                            <label for="stock_quantity"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Quantity <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="stock_quantity" name="stock_quantity" min="0" required
                                value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div> {{-- End Left Column --}}

            {{-- Right Column (Organization, Images) --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Organization Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Organization
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Category --}}
                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category <span
                                    class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category_id') border-red-500 @enderror">
                                <option value="">-- Select Category --</option>
                                @php
                                    // Assuming $categories is passed from the controller
                                    $categories = $categories ?? \App\Models\Category::orderBy('category_name')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span
                                    class="text-red-500">*</span></label>
                            <select id="status" name="status" required
                                class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-500 @enderror">
                                <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Product Images Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Product Images (Max {{ $maxFiles ?? 5 }} Total) {{-- Adjust max count as needed --}}
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        {{-- Container with data attributes --}}
                        <div id="image-uploader-container" class="space-y-3" data-max-files="{{ $maxFiles ?? 5 }}"
                            data-existing-images='@json($product->productImages->map(fn($img) => ['id' => $img->id, 'url' => asset('storage/' . $img->image_url)])->values()->all())'>

                            {{-- Label & Count --}}
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Product Images
                                {{-- Show required only if there are no images currently --}}
                                @if($product->productImages->isEmpty())
                                    @if($isRequired ?? true) <span class="text-red-500">*</span> @endif
                                @endif
                                <span class="text-xs text-gray-500 ml-1" id="image-count-info"></span>
                            </label>

                            {{-- Main Preview Area --}}
                            <div
                                class="relative w-full max-h-48 aspect-video rounded-lg bg-gray-100 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center text-gray-400 dark:text-gray-500 overflow-hidden group/preview">
                                {{-- Placeholder --}}
                                <div id="placeholder-view" class="text-center p-4 cursor-default">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    <span class="text-sm mt-2 block">Image Preview</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 mt-1 block">Upload images
                                        below.</span>
                                </div>
                                {{-- Slides Container --}}
                                <div id="image-slides-container"
                                    class="absolute inset-0 flex transition-transform duration-300 ease-in-out">
                                    {{-- JS adds slides here --}}
                                </div>
                                {{-- Controls (Appear on hover of group/preview) --}}
                                <div id="carousel-controls"
                                    class="absolute inset-0 opacity-0 group-hover/preview:opacity-100 transition-opacity duration-200 hidden">
                                    <button type="button" id="prev-button"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white p-1.5 rounded-full hover:bg-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                        aria-label="Previous image">
                                        <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button type="button" id="next-button"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 text-white p-1.5 rounded-full hover:bg-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                        aria-label="Next image">
                                        <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Thumbnail Strip --}}
                            <div id="thumbnail-strip-outer" class="w-full hidden">
                                <div id="thumbnail-strip-container"
                                    class="flex space-x-2 overflow-x-auto py-2 px-1 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                                    {{-- JS adds thumbnails here --}}
                                </div>
                            </div>

                            {{-- File Input Section --}}
                            <div class="flex items-start space-x-4 pt-1">
                                {{-- Choose Files Button (Label) --}}
                                <label id="choose-files-button" for="product_images_input_edit" {{-- Use a unique ID --}}
                                    class="cursor-pointer inline-flex items-center py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 dark:focus-within:ring-offset-gray-800 transition-opacity whitespace-nowrap"
                                    aria-controls="product_images_input_edit">
                                    <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400 dark:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span id="choose-files-button-text">Choose Files</span>
                                </label>
                                {{-- Hidden Actual File Input --}}
                                <input id="product_images_input_edit" {{-- Match label's 'for' --}} name="product_images[]"
                                    type="file" class="sr-only" multiple
                                    accept="image/png, image/jpeg, image/gif, image/webp" aria-hidden="true">
                                {{-- Helper Text --}}
                                <div class="flex-grow text-xs text-gray-500 dark:text-gray-400 mt-1 space-y-0.5">
                                    <p>Max file size: {{ $maxFileSize ?? '2MB' }}. PNG, JPG, GIF, WEBP.</p>
                                    <p id="image-limit-info"></p>
                                    <p id="image-limit-error"
                                        class="text-yellow-600 dark:text-yellow-500 font-medium hidden"></p>
                                </div>
                            </div>

                            {{-- Hidden Input for Deletions --}}
                            <input type="hidden" name="delete_images" id="delete_images_input" value="[]">

                            {{-- Server-Side Validation Errors --}}
                            <div class="space-y-1 text-xs text-red-600 dark:text-red-400 mt-1">
                                @error('product_images') <p>{{ $message }}</p> @enderror
                                @error('delete_images') <p>{{ $message }}</p> @enderror {{-- Error for the deletion input --}}
                                @foreach ($errors->get('product_images.*') as $message)
                                    <p>{{ $message[0] }}</p>
                                @endforeach
                                @error('image_count') <p>{{ $message }}</p> @enderror
                            </div>

                            {{-- HTML Templates for JavaScript --}}
                            <template id="image-slide-template">
                                {{-- Add group/slide here for individual slide hover --}}
                                <div class="w-full h-full flex-shrink-0 relative p-1 slide-item group/slide">
                                    <img src="" alt=""
                                        class="w-full h-full object-contain rounded-md slide-image bg-gray-200 dark:bg-gray-700">
                                    {{-- Remove button for slide - appears on hover of group/slide --}}
                                    <button type="button"
                                        class="absolute top-2 right-2 z-10 bg-black bg-opacity-50 text-white rounded-full p-1 opacity-0 group-hover/slide:opacity-100 transition-opacity focus:opacity-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 focus:ring-offset-gray-800 hover:bg-opacity-70 remove-button"
                                        aria-label="Remove image">
                                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    {{-- 'NEW' badge --}}
                                    <span
                                        class="absolute bottom-2 left-2 bg-blue-500 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded new-badge hidden">NEW</span>
                                </div>
                            </template>

                            <template id="thumbnail-template">
                                {{-- Parent has group/thumb --}}
                                <div class="flex-shrink-0 w-16 h-16 rounded-md bg-gray-100 dark:bg-gray-700 overflow-hidden focus:outline-none transition relative group/thumb thumbnail-button"
                                     aria-label="Go to image X">
                                    <img src="" alt="Thumbnail" class="w-full h-full object-cover thumbnail-image">
                                    {{-- Remove button for thumbnail - appears on hover of group/thumb --}}
                                    <button type="button"
                                        class="absolute top-0.5 right-0.5 bg-black bg-opacity-50 text-white rounded-full p-0.5 opacity-0 group-hover/thumb:opacity-100 transition-opacity focus:opacity-100 focus:outline-none focus:ring-1 focus:ring-red-500 remove-button-thumb"
                                        aria-label="Remove image from thumbnail">
                                        <svg class="w-3 h-3 pointer-events-none" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                        </div> {{-- End #image-uploader-container --}}
                    </div> {{-- End Card Body --}}
                </div> {{-- End Product Images Card --}}

            </div> {{-- End Right Column --}}
        </div> {{-- End Grid --}}

        {{-- Form Actions Footer --}}
        <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
            <a href="{{ route('admin.products.details', $product->id) }}"
                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-save mr-2 -ml-1"></i>
                Save Changes
            </button>
        </div>
    </form>

@endsection

{{-- Push Styles and Scripts --}}
@once
    @push('styles')
        <style>
            /* Webkit (Chrome, Safari, Edge) */
            .scrollbar-thin::-webkit-scrollbar {
                height: 8px;
                width: 8px;
            }

            .scrollbar-thin::-webkit-scrollbar-track {
                background: #e5e7eb;
                /* bg-gray-200 */
                border-radius: 4px;
            }

            .dark .scrollbar-thin::-webkit-scrollbar-track {
                background: #1f2937;
                /* dark:bg-gray-800 */
            }

            .scrollbar-thin::-webkit-scrollbar-thumb {
                background-color: #9ca3af;
                /* bg-gray-400 */
                border-radius: 4px;
                border: 2px solid #e5e7eb;
                /* track color */
            }

            .dark .scrollbar-thin::-webkit-scrollbar-thumb {
                background-color: #4b5563;
                /* dark:bg-gray-600 */
                border: 2px solid #1f2937;
                /* dark track color */
            }

            .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background-color: #6b7280;
                /* hover:bg-gray-500 */
            }

            .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background-color: #6b7280;
                /* dark:hover:bg-gray-500 */
            }

            /* Firefox */
            .scrollbar-thin {
                scrollbar-width: thin;
                scrollbar-color: #9ca3af #e5e7eb;
                /* thumb track */
            }

            .dark .scrollbar-thin {
                scrollbar-color: #4b5563 #1f2937;
                /* dark thumb dark track */
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Find all uploader instances on the page (useful if component is reused)
                document.querySelectorAll('#image-uploader-container').forEach(container => {
                    initializeImageUploader(container);
                });
            });

            function initializeImageUploader(container) {
                // --- DOM Elements (scoped to the current container) ---
                const fileInput = container.querySelector('input[type="file"]'); // More specific selector
                const chooseFilesButton = container.querySelector('#choose-files-button');
                const chooseFilesButtonText = container.querySelector('#choose-files-button-text');
                const slidesContainer = container.querySelector('#image-slides-container');
                const thumbnailStripContainer = container.querySelector('#thumbnail-strip-container');
                const thumbnailStripOuter = container.querySelector('#thumbnail-strip-outer');
                const placeholderView = container.querySelector('#placeholder-view');
                const carouselControls = container.querySelector('#carousel-controls');
                const prevButton = container.querySelector('#prev-button');
                const nextButton = container.querySelector('#next-button');
                const imageCountInfo = container.querySelector('#image-count-info');
                const imageLimitInfo = container.querySelector('#image-limit-info');
                const imageLimitError = container.querySelector('#image-limit-error');
                const deleteImagesInput = container.querySelector('#delete_images_input'); // Get the hidden input
                const slideTemplate = container.querySelector('#image-slide-template');
                const thumbnailTemplate = container.querySelector('#thumbnail-template');

                // Basic check if essential elements exist
                if (!fileInput || !slidesContainer || !thumbnailStripContainer || !slideTemplate || !thumbnailTemplate || !deleteImagesInput) {
                    console.error("Image uploader init failed: Missing essential elements within container:", container);
                    return; // Stop initialization for this container
                }

                // --- State ---
                const maxFiles = parseInt(container.dataset.maxFiles || '5', 10);
                let existingImagesData = [];
                try {
                    // Use getAttribute for potentially complex JSON strings
                    const rawData = container.getAttribute('data-existing-images');
                    existingImagesData = JSON.parse(rawData || '[]');
                } catch (e) {
                    console.error("Failed to parse existing images data:", container.getAttribute('data-existing-images'), e);
                }
                let newlySelectedFiles = []; // Array of { file: File, blobUrl: string, tempId: string }
                let imagesToDelete = [];     // Array to store IDs of existing images marked for deletion
                let currentSlideIndex = 0;
                let nextTempId = 1; // Counter for unique temporary IDs for new files

                // --- Helper: Get Combined List of Images to Display ---
                function getDisplayImages() {
                    // Filter out existing images that are marked for deletion
                    const visibleExisting = existingImagesData
                        .filter(img => !imagesToDelete.includes(img.id)) // Filter based on imagesToDelete array
                        .map(img => ({
                            tempId: `existing-${img.id}`, // Create a unique temporary ID for existing items
                            id: img.id,                   // Store the actual database ID
                            url: img.url,
                            isNew: false,                 // Flag indicating it's an existing image
                        }));

                    // Map newly selected files (which have Blob URLs)
                    const newPreviews = newlySelectedFiles.map(item => ({
                        tempId: item.tempId,             // Use the generated temporary ID
                        id: null,                        // No database ID yet
                        url: item.blobUrl,
                        isNew: true,                     // Flag indicating it's a newly added image
                        file: item.file                  // Keep file reference if needed later
                    }));

                    // Combine the two lists
                    return [...visibleExisting, ...newPreviews];
                }

                // --- Core Rendering Function (Updates the UI based on current state) ---
                function render() {
                    const displayImages = getDisplayImages(); // Get the current list of images to show
                    const totalImages = displayImages.length;

                    // 1. Update Slides Container
                    slidesContainer.innerHTML = ''; // Clear previous slides
                    // Set the transform to show the correct slide based on currentSlideIndex
                    slidesContainer.style.transform = `translateX(-${currentSlideIndex * 100}%)`;

                    if (totalImages === 0) {
                        // Show placeholder if no images
                        placeholderView.classList.remove('hidden');
                        carouselControls.classList.add('hidden'); // Hide controls
                        thumbnailStripOuter.classList.add('hidden'); // Hide thumbnail strip
                    } else {
                        // Hide placeholder if there are images
                        placeholderView.classList.add('hidden');
                        // Show controls only if more than one image
                        carouselControls.classList.toggle('hidden', totalImages <= 1);
                        thumbnailStripOuter.classList.remove('hidden'); // Show thumbnail strip

                        // Create and append slide elements for each image
                        displayImages.forEach((image, index) => {
                            const slideClone = slideTemplate.content.cloneNode(true); // Clone the template
                            const slideDiv = slideClone.querySelector('.slide-item');
                            const imgElement = slideClone.querySelector('.slide-image');
                            const removeButton = slideClone.querySelector('.remove-button'); // Get the remove button
                            const newBadge = slideClone.querySelector('.new-badge');

                            slideDiv.dataset.tempId = image.tempId; // Assign tempId for identification
                            imgElement.src = image.url;
                            imgElement.alt = `Image ${index + 1}`;
                            removeButton.dataset.tempId = image.tempId; // Assign tempId to the remove button

                            // Show/hide the 'NEW' badge
                            newBadge.classList.toggle('hidden', !image.isNew);

                            slidesContainer.appendChild(slideClone); // Add the new slide to the container
                        });

                        // Update carousel button states (disabled/enabled) after slides are rendered
                        updateCarouselButtons();
                    }

                    // 2. Update Thumbnails Container
                    thumbnailStripContainer.innerHTML = ''; // Clear previous thumbnails
                    if (totalImages > 0) {
                        // Create and append thumbnail buttons for each image
                        displayImages.forEach((image, index) => {
                            const thumbClone = thumbnailTemplate.content.cloneNode(true); // Clone the template
                            const thumbButton = thumbClone.querySelector('.thumbnail-button');
                            const thumbImage = thumbClone.querySelector('.thumbnail-image');
                            const removeThumbButton = thumbClone.querySelector('.remove-button-thumb'); // Get the thumb remove button

                            thumbButton.dataset.index = index; // For clicking to navigate
                            thumbButton.dataset.tempId = image.tempId; // For consistency and potential removal via thumb
                            thumbButton.setAttribute('aria-label', `Go to image ${index + 1}`);
                            thumbImage.src = image.url;
                            thumbImage.alt = `Thumbnail ${index + 1}`;
                            removeThumbButton.dataset.tempId = image.tempId; // Assign tempId to the thumb remove button

                            // Highlight the currently active thumbnail
                            const isActive = index === currentSlideIndex;
                            // Apply appropriate ring styles based on active state
                            thumbButton.classList.toggle('ring-2', isActive);
                            thumbButton.classList.toggle('ring-offset-2', isActive);
                            thumbButton.classList.toggle('ring-indigo-500', isActive);
                            thumbButton.classList.toggle('dark:ring-offset-gray-900', isActive);
                            thumbButton.classList.toggle('ring-1', !isActive);
                            thumbButton.classList.toggle('ring-gray-300', !isActive);
                            thumbButton.classList.toggle('dark:ring-gray-600', !isActive);
                            thumbButton.classList.toggle('hover:ring-indigo-400', !isActive);
                            thumbButton.classList.toggle('dark:hover:ring-indigo-500', !isActive);

                            thumbnailStripContainer.appendChild(thumbClone); // Add the new thumbnail to the container
                        });
                        // Ensure the current thumbnail is scrolled into view
                        scrollThumbnailIntoView(currentSlideIndex);
                    }
                    // (Thumbnail strip outer visibility is handled along with placeholderView logic above)

                    // 3. Update Informational Text and Input State
                    imageCountInfo.textContent = `(${totalImages}/${maxFiles})`; // Update count display
                    chooseFilesButtonText.textContent = totalImages > 0 ? 'Add More' : 'Choose Files'; // Change button text

                    const canAddMore = totalImages < maxFiles;
                    // Update limit info/error messages
                    imageLimitInfo.textContent = canAddMore ? `You can add ${maxFiles - totalImages} more file(s).` : '';
                    imageLimitError.textContent = canAddMore ? '' : 'Maximum number of files reached.';
                    imageLimitError.classList.toggle('hidden', !canAddMore); // Show error when cannot add more
                    // Disable/enable the choose files button and input
                    chooseFilesButton.classList.toggle('opacity-50', !canAddMore);
                    chooseFilesButton.classList.toggle('cursor-not-allowed', !canAddMore);
                    fileInput.disabled = !canAddMore;

                    // 4. Update Hidden Input for Deletions
                    // Store the array of IDs to delete as a JSON string
                    deleteImagesInput.value = JSON.stringify(imagesToDelete);

                    // 5. Update the actual file input's FileList
                    // This ensures only newly selected files are submitted with the form
                    updateFileInputState();
                }

                // --- Event Handlers ---

                // Handles when files are selected via the input
                function handleFileChange(event) {
                    const files = Array.from(event.target.files); // Get selected files as an array
                    const currentTotal = getDisplayImages().length; // Get count *before* adding new ones
                    const availableSlots = maxFiles - currentTotal;

                    // If no slots are available, clear the selection and exit
                    if (availableSlots <= 0) {
                        event.target.value = null;
                        return;
                    }

                    let filesAddedCount = 0;
                    let firstAddedIndex = -1; // Track the index where the *first* new image will appear

                    // Process only the files that fit within the limit
                    files.slice(0, availableSlots).forEach(file => {
                        // Basic check for image types
                        if (file.type.startsWith('image/')) {
                            // Prevent adding the exact same file instance again
                            const isDuplicate = newlySelectedFiles.some(item =>
                                item.file.name === file.name &&
                                item.file.size === file.size &&
                                item.file.lastModified === file.lastModified
                            );

                            if (!isDuplicate) {
                                const tempId = `new-${nextTempId++}`; // Generate a unique temp ID for the new file
                                const blobUrl = URL.createObjectURL(file); // Create a temporary URL for preview
                                newlySelectedFiles.push({ file: file, blobUrl: blobUrl, tempId: tempId }); // Add to our state array

                                // Calculate the index of the first added image in the final display list
                                if (firstAddedIndex === -1) {
                                    firstAddedIndex = existingImagesData.filter(img => !imagesToDelete.includes(img.id)).length + filesAddedCount;
                                }
                                filesAddedCount++;
                            }
                        } else {
                            // Optional: Notify user about skipped non-image files
                            console.warn(`Skipped non-image file: ${file.name}`);
                        }
                    });

                    // Reset input value to allow selecting the same file again if needed after removal
                    event.target.value = null;

                    if (filesAddedCount > 0) {
                        // If files were added, navigate to the slide of the first newly added image
                        const finalDisplayImages = getDisplayImages(); // Get the list *after* adding
                        // Use the calculated firstAddedIndex, ensuring it's within bounds
                        currentSlideIndex = Math.max(0, Math.min(firstAddedIndex, finalDisplayImages.length - 1));
                        render(); // Re-render UI, which will use the updated currentSlideIndex
                    } else if (files.length > 0) {
                        // Re-render even if no files were *added* (e.g., if they tried adding > limit)
                        // to ensure limit messages are updated correctly.
                        render();
                    }
                }

                // Handles removing an image (can be called from slide or thumbnail remove buttons)
                function removeImageByTempId(tempIdToRemove) {
                    const displayImages = getDisplayImages(); // Get the current list of displayed images
                    // Find the index of the image to remove using its temporary ID
                    const indexToRemove = displayImages.findIndex(img => img.tempId === tempIdToRemove);

                    if (indexToRemove === -1) return; // Image not found, do nothing

                    const imageToRemove = displayImages[indexToRemove];

                    // Check if it's a newly added file or an existing one
                    if (imageToRemove.isNew) {
                        // It's a new file: find it in the newlySelectedFiles array
                        const newFileIndex = newlySelectedFiles.findIndex(item => item.tempId === tempIdToRemove);
                        if (newFileIndex !== -1) {
                            URL.revokeObjectURL(newlySelectedFiles[newFileIndex].blobUrl); // IMPORTANT: Release memory used by Blob URL
                            newlySelectedFiles.splice(newFileIndex, 1); // Remove from the array
                        }
                    } else {
                        // It's an existing image: add its actual database ID to the imagesToDelete array
                        // Avoid adding duplicates
                        if (imageToRemove.id && !imagesToDelete.includes(imageToRemove.id)) {
                            imagesToDelete.push(imageToRemove.id);
                        }
                    }

                    // --- Adjust Slide Index After Removal ---
                    // Calculate the new total number of images *after* the removal/marking logic above
                    const newTotalImages = getDisplayImages().length;

                    let newIndexToGo = currentSlideIndex; // Start with the current index

                    if (newTotalImages === 0) {
                        // If removing the last image, reset index to 0 (placeholder will show)
                        newIndexToGo = 0;
                    } else if (indexToRemove < currentSlideIndex) {
                        // If the removed image was *before* the current one, decrement the index
                        newIndexToGo = currentSlideIndex - 1;
                    } else if (indexToRemove === currentSlideIndex) {
                        // If the removed image *was* the current one, try to stay at the same index
                        // (which will now show the next image), but clamp it to the new maximum index.
                        newIndexToGo = Math.min(indexToRemove, newTotalImages - 1);
                    }
                    // If the removed image was *after* the current one, the index doesn't need to change.

                    // Ensure the calculated new index is valid (at least 0)
                    currentSlideIndex = Math.max(0, newIndexToGo);

                    render(); // Re-render the UI with the updated state and slide index
                }

                // Navigate to the previous slide
                function prevSlide() {
                    goToSlide(currentSlideIndex - 1);
                }

                // Navigate to the next slide
                function nextSlide() {
                    goToSlide(currentSlideIndex + 1);
                }

                // Core slide navigation logic
                function goToSlide(index) {
                    const totalImages = getDisplayImages().length; // Get current number of displayable images
                    // Clamp the requested index to be within the valid range [0, totalImages - 1]
                    index = Math.max(0, Math.min(index, totalImages - 1));

                    // Handle edge case: if totalImages is 0 after deletion
                    if (totalImages === 0) {
                        currentSlideIndex = 0;
                        render(); // Need a full render if the last image was removed
                        return;
                    }

                    // Only update if the index is actually changing, or if the current index became invalid
                    if (index !== currentSlideIndex || currentSlideIndex >= totalImages) {
                        // Ensure index is corrected if it became invalid after deletion
                        currentSlideIndex = Math.max(0, Math.min(index, totalImages - 1));
                        // Update visual elements directly for better performance than a full render
                        slidesContainer.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
                        updateCarouselButtons(); // Update button states
                        updateThumbnailHighlight(); // Update thumbnail styles
                        scrollThumbnailIntoView(currentSlideIndex); // Make sure thumbnail is visible
                    }
                }

                // --- Event Delegation for Remove Buttons ---
                // Listen for clicks within the main slides container
                slidesContainer.addEventListener('click', (event) => {
                    // Find the closest ancestor element that is a remove button for the main slide
                    const removeButton = event.target.closest('.slide-item .remove-button'); // Be specific
                    // If a remove button was clicked and it has a tempId, call the remove function
                    if (removeButton && removeButton.dataset.tempId) {
                        removeImageByTempId(removeButton.dataset.tempId);
                    }
                });

                // Listen for clicks within the thumbnail strip container
                thumbnailStripContainer.addEventListener('click', (event) => {
                    const thumbButton = event.target.closest('.thumbnail-button');
                    const removeThumbButton = event.target.closest('.remove-button-thumb');

                    // Check if the remove icon on a thumbnail was clicked
                    if (removeThumbButton && removeThumbButton.dataset.tempId) {
                        event.stopPropagation(); // IMPORTANT: Prevent the click from also triggering navigation
                        removeImageByTempId(removeThumbButton.dataset.tempId);
                    }
                    // Otherwise, check if a thumbnail button itself was clicked (for navigation)
                    else if (thumbButton && thumbButton.dataset.index !== undefined) {
                        goToSlide(parseInt(thumbButton.dataset.index, 10));
                    }
                });

                // --- Helper Functions ---

                // Updates the hidden file input to contain only the files currently staged for upload
                function updateFileInputState() {
                    const dataTransfer = new DataTransfer(); // Use DataTransfer to manipulate the FileList
                    newlySelectedFiles.forEach(item => dataTransfer.items.add(item.file)); // Add only new files
                    fileInput.files = dataTransfer.files; // Assign the updated FileList back to the input
                    // This ensures the backend only receives the 'newlySelectedFiles' in `product_images[]`
                }

                // Updates the enabled/disabled state and visibility of carousel controls
                function updateCarouselButtons() {
                    const totalImages = getDisplayImages().length;
                    prevButton.disabled = currentSlideIndex === 0 || totalImages === 0;
                    nextButton.disabled = currentSlideIndex >= totalImages - 1 || totalImages === 0;
                    // Hide controls entirely if only 0 or 1 image
                    carouselControls.classList.toggle('hidden', totalImages <= 1);
                }

                // Updates the visual highlight (ring) on the active thumbnail
                function updateThumbnailHighlight() {
                    thumbnailStripContainer.querySelectorAll('.thumbnail-button').forEach((btn, index) => {
                        // Check if this thumbnail corresponds to the current slide index
                        const isActive = index === currentSlideIndex && getDisplayImages().length > 0;
                        // Toggle appropriate Tailwind classes for active/inactive states
                        btn.classList.toggle('ring-2', isActive);
                        btn.classList.toggle('ring-offset-2', isActive);
                        btn.classList.toggle('ring-indigo-500', isActive);
                        btn.classList.toggle('dark:ring-offset-gray-900', isActive);
                        btn.classList.toggle('ring-1', !isActive);
                        btn.classList.toggle('ring-gray-300', !isActive);
                        btn.classList.toggle('dark:ring-gray-600', !isActive);
                        btn.classList.toggle('hover:ring-indigo-400', !isActive);
                        btn.classList.toggle('dark:hover:ring-indigo-500', !isActive);
                    });
                }

                // Scrolls the thumbnail strip horizontally to ensure the active thumbnail is visible
                function scrollThumbnailIntoView(index) {
                    const thumbnailButton = thumbnailStripContainer.querySelector(`.thumbnail-button[data-index="${index}"]`);
                    if (thumbnailButton) {
                        // Use scrollIntoView with options for smooth behavior and centering if possible
                        thumbnailButton.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest', // Tries to keep it vertically centered
                            inline: 'center' // Tries to horizontally center it
                        });
                    }
                }

                // --- Cleanup ---
                // Add an event listener to revoke Blob URLs when the page is unloaded
                // This helps prevent memory leaks, although it might not fire in all scenarios (e.g., browser crash)
                window.addEventListener('beforeunload', () => {
                    newlySelectedFiles.forEach(item => URL.revokeObjectURL(item.blobUrl));
                });

                // --- Initialization ---
                // Attach primary event listeners
                fileInput.addEventListener('change', handleFileChange);
                prevButton.addEventListener('click', prevSlide);
                nextButton.addEventListener('click', nextSlide);

                // Add keyboard navigation for accessibility (arrow keys for slides)
                container.addEventListener('keydown', (event) => {
                    // Don't interfere if focus is already on a button or within the thumbnail strip
                    if (document.activeElement === prevButton || document.activeElement === nextButton || thumbnailStripContainer.contains(document.activeElement)) {
                        return;
                    }
                    // Allow arrow key navigation when focus is generally within the uploader component
                    if (slidesContainer.contains(document.activeElement) || event.target === container || placeholderView.contains(document.activeElement)) {
                        if (event.key === 'ArrowLeft') {
                            event.preventDefault(); // Prevent page scroll
                            prevSlide();
                        } else if (event.key === 'ArrowRight') {
                            event.preventDefault(); // Prevent page scroll
                            nextSlide();
                        }
                    }
                });


                render(); // Perform the initial render to display existing images and set up the UI
            } // End of initializeImageUploader

        </script>
    @endpush
@endonce