<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|integer|min:1|max:100',
            'limit' => 'required|integer|in:10,25,50,100',
        ]);
        $products = Product::with('category')
            ->paginate($validated['limit'], ['*'], 'page', $validated['page']);

        return response()->json([
            'data' => $products->items(),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => (int) $validated['limit'],
                'current_page' => (int) $validated['page'],
            ],
            'status' => 'success',
        ], 200);
    }
}
