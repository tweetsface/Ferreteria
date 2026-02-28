<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
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
    $categorias = Categoria::all();

    return view('productos', compact('productos', 'categorias'));
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
        'costo'         => 'required|numeric|min:0',
        'precio_venta'  => 'required|numeric|min:0',
        'unidad'        => 'required|string|max:50',
        'marca'         => 'nullable|string|max:100',
        'descripcion'   => 'nullable|string',
        'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'activo'        => 'nullable|boolean',
    ]);

    // 🔥 Obtener IVA desde configuración
    $iva = DB::table('configuraciones')
                ->where('clave', 'iva')
                ->value('valor') ?? 16;

    $costo = $request->costo;
    $precioVenta = $request->precio_venta;

    // 🔹 Calcular precio sin IVA
    $precioBase = $precioVenta / (1 + ($iva / 100));

    // 🔹 Calcular utilidad real
    $utilidad = $precioBase - $costo;

    // 🔹 Calcular margen %
    $margen = $costo > 0 
        ? ($utilidad / $costo) * 100 
        : 0;

    $rutaImagen = null;

    if ($request->hasFile('imagen')) {
        $rutaImagen = $request->file('imagen')
                              ->store('productos', 'public');
    }

    Producto::create([
        'codigo'        => $request->codigo,
        'nombre'        => $request->nombre,
        'id_categoria'  => $request->id_categoria,
        'costo'         => $costo,
        'precio_base'   => round($precioBase, 2),
        'precio_venta'  => round($precioVenta, 2),
        'unidad'        => $request->unidad,
        'marca'         => $request->marca,
        'descripcion'   => $request->descripcion,
        'imagen'        => $rutaImagen,
        'activo'        => $request->activo ?? true,
    ]);

    return redirect()
        ->route('producto.index')
        ->with('success', 'Producto registrado correctamente.');
}
    /**
     * Mostrar formulario edición
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::where('estado', true)->get();

        return view('productos_edit', compact('producto', 'categorias'));
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