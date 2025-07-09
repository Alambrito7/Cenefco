<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToPersonalsTable extends Migration
{
    public function up()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->softDeletes(); // <-- Agrega columna deleted_at
        });
    }

    public function down()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->dropSoftDeletes(); // <-- Elimina columna deleted_at
        });
    }
}
