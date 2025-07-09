<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('entrega_materials', function (Blueprint $table) {
        $table->decimal('costo_cd', 10, 2)->nullable();  // Puedes ajustar el tamaño y si es nullable o no
    });
}

public function down()
{
    Schema::table('entrega_materials', function (Blueprint $table) {
        $table->dropColumn('costo_cd');
    });
}

};
