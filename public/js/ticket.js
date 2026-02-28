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

function generarTicketDesdeVenta(config, productos) {
  const now = new Date();
  const folio = now.toISOString().replace(/[-:.TZ]/g, '').slice(0, 14);
  let contenido = [];

  contenido.push(centrar(config.negocio.toUpperCase()));
  contenido.push(centrar(`RFC: ${config.rfc}`));
  dividirTexto(config.direccion, 32).forEach(linea => contenido.push(centrar(linea)));
  contenido.push(centrar(`TEL: ${config.telefono}`));
  contenido.push('');
  contenido.push(centrar(`FECHA: ${now.toLocaleString()}`));
  contenido.push(centrar(`FOLIO: #${folio}`));
  contenido.push('');
  contenido.push(centrar("CANT  DESCRIPCIÓN        IMPORTE"));
  contenido.push(centrar("-------------------------------"));

  productos.forEach(p => {
    const linea = `${p.cant.padEnd(5)}${p.desc.padEnd(20)}${p.imp.padStart(7)}`;
    contenido.push(centrar(linea));
  });

  contenido.push(centrar("-------------------------------"));
  contenido.push(centrar(`SUBTOTAL:         ${config.subtotal || '$0.00'}`));
  contenido.push(centrar(`IVA:              ${config.iva || '$0.00'}`));
  contenido.push(centrar(`TOTAL:            ${config.total || '$0.00'}`));
  contenido.push('');
  contenido.push(centrar(config.leyenda || '¡Gracias por su compra!'));

  const container = document.getElementById('ticketOutput');
  container.innerHTML = '';
  const texto = document.createElement('pre');
  texto.textContent = contenido.join('\n');
  container.appendChild(texto);

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
  container.appendChild(divBarcode);
}
