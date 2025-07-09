<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaucherFieldsToVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Agregar columna para el número de baucher
            $table->string('baucher_numero')->nullable();

            // Agregar columna para la foto del baucher
            $table->string('baucher_foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn('baucher_numero');
            $table->dropColumn('baucher_foto');
        });
    }
}
