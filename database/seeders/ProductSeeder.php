<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['user_id' => 1, 'name' => 'Sepatu Murah', 'price' => 50000, 'stock' => 10],
            ['user_id' => 1, 'name' => 'Baju Baru', 'price' => 75000, 'stock' => 20],
            ['user_id' => 1, 'name' => 'Tas Keren', 'price' => 120000, 'stock' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}