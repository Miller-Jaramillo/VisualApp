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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_registro');
            $table->string('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->date('fecha_inicial')->nullable();
            $table->date('fecha_final')->nullable();
            $table->string('archivo_xlsx');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nombre_usuario')->nullable(); // Nuevo campo para el nombre del usuario
            $table->timestamps();

            // Define la relación con el usuario
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
};
