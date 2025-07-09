<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToDocentesTable extends Migration
{
    public function up()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->softDeletes(); // agrega campo deleted_at
        });
    }

    public function down()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropSoftDeletes(); // elimina campo deleted_at
        });
    }
}
