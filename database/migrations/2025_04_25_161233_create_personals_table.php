<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('ci')->unique();
            $table->integer('edad');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->string('cargo');
            $table->string('foto')->nullable();
            $table->boolean('estado')->default(true); // true = activo, false = inactivo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
