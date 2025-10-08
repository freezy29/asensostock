<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product}/edit', [ProductController::class, 'edit']);

<<<<<<< HEAD
// wew
=======
Route::get('/login', function () {
    return view('login');
});

Route::get('/stocks', function () {
    return view('stocks');   
 });
>>>>>>> 070d7b44d6755fab28605a8b9dc1be51c621732a
