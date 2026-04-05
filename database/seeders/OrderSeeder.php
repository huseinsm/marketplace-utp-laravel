<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Tidak ada user atau product, skip OrderSeeder.');
            return;
        }

        $orders = [
            [
                'user_id' => $users->first()->id,
                'items' => [
                    ['product_id' => $products->get(0)?->id, 'quantity' => 2],
                    ['product_id' => $products->get(1)?->id, 'quantity' => 1],
                ],
            ],
            [
                'user_id' => $users->first()->id,
                'items' => [
                    ['product_id' => $products->get(2)?->id, 'quantity' => 1],
                ],
            ],
            [
                'user_id' => $users->last()->id,
                'items' => [
                    ['product_id' => $products->get(3)?->id, 'quantity' => 1],
                    ['product_id' => $products->get(4)?->id, 'quantity' => 3],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $totalPrice = 0;
            $itemsData = [];

            foreach ($orderData['items'] as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $itemPrice = $product->price * $item['quantity'];
                $totalPrice += $itemPrice;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $orderData['user_id'],
                'total_price' => $totalPrice,
            ]);

            foreach ($itemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }
        }

        $this->command->info('OrderSeeder selesai: ' . count($orders) . ' order ditambahkan.');
    }
}
