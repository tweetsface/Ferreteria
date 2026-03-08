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

            $table->string('codigo')->unique(); // código de barras
            $table->string('nombre');

            $table->unsignedBigInteger('id_familia')->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();
            

            // precios
            $table->decimal('costo', 12, 2)->nullable();
            $table->decimal('precio_base', 12, 2);
            $table->decimal('precio_venta', 12, 2);

            $table->unsignedBigInteger('id_unidad')->nullable();

    $table->foreign('id_unidad')
        ->references('id_unidad')
        ->on('unidades');

            // SAT
            $table->unsignedBigInteger('id_clave_sat')->nullable();
            $table->unsignedBigInteger('id_unidad_sat')->nullable();
            $table->string('objeto_impuesto',2)->default('02');

            // datos producto
            $table->string('marca')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();

            // relaciones
            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('categorias')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('id_clave_sat')
                ->references('id_clave_sat')
                ->on('claves_productos_sat');

            $table->foreign('id_unidad_sat')
                ->references('id_unidad_sat')
                ->on('unidades_sat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};