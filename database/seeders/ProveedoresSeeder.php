<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {

        DB::table('proveedores')->insert([

            [
                'nombre' => 'Truper',
                'contacto' => 'Ventas Truper',
                'telefono' => '800-018-7873',
                'email' => 'ventas@truper.com',
                'rfc' => 'TRU010101AB1',
                'direccion' => 'Ciudad de México',
                'activo' => 1
            ],

            [
                'nombre' => 'Pretul',
                'contacto' => 'Ventas Pretul',
                'telefono' => '800-018-7873',
                'email' => 'ventas@pretul.com',
                'rfc' => 'PRE010101AB2',
                'direccion' => 'Ciudad de México',
                'activo' => 1
            ],

            [
                'nombre' => 'Bosch México',
                'contacto' => 'Ventas Bosch',
                'telefono' => '800-123-4567',
                'email' => 'ventas@bosch.com',
                'rfc' => 'BOS010101AB3',
                'direccion' => 'Estado de México',
                'activo' => 1
            ],

            [
                'nombre' => 'Makita',
                'contacto' => 'Ventas Makita',
                'telefono' => '800-987-6543',
                'email' => 'ventas@makita.com',
                'rfc' => 'MAK010101AB4',
                'direccion' => 'Jalisco',
                'activo' => 1
            ],

            [
                'nombre' => 'Stanley Black & Decker',
                'contacto' => 'Ventas Stanley',
                'telefono' => '800-456-7890',
                'email' => 'ventas@stanley.com',
                'rfc' => 'STA010101AB5',
                'direccion' => 'Nuevo León',
                'activo' => 1
            ],

            [
                'nombre' => 'Home Depot Proveedores',
                'contacto' => 'Área Comercial',
                'telefono' => '800-004-6633',
                'email' => 'proveedores@homedepot.com',
                'rfc' => 'HDP010101AB6',
                'direccion' => 'Monterrey',
                'activo' => 1
            ],

            [
                'nombre' => 'Ferretera Nacional',
                'contacto' => 'Departamento Ventas',
                'telefono' => '667-123-4567',
                'email' => 'ventas@ferretera.com',
                'rfc' => 'FER010101AB7',
                'direccion' => 'Culiacán',
                'activo' => 1
            ]

        ]);

    }
}