@extends('layouts.app')

@section('title','Venta')
@section('modulo','Punto de Venta')

@section('content')

<div class="flex flex-col h-full">




<!-- ===================== CONTENIDO ===================== -->


<!-- HEADER -->


<!-- ===================== CARDS ===================== -->
<div class="bg-white border rounded-xl px-6 py-4 mb-6">

<div class="grid grid-cols-4 gap-6 text-sm">

    <!-- Ventas -->
    <div class="flex flex-col">
        <span class="text-gray-400 uppercase text-xs tracking-wide">
            Ventas Hoy
        </span>
        <span id="ventasHoy"
              class="text-xl font-semibold text-gray-900">
            $0.00
        </span>
    </div>

    <!-- Productos -->
    <div class="flex flex-col border-l pl-6">
        <span class="text-gray-400 uppercase text-xs tracking-wide">
            Productos Vendidos
        </span>
        <span id="productosVendidos"
              class="text-xl font-semibold text-gray-900">
            0
        </span>
    </div>

    <!-- Tickets -->
    <div class="flex flex-col border-l pl-6">
        <span class="text-gray-400 uppercase text-xs tracking-wide">
            Tickets
        </span>
        <span id="ticketsGenerados"
              class="text-xl font-semibold text-gray-900">
            0
        </span>
    </div>

    <!-- En espera -->
    <div class="flex flex-col border-l pl-6">
        <span class="text-gray-400 uppercase text-xs tracking-wide">
            En Espera
        </span>
        <span id="ventasEnEspera"
              class="text-xl font-semibold text-gray-900">
            0
        </span>
    </div>

</div>

</div>


<!-- ===================== PRODUCTOS + CARRITO ===================== -->
<div class="grid grid-cols-12 gap-6 flex-1 min-h-0">

<!-- PRODUCTOS -->
<section class="col-span-8 bg-white rounded-2xl shadow-sm border p-6 flex flex-col min-h-0">

<input type="text" id="buscador"
placeholder="Buscar producto..."
oninput="filtrarProductos()"
class="w-full border rounded-xl px-5 py-3 mb-4 focus:ring-2 focus:ring-yellow-400">



<!-- CATEGORIAS -->
<div class="relative mb-4">

<button onclick="scrollCategorias(-200)"
class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow px-2 py-1 rounded-full z-10">‹</button>

<div id="contenedorCategorias"
class="flex gap-3 overflow-x-auto no-scrollbar scroll-smooth px-8">

<button onclick="filtrarCategoria('todos',this)"
class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold whitespace-nowrap">
Todos
</button>

@foreach($categorias as $categoria)
@if($productos->where('categoria',$categoria->id_categoria)->count() > 0)
<button onclick="filtrarCategoria('{{ $categoria->id_categoria }}',this)"
class="px-4 py-2 bg-gray-200 rounded-lg whitespace-nowrap hover:bg-gray-300 transition">
{{ $categoria->nombre }}
</button>
@endif
@endforeach

</div>

<button onclick="scrollCategorias(200)"
class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow px-2 py-1 rounded-full z-10">›</button>
</div>

<div id="listaProductos"
class="grid grid-cols-3 gap-5 overflow-y-auto flex-1 min-h-0"></div>

<div id="paginacion"
class="flex justify-center gap-2 mt-4"></div>

</section>

<!-- CARRITO -->
<aside class="col-span-4 bg-white rounded-2xl shadow-sm border p-6 flex flex-col min-h-0">

<h3 class="text-lg font-bold mb-4">Carrito de Venta</h3>

<div id="listaCarrito"
class="flex-1 space-y-3 overflow-y-auto min-h-0"></div>

<div class="border-t pt-4 mt-4 space-y-2">
<div class="flex justify-between text-sm">
<span>Subtotal</span>
<span id="subtotal">$0.00</span>
</div>
<div class="flex justify-between text-sm">
<span>IVA {{$porcentajeIVA}}%</span>
<span id="iva">$0.00</span>
</div>
<div class="flex justify-between font-bold text-lg pt-2 border-t">
<span>Total</span>
<span id="total" class="text-green-600">$0.00</span>
</div>

