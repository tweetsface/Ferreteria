<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function porFamilia($id)
{
    return Categoria::where('id_familia',$id)
            ->orderBy('nombre')
            ->get();
}
}
