<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ventas;
use App\Models\Certificado; 

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'email',
        'celular',
        'departamento',
        'provincia',
        'genero',
        'pais',
        'profesion',
        'grado_academico',
        'edad',
    ];


    public function getNombreCompletoAttribute()
    {
        $nombreCompleto = $this->nombre . ' ' . $this->apellido_paterno;
        if ($this->apellido_materno) {
            $nombreCompleto .= ' ' . $this->apellido_materno;
        }
        return $nombreCompleto;
    }

    
    public function ventas()
{
    return $this->hasMany(Ventas::class, 'cliente_id');
}

public function certificados()
    {
        return $this->hasMany(Certificado::class, 'cliente_id');
    }

    // Relación con las finanzas
    public function finanzas()
    {
        return $this->hasMany(Finanza::class);
    }

    // Relación con la tabla de entrega_materials
    public function entregaMaterial()
    {
        return $this->hasOne(EntregaMaterial::class, 'cliente_id'); // Aquí ajustamos el campo según lo que se necesite
    }

    


    // Otras relaciones y configuraciones


}
