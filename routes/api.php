<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; // Create ApiController later

Route::get('/products', [ApiController::class, 'products']);
Route::get('/products/{productID}', [ApiController::class, 'product']);
Route::get('/categories', [ApiController::class, 'categories']);


