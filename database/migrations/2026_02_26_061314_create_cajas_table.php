<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cajas', function (Blueprint $table) {

            $table->id('id_caja'); // id caja
            // Relaciones
            $table->unsignedBigInteger('id_sucursal')->references('id_sucursal')->on('sucursales');
            $table->unsignedBigInteger('id_usuario')->references('id_usuario')->on('usuario');

            // Montos
            $table->decimal('monto_inicial', 12, 2)->default(0);
            $table->decimal('monto_final', 12, 2)->nullable();

            $table->decimal('ventas_efectivo', 12, 2)->default(0);
            $table->decimal('ventas_tarjeta', 12, 2)->default(0);
            $table->decimal('ventas_transferencia', 12, 2)->default(0);

            // Estado
            $table->enum('estado', ['abierta', 'cerrada'])->default('abierta');

            // Fechas
            $table->timestamp('fecha_apertura')->nullable();
            $table->timestamp('fecha_cierre')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};