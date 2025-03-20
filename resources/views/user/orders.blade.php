@extends('layouts.user.user_dashboard')
@section('title', 'My Orders')

@section('content')
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[75vh]">
    <header class="mb-12">
        <h1 class="text-4xl font-semibold text-warm-black dark:text-warm-white mb-4">My Orders</h1>
        <p class="text-lg text-muted-sage-green dark:text-muted-sage-green-darker">Track and manage your skincare orders.</p>
    </header>

    <section id="orderFilter" class="mb-8">
        <h2 class="text-lg font-medium text-warm-black dark:text-warm-white mb-3">Filter by Order Status {{  request()->get('status') == 'pending' }}</h2>
        <div class="flex max-w-full gap-3 overflow-x-auto pb-2 custom-scrollbar">
            <a href="{{ route('orders.get') }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                       hover:bg-muted-sage-green  dark:hover:bg-antique-gold
                     hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == null ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : 'bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="">
                All Orders
            </a>
            <a href="{{ route('orders.get', ['status' => 'pending']) }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                      hover:bg-muted-sage-green dark:hover:bg-antique-gold
                    hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == 'pending' ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : ' bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="pending">
                Pending
            </a>
            <a href="{{ route('orders.get', ['status' => 'processing']) }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                       hover:bg-muted-sage-green  dark:hover:bg-antique-gold
                       hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == 'processing' ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : 'bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="processing">
                Processing
            </a>
            <a href="{{ route('orders.get', ['status' => 'shipped']) }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                       hover:bg-muted-sage-green  dark:hover:bg-antique-gold
                      hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == 'shipped' ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : 'bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="shipped">
                Shipped
            </a>
            <a href="{{ route('orders.get', ['status' => 'delivered']) }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                       hover:bg-muted-sage-green  dark:hover:bg-antique-gold
                     e hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == 'delivered' ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : 'bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="delivered">
                Delivered
            </a>
            <a href="{{ route('orders.get', ['status' => 'cancelled']) }}"
               class="status-filter-button inline-block px-4 py-2 rounded-full text-sm font-medium text-center
                    hover:bg-muted-sage-green  dark:hover:bg-antique-gold
                      hover:text-warm-black dark:hover:text-warm-white
                      transition-colors duration-200 shadow-md hover:shadow-lg
                      {{ request()->get('status') == 'cancelled' ? 'bg-muted-sage-green-darker dark:bg-antique-gold text-warm-white dark:text-warm-black font-semibold' : 'bg-soft-sand-beige dark:bg-warm-black text-warm-black dark:text-warm-white' }}"
                      data-status="cancelled">
                Cancelled
            </a>
        </div>
    </section>

    <section id="orderList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Adjusted grid for larger screens --}}
        @if(count($orders) > 0)
            @foreach($orders as $order)
            <div class="bg-warm-white dark:bg-warm-black rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
                <a href="{{ route('user.orders.show',  Crypt::encrypt($order->id)) }}" class="block">
                    <div class="p-6"> {{-- Increased padding for better spacing --}}
                        <div class="flex justify-between items-start mb-4"> {{-- Flex for order number and status badge --}}
                            <div>
                                <h3 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-1">Order #{{ strtoupper(substr(Crypt::encrypt($order->id),0, 20)) }}</h3>
                                <p class="text-muted-sage-green dark:text-muted-sage-green-darker text-sm">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-warm-white
                                             {{ $order->order_status == 'pending' ? 'bg-amber-500' : '' }}
                                             {{ $order->order_status == 'processing' ? 'bg-blue-500' : '' }}
                                             {{ $order->order_status == 'shipped' ? 'bg-teal-500' : '' }}
                                             {{ $order->order_status == 'delivered' ? 'bg-green-500' : '' }}
                                             {{ $order->order_status == 'cancelled' ? 'bg-red-500' : '' }}
                                             ">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4"> {{-- Order Items Summary --}}
                            <h4 class="text-md font-medium text-warm-black dark:text-warm-white mb-2">Items:</h4>
                            <ul class="list-disc list-inside text-muted-sage-green dark:text-muted-sage-green-darker text-sm">
                                @foreach($order->orderItems->take(3) as $item) {{-- Display up to 3 items --}}
                                    <li>{{ $item->product->product_name }} x {{ $item->quantity }}</li> {{-- Assuming product_name is accessible via relation --}}
                                @endforeach
                                @if(count($order->orderItems) > 3)
                                    <li>...and {{ count($order->orderItems) - 3 }} more items</li>
                                @endif
                            </ul>
                        </div>

                        <div class="flex justify-between items-center"> {{-- Total and View Details button --}}
                            <div>
                                <p class="font-medium text-warm-black dark:text-warm-white">Total: <span class="text-muted-sage-green dark:text-muted-sage-green-darker">₦{{ number_format($order->total_amount, 2) }}</span></p>
                            </div>
                            <button class="inline-flex items-center px-4 py-2 bg-muted-sage-green dark:bg-antique-gold border border-transparent rounded-md font-semibold text-xs dark:text-warm-black text-warm-white uppercase tracking-widest hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold-darker active:bg-muted-sage-green-darker dark:active:bg-antique-gold-darker focus:outline-none focus:border-muted-sage-green-darker dark:focus:border-antique-gold-darker focus:ring-muted-sage-green-darker dark:focus:ring-antique-gold-darker disabled:opacity-25 transition-all">
                                View Details
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @else
        <div class="text-center py-16 px-4 sm:px-6 lg:px-8 col-span-3"> {{-- Increased padding and centering --}}
                <div class="mx-auto mb-6 w-24 h-24 text-muted-sage-green-darker dark:text-muted-sage-green-darker-dark flex items-center justify-center rounded-full border-2 border-dashed border-muted-sage-green-darker dark:border-muted-sage-green-darker-dark">
                    {{-- Replace with your preferred "empty" icon - Example SVG below --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 opacity-70">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.375c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H7.5c-.621 0-1.125.504-1.125 1.125v7.5c0 .621.504 1.125 1.125 1.125H16.5m-9-5.25H7.5c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125H16.5m-9-5.25h5.375c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H7.5c-.621 0-1.125.504-1.125 1.125v7.5c0 .621.504 1.125 1.125 1.125H16.5" />
                    </svg>
                </div>
                <p class="text-xl font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-4">No orders placed yet.</p>
                <p class="text-muted-sage-green dark:text-muted-sage-green-darker mb-6">Browse our products and discover your new skincare favorites.</p>
                <a href="/products" class="inline-flex items-center px-4 py-2 bg-muted-sage-green dark:bg-antique-gold border border-transparent rounded-md font-semibold text-sm text-warm-black dark:text-warm-white  hover:bg-muted-sage-green-darker dark:hover:bg-antique-gold-darker active:bg-muted-sage-green-darker dark:active:bg-antique-gold-darker focus:outline-none focus:border-muted-sage-green-darker dark:focus:border-antique-gold-darker focus:ring-muted-sage-green-darker dark:focus:ring-antique-gold-darker disabled:opacity-25 transition-all">
                    Start Shopping
                </a>
            </div>
        @endif
    </section>
</main>
@endsection