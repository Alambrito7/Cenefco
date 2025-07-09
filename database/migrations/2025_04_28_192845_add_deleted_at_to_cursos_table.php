<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToCursosTable extends Migration
{
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->softDeletes(); // ← Agrega columna deleted_at
        });
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
