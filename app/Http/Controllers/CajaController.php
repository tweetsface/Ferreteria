<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function apertura()
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado', 'abierta')
            ->first();

        if ($cajaAbierta) {
            return redirect('/');
        }

        return view('AperturaCaja');
    }

    public function guardarApertura(Request $request)
    {
        $request->validate([
            'monto_inicial' => 'required|numeric|min:0'
        ]);

        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado', '1')
            ->first();

        if ($cajaAbierta) {
            return redirect('/');
        }

        Caja::create([
            'id_usuario' => auth()->id(),
            'id_sucursal' => auth()->user()->id_sucursal,
            'monto_inicial' => $request->monto_inicial,
            'estado' => 'abierta',
            'fecha_apertura' => now()
        ]);

        return redirect('/');
    }
}
