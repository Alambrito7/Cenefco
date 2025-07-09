<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaMaterial extends Model
{
    use HasFactory;
// En el modelo EntregaMaterial

    protected $fillable = ['venta_id', 'opcion_entrega', 'nro_transaccion_cd', 'comprobante_cd'];

    public function venta()
    {
        return $this->belongsTo(Ventas::class);
    }

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'venta_id'); // Relación basada en venta_id
}

// En el modelo EntregaMaterial
public function finanza()
{
    return $this->belongsTo(Finanza::class, 'venta_id');  // Relaciona EntregaMaterial con Finanza por venta_id
}




}
