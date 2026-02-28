<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ferretería POS Premium</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
.no-scrollbar::-webkit-scrollbar{display:none;}
.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
</style>

</head>

<body class="bg-gray-50 text-gray-800 font-sans">

<div class="flex h-screen overflow-hidden">

<!-- ===================== SIDEBAR ===================== -->
<aside class="w-64 bg-white border-r shadow-sm flex flex-col">

<div class="p-5 border-b">
<h1 class="text-lg font-bold text-gray-800">Ferretería POS</h1>
<p class="text-sm text-gray-500">
Sucursal {{ auth()->user()->sucursal->nombre ?? 'Centro' }}
</p>
</div>

<nav class="p-4 space-y-2 text-sm flex-1 overflow-y-auto">
<a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-gray-100">📊 Dashboard</a>
<a href="/venta" class="block px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">🏪 Venta</a>
<p class="px-4 py-2 text-gray-400 uppercase text-xs">Gestión</p>
<a href="/productos" class="block px-4 py-2 rounded-lg hover:bg-gray-100">📦 Productos</a>
<a href="/clientes" class="block px-4 py-2 rounded-lg hover:bg-gray-100">👥 Clientes</a>
<a href="/usuarios" class="block px-4 py-2 rounded-lg hover:bg-gray-100">👤 Usuarios</a>
</nav>
</aside>

<!-- ===================== CONTENIDO ===================== -->
<div class="flex-1 flex flex-col min-h-0">

<!-- HEADER -->
<header class="bg-white border-b px-8 py-4 shadow-sm">
<h2 class="text-xl font-bold">Punto de Venta</h2>
<div class="flex gap-4 mt-2 text-sm">
<div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl">
🖥 Caja {{ $cajaAbierta->id ?? '01' }}
</div>
<div class="bg-green-50 text-green-700 px-4 py-2 rounded-xl">
👤 {{ auth()->user()->nombre_completo }}
</div>
</div>
</header>

<!-- ===================== CARDS ===================== -->
<div class="grid grid-cols-4 gap-6 p-6">
<div class="bg-blue-600 text-white p-6 rounded-2xl shadow">
<p class="text-sm opacity-80">Ventas Hoy</p>
<h3 id="ventasHoy" class="text-xl font-bold">$0.00</h3>
</div>

<div class="bg-green-600 text-white p-6 rounded-2xl shadow">
<p class="text-sm opacity-80">Productos Vendidos</p>
<h3 id="productosVendidos" class="text-xl font-bold">0</h3>
</div>

<div class="bg-purple-600 text-white p-6 rounded-2xl shadow">
<p class="text-sm opacity-80">Tickets Generados</p>
<h3 id="ticketsGenerados" class="text-xl font-bold">0</h3>
</div>

<div class="bg-yellow-500 text-white p-6 rounded-2xl shadow">
<p class="text-sm opacity-80">En Espera</p>
<h3 class="text-xl font-bold">0</h3>
</div>
</div>

<!-- ===================== PRODUCTOS + CARRITO ===================== -->
<div class="grid grid-cols-12 gap-6 px-6 pb-6 flex-1 min-h-0">

<!-- PRODUCTOS -->
<section class="col-span-8 bg-white rounded-2xl shadow-sm border p-6 flex flex-col min-h-0">

<input type="text" id="buscador"
placeholder="Buscar producto..."
oninput="filtrarProductos()"
class="w-full border rounded-xl px-5 py-3 mb-4 focus:ring-2 focus:ring-yellow-400">

<!-- CATEGORIAS DINÁMICAS -->
<div class="relative mb-4">

<button onclick="scrollCategorias(-200)"
class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow px-2 py-1 rounded-full z-10">
‹
</button>

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
class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow px-2 py-1 rounded-full z-10">
›
</button>

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
<span>IVA (16%)</span>
<span id="iva">$0.00</span>
</div>
<div class="flex justify-between font-bold text-lg pt-2 border-t">
<span>Total</span>
<span id="total" class="text-green-600">$0.00</span>
</div>

<button onclick="ponerEnEspera()"
class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold mt-2">
Poner en Espera
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
(categoriaActual==="todos"||p.id_categoria==categoriaActual);
});
paginaActual=1;
renderProductos();
actualizarMetricas();
}

function renderProductos(){
let cont=document.getElementById("listaProductos");
cont.innerHTML="";
let inicio=(paginaActual-1)*porPagina;
let fin=inicio+porPagina;
let lista=productosFiltrados.slice(inicio,fin);

lista.forEach(p=>{
cont.innerHTML+=`
<div class="bg-gray-50 p-5 rounded-xl border hover:shadow-md transition">
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

function agregarProducto(id){
let producto=productos.find(p=>p.id==id);
let ex=carrito.find(p=>p.id==id);
if(ex){ex.cantidad++;}
else{carrito.push({id:producto.id,nombre:producto.nombre,precio:parseFloat(producto.precio),cantidad:1});}
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
subtotal+=p.precio*p.cantidad;
cont.innerHTML+=`
<div class="bg-gray-50 p-4 rounded-xl shadow-sm border">
<div class="flex justify-between">
<div>
<p class="font-semibold">${p.nombre}
<span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full ml-2">
x${p.cantidad}</span>
</p>
<p class="text-xs text-gray-500">$${p.precio} c/u</p>
</div>
<p class="font-bold">$${(p.precio*p.cantidad).toFixed(2)}</p>
</div>
</div>`;
});
let iva=subtotal*0.16;
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
document.getElementById("ventasHoy").innerText="$"+subtotal.toFixed(2);
document.getElementById("productosVendidos").innerText=cantidad;
document.getElementById("ticketsGenerados").innerText=carrito.length>0?1:0;
}

function scrollCategorias(valor){
document.getElementById("contenedorCategorias").scrollLeft+=valor;
}

renderProductos();
renderCarrito();
</script>

</body>
</html>