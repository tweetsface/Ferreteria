<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Familia;

class FamiliasSeeder extends Seeder
{
    public function run()
    {

        $familias = [

            ['nombre' => 'Herramientas Manuales'],
            ['nombre' => 'Herramientas Eléctricas'],
            ['nombre' => 'Construcción'],
            ['nombre' => 'Plomería'],
            ['nombre' => 'Electricidad'],
            ['nombre' => 'Pinturas y Recubrimientos'],
            ['nombre' => 'Tornillería y Fijación'],
            ['nombre' => 'Seguridad Industrial'],
            ['nombre' => 'Jardinería'],
            ['nombre' => 'Material de Corte'],
            ['nombre' => 'Medición'],
            ['nombre' => 'Accesorios'],
            ['nombre' => 'Ferretería General']

        ];

        foreach ($familias as $familia) {

            Familia::create($familia);

        }

    }
}