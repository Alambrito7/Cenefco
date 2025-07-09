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
    Schema::create('docentes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido_paterno');
        $table->string('apellido_materno')->nullable();
        $table->string('telefono');
        $table->string('correo')->unique();
        $table->string('nacionalidad');
        $table->integer('edad');
        $table->string('grado_academico');
        $table->text('experiencia');
        $table->boolean('impartio_clases')->default(false);
        $table->string('foto')->nullable();
        $table->string('curriculum')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
