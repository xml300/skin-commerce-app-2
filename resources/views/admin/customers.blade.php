@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

@section('content')
    {{-- Page Header: Title and Add Button --}}
    <div x-data="{}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Customer Management
        </h1>
        {{-- Add New Customer Button --}}
        <a href="#" {{-- Replace with your route('admin.customers.create') or JS for modal --}}
            @click.prevent="$dispatch('open-add-customer-modal')"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Customer
        </a>
    </div>

    {{-- Customer List Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        {{-- Optional: Card Header for Filters/Search (Uncomment and customize if needed) --}}
        {{-- <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">All Customers</h3>
            <div class="w-full sm:w-1/3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="search" placeholder="Search customers..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
        </div> --}}

        {{-- Table Container for Responsiveness --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Registered</th>
                        <th scope="col" class="px-6 py-3 text-center">Orders</th> {{-- Example: Order count --}}
                        <th scope="col" class="px-6 py-3 text-center">Status</th> {{-- Example: Active/Inactive --}}
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through customers --}}
                    @forelse($users as $customer) {{-- Assuming you pass $customers from controller --}}
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        {{-- ID --}}
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            #{{ $customer->id }}
                                        </td>
                                        {{-- Name --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }} {{-- Use
                                            helper or combine --}}
                                        </td>
                                        {{-- Email --}}
                                        <td class="px-6 py-4">
                                            {{ $customer->email }}
                                        </td>
                                        {{-- Registered Date --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $customer->created_at->format('M d, Y') }} {{-- Format date --}}
                                        </td>
                                        {{-- Order Count (Example - Requires eager loading 'orders') --}}
                                        <td class="px-6 py-4 text-center">
                                            {{ $customer->orders_count ?? 'N/A' }} {{-- Use orders_count if loaded --}}
                                        </td>
                                        {{-- Status (Example) --}}
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $isActive = $customer->is_active ?? true; // Assume active if no status field
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
                                        {{-- Action Buttons --}}
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center space-x-3">
                                                {{-- View Action --}}
                                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                                    class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400
                                                    transition-colors duration-150"
                                                    title="View Customer">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                {{-- Edit Action --}}
                                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                    class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400
                                                    transition-colors duration-150"
                                                    title="Edit Customer">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                {{-- Delete Action --}}
                                   
                                                    <button type="button"
                                                        x-data="{ customerId: {{ $customer->id }}, customerName: '{{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}' }"
                                                        @click="$dispatch('open-delete-modal', { id: customerId, name: customerName, url: '{{ route('admin.customers.destroy', $customer->id) }}' })"
                                                        class="text-gray-500 hover:text-red-600 ...">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                            </div>
                                        </td>
                                    </tr>
                    @empty
                        {{-- State when no customers are found --}}
                        <tr>
                            <td colspan="7" {{-- Adjust colspan based on the number of columns --}}
                                class="text-center px-6 py-16">
                                <div class="text-gray-500 dark:text-gray-400">
                                    {{-- Using a different icon for variety --}}
                                    <i class="fas fa-user-slash fa-3x mb-4"></i>
                                    <p class="text-xl font-medium mb-1">No Customers Found</p>
                                    <p class="text-sm">There are currently no customer records to display.</p>
                                    {{-- Optional: Link to add customer --}}
                                    {{-- <a href="#"
                                        class="mt-4 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add First Customer
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> {{-- End overflow-x-auto --}}

        {{-- Pagination (If using pagination) --}}
        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $users->links() }} {{-- Ensure pagination views are styled for Tailwind --}}
            </div>
        @endif

    </div> {{-- End Card --}}

    {{-- Placeholder for Add/Edit Modals (if using modals instead of separate pages) --}}
    {{-- <div id="customerModal" class="fixed inset-0 z-50 hidden ..."> ... Modal Content ... </div> --}}

    @include('layouts.admin.customer_modal')
@endsection