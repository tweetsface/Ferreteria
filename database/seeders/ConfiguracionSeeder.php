<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $configuraciones = [

            [
                'clave' => 'iva',
                'valor' => '16',
                'descripcion' => 'Porcentaje de IVA aplicado a las ventas'
            ],

            [
                'clave' => 'moneda',
                'valor' => 'MXN',
                'descripcion' => 'Moneda principal del sistema'
            ],

            [
                'clave' => 'simbolo_moneda',
                'valor' => '$',
                'descripcion' => 'Símbolo mostrado en el POS'
            ],

            [
                'clave' => 'redondeo',
                'valor' => '2',
                'descripcion' => 'Cantidad de decimales para redondeo'
            ]

        ];

        foreach ($configuraciones as $config) {

            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }
    }
}