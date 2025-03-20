@extends('layouts.user.user_dashboard')
@section('title', 'Order Details')

@section('content')
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[75vh]">
    <header class="mb-12">
        <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-4">Order Details</h1>
        <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker">View the details of your order #{{  strtoupper(substr(Crypt::encrypt($order->id), 0, 20)) }}.</p>
    </header>

    <section id="orderDetails" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md p-6 mb-8">
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-warm-black dark:text-warm-white mb-2">Order Information</h3>
                    <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">General details about your order.</p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Order Number</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ strtoupper(substr(Crypt::encrypt($order->id), 0, 20)) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Order Date</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Order Status</label>
                        <p class="mt-1 text-sm">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-warm-white
                                         {{ $order->order_status == 'pending' ? 'bg-amber-500' : '' }}
                                         {{ $order->order_status == 'processing' ? 'bg-blue-500' : '' }}
                                         {{ $order->order_status == 'shipped' ? 'bg-teal-500' : '' }}
                                         {{ $order->order_status == 'delivered' ? 'bg-green-500' : '' }}
                                         {{ $order->order_status == 'cancelled' ? 'bg-red-500' : '' }}
                                         ">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Payment Status</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ ucfirst($order->payment_status) ?? 'N/A' }}</p> {{-- Assuming you have payment_status --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="shippingDetails" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md p-6 mb-8">
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-warm-black dark:text-warm-white mb-2">Shipping Information</h3>
                    <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Details about shipping and delivery.</p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Shipping Address</label>
                        <address class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">
                            {{ $order->shipping_address?? 'N/A' }}<br> {{-- Adjust based on your address structure --}}
                            <!-- {{ $order->shipping_address->address_line_2 ?? '' }}<br>
                            {{ $order->shipping_address->city ?? 'N/A' }}, {{ $order->shipping_address->state ?? 'N/A' }} {{ $order->shipping_address->zip_code ?? 'N/A' }}<br>
                            {{ $order->shipping_address->country ?? 'N/A' }} -->
                        </address>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Shipping Method</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ $order->shipping_method ?? 'Standard Shipping' }}</p> {{-- Adjust based on your data --}}
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Tracking Number</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ $order->tracking_number ?? 'N/A' }}</p> {{-- Make sure to handle cases where tracking number is not available --}}
                    </div>
                    {{-- Add Estimated Delivery Date if available --}}
                </div>
            </div>
        </div>
    </section>

    <section id="billingDetails" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md p-6 mb-8">
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-warm-black dark:text-warm-white mb-2">Billing Information</h3>
                    <p class="text-sm text-muted-sage-green dark:text-muted-sage-green-darker">Details related to billing and payment.</p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Billing Address</label>
                        <address class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">
                            {{ $order->billing_address ?? 'Same as Shipping' }}<br> {{-- Adjust based on your address structure & logic for same as shipping --}}
                            <!-- {{ $order->billing_address->address_line_2 ?? '' }}<br>
                            {{ $order->billing_address->city ?? 'N/A' }}, {{ $order->billing_address->state ?? 'N/A' }} {{ $order->billing_address->zip_code ?? 'N/A' }}<br>
                            {{ $order->billing_address->country ?? 'N/A' }} -->
                        </address>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-warm-black dark:text-warm-white">Payment Method</label>
                        <p class="mt-1 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ $order->payment_method ?? 'N/A' }}</p> {{-- Adjust based on your data --}}
                    </div>
                    {{-- Add Payment Transaction ID if available --}}
                </div>
            </div>
        </div>
    </section>

    <section id="orderItems" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-6">Order Items</h2>
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full table-auto">
            <thead class="bg-soft-sand-beige dark:bg-warm-black"> {{-- Slightly adjusted header background --}}
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-warm-black dark:text-warm-white text-left"></th> {{-- Empty TH for image --}}
                    <th class="px-4 py-3 text-sm font-medium text-warm-black dark:text-warm-white text-left">Product</th>
                    <th class="px-4 py-3 text-sm font-medium text-warm-black dark:text-warm-white text-left">Price</th>
                    <th class="px-4 py-3 text-sm font-medium text-warm-black dark:text-warm-white text-left">Quantity</th>
                    <th class="px-4 py-3 text-sm font-medium text-warm-black dark:text-warm-white text-right">Subtotal</th> {{-- Right align subtotal header --}}
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr class="border-b border-muted-sage-green dark:border-muted-sage-green-darker hover:bg-soft-sand-beige dark:hover:bg-warm-black transition-colors duration-150"> {{-- Hover effect for rows --}}
                    <td class="px-4 py-4"> {{-- Image cell --}}
                        <div class="w-12 h-12 rounded-md overflow-hidden shadow-sm"> {{-- Container for image --}}
                            <a href="{{ route('product.details', Crypt::encrypt($item->product->id)) }}"> {{-- Link to product page --}}
                                <img src="{{ asset('images/'.'demo'.($item->product->id % 4 + 1).'.jpg') }}"  {{-- Use your actual image path logic --}}
                                     alt="{{ $item->product->product_name }}"
                                     class="w-full h-full object-cover">
                            </a>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium text-warm-black dark:text-warm-white"> {{-- Product Name Cell --}}
                        <a href="{{ route('product.details', Crypt::encrypt($item->product->id)) }}" class="hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200"> {{-- Link styling --}}
                            {{ $item->product->product_name }}
                        </a>
                    </td>
                    <td class="px-4 py-4 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">₦{{ number_format($item->product->price, 2) }}</td>
                    <td class="px-4 py-4 text-sm text-muted-sage-green dark:text-muted-sage-green-darker">{{ $item->quantity }}</td>
                    <td class="px-4 py-4 text-sm font-medium text-warm-black dark:text-warm-white text-right">₦{{ number_format($item->product->price * $item->quantity, 2) }}</td> {{-- Right align subtotal value --}}
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-soft-sand-beige dark:bg-warm-black">
                <tr>
                    <td colspan="4" class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">Subtotal:</td> {{-- Adjusted colspan --}}
                    <td class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">₦{{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount, 2) }}</td> {{-- Right align values in footer --}}
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">Shipping:</td>
                    <td class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">₦{{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">Tax:</td>
                    <td class="px-4 py-3 font-semibold text-sm text-warm-black dark:text-warm-white text-right">₦{{ number_format($order->tax_amount ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-3 font-bold text-lg text-warm-black dark:text-warm-white text-right">Total:</td>
                    <td class="px-4 py-3 font-bold text-lg text-warm-black dark:text-warm-white text-right">₦{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
    {{-- Optional: Order Timeline/History Section --}}
    {{-- <section id="orderTimeline" class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-2xl font-semibold text-warm-black dark:text-warm-white mb-6">Order Timeline</h2>
        </section> --}}

</main>
@endsection