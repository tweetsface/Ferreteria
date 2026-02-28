<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [];

        $categorias = Categoria::pluck('id_categoria')->toArray();

        if (empty($categorias)) {
            $this->command->warn('⚠ No hay categorías registradas.');
            return;
        }

        $marcas = ['Truper', 'Pretul', 'Urrea', 'Coflex', 'Philips', 'Genérica'];
        $unidades = ['pieza', 'metro', 'kilo', 'caja'];

        $nombres = [
            "Martillo Profesional",
            "Taladro Industrial",
            "Desarmador Plano",
            "Desarmador Phillips",
            "Pinzas Electricista",
            "Llave Inglesa",
            "Sierra Manual",
            "Flexómetro 5m",
            "Cinta Aislante",
            "Extensión 10m",
            "Foco LED 12W",
            "Contacto Doble",
            "Interruptor Sencillo",
            "Cerradura Puerta",
            "Candado Seguridad",
            "Silicón Sellador",
            "Pegamento Industrial",
            "Broca Concreto",
            "Broca Metal",
            "Tornillo 2 pulgadas",
            "Taquete Plástico",
            "Ancla Metálica",
            "Pala Jardinera",
            "Rastrillo",
            "Manguera 15m",
            "Pintura Blanca 1L",
            "Rodillo Profesional",
            "Brocha 2 pulgadas",
            "Nivel Burbuja",
            "Esmeriladora",
            "Lijadora Orbital",
            "Multímetro Digital",
            "Caja Herramientas",
            "Escalera Aluminio",
            "Cinta Métrica 8m",
            "Bisagra Metálica",
            "Regadera Baño",
            "Llave Lavabo",
            "Tubo PVC 1/2",
            "Codo PVC",
            "Conector Eléctrico",
            "Cable THW",
            "Guantes Seguridad",
            "Lentes Protectores",
            "Casco Seguridad",
            "Compresor Aire",
            "Pulidora",
            "Taladro Inalámbrico",
            "Disco Corte",
            "Clavo 3 pulgadas"
        ];

        foreach ($nombres as $index => $nombre) {

            $precio = rand(50, 2500);
            $costo = $precio * rand(60, 85) / 100; // margen realista

            $stock = rand(10, 100);
            $stockMinimo = rand(3, 15);

            $productos[] = [
                'codigo' => 'PROD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nombre' => $nombre,
                'id_categoria' => $categorias[array_rand($categorias)],
                'costo' => round($costo, 2),
                'precio' => $precio,
                'stock' => $stock,
                'stock_minimo' => $stockMinimo,
                'unidad' => $unidades[array_rand($unidades)],
                'marca' => $marcas[array_rand($marcas)],
                'descripcion' => 'Producto de alta calidad para uso profesional.',
                'imagen' => null,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('productos')->insert($productos);

        $this->command->info('✅ Productos creados correctamente.');
    }
}