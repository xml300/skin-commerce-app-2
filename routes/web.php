<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Create UserController later
use App\Http\Controllers\AdminController; // Create AdminController later

Route::get('/', [UserController::class, 'index']);
Route::get('/products', [UserController::class, 'products']);
Route::get('/product/{productId}', [UserController::class, 'productDetails']);
Route::get('/cart', [UserController::class, 'cart']);
Route::get('/checkout', [UserController::class, 'checkout']);
Route::get('/order-confirmation', [UserController::class, 'orderConfirmation']);

Route::get('/login', [UserController::class, 'login']);
Route::get("/register", [UserController::class, 'register']);


Route::get('/admin', [AdminController::class, 'index']);