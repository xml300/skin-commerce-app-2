@extends('layouts.admin.admin_dashboard') 




@section('content')


<div x-data="{
        deleteModalOpen: false,
        addModalOpen: false,
        orderIdToDelete: null,
        orderIdentifierToDelete: '', 
        deleteFormAction: ''
     }"
     @keydown.escape.window="deleteModalOpen = false; addModalOpen = false" 
>

    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Order Management</h1>
        
        <button @click="addModalOpen = true"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            Add New Order
        </button>
    </div>

    
    @if ($errors->hasBag('addOrder'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-700 dark:border-red-600 dark:text-red-100" role="alert">
            <strong class="font-bold">Error Adding Order!</strong>
            <span class="block sm:inline">Please check the form below.</span>
             
        </div>
    @endif
    @if (session('status')) 
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-700 dark:border-green-600 dark:text-green-100" role="alert">
            {{ session('status') }}
        </div>
    @endif


    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Customer</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            
                            $displayOrderId = '#' . strtoupper(substr(Crypt::encrypt($order->id), 0, 20));
                            
                            
                        @endphp
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $displayOrderId }}
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ $order->user->fullName() ?? 'N/A' }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $order->order_date->format('M d, Y') }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                            ₦{{ number_format($order->orderitems->sum(function ($item){ return $item->product->price * $item->quantity;}), 2) }}
                            </td>
                            
                            <td class="px-6 py-4">
                                @php
                                    $status = strtolower($order->order_status);
                                     $badgeColor = match($status) {
                                        'completed', 'delivered' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                        'processing', 'shipped' => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                        'cancelled', 'failed' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                    
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-150"
                                       title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                       class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-150"
                                       title="Edit Order">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    
                                    <button @click.prevent="
                                                orderIdToDelete = {{ $order->id }};
                                                orderIdentifierToDelete = '{{ $displayOrderId }}';
                                                deleteFormAction = '{{ route('admin.orders.destroy', $order->id) }}';
                                                deleteModalOpen = true;
                                            "
                                            class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-150"
                                            title="Delete Order">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-12">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p class="text-lg font-medium">No orders found.</p>
                                    <p class="text-sm">There are currently no orders to display.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        @if ($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $orders->links() }}
        </div>
        @endif
    </div> 


    
    <div x-show="addModalOpen"
         style="display: none;" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center px-4 py-6"
         aria-labelledby="add-order-modal-title"
         role="dialog"
         aria-modal="true"
    >
        <div @click.outside="addModalOpen = false"
             x-show="addModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden max-w-lg w-full"
        >
            
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 id="add-order-modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
                    Add New Order
                </h2>
                <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    
                    @if ($errors->any() && $errors->hasBag('addOrder'))
                       <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-700 dark:border-red-600 dark:text-red-100" role="alert">
                           <ul class="list-disc list-inside text-sm">
                               @foreach ($errors->addOrder->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                    @endif

                    
                    <div>
                        <label for="add_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Customer <span class="text-red-600">*</span>
                            <span class="text-xs text-gray-500">(Select existing customer)</span>
                        </label>
                        
                        <select id="add_user_id" name="user_id" required
                                class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('user_id', 'addOrder') border-red-500 is-invalid @enderror">
                            <option value="">-- Select Customer --</option>
                            
                            @isset($customers)
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->fullName() }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No customers available</option>
                            @endisset
                        </select>
                        @error('user_id', 'addOrder')
                           <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    
                     <div>
                        <label for="add_order_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Initial Status <span class="text-red-600">*</span></label>
                        <select id="add_order_status" name="order_status" required
                                class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('order_status', 'addOrder') border-red-500 is-invalid @enderror">
                            @php $statuses = ['pending', 'processing']; @endphp 
                             @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('order_status', 'pending') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                         @error('order_status', 'addOrder')
                           <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                     
                    {{-- <div>
                        <label for="add_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                        <textarea id="add_notes" name="notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('notes', 'addOrder') border-red-500 is-invalid @enderror">{{ old('notes') }}</textarea>
                         @error('notes', 'addOrder')
                           <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div> --}}

                     <p class="text-xs text-gray-500 dark:text-gray-400">
                        Note: Order items and further details can be added/edited after creation.
                    </p>

                </div>

                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-900">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div x-show="deleteModalOpen"
         style="display: none;" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center px-4 py-6"
         aria-labelledby="delete-modal-title"
         role="dialog"
         aria-modal="true"
         >
        <div @click.outside="deleteModalOpen = false"
             x-show="deleteModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden max-w-md w-full"
             >
            
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 id="delete-modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirm Deletion
                </h2>
                <button @click="deleteModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            
            <div class="p-6">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Are you sure you want to delete Order <strong x-text="orderIdentifierToDelete" class="font-medium text-gray-900 dark:text-white"></strong>?
                </p>
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    This action cannot be undone.
                </p>
            </div>

            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-900">
                    Cancel
                </button>
                
                <form :action="deleteFormAction" method="POST" class="inline" id="deleteOrderForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-300 dark:focus:ring-red-700 disabled:opacity-25 transition ease-in-out duration-150">
                        Delete Order
                    </button>
                </form>
            </div>
        </div>
    </div>

</div> 
@endsection