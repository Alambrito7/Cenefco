<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arqueo;
use App\Models\Ventas;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class ArqueoController extends Controller
{
    public function index()
    {
        $fechaHoy = Carbon::now()->toDateString();

        // Historial de arqueos
        $arqueos = Arqueo::with('usuario')->latest()->get();

        // Resumen diario para mostrar en la vista
        $ventasPagadasHoy = Ventas::whereDate('fecha_venta', $fechaHoy)
                                ->where('estado_venta', 'Pagado')
                                ->sum('total_pagado');

        $abonosHoy = Pago::whereDate('created_at', $fechaHoy)->sum('monto');

        $egresosHoy = 0; // si tienes una tabla de egresos, cámbialo aquí

        $totalIngresos = $ventasPagadasHoy + $abonosHoy;

        return view('modulos.arqueo.index', compact(
            'arqueos',
            'ventasPagadasHoy',
            'abonosHoy',
            'egresosHoy',
            'totalIngresos'
        ));
    }

    public function generar(Request $request)
    {
        $fecha = Carbon::now()->toDateString();

        $ventas = Ventas::whereDate('fecha_venta', $fecha)
                        ->where('estado_venta', 'Pagado')
                        ->get();
        $ingresosVentas = $ventas->sum('total_pagado');

        $pagos = Pago::whereDate('created_at', $fecha)->get();
        $ingresosPagos = $pagos->sum('monto_pagado');

        $totalIngresos = $ingresosVentas + $ingresosPagos;
        $egresos = 0; // ajustar si manejas tabla de egresos

        $arqueo = new Arqueo();
        $arqueo->fecha_arqueo = $fecha;
        $arqueo->ingresos = $totalIngresos;
        $arqueo->egresos = $egresos;
        $arqueo->saldo_final = $totalIngresos - $egresos;
        $arqueo->usuario_id = Auth::id();
        $arqueo->save();

        // ✅ Generar PDF
        $pdf = Pdf::loadView('modulos.arqueo.pdf', [
            'arqueo' => $arqueo,
            'ventas' => $ventas,
            'abonos' => $pagos
        ]);

        // ⬇ Descargar PDF al finalizar
        return $pdf->download('arqueo_' . $fecha . '.pdf');

        return redirect()->back()->with('success', '✅ Arqueo generado correctamente.');
    }
}
