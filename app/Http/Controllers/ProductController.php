<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * POST /api/products: Membuat produk baru
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name'    => 'required|string|max:150',
                'price'   => 'required|numeric|min:0',
                'stock'   => 'required|integer|min:0',
            ]);

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product berhasil dibuat.',
                'data'    => $product->load('user'),
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * GET /api/products: Mengambil semua produk
     */
    public function index(): JsonResponse
    {
        $products = Product::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar produk berhasil diambil.',
            'data'    => $products,
        ], 200);
    }

    /**
     * GET /api/products/{id}:  Mengambil produk berdasarkan ID
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::with('user')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail produk berhasil diambil.',
            'data'    => $product,
        ], 200);
    }
}