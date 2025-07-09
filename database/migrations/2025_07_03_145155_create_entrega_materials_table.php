<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_entrega_materials_table.php
public function up()
{
    Schema::create('entrega_materials', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('venta_id');
        $table->enum('opcion_entrega', ['CD', 'Google Drive']);
        $table->string('nro_transaccion_cd')->nullable();
        $table->string('comprobante_cd')->nullable();
        $table->timestamps();

        // Relación con la tabla de ventas
        $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('entrega_materials');
}

};
