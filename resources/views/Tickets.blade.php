<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ferretería Alfredo - Tickets</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen">
  <div class="flex flex-col lg:flex-row h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-64 bg-gray-800 text-white shadow-xl">
      <div class="flex flex-col h-full justify-between">
        <div>
          <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
          <nav class="flex flex-col gap-2 px-5 mt-6">
            <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded">📊 <span>Dashboard</span></a>
            <a href="/" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded">🛍️ <span>Punto de Venta</span></a>
            <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📄 <span>Facturación</span></a>
            <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 <span>Apertura de Caja</span></a>
            <a href="/corte-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">💰 <span>Cierre de Caja</span></a>
            <a href="/promociones" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🎯 <span>Promociones</span></a>
            <a href="/inventario" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📦 <span>Inventario</span></a>
            <a href="/productos" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛠️ <span>Productos</span></a>
            <a href="/sucursales" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🏢 <span>Sucursales</span></a>
            <a href="/clientes" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👥 <span>Clientes</span></a>
            <a href="/usuarios" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👥 <span>Usuarios</span></a>
            <a href="/tickets" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🖨️ <span>Tickets</span></a>
            <a href="/configuraciones" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">⚙ <span>Configuraciones</span></a>
          </nav>
        </div>
        <div class="px-5 py-4 border-t border-gray-700 text-sm flex items-center justify-between">
          <span>👤 <strong>Juan Pérez</strong></span>
          <button class="text-red-400 hover:text-red-600 font-semibold">🚪 Salir</button>
        </div>
      </div>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 p-6 overflow-auto">
      <section class="w-full max-w-6xl mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-200 relative">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800">📄 Gestión de Tickets</h2>
          <button onclick="document.getElementById('configModal').classList.remove('hidden')" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 shadow text-sm font-semibold">
            ⚙ Configurar Ticket
          </button>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-8">
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Número de Folio</label>
            <input type="text" placeholder="Ej. 000123" class="px-4 py-2 border rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-yellow-500">
          </div>
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Desde</label>
            <input type="date" class="px-4 py-2 border rounded-lg w-52 focus:outline-none focus:ring-2 focus:ring-yellow-500">
          </div>
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Hasta</label>
            <input type="date" class="px-4 py-2 border rounded-lg w-52 focus:outline-none focus:ring-2 focus:ring-yellow-500">
          </div>
          <div class="self-end md:self-auto mt-2 md:mt-0">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-6 py-2 rounded-lg transition duration-200 shadow">
              🔍 Buscar
            </button>
          </div>
        </div>

        <!-- Tabla de resultados -->
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
              <tr>
                <th class="px-4 py-3 text-left">Folio</th>
                <th class="px-4 py-3 text-left">Fecha</th>
                <th class="px-4 py-3 text-left">Sucursal</th>
                <th class="px-4 py-3 text-left">Cliente</th>
                <th class="px-4 py-3 text-left">Total</th>
                <th class="px-4 py-3 text-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="text-sm text-gray-800 divide-y divide-gray-200">
              <tr>
                <td class="px-4 py-3">000123</td>
                <td class="px-4 py-3">2025-06-25</td>
                <td class="px-4 py-3">Sucursal Centro</td>
                <td class="px-4 py-3">Juan Pérez</td>
                <td class="px-4 py-3">$350.00</td>
                <td class="px-4 py-3 text-center">
                  <div class="flex justify-center gap-2">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-semibold">🔄 Devolución</button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-semibold">🖨 Reimprimir</button>
                  </div>
                </td>
              </tr>
              <!-- Más resultados aquí -->
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <!-- Modal Configuración del Ticket -->
  <div id="configModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl w-full max-w-xl p-6 relative">
      <h3 class="text-xl font-bold text-gray-800 mb-4">⚙ Personalizar Ticket</h3>
      <form id="configForm" class="space-y-4">
        <input type="text" placeholder="Nombre de la empresa" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        <input type="text" placeholder="Dirección" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        <input type="text" placeholder="Teléfono" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        <input type="text" placeholder="RFC" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        <textarea placeholder="Leyenda al pie del ticket..." class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>

        <div class="flex justify-between mt-4">
          <button type="button" onclick="document.getElementById('configModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
          <button type="button" onclick="mostrarVistaPrevia()" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold rounded">Guardar y Ver Ticket</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Vista previa del ticket -->
  <div id="preview" class="fixed bottom-5 right-5 bg-white border border-gray-300 p-4 rounded shadow-md w-72 hidden">
    <h4 class="text-lg font-bold mb-2 text-center">🧾 Vista previa del Ticket</h4>
    <hr class="mb-2">
    <p class="text-sm text-center">FERRETERÍA ALFREDO</p>
    <p class="text-xs text-center">RFC: XAXX010101000</p>
    <p class="text-xs text-center">Calle Ficticia 123, Centro</p>
    <p class="text-xs text-center">Tel: 6671234567</p>
    <hr class="my-2">
    <p class="text-xs">Fecha: 25/06/2025</p>
    <p class="text-xs">Cliente: Juan Pérez</p>
    <p class="text-xs">Folio: 000123</p>
    <hr class="my-2">
    <p class="text-xs">Martillo x1 ......... $150.00</p>
    <p class="text-xs">Total: $150.00</p>
    <hr class="my-2">
    <p class="text-xs text-center italic">¡Gracias por su compra!</p>
  </div>

  <script>
    function mostrarVistaPrevia() {
      document.getElementById('configModal').classList.add('hidden');
      document.getElementById('preview').classList.remove('hidden');
    }
  </script>
</body>
</html>
