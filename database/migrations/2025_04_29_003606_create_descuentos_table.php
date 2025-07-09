<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('porcentaje', 5, 2); // Ejemplo: 10.50%
            $table->text('descripcion')->nullable();
            $table->softDeletes(); // Para el borrado lógico
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
