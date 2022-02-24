<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Actualizar productos',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Categoria buscar',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Categoria Act',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Crear categorias',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Crear productos',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Eliminar categorias',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Eliminar productos',
            'guard_name' => 'web',
        ]);
    }
}
