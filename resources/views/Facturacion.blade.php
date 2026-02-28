<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Facturación - Ferretería Alfredo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-none flex-col w-64 bg-gray-800 text-white shadow-xl">
      <div class="flex flex-col h-full justify-between">
        <div>
          <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
          <nav class="flex flex-col gap-2 px-5 mt-6">
            <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              📊 <span>Dashboard</span>
            </a>
            <a href="/" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              🛍️ <span>Punto de Venta</span>
            </a>
            <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold rounded">
              📄 <span>Facturación</span>
            </a>
            <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 <span>Apertura de Caja</span></a>

            <a href="/corte-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              💰 <span>Cierre de Caja</span>
            </a>
            <a href="/promociones" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              🎯 <span>Promociones</span>
            </a>
            <a href="/inventario" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              📦 <span>Inventario</span>
            </a>
            <a href="/productos" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              🛠️ <span>Productos</span>
            </a>
            <a href="/sucursales" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              🏢 <span>Sucursales</span>
            </a>
            <a href="/clientes" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              👥 <span>Clientes</span>
            </a>
            <a href="/usuarios" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
              👤 <span>Usuarios</span>
            </a>
            <a href="/tickets" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🖨️ <span>Tickets</span></a>
          </nav>
        </div>
        <div class="px-5 py-4 border-t border-gray-700 text-sm flex items-center justify-between">
          <span>👤 <strong>Juan Pérez</strong></span>
          <button class="text-red-400 hover:text-red-600 font-semibold">🚪 Salir</button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 lg:p-10 overflow-auto bg-gray-100">
      <div class="max-w-5xl mx-auto space-y-12">

        <!-- Formulario de facturación -->
        <section class="bg-white border border-gray-300 rounded-xl shadow-md p-6">
          <h1 class="text-3xl font-bold text-gray-800 mb-6">📄 Facturación</h1>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block font-semibold text-sm mb-1">RFC del Cliente</label>
              <input type="text" placeholder="PEJU800101ABC" class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Nombre o Razón Social</label>
              <input type="text" placeholder="Juan Pérez" class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Correo Electrónico</label>
              <input type="email" placeholder="correo@ejemplo.com" class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Uso de CFDI</label>
              <select class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="G01">G01 - Adquisición de mercancías</option>
                <option value="G03">G03 - Gastos en general</option>
                <option value="P01">P01 - Por definir</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1">Método de pago</label>
              <select class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="PUE">Pago en una sola exhibición</option>
                <option value="PPD">Pago en parcialidades o diferido</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1">Forma de pago</label>
              <select class="w-full border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="01">01 - Efectivo</option>
                <option value="03">03 - Transferencia</option>
                <option value="04">04 - Tarjeta de crédito</option>
              </select>
            </div>
          </div>
          <div class="mt-8 text-right">
            <button class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold">💾 Generar Factura</button>
          </div>
        </section>

        <!-- Facturas emitidas -->
        <section class="bg-white border border-gray-300 rounded-xl shadow-md p-6">
          <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6 gap-4">
            <div>
              <h2 class="text-xl font-bold text-gray-800 mb-2">📋 Facturas Emitidas</h2>
              <p class="text-sm text-gray-500">Consulta las facturas generadas en un rango de fechas.</p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-end gap-2">
              <div>
                <label class="block text-sm font-medium mb-1">Desde:</label>
                <input type="date" class="border px-3 py-2 rounded-lg focus:outline-none focus:ring-yellow-500">
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Hasta:</label>
                <input type="date" class="border px-3 py-2 rounded-lg focus:outline-none focus:ring-yellow-500">
              </div>
              <div class="sm:pt-6">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg font-semibold">🔎 Filtrar</button>
              </div>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-300 rounded-xl">
              <thead class="bg-gray-100 font-bold text-gray-700">
                <tr>
                  <th class="px-4 py-3 border">Folio</th>
                  <th class="px-4 py-3 border">Cliente</th>
                  <th class="px-4 py-3 border">Fecha</th>
                  <th class="px-4 py-3 border">Total</th>
                  <th class="px-4 py-3 border">CFDI</th>
                  <th class="px-4 py-3 border text-center">Acciones</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr>
                  <td class="px-4 py-2 border">FAC-00123</td>
                  <td class="px-4 py-2 border">Juan Pérez</td>
                  <td class="px-4 py-2 border">2025-06-24</td>
                  <td class="px-4 py-2 border">$1,250.00</td>
                  <td class="px-4 py-2 border">G03</td>
                  <td class="px-4 py-2 border text-center">
                    <button class="text-blue-600 hover:underline text-sm">📄 Ver PDF</button>
                    <button class="text-green-600 hover:underline text-sm ml-2">📥 XML</button>
                  </td>
                </tr>
                <tr>
                  <td class="px-4 py-2 border">FAC-00124</td>
                  <td class="px-4 py-2 border">María López</td>
                  <td class="px-4 py-2 border">2025-06-24</td>
                  <td class="px-4 py-2 border">$980.00</td>
                  <td class="px-4 py-2 border">P01</td>
                  <td class="px-4 py-2 border text-center">
                    <button class="text-blue-600 hover:underline text-sm">📄 Ver PDF</button>
                    <button class="text-green-600 hover:underline text-sm ml-2">📥 XML</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

      </div>
    </main>
  </div>
</body>
</html>
