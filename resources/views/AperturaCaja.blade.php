<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Apertura de Caja - Ferretería POS</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

<div class="flex h-screen overflow-hidden relative">

<!-- SIDEBAR -->
<aside id="sidebar"
class="fixed lg:static w-64 bg-white border-r shadow-sm flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">

<div class="p-5 border-b">
<h1 class="text-lg font-bold text-gray-800">Ferretería POS</h1>
<p class="text-sm text-gray-500">
Sucursal {{ auth()->user()->id_sucursal }}
</p>
</div>

<nav class="p-4 space-y-2 text-sm flex-1 overflow-y-auto">

<a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-gray-100">📊 Dashboard</a>
<a href="/venta" class="block px-4 py-2 rounded-lg hover:bg-gray-100">🏪 Venta</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Gestión</p>

<a href="/productos" class="block px-4 py-2 rounded-lg hover:bg-gray-100">📦 Productos</a>
<a href="/clientes" class="block px-4 py-2 rounded-lg hover:bg-gray-100">👥 Clientes</a>
<a href="/usuarios" class="block px-4 py-2 rounded-lg hover:bg-gray-100">👤 Usuarios</a>
<a href="/sucursales" class="block px-4 py-2 rounded-lg hover:bg-gray-100">🏢 Sucursales</a>

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Caja</p>

<a href="/apertura-caja" class="block px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
🔓 Apertura de Caja
</a>

<a href="/cierre-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
💰 Cierre de Caja
</a>

</nav>
</aside>

<!-- CONTENIDO -->
<div class="flex-1 flex flex-col">

<!-- HEADER -->
<header class="bg-white border-b px-8 py-4 flex justify-between items-center shadow-sm">

<div>
<h2 class="text-xl font-bold text-gray-800">Apertura de Caja</h2>

<div class="flex items-center gap-4 mt-2 text-sm">
<div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl font-medium shadow-sm">
🖥 Caja 01
</div>

<div class="bg-green-50 text-green-700 px-4 py-2 rounded-xl font-medium shadow-sm">
👤 {{ auth()->user()->nombre_completo }}
</div>
</div>
</div>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 font-semibold">
🚪 Salir
</button>
</form>

</header>

<main class="flex-1 p-6 flex items-center justify-center">

<form method="POST"
action="{{ route('caja.guardar') }}"
class="bg-white p-8 rounded-xl shadow border border-gray-200 w-full max-w-md">

@csrf

<h3 class="text-lg font-semibold mb-6 text-gray-700">
Configuración Inicial de Caja
</h3>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
{{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
{{ session('success') }}
</div>
@endif

<div class="mb-5">
<label class="block mb-1 font-semibold text-sm">Cajero</label>
<p class="bg-gray-100 border border-gray-300 p-3 rounded-lg text-gray-700 font-medium">
{{ auth()->user()->nombre_completo }}
</p>
</div>

<div class="mb-6">
<label class="block mb-1 font-semibold text-sm">
Monto Inicial
</label>

<input
type="number"
name="monto_inicial"
class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-yellow-500"
placeholder="Ej. 1000.00"
min="0"
step="0.01"
required
/>

@error('monto_inicial')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

<button
type="submit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold w-full transition">
Abrir Caja
</button>

</form>

</main>
</div>
</div>

<script>
function toggleSidebar(){
document.getElementById("sidebar").classList.toggle("-translate-x-full");
}
</script>

</body>
</html>