<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'venta_id',
        'monto',
        'registrado_por',
        'baucher_numero',
        'baucher_foto'
    ];

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }
}
