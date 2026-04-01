<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'user_id' => 1,
                'name'    => 'Toko Maju Jaya',
                'address' => 'Jl. Sudirman No.1, Jakarta',
                'phone'   => '081234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'name'    => 'Toko Bandung Raya',
                'address' => 'Jl. Merdeka No.5, Bandung',
                'phone'   => '082345678901',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'name'    => 'Toko Surabaya Indah',
                'address' => 'Jl. Diponegoro No.12, Surabaya',
                'phone'   => '083456789012',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 4,
                'name'    => 'Toko Yogya Sejahtera',
                'address' => 'Jl. Gatot Subroto No.8, Yogyakarta',
                'phone'   => '084567890123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 5,
                'name'    => 'Toko Medan Makmur',
                'address' => 'Jl. Ahmad Yani No.3, Medan',
                'phone'   => '085678901234',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 6,
                'name'    => 'Toko Makassar Jaya',
                'address' => 'Jl. Pahlawan No.7, Makassar',
                'phone'   => '086789012345',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('profiles')->insert($profiles);
    }
}
