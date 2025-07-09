<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteVentasController extends Controller
{
    public function index()
    {
        // Ventas por mes
        $ventasPorMes = Ventas::selectRaw('MONTH(fecha_venta) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');
    
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
    
        $ventasPorMesFormateado = [];
        foreach ($meses as $num => $nombre) {
            $ventasPorMesFormateado[$nombre] = $ventasPorMes[$num] ?? 0;
        }
    
        // Ventas por vendedor
        $ventasPorVendedor = Ventas::with('vendedor')
            ->selectRaw('vendedor_id, COUNT(*) as total')
            ->groupBy('vendedor_id')
            ->get()
            ->mapWithKeys(function ($venta) {
                return [$venta->vendedor->nombre . ' ' . $venta->vendedor->apellido_paterno => $venta->total];
            });
    
        // Cursos más vendidos
        $cursosMasVendidos = Ventas::with('curso')
            ->selectRaw('curso_id, COUNT(*) as total')
            ->groupBy('curso_id')
            ->get()
            ->mapWithKeys(function ($venta) {
                return [$venta->curso->nombre => $venta->total];
            });
    
        return view('modulos.sector_ventas.reportes.index', [
            'ventasPorMes' => $ventasPorMesFormateado,
            'ventasPorVendedor' => $ventasPorVendedor,
            'cursosMasVendidos' => $cursosMasVendidos
        ]);
    }
    
}
