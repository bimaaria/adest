<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\AddRequest;
use App\Http\Requests\UploadImageRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
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

    public function store(AddRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['image'] = $validated['image_path'];
            unset($validated['image_path']);

            $product = Product::create($validated);

            return response()->json([
                'data' => $product,
                'status' => 'success',
            ], 201);
        } catch (\Throwable $e) {
            if ($request->has('image_path')) {
                Storage::disk('public')->delete($request->image_path);
            }

            return response()->json([
                'message' => 'Failed to create product.',
                'status' => 'error',
            ], 500);
        }
    }

    public function upload(UploadImageRequest $request)
    {
        $request->validated();

        $path = $request->file('image')->store('products', 'public');
        return response()->json([
            'path' => $path,
            'status' => 'success',
        ], 200);
    }
}
