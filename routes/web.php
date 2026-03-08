<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuloPrincipalController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Ruta pública
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/', [VentaController::class, 'index'])->name('dashboard');

    Route::get('productos', [ProductoController::class,'index'])->name('producto.index');
    Route::post('productos', [ProductoController::class,'store'])->name('producto.store');
    Route::put('productos/{id}', [ProductoController::class,'update'])->name('producto.update');  
    Route::delete('productos', [ProductoController::class,'destroy'])->name('producto.destroy');  
    Route::get('clientes', [ClienteController::class,'index'])->name('cliente.index');
    Route::post('clientes', [ClienteController::class,'store'])->name('cliente.store');
    Route::get('/clientes/buscar', [ClienteController::class,'buscar'])->name('clientes.buscar');
    Route::put('clientes/{id}', [ClienteController::class,'update'])->name('cliente.update');
    Route::get('usuarios', [UsuarioController::class,'index'])->name('usuario.index');
    Route::get('sucursales', [SucursalController::class,'index'])->name('sucursal.index');
    
    Route::get('/facturas', [FacturaController::class,'index'])->name('facturacion.index');
    Route::get('/facturas/buscar', [FacturaController::class,'buscar'])->name('facturacion.buscar');
    Route::post('/facturas/generar/{id}', [FacturaController::class,'facturar'])->name('facturacion.generar');
    Route::post('/facturas/cancelar/{id}', [FacturaController::class,'cancelar'])->name('facturacion.cancelar');
    Route::post('/facturas/verificar/{id}', [FacturaController::class,'verificarEstatus'])->name('facturacion.verificar');
    
    Route::get('/factura/xml/{uuid}', [FacturacionController::class,'descargarXML'])->name('factura.xml');

Route::get('/factura/pdf/{uuid}', [FacturacionController::class,'descargarPDF'])->name('factura.pdf');

Route::get('/factura/ver/{uuid}', [FacturacionController::class,'verFactura'])
->name('factura.ver');
    Route::resource('sucursales', SucursalController::class);
    Route::resource('inventario', InventarioController::class);
    Route::resource('promociones', PromocionController::class);
    Route::resource('facturacion', FacturacionController::class);
    Route::resource('tickets', TicketController::class);

    Route::get('/apertura-caja', [CajaController::class, 'apertura']);
    Route::post('/apertura-caja', [CajaController::class, 'guardarApertura'])
    ->name('caja.guardar');
    Route::get('/cierre-caja', [CajaController::class, 'cierre']);

    Route::get('/venta', [VentaController::class, 'index']);

    Route::post('/venta/guardar', [VentaController::class, 'guardar']);


Route::get('/facturacion/pdf/{id}', [FacturaController::class, 'descargarPDF'])
    ->name('facturacion.pdf');

Route::get('/facturacion/xml/{id}', [FacturaController::class, 'descargarXML'])
    ->name('facturacion.xml');


    Route::get('/api/categorias/{familia}',[CategoriaController::class,'porFamilia']);
    Route::get('/api/usos-cfdi/{id}',[FacturaController::class,'usosPorRegimen']
);
});

/*
|--------------------------------------------------------------------------
| Perfil Breeze
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';