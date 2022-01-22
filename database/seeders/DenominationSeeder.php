<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Denomination::create([
            'type' => 'Billete',
            'value' => 100,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 500,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 200,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Billete',
            'value' => 100,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Denomination::create([
            'type' => 'Billete',
            'value' => 50,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Denomination::create([
            'type' => 'Billete',
            'value' => 20,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 10,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 5,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 2,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 1,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);

        Denomination::create([
            'type' => 'Moneda',
            'value' => 1,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Denomination::create([
            'type' => 'Moneda',
            'value' => 0.5,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
        Denomination::create([
            'type' => 'Otro',
            'value' => 0,
            'image' => 'https://dummyimage.com/200x150/4648c9/fff',
        ]);
    }
}
