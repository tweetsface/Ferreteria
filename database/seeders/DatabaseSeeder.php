<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    $this->call([
    UsuarioSeeder::class,
    SucursalesSeeder::class,
    UnidadesSeeder::class,
    UnidadesSatSeeder::class,
    ClavesProductosSatSeeder::class,
    FamiliasSeeder::class,
    CategoriaSeeder::class,
    ProductoSeeder::class,
    TipoPagoSeeder::class,
    ConfiguracionSeeder::class,
    ProveedoresSeeder::class,
    RegimenFiscalSeeder::class,
    UsoCfdiSeeder::class,
    UsoCfdiRegimenSeeder::class,
    ClientesSeeder::class,
    //ImportarProductosAccessSeeder::Class,
    //ImportarFamiliasSeeder::Class,

]);
    }
}
