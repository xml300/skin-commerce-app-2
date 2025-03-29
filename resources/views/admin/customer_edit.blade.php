@extends('layouts.admin.admin_dashboard')

@section('content')
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Edit Customer: {{ $customer->fullName() ?? ($customer->first_name . ' ' . $customer->last_name) }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Modify details for customer #{{ $customer->id }}.
            </p>
        </div>
         
        <a href="{{ route('admin.customers.show', $customer->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 dark:focus:ring-gray-700 active:bg-gray-400 dark:active:bg-gray-500 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap">
            <i class="fas fa-arrow-left mr-2 -ml-1"></i>
            Cancel
        </a>
    </div>

    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Customer Details
                </h3>
            </div>

            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                <input type="text" name="id" value="{{ $customer->id }}" hidden>
                
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $customer->first_name) }}" required
                           class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $customer->last_name) }}" required
                           class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                           class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $customer->phone_number) }}"
                           class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="is_active" id="is_active"
                            class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('is_active') border-red-500 @enderror">
                        <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                     <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Leave password fields blank to keep the current password.</p>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                         <div>
                             <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                             <input type="password" name="password" id="password"
                                    class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
                             @error('password')
                                 <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                             @enderror
                         </div>
                         <div>
                             <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                             <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                         </div>
                     </div>
                </div>

                 
                 <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Address Information</h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="md:col-span-2">
                            <label for="address_line_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Line 1</label>
                            <input type="text" name="address_line_1" id="address_line_1" value="{{ old('address_line_1', $customer->address_line_1) }}"
                                   class="p-2 mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('address_line_1') border-red-500 @enderror">
                            @error('address_line_1') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        
                     </div>
                 </div>

            </div>

            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center space-x-3">
                <a href="{{ route('admin.customers.show', $customer->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:text-gray-500 dark:hover:text-gray-100 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection