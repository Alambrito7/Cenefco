<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pagina_central',
        'subpagina',
        'area',
        'curso',
        'docente',
        'fecha_publicacion',
        'fecha_inicio',
        'link_grupo',
        'estado',
    ];
}
