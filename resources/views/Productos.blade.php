@extends('layouts.app')

@section('title', 'Productos')

@section('modulo')
Gestión de Productos
@endsection

@section('content')

<main class="flex-1 p-6 overflow-y-auto">

<!-- ================= FORMULARIO ================= -->

<form method="POST"
action="{{route('producto.store')}}"
enctype="multipart/form-data"
class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

@csrf

<div>
<label class="block mb-1 font-semibold">SKU / Código</label>
<input type="text" id="codigo" name="codigo" class="w-full border rounded px-4 py-2" required />
</div>

<div>
<label class="block mb-1 font-semibold">Nombre</label>
<input type="text" name="nombre" class="w-full border rounded px-4 py-2" required />
</div>

<!-- FAMILIA -->

<div>
<label class="block mb-1 font-semibold">Familia</label>

<select id="familia" name="id_familia" class="w-full border rounded px-4 py-2">

<option value="">Seleccione</option>

@foreach($familias as $familia)

<option value="{{ $familia->id_familia }}">
{{ $familia->nombre }}
</option>

@endforeach

</select>

</div>

<!-- CATEGORIA -->

<div>
<label class="block mb-1 font-semibold">Categoría</label>

<select id="categoria" name="id_categoria" class="w-full border rounded px-4 py-2">

<option value="">Seleccione una familia</option>

</select>

</div>

<!-- PROVEEDOR -->

<div>
<label class="block mb-1 font-semibold">Proveedor</label>

<select name="id_proveedor" class="w-full border rounded px-4 py-2">

<option value="">Seleccione proveedor</option>

@foreach($proveedores as $proveedor)

<option value="{{ $proveedor->id_proveedor }}">
{{ $proveedor->nombre }}
</option>

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

<!-- UNIDAD VENTA -->

<div>

<label class="block mb-1 font-semibold">Unidad de venta</label>

<select name="id_unidad" class="w-full border rounded px-4 py-2">

<option value="">Seleccione</option>

@foreach($unidadesVenta as $unidad)

<option value="{{ $unidad->id_unidad }}">

{{ $unidad->nombre }} ({{ $unidad->abreviatura }})

</option>

@endforeach

</select>

</div>

<!-- UNIDAD SAT -->

<div>

<label class="block mb-1 font-semibold">Unidad SAT</label>

<select name="id_unidad_sat" class="w-full border rounded px-4 py-2">

@foreach($unidades as $unidad)

<option value="{{ $unidad->id_unidad_sat }}">

{{ $unidad->clave }} - {{ $unidad->nombre }}

</option>

@endforeach

</select>

</div>

<!-- CLAVE SAT -->

<div>

<label class="block mb-1 font-semibold">Clave SAT</label>

<select name="id_clave_sat" class="w-full border rounded px-4 py-2">

@foreach($clavesSat as $clave)

<option value="{{ $clave->id_clave_sat }}">

{{ $clave->clave }} - {{ $clave->descripcion }}

</option>

@endforeach

</select>

</div>

<div>

<label class="block mb-1 font-semibold">Objeto Impuesto</label>

<select name="objeto_impuesto" class="w-full border rounded px-4 py-2">

<option value="02">02 - Sí objeto de impuesto</option>
<option value="01">01 - No objeto de impuesto</option>
<option value="03">03 - Exento</option>

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

<textarea name="descripcion"
rows="3"
class="w-full border rounded px-4 py-2"></textarea>

</div>

<div class="md:col-span-2">

<label class="block mb-1 font-semibold">Imagen del Producto</label>

<input type="file"
name="imagen"
accept="image/*"
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

<form id="formFiltros"
method="GET"
action="{{ route('producto.index') }}"
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

<option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>
Activos
</option>

<option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>
Inactivos
</option>

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

<td class="p-2 text-center">

@if($producto->imagen)

<img src="{{ asset('storage/'.$producto->imagen) }}"
class="h-12 w-12 object-cover rounded border mx-auto">

@else
—
@endif

</td>

<td class="p-2">{{ $producto->codigo }}</td>

<td class="p-2">{{ $producto->nombre }}</td>

<td class="p-2">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>

<td class="p-2">${{ number_format($producto->precio_venta,2) }}</td>

<td class="p-2">{{ $producto->unidad->nombre ?? '-' }}</td>

<td class="p-2 text-center">

@if($producto->activo)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
Activo
</span>

@else

<span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">
Inactivo
</span>

@endif

</td>

<td class="p-2 text-center">

<button type="button"
class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">

Editar

</button>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-4">

{{ $productos->links() }}

</div>

</section>

</main>

<script>

let filtroTimer;

function autoSubmit(){

clearTimeout(filtroTimer);

filtroTimer=setTimeout(()=>{

document.getElementById('formFiltros').submit();

},400);

}

document.addEventListener("DOMContentLoaded",function(){

const familia=document.getElementById("familia");

const categoria=document.getElementById("categoria");

familia.addEventListener("change",function(){

let id=this.value;

if(!id){

categoria.innerHTML="<option>Seleccione una familia</option>";

return;

}

categoria.innerHTML="<option>Cargando...</option>";

fetch("/api/categorias/"+id)

.then(res=>res.json())

.then(data=>{

categoria.innerHTML="<option value=''>Seleccione</option>";

data.forEach(cat=>{

let option=document.createElement("option");

option.value=cat.id_categoria;

option.textContent=cat.nombre;

categoria.appendChild(option);

});

});

});

setTimeout(()=>{

const sku=document.getElementById("codigo");

if(sku){

sku.focus();

sku.select();

}

},100);

});

</script>

@endsection