@extends("layouts.auth.auth_layout")
@section( "title", "Login")
@section('auth-title', 'Sign in to Stara')
@section('auth-subtitle', 'Welcome back! Enter your credentials to access your account.')

@section('content')
    <div class="w-full">
            <h2 class="text-3xl font-semibold text-warm-black dark:text-warm-white mb-10 text-center">Log in</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-8">
                    <label for="email" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Email Address
                    </label>
                    <input id="email" type="email" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10">
                    <label for="password" class="block text-sm font-medium text-muted-sage-green dark:text-muted-sage-green-darker mb-3">
                        Password
                    </label>
                    <input id="password" type="password" class="form-input appearance-none border rounded-xl w-full py-3 px-4 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password" placeholder="********">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:hover:bg-antique-gold-darker dark:text-warm-black" type="submit">
                        Log in
                    </button>
                    <a class="inline-block align-baseline font-medium text-sm text-muted-sage-green dark:text-muted-sage-green-darker hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200" href="/register">
                        Sign up
                    </a>
                </div>
            </form>
    </div>
@endsection