<button onclick="realizarCobro()"
class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-semibold mt-2">
Cobrar
</button>

<button onclick="ponerEnEspera()"
class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold mt-2">
Poner en Espera
</button>

<button onclick="CancelarVenta()"
class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold mt-2">
Cancelar Venta
</button>
</div>
</aside>

</div>
</div>

<script>
const productos=@json($productos);
let carrito=[];
let productosFiltrados=[...productos];
let paginaActual=1;
let categoriaActual="todos";
const porPagina=6;

/* ================= FILTROS ================= */

function filtrarCategoria(cat,btn){
categoriaActual=cat;
document.querySelectorAll("#contenedorCategorias button").forEach(b=>{
b.classList.remove("bg-yellow-100","text-yellow-700","font-semibold");
});
btn.classList.add("bg-yellow-100","text-yellow-700","font-semibold");
filtrarProductos();
}

function filtrarProductos(){
let texto=document.getElementById("buscador").value.toLowerCase();
productosFiltrados=productos.filter(p=>{
return p.nombre.toLowerCase().includes(texto) &&
(categoriaActual==="todos"||p.categoria==categoriaActual);
});
paginaActual=1;
renderProductos();
}

/* ================= PRODUCTOS ================= */

function renderProductos(){
let cont=document.getElementById("listaProductos");
cont.innerHTML="";
let inicio=(paginaActual-1)*porPagina;
let fin=inicio+porPagina;
let lista=productosFiltrados.slice(inicio,fin);

lista.forEach(p=>{

let imagenHTML = p.imagen
? `
<div class="w-full h-36 bg-white rounded-xl mb-3 flex items-center justify-center overflow-hidden border">
    <img src="/storage/${p.imagen}"
         class="max-h-full max-w-full object-contain transition-transform duration-200 hover:scale-105"
         onerror="this.src='https://via.placeholder.com/150?text=Sin+Imagen'">
</div>
`
: `
<div class="w-full h-36 flex items-center justify-center bg-gray-100 rounded-xl mb-3 text-gray-400 border">
    Sin imagen
</div>
`;
cont.innerHTML+=`
<div class="bg-gray-50 p-5 rounded-xl border hover:shadow-md transition flex flex-col">

${imagenHTML}

<h3 class="font-semibold">${p.nombre}</h3>
<p class="text-yellow-600 font-bold">$${parseFloat(p.precio).toFixed(2)}</p>
<p class="text-sm text-gray-500">Stock: ${p.stock}</p>

<button onclick="agregarProducto(${p.id})"
class="w-full bg-blue-600 text-white py-2 rounded-lg mt-2">
Agregar
</button>

</div>`;
});

renderPaginacion();
}

function renderPaginacion(){
let totalPaginas=Math.ceil(productosFiltrados.length/porPagina);
let pag=document.getElementById("paginacion");
pag.innerHTML="";
for(let i=1;i<=totalPaginas;i++){
pag.innerHTML+=`
<button onclick="paginaActual=${i};renderProductos();"
class="px-3 py-1 rounded ${i===paginaActual?'bg-yellow-500 text-white':'bg-gray-200'}">
${i}
</button>`;
}
}

/* ================= CARRITO ================= */

function agregarProducto(id){
let producto=productos.find(p=>p.id==id);
let ex=carrito.find(p=>p.id==id);
if(ex){ex.cantidad++;}
else{
  carrito.push({
    id: producto.id,
    nombre: producto.nombre,
    precio_base: parseFloat(producto.precio_base),
    precio_venta: parseFloat(producto.precio),
    cantidad: 1,
    unidad:producto.unidad
});
}
renderCarrito();
actualizarMetricas();
}

