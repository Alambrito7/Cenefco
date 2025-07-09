<?php

// app/Models/Ventas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ventas extends Model
{
    use SoftDeletes;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'curso_id',
        'vendedor_id',
        'descuento_id',
        'costo_curso',
        'estado_venta',
        'forma_pago',
        'primer_pago',
        'total_pagado',
        'saldo_pago',
        'descuento_monto',
        'fecha_venta',
        'comprobante_pago',
        'numero_transaccion',
        'banco',
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function curso() {
        return $this->belongsTo(Curso::class);
    }

    public function vendedor() {
        return $this->belongsTo(Personal::class, 'vendedor_id');
    }

    public function descuento() {
        return $this->belongsTo(Descuento::class);
    }

    
    public function pagos()
{
    return $this->hasMany(Pago::class, 'venta_id');
}

// En el modelo Venta
// En el modelo Venta
public function entregaMaterial()
{
    return $this->hasOne(EntregaMaterial::class, 'venta_id'); // Usamos 'venta_id' como la clave foránea
}

public function finanzas()
{
    return $this->hasMany(Finanza::class, 'venta_id');  // Relación inversa
}


    

    
}
