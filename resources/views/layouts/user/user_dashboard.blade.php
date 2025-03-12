<!DOCTYPE html>
<html lang="en" class="dark">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Stara')</title>
    @vite("resources/css/app.css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body
    class="bg-green-50 text-green-900 dark:bg-green-900 dark:text-green-50 font-sans min-h-screen"
  >
  <header class="bg-white dark:bg-black shadow-md pt-0 relative">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <img src="{{ asset('images/stara-logo.jpg') }}" class="h-12">

        <nav class="flex items-center font-medium">
            <a href="/"
               class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3">Home</a>
            <a href="/products"
               class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3">Products</a>

            @auth
            <a
               href="/cart"
               id="cart-link"
               class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3 group"
            ><i class="fa-solid fa-cart-shopping"></i><sup class="mx-0.5 px-1 py-0 rounded-full bg-green-800 dark:bg-green-500 dark:group-hover:bg-green-100"><span id="cart-count" class="super text-white dark:text-black">0</span></sup></a
            >
            <script>
              if(location.pathname.startsWith('/cart')) localStorage.removeItem('cartChanges');
              const cartCount = localStorage.getItem('cartCount');

              if(cartCount == null){
                fetch("/api/cart/count")
                .then(res => res.json())
                .then(data => {
                    document.getElementById("cart-count").textContent = data.count;
                    localStorage.setItem("cartCount", data.count);
                });
              }else{
                const otherCount = JSON.parse(localStorage.getItem("cartChanges") || "{}");
                let nCount = 0;
                if(otherCount.update){
                  otherCount.update.forEach(item => {
                    if(otherCount.remove.indexOf(item.productId) == -1){
                      nCount += item.quantityChange;
                    }
                  });
                }
                document.getElementById("cart-count").textContent = parseInt(cartCount) + nCount;
              }
            </script>
            @endauth


            <div class="ml-4 group py-6">
                <button id="profile-dropdown-button"
                        class="peer flex items-center text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white focus:outline-none"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fa-regular fa-user"></i> <span class="ml-2 hidden sm:inline">Profile</span>
                </button>

                <div id="profile-dropdown" class="hidden group-hover:flex absolute top-full right-16 mt-0 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-10"
                     aria-labelledby="profile-dropdown-button" aria-hidden="true">

                    <div class="w-full py-1">
                        <!-- Dark Mode Toggle Switch -->
                        <div class="flex items-center justify-between px-4 py-2">
                            <label for="darkModeToggleDropdown" class="text-gray-700 dark:text-gray-300"
                                   >Dark Mode</label>
                            <div class="relative flex items-center justify-center mt-1">
                                <input
                                    type="checkbox"
                                    id="darkModeToggleDropdown"
                                    class="appearance-none w-10 h-5 bg-green-300 dark:bg-green-700 rounded-full peer cursor-pointer relative"
                                />
                                <span
                                    class="absolute left-1 top-1 bg-white dark:bg-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-green-500"
                                ></span>
                            </div>
                        </div>

                        <hr class="border-t border-gray-200 dark:border-gray-700">

                        @guest
                        <a href="/login" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Login
                        </a>
                        <a href="/register" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Sign Up
                        </a>
                        @endguest

                        @auth
                        <div class="px-4 py-2">
                            <p class="text-sm text-gray-700 dark:text-gray-300">Logged in as:</p>
                            <p class="text-green-700 dark:text-green-300 font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                        </div>
                        <hr class="border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

    @yield('content')

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        const htmlElement = document.documentElement;
        const cartCountSpan = document.getElementById("cart-count");

        const darkModeToggle = document.getElementById('darkModeToggleDropdown');

        if(location.search != "") location.search = "";

  
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

      });
    </script>
    @include("layouts.user.partials.footer")
  </body>
</html>