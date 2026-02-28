<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Configuración de Ticket - Ferretería Alfredo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
  <style>
    .ticket-preview {
      font-family: monospace;
      background: #fff;
      padding: 20px;
      border: 1px dashed #000;
      width: 320px;
      margin: 20px auto;
      text-align: center;
      font-size: 14px;
      white-space: pre-wrap;
      line-height: 1.3em;
      word-break: break-word;
    }
    .ticket-preview pre {
      display: inline-block;
      text-align: left;
      margin: 0 auto;
      max-width: 100%;
    }
    .barcode-container {
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }
    #preview {
      display: flex !important;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
    }
    @media print {
      body * { visibility: hidden; }
      #preview, #preview * { visibility: visible; }
      #preview { position: absolute; left: 0; top: 0; }
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen">

<div class="flex flex-col lg:flex-row h-screen overflow-hidden">
  <aside class="hidden lg:flex flex-col w-64 bg-gray-800 text-white shadow-xl">
    <div class="flex flex-col h-full justify-between">
      <div>
        <h2 class="text-2xl font-bold p-5 border-b border-gray-700">🔧 Alfredo POS</h2>
        <nav class="flex flex-col gap-2 px-5 mt-6">
          <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📊 Dashboard</a>
          <a href="/" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛍 Punto de Venta</a>
          <a href="/facturacion" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📄 Facturación</a>
          <a href="/apertura-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🔓 Apertura de Caja</a>
          <a href="/corte-caja" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">💰 Cierre de Caja</a>
          <a href="/promociones" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🎯 Promociones</a>
          <a href="/inventario" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">📦 Inventario</a>
          <a href="/productos" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🛠 Productos</a>
          <a href="/sucursales" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🏢 Sucursales</a>
          <a href="/clientes" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👥 Clientes</a>
          <a href="/usuarios" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">👤 Usuarios</a>
          <a href="/tickets" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">🖨️ Tickets</a>
          <a href="/config-ticket" class="flex items-center gap-2 py-2 px-3 bg-yellow-500 text-gray-900 font-semibold rounded">⚙️ Configurar Ticket</a>
        </nav>
      </div>
      <div class="px-5 py-4 border-t border-gray-700 text-sm flex items-center justify-between">
        <span>👤 <strong>Juan Pérez</strong></span>
        <button class="text-red-400 hover:text-red-600 font-semibold">🚪 Salir</button>
      </div>
    </div>
  </aside>

  <main class="flex-1 p-6 overflow-auto">
    <section class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-200">
      <h2 class="text-2xl font-bold text-center mb-6">🧾 Configuración del Ticket</h2>

      <form id="ticketForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div><label class="block font-semibold mb-1">Nombre del negocio</label><input type="text" id="negocio" class="w-full p-2 border rounded" value="Ferretería Alfredo" /></div>
        <div><label class="block font-semibold mb-1">RFC</label><input type="text" id="rfc" class="w-full p-2 border rounded" value="XAXX010101000" /></div>
        <div><label class="block font-semibold mb-1">Dirección</label><input type="text" id="direccion" class="w-full p-2 border rounded" value="Av. Principal #123, Culiacán, Sinaloa" /></div>
        <div><label class="block font-semibold mb-1">Teléfono</label><input type="text" id="telefono" class="w-full p-2 border rounded" value="667 123 4567" /></div>
        <div class="md:col-span-2"><label class="block font-semibold mb-1">Leyenda/agradecimiento</label><input type="text" id="leyenda" class="w-full p-2 border rounded" value="¡Gracias por su compra!" /></div>
      </form>

      <div class="text-center mt-6 flex flex-col sm:flex-row justify-center gap-4">
        <button onclick="generarTicket()" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">🖨️ Vista Previa</button>
        <button onclick="guardarConfiguracion()" type="button" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold transition">💾 Guardar Configuración</button>
      </div>

      <div id="preview" class="mt-10 hidden">
        <div class="ticket-preview" id="ticketOutput"></div>
      </div>
    </section>
  </main>
</div>

<script>
  function centrar(texto, ancho = 32) {
    const espacios = Math.floor((ancho - texto.length) / 2);
    return ' '.repeat(Math.max(espacios, 0)) + texto;
  }

  function dividirTexto(texto, maxLen) {
    const palabras = texto.split(' ');
    const partes = [];
    let linea = '';

    for (let palabra of palabras) {
      if ((linea + palabra).length > maxLen) {
        partes.push(linea.trim());
        linea = palabra + ' ';
      } else {
        linea += palabra + ' ';
      }
    }
    if (linea.trim()) partes.push(linea.trim());
    return partes;
  }

  function generarTicket() {
    const negocio = document.getElementById('negocio').value.toUpperCase();
    const rfc = document.getElementById('rfc').value;
    const direccion = document.getElementById('direccion').value;
    const telefono = document.getElementById('telefono').value;
    const leyenda = document.getElementById('leyenda').value;

    const now = new Date();
    const folio = now.toISOString().replace(/[-:.TZ]/g, '').slice(0, 14);

    let contenido = [];
    contenido.push(centrar(negocio));
    contenido.push(centrar(`RFC: ${rfc}`));
    dividirTexto(direccion, 32).forEach(linea => contenido.push(centrar(linea)));
    contenido.push(centrar(`TEL: ${telefono}`));
    contenido.push('');
    contenido.push(centrar(`FECHA: ${now.toLocaleString()}`));
    contenido.push(centrar(`FOLIO: #${folio}`));
    contenido.push('');
    contenido.push(centrar("CANT  DESCRIPCIÓN        IMPORTE"));
    contenido.push(centrar("-------------------------------"));
    const productos = [
      { cant: '01', desc: 'MARTILLO', imp: '$150.00' },
      { cant: '02', desc: 'DESTORNILLADOR', imp: '$80.00' },
      { cant: '01', desc: 'CINTA MÉTRICA', imp: '$95.00' }
    ];
    productos.forEach(p => {
      const linea = `${p.cant.padEnd(5)}${p.desc.padEnd(20)}${p.imp.padStart(7)}`;
      contenido.push(centrar(linea));
    });
    contenido.push(centrar("-------------------------------"));
    contenido.push(centrar("SUBTOTAL:                 $325.00"));
    contenido.push(centrar("IVA:                       $52.00"));
    contenido.push(centrar("TOTAL:                    $377.00"));
    contenido.push('');
    contenido.push(centrar(leyenda));

    const output = document.getElementById('ticketOutput');
    output.innerHTML = '';
    const texto = document.createElement('pre');
    texto.textContent = contenido.join('\n');
    output.appendChild(texto);

    const divBarcode = document.createElement("div");
    divBarcode.classList.add("barcode-container");
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    JsBarcode(svg, folio, {
      format: "CODE128",
      width: 2,
      height: 40,
      displayValue: true,
      fontSize: 14
    });
    divBarcode.appendChild(svg);
    output.appendChild(divBarcode);

    document.getElementById('preview').classList.remove('hidden');
  }

  function guardarConfiguracion() {
    alert("✅ Configuración guardada (simulada).");
  }
</script>

</body>
</html>
