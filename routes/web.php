<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);
Route::get('/login', function () {

    return view('auth.login');
});
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::resource('products', ProductController::class);
Route::resource('variants', ProductVariantController::class);
