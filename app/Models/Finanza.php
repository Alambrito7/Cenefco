<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finanza extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'venta_id', 'curso_id', 'monto', 'banco', 'nro_transaccion', 'fecha_hora',
    ];

    protected $dates = ['fecha_hora', 'deleted_at'];

    // Relación con ventas
    public function venta()
    {
        return $this->belongsTo(Ventas::class);
    }

    // Relación con cursos
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    // Finanza.php
public function cliente() {
    return $this->belongsTo(Cliente::class);
}

public function entregaMaterial() {
    return $this->hasOne(EntregaMaterial::class);
}

}
