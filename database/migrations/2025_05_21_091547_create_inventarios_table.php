<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_af')->unique();
            $table->string('nombre');
            $table->string('concepto_1')->nullable(); // Modelo
            $table->string('concepto_2')->nullable(); // Color
            $table->string('imei_1')->nullable();
            $table->string('imei_2')->nullable();
            $table->string('sim_1')->nullable();
            $table->string('sim_2')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->string('destino')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('valor', 10, 2)->default(0);
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->foreign('responsable_id')->references('id')->on('personals');
            $table->timestamps();
            $table->softDeletes(); // <-- Soporte para borrado lógico
        });
    }

    public function down() {
        Schema::dropIfExists('inventarios');
    }
};
