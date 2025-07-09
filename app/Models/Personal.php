<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Agregar esto

class Personal extends Model
{
    use HasFactory, SoftDeletes; // <-- Agregar SoftDeletes aquí también

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'edad',
        'genero',
        'telefono',
        'correo',
        'cargo',
        'foto'
    ];

    public function inventarios() {
        return $this->hasMany(Inventario::class, 'responsable_id');
    }
    
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'personal_id');
    }
}
