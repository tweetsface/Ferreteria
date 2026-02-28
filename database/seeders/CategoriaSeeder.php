<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categorias')->insert([
            
            ['nombre' => 'Herramientas Manuales', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Herramientas Eléctricas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tornillería', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Plomería', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Electricidad', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pinturas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Material de Construcción', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cerraduras y Seguridad', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Adhesivos y Selladores', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jardinería', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Iluminación', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ferretería Industrial', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Accesorios para Baño', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Equipo de Seguridad', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Fijaciones y Anclajes', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],

        ]);
    }
}
