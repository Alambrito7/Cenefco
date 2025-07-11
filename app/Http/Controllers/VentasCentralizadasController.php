<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Venta;
use App\Models\Finanza;
use App\Models\Pago;
use App\Models\EntregaMaterial;
use App\Models\Personal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
            'personal'
        ])->get();

        // Preparar los resultados para mostrar en la vista
        $data = $cursos->map(function ($curso) {
            // Total de Inscritos
            $totalInscritos = $curso->ventas->count();

            // Precio - Asumimos que el precio es el mismo para todos los inscritos
            $precio = $curso->ventas->first() ? $curso->ventas->first()->precio : 0;

            // Encargado - Obtener el nombre del personal asignado al curso
            $encargado = $curso->personal ? $curso->personal->nombre : 'No asignado';

            // Total de Ventas Curso (Sumatoria de monto en finanzas)
            $totalVentasCurso = $curso->finanzas->sum('monto');

            // Total de Plan de Pagos (Sumatoria de monto en pagos)
            $totalPagos = $curso->pagos->sum('monto');

            // Total de Pagos CD (Sumatoria de costo_cd en entrega_materials)
            $totalPagosCD = $curso->entregaMaterials->sum('costo_cd');

            // **NUEVO: Contar pagos por banco**
            $pagosPorBanco = $curso->finanzas->groupBy('banco')->map(function ($group) {
                return $group->count();
            });

            // Organizar la información en un array
            return [
                'curso_id' => $curso->id,
                'empresa' => $curso->area,
                'curso' => $curso->nombre,
                'total_inscritos' => $totalInscritos,
                'precio' => $precio,
                'encargado' => $encargado,
                'total_ventas_curso' => $totalVentasCurso,
                'total_plan_pagos' => $totalPagos,
                'total_pagos_cd' => $totalPagosCD,
                'pagos_por_banco' => $pagosPorBanco, // Nueva información
            ];
        });

        // **NUEVO: Obtener todos los bancos únicos para mostrar en la tabla**
        $bancosUnicos = Finanza::distinct()->pluck('banco')->filter()->sort()->values();

        // Pasar los datos a la vista
        return view('ventas_centralizadas.index', compact('data', 'bancosUnicos'));
    }


    /**
     * Exportar reporte a PDF
     */
    public function exportarPDF(Request $request)
    {
        // Obtener los mismos datos que en index()
        $cursos = Curso::with([
            'ventas',
            'finanzas',
            'pagos',
            'entregaMaterials',
            'personal'
        ])->get();

        $data = $cursos->map(function ($curso) {
            $totalInscritos = $curso->ventas->count();
            $precio = $curso->ventas->first() ? $curso->ventas->first()->precio : 0;
            $encargado = $curso->personal ? $curso->personal->nombre : 'No asignado';
            $totalVentasCurso = $curso->finanzas->sum('monto');
            $totalPagos = $curso->pagos->sum('monto');
            $totalPagosCD = $curso->entregaMaterials->sum('costo_cd');

            $pagosPorBanco = $curso->finanzas->groupBy('banco')->map(function ($group) {
                return $group->count();
            });

            return [
                'curso_id' => $curso->id,
                'empresa' => $curso->area,
                'curso' => $curso->nombre,
                'total_inscritos' => $totalInscritos,
                'precio' => $precio,
                'encargado' => $encargado,
                'total_ventas_curso' => $totalVentasCurso,
                'total_plan_pagos' => $totalPagos,
                'total_pagos_cd' => $totalPagosCD,
                'pagos_por_banco' => $pagosPorBanco,
            ];
        });

        $bancosUnicos = Finanza::distinct()->pluck('banco')->filter()->sort()->values();

        // Calcular totales generales
        $totales = [
            'total_cursos' => count($data),
            'total_inscritos' => collect($data)->sum('total_inscritos'),
            'total_ventas_curso' => collect($data)->sum('total_ventas_curso'),
            'total_plan_pagos' => collect($data)->sum('total_plan_pagos'),
            'total_pagos_cd' => collect($data)->sum('total_pagos_cd'),
        ];

        // Calcular totales por banco
        $totalesPorBanco = [];
        foreach ($bancosUnicos as $banco) {
            $totalesPorBanco[$banco] = collect($data)->sum(function($item) use ($banco) {
                return $item['pagos_por_banco'][$banco] ?? 0;
            });
        }

        // Datos adicionales para el PDF
        $fechaGeneracion = Carbon::now()->format('d/m/Y H:i:s');
        $usuario = auth()->user()->name ?? 'Sistema';

        // Generar el PDF
        $pdf = PDF::loadView('ventas_centralizadas.pdf', compact(
            'data', 
            'bancosUnicos', 
            'totales', 
            'totalesPorBanco',
            'fechaGeneracion',
            'usuario'
        ));

        // Configurar el PDF
        $pdf->setPaper('A4', 'landscape'); // Horizontal para que quepan todas las columnas
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);

        // Nombre del archivo
        $nombreArchivo = 'ventas_centralizadas_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';

        // Descargar el PDF
        return $pdf->download($nombreArchivo);
    }
}
