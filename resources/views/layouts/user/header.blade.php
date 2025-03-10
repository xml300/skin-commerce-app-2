<!DOCTYPE html>
<html lang="en" class="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{$title ?? 'Skincare Shop' }}</title>
    @vite("resources/css/app.css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body
    class="bg-green-50 text-green-900 dark:bg-green-900 dark:text-green-50 font-sans min-h-screen"
  >
    <header class="bg-white dark:bg-black shadow-md py-4">
      <div class="container mx-auto px-4 flex justify-between items-center">
        <a href="/" class="text-xl font-bold text-green-900 dark:text-white"
          >Skincare Shop</a
        >

        <nav class="flex items-center font-medium">
          <a
            href="/"
            class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3"
            >Home</a
          >
          <a
            href="/products"
            class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3"
            >Products</a
          >
          <a
            href="/cart"
            id="cart-link"
            class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-white px-3 group"
            ><i class="fa-solid fa-cart-shopping"></i><sup class="mx-0.5 px-1 py-0 rounded-full bg-green-800 dark:bg-green-500 dark:group-hover:bg-green-100"><span id="cart-count" class="super text-white dark:text-black">0</span></sup></a
          >

          <!-- Dark Mode Toggle Switch -->
          <div class="flex items-center space-x-2 ml-4">
            <label for="darkModeToggle" class="text-green-700 dark:text-green-300"
              >Dark Mode</label
            >
            <div class="relative flex items-center justify-center mt-1">
              <input
                type="checkbox"
                id="darkModeToggle"
                class="appearance-none w-10 h-5 bg-green-300 dark:bg-green-700 rounded-full peer cursor-pointer relative"
              />
              <span
                class="absolute left-1 top-1 bg-white dark:bg-black rounded-full w-3 h-3 transition-all peer-checked:left-6 peer-checked:bg-green-500"
              ></span>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const htmlElement = document.documentElement;
        const cartCountSpan = document.getElementById("cart-count");

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

        // Function to update cart counter in header
        window.updateCartCounter = function () {
          // Make it global for use in other scripts
          let cart = JSON.parse(localStorage.getItem("cart") || "[]");
          let totalQuantity = cart.reduce(
            (sum, item) => sum + item.quantity,
            0
          );
          cartCountSpan.textContent = totalQuantity;
        };

        updateCartCounter(); // Initial cart count update on page load
      });
    </script>
 