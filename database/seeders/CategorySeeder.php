<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Category::create([
            'name' => 'cursos',
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Category::create([
            'name' => 'xdxd',
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Category::create([
            'name' => 'Hola',
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Category::create([
            'name' => 'Computadoras',
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
    }
}
