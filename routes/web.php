<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', [ProductController::class, 'index'])->middleware('auth'); */

Route::get('/', [ProductController::class, 'index']);

Route::resource('products', ProductController::class)->middleware('auth');
Route::resource('variants', ProductVariantController::class);

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
