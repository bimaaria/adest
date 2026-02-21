<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('products', function () {
        return Inertia::render('products/Index');
    })->name('products');

    Route::get('categories', function () {
        return Inertia::render('categories/Index');
    })->name('categories');

    Route::get('transactions', function () {
        return Inertia::render('transactions/Index');
    })->name('transactions');
});

require __DIR__.'/settings.php';
