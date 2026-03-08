<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sucursales')->insert([

            [
                'nombre' => 'Sucursal Principal',
                'direccion' => 'Av. Principal #100',
                'telefono' => '6120000000',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Sucursal Centro',
                'direccion' => 'Calle Centro #45',
                'telefono' => '6120000001',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Sucursal Norte',
                'direccion' => 'Colonia Norte #200',
                'telefono' => '6120000002',
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}