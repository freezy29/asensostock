<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
Route::get('/login', function () {
    return view('login');
});