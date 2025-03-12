@extends("layouts.auth.auth_layout")
@section("title", "Stara")
@section("auth-title", "Register")
@section("auth-subtitle", "Sign up to access our services.")

@section("content")
    <div class="w-full">
        <div class="">
            <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-6 text-center">Register at Stara</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf  
                
                <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-4">
                    <label for="first_name" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        First Name
                    </label>
                    <input id="first_name" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('first_name') border-red-500 @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                    @error('first_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="last_name" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Last Name
                    </label>
                    <input id="last_name" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('last_name') border-red-500 @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                    @error('last_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                </div>
                
                <div class="mb-4">
                    <label for="username" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Username
                    </label>
                    <input id="username" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('username') border-red-500 @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    @error('username')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

            
                <div class="mb-4">
                    <label for="email" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Email Address
                    </label>
                    <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="password" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Password
                    </label>
                    <input id="password" type="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" name="password_confirmation" required autocomplete="new-password">
                </div>

                

                <div class="mb-4">
                    <label for="billing_address" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Billing Address (Optional)
                    </label>
                    <textarea id="billing_address" rows="2" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('billing_address') border-red-500 @enderror" name="billing_address">{{ old('billing_address') }}</textarea>
                    @error('billing_address')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="phone_number" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Phone Number (Optional)
                    </label>
                    <input id="phone_number" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone_number') border-red-500 @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel">
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex items-center justify-between">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800" type="submit">
                        Register
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800 dark:text-green-300 dark:hover:text-green-200" href="/login">
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection