<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Create UserController later
use App\Http\Controllers\AdminController; // Create AdminController later


Route::middleware(['user', 'redirect'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name("home");
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::get('/contact', [UserController::class, 'contact']);
    Route::get('/privacy', [UserController::class, 'privacy']);
    Route::get('/terms', [UserController::class, 'terms']);
    Route::get('/products', [UserController::class, 'products'])->name('products');
    Route::get('/product/{productId}', [UserController::class, 'productDetails'])->name('product.details');
});

Route::get('/login', [UserController::class, 'login'])->name('login.get');
Route::get("/register", [UserController::class, 'register'])->name('register.get');

Route::post('/api/login', [AuthController::class, 'login'])->name("login");
Route::post('/api/register', [AuthController::class, 'register'])->name("register");

Route::middleware(['auth.user', 'redirect'])->group(function () {
    Route::get('/cart', [UserController::class, 'cart'])->withoutMiddleware('update.cart');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders.get');
    Route::get('/orders/{orderId}', [UserController::class, 'orderDetails'])->name('user.orders.show');
    Route::get('/checkout', [UserController::class, 'checkout']);
    Route::get('/order-confirmation', [UserController::class, 'orderConfirmation'])->name('user.order-confirm');
    Route::get('/order-confirmation/success', [UserController::class, 'orderSuccess'])->name('user.order-success');
    Route::get('/order-confirmation/failed', [UserController::class, 'orderFailed'])->name('user.order-failed');
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get('/api/cart', [UserController::class, 'getCart'])->name('cart.get');
    Route::get('/api/cart/count', [UserController::class, 'getCartCount']);
    Route::post('/api/cart/item', [UserController::class, 'addToCart'])->name('cart.add');
    Route::put('/api/cart/item/{productID}', [UserController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/api/cart/item/{productID}', [UserController::class, 'removeCartItem'])->name('cart.remove');
    Route::delete('/api/cart', [UserController::class, 'clearCart'])->name('cart.clear');

    Route::post('/api/order', [UserController::class, 'placeOrder'])->name('order.place');
    Route::get('/callback', [UserController::class, 'paymentCallback']);
});


Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');

    Route::patch('/admin/profile/update', [AdminController::class, 'profile_update'])->name('admin.profile.update');
    Route::put('/admin/profile/pass/update', [AdminController::class, 'pass_update'])->name('admin.password.update');


    Route::get('/admin/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::get('/admin/products/edit/{productId}', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::get('/admin/products/{productId}', [AdminController::class, 'productDetails'])->name('admin.products.details');


    Route::get('/admin/orders/{orderId}', [AdminController::class, 'orderDetails'])->name('admin.orders.show');
    Route::put('/admin/orders/{orderId}', [AdminController::class, 'orderUpdate'])->name('admin.orders.update');
    Route::post('/admin/orders/create', [AdminController::class, 'orderCreate'])->name('admin.orders.store');
    Route::get('/admin/orders/edit/{orderId}', [AdminController::class, 'orderEdit'])->name('admin.orders.edit');
    Route::delete('/admin/orders/delete/{orderId}', [AdminController::class, 'orderDelete'])->name('admin.orders.destroy');


    Route::get('/admin/customers/create', [AdminController::class, 'customers'])->name('admin.customers.store');
    Route::get('/admin/customers/{userId}', [AdminController::class, 'customerDetails'])->name('admin.customers.show');
    Route::put('/admin/customers/{userId}', [AdminController::class, 'customerUpdate'])->name('admin.customers.update');
    Route::get('/admin/customers/edit/{userId}', [AdminController::class, 'customerEdit'])->name('admin.customers.edit');
    Route::delete('/admin/customers/{userId}', [AdminController::class, 'customerDelete'])->name('admin.customers.destroy');


    Route::post('/api/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::delete('/api/admin/products/{productId}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');
    Route::put('/api/admin/products/{productId}', [AdminController::class, 'updateProduct'])->name('admin.products.update');

    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.destroy'); // or destroy if you prefer
});
