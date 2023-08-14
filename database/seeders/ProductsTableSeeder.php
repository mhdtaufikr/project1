<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Insert sample products
        Product::create([
            'name' => 'Vespa Matic 2022',
            'description' => '<p>Pajak Mati 1 Tahun</p>',
            'price' => 20000000.00,
            'status' => 0,
            'product_picture' => 'img/1691853189.png',
        ]);

        Product::create([
            'name' => 'Vespa Matic 2020',
            'description' => '<p>Pajak Mati 1 Tahun</p>',
            'price' => 18000000.00,
            'status' => 0,
            'product_picture' => 'img/1691854228.png',
        ]);

        Product::create([
            'name' => 'Vespa Matic 2018',
            'description' => '<p>Pajak Mati 2 Tahun</p>',
            'price' => 18000000.00,
            'status' => 0,
            'product_picture' => 'img/1691868055.jpg',
        ]);

        // Add more products here...
    }
}
