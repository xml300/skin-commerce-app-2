@extends('layouts.admin.admin_dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card dark:bg-gray-800 dark:border-gray-700"> {{-- Dark mode card background and border --}}
                        <div class="card-header bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700"> {{-- Dark mode card header background and border --}}
                            <h3 class="card-title text-xl font-semibold text-gray-900 dark:text-white">Order Management</h3> {{-- Dark mode card title text color --}}
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <button class="btn btn-primary">Add New Order (Future)</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"> {{-- Table styling and dark mode text color --}}
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"> {{-- Thead styling, dark mode background and text --}}
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Order ID</th>
                                            <th scope="col" class="px-6 py-3">Customer Name</th>
                                            <th scope="col" class="px-6 py-3">Order Date</th>
                                            <th scope="col" class="px-6 py-3">Total Amount</th>
                                            <th scope="col" class="px-6 py-3">Status</th>
                                            <th scope="col" class="px-6 py-3 text-center">Actions</th> {{-- Centered Actions header --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"> {{-- Row styling, dark mode background, border, and hover --}}
                                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $order->id }}</td> {{-- Dark mode text color, whitespace nowrap for Order ID --}}
                                                <td class="px-6 py-4">{{ $order->user()->first()->fullName() }}</td>
                                                <td class="px-6 py-4">{{ $order->ordered_at }}</td>
                                                <td class="px-6 py-4">{{ $order->order_total }}</td>
                                                <td class="px-6 py-4">{{ $order->order_status }}</td>
                                                <td class="px-6 py-4 text-center"> {{-- Centered Actions content --}}
                                                    <div class="flex justify-center space-x-2"> {{-- Flex container for buttons, space between --}}
                                                        <button class="btn btn-sm btn-info">View</button>
                                                        <button class="btn btn-sm btn-primary">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection