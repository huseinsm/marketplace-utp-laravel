<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // POST /api/tags
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $tag = Tag::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Tag berhasil dibuat',
            'data'    => $tag
        ], 201);
    }

    // PUT /api/products/{id}/tag/{tagId}
    public function attachTag($productId, $tagId)
    {
        $product = Product::findOrFail($productId);
        $tag     = Tag::findOrFail($tagId);

        // Cegah duplikat
        if (!$product->tags()->where('tag_id', $tagId)->exists()) {
            $product->tags()->attach($tagId);
        }

        return response()->json([
            'message' => 'Tag berhasil ditambahkan ke produk',
            'data'    => $product->load('tags')
        ]);
    }

    // GET /api/products/{id}
    public function showProduct($id)
    {
        $product = Product::with('tags')->findOrFail($id);

        return response()->json([
            'data' => $product
        ]);
    }
}