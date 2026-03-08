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
    Schema::create('uso_cfdi_regimen', function (Blueprint $table) {

$table->id('id_cfdi_regimen');
$table->unsignedBigInteger('id_regimen');
$table->unsignedBigInteger('id_uso_cfdi');

$table->foreign('id_regimen')
->references('id_regimen')
->on('regimenes_fiscales')
->onDelete('cascade');

$table->foreign('id_uso_cfdi')
->references('id_uso_cfdi')
->on('usos_cfdi')
->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uso_cfdi_regimen');
    }
};
