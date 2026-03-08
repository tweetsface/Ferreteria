<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportarProductosAccessSeeder extends Seeder
{
    public function run(): void
    {

        $archivo = storage_path('app\productos_importados.json');
        $productos = json_decode(file_get_contents($archivo), true);

        foreach ($productos as $producto) {

            DB::table('productos')->insert([

                'codigo' => $producto['CodigoDeBarras'] ?? Str::uuid(),

                'nombre' => $producto['Nombre'] ?? 'SIN NOMBRE',

                'descripcion' => $producto['Descripcion'] ?? null,

                'marca' => $producto['Marca'] ?? null,

                'costo' => $producto['Costo'] ?? 0,

                'precio_base' => $producto['Precio1'] ?? 0,

                'precio_venta' => $producto['Precio1'] ?? 0,

                'id_categoria' => null,
                'id_familia' => null,

                'id_unidad' => null,

                'id_clave_sat' => null,
                'id_unidad_sat' => null,

                'objeto_impuesto' => '02',

                'activo' => true,

                'created_at' => now(),
                'updated_at' => now()

            ]);
        }
    }
}