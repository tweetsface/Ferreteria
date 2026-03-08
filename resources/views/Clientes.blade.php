@extends('layouts.app')

@section('title','Clientes')

@section('modulo','Gestión de Clientes')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

{{-- MENSAJES --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded-lg">
{{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded-lg">
<ul class="list-disc pl-5">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


{{-- ================= FORMULARIO CREAR ================= --}}
<form method="POST"  id="formCliente"
action="{{ route('cliente.store') }}"
class="bg-white p-6 rounded-xl shadow border grid grid-cols-1 md:grid-cols-2 gap-6">

@csrf

<input type="text" name="nombre" placeholder="Nombre"
class="border rounded px-3 py-2 w-full">
<p class="text-red-500 text-xs mt-1 hidden" id="error_nombre"></p>

<input type="text" name="apellidos" placeholder="Apellidos"
class="border rounded px-3 py-2 w-full">
<p class="text-red-500 text-xs mt-1 hidden" id="error_apellidos"></p>

<input type="text" name="telefono" placeholder="Teléfono"
class="border rounded px-3 py-2 w-full">
<p class="text-red-500 text-xs mt-1 hidden" id="error_telefono"></p>

<input type="email" name="email" placeholder="Email"
class="border rounded px-3 py-2 w-full">
<p class="text-red-500 text-xs mt-1 hidden" id="error_email"></p>

<input type="text" name="direccion" placeholder="Dirección"
class="border rounded px-3 py-2">
<p class="text-red-500 text-xs mt-1 hidden" id="error_direccion"></p>

<select id="tipo_persona"
name="tipo_persona"
class="border rounded px-3 py-2"
required>

<option value="">Tipo de Persona</option>
<option value="fisica">Persona Física</option>
<option value="moral">Persona Moral</option>

</select>

<input type="text" name="rfc" placeholder="RFC"
class="border rounded px-3 py-2 uppercase w-full">
<p class="text-red-500 text-xs mt-1 hidden" id="error_rfc"></p>

<input type="text" name="razon_social"
placeholder="Razón Social"
class="border rounded px-3 py-2"
required>
<p class="text-red-500 text-xs mt-1 hidden" id="error_razon_social"></p>

<input type="text" name="codigo_postal"
placeholder="Código Postal"
maxlength="5"
class="border rounded px-3 py-2"
required>
<p class="text-red-500 text-xs mt-1 hidden" id="error_cp"></p>

<select name="regimen_fiscal"
class="border rounded px-3 py-2"
required>

<option value="">Régimen Fiscal</option>
<option value="601">601 - General de Ley Personas Morales</option>
<option value="603">603 - Personas físicas con actividad empresarial</option>
<option value="605">605 - Sueldos y Salarios</option>
<option value="606">606 - Arrendamiento</option>
<option value="612">612 - Actividades Empresariales</option>
<option value="621">621 - Incorporación Fiscal</option>
<option value="626">626 - RESICO</option>

</select>

<select id="uso_cfdi"
name="uso_cfdi"
class="border rounded px-3 py-2"
required>

<option value="">Uso CFDI</option>

</select>

<div class="md:col-span-2 text-right">
<button class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded">
Agregar Cliente
</button>
</div>

</form>


{{-- ================= TABLA CLIENTES ================= --}}
<div class="bg-white border rounded-2xl shadow-sm">

<div class="flex items-center justify-between p-6 border-b">

<h3 class="text-lg font-semibold text-gray-800">
Clientes Registrados
</h3>

<form method="GET" class="flex items-center gap-3">

<div class="relative w-72">

<span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
🔎
</span>

<input type="text"
name="buscar"
value="{{ request('buscar') }}"
placeholder="Buscar cliente..."
class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">

</div>

<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
Buscar
</button>

</form>

</div>


<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-50 text-gray-600 uppercase text-xs">

<tr>
<th class="px-6 py-3 text-left">Nombre</th>
<th class="px-6 py-3 text-left">RFC</th>
<th class="px-6 py-3 text-left">Teléfono</th>
<th class="px-6 py-3 text-left">Uso CFDI</th>
<th class="px-6 py-3 text-center">Acción</th>
</tr>

</thead>

<tbody class="divide-y">

@forelse($clientes as $cliente)

<tr class="hover:bg-gray-50">

<td class="px-6 py-4">
{{ $cliente->nombre }}
</td>

<td class="px-6 py-4">
{{ $cliente->rfc }}
</td>

<td class="px-6 py-4">
{{ $cliente->telefono }}
</td>

<td class="px-6 py-4">
{{ $cliente->uso_cfdi }}
</td>

<td class="px-6 py-4 text-center">

<button
onclick="abrirModal(
'{{ $cliente->id_cliente }}',
'{{ $cliente->nombre }}',
'{{ $cliente->rfc }}',
'{{ $cliente->razon_social }}',
'{{ $cliente->codigo_postal }}',
'{{ $cliente->regimen_fiscal }}',
'{{ $cliente->uso_cfdi }}'
)"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">

Editar

</button>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-6 text-gray-400">
No hay clientes registrados
</td>
</tr>

@endforelse

</tbody>

</table>

</div>


<div class="p-4 border-t">
{{ $clientes->links() }}
</div>

</div>

</div>



{{-- ================= MODAL EDITAR ================= --}}
<div id="modalEditar"
class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

<div class="bg-white w-full max-w-xl rounded-2xl shadow-xl p-8">

<h3 class="text-lg font-semibold mb-6">
Editar Cliente
</h3>

<form id="formEditar" method="POST">

@csrf
@method('PUT')

<input type="hidden" id="edit_id">

<div class="space-y-4">

<input type="text"
id="edit_nombre"
name="nombre"
class="w-full border rounded-lg px-4 py-2">

<input type="text"
id="edit_rfc"
name="rfc"
class="w-full border rounded-lg px-4 py-2">

<input type="text"
id="edit_razon_social"
name="razon_social"
class="w-full border rounded-lg px-4 py-2">

<input type="text"
id="edit_codigo_postal"
name="codigo_postal"
class="w-full border rounded-lg px-4 py-2">

<select id="edit_regimen_fiscal"
name="regimen_fiscal"
class="w-full border rounded-lg px-4 py-2">

<option value="601">601 - General de Ley Personas Morales</option>
<option value="603">603 - Personas físicas con actividad empresarial</option>
<option value="605">605 - Sueldos y Salarios</option>
<option value="606">606 - Arrendamiento</option>
<option value="612">612 - Actividades Empresariales</option>
<option value="621">621 - Incorporación Fiscal</option>
<option value="626">626 - RESICO</option>

</select>

<select id="edit_uso_cfdi"
name="uso_cfdi"
class="w-full border rounded-lg px-4 py-2">

<option value="G03">G03 - Gastos en general</option>
<option value="P01">P01 - Por definir</option>
<option value="I01">I01 - Construcciones</option>

</select>

</div>

<div class="flex justify-end gap-3 mt-6">

<button type="button"
onclick="cerrarModal()"
class="px-4 py-2 border rounded-lg">

Cancelar

</button>

<button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

Actualizar

</button>

</div>

</form>

</div>

</div>



{{-- ================= SCRIPTS ================= --}}
<script>

    

const tipoPersona = document.getElementById("tipo_persona");
const usoSelect = document.getElementById("uso_cfdi");

const usosCFDI = {

fisica: [
{clave:"G03",texto:"G03 - Gastos en general"},
{clave:"D01",texto:"D01 - Honorarios médicos"},
{clave:"P01",texto:"P01 - Por definir"}
],

moral: [
{clave:"G03",texto:"G03 - Gastos en general"},
{clave:"I01",texto:"I01 - Construcciones"},
{clave:"P01",texto:"P01 - Por definir"}
]

};

tipoPersona?.addEventListener("change", function(){

let tipo=this.value;

usoSelect.innerHTML="<option value=''>Uso CFDI</option>";

if(usosCFDI[tipo]){

usosCFDI[tipo].forEach(u=>{

let opt=document.createElement("option");
opt.value=u.clave;
opt.textContent=u.texto;

usoSelect.appendChild(opt);

});

}

});


function abrirModal(id,nombre,rfc,razon,cp,regimen,uso){

document.getElementById("modalEditar").classList.remove("hidden");

document.getElementById("edit_id").value=id;
document.getElementById("edit_nombre").value=nombre;
document.getElementById("edit_rfc").value=rfc;
document.getElementById("edit_razon_social").value=razon;
document.getElementById("edit_codigo_postal").value=cp;
document.getElementById("edit_regimen_fiscal").value=regimen;
document.getElementById("edit_uso_cfdi").value=uso;

document.getElementById("formEditar").action="/clientes/"+id;

}

function cerrarModal(){

document.getElementById("modalEditar").classList.add("hidden");

}

document.getElementById("formCliente").addEventListener("submit", function(e){

let nombre = document.querySelector("input[name='nombre']").value.trim();
let apellidos = document.querySelector("input[name='apellidos']").value.trim();
let telefono = document.querySelector("input[name='telefono']").value.trim();
let email = document.querySelector("input[name='email']").value.trim();
let rfc = document.querySelector("input[name='rfc']").value.trim().toUpperCase();
let razon = document.querySelector("input[name='razon_social']").value.trim();
let cp = document.querySelector("input[name='codigo_postal']").value.trim();
let tipoPersona = document.querySelector("select[name='tipo_persona']").value;
let regimen = document.querySelector("select[name='regimen_fiscal']").value;
let uso = document.querySelector("select[name='uso_cfdi']").value;

let errores = [];


// NOMBRE
if(nombre.length < 3){
mostrarError("error_nombre","El nombre debe tener al menos 3 caracteres");
}


// APELLIDOS
if(apellidos.length < 3){
mostrarError("error_apellidos","Los apellidos deben tener al menos 3 caracteres");
}


// TELEFONO
if(telefono && !/^[0-9]{10}$/.test(telefono)){
mostrarError("error_telefono","El teléfono debe tener 10 dígitos");
}


// EMAIL
if(email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
mostrarError("error_email","Email inválido");
}


// RFC
if(!regexRFC.test(rfc)){
mostrarError("error_rfc","RFC inválido");
}


// RFC longitud
if(tipoPersona === "fisica" && rfc.length !== 13){
mostrarError("error_rfc","El RFC de persona física debe tener 13 caracteres");
}

if(tipoPersona === "moral" && rfc.length !== 12){
mostrarError("error_rfc","El RFC de persona moral debe tener 12 caracteres");
}


// CP
if(!/^[0-9]{5}$/.test(cp)){
mostrarError("error_cp","Código postal inválido");
}


if(errores){
e.preventDefault();
}

});


// RFC mayúsculas automático
document.querySelector("input[name='rfc']").addEventListener("input",function(){
this.value=this.value.toUpperCase();
});


</script>

@endsection