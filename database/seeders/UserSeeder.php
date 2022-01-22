<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'anonimo',
            'phone' => '7713336045',
            'email' => 'user@gmail.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('741852963'),
        ]);



        User::create([
            'name' => 'hola',
            'phone' => '7713336047',
            'email' => 'user2@gmail.com',
            'profile' => 'Empleado',
            'status' => 'Active',
            'password' => bcrypt('123456789'),
        ]);
    }
}
