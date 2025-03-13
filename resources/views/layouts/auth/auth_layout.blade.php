<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full"> {{-- Removed generic bg-gray classes from html --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Authentication')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-warm-white dark:bg-warm-black text-warm-black dark:text-warm-white"> {{-- Updated body classes to use Stara colors and font --}}
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md"> {{-- Reduced max width to md for better centering on smaller screens --}}
            <a href="{{ route('home') }}" class="text-center text-xl font-bold text-warm-black dark:text-warm-white block"> {{-- Updated title styling to Stara colors --}}
                Stara {{-- Hardcoded 'Stara' as brand name for auth pages --}}
            </a>

            <h2 class="mt-6 text-center text-2xl font-bold text-warm-black dark:text-warm-white"> {{-- Reduced and updated auth title styling --}}
                @yield('auth-title')
            </h2>
            <p class="mt-2 text-center text-sm text-muted-sage-green dark:text-antique-gold"> {{-- Updated subtitle styling to Stara accent colors --}}
                @yield('auth-subtitle')
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md"> {{-- Reduced max width here as well --}}
            <div class="bg-warm-white dark:bg-warm-black py-8 px-4 shadow sm:rounded-lg sm:px-10"> {{-- Updated container background to Stara colors --}}
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>