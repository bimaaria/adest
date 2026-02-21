<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');
