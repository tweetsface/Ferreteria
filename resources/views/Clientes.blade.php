@extends('layouts.app')

@section('title', 'Clientes')

@section('modulo')
Gestión de Clientes
@endsection

@section('content')

{{-- ================= FORMULARIO ================= --}}
<form id="formCliente"
class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<label class="block font-medium mb-1">Nombres</label>
<input type="text" id="nombres" required
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div>
<label class="block font-medium mb-1">Apellidos</label>
<input type="text" id="apellidos" required
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div>
<label class="block font-medium mb-1">Teléfono</label>
<input type="tel" id="telefono" pattern="[0-9]{10}" required
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
<small class="text-gray-500">10 dígitos</small>
</div>

<div>
<label class="block font-medium mb-1">Email</label>
<input type="email" id="email"
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div class="md:col-span-2">
<label class="block font-medium mb-1">Dirección</label>
<input type="text" id="direccion" required
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div class="md:col-span-2 flex justify-end">
<button type="submit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-semibold transition">
Agregar Cliente
</button>
</div>

</form>

{{-- ================= TABLA ================= --}}
<section class="bg-white p-6 rounded-xl shadow border border-gray-200">

<h2 class="text-2xl font-semibold mb-4">Clientes Registrados</h2>

<div class="overflow-auto max-h-[400px] border border-gray-300 rounded">
<table class="w-full border-collapse border border-gray-300 text-sm">

<thead class="bg-gray-100">
<tr>
<th class="border border-gray-300 p-2 text-left">Nombres</th>
<th class="border border-gray-300 p-2 text-left">Apellidos</th>
<th class="border border-gray-300 p-2 text-left">Teléfono</th>
<th class="border border-gray-300 p-2 text-left">Email</th>
<th class="border border-gray-300 p-2 text-left">Dirección</th>
<th class="border border-gray-300 p-2 text-center">Acciones</th>
</tr>
</thead>

<tbody id="tablaClientesBody">
<tr>
<td colspan="6" class="text-center p-4 text-gray-500 italic">
No hay clientes registrados
</td>
</tr>
</tbody>

</table>
</div>

</section>

{{-- ================= SCRIPT ================= --}}
<script>
const form = document.getElementById('formCliente');
const tbody = document.getElementById('tablaClientesBody');

let clientes = [];

function actualizarTabla() {
if (clientes.length === 0) {
tbody.innerHTML = `
<tr>
<td colspan="6" class="text-center p-4 text-gray-500 italic">
No hay clientes registrados
</td>
</tr>`;
return;
}

tbody.innerHTML = clientes.map((c, i) => `
<tr class="${i % 2 === 0 ? 'bg-gray-50' : ''}">
<td class="border border-gray-300 p-2">${c.nombres}</td>
<td class="border border-gray-300 p-2">${c.apellidos}</td>
<td class="border border-gray-300 p-2">${c.telefono}</td>
<td class="border border-gray-300 p-2">${c.email || '-'}</td>
<td class="border border-gray-300 p-2">${c.direccion}</td>
<td class="border border-gray-300 p-2 text-center">
<button onclick="eliminarCliente(${i})"
class="text-red-600 hover:underline">
Eliminar
</button>
</td>
</tr>
`).join('');
}

function eliminarCliente(index) {
if (confirm('¿Eliminar este cliente?')) {
clientes.splice(index, 1);
actualizarTabla();
}
}

form.addEventListener('submit', e => {
e.preventDefault();

const nombres = document.getElementById('nombres').value.trim();
const apellidos = document.getElementById('apellidos').value.trim();
const telefono = document.getElementById('telefono').value.trim();
const email = document.getElementById('email').value.trim();
const direccion = document.getElementById('direccion').value.trim();

if (!nombres || !apellidos || !telefono || !direccion) {
alert('Por favor, completa todos los campos obligatorios.');
return;
}

if (!/^\d{10}$/.test(telefono)) {
alert('El teléfono debe tener 10 dígitos.');
return;
}

if (email) {
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(email)) {
alert('Ingresa un email válido o déjalo vacío.');
return;
}
}

clientes.push({ nombres, apellidos, telefono, email, direccion });

form.reset();
actualizarTabla();
});

actualizarTabla();
</script>

@endsection