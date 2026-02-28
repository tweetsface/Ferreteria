<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inventario - Ferretería Alfredo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SheetJS para exportar Excel -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-64 bg-gray-800 text-white shadow-xl">
      <div class="flex flex-col h-full justify-between">
        <div>
          <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
          <nav class="flex flex-col gap-2 px-5 mt-6">
            <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 hover:bg-yellow-500 hover:text-gray-900 rounded font-semibold">📊 <span>Dashboard</span></a>
            <a href="/" class="flex items-center gap-2 py-2 px-3 hover:bg-yellow-500 hover:text-gray-900 rounded font-semibold">🛍️ <span>Punto de Venta</span></a>
            <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 hover:bg-yellow-500 hover:text-gray-900 rounded font-semibold">📄 <span>Facturación</span></a>
            <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 <span>Apertura de Caja</span></a>
            <a href="/cierre-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-yellow-500 hover:text-gray-900 rounded font-semibold">💰 <span>Cierre de Caja</span></a>
            <a href="/promociones" class="flex items-center gap-2 py-2 px-3 hover:bg-yellow-500 hover:text-gray-900 rounded font-semibold">🎯 <span>Promociones</span></a>
            <a href="/inventario" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 text-gray-900 font-semibold rounded">📦 <span>Inventario</span></a>
            <a href="/productos" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛠️ <span>Productos</span></a>
            <a href="/sucursales" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🏢 <span>Sucursales</span></a>
            <a href="/clientes" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👥 <span>Clientes</span></a>
            <a href="/usuarios" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👤 <span>Usuarios</span></a>
            <a href="/tickets" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🖨️ <span>Tickets</span></a>
          </nav>
        </div>
        <div class="px-5 py-4 border-t border-gray-700 text-sm flex items-center justify-between">
          <span>👤 <strong>Admin</strong></span>
          <button class="text-red-400 hover:text-red-600 font-semibold">🚪 Salir</button>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto bg-gray-100">
      <h1 class="text-4xl font-bold mb-8 text-gray-900">📦 Inventario</h1>

      <!-- Selector sucursal -->
      <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <label for="selectSucursal" class="font-semibold mr-2">Sucursal:</label>
          <select id="selectSucursal" class="border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="Centro">Sucursal Centro</option>
            <option value="Norte">Sucursal Norte</option>
            <option value="Sur">Sucursal Sur</option>
          </select>
        </div>

        <input type="text" id="buscarInput" placeholder="Buscar por nombre o SKU..."
          class="w-full md:max-w-md border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" />

        <button id="btnAbrirHistorial" class="bg-white border border-yellow-500 text-yellow-600 px-5 py-2 rounded-xl font-semibold shadow hover:bg-yellow-500 hover:text-white transition text-sm">
          📜 Ver historial de movimientos
        </button>
      </div>

      <!-- Tabla de inventario -->
      <section class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Productos registrados</h2>
        <table class="w-full border-collapse border border-gray-300 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border border-gray-300 p-2 text-left">SKU</th>
              <th class="border border-gray-300 p-2 text-left">Nombre</th>
              <th class="border border-gray-300 p-2 text-left">Categoría</th>
              <th class="border border-gray-300 p-2 text-right">Precio</th>
              <th class="border border-gray-300 p-2 text-center">Cantidad</th>
              <th class="border border-gray-300 p-2 text-center">Stock mínimo</th>
              <th class="border border-gray-300 p-2 text-center">Operaciones</th>
            </tr>
          </thead>
          <tbody id="tablaInventarioBody">
            <tr>
              <td colspan="7" class="text-center p-4 text-gray-500 italic">No hay productos en inventario</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Productos sin stock -->
      <section id="sinStockSection" class="bg-white p-6 rounded-xl shadow border border-gray-200">
        <h2 class="text-2xl font-semibold mb-4 text-red-600">🚨 Productos sin stock</h2>
        <table class="w-full border-collapse border border-gray-300 text-sm">
          <thead class="bg-red-100">
            <tr>
              <th class="border border-gray-300 p-2 text-left">SKU</th>
              <th class="border border-gray-300 p-2 text-left">Nombre</th>
              <th class="border border-gray-300 p-2 text-left">Categoría</th>
              <th class="border border-gray-300 p-2 text-right">Precio</th>
              <th class="border border-gray-300 p-2 text-center">Stock mínimo</th>
              <th class="border border-gray-300 p-2 text-center">Operaciones</th>
            </tr>
          </thead>
          <tbody id="tablaSinStockBody">
            <tr>
              <td colspan="6" class="text-center p-4 text-gray-500 italic">No hay productos sin stock</td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <!-- Modal Historial -->
  <div id="modalHistorial" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-11/12 max-w-5xl max-h-[80vh] overflow-auto p-6 relative">
      <h3 class="text-2xl font-semibold mb-4">📜 Historial de Movimientos</h3>

      <!-- Filtro fechas -->
      <div class="flex flex-col md:flex-row gap-4 mb-4 items-center">
        <div>
          <label for="fechaDesde" class="font-semibold mr-2">Desde:</label>
          <input type="date" id="fechaDesde" class="border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        </div>
        <div>
          <label for="fechaHasta" class="font-semibold mr-2">Hasta:</label>
          <input type="date" id="fechaHasta" class="border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" />
        </div>
        <button id="btnFiltrarFechas" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl font-semibold shadow transition text-sm">
          Filtrar
        </button>
        <button id="btnExportarExcel" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-semibold shadow transition text-sm ml-auto">
          Exportar a Excel
        </button>
      </div>

      <table class="w-full border-collapse border border-gray-300 text-sm mb-4">
        <thead class="bg-gray-100">
          <tr>
            <th class="border border-gray-300 p-2 text-left">SKU</th>
            <th class="border border-gray-300 p-2 text-left">Producto</th>
            <th class="border border-gray-300 p-2 text-center">Acción</th>
            <th class="border border-gray-300 p-2 text-center">Cantidad</th>
            <th class="border border-gray-300 p-2 text-center">Fecha y Hora</th>
          </tr>
        </thead>
        <tbody id="tablaHistorialBody">
          <tr>
            <td colspan="5" class="text-center p-4 text-gray-500 italic">No hay movimientos registrados</td>
          </tr>
        </tbody>
      </table>

      <button id="btnCerrarHistorial" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
    </div>
  </div>

  <script>
    const selectSucursal = document.getElementById('selectSucursal');
    const tbody = document.getElementById('tablaInventarioBody');
    const tbodySinStock = document.getElementById('tablaSinStockBody');
    const buscarInput = document.getElementById('buscarInput');
    const modalHistorial = document.getElementById('modalHistorial');
    const btnAbrirHistorial = document.getElementById('btnAbrirHistorial');
    const btnCerrarHistorial = document.getElementById('btnCerrarHistorial');
    const tablaHistorialBody = document.getElementById('tablaHistorialBody');

    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    const btnFiltrarFechas = document.getElementById('btnFiltrarFechas');
    const btnExportarExcel = document.getElementById('btnExportarExcel');

    // Inventario por sucursal
    let inventariosPorSucursal = {
      Centro: [
        { sku: 'HAM123', nombre: 'Martillo', categoria: 'Herramientas', precio: 150, cantidad: 10, stockMinimo: 5 },
        { sku: 'DES456', nombre: 'Destornillador', categoria: 'Herramientas', precio: 80, cantidad: 0, stockMinimo: 5 },
        { sku: 'CLV789', nombre: 'Clavo', categoria: 'Ferretería', precio: 5, cantidad: 0, stockMinimo: 20 }
      ],
      Norte: [
        { sku: 'ALC789', nombre: 'Alicate', categoria: 'Herramientas', precio: 95, cantidad: 12, stockMinimo: 3 },
        { sku: 'CIN101', nombre: 'Cinta métrica', categoria: 'Herramientas', precio: 95, cantidad: 0, stockMinimo: 5 }
      ],
      Sur: []
    };

    // Historial por sucursal
    let historialPorSucursal = {
      Centro: [
        { sku: 'HAM123', nombre: 'Martillo', accion: 'Entrada', cantidad: 5, fecha: new Date('2025-06-20T10:30:00') },
        { sku: 'HAM123', nombre: 'Martillo', accion: 'Salida', cantidad: 2, fecha: new Date('2025-06-21T14:00:00') },
      ],
      Norte: [],
      Sur: []
    };

    // Para guardar último filtro fechas y mostrar
    let historialFiltrado = [];

    function renderTabla() {
      const sucursal = selectSucursal.value;
      const filtro = buscarInput.value.toLowerCase();
      const inventario = inventariosPorSucursal[sucursal] || [];

      // Filtrar productos con stock > 0 y que coincidan con búsqueda
      const productosConStock = inventario.filter(p =>
        p.cantidad > 0 &&
        (p.nombre.toLowerCase().includes(filtro) || p.sku.toLowerCase().includes(filtro))
      );

      if (productosConStock.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" class="text-center p-4 text-gray-500 italic">No se encontraron productos con stock</td>
          </tr>
        `;
      } else {
        tbody.innerHTML = productosConStock.map((p, i) => {
          const claseStockBajo = p.cantidad <= p.stockMinimo ? 'bg-red-100' : (i % 2 === 0 ? 'bg-gray-50' : '');
          return `
            <tr class="${claseStockBajo}">
              <td class="border border-gray-300 p-2">${p.sku}</td>
              <td class="border border-gray-300 p-2">${p.nombre}</td>
              <td class="border border-gray-300 p-2">${p.categoria}</td>
              <td class="border border-gray-300 p-2 text-right">$${p.precio.toFixed(2)}</td>
              <td class="border border-gray-300 p-2 text-center">${p.cantidad}</td>
              <td class="border border-gray-300 p-2 text-center">${p.stockMinimo}</td>
              <td class="border border-gray-300 p-2 text-center space-x-1">
                <button onclick="ajustarStock('${sucursal}', '${p.sku}', 1)" class="text-green-600 hover:underline text-xs">+ Entrada</button>
                <button onclick="ajustarStock('${sucursal}', '${p.sku}', -1)" class="text-red-600 hover:underline text-xs">- Salida</button>
              </td>
            </tr>
          `;
        }).join('');
      }

      // Render productos sin stock
      const productosSinStock = inventario.filter(p =>
        p.cantidad === 0 &&
        (p.nombre.toLowerCase().includes(filtro) || p.sku.toLowerCase().includes(filtro))
      );

      if (productosSinStock.length === 0) {
        tbodySinStock.innerHTML = `
          <tr>
            <td colspan="6" class="text-center p-4 text-gray-500 italic">No hay productos sin stock</td>
          </tr>
        `;
      } else {
        tbodySinStock.innerHTML = productosSinStock.map((p, i) => `
          <tr class="${i % 2 === 0 ? 'bg-red-50' : ''}">
            <td class="border border-gray-300 p-2">${p.sku}</td>
            <td class="border border-gray-300 p-2">${p.nombre}</td>
            <td class="border border-gray-300 p-2">${p.categoria}</td>
            <td class="border border-gray-300 p-2 text-right">$${p.precio.toFixed(2)}</td>
            <td class="border border-gray-300 p-2 text-center">${p.stockMinimo}</td>
            <td class="border border-gray-300 p-2 text-center space-x-1">
              <button onclick="ajustarStock('${sucursal}', '${p.sku}', 1)" class="text-green-600 hover:underline text-xs">+ Entrada</button>
            </td>
          </tr>
        `).join('');
      }
    }

    function ajustarStock(sucursal, sku, cantidadCambio) {
      const inventario = inventariosPorSucursal[sucursal];
      const producto = inventario.find(p => p.sku === sku);
      if (!producto) return;

      let nuevaCantidad = producto.cantidad + cantidadCambio;
      if (nuevaCantidad < 0) nuevaCantidad = 0;

      // Actualizar cantidad
      producto.cantidad = nuevaCantidad;

      // Guardar en historial
      historialPorSucursal[sucursal] = historialPorSucursal[sucursal] || [];
      historialPorSucursal[sucursal].push({
        sku: producto.sku,
        nombre: producto.nombre,
        accion: cantidadCambio > 0 ? 'Entrada' : 'Salida',
        cantidad: Math.abs(cantidadCambio),
        fecha: new Date()
      });

      renderTabla();
    }

    // Filtrar historial por fechas y sucursal
    function filtrarHistorial() {
      const sucursal = selectSucursal.value;
      const desde = fechaDesde.value ? new Date(fechaDesde.value) : null;
      const hasta = fechaHasta.value ? new Date(fechaHasta.value) : null;
      const historial = historialPorSucursal[sucursal] || [];

      historialFiltrado = historial.filter(mov => {
        if (desde && mov.fecha < desde) return false;
        if (hasta) {
          // Ajustar hasta para incluir todo el día
          const fechaHastaEnd = new Date(hasta);
          fechaHastaEnd.setHours(23,59,59,999);
          if (mov.fecha > fechaHastaEnd) return false;
        }
        return true;
      });

      renderHistorial();
    }

    function renderHistorial() {
      if (historialFiltrado.length === 0) {
        tablaHistorialBody.innerHTML = `
          <tr>
            <td colspan="5" class="text-center p-4 text-gray-500 italic">No hay movimientos registrados en este rango</td>
          </tr>
        `;
        return;
      }

      tablaHistorialBody.innerHTML = historialFiltrado.map(mov => `
        <tr>
          <td class="border border-gray-300 p-2">${mov.sku}</td>
          <td class="border border-gray-300 p-2">${mov.nombre}</td>
          <td class="border border-gray-300 p-2 text-center">${mov.accion}</td>
          <td class="border border-gray-300 p-2 text-center">${mov.cantidad}</td>
          <td class="border border-gray-300 p-2 text-center">${mov.fecha.toLocaleString()}</td>
        </tr>
      `).join('');
    }

    btnAbrirHistorial.addEventListener('click', () => {
      modalHistorial.classList.remove('hidden');
      // Inicializa filtros fechas y tabla
      fechaDesde.value = '';
      fechaHasta.value = '';
      filtrarHistorial();
    });

    btnCerrarHistorial.addEventListener('click', () => {
      modalHistorial.classList.add('hidden');
    });

    btnFiltrarFechas.addEventListener('click', () => {
      filtrarHistorial();
    });

    btnExportarExcel.addEventListener('click', () => {
      if (historialFiltrado.length === 0) {
        alert('No hay movimientos para exportar');
        return;
      }
      // Preparar datos para exportar
      const data = historialFiltrado.map(m => ({
        SKU: m.sku,
        Producto: m.nombre,
        Acción: m.accion,
        Cantidad: m.cantidad,
        'Fecha y Hora': m.fecha.toLocaleString()
      }));

      /* convertir a worksheet */
      const ws = XLSX.utils.json_to_sheet(data);

      /* crear libro */
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Historial");

      /* exportar */
      XLSX.writeFile(wb, "historial_movimientos.xlsx");
    });

    // Renders
    selectSucursal.addEventListener('change', renderTabla);
    buscarInput.addEventListener('input', renderTabla);

    // Inicializa tabla al cargar
    renderTabla();

  </script>
</body>
</html>
