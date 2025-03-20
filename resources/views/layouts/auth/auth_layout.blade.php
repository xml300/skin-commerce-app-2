<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full light"> {{-- Set initial theme to light,
control with JS --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Authentication')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full bg-warm-white dark:bg-warm-black text-warm-black dark:text-warm-white">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{ route('home') }}"
                class="text-center text-3xl font-semibold text-warm-black dark:text-warm-white block mb-2">
                Stara
            </a>

            <h2 class="mt-6 text-center text-3xl font-semibold text-warm-black dark:text-warm-white">
                @yield('auth-title')
            </h2>
            <p class="mt-2 text-center text-muted-sage-green dark:text-muted-sage-green-darker">
                @yield('auth-subtitle')
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-warm-white dark:bg-warm-black px-10 py-8 rounded-xl shadow-md"> {{-- Increased padding and
                rounded corners --}}
                <div class="flex justify-end">
                    <div class="flex gap-x-3 items-center justify-between px-4 py-2">
                        <label for="darkModeToggleDropdown"
                            class="block text-sm text-warm-black dark:text-warm-white">Dark
                            Mode</label>
                        <div class="relative flex items-center justify-center mt-1">
                            <input type="checkbox" id="darkModeToggleDropdown"
                                class="appearance-none w-10 h-5 bg-soft-sand-beige dark:bg-muted-sage-green rounded-full peer cursor-pointer relative" />
                            <span
                                class="absolute left-1 top-1 bg-warm-white dark:bg-warm-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-warm-white dark:peer-checked:bg-warm-black"></span>
                        </div>
                    </div>
                </div>

                @yield('content')
            </div>
            <p class="mt-4 text-center text-sm text-muted-sage-green dark:text-muted-sage-green-darker"> {{-- Added
                extra text area for auth pages --}}
                @yield('auth-extra')
            </p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const htmlElement = document.documentElement;
            const darkModeToggleDropdown = document.getElementById('darkModeToggleDropdown');
        
            const savedDarkMode = localStorage.getItem("darkMode");
            let initialDarkMode = false;

            if (savedDarkMode === "enabled") {
                initialDarkMode = true;
            } else if (savedDarkMode === "disabled") {
                initialDarkMode = false;
            } else if (
                window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                initialDarkMode = true;
            }

            if (initialDarkMode) {
                htmlElement.classList.add("dark");
                darkModeToggleDropdown.checked = true;
            } else {
                htmlElement.classList.remove("dark");
                darkModeToggleDropdown.checked = false;
            }


            const setDarkMode = (isDark) => {
                if (isDark) {
                    htmlElement.classList.add("dark");
                    localStorage.setItem("darkMode", "enabled");
                    darkModeToggleDropdown.checked = true;
                } else {
                    htmlElement.classList.remove("dark");
                    localStorage.setItem("darkMode", "disabled");
                    darkModeToggleDropdown.checked = false;
                }
            };


            darkModeToggleDropdown.addEventListener("change", () => {
                setDarkMode(darkModeToggleDropdown.checked);
            });
        });
    </script>
</body>

</html>