<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\UnidadSat;
use App\Models\ClaveProductoSat;
use App\Models\Familia;
use App\Models\Proveedor;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductoController extends Controller
{
    /**
     * Mostrar listado
     */
   public function index(Request $request)
{

$query = Producto::with('categoria');

if ($request->buscar) {
    $query->where(function ($q) use ($request) {
        $q->where('codigo', 'like', "%{$request->buscar}%")
          ->orWhere('nombre', 'like', "%{$request->buscar}%");
    });
}

if ($request->categoria) {
    $query->where('id_categoria', $request->categoria);
}

if ($request->estado !== null && $request->estado !== '') {
    $query->where('activo', $request->estado);
}

$productos = $query->paginate(10)->withQueryString();

$unidades = UnidadSat::orderBy('nombre')->get();

$clavesSat = ClaveProductoSat::orderBy('descripcion')->get();

$categorias = Categoria::orderBy('nombre')->get();

$familias = Familia::orderBy('nombre')->get();

$proveedores = Proveedor::orderBy('nombre')->get();

$unidadesVenta = Unidad::orderBy('nombre')->get();

return view('productos', compact(
'productos',
'categorias',
'unidades',
'clavesSat',
'familias',
'proveedores',
'unidadesVenta'));

}
    /**
     * Guardar nuevo producto
     */
public function store(Request $request)
{
    $request->validate([
        'codigo'        => 'required|unique:productos,codigo',
        'nombre'        => 'required|string|max:255',
        'id_categoria'  => 'nullable|exists:categorias,id_categoria',
        'id_familia'    => 'nullable|exists:familias,id_familia',

        'id_clave_sat'  => 'required|exists:claves_productos_sat,id_clave_sat',
        'id_unidad_sat' => 'required|exists:unidades_sat,id_unidad_sat',

        'costo'         => 'required|numeric|min:0',
        'precio_venta'  => 'required|numeric|min:0',

        'marca'         => 'nullable|string|max:100',
        'descripcion'   => 'nullable|string',
        'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'activo'        => 'nullable|boolean',
        'id_proveedor'  => 'nullable|exists:proveedores,id_proveedor'
    ]);

    // 🔥 Obtener IVA desde configuración
    $iva = DB::table('configuraciones')
                ->where('clave', 'iva')
                ->value('valor') ?? 16;

    // 🔹 Redondear valores capturados
    $costo = round($request->costo, 2);
    $precioVenta = round($request->precio_venta, 2);

    // 🔹 Calcular precio sin IVA correctamente
    $precioBase = round($precioVenta / (1 + ($iva / 100)), 2);

    $rutaImagen = null;

    if ($request->hasFile('imagen')) {
        $rutaImagen = $request->file('imagen')
                              ->store('productos', 'public');
    }

    // 🔹 Crear producto
    $producto = Producto::create([
        'codigo'        => $request->codigo,
        'nombre'        => $request->nombre,
        'id_categoria'  => $request->id_categoria,
        'id_familia'    => $request->id_familia,

        'costo'         => $costo,
        'precio_base'   => $precioBase,
        'precio_venta'  => $precioVenta,

        'id_unidad'     => $request->id_unidad,

        // SAT
        'id_clave_sat'  => $request->id_clave_sat,
        'id_unidad_sat' => $request->id_unidad_sat,
        'objeto_impuesto' => $request->objeto_impuesto ?? '02',

        'marca'         => $request->marca,
        'descripcion'   => $request->descripcion,
        'imagen'        => $rutaImagen,
        'activo'        => $request->activo ?? true,
    ]);

    // 🔹 Obtener sucursal del usuario logueado
    $idSucursal = auth()->user()->id_sucursal;

    // 🔹 Crear inventario inicial para esa sucursal
    DB::table('producto_sucursal')->insert([
        'id_producto'  => $producto->id_producto,
        'id_sucursal'  => $idSucursal,
        'existencia'   => 0,
        'stock_minimo' => 5,
        'stock_maximo' => 100,
        'created_at'   => now(),
        'updated_at'   => now(),
    ]);

    return redirect()
        ->route('producto.index')
        ->with('success', 'Producto registrado correctamente.');
}


public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $request->validate([
        'nombre'        => 'nullable|string|max:255',
        'id_categoria'  => 'nullable|exists:categorias,id_categoria',
        'costo'         => 'nullable|numeric|min:0',
        'precio_venta'  => 'nullable|numeric|min:0',
        'unidad'        => 'nullable|string|max:50',
        'marca'         => 'nullable|string|max:100',
        'descripcion'   => 'nullable|string',
        'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'activo'        => 'nullable|boolean',
    ]);

    // 🔥 Obtener IVA desde BD
    $iva = DB::table('configuraciones')
                ->where('clave', 'iva')
                ->value('valor') ?? 16;

    // 🔹 Preparar arreglo de actualización
    $data = [
        'nombre'        => $request->nombre ?? $producto->nombre,
        'id_categoria'  => $request->id_categoria ?? $producto->id_categoria,
        'costo'         => $request->costo ?? $producto->costo,
        'unidad'        => $request->unidad ?? $producto->unidad,
        'marca'         => $request->marca ?? $producto->marca,
        'descripcion'   => $request->descripcion ?? $producto->descripcion,
        'activo'        => $request->activo ?? $producto->activo,
    ];

    // 🔹 Si cambian precio venta → recalcular base
    if ($request->filled('precio_venta')) {

        $precioVenta = $request->precio_venta;
        $precioBase  = $precioVenta / (1 + ($iva / 100));

        $data['precio_venta'] = round($precioVenta, 2);
        $data['precio_base']  = round($precioBase, 2);
    }

    // 🔹 Imagen nueva
    if ($request->hasFile('imagen')) {

        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $data['imagen'] = $request->file('imagen')->store('productos', 'public');
    }

    // 🔥 Actualizar todo junto
    $producto->update($data);

    return redirect()
        ->route('producto.index')
        ->with('success', 'Producto actualizado correctamente.');
}
    /**
     * Eliminar producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar imagen física
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()
            ->route('producto.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}