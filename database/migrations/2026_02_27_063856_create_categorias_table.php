<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {

            $table->id('id_categoria'); // PK personalizada

            $table->string('nombre', 100)->unique(); // nombre único
            $table->string('descripcion')->nullable();

            $table->boolean('estado')->default(true); 
            // true = activa
            // false = inactiva

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};