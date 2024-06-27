<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
