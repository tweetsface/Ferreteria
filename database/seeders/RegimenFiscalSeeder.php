<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RegimenFiscalSeeder extends Seeder
{

    public function run()
    {

        DB::table('regimenes_fiscales')->insert([

            [
                'clave'=>'601',
                'descripcion'=>'General de Ley Personas Morales',
                'tipo_persona'=>'moral'
            ],

            [
                'clave'=>'603',
                'descripcion'=>'Personas Morales con Fines no Lucrativos',
                'tipo_persona'=>'moral'
            ],

            [
                'clave'=>'605',
                'descripcion'=>'Sueldos y Salarios',
                'tipo_persona'=>'fisica'
            ],

            [
                'clave'=>'606',
                'descripcion'=>'Arrendamiento',
                'tipo_persona'=>'fisica'
            ],

            [
                'clave'=>'612',
                'descripcion'=>'Personas Físicas con Actividades Empresariales',
                'tipo_persona'=>'fisica'
            ],

            [
                'clave'=>'626',
                'descripcion'=>'RESICO',
                'tipo_persona'=>'fisica'
            ]

        ]);

    }

}
