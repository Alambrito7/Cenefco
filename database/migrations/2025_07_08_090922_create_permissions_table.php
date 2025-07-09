<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // registros.view, ventas.create, etc.
            $table->string('display_name'); // Ver Registros, Crear Ventas
            $table->string('module'); // registros, ventas, inventario, etc.
            $table->string('action'); // view, create, edit, delete, export
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index(['module', 'action']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}