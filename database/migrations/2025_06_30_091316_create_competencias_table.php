<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciasTable extends Migration
{
    public function up()
    {
        Schema::create('competencias', function (Blueprint $table) {
            $table->id();
            $table->string('pagina_central');
            $table->string('subpagina');
            $table->string('area');
            $table->string('curso');
            $table->string('docente');
            $table->date('fecha_publicacion');
            $table->date('fecha_inicio');
            $table->string('link_grupo');
            $table->enum('estado', ['testeo', 'ejecutado', 'cancelado', 'sin respuesta']);
            $table->timestamps();
            $table->softDeletes(); // Columna para eliminación lógica
        });
    }

    public function down()
    {
        Schema::dropIfExists('competencias');
    }
}
