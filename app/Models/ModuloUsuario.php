<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloUsuario extends Model
{
    protected $table = 'modulos_usuario';
    protected $fillable = ['user_id', 'modulo'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

