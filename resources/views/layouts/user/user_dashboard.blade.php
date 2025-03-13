<!DOCTYPE html>
<html lang="en"> {{-- Removed initial `light` class, will be set by JS --}}
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Stara')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body
    class="font-sans min-h-screen bg-warm-white text-warm-black dark:bg-warm-black dark:text-warm-white"
>
    <header class="sticky top-0 z-50 bg-warm-white dark:bg-warm-black shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" aria-label="Stara Homepage">
                    <img src="{{ asset('images/stara-logo.jpg') }}" class="h-10" alt="Stara Logo">
                </a>

                <nav class="hidden sm:flex items-center font-medium space-x-6">
                    <a href="/"
                       class="text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200">Home</a>
                    <a href="/products"
                       class="text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200">Products</a>

                    @auth
                    <a
                       href="/cart"
                       id="cart-link"
                       class="relative hover:text-muted-sage-green dark:hover:text-antique-gold transition-colors duration-200"
                       aria-label="Shopping Cart"
                    >
                        <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                        <sup class="absolute top-[-0.4rem] left-full px-[0.375rem] p-[0.025rem]  text-xs font-normal bg-muted-sage-green dark:bg-antique-gold text-warm-white dark:text-warm-black rounded-full" id="cart-count">
                            <!-- Cart Count -->
                        </sup>
                    </a>
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


                    <div class="relative group">
                        <button id="profile-dropdown-button" type="button"
                                class="flex items-center gap-2 text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-antique-gold focus:outline-none transition-colors duration-200"
                                aria-haspopup="true" aria-expanded="false" aria-label="Profile Menu">
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                            <span class="hidden md:inline">Profile</span>
                        </button>

                        <div id="profile-dropdown" class="hidden group-hover:block absolute top-full right-0 pt-2 w-48 bg-warm-white dark:bg-warm-black rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" aria-orientation="vertical" aria-labelledby="profile-dropdown-button" tabindex="-1">

                            <div class="py-1" role="none">
                                <!-- Dark Mode Toggle Switch -->
                                <div class="flex items-center justify-between px-4 py-2">
                                    <label for="darkModeToggleDropdown" class="block text-sm text-warm-black dark:text-warm-white"
                                           >Dark Mode</label>
                                    <div class="relative flex items-center justify-center mt-1">
                                        <input
                                            type="checkbox"
                                            id="darkModeToggleDropdown"
                                            class="appearance-none w-10 h-5 bg-soft-sand-beige dark:bg-muted-sage-green rounded-full peer cursor-pointer relative"
                                        />
                                         <span
                                            class="absolute left-1 top-1 bg-warm-white dark:bg-warm-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-warm-white dark:peer-checked:bg-warm-black"
                                        ></span>
                                    </div>
                                </div>

                                <hr class="border-t border-soft-sand-beige dark:border-warm-black">

                                @guest
                                <a href="/login" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="login-menu-item">
                                    Login
                                </a>
                                <a href="/register" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="signup-menu-item">
                                    Sign Up
                                </a>
                                @endguest

                                @auth
                                <div class="px-4 py-2" role="none">
                                    <p class="text-sm text-warm-black dark:text-warm-white">Logged in as:</p>
                                    <p class="text-warm-black dark:text-muted-sage-green font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-warm-black dark:text-warm-white">{{ Auth::user()->email }}</p>
                                </div>
                                <hr class="border-t border-soft-sand-beige dark:border-warm-black">
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="logout-menu-item"
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
                 {{-- Mobile Navigation Button --}}
                 <div class="sm:hidden flex items-center">
                    <button id="mobile-menu-button" type="button" class="text-warm-black dark:text-warm-white focus:outline-none" aria-label="Mobile Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
             {{-- Mobile Navigation Menu (Hidden by default) --}}
             <div class="hidden sm:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" aria-current="page">Home</a>
                    <a href="/products" class="block px-3 py-2 rounded-md text-base font-medium text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black">Products</a>
                    @auth
                    <a href="/cart"  class="block px-3 py-2 rounded-md text-base font-medium text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black">Cart</a>
                    @endauth
                    <!-- Account/Profile Dropdown in Mobile Menu -->
                    <div class="relative group">
                        <button id="mobile-profile-dropdown-button" type="button"
                                class="flex w-full justify-between items-center px-3 py-2 rounded-md text-base font-medium text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black focus:outline-none"
                                aria-haspopup="true" aria-expanded="false" aria-label="Profile Menu">
                            <span>Profile</span> <i class="fa-regular fa-user"></i>
                        </button>

                        <div id="mobile-profile-dropdown" class="hidden group-hover:block absolute left-0 pt-2 w-full bg-warm-white dark:bg-warm-black rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                             role="menu" aria-orientation="vertical" aria-labelledby="mobile-profile-dropdown-button" tabindex="-1">

                            <div class="py-1" role="none">
                                <!-- Dark Mode Toggle Switch -->
                                <div class="flex items-center justify-between px-4 py-2">
                                    <label for="darkModeToggleMobile" class="block text-sm text-warm-black dark:text-warm-white"
                                           >Dark Mode</label>
                                    <div class="relative flex items-center justify-center mt-1">
                                        <input
                                            type="checkbox"
                                            id="darkModeToggleMobile"
                                            class="appearance-none w-10 h-5 bg-soft-sand-beige dark:bg-muted-sage-green rounded-full peer cursor-pointer relative"
                                        />
                                        <span
                                            class="absolute left-1 top-1 bg-warm-white dark:bg-warm-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-warm-white dark:peer-checked:bg-warm-black"
                                        ></span>
                                    </div>
                                </div>

                                <hr class="border-t border-soft-sand-beige dark:border-warm-black">

                                @guest
                                <a href="/login" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="login-mobile-menu-item">
                                    Login
                                </a>
                                <a href="/register" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="signup-mobile-menu-item">
                                    Sign Up
                                </a>
                                @endguest

                                @auth
                                <div class="px-4 py-2" role="none">
                                    <p class="text-sm text-warm-black dark:text-warm-white">Logged in as:</p>
                                    <p class="text-warm-black dark:text-muted-sage-green font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-warm-black dark:text-warm-white">{{ Auth::user()->email }}</p>
                                </div>
                                <hr class="border-t border-soft-sand-beige dark:border-warm-black">
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black" role="menuitem" tabindex="-1" id="logout-mobile-menu-item"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        const htmlElement = document.documentElement;
        const cartCountSpan = document.getElementById("cart-count");
        const darkModeToggleDropdown = document.getElementById('darkModeToggleDropdown');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileProfileDropdownButton = document.getElementById('mobile-profile-dropdown-button');
        const mobileProfileDropdown = document.getElementById('mobile-profile-dropdown');
        const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');

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
          darkModeToggleMobile.checked = true;
        } else {
          htmlElement.classList.remove("dark");
          darkModeToggleDropdown.checked = false;
          darkModeToggleMobile.checked = false;
        }


        const setDarkMode = (isDark) => {
          if (isDark) {
            htmlElement.classList.add("dark");
            localStorage.setItem("darkMode", "enabled");
            darkModeToggleDropdown.checked = true;
            darkModeToggleMobile.checked = true;
          } else {
            htmlElement.classList.remove("dark");
            localStorage.setItem("darkMode", "disabled");
            darkModeToggleDropdown.checked = false;
            darkModeToggleMobile.checked = false;
          }
        };


        darkModeToggleDropdown.addEventListener("change", () => {
          setDarkMode(darkModeToggleDropdown.checked);
        });

        darkModeToggleMobile.addEventListener("change", () => {
          setDarkMode(darkModeToggleMobile.checked);
        });


        // Dropdown Toggle (Basic JS)
        profileDropdownButton.addEventListener('click', () => {
            const expanded = !profileDropdown.classList.contains('hidden');
            profileDropdownButton.setAttribute('aria-expanded', !expanded);
            profileDropdown.classList.toggle('hidden');
        });
        mobileProfileDropdownButton.addEventListener('click', () => {
            const expanded = !mobileProfileDropdown.classList.contains('hidden');
            mobileProfileDropdownButton.setAttribute('aria-expanded', !expanded);
            mobileProfileDropdown.classList.toggle('hidden');
        });


        document.addEventListener('click', (event) => {
            if (!profileDropdown.contains(event.target) && !profileDropdownButton.contains(event.target)) {
                profileDropdown.classList.add('hidden');
                profileDropdownButton.setAttribute('aria-expanded', false);
            }
            if (!mobileProfileDropdown.contains(event.target) && !mobileProfileDropdownButton.contains(event.target)) {
                mobileProfileDropdown.classList.add('hidden');
                mobileProfileDropdownButton.setAttribute('aria-expanded', false);
            }
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', false);
            }
        });

        mobileMenuButton.addEventListener('click', () => {
            const expanded = !mobileMenu.classList.contains('hidden');
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });
      });
    </script>
    @include("layouts.user.partials.footer")
</body>
</html>