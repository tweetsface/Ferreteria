<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportarFamiliasSeeder extends Seeder
{
    public function run(): void
    {

        $familias = json_decode(
            file_get_contents(storage_path('app/familias.json')),
            true
        );

        foreach ($familias as $familia) {

            DB::table('familias')->insert([
                'nombre' => $familia['nombre'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

        }

    }
}