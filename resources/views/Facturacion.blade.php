@extends('layouts.app')

@section('title','Facturación')

@section('modulo','Módulo de Facturación')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

{{-- MENSAJES --}}
@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
{{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
<ul class="list-disc pl-5">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


{{-- BUSCAR VENTA --}}
<div class="bg-white border rounded-xl p-6 shadow-sm">

<form method="GET"
action="{{ route('facturacion.buscar') }}"
class="flex gap-4">

<input type="text"
name="folio"
placeholder="Buscar por folio de venta..."
class="flex-1 border rounded-lg px-4 py-2"
required>

<button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
Buscar
</button>

</form>

</div>


{{-- RESULTADO --}}
@isset($venta)

<div class="bg-white border rounded-xl p-6 shadow-sm space-y-8">

{{-- INFO VENTA --}}
<div>

<h3 class="font-semibold mb-4 text-gray-800">
Información de la Venta
</h3>

<div class="grid md:grid-cols-3 gap-6 text-sm">

<div>
<p class="text-gray-400">Folio</p>
<p class="font-semibold">{{ $venta->folio }}</p>
</div>

<div>
<p class="text-gray-400">Fecha</p>
<p class="font-semibold">{{ $venta->created_at }}</p>
</div>

<div>
<p class="text-gray-400">Total</p>
<p class="font-semibold text-green-600 text-lg">
${{ number_format($venta->total,2) }}
</p>
</div>

</div>

</div>


@if(!$venta->uuid_factura)

{{-- FORMULARIO FACTURA --}}
<div class="border-t pt-6 space-y-6">

<h3 class="text-lg font-semibold">
Datos para Facturación
</h3>

<form method="POST"
action="{{ route('facturacion.generar',$venta->id_venta) }}"
class="space-y-6">

@csrf


{{-- TIPO CLIENTE --}}
<div>

<label class="block text-sm text-gray-600 mb-2">
Tipo de cliente
</label>

<div class="flex gap-6">

<label class="flex items-center gap-2">
<input type="radio" name="tipo_cliente" value="registrado" checked>
Cliente registrado
</label>

<label class="flex items-center gap-2">
<input type="radio" name="tipo_cliente" value="publico">
Público en general
</label>

</div>

</div>


{{-- BUSCAR CLIENTE --}}
<div id="buscadorCliente" class="relative">

<label class="block text-sm text-gray-600 mb-2">
Buscar Cliente (RFC o Nombre)
</label>

<input type="text"
id="inputBusquedaCliente"
placeholder="Escribe RFC o nombre..."
class="w-full border rounded-xl px-4 py-3">

<div id="resultadoClientes"
class="absolute w-full bg-white border rounded-xl shadow mt-1 hidden z-50 max-h-60 overflow-y-auto">
</div>

</div>


{{-- GRID --}}
<div class="grid md:grid-cols-2 gap-6">


<div>
<label class="block text-sm text-gray-600 mb-1">RFC</label>

<input type="text"
name="rfc"
id="rfc"
class="w-full border rounded-xl px-4 py-2 uppercase"
required>
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Razón Social</label>

<input type="text"
name="razon_social"
id="razon_social"
class="w-full border rounded-xl px-4 py-2"
required>
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Código Postal</label>

<input type="text"
name="codigo_postal"
maxlength="5"
class="w-full border rounded-xl px-4 py-2"
required>
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Régimen Fiscal</label>

<select name="regimen_fiscal"
id="regimen_fiscal"
class="w-full border rounded-xl px-4 py-2"
required>

<option value="">Seleccionar</option>

@foreach($regimenes as $regimen)
<option value="{{ $regimen->id_regimen }}">
{{ $regimen->clave }} - {{ $regimen->descripcion }}
</option>
@endforeach

</select>

</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Uso CFDI</label>

<select id="uso_cfdi"
name="uso_cfdi"
class="w-full border rounded-xl px-4 py-2"
required>

<option value="">Seleccione régimen primero</option>

</select>
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Correo electrónico</label>

<input type="email"
name="email"
id="email"
placeholder="correo@cliente.com"
class="w-full border rounded-lg px-4 py-2">
</div>


<div class="flex items-center gap-2">
<input type="checkbox"
name="enviar_email"
value="1"
class="h-4 w-4">

<label class="text-sm text-gray-600">
Enviar factura al correo del cliente
</label>
</div>

</div>


<button
class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold">
Generar Factura
</button>

</form>

</div>

@endif

</div>

@endisset

</div>


<script>

/* =============================
   BUSCADOR CLIENTES
============================= */

const inputBusqueda=document.getElementById("inputBusquedaCliente");
const resultado=document.getElementById("resultadoClientes");

if(inputBusqueda){

inputBusqueda.addEventListener("keyup",function(){

let valor=this.value;

if(valor.length<2){
resultado.classList.add("hidden");
return;
}

fetch(`/clientes/buscar?buscar=${valor}`)
.then(res=>res.json())
.then(clientes=>{

resultado.innerHTML="";

clientes.forEach(cliente=>{

resultado.innerHTML+=`
<div class="p-3 hover:bg-gray-100 cursor-pointer border-b"
onclick="seleccionarCliente(
'${cliente.rfc}',
'${cliente.razon_social}',
'${cliente.codigo_postal}',
'${cliente.id_regimen}',
'${cliente.email}',
'${cliente.uso_cfdi}'
)">
<strong>${cliente.razon_social}</strong><br>
<span class="text-sm text-gray-500">${cliente.rfc}</span>
</div>
`;

});

resultado.classList.remove("hidden");

});

});

}


/* =============================
   SELECCIONAR CLIENTE
============================= */

function seleccionarCliente(rfc,razon,cp,regimen,email,uso_cfdi){

document.getElementById("rfc").value=rfc;
document.getElementById("razon_social").value=razon;
document.querySelector("input[name='codigo_postal']").value=cp;

if(email){
document.getElementById("email").value=email;
}

document.getElementById("regimen_fiscal").value=regimen;

cargarUsos(regimen,uso_cfdi);

resultado.classList.add("hidden");

}


/* =============================
   CARGAR USOS CFDI
============================= */

function cargarUsos(regimen,usoSeleccionado=null){

let selectUso=document.getElementById("uso_cfdi");

selectUso.innerHTML='<option>Cargando...</option>';

fetch(`/api/usos-cfdi/${regimen}`)
.then(res=>res.json())
.then(data=>{

selectUso.innerHTML='<option value="">Seleccione Uso CFDI</option>';

data.usos.forEach(uso=>{

let option=document.createElement("option");

option.value=uso.clave;
option.textContent=uso.clave+" - "+uso.descripcion;

selectUso.appendChild(option);

});

if(usoSeleccionado){
selectUso.value=usoSeleccionado;
}

});

}

document.getElementById("regimen_fiscal").addEventListener("change",function(){
cargarUsos(this.value);
});


/* =============================
   PUBLICO EN GENERAL
============================= */

const radiosTipoCliente=document.querySelectorAll("input[name='tipo_cliente']");
const buscadorCliente=document.getElementById("buscadorCliente");

radiosTipoCliente.forEach(radio=>{

radio.addEventListener("change",function(){

if(this.value==="publico"){

buscadorCliente.style.display="none";

fetch('/clientes/buscar?buscar=XAXX010101000')
.then(res=>res.json())
.then(clientes=>{

let cliente=clientes[0];

seleccionarCliente(
cliente.rfc,
cliente.razon_social,
cliente.codigo_postal,
cliente.id_regimen,
cliente.email,
cliente.uso_cfdi
);

});

}else{

buscadorCliente.style.display="block";

document.getElementById("rfc").value="";
document.getElementById("razon_social").value="";
document.querySelector("input[name='codigo_postal']").value="";
document.getElementById("regimen_fiscal").value="";
document.getElementById("uso_cfdi").innerHTML='<option value="">Seleccione régimen primero</option>';

}

});

});

</script>

@endsection