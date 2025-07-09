<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosDocentesTable extends Migration
{
    public function up()
    {
        Schema::create('certificados_docentes', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');

            // Datos del certificado
            $table->year('anio');
            $table->string('mes_curso');
            $table->string('ciudad');

            $table->enum('estado_certificado', ['Entregado', 'Pendiente']);

            $table->date('fecha_entrega_area_academica')->nullable();
            $table->date('fecha_envio_entregada')->nullable();

            // Condicionales
            $table->string('numero_guia')->nullable(); // Si es envío
            $table->string('direccion_oficina')->nullable(); // Si es entrega en oficina

            $table->timestamps();
            $table->softDeletes(); // Para eliminación lógica
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificados_docentes');
    }
}
