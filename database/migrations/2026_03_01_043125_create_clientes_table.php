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
        Schema::create('clientes', function (Blueprint $table) {
    $table->id('id_cliente');

    $table->string('nombre');
    $table->string('telefono')->nullable();
    $table->string('email')->nullable();

    // Datos fiscales (para factura)
    $table->string('rfc')->nullable();
    $table->string('razon_social')->nullable();
    $table->string('codigo_postal')->nullable();
    $table->string('regimen_fiscal')->nullable();
    $table->string('uso_cfdi')->nullable();

    $table->string('direccion')->nullable();

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
        Schema::dropIfExists('clientes');
    }
};
