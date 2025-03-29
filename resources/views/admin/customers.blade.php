@extends('layouts.admin.admin_dashboard')

@section('content')

    <div x-data="{}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Customer Management
        </h1>

        <a href="#"
            @click.prevent="$dispatch('open-add-customer-modal')"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Customer
        </a>
    </div>


    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">

        
        <form method="GET" action="{{ route('admin.customers') }}"> 
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white whitespace-nowrap">All Customers</h3>
                <div class="w-full sm:w-1/3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        
                        <input type="search" name="search" placeholder="Search name, email..."
                            value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        
                        
                    </div>
                </div>
            </div>
        </form>


        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Registered</th>
                        <th scope="col" class="px-6 py-3 text-center">Orders</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($users as $customer)
                        <tr
                            class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">

                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                #{{ $customer->id }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                
                                {{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->email }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $customer->created_at->format('M d, Y') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                
                                {{ $customer->orders_count ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    // Ensure is_active attribute exists or provide default
                                    $isActive = $customer->is_active ?? true;
                                    $statusColor = $isActive
                                        ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                                        : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100';
                                    $statusText = $isActive ? 'Active' : 'Inactive';
                                @endphp
                                <span
                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">

                                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                                        class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400
                                        transition-colors duration-150"
                                        title="View Customer">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                        class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400
                                        transition-colors duration-150"
                                        title="Edit Customer">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>


                                    <button type="button"
                                        x-data="{ customerId: {{ $customer->id }}, customerName: '{{ addslashes($customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name)) }}' }" 
                                        @click="$dispatch('open-delete-modal', { id: customerId, name: customerName, url: '{{ route('admin.customers.destroy', $customer->id) }}' })"
                                        class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition-colors duration-150"
                                        title="Delete Customer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>
                             
                            <td colspan="7"
                                class="text-center px-6 py-16">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-{{ request('search') ? 'search' : 'user-slash' }} fa-3x mb-4"></i> 
                                    <p class="text-xl font-medium mb-1">
                                        {{ request('search') ? 'No Customers Found Matching "' . e(request('search')) . '"' : 'No Customers Found' }}
                                    </p>
                                    <p class="text-sm">
                                         {{ request('search') ? 'Try refining your search criteria.' : 'There are currently no customer records to display.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif

    </div>


    
    @include('layouts.admin.customer_modal') 
@endsection