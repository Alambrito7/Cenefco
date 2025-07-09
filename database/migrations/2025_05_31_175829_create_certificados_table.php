<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosTable extends Migration
{
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();

            // Relación con cliente
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Relación con curso
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');

            // Estado de entrega: Entregado o Pendiente
            $table->enum('estado_entrega', ['Entregado', 'Pendiente'])->default('Pendiente');

            // Fecha de entrega (puede ser null si está pendiente)
            $table->date('fecha_entrega')->nullable();

            // Relación con personal que entregó (puede ser null)
            $table->foreignId('personal_entrego_id')->nullable()->constrained('personals')->nullOnDelete();

            // Modalidad de entrega: Envío o Entrega en Oficina
            $table->string('modalidad_entrega')->nullable();

            // Observaciones opcionales
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Borrado lógico
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificados');
    }
}
