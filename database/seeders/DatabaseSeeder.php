<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Products;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $products = [
            [
                'name_product' => 'Tenda',
                'sales_price' => 1,
                'unit_measure' => 'm2'
            ],
            [
                'name_product' => 'floring',
                'sales_price' => 1,
                'unit_measure' => 'm2'
            ],
            [
                'name_product' => 'Kursi Futura',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
            [
                'name_product' => 'Kipas',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
            [
                'name_product' => 'Meja Sofa',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
            [
                'name_product' => 'Vas Bunga',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
            [
                'name_product' => 'Podium',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
            [
                'name_product' => 'Mini Garden',
                'sales_price' => 1,
                'unit_measure' => 'Units'
            ],
        ];

        foreach ($products as $product) {
            Products::create([
                'name_product' => $product['name_product'],
                'sales_price' => $product['sales_price'],
                'unit_measure' => $product['unit_measure']
            ]);
        }
    }
}
