<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClaveProductoSat;

class ClavesProductosSatSeeder extends Seeder
{
    public function run()
    {

        $claves = [

            ['clave'=>'01010101','descripcion'=>'No existe en el catálogo'],

            ['clave'=>'27111701','descripcion'=>'Martillos'],
            ['clave'=>'27111702','descripcion'=>'Desarmadores'],
            ['clave'=>'27111703','descripcion'=>'Llaves inglesas'],
            ['clave'=>'27111704','descripcion'=>'Pinzas'],
            ['clave'=>'27111705','descripcion'=>'Alicates'],
            ['clave'=>'27111706','descripcion'=>'Cinceles'],

            ['clave'=>'27112701','descripcion'=>'Taladros'],
            ['clave'=>'27112702','descripcion'=>'Sierras eléctricas'],
            ['clave'=>'27112703','descripcion'=>'Herramientas eléctricas'],
            ['clave'=>'27112704','descripcion'=>'Esmeriles'],
            ['clave'=>'27112705','descripcion'=>'Lijadoras'],

            ['clave'=>'31161500','descripcion'=>'Tuercas'],
            ['clave'=>'31161600','descripcion'=>'Tornillos'],
            ['clave'=>'31161601','descripcion'=>'Tornillos para madera'],
            ['clave'=>'31161602','descripcion'=>'Tornillos para metal'],
            ['clave'=>'31161603','descripcion'=>'Tornillos de máquina'],

            ['clave'=>'31161700','descripcion'=>'Pernos'],
            ['clave'=>'31161800','descripcion'=>'Arandelas'],

            ['clave'=>'30111601','descripcion'=>'Cemento'],
            ['clave'=>'30111602','descripcion'=>'Yeso'],
            ['clave'=>'30111500','descripcion'=>'Arena'],
            ['clave'=>'30111603','descripcion'=>'Cal'],

            ['clave'=>'40141700','descripcion'=>'Tuberías'],
            ['clave'=>'40141701','descripcion'=>'Tubería PVC'],
            ['clave'=>'40141702','descripcion'=>'Tubería metálica'],
            ['clave'=>'40141703','descripcion'=>'Tubería hidráulica'],

            ['clave'=>'46171505','descripcion'=>'Candados'],
            ['clave'=>'46171506','descripcion'=>'Cerraduras'],
            ['clave'=>'46171507','descripcion'=>'Llaves'],

            ['clave'=>'30152000','descripcion'=>'Pinturas'],
            ['clave'=>'31211900','descripcion'=>'Brochas'],
            ['clave'=>'31211901','descripcion'=>'Rodillos para pintura'],

            ['clave'=>'27112100','descripcion'=>'Carretillas'],
            ['clave'=>'27112000','descripcion'=>'Palas'],
            ['clave'=>'27112200','descripcion'=>'Picos'],

            ['clave'=>'46181800','descripcion'=>'Guantes de seguridad'],
            ['clave'=>'46182000','descripcion'=>'Cascos de seguridad'],
            ['clave'=>'46182100','descripcion'=>'Lentes de seguridad']

        ];

        foreach($claves as $clave){

            ClaveProductoSat::create($clave);

        }

    }
}
