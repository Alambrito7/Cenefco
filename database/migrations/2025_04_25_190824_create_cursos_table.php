<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('area');
            $table->string('marca');
            $table->foreignId('personal_id')->constrained()->onDelete('cascade');
            $table->foreignId('docente_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->string('dias_clases');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['En curso', 'Programado', 'Finalizado']);
            $table->string('flayer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
