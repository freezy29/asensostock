<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

//index
Route::get('/', [ProductController::class, 'index'])->middleware('auth');

//products
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
});
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});

//users
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
});

//auth
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest');
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
