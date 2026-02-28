<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sucursales - Ferretería POS</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.fade-in {
animation: fadeIn .25s ease-in-out;
}
@keyframes fadeIn {
from {opacity:0; transform:translateY(6px);}
to {opacity:1; transform:translateY(0);}
}
</style>

</head>

<body class="bg-gray-50 text-gray-800 font-sans">

<!-- NAVBAR MÓVIL -->
<div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 flex items-center px-4 py-3 shadow-sm">
<button onclick="toggleSidebar()" class="text-2xl mr-4">&#9776;</button>
<h2 class="text-lg font-semibold">Ferretería POS</h2>
</div>

<div class="flex h-screen overflow-hidden relative">

<!-- SIDEBAR COMPLETO -->
<aside id="sidebar"
class="fixed lg:static w-64 bg-white border-r shadow-sm flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">

<div class="p-5 border-b">
<h1 class="text-lg font-bold text-gray-800">Ferretería POS</h1>
<p class="text-sm text-gray-500">Sucursal Centro</p>
</div>

<nav class="p-4 space-y-2 text-sm flex-1 overflow-y-auto">

<a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📊 Dashboard
</a>

<a href="/venta" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🏪 Venta
</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Gestión</p>

<a href="/productos" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📦 Productos
</a>

<a href="/clientes" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
👥 Clientes
</a>

<a href="/usuarios" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
👤 Usuarios
</a>

<a href="/sucursales" class="block px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
🏢 Sucursales
</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Caja</p>

<a href="/apertura-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🔓 Apertura de Caja
</a>

<a href="/cierre-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
💰 Cierre de Caja
</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Inventario</p>

<a href="/inventario" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📦 Inventario
</a>

<a href="/promociones" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🎯 Promociones
</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Otros</p>

<a href="/facturacion" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📄 Facturación
</a>

<a href="/tickets" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🖨️ Tickets
</a>

<a href="/reportes" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📊 Reportes
</a>

</nav>
</aside>

<!-- OVERLAY -->
<div id="overlay" onclick="closeSidebar()" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-40"></div>

<!-- CONTENIDO -->
<div class="flex-1 flex flex-col mt-[60px] lg:mt-0">

<!-- HEADER -->
<header class="bg-white border-b px-8 py-4 flex justify-between items-center shadow-sm">

<div>
<h2 class="text-xl font-bold text-gray-800">Gestión de Sucursales</h2>

<div class="flex items-center gap-4 mt-2 text-sm">
<div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl font-medium shadow-sm">
🖥 Caja 01
</div>

<div class="bg-green-50 text-green-700 px-4 py-2 rounded-xl font-medium shadow-sm">
👤 Miguel Espinoza
</div>
</div>
</div>

<button class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 font-semibold">
🚪 Salir
</button>

</header>

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

</body>
</html>