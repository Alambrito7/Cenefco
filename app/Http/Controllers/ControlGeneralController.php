<?php

namespace App\Http\Controllers;

use App\Models\Finanza;
use App\Models\Cliente;
use App\Models\EntregaMaterial;
use Illuminate\Http\Request;

class ControlGeneralController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las transacciones con las relaciones necesarias
        $transacciones = Finanza::with(['venta.cliente', 'venta.curso', 'venta.entregaMaterial'])
            ->join('entrega_materials', 'entrega_materials.venta_id', '=', 'finanzas.venta_id') // Relación entre finanzas y entrega_materials
            ->get();

        // Agrupar por el nombre del curso
        $transaccionesAgrupadas = $transacciones->groupBy(function($item) {
            return $item->venta->curso->nombre; // Agrupar por nombre del curso
        });

        return view('controlGeneral.index', compact('transaccionesAgrupadas'));
    }
}

