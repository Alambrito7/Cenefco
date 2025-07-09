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
    Schema::create('arqueos', function (Blueprint $table) {
        $table->id();
        $table->date('fecha_arqueo');
        $table->decimal('ingresos', 10, 2)->default(0);
        $table->decimal('egresos', 10, 2)->default(0);
        $table->decimal('saldo_final', 10, 2)->default(0);
        $table->unsignedBigInteger('usuario_id'); // quien lo genera
        $table->timestamps();

        $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arqueos');
    }
};
