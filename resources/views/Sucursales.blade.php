
@extends('layouts.app')

@section('title', 'Sucursales')

@section('modulo')
Gestión de Sucursales
@endsection

@section('content')

<!-- CONTENIDO -->
<div class="flex-1 flex flex-col mt-[60px] lg:mt-0">

<!-- HEADER -->


<main class="flex-1 p-6 overflow-y-auto">

<!-- FILTROS -->
<div class="flex flex-wrap gap-4 items-center mb-6">

<input id="buscador"
type="text"
placeholder="Buscar sucursal..."
onkeyup="aplicarFiltros()"
class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-yellow-500 w-64">

<select id="filtroEstado"
onchange="aplicarFiltros()"
class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-yellow-500">

<option value="Todas">Todas</option>
<option value="Activa">Activas</option>
<option value="Inactiva">Inactivas</option>

</select>

<button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg font-semibold transition">
+ Nueva Sucursal
</button>

</div>

<!-- CARDS -->
<div id="contenedorSucursales"
class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
</div>

</main>
</div>
</div>

<script>

const sucursales = [
{nombre:"Sucursal Centro",direccion:"Av. Obregón 120",telefono:"(667) 123-4567",responsable:"Ana Gómez",estado:"Activa"},
{nombre:"Sucursal Norte",direccion:"Blvd. Lola Beltrán 450",telefono:"(667) 765-4321",responsable:"Carlos Méndez",estado:"Activa"},
{nombre:"Sucursal Sur",direccion:"Av. Patria 89",telefono:"(667) 998-8776",responsable:"Laura Pérez",estado:"Inactiva"},
{nombre:"Sucursal Este",direccion:"Av. Universitarios 340",telefono:"(667) 334-4556",responsable:"Miguel Espinoza",estado:"Activa"},
{nombre:"Sucursal Costa Rica",direccion:"Costa Rica",telefono:"(667) 777-9900",responsable:"José Ramírez",estado:"Inactiva"}
];

function renderSucursales(lista){
const contenedor=document.getElementById("contenedorSucursales");
contenedor.innerHTML="";

if(lista.length===0){
contenedor.innerHTML='<p class="col-span-full text-center text-gray-500 italic">No se encontraron sucursales</p>';
return;
}

lista.forEach(s=>{
contenedor.innerHTML+=`
<div class="bg-white rounded-xl shadow border border-gray-200 p-5 hover:shadow-lg hover:-translate-y-1 transition duration-300 fade-in">

<div class="flex justify-between items-center mb-2">
<h3 class="text-lg font-bold">${s.nombre}</h3>
<span class="text-xs font-semibold px-2 py-1 rounded ${
s.estado==="Activa"
? "bg-green-100 text-green-700"
: "bg-gray-200 text-gray-600"
}">
${s.estado}
</span>
</div>

<p class="text-sm text-gray-500 mb-4">${s.direccion}</p>

<div class="text-sm space-y-1 mb-4">
<div><strong>Teléfono:</strong> ${s.telefono}</div>
<div><strong>Responsable:</strong> ${s.responsable}</div>
</div>

<div class="flex justify-end gap-2">
<button class="px-3 py-1.5 text-sm rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition">
Editar
</button>
<button class="px-3 py-1.5 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
Eliminar
</button>
</div>

</div>
`;
});
}

function aplicarFiltros(){
const texto=document.getElementById("buscador").value.toLowerCase();
const estado=document.getElementById("filtroEstado").value;

let filtradas=sucursales.filter(s=>
(s.nombre.toLowerCase().includes(texto) ||
s.direccion.toLowerCase().includes(texto) ||
s.responsable.toLowerCase().includes(texto))
);

if(estado!=="Todas"){
filtradas=filtradas.filter(s=>s.estado===estado);
}

renderSucursales(filtradas);
}

renderSucursales(sucursales);

function toggleSidebar(){
document.getElementById("sidebar").classList.toggle("-translate-x-full");
document.getElementById("overlay").classList.toggle("hidden");
}

function closeSidebar(){
document.getElementById("sidebar").classList.add("-translate-x-full");
document.getElementById("overlay").classList.add("hidden");
}

</script>
@endsection