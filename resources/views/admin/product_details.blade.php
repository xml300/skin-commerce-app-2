{{-- resources/views/admin/products/show.blade.php (or similar) --}}

@extends('layouts.admin.admin_dashboard')

@section('title', 'Product Details: ' . $product->product_name)

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        {{-- Breadcrumbs and Title (no changes needed here) --}}
        <div>
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
                    <li class="text-gray-700 dark:text-gray-300" aria-current="page">
                        {{ Str::limit($product->product_name, 30) }}
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-box-open text-xl text-gray-500 dark:text-gray-400"></i>
                {{ $product->product_name }}
            </h1>
        </div>

        {{-- Action Buttons (no changes needed here) --}}
        <div class="flex items-center space-x-2 flex-wrap gap-2">
            <a href="{{ route('admin.products') }}"
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-arrow-left mr-2 -ml-1"></i>
                Back to List
            </a>
            <a href="{{ route('admin.products.edit', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-pencil-alt mr-2 -ml-1"></i>
                Edit Product
            </a>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                {{-- *** START: Redesigned Product Image Section *** --}}
                <div class="md:col-span-1 space-y-4"
                     x-data="{
                        mainImageUrl: '{{ $product->productImages->isNotEmpty() ? asset('storage/'.$product->productImages->first()->image_url) : asset('images/placeholder_product_large.png') }}',
                        images: {{ Js::from($product->productImages->map(fn($img) => ['id' => $img->id, 'url' => asset('storage/'.$img->image_url)])) }},
                        placeholderUrl: '{{ asset('images/placeholder_product_large.png') }}'
                     }"
                     x-init="mainImageUrl = images.length > 0 ? images[0].url : placeholderUrl">

                    <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                        Product Images
                    </h3>

                    {{-- Main Image Display --}}
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden shadow">
                         <img :src="mainImageUrl"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-cover"
                             {{-- Optional: Add error handling for broken images --}}
                             onerror="this.onerror=null; this.src='{{ asset('images/placeholder_product_large.png') }}';">
                    </div>

                    {{-- Thumbnails --}}
                    {{-- Only show thumbnails if there's more than one image --}}
                    <template x-if="images.length > 1">
                        <div class="grid grid-cols-4 gap-2">
                            <template x-for="(image, index) in images" :key="image.id">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100 dark:bg-gray-600 rounded overflow-hidden cursor-pointer border-2 hover:border-indigo-400 dark:hover:border-indigo-500"
                                     :class="{
                                        'border-indigo-500 dark:border-indigo-600 ring-2 ring-indigo-300 dark:ring-indigo-500 ring-offset-1 dark:ring-offset-gray-800': mainImageUrl === image.url,
                                        'border-transparent': mainImageUrl !== image.url
                                     }"
                                     @click="mainImageUrl = image.url"
                                     role="button"
                                     :aria-label="'View image ' + (index + 1)"
                                     tabindex="0">
                                    <img :src="image.url"
                                         :alt="'Thumbnail ' + (index + 1) + ' for ' + '{{ e($product->product_name) }}'"
                                         class="w-full h-full object-cover"
                                         loading="lazy" {{-- Add lazy loading for thumbs --}}
                                         onerror="this.onerror=null; this.src='{{ asset('images/placeholder_product_small.png') }}';"> {{-- Optional: Small placeholder for thumb errors --}}
                                </div>
                            </template>
                        </div>
                    </template>
                     {{-- Message if no images are available --}}
                    <template x-if="images.length === 0">
                         <p class="text-sm text-gray-500 dark:text-gray-400 italic">No product images available.</p>
                    </template>
                </div>
                {{-- *** END: Redesigned Product Image Section *** --}}

                {{-- Product Details Section (no changes needed here) --}}
                <div class="md:col-span-2 space-y-5">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Core Information
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            {{-- Product ID --}}
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Product ID</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $product->id ?? 'N/A' }}</dd>
                            </div>
                            {{-- Category --}}
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $product->category->category_name ?? 'N/A' }}</dd>
                            </div>
                            {{-- Price --}}
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Price</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white font-semibold">₦{{ number_format($product->price, 2) }}</dd>
                            </div>
                            {{-- Sale Price --}}
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Sale Price</dt>
                                    <dd class="mt-1 text-red-600 dark:text-red-400 font-semibold">₦{{ number_format($product->sale_price, 2) }}</dd>
                                </div>
                            @endif
                            {{-- Stock Quantity --}}
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Stock Quantity</dt>
                                @php
                                    $stock = $product->stock_quantity ?? 0;
                                    $stockColor = match (true) {
                                        $stock <= 0 => 'text-red-600 dark:text-red-400 font-semibold',
                                        $stock <= 10 => 'text-yellow-600 dark:text-yellow-400 font-semibold',
                                        default => 'text-green-600 dark:text-green-400',
                                    };
                                @endphp
                                <dd class="mt-1 {{ $stockColor }}">{{ $stock }} units</dd>
                            </div>
                            {{-- Status --}}
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                @php
                                    $status = strtolower($product->status ?? 'draft');
                                    $statusBadge = match($status) {
                                        'published' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                        'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                        'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                    };
                                @endphp
                                <dd class="mt-1">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Description --}}
                    <div class="pt-5">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Description
                        </h3>
                        <div class="prose prose-sm sm:prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                             <p class="whitespace-pre-wrap">{{ $product->description }}</p>
                        </div>
                        @empty($product->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No description provided.</p>
                        @endempty
                    </div>

                    {{-- History --}}
                     <div class="pt-5">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            History
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                             <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">
                                    {{ $product->created_at ? $product->created_at->format('M d, Y H:i A') : 'N/A' }}
                                    ({{ $product->created_at ? $product->created_at->diffForHumans() : '' }})
                                </dd>
                            </div>
                             <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">
                                     {{ $product->updated_at ? $product->updated_at->format('M d, Y H:i A') : 'N/A' }}
                                     ({{ $product->updated_at ? $product->updated_at->diffForHumans() : '' }})
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Footer / Delete Button (no changes needed here) --}}
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
            <button type="button"
                @click="$dispatch('open-delete-confirm-modal', {
                    id: {{ $product->id }},
                    name: '{{ e(addslashes($product->product_name)) }}'
                })"
                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                title="Delete Product">
                <i class="fas fa-trash-alt mr-1.5 -ml-0.5"></i> Delete Permanently
            </button>
        </div>
    </div>

    @include('layouts.admin.delete_product_modal')

@endsection

{{-- Make sure Alpine.js is included in your admin_dashboard layout --}}
{{-- Also ensure you have the @js Blade directive available (standard in Laravel 9+) or use json_encode --}}