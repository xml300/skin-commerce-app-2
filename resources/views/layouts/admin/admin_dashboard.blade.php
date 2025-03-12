<!DOCTYPE html>
<html lang="en" class="light"> <!-- Initial class set to 'light' -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Stara</title>
    @vite("resources/css/app.css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 font-sans">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-white dark:bg-gray-800 w-64 fixed h-full shadow-md transition-transform duration-300"> {{-- Added
            ID and transition --}}
            <div class="p-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Stara Admin</h2>
            </div>
            <nav class="mt-4">
                <a href="#"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.products') }}"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-box-open mr-2"></i> Products
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i> Orders
                </a>
                <a href="{{ route('admin.customers') }}"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-users mr-2"></i> Customers
                </a>
                <a href="{{ route('admin.categories') }}"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-tags mr-2"></i> Categories
                </a>
                <a href="{{ route('admin.reports') }}"
                    class="block py-2 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i> Reports
                </a>

                <div class="border-t-1 border-gray-600 mx-4 my-6"></div>

                <!-- Dark Mode Toggle Switch -->
                <div class="flex items-center space-x-2  py-2 px-4 ">
                    <label for="darkModeToggle" class="text-gray-700 dark:text-gray-300">Dark Mode</label>
                    <div class="relative flex items-center">
                        <input type="checkbox" id="darkModeToggle"
                            class="appearance-none w-10 h-5 bg-gray-300 dark:bg-gray-600 rounded-full peer cursor-pointer relative" />
                        <span
                            class="absolute right-0 top-1 bg-white dark:bg-gray-800 rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-blue-500"></span>

                    </div>
                </div>
                {{-- Add more navigation links here --}}
            </nav>
        </aside>

        <!-- Main Content -->
        <div id="main-content" class="ml-64 p-4 md:p-8 lg:p-10 transition-margin duration-300"> {{-- Added ID and
            transition --}}
            <header class="flex justify-between items-center mb-6">
                <div>
                    <button id="sidebarToggle" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <main>
                @yield('content')
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const darkModeToggle = document.getElementById("darkModeToggle");
                const htmlElement = document.documentElement;
                const sidebarToggle = document.getElementById("sidebarToggle"); // Get sidebar toggle button
                const sidebar = document.getElementById("sidebar"); // Get sidebar element
                const mainContent = document.getElementById("main-content"); // Get main content element


                const setDarkMode = (isDark) => {
                    if (isDark) {
                        htmlElement.classList.add("dark");
                        htmlElement.classList.remove("light");
                        localStorage.setItem("darkMode", "enabled");
                        darkModeToggle.checked = true;
                    } else {
                        htmlElement.classList.remove("dark");
                        htmlElement.classList.add("light");
                        localStorage.setItem("darkMode", "disabled");
                        darkModeToggle.checked = false;
                    }
                };

                const savedDarkMode = localStorage.getItem("darkMode");
                if (savedDarkMode === "enabled") {
                    setDarkMode(true);
                } else if (savedDarkMode === "disabled") {
                    setDarkMode(false);
                } else if (
                    window.matchMedia &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches
                ) {
                    setDarkMode(true);
                } else {
                    setDarkMode(false);
                }

                darkModeToggle.addEventListener("change", () => {
                    setDarkMode(darkModeToggle.checked);
                });


                // Sidebar Toggle Logic
                const setSidebarState = (isCollapsed) => {
                    if (isCollapsed) {
                        sidebar.classList.add('-translate-x-full'); // Hide sidebar (translate it out of view)
                        mainContent.classList.add('ml-0'); // Make main content take full width
                        mainContent.classList.remove('ml-64');
                        localStorage.setItem("sidebarCollapsed", "true");
                    } else {
                        sidebar.classList.remove('-translate-x-full'); // Show sidebar
                        mainContent.classList.remove('ml-0'); // Adjust main content margin
                        mainContent.classList.add('ml-64');
                        localStorage.setItem("sidebarCollapsed", "false");
                    }
                };

                const savedSidebarState = localStorage.getItem("sidebarCollapsed");
                if (savedSidebarState === "true") {
                    setSidebarState(true); // Initialize sidebar as collapsed if saved state is true
                } else {
                    setSidebarState(false); // Otherwise, initialize as expanded
                }


                sidebarToggle.addEventListener('click', () => {
                    const isCurrentlyCollapsed = sidebar.classList.contains('-translate-x-full');
                    setSidebarState(!isCurrentlyCollapsed); // Toggle sidebar state
                });


            });
        </script>

</body>

</html>