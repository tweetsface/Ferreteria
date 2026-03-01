<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title', 'Ferretería POS')</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

<div class="flex h-screen overflow-hidden">

{{-- ================= SIDEBAR ================= --}}
<aside class="w-64 bg-white border-r shadow-sm flex flex-col">

<div class="p-5 border-b">
<h1 class="text-lg font-bold text-gray-800">Ferretería POS</h1>
<p class="text-sm text-gray-500">Sucursal Centro</p>
</div>
<nav class="p-4 space-y-2 text-sm flex-1 overflow-y-auto">

{{-- ================= DASHBOARD (ADMIN) ================= --}}
@if(auth()->user()->rol == 1)
<a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📊 Dashboard
</a>
@endif


{{-- ================= OPERACIÓN (TODOS) ================= --}}
<p class="px-4 py-2 text-gray-400 uppercase text-xs">Operación</p>

<a href="/venta" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🏪 Venta
</a>

<a href="/clientes" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
👥 Clientes
</a>

@if(auth()->user()->rol == 1)
<a href="/facturacion" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📄 Facturación
</a>
@endif


{{-- ================= INVENTARIO (ADMIN) ================= --}}
@if(auth()->user()->rol == 1)
<p class="px-4 py-2 text-gray-400 uppercase text-xs">Inventario</p>

<a href="/productos" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📦 Productos
</a>

<a href="/inventario" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📦 Movimientos de Inventario
</a>
@endif


{{-- ================= CAJA (TODOS) ================= --}}
<p class="px-4 py-2 text-gray-400 uppercase text-xs">Caja</p>

<a href="/apertura-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🔓 Apertura de Caja
</a>

<a href="/cierre-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
💰 Cierre de Caja
</a>

@if(auth()->user()->rol == 1)
<a href="/movimientos-caja" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
📑 Movimientos de Caja
</a>
@endif


{{-- ================= ADMINISTRACIÓN (SOLO ADMIN) ================= --}}
@if(auth()->user()->rol == 1)

<p class="px-4 py-2 text-gray-400 uppercase text-xs">Administración</p>

<a href="/usuarios" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
👤 Usuarios
</a>

<a href="/configuracion" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
⚙️ Configuración
</a>

<a href="/sucursales" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
🏢 Sucursales
</a>

@endif

</nav>
<div class="mt-auto border-t">

<form method="POST" action="{{ route('logout') }}">
@csrf

<button type="submit"
class="block w-full text-left px-4 py-3
text-gray-700 font-medium
hover:bg-gray-100
border-l-4 border-transparent
hover:border-red-500
transition">

🚪 Cerrar sesión

</button>

</form>

</div>
</aside>

{{-- ================= CONTENIDO ================= --}}
<div class="flex-1 flex flex-col ">

{{-- HEADER --}}
<header class="bg-white border-b px-8 py-4">

<div class="flex items-center justify-between">

    {{-- IZQUIERDA --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-900 tracking-tight">
            @yield('modulo')
        </h2>

        <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">
            Sistema Punto de Venta
        </p>
    </div>

    {{-- DERECHA --}}
    <div class="flex items-center gap-6 text-sm text-gray-600">

        <div class="flex items-center gap-2">
            <span class="text-gray-400">Sucursal:</span>
            <span class="font-medium text-gray-800">
                Centro
            </span>
        </div>

        <div class="h-5 w-px bg-gray-200"></div>

        <div class="flex items-center gap-2">
            <span class="text-gray-400">Cajero:</span>
            <span class="font-medium text-gray-800">
                {{ auth()->user()->nombre_completo ?? 'Usuario' }}
            </span>
        </div>

        <div class="h-5 w-px bg-gray-200"></div>

        <div class="text-right leading-tight">
            <p id="fechaCompleta" class="text-xs text-gray-500"></p>
            <p id="reloj" class="font-semibold text-gray-900 tracking-wide">
                00:00:00
            </p>
        </div>

    </div>

</div>

</header>
{{-- CONTENIDO VARIABLE --}}
<main class="flex-1 p-6 overflow-y-auto bg-gray-100">
    @yield('content')
</main>

</div>
</div>
<script>
function actualizarFechaHora() {

    const ahora = new Date();

    document.getElementById('reloj').textContent =
        ahora.toLocaleTimeString('es-MX', { hour12:false });

    const fecha = ahora.toLocaleDateString('es-MX', {
        weekday:'long',
        year:'numeric',
        month:'long',
        day:'numeric'
    });

    document.getElementById('fechaCompleta').textContent =
        fecha.charAt(0).toUpperCase() + fecha.slice(1);
}

setInterval(actualizarFechaHora,1000);
actualizarFechaHora();
</script>
</body>
</html>