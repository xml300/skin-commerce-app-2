@extends('layouts.admin.admin_dashboard')

@section('content')
    {{-- Page Header: Title and Actions --}}
    <div x-data="{}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Customer Details: {{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Viewing details for customer #{{ $customer->id }}.
            </p>
        </div>
        <div class="flex items-center space-x-2">
             {{-- Back Button --}}
            <a href="{{ route('admin.customers') }}" {{-- Adjust route name if needed --}}
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 dark:focus:ring-gray-700 active:bg-gray-400 dark:active:bg-gray-500 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-arrow-left mr-2 -ml-1"></i>
                Back to List
            </a>
            {{-- Edit Button --}}
            <a href="{{ route('admin.customers.edit', $customer->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-pencil-alt mr-2 -ml-1"></i>
                Edit Customer
            </a>
            {{-- Delete Button (Triggers Modal) --}}
             {{-- Add x-data for modal control if not already in layout --}}
            <button type="button"
                    x-data="{ customerId: {{ $customer->id }}, customerName: '{{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}' }"
                    @click="$dispatch('open-delete-modal', { id: customerId, name: customerName, url: '{{ route('admin.customers.destroy', $customer->id) }}' })"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-300 dark:focus:ring-red-700 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
                <i class="fas fa-trash-alt mr-2 -ml-1"></i>
                Delete
            </button>
        </div>
    </div>

    {{-- Customer Details Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Customer Information
            </h3>
        </div>
        <div class="px-6 py-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                {{-- Basic Info --}}
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->email }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->phone_number ?? 'N/A' }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Since</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->created_at->format('M d, Y, h:i A') }}</dd>
                </div>

                 {{-- Status --}}
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                         @php
                             $isActive = $customer->is_active ?? true; // Default to true if not set
                             $statusColor = $isActive
                                 ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                                 : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100';
                             $statusText = $isActive ? 'Active' : 'Inactive';
                         @endphp
                         <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                             {{ $statusText }}
                         </span>
                    </dd>
                </div>

                {{-- Order Info (Example) --}}
                 <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</dt>
                    {{-- You might need to load this relation: $customer->loadCount('orders') in controller --}}
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $customer->orders->count() ?? 'N/A' }}</dd>
                 </div>

                {{-- Address Info --}}
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($customer->address_line_1 || $customer->city || $customer->state)
                            {{ $customer->address_line_1 ?? '' }}<br>
                            {{ $customer->address_line_2 ? $customer->address_line_2 . '<br>' : '' }}
                            {{ $customer->city ?? '' }}{{ $customer->city && $customer->state ? ',' : '' }} {{ $customer->state ?? '' }} {{ $customer->postal_code ?? '' }}<br>
                            {{ $customer->country ?? '' }}
                        @else
                            N/A
                        @endif
                    </dd>
                </div>

                {{-- Add more fields as needed (e.g., Notes, Last Login) --}}

            </dl>
        </div>
    </div>

    {{-- Include Delete Modal (if it's a shared component) --}}
    @include('layouts.admin.customer_modal')
     {{-- Or place the modal code directly here or in the main layout --}}

@endsection