<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {

    $table->id('id_venta');

    $table->unsignedBigInteger('id_usuario');
    $table->unsignedBigInteger('id_caja')->nullable();

    $table->decimal('subtotal',10,2);
    $table->decimal('iva',10,2);
    $table->decimal('total',10,2);

    $table->unsignedBigInteger('id_tipo_pago'); //

    $table->timestamps();

    // 🔐 LLAVES FORÁNEAS
    $table->foreign('id_usuario')
          ->references('id_usuario')
          ->on('usuarios')
          ->onDelete('restrict');

    $table->foreign('id_caja')
          ->references('id_caja')
          ->on('cajas')
          ->onDelete('restrict');

           // 👇 AQUÍ VA LA RELACIÓN
    $table->foreign('id_tipo_pago')
          ->references('id_tipo_pago')
          ->on('tipos_pago')
          ->onDelete('restrict');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
