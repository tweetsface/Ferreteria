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
      Schema::create('tipos_pago', function (Blueprint $table) {
    $table->id('id_tipo_pago');
    $table->string('nombre'); // Efectivo, Tarjeta, Transferencia
    $table->decimal('comision', 5,2)->default(0); // % comisión
    $table->boolean('activo')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_pago');
    }
};
