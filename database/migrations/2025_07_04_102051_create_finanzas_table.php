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
        Schema::create('finanzas', function (Blueprint $table) {
            $table->id();

            // Relación con ventas y cursos
            $table->foreignId('venta_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');

            // Campos de transacción financiera
            $table->decimal('monto', 10, 2);
            $table->enum('banco', ['BCP', 'Tigo Money', 'B U', 'Recibo', 'WesterUnion']);
            $table->string('nro_transaccion')->unique();
            $table->dateTime('fecha_hora');

            // Borrado lógico
            $table->softDeletes();
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
        Schema::dropIfExists('finanzas');
    }
};
