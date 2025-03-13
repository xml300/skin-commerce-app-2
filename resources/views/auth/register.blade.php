@extends("layouts.auth.auth_layout")
@section("title", "Stara - Register") {{-- Updated title to be more specific --}}
@section("auth-title", "Join Stara Today") {{-- More engaging auth title --}}
@section("auth-subtitle", "Create your Stara account and start exploring.") {{-- More brand-aligned subtitle --}}

@section("content")
    <div class="w-full">
        <div class="">
            <h2 class="text-2xl font-bold text-warm-black dark:text-warm-white mb-8 text-center">Register at Stara</h2> {{-- Updated heading style and margin --}}

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid md:grid-cols-2 md:gap-6">
                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="first_name" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        First Name
                    </label>
                    <input id="first_name" type="text" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('first_name') border-red-500 @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" placeholder="John"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('first_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>

                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="last_name" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Last Name
                    </label>
                    <input id="last_name" type="text" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('last_name') border-red-500 @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Doe"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('last_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>
                </div>

                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="username" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Username
                    </label>
                    <input id="username" type="text" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('username') border-red-500 @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="johndoe"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('username')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>


                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="email" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Email Address
                    </label>
                    <input id="email" type="email" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="your@email.com"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>


                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="password" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Password
                    </label>
                    <input id="password" type="password" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password" placeholder="********"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>

                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="password_confirmation" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200" name="password_confirmation" required autocomplete="new-password" placeholder="********"> {{-- Updated input style, added placeholder, form-input class --}}
                </div>



                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="billing_address" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Billing Address (Optional)
                    </label>
                    <textarea id="billing_address" rows="2" class="form-textarea appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('billing_address') border-red-500 @enderror" name="billing_address" placeholder="Your billing address">{{ old('billing_address') }}</textarea> {{-- Updated textarea style, added placeholder, form-textarea class --}}
                    @error('billing_address')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>

                <div class="mb-8"> {{-- Increased margin bottom --}}
                    <label for="phone_number" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Phone Number (Optional)
                    </label>
                    <input id="phone_number" type="tel" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('phone_number') border-red-500 @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel" placeholder="123-456-7890"> {{-- Updated input style, added placeholder, form-input class, changed input type to tel --}}
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>


                <div class="flex items-center justify-between">
                    <button class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:hover:bg-antique-gold-darker dark:text-warm-black" type="submit"> {{-- Updated button style to use Stara colors and rounded corners, added transition --}}
                        Register
                    </button>
                    <a class="inline-block align-baseline font-medium text-sm text-muted-sage-green hover:text-muted-sage-green-darker dark:text-antique-gold dark:hover:text-antique-gold-darker transition-colors duration-200" href="/login"> {{-- Updated login link style to use Stara colors and transition --}}
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection