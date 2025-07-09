<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← Importamos
use App\Models\Venta; // Importar el modelo Venta


class Curso extends Model
{
    use HasFactory, SoftDeletes; // ← Activamos borrado lógico

    protected $fillable = [
        'nombre',
        'area',
        'marca',
        'personal_id',
        'docente_id',
        'fecha',
        'dias_clases',
        'descripcion',
        'estado',
        'flayer',
    ];

    public function encargado()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function ventas()
{
    return $this->hasMany(ventas::class, 'curso_id');
}

// app/Models/Curso.php
public function inscritos()
{
    return $this->hasMany(Inscrito::class);
}

// Relación con 'finanzas' (tabla 'finanzas')
public function finanzas()
{
    return $this->hasManyThrough(Finanza::class, Ventas::class, 'curso_id', 'venta_id');
}
   // Relación con 'pagos'
   public function pagos()
   {
       return $this->hasManyThrough(Pago::class, Ventas::class, 'curso_id', 'venta_id');
   }

     // Relación con 'entregaMaterials'
     public function entregaMaterials()
     {
         return $this->hasManyThrough(EntregaMaterial::class, Ventas::class, 'curso_id', 'venta_id');
     }

     public function personal()
     {
         return $this->belongsTo(Personal::class, 'personal_id');
     }

}
