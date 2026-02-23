<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/order', [OrderController::class, 'index'])->name('order');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/create', [ProductController::class, 'create'])->name('product.create');

    Route::get('categories', function () {
        return Inertia::render('categories/Index');
    })->name('categories');

    Route::get('transactions', function () {
        return Inertia::render('transactions/Index');
    })->name('transactions');
});

require __DIR__.'/settings.php';
