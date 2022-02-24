<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin Redes',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Cajero',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Capturista Datos',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Empleado General',
            'guard_name' => 'web',
        ]);

    }
}
