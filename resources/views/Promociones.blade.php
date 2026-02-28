<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Promociones - Ferretería Alfredo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar fijo -->
    <aside class="hidden lg:flex flex-none w-64 bg-gray-800 text-white flex-col justify-between shadow-xl">
      <div>
        <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
        <nav class="flex flex-col gap-2 px-5 mt-6">
          <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📊 Dashboard</a>
          <a href="/" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛍️ Punto de Venta</a>
          <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📄 Facturación</a>
          <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 <span>Apertura de Caja</span></a>
          <a href="/cierre-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">💰 Cierre de Caja</a>
          <a href="/promociones" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 text-gray-900 rounded font-semibold">🎯 Promociones</a>
          <a href="/inventario" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📦 Inventario</a>
          <a href="/productos" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛠️ Productos</a>
          <a href="/sucursales" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🏢 Sucursales</a>
          <a href="/clientes" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👥 Clientes</a>
          <a href="/usuarios" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👤 Usuarios</a>
          <a href="/tickets" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🖨️ <span>Tickets</span></a>
        </nav>
      </div>
      <div class="px-5 py-4 border-t border-gray-700 text-sm flex items-center justify-between">
        <span>👤 <strong>Juan Pérez</strong></span>
        <button class="text-red-400 hover:text-red-600 font-semibold">🚪 Salir</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">🎯 Promociones</h1>

      <!-- Crear promoción -->
      <section class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">➕ Crear nueva promoción</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block mb-1 font-semibold">Nombre de la promoción</label>
            <input type="text" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Ej. 2x1 en martillos" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Descripción</label>
            <input type="text" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Detalle de la promo" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Fecha inicio</label>
            <input type="date" class="w-full border border-gray-300 p-2 rounded-lg" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Fecha fin</label>
            <input type="date" class="w-full border border-gray-300 p-2 rounded-lg" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Tipo de descuento</label>
            <select class="w-full border border-gray-300 p-2 rounded-lg">
              <option value="porcentaje">Porcentaje</option>
              <option value="monto">Monto fijo</option>
              <option value="producto">Producto gratis</option>
            </select>
          </div>
          <div>
            <label class="block mb-1 font-semibold">Valor</label>
            <input type="number" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Ej. 10 o 50.00" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Categoría (opcional)</label>
            <select class="w-full border border-gray-300 p-2 rounded-lg">
              <option value="">-- Ninguna --</option>
              <option value="herramientas">Herramientas</option>
              <option value="tuberia">Tubería</option>
              <option value="electrico">Eléctrico</option>
              <option value="pinturas">Pinturas y Solventes</option>
              <option value="ferreteria">Ferretería General</option>
              <option value="materiales">Materiales de Construcción</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Aplica la promoción a toda esta categoría.</p>
          </div>
          <div>
            <label class="block mb-1 font-semibold">Producto específico (opcional)</label>
            <input type="text" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Ej. Martillo, SKU123, etc." />
            <p class="text-xs text-gray-500 mt-1">Deja vacío para aplicar a múltiples productos o categorías.</p>
          </div>
          <div class="md:col-span-2 flex justify-end mt-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">Guardar promoción</button>
          </div>
        </form>
      </section>

      <!-- Filtro -->
      <section class="mb-6">
        <form class="flex flex-wrap gap-4 items-end">
          <div>
            <label class="block mb-1 font-semibold">Buscar promoción</label>
            <input type="text" class="border border-gray-300 p-2 rounded-lg" placeholder="Nombre..." />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Desde</label>
            <input type="date" class="border border-gray-300 p-2 rounded-lg" />
          </div>
          <div>
            <label class="block mb-1 font-semibold">Hasta</label>
            <input type="date" class="border border-gray-300 p-2 rounded-lg" />
          </div>
          <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-5 py-2 rounded-lg font-semibold">Buscar</button>
        </form>
      </section>

      <!-- Tabla de promociones -->
      <section class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">📋 Promociones activas</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="bg-gray-200 text-gray-700">
              <tr>
                <th class="p-3">Nombre</th>
                <th class="p-3">Inicio</th>
                <th class="p-3">Fin</th>
                <th class="p-3">Tipo</th>
                <th class="p-3">Valor</th>
                <th class="p-3">Categoría</th>
                <th class="p-3">Producto</th>
                <th class="p-3 text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="p-3 font-medium text-gray-800">2x1 en Martillos</td>
                <td class="p-3">2025-06-01</td>
                <td class="p-3">2025-06-30</td>
                <td class="p-3">Producto</td>
                <td class="p-3">Martillo gratis</td>
                <td class="p-3 text-gray-400 italic">Herramientas</td>
                <td class="p-3">Martillo 16oz</td>
                <td class="p-3 text-center space-x-2">
                  <button class="text-blue-600 hover:underline">Editar</button>
                  <button class="text-yellow-600 hover:underline">Desactivar</button>
                  <button class="text-red-600 hover:underline">Eliminar</button>
                </td>
              </tr>
              <tr class="border-b">
                <td class="p-3 font-medium text-gray-800">10% en pintura</td>
                <td class="p-3">2025-06-10</td>
                <td class="p-3">2025-06-24</td>
                <td class="p-3">Porcentaje</td>
                <td class="p-3">10%</td>
                <td class="p-3">Pinturas y Solventes</td>
                <td class="p-3 text-gray-400 italic">General</td>
                <td class="p-3 text-center space-x-2">
                  <button class="text-blue-600 hover:underline">Editar</button>
                  <button class="text-yellow-600 hover:underline">Desactivar</button>
                  <button class="text-red-600 hover:underline">Eliminar</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
