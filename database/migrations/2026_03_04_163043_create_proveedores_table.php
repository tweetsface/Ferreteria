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
       Schema::create('proveedores', function (Blueprint $table) {
        $table->id('id_proveedor');
        $table->string('nombre');
        $table->string('contacto')->nullable();
        $table->string('telefono')->nullable();
        $table->string('email')->nullable();
        $table->string('rfc')->nullable();
        $table->text('direccion')->nullable();
        $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('proveedores');
    }
};
