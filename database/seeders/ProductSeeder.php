<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('Tidak ada user, skip ProductSeeder.');
            return;
        }

        $products = [
            ['name' => 'Laptop Gaming ASUS ROG',    'price' => 15000000, 'stock' => 10],
            ['name' => 'Mouse Wireless Logitech',   'price' => 350000,   'stock' => 50],
            ['name' => 'Keyboard Mechanical Rexus', 'price' => 700000,   'stock' => 30],
            ['name' => 'Monitor LG 24 inch',        'price' => 2500000,  'stock' => 15],
            ['name' => 'Headset Gaming HyperX',     'price' => 1200000,  'stock' => 20],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['user_id' => $user->id]));
        }

        $this->command->info('ProductSeeder selesai: ' . count($products) . ' produk ditambahkan.');
    }
}