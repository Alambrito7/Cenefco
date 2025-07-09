<?php

// app/Http/Controllers/InscritosController.php
namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Curso;
use Illuminate\Http\Request;

class InscritosController extends Controller
{
    public function mostrarInscritos($cursoId)
    {
        $curso = Curso::find($cursoId);
        $inscritos = $curso->inscripciones()->get();

        return view('inscritos.lista', compact('curso', 'inscritos'));
    }
}
