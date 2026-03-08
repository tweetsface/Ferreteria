<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsoCfdiSeeder extends Seeder
{

    public function run()
    {

        DB::table('usos_cfdi')->insert([

            ['clave'=>'G03','descripcion'=>'Gastos en general'],
            ['clave'=>'I01','descripcion'=>'Construcciones'],
            ['clave'=>'I02','descripcion'=>'Mobiliario y equipo de oficina'],
            ['clave'=>'I03','descripcion'=>'Equipo de transporte'],
            ['clave'=>'I04','descripcion'=>'Equipo de cómputo'],
            ['clave'=>'D01','descripcion'=>'Honorarios médicos'],
            ['clave'=>'D02','descripcion'=>'Gastos médicos'],
            ['clave'=>'D03','descripcion'=>'Gastos funerarios'],
            ['clave'=>'D04','descripcion'=>'Donativos'],
            ['clave'=>'D07','descripcion'=>'Primas por seguros'],
            ['clave'=>'D08','descripcion'=>'Transportación escolar'],
            ['clave'=>'D10','descripcion'=>'Pagos por servicios educativos'],
            ['clave'=>'S01','descripcion'=>'Sin efectos fiscales'],
            ['clave'=>'P01','descripcion'=>'Por definir']

        ]);

    }

}