<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Validasi POST: pastikan field items ada dan tidak kosong
        if ($request->isMethod('post')) {
            if (!$request->has('user_id') || empty($request->input('user_id'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field user_id wajib diisi.',
                ], 400);
            }

            if (!$request->has('items') || !is_array($request->input('items')) || count($request->input('items')) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field items wajib diisi dan harus berupa array yang tidak kosong.',
                ], 400);
            }

            foreach ($request->input('items') as $index => $item) {
                if (!isset($item['quantity']) || $item['quantity'] < 1) {
                    return response()->json([
                        'success' => false,
                        'message' => "Quantity pada item ke-{$index} harus lebih dari 0.",
                    ], 400);
                }
            }
        }

        if ($request->route('id') && !is_numeric($request->route('id'))) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter id harus berupa angka.',
            ], 400);
        }

        return $next($request);
    }
}
