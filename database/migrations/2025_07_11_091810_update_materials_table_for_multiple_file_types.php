<?php

// database/migrations/xxxx_xx_xx_update_materials_table_for_multiple_file_types.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Agregar campos para información detallada del archivo
            $table->string('file_name')->nullable()->after('file_path');
            $table->bigInteger('file_size')->nullable()->after('file_name'); // en bytes
            $table->string('mime_type')->nullable()->after('file_size');
            
            // Actualizar el enum de tipo para incluir nuevos tipos
            $table->dropColumn('type');
        });
        
        Schema::table('materials', function (Blueprint $table) {
            $table->enum('type', ['pdf', 'image', 'document', 'executable', 'compressed', 'video'])
                  ->after('rama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Eliminar campos agregados
            $table->dropColumn(['file_name', 'file_size', 'mime_type']);
            
            // Restaurar enum original
            $table->dropColumn('type');
        });
        
        Schema::table('materials', function (Blueprint $table) {
            $table->enum('type', ['pdf', 'video'])->after('rama');
        });
    }
};