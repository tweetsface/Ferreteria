<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $clientes = Cliente::latest()->paginate(10);
    return view('clientes', compact('clientes'));
}

public function buscar(Request $request)
{
    $buscar = $request->buscar;

    $clientes = Cliente::leftJoin('regimenes_fiscales','clientes.regimen_fiscal','=','regimenes_fiscales.clave')
        ->leftJoin('usos_cfdi','clientes.uso_cfdi','=','usos_cfdi.clave')
        ->where('clientes.rfc','like',"%$buscar%")
        ->orWhere('clientes.nombre','like',"%$buscar%")
        ->limit(10)
        ->select(
            'clientes.*',
            'regimenes_fiscales.id_regimen',
            'usos_cfdi.id_uso_cfdi'
        )
        ->get();

    return response()->json($clientes);
}
    public function busqueda(Request $request)
{
    $buscar = $request->q;

    $clientes = Cliente::where('rfc','like',"%$buscar%")
        ->orWhere('razon_social','like',"%$buscar%")
        ->limit(10)
        ->get();

    return response()->json($clientes);
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
    $request->validate([

        'nombre' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'telefono' => 'nullable|digits:10',
        'email' => 'nullable|email',
        'direccion' => 'nullable|string|max:255',

        // Datos fiscales
        'tipo_persona' => 'required|in:fisica,moral',
        'rfc' => 'required|string|max:13',
        'razon_social' => 'required|string|max:255',
        'codigo_postal' => 'required|digits:5',
        'regimen_fiscal' => 'required|string',
        'uso_cfdi' => 'required|string',

    ]);

    Cliente::create([

        'nombre' => $request->nombre." ". $request->apellidos,
        'telefono' => $request->telefono,
        'email' => $request->email,
        'direccion' => $request->direccion,

        'tipo_persona' => $request->tipo_persona,
        'rfc' => strtoupper($request->rfc),
        'razon_social' => $request->razon_social,
        'codigo_postal' => $request->codigo_postal,
        'regimen_fiscal' => $request->regimen_fiscal,
        'uso_cfdi' => $request->uso_cfdi,

    ]);

    return redirect()->route('cliente.index')
                     ->with('success', 'Cliente registrado correctamente');
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
    $cliente = Cliente::findOrFail($id);

    $cliente->nombre = $request->nombre;
    $cliente->rfc = $request->rfc;
    $cliente->razon_social = $request->razon_social;
    $cliente->codigo_postal = $request->codigo_postal;
    $cliente->regimen_fiscal = $request->regimen_fiscal;
    $cliente->uso_cfdi = $request->uso_cfdi;

    $cliente->save();

    return redirect()
        ->route('cliente.index')
        ->with('success','Cliente actualizado correctamente');
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