function renderCarrito(){
let cont=document.getElementById("listaCarrito");
cont.innerHTML="";

if(carrito.length===0){
cont.innerHTML=`<div class="flex items-center justify-center h-full text-gray-400">🛒 No hay productos en el carrito</div>`;
actualizarMetricas();
return;
}

let subtotal=0;

carrito.forEach(p=>{
subtotal+=p.precio_base*p.cantidad;
cont.innerHTML+=`
<div class="bg-gray-50 p-4 rounded-xl shadow-sm border">
<div class="flex justify-between">
<div>
<p class="font-semibold">${p.nombre}
<span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full ml-2">
x${p.cantidad}</span>
</p>
<p class="text-xs text-gray-500">$${p.precio_venta} c/${p.unidad}</p>
</div>
<p class="font-bold">$${(p.precio_venta*p.cantidad).toFixed(2)}</p>
</div>
</div>`;
});

let iva=subtotal*({{$porcentajeIVA}}/100);
let total=subtotal+iva;

document.getElementById("subtotal").innerText="$"+subtotal.toFixed(2);
document.getElementById("iva").innerText="$"+iva.toFixed(2);
document.getElementById("total").innerText="$"+total.toFixed(2);

actualizarMetricas();
}

function actualizarMetricas(){
let subtotal=0;
let cantidad=0;
carrito.forEach(p=>{
subtotal+=p.precio*p.cantidad;
cantidad+=p.cantidad;
});

}

function scrollCategorias(valor){
document.getElementById("contenedorCategorias").scrollLeft+=valor;
}

function ponerEnEspera(){
alert("Venta puesta en espera (pendiente implementar backend)");
}

/* ================= FUNCIONALIDAD BOTONES ================= */

let contadorEspera = 0;
/* ================= FLUJO CORRECTO DE COBRO ================= */

function realizarCobro(){

renderMetodosPago();

    if(carrito.length === 0){
        alert("Carrito vacío");
        return;
    }

    document.getElementById("totalModal").innerText =
        document.getElementById("total").innerText;

    let modal = document.getElementById("modalPago");
    let contenedor = document.getElementById("contenedorModal");

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    setTimeout(()=>{
        contenedor.classList.remove("scale-95","opacity-0");
        contenedor.classList.add("scale-100","opacity-100");
    },10);
}

function realizarCobroFinal(){

    let metodoSeleccionado = document.querySelector(
        'input[name="metodoPago"]:checked'
    );

    if(!metodoSeleccionado){
        alert("Seleccione método de pago");
        return;
    }

    let metodo = metodoSeleccionado.value;
    let total = parseFloat(
        document.getElementById("total").innerText.replace('$','')
    );

    if(metodo === "efectivo"){

        let recibido = parseFloat(
            document.getElementById("montoRecibido").value
        );

        if(isNaN(recibido)){
            alert("Ingrese con cuánto paga");
            return;
        }

        if(recibido < total){
            alert("Monto insuficiente");
            return;
        }

        let cambio = recibido - total;

        document.getElementById("cambioCalculado")
            .innerText = "$"+cambio.toFixed(2);

        guardarVenta("efectivo");
    }

    if(metodo === "tarjeta"){

        document.getElementById("seccionTarjeta")
            .classList.remove("hidden");

        document.getElementById("mensajeTerminal")
            .innerText = "Conectando a la terminal...";

        // Animación simulada
        setTimeout(()=>{

            let aprobado = Math.random() < 0.7;

            if(aprobado){

                document.getElementById("mensajeTerminal")
                    .innerText = "Pago aprobado ✅";

                setTimeout(()=>{
                    guardarVenta("tarjeta");
                },800);

            } else {

                document.getElementById("mensajeTerminal")
                    .innerText = "Ocurrió un error ❌";

                alert("Pago rechazado. Puede intentar nuevamente o cambiar método.");

            }

        },2000);
    }
}

