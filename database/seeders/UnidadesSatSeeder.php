<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadSat;

class UnidadesSatSeeder extends Seeder
{
    public function run()
    {

        $unidades = [

            ['clave'=>'H87','nombre'=>'Pieza','descripcion'=>'Unidad de pieza'],
            ['clave'=>'E48','nombre'=>'Unidad de servicio','descripcion'=>'Unidad de servicio'],
            ['clave'=>'ACT','nombre'=>'Actividad','descripcion'=>'Unidad de actividad'],
            ['clave'=>'KGM','nombre'=>'Kilogramo','descripcion'=>'Unidad de peso kilogramo'],
            ['clave'=>'GRM','nombre'=>'Gramo','descripcion'=>'Unidad de peso gramo'],
            ['clave'=>'LTR','nombre'=>'Litro','descripcion'=>'Unidad de volumen litro'],
            ['clave'=>'MTR','nombre'=>'Metro','descripcion'=>'Unidad de longitud metro'],
            ['clave'=>'MTK','nombre'=>'Metro cuadrado','descripcion'=>'Unidad de área'],
            ['clave'=>'MLT','nombre'=>'Mililitro','descripcion'=>'Unidad de volumen mililitro'],
            ['clave'=>'PR','nombre'=>'Par','descripcion'=>'Unidad por par'],
            ['clave'=>'SET','nombre'=>'Juego','descripcion'=>'Conjunto de piezas'],
            ['clave'=>'BOX','nombre'=>'Caja','descripcion'=>'Unidad en caja'],
            ['clave'=>'PK','nombre'=>'Paquete','descripcion'=>'Unidad en paquete'],
            ['clave'=>'DZN','nombre'=>'Docena','descripcion'=>'Unidad por docena'],
            ['clave'=>'DAY','nombre'=>'Día','descripcion'=>'Unidad por día'],
            ['clave'=>'HUR','nombre'=>'Hora','descripcion'=>'Unidad por hora']

        ];

        foreach($unidades as $unidad){
            UnidadSat::create($unidad);
        }

    }
}
