<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('products/Index');
    }

    public function create()
    {
        $categories = Category::all();

        return Inertia::render('products/Create', [
            'categories' => $categories,
        ]);
    }

    public function edit()
    {
        return Inertia::render('products/Edit');
    }
}
