<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Create UserController later
use App\Http\Controllers\AdminController; // Create AdminController later

Route::get('/', [UserController::class, 'index'])->name("home");
Route::get('/products', [UserController::class, 'products']);
Route::get('/product/{productId}', [UserController::class, 'productDetails']);

Route::get('/login', [UserController::class, 'login'])->name('login.get');
Route::get("/register", [UserController::class, 'register'])->name('register.get');

Route::post('/api/login', [AuthController::class, 'login'])->name("login");
Route::post('/api/register', [AuthController::class, 'register'])->name("register");

Route::middleware(['auth.user'])->group(function () {
    Route::get('/cart', [UserController::class, 'cart'])->withoutMiddleware('update.cart');
    Route::get('/checkout', [UserController::class, 'checkout']);
    Route::get('/order-confirmation', [UserController::class, 'orderConfirmation']);
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get('/api/cart', [UserController::class, 'getCart'])->name('cart.get');
    Route::get('/api/cart/count', [UserController::class, 'getCartCount']);
    // Route::post('/api/cart', [UserController::class, 'massUpdateCart'])->name('cart.mass.update');
    Route::post('/api/cart/item', [UserController::class, 'addToCart'])->name('cart.add');
    Route::put('/api/cart/item/{productID}', [UserController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/api/cart/item/{productID}', [UserController::class, 'removeCartItem'])->name('cart.remove');
    Route::delete('/api/cart', [UserController::class, 'clearCart'])->name('cart.clear');

    Route::post('/api/order', [UserController::class, 'placeOrder'])->name('order.place');
});


Route::get('/admin', [AdminController::class, 'index']);