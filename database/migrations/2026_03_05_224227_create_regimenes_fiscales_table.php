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
       Schema::create('regimenes_fiscales', function (Blueprint $table) {

$table->id('id_regimen');

$table->string('clave',5);
$table->string('descripcion');

$table->enum('tipo_persona',['fisica','moral']);

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
        Schema::dropIfExists('regimenes_fiscales');
    }
};
