<?php

use App\Http\Controllers\api\CategoryApiController;
use App\Http\Controllers\api\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

Route::get('/products', [ProductApiController::class, 'index'])->name('api.products.index');
Route::post('/products', [ProductApiController::class, 'store'])->name('api.products.store');
Route::post('/products/upload', [ProductApiController::class, 'upload'])->name('api.products.upload');
Route::get('/categories', [CategoryApiController::class, 'index'])->name('api.categories.index');
