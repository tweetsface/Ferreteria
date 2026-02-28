<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Caja;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\TipoPago;
use App\Models\Configuracion;

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
                'id_producto as id',
                'codigo',
                'nombre',
                'id_categoria as categoria',
                'precio_venta as precio',
                'stock',
                'imagen',
        
                'precio_base',
            )
            ->get();

        $tiposPago = TipoPago::where('activo',1)->get();
        $categorias = Categoria::all();
        $porcentajeIVA = Configuracion::where('clave', 'iva') ->value('valor');

        

        return view('ModuloPrincipal', compact('cajaAbierta','productos','categorias',
        'tiposPago','porcentajeIVA'));
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 GUARDAR VENTA REAL
    |--------------------------------------------------------------------------
    */

    public function guardar(Request $request)
    {
        DB::beginTransaction();

        try {

            $cajaAbierta = Caja::where('id_usuario', auth()->id())
                ->where('estado', 'abierta')
                ->first();

            if (!$cajaAbierta) {
                return response()->json([
                    'error' => 'No hay caja abierta'
                ], 422);
            }

            if (empty($request->productos)) {
                return response()->json([
                    'error' => 'El carrito está vacío'
                ], 422);
            }

            $subtotal = 0;

            /*
            |--------------------------------------------------------------------------
            | 1️⃣ VALIDAR STOCK
            |--------------------------------------------------------------------------
            */

            foreach ($request->productos as $item) {

                $producto = Producto::where('id_producto', $item['id'])->firstOrFail();

                if ($producto->stock < $item['cantidad']) {
                    return response()->json([
                        'error' => 'Stock insuficiente para '.$producto->nombre
                    ], 422);
                }

                $subtotal += $producto->precio_base * $item['cantidad'];
            }

            $porcentajeIva = Configuracion::where('clave', 'iva') ->value('valor');
            if(!$porcentajeIva){
                $porcentajeIva = 16; // fallback de seguridad
            }
            $iva = $subtotal * ($porcentajeIva / 100);
            $total = $subtotal + $iva;
            /*
            |--------------------------------------------------------------------------
            | 2️⃣ CREAR VENTA
            |--------------------------------------------------------------------------
            */

            $venta = Venta::create([
                'id_usuario'  => auth()->user()->id_usuario,
                'id_caja'     => $cajaAbierta->id_caja,
                'subtotal'    => $subtotal,
                'iva'         => $iva,
                'total'       => $total,
                'id_tipo_pago' => $request->id_tipo_pago
            ]);

            /*
            |--------------------------------------------------------------------------
            | 3️⃣ CREAR DETALLES + DESCONTAR STOCK
            |--------------------------------------------------------------------------
            */

            foreach ($request->productos as $item) {

                $producto = Producto::where('id_producto', $item['id'])->firstOrFail();

                DetalleVenta::create([
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $producto->id_producto,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal'        => $producto->precio_base * $item['cantidad'],
                    'iva' =>  $porcentajeIva,
                ]);

                // 🔥 Descontar inventario
                $producto->decrement('stock', $item['cantidad']);
            }

            DB::commit();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Error al procesar la venta',
                'detalle' => $e->getMessage() // quitar en producción
            ], 500);
        }
    }
}