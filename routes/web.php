<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{product}/edit', [ProductController::class, 'edit']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/stocks', function () {
    return view('stocks');
 
=======
}); //weww
>>>>>>> ba4f26394730cea02532689d6c9112df92fe7c23

