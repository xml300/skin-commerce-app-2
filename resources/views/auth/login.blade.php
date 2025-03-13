@extends("layouts.auth.auth_layout")
@section( "title", "Stara")
@section('auth-title', 'Login')
@section('auth-subtitle', 'Sign in to access your account.')

@section('content')
<!-- <main class="container mx-auto p-4 md:p-8 lg:p-10 flex justify-center items-center min-h-[75vh]"> -->
    <div class="w-full">
            <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-6 text-center">Login to Stara</h2>


            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Email
                    </label>
                    <input id="email" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Password
                    </label>
                    <input id="password" type="password" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 dark:bg-green-700 dark:hover:bg-green-800" type="submit">
                        Login
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800 dark:text-green-300 dark:hover:text-green-200" href="/register">
                        Register
                    </a>
                </div>
            </form>
    </div>
<!-- </main> -->
@endsection