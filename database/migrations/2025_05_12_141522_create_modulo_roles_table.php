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
        Schema::create('modulo_user', function (Blueprint $table) {
            if (!Schema::hasTable('modulo_user')) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('modulo_id');
                $table->timestamps();
        
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
            }
        });
        
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulo_user');
    }
};
