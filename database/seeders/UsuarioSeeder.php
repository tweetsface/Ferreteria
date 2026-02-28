<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre_usuario' => 'miguel',
            'nombre_completo' => 'Miguel Espinoza',
            'email' => 'miguel@gmail.com',
            'password' => Hash::make('maesmaes'),
            'id_sucursal' => 1,
            'activo' => 1,
        ]);
    }
}