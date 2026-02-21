<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|integer|min:1|max:100',
            'limit' => 'required|integer|in:10,25,50,100',
        ]);
        $categories = Category::paginate($validated['limit'], ['*'], 'page', $validated['page']);

        return response()->json([
            'data' => $categories->items(),
            'pagination' => [
                'total' => $categories->total(),
                'per_page' => (int) $validated['limit'],
                'current_page' => (int) $validated['page'],
            ],
            'status' => 'success',
        ], 200);
    }
}
