<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Ventas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Gráfico de ventas por mes
        $ventasDelAnio = Ventas::selectRaw('MONTH(fecha_venta) as mes, COUNT(*) as total')
            ->whereYear('fecha_venta', Carbon::now()->year)
            ->where('estado_venta', '!=', 'Anulado') // opcional
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();
    
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $ventasPorMes = [];
    
        for ($i = 1; $i <= 12; $i++) {
            $ventasPorMes[] = $ventasDelAnio[$i] ?? 0;
        }
    
        // Obtener las ventas (inscritos)
        $ventas = Ventas::all();  // Esto obtendrá todas las ventas
    
        return view('dashboards.superadmin', [
            'usuarios' => User::count(),
            'clientes' => Cliente::count(),
            'docentes' => Docente::count(),
            'cursos' => Curso::count(),
            'roles' => User::select('role')->get()->groupBy('role')->map->count()->toArray(),
            'meses' => $meses,
            'ventasPorMes' => $ventasPorMes,
            'ventas' => $ventas // Pasar las ventas a la vista
        ]);
    }
    
}
