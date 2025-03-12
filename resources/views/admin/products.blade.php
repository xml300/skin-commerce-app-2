@extends('layouts.admin.admin_dashboard')
@section('content')
<div class="container mx-auto p-4 md:p-8 lg:p-10">
    <header class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
            Product Management
        </h1>
    </header>

    <section class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                Product List
            </h2>
            <button id="addProductButton"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800"
                type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 inline-block align-middle mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Product
            </button>
        </div>

        <div id="productList" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
            <p class="text-gray-600 dark:text-gray-400">Product list table will go here. (This is a placeholder)</p>
            {{-- Product List Table will be inserted here --}}
        </div>
    </section>

    <!-- Add Product Modal (If needed on this page) -->
    {{-- @include('admin.products.partials.add_edit_modal') --}} {{-- Example of including a modal partial --}}

</div>
@endsection