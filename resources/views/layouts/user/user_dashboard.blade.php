<!DOCTYPE html>
<html lang="en" class="dark"> {{-- `dark` class for initial dark mode, consider user preference from local storage on load --}}
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Stara')</title> {{-- Assuming 'Stara' is the brand name --}}
    @vite("resources/css/app.css") {{-- Include compiled CSS using Vite --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> {{-- Consider self-hosting or using a more modern icon library if performance is critical --}}
  </head>
  <body
    class="bg-warm-white text-warm-black dark:bg-warm-black dark:text-warm-white font-sans min-h-screen" {{-- Base body styles using color palette and font --}}
  >
  <header class="bg-warm-white dark:bg-warm-black shadow-md pt-0 relative"> {{-- Header styling with background, shadow, and positioning --}}
    <div class="container mx-auto px-4 flex justify-between items-center py-4 md:py-6"> {{-- Container for header content, padding and flex layout, responsive vertical padding --}}
        <a href="/" aria-label="Stara Homepage"> {{-- Added aria-label for accessibility --}}
            <img src="{{ asset('images/stara-logo.jpg') }}" class="h-12" alt="Stara Logo"> {{-- Logo with alt text for accessibility --}}
        </a>

        <nav class="flex items-center font-medium"> {{-- Navigation container --}}
            <a href="/"
               class="text-warm-black dark:text-muted-sage-green hover:text-warm-black dark:hover:text-warm-white px-3 py-2 rounded-md transition-colors duration-200">Home</a> {{-- Navigation link, added padding and rounded corners for better touch targets and visual feedback --}}
            <a href="/products"
               class="text-warm-black dark:text-muted-sage-green hover:text-warm-black dark:hover:text-warm-white px-3 py-2 rounded-md transition-colors duration-200">Products</a> {{-- Navigation link --}}

            @auth
            <a
               href="/cart"
               id="cart-link"
               class="text-warm-black dark:text-muted-sage-green hover:text-warm-black dark:hover:text-warm-white px-3 py-2 rounded-md transition-colors duration-200 group relative" {{-- Relative positioning for badge --}}
            ><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i><span class="sr-only">Shopping Cart</span> {{-- Added aria-hidden and sr-only for icon accessibility --}}<sup class="absolute top-0 right-[-0.25rem] mt-[-0.25rem] px-1 py-0 text-xs rounded-full bg-muted-sage-green dark:bg-antique-gold dark:group-hover:bg-soft-sand-beige"><span id="cart-count" class="text-warm-white dark:text-warm-black font-normal"><!-- Cart Count --></span></sup></a {{-- Adjusted badge positioning, smaller font size, removed `super` class which is likely not Tailwind --}}
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


            <div class="ml-4 group relative"> {{-- Relative positioning for dropdown --}}
                <button id="profile-dropdown-button" type="button" {{-- Explicit button type --}}
                        class="peer flex items-center text-warm-black dark:text-muted-sage-green hover:text-warm-black dark:hover:text-warm-white focus:outline-none focus:ring-2 focus:ring-muted-sage-green dark:focus:ring-antique-gold px-3 py-2 rounded-md transition-colors duration-200" {{-- Added focus ring for accessibility, padding and rounded corners --}}
                        aria-haspopup="true" aria-expanded="false" aria-label="Profile Menu"> {{-- Added aria-label for accessibility --}}
                    <i class="fa-regular fa-user" aria-hidden="true"></i> <span class="ml-2 hidden sm:inline">Profile</span> {{-- Icon accessibility --}}
                </button>

                <div id="profile-dropdown" class="hidden group-hover:block absolute top-full right-0 mt-2 w-48 bg-warm-white dark:bg-warm-black border border-soft-sand-beige dark:border-warm-black rounded-md shadow-lg z-10" {{-- Adjusted dropdown positioning and appearance, `group-hover:block` for CSS-based dropdown --}}
                     aria-labelledby="profile-dropdown-button" aria-hidden="true"> {{-- aria-hidden initially true as it's hidden --}}

                    <div class="w-full py-1">
                        <!-- Dark Mode Toggle Switch -->
                        <div class="flex items-center justify-between px-4 py-2">
                            <label for="darkModeToggleDropdown" class="block text-sm text-warm-black dark:text-warm-white" {{-- Block display for label --}}
                                   >Dark Mode</label>
                            <div class="relative flex items-center justify-center mt-1">
                                <input
                                    type="checkbox"
                                    id="darkModeToggleDropdown"
                                    class="appearance-none w-10 h-5 bg-soft-sand-beige dark:bg-muted-sage-green rounded-full peer cursor-pointer relative"
                                />
                                <span
                                    class="absolute left-1 top-1 bg-warm-white dark:bg-warm-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-muted-sage-green"
                                ></span>
                            </div>
                        </div>

                        <hr class="border-t border-soft-sand-beige dark:border-warm-black">

                        @guest
                        <a href="/login" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black transition-colors duration-200"> {{-- Block links for dropdown, added text-sm and transition --}}
                            Login
                        </a>
                        <a href="/register" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black transition-colors duration-200">
                            Sign Up
                        </a>
                        @endguest

                        @auth
                        <div class="px-4 py-2">
                            <p class="text-sm text-warm-black dark:text-warm-white">Logged in as:</p>
                            <p class="text-warm-black dark:text-muted-sage-green font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-warm-black dark:text-warm-white">{{ Auth::user()->email }}</p> {{-- Reduced email text size --}}
                        </div>
                        <hr class="border-t border-soft-sand-beige dark:border-warm-black">
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-warm-black dark:text-warm-white hover:bg-soft-sand-beige dark:hover:bg-warm-black transition-colors duration-200" {{-- Block link, text-sm, transition --}}
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
            htmlElement.classList.remove("light"); // Consider removing 'light' class, not strictly needed
            localStorage.setItem("darkMode", "enabled");
            darkModeToggle.checked = true;
          } else {
            htmlElement.classList.remove("dark");
            htmlElement.classList.add("light"); // Consider removing 'light' class
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
          window.matchMedia("(prefers-color-scheme: dark)").matches // Respect system preference
        ) {
          setDarkMode(true);
        } else {
          setDarkMode(false);
        }

        darkModeToggle.addEventListener("change", () => {
          setDarkMode(darkModeToggle.checked);
        });

        // Dropdown Toggle (Basic JS, consider using Tailwind Collapse or similar for more complex scenarios)
        profileDropdownButton.addEventListener('click', () => {
            const expanded = profileDropdownButton.getAttribute('aria-expanded') === 'true' || false;
            profileDropdownButton.setAttribute('aria-expanded', !expanded);
            profileDropdown.classList.toggle('hidden'); // Simple toggle, consider accessibility implications for complex menus
            profileDropdown.setAttribute('aria-hidden', expanded); // Update aria-hidden when toggling visibility
        });

        document.addEventListener('click', (event) => { // Close dropdown on outside click
            if (!profileDropdown.contains(event.target) && !profileDropdownButton.contains(event.target)) {
                profileDropdown.classList.add('hidden');
                profileDropdownButton.setAttribute('aria-expanded', false);
                profileDropdown.setAttribute('aria-hidden', true);
            }
        });
      });
    </script>
    @include("layouts.user.partials.footer") {{-- Assuming footer partial exists --}}
  </body>
</html>