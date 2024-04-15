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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->string('direccion')->nullable();
            $table->string('barrio')->nullable();
            $table->string('comuna')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->integer('edad')->nullable();
            $table->string('genero')->nullable();
            $table->string('tipo_victima')->nullable();
            $table->string('clase_accidente')->nullable();
            $table->string('caso_accidente')->nullable();
            $table->string('lesion')->nullable();
            $table->string('hipotesis')->nullable();
            $table->string('estado_victima')->nullable();
            $table->string('dia')->nullable();
            $table->time('hora')->nullable();
            $table->string('area')->nullable();
            $table->string('sector')->nullable();
            $table->string('condicion_climatica')->nullable();
            $table->string('superficie_rodadura')->nullable();
            $table->string('geometria')->nullable();
            $table->string('estado_via')->nullable();
            $table->string('condicion')->nullable();
            $table->unsignedBigInteger('registro_id');
            $table->timestamps();

            $table->foreign('registro_id')->references('id')->on('registros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos');
    }
};
