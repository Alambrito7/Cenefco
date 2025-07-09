<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends Model
{
    use HasFactory, SoftDeletes; // <- Muy importante usar SoftDeletes

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'correo',
        'nacionalidad',
        'edad',
        'grado_academico',
        'experiencia',
        'impartio_clases',
        'foto',
        'curriculum',
    ];

    protected $dates = ['deleted_at']; // <- Necesario para SoftDeletes
}