function guardarVenta(metodo){

    let totalVenta = parseFloat(
        document.getElementById("total").innerText.replace('$','')
    );

    let cantidadVendida = carrito.reduce((acc,p)=>acc+p.cantidad,0);

    fetch('/venta/guardar',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            metodo_pago: metodo,
            productos: carrito
        })
    })
    .then(res=>res.json())
    .then(data=>{

        if(data.error){
            alert(data.error);
            return;
        }

        actualizarCards(totalVenta, cantidadVendida);

        carrito = [];
        renderCarrito();
        cerrarModalPago();

        alert("Venta realizada correctamente");
    });
}

function cerrarModalPago(){
    document.getElementById("modalPago").classList.add("hidden");
    document.getElementById("seccionEfectivo").classList.add("hidden");
    document.getElementById("seccionTarjeta").classList.add("hidden");
    document.getElementById("montoRecibido").value="";
    document.getElementById("cambioCalculado").innerText="$0.00";

    document.querySelectorAll('input[name="metodoPago"]').forEach(r=>r.checked=false);
}
document.addEventListener("input", function(e){
    if(e.target.id === "montoRecibido"){
        calcularCambio();
    }
});

function calcularCambio(){

    let total = parseFloat(
        document.getElementById("total").innerText.replace('$','')
    );

    let recibido = parseFloat(
        document.getElementById("montoRecibido").value
    );

    let cambioElemento = document.getElementById("cambioCalculado");
    let boton = document.getElementById("btnFinalizar");

    if(isNaN(recibido)){
        cambioElemento.innerText = "$0.00";
        boton.disabled = true;
        boton.classList.add("opacity-50","cursor-not-allowed");
        return;
    }

    let cambio = recibido - total;

    if(cambio < 0){
        cambioElemento.innerText =
            "Faltan $" + Math.abs(cambio).toFixed(2);
        cambioElemento.classList.remove("text-green-600");
        cambioElemento.classList.add("text-red-600");

        boton.disabled = true;
        boton.classList.add("opacity-50","cursor-not-allowed");

    } else {
        cambioElemento.innerText =
            "$" + cambio.toFixed(2);
        cambioElemento.classList.remove("text-red-600");
        cambioElemento.classList.add("text-green-600");

        boton.disabled = false;
        boton.classList.remove("opacity-50","cursor-not-allowed");
    }
}
function agregarMonto(valor){
    document.getElementById("montoRecibido").value = valor;
    calcularCambio();
}

function pagarTarjeta(idTipoPago){

    document.getElementById("seleccionMetodo").classList.add("hidden");
    document.getElementById("seccionTarjeta").classList.remove("hidden");

    setTimeout(()=>{

        let aprobado = Math.random() < 0.75;

        if(aprobado){

            document.getElementById("spinnerTerminal").classList.add("hidden");
            document.getElementById("mensajeTerminal").innerText = "Pago aprobado ✅";

            setTimeout(()=>{
                procesarVenta(idTipoPago); // 👈 USAMOS EL ID DIRECTO
            },800);

        } else {

            document.getElementById("spinnerTerminal").classList.add("hidden");
            document.getElementById("mensajeTerminal").innerText = "Transacción rechazada ❌";

            setTimeout(()=>{
                cerrarModalPago();
            },1500);
        }

    },2000);
}

function pagarEfectivo(){
    document.getElementById("seleccionMetodo").classList.add("hidden");
    document.getElementById("seccionEfectivo").classList.remove("hidden");
}

function finalizarEfectivo(){

    let total = parseFloat(
        document.getElementById("total").innerText.replace('$','')
    );

    let recibido = parseFloat(
        document.getElementById("montoRecibido").value
    );

    if(isNaN(recibido) || recibido < total){
        alert("Monto insuficiente");
        return;
    }

    procesarVenta(metodoSeleccionadoId); // 👈 O pásalo como parámetro también

}

let procesandoVenta = false;

