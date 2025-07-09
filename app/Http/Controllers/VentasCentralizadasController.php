<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Venta;
use App\Models\Finanza;
use App\Models\Pago;
use App\Models\EntregaMaterial;
use App\Models\Personal; // Agregar el modelo Personal
use Illuminate\Http\Request;

class VentasCentralizadasController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los cursos con sus relaciones, incluyendo el personal
        $cursos = Curso::with([
            'ventas',
            'finanzas',
            'pagos',
            'entregaMaterials',
            'personal' // Agregar la relación con personal
        ])->get();

        // Preparar los resultados para mostrar en la vista
        $data = $cursos->map(function ($curso) {
            // Total de Inscritos
            $totalInscritos = $curso->ventas->count();

            // Precio - Asumimos que el precio es el mismo para todos los inscritos
            $precio = $curso->ventas->first() ? $curso->ventas->first()->precio : 0;

            // Encargado - Obtener el nombre del personal asignado al curso
            $encargado = $curso->personal ? $curso->personal->nombre : 'No asignado';
            // Si el campo se llama diferente, usa: $curso->personal->nombre_completo o el campo correspondiente

            // Total de Ventas Curso (Sumatoria de monto en finanzas)
            $totalVentasCurso = $curso->finanzas->sum('monto');

            // Total de Plan de Pagos (Sumatoria de monto en pagos)
            $totalPagos = $curso->pagos->sum('monto');

            // Total de Pagos CD (Sumatoria de costo_cd en entrega_materials)
            $totalPagosCD = $curso->entregaMaterials->sum('costo_cd');

            // Organizar la información en un array
            return [
                'empresa' => $curso->area, // Área de la empresa (tabla cursos)
                'curso' => $curso->nombre,
                'total_inscritos' => $totalInscritos,
                'precio' => $precio,
                'encargado' => $encargado,
                'total_ventas_curso' => $totalVentasCurso,
                'total_plan_pagos' => $totalPagos,
                'total_pagos_cd' => $totalPagosCD,
            ];
        });

        // Pasar los datos a la vista
        return view('ventas_centralizadas.index', compact('data'));
    }
}