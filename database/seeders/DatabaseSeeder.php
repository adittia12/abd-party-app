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
                'inter_ref' => 'ABD0001',
                'name_product' => 'Meja',
                'sales_price' => 1,
                'unit_measure' => 'Unit'
            ],
            [
                'inter_ref' => 'ABD0002',
                'name_product' => 'Kursi',
                'sales_price' => 1,
                'unit_measure' => 'Unit'
            ]
        ];

        foreach ($products as $product) {
            Products::create([
                'inter_ref' => $product['inter_ref'],
                'name_product' => $product['name_product'],
                'sales_price' => $product['sales_price'],
                'unit_measure' => $product['unit_measure']
            ]);
        }
    }
}
