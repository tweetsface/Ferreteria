<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {

            $table->bigIncrements('id_detalle_venta');

            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_producto');

            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);

            // 🔹 CAMPOS NECESARIOS PARA FACTURACIÓN
            $table->decimal('iva', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->string('clave_sat',20)->nullable();
            $table->string('clave_unidad_sat',10)->nullable();
            $table->string('unidad_sat',50)->nullable();
            $table->string('descripcion')->nullable();

            $table->string('objeto_impuesto',2)->default('02');

            $table->timestamps();

            // 🔥 FOREIGN KEYS
            $table->foreign('id_venta')
                  ->references('id_venta')
                  ->on('ventas')
                  ->onDelete('cascade');

            $table->foreign('id_producto')
                  ->references('id_producto')
                  ->on('productos')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
};