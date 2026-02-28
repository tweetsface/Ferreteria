<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Productos - Ferretería POS</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="w-64 bg-white border-r shadow-sm flex flex-col">
<div class="p-5 border-b">
<h1 class="text-lg font-bold text-gray-800">Ferretería POS</h1>
<p class="text-sm text-gray-500">Sucursal Centro</p>
</div>
<nav class="p-4 space-y-2 text-sm flex-1 overflow-y-auto">
<a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-gray-100">📊 Dashboard</a>
<a href="/venta" class="block px-4 py-2 rounded-lg hover:bg-gray-100">🏪 Venta</a>
<p class="px-4 py-2 text-gray-400 uppercase text-xs">Gestión</p>
<a href="/productos" class="block px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">📦 Productos</a>
</nav>
</aside>

<!-- CONTENIDO -->
<div class="flex-1 flex flex-col">

<header class="bg-white border-b px-8 py-4 shadow-sm">
<h2 class="text-xl font-bold text-gray-800">Gestión de Productos</h2>
</header>

<main class="flex-1 p-6 overflow-y-auto">

<!-- ================= FORMULARIO ================= -->
<form method="POST"
action="{{route('producto.store')}}"
enctype="multipart/form-data"
class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

@csrf

<div>
<label class="block mb-1 font-semibold">SKU / Código</label>
<input type="text" name="codigo" class="w-full border rounded px-4 py-2" required />
</div>

<div>
<label class="block mb-1 font-semibold">Nombre</label>
<input type="text" name="nombre" class="w-full border rounded px-4 py-2" required />
</div>

<div>
<label class="block mb-1 font-semibold">Categoría</label>
<select name="id_categoria" class="w-full border rounded px-4 py-2">
<option value="">Seleccione</option>
@foreach($categorias as $categoria)
<option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
@endforeach
</select>
</div>

<div>
<label class="block mb-1 font-semibold">Marca</label>
<input type="text" name="marca" class="w-full border rounded px-4 py-2" />
</div>

<div>
<label class="block mb-1 font-semibold">Costo</label>
<input type="number" step="0.01" name="costo" class="w-full border rounded px-4 py-2" />
</div>

<div>
<label class="block mb-1 font-semibold">
Precio de Venta
<span class="text-xs text-gray-400">(Incluye IVA)</span>
</label>
<input type="number"
step="0.01"
name="precio_venta"
class="w-full border rounded px-4 py-2"
required />
</div>

<div>
<label class="block mb-1 font-semibold">Unidad</label>
<select name="unidad" class="w-full border rounded px-4 py-2">
<option value="pieza">Pieza</option>
<option value="metro">Metro</option>
<option value="kilo">Kilo</option>
<option value="caja">Caja</option>
</select>
</div>

<div>
<label class="block mb-1 font-semibold">Estado</label>
<select name="activo" class="w-full border rounded px-4 py-2">
<option value="1">Activo</option>
<option value="0">Inactivo</option>
</select>
</div>

<div class="md:col-span-2">
<label class="block mb-1 font-semibold">Descripción</label>
<textarea name="descripcion" rows="3" class="w-full border rounded px-4 py-2"></textarea>
</div>

<div class="md:col-span-2">
<label class="block mb-1 font-semibold">Imagen del Producto</label>
<input type="file" name="imagen" accept="image/*"
class="w-full border border-gray-300 rounded px-4 py-2
file:bg-yellow-500 file:text-white file:rounded file:border-0
file:px-4 file:py-2 hover:file:bg-yellow-600 cursor-pointer">
</div>

<div class="md:col-span-2 flex justify-end">
<button type="submit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-semibold">
Agregar Producto
</button>
</div>

</form>

<!-- ================= FILTROS ================= -->
<section class="bg-white p-4 rounded-xl shadow border border-gray-200 mb-4">
<form id="formFiltros" method="GET" action="{{ route('producto.index') }}"
class="grid grid-cols-1 md:grid-cols-3 gap-4">

<input type="text"
name="buscar"
placeholder="Buscar por código o nombre..."
value="{{ request('buscar') }}"
class="border rounded px-3 py-2"
oninput="autoSubmit()">

