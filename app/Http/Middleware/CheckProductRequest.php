<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProductRequest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post')) {
            if (!$request->filled('name') || !$request->filled('price')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field name dan price tidak boleh kosong.',
                ], 400);
            }

            if ($request->has('stock') && $request->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock produk harus lebih dari 0.',
                ], 400);
            }
        }

        return $next($request);
    }
}