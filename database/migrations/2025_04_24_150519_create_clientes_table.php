<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido_paterno');
        $table->string('apellido_materno')->nullable();
        $table->string('ci')->unique();
        $table->string('email')->unique();
        $table->string('celular');
        $table->string('departamento');
        $table->string('provincia');
        $table->string('genero');
        $table->string('pais');
        $table->string('profesion')->nullable();
        $table->string('grado_academico')->nullable(); // estudiante, licenciatura, etc.
        $table->integer('edad')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
