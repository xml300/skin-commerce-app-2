<!DOCTYPE html>
<html lang="en" class="light"> <!-- Initial class based on preference or default -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Stara (Redesigned)</title>
    @vite("resources/css/app.css") {{-- Make sure your Vite setup compiles Tailwind --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Optional: Style scrollbars for a more integrated look (Webkit browsers) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 20px;
            border: transparent;
        }

        html.dark ::-webkit-scrollbar-thumb {
            background-color: rgba(75, 85, 99, 0.5);
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.7);
        }

        html.dark ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(75, 85, 99, 0.7);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white dark:bg-gray-800 w-64 fixed inset-y-0 left-0 z-30 shadow-lg border-r border-gray-200 dark:border-gray-700
                   transform -translate-x-full md:translate-x-0  {{-- Starts hidden on mobile, visible on desktop by default via md:translate-x-0 --}}
                   transition-transform duration-300 ease-in-out flex flex-col">

            {{-- Sidebar Header --}}
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">Stara Admin</h2>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
                {{-- Active Link Example (Add conditional class based on route) --}}
                <a href="/"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                           {{ Request::is('admin') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-tachometer-alt mr-3 w-5 text-center
                              {{ Request::is('admin') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Dashboard
                </a>
                {{-- Other Links --}}
                <a href="{{ route('admin.products') }}"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                           {{ Request::routeIs('admin.products*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-box-open mr-3 w-5 text-center
                              {{ Request::routeIs('admin.products*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Products
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                            {{ Request::routeIs('admin.orders*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-shopping-cart mr-3 w-5 text-center
                               {{ Request::routeIs('admin.orders*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Orders
                </a>
                <a href="{{ route('admin.customers') }}"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                            {{ Request::routeIs('admin.customers*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-users mr-3 w-5 text-center
                               {{ Request::routeIs('admin.customers*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Customers
                </a>
                <a href="{{ route('admin.categories') }}"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                            {{ Request::routeIs('admin.categories*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-tags mr-3 w-5 text-center
                               {{ Request::routeIs('admin.categories*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Categories
                </a>
                <a href="{{ route('admin.reports') }}"
                    class="flex items-center py-2.5 px-4 rounded-md text-sm font-medium group transition-colors duration-150
                            {{ Request::routeIs('admin.reports*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <i
                        class="fas fa-chart-bar mr-3 w-5 text-center
                               {{ Request::routeIs('admin.reports*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"></i>
                    Reports
                </a>
                {{-- Add more links following the same pattern --}}
            </nav>

            {{-- Sidebar Footer / Settings --}}
            <div class="mt-auto p-4 border-t border-gray-200 dark:border-gray-700">
                {{-- Dark Mode Toggle Section --}}
                <div
                    class="flex items-center justify-between space-x-3 py-2 px-4 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                    <label for="darkModeToggle"
                        class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer flex items-center">
                        <i class="fas fa-moon mr-3 text-gray-500 dark:text-gray-400 w-5 text-center"></i>
                        Dark Mode
                    </label>
                    {{-- Corrected Toggle Switch --}}
                    <label for="darkModeToggle" class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="darkModeToggle" name="darkModeToggle" class="sr-only peer"> {{-- Hide
                        original checkbox, add peer --}}
                        <div class="
                            w-11 h-6
                            bg-gray-300 dark:bg-gray-600
                            peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800
                            rounded-full
                            peer {{-- Add peer here too for easier targeting if needed --}}
                            peer-checked:after:translate-x-full
                            peer-checked:after:border-white
                            after:content-['']
                            after:absolute after:top-[2px] after:left-[2px] {{-- Positioning the handle --}}
                            after:bg-white
                            after:border-gray-300 dark:after:border-gray-600 {{-- Handle border (unchecked) --}}
                            after:border after:rounded-full
                            after:h-5 after:w-5 {{-- Handle size --}}
                            after:transition-all {{-- Animate the handle --}}
                            dark:border-gray-600
                            peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 {{-- Track background color when checked --}}
                            ">
                        </div>
                    </label>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden" aria-hidden="true">
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col
                    transition-all duration-300 ease-in-out
                    md:pl-64 {{-- Default margin for desktop, managed by CSS --}}
                   ">
            {{-- Top Header Bar --}}
            <header
                class="sticky top-0 z-10 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        {{-- Left Side: Toggle and maybe Search --}}
                        <div class="flex items-center">
                            {{-- Toggle Button (Visible only on mobile/tablet) --}}
                            <button id="sidebarToggle" aria-label="Toggle sidebar"
                                class="md:hidden mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            
                        </div>

                        {{-- Right Side: Notifications, Profile --}}
                        <div class="flex items-center space-x-4">
                            {{-- Notification Icon (Placeholder) --}}
                            <button aria-label="View notifications"
                                class="relative p-1 rounded-full text-gray-400 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-indigo-500">
                                <i class="far fa-bell text-xl"></i>
                                {{-- Optional: Notification count badge --}}
                                {{-- <span
                                    class="absolute -top-1 -right-1 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-gray-800 bg-red-500 text-xs text-white flex items-center justify-center">3</span>
                                --}}
                            </button>

                            {{-- User Profile Dropdown (Placeholder) --}}
                            <div class="relative">
                                <button aria-label="User menu"
                                    class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-indigo-500"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    {{-- Or use initials: --}}
                                    <span
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500">
                                        <span
                                            class="text-sm font-medium leading-none text-white">{{ substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1) }}</span>
                                    </span>
                                </button>
                                {{-- Dropdown Panel (Hidden by default, needs JS) --}}
                                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1" id="user-menu">
                                    <a href="{{ route('admin.profile') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        role="menuitem" tabindex="-1">Your Profile</a>
                                    <form method="POST" action="#"> {{-- Replace # with your logout route --}}
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                            role="menuitem" tabindex="-1">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </header>

            {{-- Main Page Content --}}
            <main class="flex-1 p-6 lg:p-8">
                {{-- ========== Flash Message Display Section ========== --}}
                <div class="mb-6 space-y-4"> {{-- Container for messages with spacing --}}
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="relative rounded-lg bg-green-100 dark:bg-green-900/60 p-4 text-sm text-green-700 dark:text-green-200 border border-green-200 dark:border-green-700"
                            role="alert">
                            <span class="font-medium">Success!</span> {{ session('success') }}
                            <button @click="show = false" type="button"
                                class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-green-900/60 dark:text-green-300 dark:hover:bg-green-800/70"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="relative rounded-lg bg-red-100 dark:bg-red-900/60 p-4 text-sm text-red-700 dark:text-red-200 border border-red-200 dark:border-red-700"
                            role="alert">
                            <span class="font-medium">Error!</span> {{ session('error') }}
                            <button @click="show = false" type="button"
                                class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-red-900/60 dark:text-red-300 dark:hover:bg-red-800/70"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="relative rounded-lg bg-yellow-100 dark:bg-yellow-900/60 p-4 text-sm text-yellow-700 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700"
                            role="alert">
                            <span class="font-medium">Warning!</span> {{ session('warning') }}
                            <button @click="show = false" type="button"
                                class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 bg-yellow-100 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-yellow-900/60 dark:text-yellow-300 dark:hover:bg-yellow-800/70"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="relative rounded-lg bg-blue-100 dark:bg-blue-900/60 p-4 text-sm text-blue-700 dark:text-blue-200 border border-blue-200 dark:border-blue-700"
                            role="alert">
                            <span class="font-medium">Info:</span> {{ session('info') }}
                            <button @click="show = false" type="button"
                                class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-blue-900/60 dark:text-blue-300 dark:hover:bg-blue-800/70"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    {{-- Display validation errors if any --}}
                    @if ($errors->any())
                        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="relative rounded-lg bg-red-100 dark:bg-red-900/60 p-4 text-sm text-red-700 dark:text-red-200 border border-red-200 dark:border-red-700"
                            role="alert">
                            <span class="font-medium">Validation Errors!</span> Please check the form below.
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button @click="show = false" type="button"
                                class="absolute top-2.5 right-2.5 ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-red-900/60 dark:text-red-300 dark:hover:bg-red-800/70"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
                {{-- ========== End Flash Message Display Section ========== --}}

                @yield('content')
            </main>

            {{-- Footer (Inside main-content) --}}
            <footer
                class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} Stara. All rights reserved.
            </footer>
        </div> {{-- End #main-content --}}
    </div> {{-- End .flex.min-h-screen --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeToggle = document.getElementById("darkModeToggle");
            const htmlElement = document.documentElement;
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("main-content");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            const mediumBreakpoint = 768; // Tailwind's 'md' breakpoint (adjust if your config differs)

            // --- Dark Mode Logic ---
            const setDarkMode = (isDark) => {
                if (isDark) {
                    htmlElement.classList.add("dark");
                    htmlElement.classList.remove("light");
                    localStorage.setItem("darkMode", "enabled");
                    if (darkModeToggle) darkModeToggle.checked = true;
                } else {
                    htmlElement.classList.remove("dark");
                    htmlElement.classList.add("light");
                    localStorage.setItem("darkMode", "disabled");
                    if (darkModeToggle) darkModeToggle.checked = false;
                }
            };

            // Initialize Dark Mode
            const savedDarkMode = localStorage.getItem("darkMode");
            if (savedDarkMode === "enabled") {
                setDarkMode(true);
            } else if (savedDarkMode === "disabled") {
                setDarkMode(false);
            } else if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
                setDarkMode(true); // Use OS preference if no setting saved
            } else {
                setDarkMode(false); // Default to light
            }

            // Dark Mode Toggle Event Listener
            if (darkModeToggle) {
                darkModeToggle.addEventListener("change", () => {
                    setDarkMode(darkModeToggle.checked);
                });
            }

            // --- Sidebar Toggle Logic ---
            const setSidebarState = (isOpen) => {
                const isMediumOrLarger = window.innerWidth >= mediumBreakpoint;

                if (isOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    // Ensure md:translate-x-0 is present for desktop consistency if forcing open
                    sidebar.classList.add('md:translate-x-0');

                    if (isMediumOrLarger) {
                        // Ensure margin is present on desktop when sidebar is open
                        mainContent.classList.add('md:ml-64');
                        sidebarOverlay.classList.add('hidden'); // Ensure overlay is hidden on desktop
                    } else {
                        sidebarOverlay.classList.remove('hidden'); // Show overlay on mobile
                        // Margin is handled by lack of md:ml-64 on mobile
                    }
                    localStorage.setItem("sidebarOpen", "true");
                } else {
                    sidebar.classList.add('-translate-x-full');
                    // Keep md:translate-x-0 unless explicitly hiding on desktop via localStorage later
                    sidebarOverlay.classList.add('hidden'); // Hide overlay

                    if (isMediumOrLarger) {
                        // If we wanted a button to HIDE on desktop, we'd remove md:ml-64 here.
                        // By default, closing on desktop isn't a primary action, so we rely on CSS.
                        // mainContent.classList.remove('md:ml-64'); // Uncomment if explicit desktop hide needed
                    }
                    localStorage.setItem("sidebarOpen", "false");
                }
            };

            // Initialize Sidebar State
            const savedSidebarState = localStorage.getItem("sidebarOpen");
            const isInitiallyMediumOrLarger = window.innerWidth >= mediumBreakpoint;

            // Determine initial state: Respect saved state. Default open on desktop, closed on mobile.
            let initialSidebarOpen;
            if (savedSidebarState === "false") {
                initialSidebarOpen = false; // Explicitly closed by user
            } else if (savedSidebarState === "true") {
                initialSidebarOpen = true; // Explicitly opened by user
            } else {
                // No saved state, use default based on screen size
                initialSidebarOpen = isInitiallyMediumOrLarger;
            }

            // Apply initial state classes correctly ON LOAD
            if (initialSidebarOpen) {
                sidebar.classList.remove('-translate-x-full'); // Make visible
                sidebar.classList.add('md:translate-x-0');    // Ensure CSS rule for desktop visibility is present

                if (isInitiallyMediumOrLarger) {
                    mainContent.classList.add('md:ml-64');    // Add margin on desktop
                    sidebarOverlay.classList.add('hidden');   // Hide overlay
                } else {
                    mainContent.classList.remove('md:ml-64'); // No margin on mobile
                    sidebarOverlay.classList.remove('hidden'); // Show overlay
                }
            } else {
                // Sidebar should be closed initially
                sidebar.classList.add('-translate-x-full');     // Make hidden
                mainContent.classList.remove('md:ml-64');     // Ensure no margin initially
                sidebarOverlay.classList.add('hidden');       // Hide overlay

                // If closed because of mobile size, keep md:translate-x-0 so it appears on resize
                // If explicitly saved as closed ('false'), allow md:translate-x-0 removal if needed,
                // but generally better to keep it for predictable resize behavior.
                // sidebar.classList.add('md:translate-x-0'); // Keep this rule generally
            }

            // Sidebar Toggle Button Click (Mainly for Mobile)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    // Check current VISUAL state by looking for the translate class
                    const isCurrentlyOpen = !sidebar.classList.contains('-translate-x-full');
                    setSidebarState(!isCurrentlyOpen); // Toggle state
                });
            }

            // Sidebar Overlay Click (to close sidebar on mobile)
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    setSidebarState(false);
                });
            }

            // --- Optional: Handle window resize ---
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    const isCurrentlyMediumOrLarger = window.innerWidth >= mediumBreakpoint;
                    const isOpen = !sidebar.classList.contains('-translate-x-full');

                    if (isCurrentlyMediumOrLarger) {
                        sidebarOverlay.classList.add('hidden'); // Always hide overlay on desktop

                        // If sidebar should be visible on desktop (default or opened), ensure margin is present
                        if (sidebar.classList.contains('md:translate-x-0') && isOpen) {
                            mainContent.classList.add('md:ml-64');
                        } else if (!sidebar.classList.contains('md:translate-x-0') || !isOpen) {
                            // If sidebar is meant to be hidden on desktop (less common) or is closed
                            mainContent.classList.remove('md:ml-64');
                        }
                        // Ensure sidebar itself is visible based on its default state if resizing TO desktop
                        sidebar.classList.add('md:translate-x-0');

                    } else {
                        // Resized TO mobile view
                        mainContent.classList.remove('md:ml-64'); // Remove desktop margin
                        // Show overlay only if sidebar is currently open
                        if (isOpen) {
                            sidebarOverlay.classList.remove('hidden');
                        } else {
                            sidebarOverlay.classList.add('hidden');
                        }
                    }
                }, 150); // Debounce resize events
            });


            // --- User Profile Dropdown ---
            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', (event) => {
                    event.stopPropagation(); // Prevent click from bubbling to document
                    const expanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                    userMenuButton.setAttribute('aria-expanded', !expanded);
                    userMenu.classList.toggle('hidden');
                });

                // Close dropdown if clicking outside
                document.addEventListener('click', (event) => {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        if (userMenuButton.getAttribute('aria-expanded') === 'true') {
                            userMenuButton.setAttribute('aria-expanded', 'false');
                            userMenu.classList.add('hidden');
                        }
                    }
                });

                // Close dropdown with Escape key
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && userMenuButton.getAttribute('aria-expanded') === 'true') {
                        userMenuButton.setAttribute('aria-expanded', 'false');
                        userMenu.classList.add('hidden');
                    }
                });
            }

        });
    </script>

    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    @stack('scripts')

</body>

</html>