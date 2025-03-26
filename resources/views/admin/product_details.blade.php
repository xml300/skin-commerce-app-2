@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

{{-- Optional: Set the page title dynamically --}}
@section('title', 'Product Details: ' . $product->product_name)

@section('content')
    {{-- Page Header: Title and Actions --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            {{-- Breadcrumbs (Optional but recommended) --}}
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
                        {{ Str::limit($product->product_name, 30) }} {{-- Limit name length in breadcrumb --}}
                    </li>
                </ol>
            </nav>
            {{-- Page Title --}}
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-box-open text-xl text-gray-500 dark:text-gray-400"></i>
                {{ $product->product_name }}
            </h1>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center space-x-2 flex-wrap gap-2">
             {{-- Back to List Button --}}
            <a href="{{ route('admin.products') }}"
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-arrow-left mr-2 -ml-1"></i>
                Back to List
            </a>
            {{-- Edit Product Button --}}
            <a href="{{ route('admin.products.edit', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-pencil-alt mr-2 -ml-1"></i>
                Edit Product
            </a>
        </div>
    </div>

    {{-- Product Details Card --}}
    <div x-data="{}" class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                {{-- Column 1: Image(s) --}}
                <div class="md:col-span-1 space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                        Product Image
                    </h3>
                    {{-- Main Image --}}
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden shadow">
                         <img src="{{ $product->image_url ?? asset('images/placeholder_product_large.png') }}" {{-- Use accessor or placeholder --}}
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-cover">
                    </div>
                    {{-- Optional: Thumbnail Gallery for additional images --}}
                    {{-- <div class="grid grid-cols-4 gap-2">
                        @foreach($product->galleryImages as $image)
                            <div class="aspect-w-1 aspect-h-1 bg-gray-100 dark:bg-gray-600 rounded overflow-hidden cursor-pointer border-2 border-transparent hover:border-indigo-500">
                                <img src="{{ $image->url }}" alt="Thumbnail" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div> --}}
                </div>

                {{-- Column 2: Core Details --}}
                <div class="md:col-span-2 space-y-5">
                     {{-- Section for Basic Info --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Core Information
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            {{-- Product Name (already in title, but can repeat) --}}
                            {{-- <div class="sm:col-span-2">
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $product->product_name }}</dd>
                            </div> --}}

                            {{-- SKU --}}
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

                            {{-- Sale Price (Optional) --}}
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Sale Price</dt>
                                    <dd class="mt-1 text-red-600 dark:text-red-400 font-semibold">₦{{ number_format($product->sale_price, 2) }}</dd>
                                </div>
                            @endif

                            {{-- Stock --}}
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

                             {{-- Weight (Example) --}}
                            {{-- <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Weight</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $product->weight ?? 'N/A' }} {{ $product->weight ? 'kg' : '' }}</dd>
                            </div> --}}

                             {{-- Dimensions (Example) --}}
                            {{-- <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Dimensions (LxWxH)</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $product->dimensions ?? 'N/A' }} {{ $product->dimensions ? 'cm' : '' }}</dd>
                            </div> --}}

                        </dl>
                    </div>

                    {{-- Section for Description --}}
                    <div class="pt-5">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            Description
                        </h3>
                        {{-- Use prose for better typography if Tailwind Typography plugin is installed --}}
                        <div class="prose prose-sm sm:prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                             {{-- If description is plain text and might be long --}}
                             <p class="whitespace-pre-wrap">{{ $product->description }}</p>
                        </div>
                         {{-- Fallback if no description --}}
                        @empty($product->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No description provided.</p>
                        @endempty
                    </div>

                     {{-- Section for Timestamps --}}
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

                </div> {{-- End Column 2 --}}
            </div> {{-- End Grid --}}
        </div> {{-- End Padding Wrapper --}}

        {{-- Card Footer for Actions (Optional place for Delete) --}}
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
           
        <button type="button"
        {{-- Dispatch an event with the product's ID and name --}}
        @click="console.log('Delete button clicked. ID:', {{ $product->id }});
            $dispatch('open-delete-confirm-modal', {
            id: {{ $product->id }},
            name: '{{ e(addslashes($product->product_name)) }}'
        })"
        class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
        title="Delete Product">
        <i class="fas fa-trash-alt mr-1.5 -ml-0.5"></i> Delete Permanently
</button>
        </div>

    </div> {{-- End Card --}}

    @include('layouts.admin.delete_product_modal')

@endsection