function procesarVenta(idTipoPago){
    

    // 🔒 Evitar doble envío
    if(procesandoVenta){
        return;
    }

    // 🛒 Validar carrito
    if(carrito.length === 0){
        alert("El carrito está vacío");
        return;
    }

    // 💳 Validar método de pago
    if(!idTipoPago){
        alert("Método de pago inválido");
        return;
    }

    procesandoVenta = true;

    // 🔐 Deshabilitar botón si existe
    let btn = document.getElementById("btnFinalizar");
    if(btn){
        btn.disabled = true;
        btn.classList.add("opacity-50","cursor-not-allowed");
    }

    let productosEnviar = carrito.map(item => ({
        id: item.id,
        cantidad: item.cantidad
    }));

    fetch('/venta/guardar',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json'
        },
        body: JSON.stringify({
            id_tipo_pago: idTipoPago,
            productos: productosEnviar
        })
    })
    .then(async res => {

        let data;

        try {
            data = await res.json();
        } catch(e){
            throw { error: "Respuesta inválida del servidor" };
        }

        if(!res.ok){
            throw data;
        }

        return data;
    })
    .then(data => {

        // 💰 Calcular métricas antes de limpiar
        let totalVenta = parseFloat(
            document.getElementById("total").innerText.replace('$','')
        );

        let cantidadVendida = carrito.reduce((acc,p)=>acc+p.cantidad,0);

        actualizarCards(totalVenta, cantidadVendida);

        // 🧹 Limpiar carrito
        carrito = [];
        renderCarrito();

        cerrarModalPago();

        alert("Venta guardada correctamente");
        reiniciarVenta();


    })
    .catch(error => {

        console.error("Error real:", error);

        alert(error.error || "Error al procesar la venta");

    })
    .finally(() => {

        procesandoVenta = false;

        if(btn){
            btn.disabled = false;
            btn.classList.remove("opacity-50","cursor-not-allowed");
        }

    });
}
function ponerEnEspera(){

    if(carrito.length === 0){
        alert("Carrito vacío");
        return;
    }

    contadorEspera++;

    document.getElementById("ventasEnEspera").innerText = contadorEspera;

    carrito = [];
    renderCarrito();
}

function CancelarVenta(){

    if(carrito.length === 0){
        alert("No hay venta activa");
        return;
    }

    if(!confirm("¿Seguro que deseas cancelar la venta?")){
        return;
    }

    carrito = [];
    renderCarrito();
}


/* ================= ACTUALIZAR CARDS ================= */

function actualizarCards(totalVenta, cantidadVendida){

    let ventasHoy = parseFloat(
        document.getElementById("ventasHoy").innerText.replace('$','')
    );

    let productosVendidos = parseInt(
        document.getElementById("productosVendidos").innerText
    );

    let tickets = parseInt(
        document.getElementById("ticketsGenerados").innerText
    );

    ventasHoy += totalVenta;
    productosVendidos += cantidadVendida;
    tickets += 1;

    document.getElementById("ventasHoy").innerText = "$"+ventasHoy.toFixed(2);
    document.getElementById("productosVendidos").innerText = productosVendidos;
    document.getElementById("ticketsGenerados").innerText = tickets;
}

document.addEventListener("change", function(e){

    if(e.target.name === "metodoPago"){

        // Ocultar ambas secciones primero
        document.getElementById("seccionEfectivo").classList.add("hidden");
        document.getElementById("seccionTarjeta").classList.add("hidden");

        // Mostrar según selección
        if(e.target.value === "efectivo"){
            document.getElementById("seccionEfectivo")
                .classList.remove("hidden");
        }

        if(e.target.value === "tarjeta"){
            document.getElementById("seccionTarjeta")
                .classList.remove("hidden");
        }
    }

});









renderProductos();
renderCarrito();


const tiposPago = @json($tiposPago);


function renderMetodosPago(){

    let contenedor = document.getElementById("seleccionMetodo");
    contenedor.innerHTML = "";

    tiposPago.forEach(tipo => {

        let icono = "💳";

        if(tipo.nombre.toLowerCase().includes("efectivo")){
            icono = "💵";
        }

        contenedor.innerHTML += `
        <div onclick="seleccionarMetodo(${tipo.id_tipo_pago}, '${tipo.nombre}')"
        class="cursor-pointer border-2 border-gray-200 rounded-2xl p-6 flex flex-col items-center gap-3 hover:border-blue-500 hover:shadow-xl transition">

            <div class="text-5xl">${icono}</div>
            <p class="font-semibold text-gray-700">${tipo.nombre}</p>

        </div>
        `;
    });
}

