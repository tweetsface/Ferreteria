<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_sucursal', function (Blueprint $table) {

            $table->bigIncrements('id_producto_sucursal');

            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_sucursal');

            $table->decimal('existencia',10,2)->default(0);
            $table->decimal('stock_minimo',10,2)->default(0);
            $table->decimal('stock_maximo',10,2)->nullable();

            $table->timestamps();

            // Relaciones
            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('productos')
                ->onDelete('cascade');

            $table->foreign('id_sucursal')
                ->references('id_sucursal')
                ->on('sucursales')
                ->onDelete('cascade');

            // Evita duplicar producto por sucursal
            $table->unique(['id_producto','id_sucursal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_sucursal');
    }
};