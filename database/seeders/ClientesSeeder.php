<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::updateOrCreate(
            [
                'rfc' => 'XAXX010101000'
            ],
            [
                'nombre' => 'PUBLICO EN GENERAL',
                'razon_social' => 'PUBLICO EN GENERAL',
                'telefono' => null,
                'email' => null,
                'codigo_postal' => '80194', // cambia si tu sucursal tiene otro CP
                'regimen_fiscal' => '616',
                'uso_cfdi' => 'S01',
                'direccion' => null
            ]
        );
    }
}
