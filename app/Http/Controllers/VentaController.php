<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Caja;
use App\Models\Producto;
use App\Models\Categoria;

class VentaController extends Controller
{
    public function index()
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado', 'abierta')
            ->first();

        if (!$cajaAbierta) {
            return redirect('/apertura-caja');
        }

    $productos = Producto::where('activo', 1)
        ->select(
            'id_producto as id',   // 👈 alias correcto
            'codigo',
            'nombre',
            'id_categoria as categoria',
            'precio',
            'stock'
        )
        ->get();

        $categorias = Categoria::all();

        return view('ModuloPrincipal', compact('cajaAbierta','productos','categorias'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
