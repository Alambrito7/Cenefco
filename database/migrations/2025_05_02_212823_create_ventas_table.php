<?php

// database/migrations/xxxx_xx_xx_create_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
        
            // Relaciones
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendedor_id')->constrained('personals')->onDelete('cascade');
            $table->foreignId('descuento_id')->nullable()->constrained()->onDelete('set null');
        
            // Datos de la venta
            $table->decimal('costo_curso', 10, 2);
            $table->enum('estado_venta', ['Pagado', 'Plan de Pagos', 'Anulado']);
            $table->decimal('primer_pago', 10, 2)->nullable();    // Solo si es plan de pagos
            $table->decimal('total_pagado', 10, 2)->nullable();   // Solo si es pagado
            $table->decimal('saldo_pago', 10, 2)->nullable();     // Calculado automáticamente
            $table->decimal('descuento_monto', 10, 2)->nullable(); // Calculado automáticamente
        
            $table->enum('forma_pago', ['Contado Oficina', 'Transferencia Bancaria', 'Pago por QR']);
            $table->timestamp('fecha_venta')->useCurrent();
            $table->string('comprobante_pago')->nullable();
        
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
