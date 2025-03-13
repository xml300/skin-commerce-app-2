<footer class="bg-warm-white dark:bg-warm-black border-t border-soft-sand-beige dark:border-warm-black py-8 mt-12"> {{-- Updated border classes, increased padding for vertical rhythm --}}
    <div class="container mx-auto px-4"> {{-- Container for content, keeping horizontal padding --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center md:text-left"> {{-- Grid layout for footer sections, responsive columns --}}
            <div>
                <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-4">About Stara</h4> {{-- Section heading, consistent typography --}}
                <p class="text-sm text-warm-black dark:text-muted-sage-green">Your destination for essential and natural products. We believe in quality, sustainability, and well-being.</p> {{-- Description text, using muted accent color for softer text --}}
            </div>
            <div>
                <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-4">Customer Service</h4> {{-- Section heading --}}
                <ul class="list-none pl-0"> {{-- Removing default list styling --}}
                    <li><a href="#" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">Contact Us</a></li> {{-- List links, block display for full click area, consistent text styles and hover effect --}}
                    <li><a href="#" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">Shipping & Returns</a></li>
                    <li><a href="#" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-4">Quick Links</h4> {{-- Section heading --}}
                <ul class="list-none pl-0"> {{-- Removing default list styling --}}
                    <li><a href="/" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">Homepage</a></li> {{-- List links --}}
                    <li><a href="/products" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">Products</a></li>
                    <li><a href="/cart" class="block text-sm text-warm-black dark:text-muted-sage-green hover:text-muted-sage-green dark:hover:text-warm-white py-1 transition-colors duration-200">Shopping Cart</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg text-warm-black dark:text-warm-white mb-4">Connect With Us</h4> {{-- Section heading --}}
                <div class="flex justify-center md:justify-start space-x-4 mb-4"> {{-- Social icons container, flex layout, spacing --}}
                    <a href="#" class="text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-warm-white transition-colors duration-200" aria-label="Facebook"><i class="fa-brands fa-facebook-square fa-lg"></i><span class="sr-only">Facebook</span></a> {{-- Social icons with aria-labels for accessibility, consistent icon styling --}}
                    <a href="#" class="text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-warm-white transition-colors duration-200" aria-label="Instagram"><i class="fa-brands fa-instagram fa-lg"></i><span class="sr-only">Instagram</span></a>
                    <a href="#" class="text-warm-black dark:text-warm-white hover:text-muted-sage-green dark:hover:text-warm-white transition-colors duration-200" aria-label="Twitter"><i class="fa-brands fa-twitter-square fa-lg"></i><span class="sr-only">Twitter</span></a>
                </div>
                <p class="text-sm text-warm-black dark:text-muted-sage-green">Stay updated with our latest news and offers.</p> {{-- Subtext for social links --}}
            </div>
        </div>
        <hr class="my-8 border-t border-soft-sand-beige dark:border-warm-black"> {{-- Separator line, increased vertical spacing --}}
        <div class="text-center text-sm text-warm-black dark:text-muted-sage-green">
            <p>© {{ date('Y') }} Stara. All rights reserved.</p>
            <p class="mt-2">Simplified MVP - No Payment Gateway, Simulated Checkout.</p>
            <p class="mt-2">
                <a href="/privacy" class="hover:text-muted-sage-green dark:hover:text-warm-white transition-colors duration-200">Privacy Policy</a>
                <span class="mx-2">·</span> {{-- Separator dot --}}
                <a href="/terms" class="hover:text-muted-sage-green dark:hover:text-warm-white transition-colors duration-200">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>