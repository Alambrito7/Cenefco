<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificadoDocente extends Model
{
    use SoftDeletes;

    protected $table = 'certificados_docentes';

    protected $fillable = [
        'docente_id',
        'curso_id',
        'anio',
        'mes_curso',
        'ciudad',
        'estado_certificado',
        'fecha_entrega_area_academica',
        'fecha_envio_entregada',
        'numero_guia',
        'direccion_oficina'
    ];

    // Relación con Docente
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
