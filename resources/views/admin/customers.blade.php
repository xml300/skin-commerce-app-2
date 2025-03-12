@extends('layouts.admin.admin_dashboard')
@section('content')
    <div class="container mx-auto p-4 md:p-8 lg:p-10">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">
                Customer Management
            </h1>
        </header>

        <section class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                    Customer List
                </h2>
                <button id="addNewCustomerButton"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 dark:bg-blue-700 dark:hover:bg-blue-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 inline-block align-middle mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add New Customer
                </button>
            </div>

            <div id="customerList" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4 overflow-x-auto">
                <p class="text-gray-600 dark:text-gray-400">Customer list table will go here. (This is a placeholder)</p>
                {{-- Customer List Table will be inserted here --}}
            </div>
        </section>

        {{-- Customer Details Modal or other customer related sections can be added here --}}

    </div>
@endsection