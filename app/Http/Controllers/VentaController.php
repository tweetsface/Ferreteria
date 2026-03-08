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

    $productos = Producto::leftJoin('unidades', 'productos.id_unidad', '=', 'unidades.id_unidad')
        ->where('productos.activo', 1)
        ->select(
            'productos.id_producto as id',
            'productos.codigo',
            'productos.nombre',
            'productos.id_categoria as categoria',
            'productos.precio_venta as precio',
            'productos.imagen',
            'productos.precio_base',
            'unidades.abreviatura as unidad'   // 👈 aquí traemos la abreviatura
        )
        ->get();

    $tiposPago = TipoPago::where('activo',1)->get();
    $categorias = Categoria::all();
    $porcentajeIVA = Configuracion::where('clave', 'iva')->value('valor');

    return view('ModuloPrincipal', compact(
        'cajaAbierta',
        'productos',
        'categorias',
        'tiposPago',
        'porcentajeIVA'
    ));
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

        /*
        |--------------------------------------------------------------------------
        | 1️⃣ VALIDAR CAJA ABIERTA
        |--------------------------------------------------------------------------
        */

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

        $ids = collect($request->productos)->pluck('id');

        $idSucursal = auth()->user()->id_sucursal;

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ TRAER PRODUCTOS + STOCK + CATÁLOGOS SAT
        |--------------------------------------------------------------------------
        */

        $productos = DB::table('producto_sucursal')

            ->join('productos', 'producto_sucursal.id_producto', '=', 'productos.id_producto')

            ->leftJoin('claves_productos_sat', 'productos.id_clave_sat', '=', 'claves_productos_sat.id_clave_sat')

            ->leftJoin('unidades_sat', 'productos.id_unidad_sat', '=', 'unidades_sat.id_unidad_sat')

            ->whereIn('productos.id_producto', $ids)

            ->where('producto_sucursal.id_sucursal', $idSucursal)

            ->select(

                'productos.id_producto',
                'productos.nombre',
                'productos.objeto_impuesto',
                'productos.precio_base',
                'productos.precio_venta',

                'claves_productos_sat.clave as clave_sat',

                'unidades_sat.clave as clave_unidad_sat',
                'unidades_sat.nombre as unidad_sat',

                'producto_sucursal.existencia as stock'

            )
            ->get()
            ->keyBy('id_producto');

        $subtotalVenta = 0;
        $ivaVenta = 0;
        $totalVenta = 0;

        $porcentajeIva = Configuracion::where('clave', 'iva')->value('valor') ?? 16;
        $tasaIva = round($porcentajeIva / 100,2);

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ VALIDAR STOCK Y CALCULAR TOTALES
        |--------------------------------------------------------------------------
        */

        foreach ($request->productos as $item) {

            $producto = $productos[$item['id']];

            if ($producto->stock < $item['cantidad']) {
                return response()->json([
                    'error' => 'Stock insuficiente para ' . $producto->nombre
                ], 422);
            }

            $precio = $producto->precio_base;
            $precioVenta = $producto->precio_venta;
            $cantidad = $item['cantidad'];

            $subtotalProducto = round($precio * $cantidad, 2);
            $totalProducto = round($precioVenta * $cantidad, 2);
            $ivaProducto = round($totalProducto - $subtotalProducto, 2);

            $subtotalVenta += $subtotalProducto;
            $ivaVenta += $ivaProducto;
            $totalVenta += $totalProducto;
        }

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ CREAR VENTA
        |--------------------------------------------------------------------------
        */

        $venta = Venta::create([
            'id_usuario' => auth()->user()->id_usuario,
            'id_caja' => $cajaAbierta->id_caja,
            'subtotal' => $subtotalVenta,
            'iva' => $ivaVenta,
            'total' => $totalVenta,
            'id_tipo_pago' => $request->id_tipo_pago
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5️⃣ GENERAR FOLIO
        |--------------------------------------------------------------------------
        */

        $folio = 'V-' . str_pad($venta->id_venta, 6, '0', STR_PAD_LEFT);

        $venta->update([
            'folio' => $folio
        ]);

        /*
        |--------------------------------------------------------------------------
        | 6️⃣ CREAR DETALLES + DATOS SAT
        |--------------------------------------------------------------------------
        */

        foreach ($request->productos as $item) {

            $producto = $productos[$item['id']];

            $precio = $producto->precio_base;
            $cantidad = $item['cantidad'];
            DetalleVenta::create([

                'id_venta' => $venta->id_venta,
                'id_producto' => $producto->id_producto,

                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'subtotal' => $subtotalProducto,
                'iva' => $ivaProducto,
                'total' => $totalProducto,

                // 🔹 DATOS SAT
                'clave_sat' => $producto->clave_sat,
                'clave_unidad_sat' => $producto->clave_unidad_sat,
                'unidad_sat' => $producto->unidad_sat,
                'descripcion' => $producto->nombre,
                'objeto_impuesto' => $producto->objeto_impuesto ?? '02'

            ]);

            /*
            |--------------------------------------------------------------------------
            | DESCONTAR INVENTARIO
            |--------------------------------------------------------------------------
            */

            DB::table('producto_sucursal')
                ->where('id_producto', $producto->id_producto)
                ->where('id_sucursal', $idSucursal)
                ->decrement('existencia', $cantidad);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'folio' => $folio,
            'total' => $totalVenta
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'error' => 'Error al procesar la venta',
            'detalle' => $e->getMessage()
        ], 500);
    }
}
}