<select name="categoria"
class="border rounded px-3 py-2"
onchange="autoSubmit()">
<option value="">Todas las categorías</option>
@foreach($categorias as $categoria)
<option value="{{ $categoria->id_categoria }}"
{{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
{{ $categoria->nombre }}
</option>
@endforeach
</select>

<select name="estado"
class="border rounded px-3 py-2"
onchange="autoSubmit()">
<option value="">Todos</option>
<option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
<option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
</select>

</form>
</section>

<!-- ================= TABLA ================= -->
<section class="bg-white p-6 rounded-xl shadow border border-gray-200">
<div class="overflow-auto border rounded">
<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-2 text-center">Imagen</th>
<th class="p-2">SKU</th>
<th class="p-2">Nombre</th>
<th class="p-2">Categoría</th>
<th class="p-2">Precio</th>
<th class="p-2">Unidad</th>
<th class="p-2">Estado</th>
<th class="p-2">Acciones</th>
</tr>
</thead>

<tbody>
@foreach($productos as $producto)
<tr class="border-t hover:bg-gray-50">

<td class="p-2 text-center relative group">
@if($producto->imagen)
<img src="{{ asset('storage/'.$producto->imagen) }}"
class="h-12 w-12 object-cover rounded border mx-auto cursor-pointer">

<div class="absolute hidden group-hover:block z-50 top-0 left-16">
<img src="{{ asset('storage/'.$producto->imagen) }}"
class="w-48 h-48 object-cover rounded-xl shadow-2xl border bg-white p-1">
</div>
@else
—
@endif
</td>

<td class="p-2">{{ $producto->codigo }}</td>
<td class="p-2">{{ $producto->nombre }}</td>
<td class="p-2">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
<td class="p-2">${{ number_format($producto->precio_venta,2) }}</td>
<td class="p-2">{{ $producto->unidad }}</td>
<td class="p-2 text-center">
@if($producto->activo)
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Activo</span>
@else
<span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">Inactivo</span>
@endif
</td>
<td class="p-2 text-center">
<button type="button"
onclick="abrirModalEditar(
'{{ $producto->id_producto }}',
'{{ $producto->codigo }}',
'{{ $producto->nombre }}',
'{{ $producto->id_categoria }}',
'{{ $producto->marca }}',
'{{ $producto->costo }}',
'{{ $producto->precio_venta }}',
'{{ $producto->unidad }}',
`{{ $producto->descripcion }}`,
'{{ $producto->activo }}'
)"
class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">
Editar
</button>
</td>

</tr>
@endforeach
</tbody>

</table>
</div>
</section>

</main>
</div>
</div>

<!-- ================= MODAL EDITAR ================= -->
<div id="modalEditar"
class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

<div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6">

<h3 class="text-lg font-bold mb-4">Editar Producto</h3>

<form id="formEditar" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<div>
<label class="text-sm font-semibold">Código</label>
<input type="text" id="edit_codigo"
class="w-full border rounded px-3 py-2 bg-gray-100"
readonly>
</div>

<div>
<label class="text-sm font-semibold">Nombre</label>
<input type="text" name="nombre" id="edit_nombre"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm font-semibold">Categoría</label>
<select name="id_categoria" id="edit_categoria"
class="w-full border rounded px-3 py-2">
@foreach($categorias as $categoria)
<option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
@endforeach
</select>
</div>

<div>
<label class="text-sm font-semibold">Marca</label>
<input type="text" name="marca" id="edit_marca"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm font-semibold">Costo</label>
<input type="number" step="0.01" name="costo" id="edit_costo"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm font-semibold">Precio</label>
<input type="number" step="0.01" name="precio_venta" id="edit_precio_venta"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm font-semibold">Unidad</label>
<select name="unidad" id="edit_unidad"
class="w-full border rounded px-3 py-2">
<option value="pieza">Pieza</option>
<option value="metro">Metro</option>
<option value="kilo">Kilo</option>
<option value="caja">Caja</option>
</select>
</div>

<div>
<label class="text-sm font-semibold">Estado</label>
<select name="activo" id="edit_activo"
class="w-full border rounded px-3 py-2">
<option value="1">Activo</option>
<option value="0">Inactivo</option>
</select>
</div>

<div class="md:col-span-2">
<label class="text-sm font-semibold">Descripción</label>
<textarea name="descripcion" id="edit_descripcion"
class="w-full border rounded px-3 py-2"></textarea>
</div>

<div class="md:col-span-2">
<label class="text-sm font-semibold">Actualizar Imagen</label>
<input type="file" name="imagen" accept="image/*"
class="w-full border border-gray-300 rounded px-3 py-2">
</div>

</div>

<div class="flex justify-end gap-3 mt-6">
<button type="button" onclick="cerrarModal()"
class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
<button type="submit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
Actualizar
</button>
</div>

</form>
</div>
</div>

<script>
let filtroTimer;
function autoSubmit(){
clearTimeout(filtroTimer);
filtroTimer=setTimeout(()=>{
document.getElementById('formFiltros').submit();
},400);
}

function abrirModalEditar(id,codigo,nombre,categoria,marca,costo,precio,unidad,descripcion,activo){
const modal=document.getElementById('modalEditar');
modal.classList.remove('hidden');
modal.classList.add('flex');

document.getElementById('edit_codigo').value=codigo;
document.getElementById('edit_nombre').value=nombre;
document.getElementById('edit_categoria').value=categoria;
document.getElementById('edit_marca').value=marca;
document.getElementById('edit_costo').value=costo;
document.getElementById('edit_precio_venta').value=precio;
document.getElementById('edit_unidad').value=unidad;
document.getElementById('edit_descripcion').value=descripcion;
document.getElementById('edit_activo').value=activo;

document.getElementById('formEditar').action=
"{{ route('producto.update', ':id') }}".replace(':id',id);
}

function cerrarModal(){
const modal=document.getElementById('modalEditar');
modal.classList.add('hidden');
modal.classList.remove('flex');
}
</script>

</body>
</html>