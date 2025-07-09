<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaucherColumnsToPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('baucher_numero')->nullable();  // Agrega la columna para el número de baucher
            $table->string('baucher_foto')->nullable();    // Agrega la columna para la foto del baucher
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['baucher_numero', 'baucher_foto']);
        });
    }
}
