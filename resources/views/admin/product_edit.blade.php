@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

{{-- Set the page title dynamically --}}
@section('title', 'Edit Product: ' . $product->product_name)

@section('content')
    {{-- Page Header: Title and Actions --}}
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
                         <a href="{{ route('admin.products.details', $product->id) }}" class="hover:text-indigo-600">{{ Str::limit($product->product_name, 30) }}</a>
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
             {{-- Back to Details Button --}}
            <a href="{{ route('admin.products.details', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-eye mr-2 -ml-1"></i>
                View Details
            </a>
        </div>
    </div>

    {{-- Edit Form --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- CSRF Protection --}}
        @method('PUT') {{-- Method spoofing for UPDATE --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Content Column (Fields) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Product Details Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Product Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Product Name --}}
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" id="product_name" name="product_name"
                                   value="{{ old('product_name', $product->product_name) }}" required
                                   class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('product_name') border-red-500 @enderror">
                            @error('product_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea id="description" name="description" rows="6"
                                      class="p-3 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                                      >{{ old('description', $product->description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Provide a detailed description of the product. Supports basic HTML if needed (ensure proper sanitization on backend).</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            {{-- Consider adding a WYSIWYG editor like TinyMCE or CKEditor here --}}
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
                         {{-- Price --}}
                        <div> 
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Regular Price (₦) <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" step="0.01" min="0" required
                                   value="{{ old('price', $product->price) }}"
                                   class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sale Price --}}
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sale Price (₦)</label>
                            <input type="number" id="sale_price" name="sale_price" step="0.01" min="0"
                                   value="{{ old('sale_price', $product->sale_price) }}"
                                   placeholder="Optional"
                                   class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('sale_price') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank if not on sale.</p>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock Quantity --}}
                         <div class="sm:col-span-2">
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                            <input type="number" id="stock_quantity" name="stock_quantity" min="0" required
                                   value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                                   class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column (Category, Status, Image) --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Organize Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                     <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Organization
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Category --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                    class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category_id') border-red-500 @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category) {{-- Assuming $categories is passed from controller --}}
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
                        {{-- <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-500">*</span></label>
                            <select id="status" name="status" required
                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-500 @enderror">
                                <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>
                </div>

                 {{-- Product Image Card --}}
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Product Image
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                         {{-- Current Image Preview --}}
                        <div>
                             <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Image</label>
                             <img src="{{ $product->image_url ?? asset('images/placeholder_product_medium.png') }}"
                                  alt="Current product image"
                                  class="h-32 w-32 object-cover rounded-md shadow-sm bg-gray-100 dark:bg-gray-700">
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload New Image</label>
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 dark:file:bg-gray-600 file:text-indigo-700 dark:file:text-indigo-100
                                          hover:file:bg-indigo-100 dark:hover:file:bg-gray-500
                                          @error('image') border border-red-500 rounded-md @enderror">
                             <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to keep the current image. Max file size: 2MB. Allowed types: JPG, PNG, GIF, WEBP.</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions Footer --}}
        <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
             <a href="{{ route('admin.products.details', $product->id) }}"
                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                 Cancel
             </a>
             <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                 {{-- Optional: Add a loading spinner here --}}
                 Save Changes
            </button>
        </div>

    </form>

@endsection

@push('scripts')
    {{-- Add scripts for WYSIWYG editor initialization if used --}}
    {{-- <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#description',
        plugins: '...', // Configure plugins
        toolbar: '...', // Configure toolbar
        // Add dark mode support if needed based on your layout's dark mode toggle
      });
    </script> --}}
@endpush