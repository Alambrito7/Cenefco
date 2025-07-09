<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = ['nombre', 'ruta'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
