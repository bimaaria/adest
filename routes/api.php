<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

Route::get('/products', function (Request $request) {
    return response()->json([
        'data' => [
            [
                'id' => 1,
                'name' => 'Product 1',
                'price' => 100,
            ],
            [
                'id' => 2,
                'name' => 'Product 2',
                'price' => 200,
            ],
        ],
    ]);
});
