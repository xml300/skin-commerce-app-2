<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; // Create ApiController later

Route::get('/products', [ApiController::class, 'products']);
Route::get('/products/{productID}', [ApiController::class, 'product']);
Route::get('/categories', [ApiController::class, 'categories']);

Route::post('/admin/products', [ApiController::class, 'storeProduct'])->name('admin.products.store');
Route::delete('/admin/products/{productID}', [ApiController::class, 'deleteProduct']);
Route::put('/admin/products/{productId}', [ApiController::class, 'updateProduct']);