let metodoSeleccionadoId = null;
let metodoSeleccionadoNombre = null;
function seleccionarMetodo(id, nombre){

    metodoSeleccionadoId = id; // guardamos por seguridad

    document.getElementById("seleccionMetodo").classList.add("hidden");

    if(nombre.toLowerCase().includes("efectivo")){
        pagarEfectivo(id); // 👈 PASAMOS EL ID
    }

    if(nombre.toLowerCase().includes("tarjeta")){
        pagarTarjeta(id); // 👈 PASAMOS EL ID
    }
}


/* ================= DETECTOR SCANNER PROFESIONAL ================= */

let scannerBuffer = "";
let lastKeyTime = 0;
let scannerTimer = null;

// velocidad máxima entre teclas (scanner = rapidísimo)
const SCANNER_SPEED = 50; // ms

document.addEventListener("keydown", function(e){

    // ignorar teclas especiales
    if(e.key.length > 1 && e.key !== "Enter") return;

    const now = Date.now();
    const timeDiff = now - lastKeyTime;
    lastKeyTime = now;

    // si tarda mucho → es humano → reiniciar buffer
    if(timeDiff > SCANNER_SPEED){
        scannerBuffer = "";
    }

    // ENTER normalmente finaliza lectura
    if(e.key === "Enter"){
        if(scannerBuffer.length >= 6){
            procesarCodigoScanner(scannerBuffer);
        }
        scannerBuffer = "";
        return;
    }

    scannerBuffer += e.key;

    clearTimeout(scannerTimer);

    // fallback por si el scanner no manda ENTER
    scannerTimer = setTimeout(()=>{
        if(scannerBuffer.length >= 6){
            procesarCodigoScanner(scannerBuffer);
        }
        scannerBuffer = "";
    }, 80);

});

function procesarCodigoScanner(codigo){

    // 🔥 limpieza completa estilo POS real
    codigo = codigo
        .replace(/\r/g,'')
        .replace(/\n/g,'')
        .replace(/\s/g,'').trim();

    console.log("CODIGO LIMPIO:", codigo);

    let producto = productos.find(p =>
        String(p.codigo).trim() === codigo
    );

    if(producto){

        agregarProducto(producto.id);
        mostrarFeedbackScanner(true, producto.nombre);

    }else{
        mostrarFeedbackScanner(false, codigo);
    }
}
function mostrarFeedbackScanner(exito, texto){

    const aviso = document.getElementById("scannerFeedback");

    // 🔥 reset total para permitir múltiples ejecuciones
    aviso.style.opacity = "0";
    aviso.style.transform = "translateY(-10px)";

    // forzar reflow (truco profesional)
    aviso.offsetHeight;

    if(exito){
        aviso.className =
        "fixed top-6 right-6 px-6 py-3 rounded-lg shadow-lg text-white font-semibold bg-green-600 transition-all duration-300 z-50";
        aviso.innerText = "✔ Agregado: " + texto;
    }else{
        aviso.className =
        "fixed top-6 right-6 px-6 py-3 rounded-lg shadow-lg text-white font-semibold bg-red-600 transition-all duration-300 z-50";
        aviso.innerText = "✖ No se encontró el producto";
    }

    // mostrar
    aviso.style.opacity = "1";
    aviso.style.transform = "translateY(0)";

    // ocultar después
    setTimeout(()=>{
        aviso.style.opacity = "0";
        aviso.style.transform = "translateY(-10px)";
    },1500);
}

