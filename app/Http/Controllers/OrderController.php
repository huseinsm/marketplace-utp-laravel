<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            $order = DB::transaction(function () use ($validated) {
                $totalPrice = 0;
                $orderItemsData = [];

                foreach ($validated['items'] as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $itemPrice = $product->price * $item['quantity'];
                    $totalPrice += $itemPrice;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ];
                }

                $order = Order::create([
                    'user_id' => $validated['user_id'],
                    'total_price' => $totalPrice,
                ]);

                foreach ($orderItemsData as $itemData) {
                    $order->orderItems()->create($itemData);
                }

                return $order->load(['user', 'orderItems.product']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat.',
                'data' => $order,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function index(): JsonResponse
    {
        $orders = Order::with(['user', 'orderItems.product'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar order berhasil diambil.',
            'data' => $orders,
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::with(['user', 'orderItems.product'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail order berhasil diambil.',
            'data' => $order,
        ], 200);
    }
}
