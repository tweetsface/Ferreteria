<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $archivo = storage_path('app/productos.csv');

$productos = array_map('str_getcsv', file($archivo));
$header = array_shift($productos);

        foreach ($productos as $fila) {

            $producto = array_combine($header, $fila);

            DB::table('productos')->insert([

                'codigo' => $producto['codigo'],
                'nombre' => $producto['nombre'],

                'id_familia' => null,
                'id_categoria' => null,

                'costo' => $producto['costo'],
                'precio_base' => $producto['precio_base'],
                'precio_venta' => $producto['precio_venta'],

                'id_unidad' => 1,

                'id_clave_sat' => 1,
                'id_unidad_sat' => 1,

                'objeto_impuesto' => '02',

                'marca' => $producto['marca'],
                'descripcion' => $producto['descripcion'],
                'imagen' => null,

                'activo' => 1,

                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }


}