<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unidades')->insert([

            [
                'nombre' => 'Pieza',
                'abreviatura' => 'pza',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Metro',
                'abreviatura' => 'm',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Centímetro',
                'abreviatura' => 'cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Kilogramo',
                'abreviatura' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Gramo',
                'abreviatura' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Litro',
                'abreviatura' => 'lt',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Mililitro',
                'abreviatura' => 'ml',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Caja',
                'abreviatura' => 'cj',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Paquete',
                'abreviatura' => 'paq',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Bulto',
                'abreviatura' => 'blt',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Rollo',
                'abreviatura' => 'rll',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}