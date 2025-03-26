@extends('layouts.admin.admin_dashboard')

@section('content')
    {{-- Page Title & Actions --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Order Details <span class="text-base font-normal text-gray-500 dark:text-gray-400">#{{ strtoupper(substr(Crypt::encrypt($order->id), 0, 20))  }}</span> {{-- Or your preferred ID format --}}
        </h1>
        <div>
            <a href="{{ route('admin.orders') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 dark:focus:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
            <a href="{{ route('admin.orders.edit', $order->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-pencil-alt mr-2"></i> Edit Order
            </a>
             {{-- Optional: Add Print Button or Delete Trigger Here if needed --}}
        </div>
    </div>

    {{-- Order Details Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6 space-y-6">

            {{-- Order Summary Section --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Order Information</h3>
                    <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex justify-between">
                            <dt>Order ID:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">#{{ strtoupper(substr(Crypt::encrypt($order->id), 0, 20)) }}</dd> {{-- Or your preferred ID format --}}
                        </div>
                        <div class="flex justify-between">
                            <dt>Order Date:</dt>
                            <dd>{{ $order->order_date->format('M d, Y H:i A') }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt>Status:</dt>
                            <dd>
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
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Customer Details</h3>
                    <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        @if($order->user)
                        <div class="flex justify-between">
                            <dt>Name:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $order->user->fullName() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Email:</dt>
                            <dd><a href="mailto:{{ $order->user->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $order->user->email }}</a></dd>
                        </div>
                        {{-- Add Phone Number if available --}}
                        <div class="flex justify-between">
                            <dt>Phone:</dt>
                            <dd>{{ $order->user->phone ?? 'N/A' }}</dd>
                        </div>
                        @else
                        <div><dt>Customer:</dt> <dd>N/A</dd></div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Payment & Shipping</h3>
                    <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex justify-between">
                            <dt>Payment Method:</dt>
                            <dd>{{ $order->payment_method ?? 'N/A' }}</dd> {{-- Adjust field name --}}
                        </div>
                        <div class="flex justify-between">
                            <dt>Payment Status:</dt>
                            <dd>{{ $order->payment_status ?? 'N/A' }}</dd> {{-- Adjust field name --}}
                        </div>
                        <div class="flex justify-between">
                            <dt>Shipping Method:</dt>
                            <dd>{{ $order->shipping_method ?? 'N/A' }}</dd> {{-- Adjust field name --}}
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Address Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                 <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Shipping Address</h3>
                    @if($order->shippingAddress) {{-- Assuming you have a relationship or fields --}}
                        <address class="text-sm text-gray-600 dark:text-gray-400 not-italic">
                            {{ $order->shippingAddress->address_line_1 ?? '' }}<br>
                            {{ $order->shippingAddress->address_line_2 ? $order->shippingAddress->address_line_2 . '<br>' : '' }}
                            {{ $order->shippingAddress->city ?? '' }}, {{ $order->shippingAddress->state ?? '' }} {{ $order->shippingAddress->postal_code ?? '' }}<br>
                            {{ $order->shippingAddress->country ?? '' }}
                        </address>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No shipping address provided.</p>
                    @endif
                </div>
                 <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Billing Address</h3>
                     @if($order->billingAddress) {{-- Assuming you have a relationship or fields --}}
                        <address class="text-sm text-gray-600 dark:text-gray-400 not-italic">
                            {{ $order->billingAddress->address_line_1 ?? '' }}<br>
                            {{ $order->billingAddress->address_line_2 ? $order->billingAddress->address_line_2 . '<br>' : '' }}
                            {{ $order->billingAddress->city ?? '' }}, {{ $order->billingAddress->state ?? '' }} {{ $order->billingAddress->postal_code ?? '' }}<br>
                            {{ $order->billingAddress->country ?? '' }}
                        </address>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No billing address provided (or same as shipping).</p>
                    @endif
                </div>
            </div>

            {{-- Order Items Section --}}
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Order Items</h3>
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
                            @forelse($order->orderItems as $item) {{-- Assuming 'orderItems' relationship --}}
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $item->product->product_name ?? 'Product Not Found' }} {{-- Assuming item->product->name --}}
                                        {{-- You might want to add SKU or other identifiers here --}}
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
                        {{-- Order Totals Footer --}}
                        <tfoot>
                            {{-- Subtotal Row --}}
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td colspan="3" class="px-4 py-2 text-right font-medium">Subtotal:</td>
                                <td class="px-4 py-2 text-right font-medium">
                                ₦{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}
                                </td>
                            </tr>
                            {{-- Shipping Row (Example) --}}
                            @if(isset($order->shipping_cost))
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td colspan="3" class="px-4 py-2 text-right font-medium">Shipping:</td>
                                <td class="px-4 py-2 text-right font-medium">
                                ₦{{ number_format($order->shipping_cost, 2) }}
                                </td>
                            </tr>
                            @endif
                             {{-- Tax Row (Example) --}}
                            @if(isset($order->tax_amount))
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td colspan="3" class="px-4 py-2 text-right font-medium">Tax:</td>
                                <td class="px-4 py-2 text-right font-medium">
                                ₦{{ number_format($order->tax_amount, 2) }}
                                </td>
                            </tr>
                            @endif
                            {{-- Grand Total Row --}}
                            <tr class="text-gray-900 dark:text-white font-semibold text-base border-t-2 border-gray-300 dark:border-gray-600">
                                <td colspan="3" class="px-4 py-3 text-right">Grand Total:</td>
                                <td class="px-4 py-3 text-right">
                                ₦{{ number_format($order->orderItems->sum(function($item) { return $item->product->price * $item->quantity; }) + $order->shipping_cost + $order->tax_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Order Notes/History (Optional) --}}
            {{-- <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Order Notes</h3>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md text-sm text-gray-600 dark:text-gray-300">
                    {{ $order->notes ?? 'No notes for this order.' }}
                </div>
            </div> --}}

        </div> {{-- End p-6 --}}
    </div> {{-- End Card --}}

@endsection