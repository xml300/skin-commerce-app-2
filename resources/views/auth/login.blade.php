@include("layouts.user.header", ["title" => "Login"])

<main class="container mx-auto p-4 md:p-8 lg:p-10 flex justify-center items-center min-h-[75vh]">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-green-950 shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold text-green-900 dark:text-white mb-6 text-center">Login to Skincare Shop</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf {{-- CSRF protection --}}

                <div class="mb-4">
                    <label for="username" class="block text-green-800 dark:text-gray-200 text-sm font-bold mb-2">
                        Username or Email
                    </label>
                    <input id="username" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-green-700 dark:text-white dark:bg-green-800 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('username') border-red-500 @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    @error('username')
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
    </div>
</main>
@include("layouts.user.footer")