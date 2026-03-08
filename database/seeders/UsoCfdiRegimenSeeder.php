<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsoCfdiRegimenSeeder extends Seeder
{

    public function run()
    {

        $regimen605 = DB::table('regimenes_fiscales')
            ->where('clave','605')
            ->value('id_regimen');

        $regimen601 = DB::table('regimenes_fiscales')
            ->where('clave','601')
            ->value('id_regimen');

        $regimen612 = DB::table('regimenes_fiscales')
            ->where('clave','612')
            ->value('id_regimen');


        $usos = DB::table('usos_cfdi')->pluck('id_uso_cfdi','clave');


        $data = [

            // REGIMEN 605
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['S01']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D01']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D02']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D03']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D04']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D07']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D08']],
            ['id_regimen'=>$regimen605,'id_uso_cfdi'=>$usos['D10']],


            // REGIMEN 601
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['G03']],
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['I01']],
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['I02']],
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['I03']],
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['I04']],
            ['id_regimen'=>$regimen601,'id_uso_cfdi'=>$usos['P01']],


            // REGIMEN 612
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['G03']],
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['I01']],
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['I02']],
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['I03']],
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['I04']],
            ['id_regimen'=>$regimen612,'id_uso_cfdi'=>$usos['P01']]

        ];


        DB::table('uso_cfdi_regimen')->insert($data);

    }

}