function reiniciarVenta(){

    /* ================= LIMPIAR CARRITO ================= */
    carrito = [];
    renderCarrito();

    /* ================= REINICIAR TOTALES ================= */
    document.getElementById("subtotal").innerText = "$0.00";
    document.getElementById("iva").innerText = "$0.00";
    document.getElementById("total").innerText = "$0.00";

    /* ================= LIMPIAR MODAL ================= */
    document.getElementById("montoRecibido").value = "";
    document.getElementById("cambioCalculado").innerText = "$0.00";

    document.getElementById("seccionEfectivo").classList.add("hidden");
    document.getElementById("seccionTarjeta").classList.add("hidden");

    document.querySelectorAll('input[name="metodoPago"]')
        .forEach(r => r.checked = false);

    /* ================= LIMPIAR SCANNER ================= */
    scannerBuffer = "";

    /* ================= CERRAR MODAL ================= */
    cerrarModalPago();

}
/* ===== SIMULADOR DE LECTOR ===== */

function simularScanner(codigo = "7501031311309") {

    let i = 0;

    const intervalo = setInterval(() => {

        if(i < codigo.length){

            document.dispatchEvent(
                new KeyboardEvent("keydown", {
                    key: codigo[i]
                })
            );

            i++;

        } else {

            document.dispatchEvent(
                new KeyboardEvent("keydown", {
                    key: "Enter"
                })
            );

            clearInterval(intervalo);
        }

    }, 10); // velocidad scanner real
}

</script>


<div id="scannerFeedback"
class="fixed top-6 right-6 px-6 py-3 rounded-lg shadow-lg
text-white font-semibold opacity-0 pointer-events-none
transition-all duration-300 z-50">
</div>
<!-- ================= MODAL METODO DE PAGO ================= -->
<!-- ================= MODAL COBRO PRO ================= -->
<div id="modalPago"
class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden items-center justify-center z-50">

<div id="contenedorModal"
class="bg-white w-[520px] p-8 rounded-3xl shadow-2xl scale-95 opacity-0 transition-all duration-300">

<h3 class="text-center text-gray-400 text-xs tracking-widest uppercase">
Total a pagar
</h3>

<p id="totalModal"
class="text-center text-5xl font-extrabold text-green-600 my-4 tracking-tight">
$0.00
</p>

<!-- ================= SELECCION METODO ================= -->
<div id="seleccionMetodo"
class="grid grid-cols-2 gap-6 mt-6">
</div>

<!-- ================= EFECTIVO ================= -->
<div id="seccionEfectivo" class="hidden mt-8 space-y-4">

<input type="number"
id="montoRecibido"
placeholder="¿Con cuánto paga?"
class="w-full border-2 border-gray-200 focus:border-green-500 rounded-xl px-4 py-3 text-lg outline-none transition">

<!-- Botones rápidos -->
<div class="flex gap-3">
<button onclick="agregarMonto(100)" class="flex-1 bg-gray-100 hover:bg-gray-200 rounded-lg py-2">$100</button>
<button onclick="agregarMonto(200)" class="flex-1 bg-gray-100 hover:bg-gray-200 rounded-lg py-2">$200</button>
<button onclick="agregarMonto(500)" class="flex-1 bg-gray-100 hover:bg-gray-200 rounded-lg py-2">$500</button>
</div>

<div class="flex justify-between text-lg">
<span class="text-gray-500">Cambio:</span>
<span id="cambioCalculado"
class="font-bold text-green-600">$0.00</span>
</div>

<button id="btnFinalizar"
onclick="finalizarEfectivo()"
disabled
class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold mt-4 opacity-50 cursor-not-allowed transition">
Finalizar Cobro
</button>

</div>

<!-- ================= TARJETA ================= -->
<div id="seccionTarjeta"
class="hidden mt-8 flex flex-col items-center gap-4">

<div id="spinnerTerminal"
class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>

<p id="mensajeTerminal"
class="text-gray-600 font-medium">
Conectando a la terminal...
</p>

</div>

<button onclick="cerrarModalPago()"
class="w-full bg-gray-100 hover:bg-gray-200 py-2 rounded-xl mt-8 transition">
Cancelar
</button>

</div>
</div>
</div>
</div>
@endsection