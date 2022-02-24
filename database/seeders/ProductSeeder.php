<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'name' => 'Laravel',
            'cost' => 200,
            'price' => 350,
            'price_mayoreo' => 345,
            'price' => 350,
            'barcode' => '750100',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png',
        ]);
        Product::create([
            'name' => 'Laravel numero 2',
            'cost' => 250,
            'price' => 300,
            'price_mayoreo' => 290,
            'barcode' => '750700',
            'stock' => 800,
            'alerts' => 12,
            'category_id' => 2,
            'image' => 'curso2.png',
        ]);
        Product::create([
            'name' => 'vue js',
            'cost' => 280,
            'price' => 360,
            'price_mayoreo' => 350,
            'barcode' => '750707',
            'stock' => 80,
            'alerts' => 6,
            'category_id' => 3,
            'image' => 'vue.png',
        ]);
    }
}
