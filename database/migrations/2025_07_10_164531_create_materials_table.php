<?php

// database/migrations/2025_07_10_000000_create_materials_table.php

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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('rama'); // Area del curso
            $table->enum('type', ['pdf', 'video'])->comment('Tipo de material: PDF o Video');
            $table->string('file_path')->nullable()->comment('Ruta del archivo PDF');
            $table->string('video_url')->nullable()->comment('Enlace del video');
            $table->text('description')->comment('Descripción del material');
            $table->timestamps();
            $table->softDeletes(); // Para borrado lógico
            
            // Índices para mejorar el rendimiento
            $table->index('rama');
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};