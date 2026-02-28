<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Corte de Caja - Ferretería Alfredo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white hidden lg:flex flex-col justify-between shadow-xl">
      <div>
        <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
        <nav class="flex flex-col gap-2 px-5 mt-6">
          <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📊 Dashboard</a>
          <a href="/" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛍️ Punto de Venta</a>
          <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📄 Facturación</a>
          <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 <span>Apertura de Caja</span></a>
          <a href="/corte-caja" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 text-gray-900 rounded font-semibold">💰 Cierre de Caja</a>
          <a href="/promociones" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🎯 Promociones</a>
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

    <!-- Contenido principal dinámico -->
    <main id="contenidoPrincipal" class="flex-1 p-6 overflow-y-auto"></main>

  </div>

  <script>
    const contenedor = document.getElementById('contenidoPrincipal');

    // Estado inicial
    let montoInicial = 0;
    let retiros = [];
    let corteGenerado = false;

    // Renderiza la pantalla de corte con la info actual
    function renderCorteCaja() {
      const totalRetiros = retiros.reduce((sum, r) => sum + r.monto, 0);
      const saldoActual = montoInicial - totalRetiros;

      const tablaRetiros = retiros.length > 0
        ? retiros.map((r, i) => `
          <tr class="${i % 2 === 0 ? 'bg-gray-50' : ''}">
            <td class="p-2 border">${r.descripcion}</td>
            <td class="p-2 border text-right">$${r.monto.toFixed(2)}</td>
            <td class="p-2 border text-center">
              ${corteGenerado ? '' : `<button onclick="eliminarRetiro(${i})" class="text-red-600 hover:underline">Eliminar</button>`}
            </td>
          </tr>
        `).join('')
        : `<tr><td colspan="3" class="p-4 text-center text-gray-500 italic">No hay retiros parciales</td></tr>`;

      return `
        <div class="max-w-5xl mx-auto">

          <h1 class="text-3xl font-bold text-gray-800 mb-6">💰 Corte de Caja</h1>

          <section class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold mb-4">💵 Información inicial</h2>
            <div class="grid grid-cols-2 gap-4 text-lg">
              <div>
                <span class="font-semibold text-gray-700">Monto Inicial Aperturado:</span>
                <p class="mt-1 text-green-700 font-bold text-2xl">$${montoInicial.toFixed(2)}</p>
              </div>
              <div>
                <span class="font-semibold text-gray-700">Total Retiros Parciales:</span>
                <p class="mt-1 text-red-600 font-bold text-2xl">-$${totalRetiros.toFixed(2)}</p>
              </div>
              <div class="col-span-2">
                <span class="font-semibold text-gray-700">Saldo Actual:</span>
                <p class="mt-1 text-blue-700 font-bold text-3xl">$${saldoActual.toFixed(2)}</p>
              </div>
            </div>
          </section>

          ${corteGenerado ? '' : `
            <section class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-6">
              <h2 class="text-xl font-semibold mb-4">➖ Agregar Retiro Parcial</h2>
              <form id="formRetiro" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                  <label for="descRetiro" class="block text-sm font-medium mb-1">Descripción</label>
                  <input id="descRetiro" type="text" placeholder="Ej. Pago a proveedor" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-yellow-500 focus:outline-none" required />
                </div>
                <div>
                  <label for="montoRetiro" class="block text-sm font-medium mb-1">Monto</label>
                  <input id="montoRetiro" type="number" min="0.01" step="0.01" placeholder="Ej. 150.00" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-yellow-500 focus:outline-none" required />
                </div>
                <div>
                  <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold w-full">Agregar Retiro</button>
                </div>
              </form>
            </section>
          `}

          <section class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold mb-4">📋 Historial de Retiros Parciales</h2>
            <table class="w-full text-left text-sm border-collapse border border-gray-300">
              <thead class="bg-gray-200">
                <tr>
                  <th class="p-2 border">Descripción</th>
                  <th class="p-2 border text-right">Monto</th>
                  <th class="p-2 border text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                ${tablaRetiros}
              </tbody>
            </table>
          </section>

          <section class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-6">
            <h2 class="text-xl font-semibold mb-4">📋 Resumen de Ventas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="font-semibold text-gray-700">Total de Ventas</p>
                <p class="text-2xl font-bold text-green-700">$5,820.00</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="font-semibold text-gray-700">Tickets Emitidos</p>
                <p class="text-2xl font-bold text-blue-700">47</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="font-semibold text-gray-700">Ventas en Efectivo</p>
                <p class="text-xl font-bold text-gray-800">$3,100.00</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="font-semibold text-gray-700">Ventas con Tarjeta</p>
                <p class="text-xl font-bold text-gray-800">$2,400.00</p>
              </div>
            </div>
            <div class="mt-4">
              <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
              <textarea id="observaciones" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-yellow-500 focus:outline-none resize-none" placeholder="Notas adicionales del corte..." ${corteGenerado ? 'disabled' : ''}></textarea>
            </div>
          </section>

          <div class="flex flex-wrap gap-3 mb-10">
            <button id="btnGenerarCorte" class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-lg font-bold" ${corteGenerado ? 'disabled' : ''}>🧾 Generar Corte</button>
            <button id="btnImprimirCorte" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold">🖨️ Imprimir Corte</button>
            <button id="btnCerrarCaja" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-bold">🔒 Cerrar Caja</button>
          </div>

        </div>
      `;
    }

    function mostrarMensajeApertura() {
      contenedor.innerHTML = `
        <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow border border-gray-200 mt-20 text-center">
          <h1 class="text-3xl font-bold mb-6 text-gray-800">⚠️ Caja No Aperturada</h1>
          <p class="text-gray-700 mb-4">Primero debes abrir la caja antes de poder hacer el corte.</p>
          <a href="/apertura-caja" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-6 py-3 rounded-lg font-semibold">Abrir Caja</a>
        </div>
      `;
    }

    // Funciones principales
    function agregarRetiro(e) {
      e.preventDefault();
      if (corteGenerado) return;

      const descInput = document.getElementById('descRetiro');
      const montoInput = document.getElementById('montoRetiro');
      const descripcion = descInput.value.trim();
      const monto = parseFloat(montoInput.value);

      if (!descripcion) {
        alert('Ingresa una descripción para el retiro.');
        descInput.focus();
        return;
      }
      if (isNaN(monto) || monto <= 0) {
        alert('Ingresa un monto válido mayor a 0 para el retiro.');
        montoInput.focus();
        return;
      }
      const totalRetiros = retiros.reduce((sum, r) => sum + r.monto, 0);
      if (monto > (montoInicial - totalRetiros)) {
        alert('El monto del retiro no puede ser mayor al saldo actual.');
        montoInput.focus();
        return;
      }
      retiros.push({ descripcion, monto });
      descInput.value = '';
      montoInput.value = '';
      actualizarVista();
    }

    function eliminarRetiro(index) {
      if (corteGenerado) return;
      retiros.splice(index, 1);
      actualizarVista();
    }

    function generarCorte() {
      if (corteGenerado) {
        alert('El corte ya fue generado.');
        return;
      }
      corteGenerado = true;
      actualizarVista();
      alert('Corte generado correctamente. Puedes imprimirlo o cerrar la caja.');
    }

    function imprimirCorte() {
      if (!corteGenerado) {
        alert('Primero debes generar el corte para imprimirlo.');
        return;
      }

      const totalRetiros = retiros.reduce((sum, r) => sum + r.monto, 0);
      const saldoActual = montoInicial - totalRetiros;
      const observaciones = document.getElementById('observaciones').value.trim();

      const contenido = `
        <!DOCTYPE html>
        <html lang="es">
        <head>
          <meta charset="UTF-8" />
          <title>Reporte Corte de Caja</title>
          <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            h1 { color: #f59e0b; }
            table { border-collapse: collapse; width: 100%; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; }
            th { background-color: #f3f4f6; }
          </style>
        </head>
        <body>
          <h1>Reporte Corte de Caja</h1>
          <p><strong>Fecha:</strong> ${new Date().toLocaleString()}</p>
          <p><strong>Monto Inicial:</strong> $${montoInicial.toFixed(2)}</p>
          <p><strong>Total Retiros:</strong> $${totalRetiros.toFixed(2)}</p>
          <p><strong>Saldo Actual:</strong> $${saldoActual.toFixed(2)}</p>

          <h2>Retiros Parciales</h2>
          <table>
            <thead><tr><th>Descripción</th><th>Monto</th></tr></thead>
            <tbody>
              ${retiros.length > 0 
                ? retiros.map(r => `<tr><td>${r.descripcion}</td><td>$${r.monto.toFixed(2)}</td></tr>`).join('')
                : '<tr><td colspan="2" style="text-align:center;">No hay retiros</td></tr>'
              }
            </tbody>
          </table>

          <h2>Observaciones</h2>
          <p>${observaciones || 'Ninguna'}</p>
        </body>
        </html>
      `;

      const ventana = window.open('', '_blank', 'width=600,height=700');
      ventana.document.write(contenido);
      ventana.document.close();

      // Espera a que el documento esté listo para imprimir
      ventana.onload = function () {
        ventana.focus();
        ventana.print();
        ventana.onafterprint = () => ventana.close();
      };
    }

    function cerrarCaja() {
      if (confirm('¿Estás seguro de cerrar la caja? Esta acción no podrá revertirse.')) {
        montoInicial = 0;
        retiros = [];
        corteGenerado = false;
        actualizarVista();
        alert('Caja cerrada correctamente.');
      }
    }

    // Actualiza la vista según estado
    function actualizarVista() {
      if (1 > 0) {
        contenedor.innerHTML = renderCorteCaja();
        if (!corteGenerado) {
          document.getElementById('formRetiro').addEventListener('submit', agregarRetiro);
          document.getElementById('btnGenerarCorte').addEventListener('click', generarCorte);
        }
        document.getElementById('btnImprimirCorte').addEventListener('click', imprimirCorte);
        document.getElementById('btnCerrarCaja').addEventListener('click', cerrarCaja);
      } else {
        mostrarMensajeApertura();
      }
    }

    // Inicializa app
    actualizarVista();
  </script>
</body>
</html>
