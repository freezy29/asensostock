<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//index
Route::get('/', [ProductController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('variants', ProductVariantController::class);
});
Route::middleware('admin')->group(function () {
    //categories
    Route::get('/categories/create', [ProductCategoryController::class, 'create'])
        ->name('categories.create');
    Route::post('/categories', [ProductCategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('/category/{category}/edit', [ProductCategoryController::class, 'edit'])
        ->name('categories.edit');
    Route::put('/category/{category}', [ProductCategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('/category/{category}', [ProductCategoryController::class, 'destroy'])
        ->name('categories.destroy');

    //products
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    //product variants
    Route::get('/variants/create', [ProductVariantController::class, 'create']);
    Route::post('/variants', [ProductVariantController::class, 'store']);
    Route::get('/variants/{variant}/edit', [ProductVariantController::class, 'edit']);
    Route::put('/variants/{variant}', [ProductVariantController::class, 'update']);
    Route::delete('/variants/{variant}', [ProductVariantController::class, 'destroy']);
});

//users
Route::middleware(['auth', 'admin'])->group(function () {
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
