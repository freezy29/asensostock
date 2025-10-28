<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//index
Route::get('/', [ProductController::class, 'index'])->middleware('auth');
//dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')
    ->name('dashboard.index');

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('products', ProductController::class)
        ->except(['index', 'show']);

    Route::resource('categories', ProductCategoryController::class)
        ->except(['index', 'show']);

    Route::resource('variants', ProductVariantController::class)
        ->except(['index', 'show']);

    Route::resource('transactions', TransactionController::class)
        ->except(['index', 'show', 'create']);
});

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class)
        ->only(['index', 'show']);

    Route::resource('categories', ProductCategoryController::class)
        ->only(['index', 'show']);

    Route::resource('variants', ProductVariantController::class)
        ->only(['index', 'show']);

    Route::resource('transactions', TransactionController::class)
        ->only(['index', 'show', 'create']);
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
