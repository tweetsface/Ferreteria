<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPago;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'Efectivo',
                'comision' => 0.00,
                'activo' => true
            ],
            [
                'nombre' => 'Tarjeta',
                'comision' => 3.50,
                'activo' => true
            ]
        ];

        foreach ($tipos as $tipo) {
            TipoPago::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }
    }
}
