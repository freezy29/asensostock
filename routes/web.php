<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);
});
Route::middleware('admin')->group(function () {

    //products
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    //transactions
    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
        ->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
        ->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');
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
