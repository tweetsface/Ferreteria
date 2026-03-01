@extends('layouts.app')

@section('title', 'Usuarios')

@section('modulo')
Gestión de Usuarios
@endsection

@section('content')
<!-- CONTENIDO -->
<div class="flex-1 flex flex-col">


<main class="flex-1 p-6 overflow-y-auto">

<!-- FORMULARIO -->
<form id="formUsuario"
class="bg-white p-6 rounded-xl shadow border border-gray-200 mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<label class="block font-medium mb-1">Nombres</label>
<input type="text" id="nombres" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div>
<label class="block font-medium mb-1">Apellidos</label>
<input type="text" id="apellidos" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div>
<label class="block font-medium mb-1">Teléfono</label>
<input type="tel" id="telefono" pattern="[0-9]{10}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
<small class="text-gray-500">10 dígitos</small>
</div>

<div>
<label class="block font-medium mb-1">Email</label>
<input type="email" id="email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div>
<label class="block font-medium mb-1">Sucursal</label>
<select id="sucursal" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
<option value="">-- Selecciona una sucursal --</option>
<option>Culiacán</option>
<option>Mazatlán</option>
<option>Los Mochis</option>
<option>Guamúchil</option>
</select>
</div>

<div>
<label class="block font-medium mb-1">Rol</label>
<select id="rol" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500">
<option value="">-- Selecciona un rol --</option>
<option>Cajero</option>
<option>Administrador</option>
</select>
</div>

<!-- PASSWORD -->
<div>
<label class="block font-medium mb-1">Contraseña</label>
<input type="password" id="password" required minlength="6"
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
<small class="text-gray-500">Mínimo 6 caracteres</small>
</div>

<div>
<label class="block font-medium mb-1">Confirmar Contraseña</label>
<input type="password" id="confirmar_password" required minlength="6"
class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-yellow-500" />
</div>

<div class="md:col-span-2 flex justify-end">
<button type="submit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-semibold transition">
Agregar Usuario
</button>
</div>

</form>

<!-- TABLA -->
<section class="bg-white p-6 rounded-xl shadow border border-gray-200">

<h2 class="text-2xl font-semibold mb-4">Usuarios Registrados</h2>

<div class="overflow-auto max-h-[400px] border border-gray-300 rounded">
<table class="w-full border-collapse border border-gray-300 text-sm">

<thead class="bg-gray-100">
<tr>
<th class="border border-gray-300 p-2 text-left">Nombres</th>
<th class="border border-gray-300 p-2 text-left">Apellidos</th>
<th class="border border-gray-300 p-2 text-left">Teléfono</th>
<th class="border border-gray-300 p-2 text-left">Email</th>
<th class="border border-gray-300 p-2 text-left">Sucursal</th>
<th class="border border-gray-300 p-2 text-left">Rol</th>
<th class="border border-gray-300 p-2 text-center">Acciones</th>
</tr>
</thead>

<tbody id="tablaUsuariosBody">
<tr>
<td colspan="7" class="text-center p-4 text-gray-500 italic">
No hay usuarios registrados
</td>
</tr>
</tbody>

</table>
</div>

</section>

</main>
</div>
</div>

<script>
const form = document.getElementById('formUsuario');
const tbody = document.getElementById('tablaUsuariosBody');

let usuarios = [];

function actualizarTabla() {
if (usuarios.length === 0) {
tbody.innerHTML = `
<tr>
<td colspan="7" class="text-center p-4 text-gray-500 italic">
No hay usuarios registrados
</td>
</tr>`;
return;
}

tbody.innerHTML = usuarios.map((u, i) => `
<tr class="${i % 2 === 0 ? 'bg-gray-50' : ''}">
<td class="border border-gray-300 p-2">${u.nombres}</td>
<td class="border border-gray-300 p-2">${u.apellidos}</td>
<td class="border border-gray-300 p-2">${u.telefono}</td>
<td class="border border-gray-300 p-2">${u.email}</td>
<td class="border border-gray-300 p-2">${u.sucursal}</td>
<td class="border border-gray-300 p-2">${u.rol}</td>
<td class="border border-gray-300 p-2 text-center">
<button onclick="eliminarUsuario(${i})" class="text-red-600 hover:underline">
Eliminar
</button>
</td>
</tr>
`).join('');
}

function eliminarUsuario(index) {
if (confirm('¿Eliminar este usuario?')) {
usuarios.splice(index, 1);
actualizarTabla();
}
}

form.addEventListener('submit', e => {
e.preventDefault();

const nombres = document.getElementById('nombres').value.trim();
const apellidos = document.getElementById('apellidos').value.trim();
const telefono = document.getElementById('telefono').value.trim();
const email = document.getElementById('email').value.trim();
const sucursal = document.getElementById('sucursal').value;
const rol = document.getElementById('rol').value;
const password = document.getElementById('password').value.trim();
const confirmarPassword = document.getElementById('confirmar_password').value.trim();

if (!nombres || !apellidos || !telefono || !email || !sucursal || !rol || !password || !confirmarPassword) {
alert('Por favor, completa todos los campos.');
return;
}

if (!/^\d{10}$/.test(telefono)) {
alert('El teléfono debe tener 10 dígitos.');
return;
}

if (password.length < 6) {
alert('La contraseña debe tener mínimo 6 caracteres.');
return;
}

if (password !== confirmarPassword) {
alert('Las contraseñas no coinciden.');
return;
}

usuarios.push({ nombres, apellidos, telefono, email, sucursal, rol });

form.reset();
actualizarTabla();
});

actualizarTabla();
</script>
@endsection