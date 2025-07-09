<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo_af', 'nombre', 'concepto_1', 'concepto_2',
        'imei_1', 'imei_2', 'sim_1', 'sim_2',
        'estado', 'destino', 'observaciones',
        'valor', 'responsable_id'
    ];

    public function responsable() {
        return $this->belongsTo(Personal::class, 'responsable_id');
    }
}