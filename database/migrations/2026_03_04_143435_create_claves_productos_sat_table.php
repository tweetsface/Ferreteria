<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('claves_productos_sat', function (Blueprint $table) {

            $table->id('id_clave_sat');

            $table->string('clave',20)->unique();

            $table->string('descripcion');

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('claves_productos_sat');
    }
};