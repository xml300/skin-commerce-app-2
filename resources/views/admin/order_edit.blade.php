@extends('layouts.admin.admin_dashboard')

@section('content')
    {{-- Page Title --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Edit Order <span class="text-base font-normal text-gray-500 dark:text-gray-400">#{{ strtoupper(substr(Crypt::encrypt($order->id), 0,20)) }}</span>
        </h1>
        <a href="{{ route('admin.orders.show', $order->id) }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 dark:focus:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Cancel
        </a>
    </div>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-700 dark:border-red-600 dark:text-red-100" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Or PATCH --}}

            <div class="p-6 space-y-6">
                <input type="text" name="id" value="{{ $order->id }}" hidden>

                {{-- Non-Editable Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">#{{ strtoupper(substr(Crypt::encrypt($order->id), 0,20)) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->user->fullName() ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $order->order_date->format('M d, Y H:i A') }}</p>
                    </div>
                </div>

                {{-- Editable Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Order Status --}}
                    <div>
                        <label for="order_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order Status <span class="text-red-600">*</span></label>
                        <select id="order_status" name="order_status" required
                                class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('order_status') border-red-500 @enderror">
                            @php
                                // Define possible statuses (could also come from config or controller)
                                $statuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'failed'];
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('order_status', $order->order_status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('order_status')
                           <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Add other editable fields as needed --}}
                    {{-- Example: Tracking Number --}}
                    {{-- <div>
                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tracking Number</label>
                        <input type="text" id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('tracking_number') border-red-500 @enderror">
                         @error('tracking_number')
                           <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    {{-- Example: Admin Notes --}}
                    {{-- <div class="md:col-span-2">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Notes</label>
                        <textarea id="admin_notes" name="admin_notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm @error('admin_notes') border-red-500 @enderror">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div> --}}

                </div>

                {{-- Display Order Items (Usually non-editable here, or needs complex JS) --}}
                 <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">Order Items (Read-only)</h3>
                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-md">
                        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                             <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Product</th>
                                    <th scope="col" class="px-4 py-3 text-center">Quantity</th>
                                    <th scope="col" class="px-4 py-3 text-right">Unit Price</th>
                                    <th scope="col" class="px-4 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->orderItems as $item)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $item->product->name ?? 'Product Not Found' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-right">₦{{ number_format($item->product->price, 2) }}</td>
                                        <td class="px-4 py-3 text-right font-medium text-gray-900 dark:text-white">
                                        ₦{{ number_format($item->product->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center px-4 py-6 text-gray-500 dark:text-gray-400">
                                            No items found for this order.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="text-gray-900 dark:text-white font-semibold text-base border-t-2 border-gray-300 dark:border-gray-600">
                                    <td colspan="3" class="px-4 py-3 text-right">Grand Total:</td>
                                    <td class="px-4 py-3 text-right">
                                    ₦{{ number_format($order->orderItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2)}}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div> {{-- End p-6 --}}

            {{-- Form Actions --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                    Update Order
                </button>
            </div>
        </form>
    </div> {{-- End Card --}}

@endsection