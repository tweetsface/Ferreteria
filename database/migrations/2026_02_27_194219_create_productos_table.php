<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

     public function up(): void
     {
      Schema::create('productos', function (Blueprint $table) {

        $table->id('id_producto');

        $table->string('codigo')->unique(); // SKU o código de barras
        $table->string('nombre');

        // FK hacia categorias
        $table->unsignedBigInteger('id_categoria')->nullable();

        // 🔹 NUEVOS CAMPOS IMPORTANTES
        $table->decimal('costo', 12, 2)->nullable(); // Precio de compra
        $table->decimal('precio_base', 12, 2);
        $table->decimal('precio_venta', 12, 2);
        $table->integer('stock')->default(0);
        $table->integer('stock_minimo')->default(0); // Alerta inventario bajo
        $table->string('unidad')->default('pieza'); // pieza, metro, kilo
        $table->string('marca')->nullable(); // Truper, Urrea, etc.

        $table->text('descripcion')->nullable();
        $table->string('imagen')->nullable();

        $table->boolean('activo')->default(true);

        $table->timestamps();

        // 🔗 Foreign Key
        $table->foreign('id_categoria')
              ->references('id_categoria')
              ->on('categorias')
              ->onUpdate('cascade')
              ->onDelete('set null');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};