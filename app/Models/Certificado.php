<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cliente;
use App\Models\Curso;
use App\Models\Personal;

class Certificado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'curso_id',
        'estado_entrega',
        'fecha_entrega',
        'personal_entrego',
        'modalidad_entrega',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function personal()
{
    return $this->belongsTo(Personal::class, 'personal_entrego_id');
}

}
