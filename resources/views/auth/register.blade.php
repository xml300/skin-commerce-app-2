@extends("layouts.auth.auth_layout")
@section("title", "Register")
@section("auth-title", "Create an Account")
@section("auth-subtitle", "Start your skincare journey with Stara.")

@section("content")
    <div class="w-full">
        <div class="">
            <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-10 text-center">Sign Up</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf


                <div class="mb-8">
                    <label for="user_type" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                       User Type
                    </label>
                    <select id="user_type" type="text" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" name="user_type" value="{{ old('first_name') }}" required>
                        <option value="">Select a user type...</option>
                        <option value="0">Customer</option>
                        <option value="1">Admin</option>
                    </select> 
                </div>

                <div class="grid md:grid-cols-2 md:gap-8">
                <div class="mb-8">
                    <label for="first_name" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        First Name
                    </label>
                    <input id="first_name" type="text" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('first_name') border-red-500 @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" placeholder="John">
                    @error('first_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="last_name" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Last Name
                    </label>
                    <input id="last_name" type="text" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('last_name') border-red-500 @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Doe">
                    @error('last_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                </div>

                <div class="mb-8">
                    <label for="username" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Username
                    </label>
                    <input id="username" type="text" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('username') border-red-500 @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="johndoe">
                    @error('username')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-8">
                    <label for="email" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Email Address
                    </label>
                    <input id="email" type="email" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-8">
                    <label for="password" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Password
                    </label>
                    <input id="password" type="password" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password" placeholder="********">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" name="password_confirmation" required autocomplete="new-password" placeholder="********">
                </div>



                <div class="mb-8">
                    <label for="billing_address" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Billing Address (Optional)
                    </label>
                    <textarea id="billing_address" rows="3" class="form-textarea appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('billing_address') border-red-500 @enderror" name="billing_address" placeholder="Your billing address">{{ old('billing_address') }}</textarea>
                    @error('billing_address')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10">
                    <label for="phone_number" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Phone Number (Optional)
                    </label>
                    <input id="phone_number" type="tel" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('phone_number') border-red-500 @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel" placeholder="123-456-7890">
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex items-center justify-between">
                    <button class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:hover:bg-antique-gold-darker dark:text-warm-black" type="submit">
                        Sign up
                    </button>
                    <a class="inline-block align-baseline font-medium text-sm text-muted-sage-green dark:text-muted-sage-green-darker hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200" href="/login">
                        Log in
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection