<?php

namespace App\Http\Controllers;

use App\Models\{Ventas, Cliente, Curso, Personal, Descuento, Pago};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;


class VentasController extends Controller
{
    public function index(Request $request)
    {
        $query = Ventas::with(['cliente', 'curso', 'vendedor'])
                        ->whereNull('deleted_at');
    
        // 🔍 Filtro por rango de fechas (corrige hasta el final del día)
        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $fechaDesde = $request->fecha_desde . ' 00:00:00';
            $fechaHasta = $request->fecha_hasta . ' 23:59:59';
            $query->whereBetween('fecha_venta', [$fechaDesde, $fechaHasta]);
        } elseif ($request->filled('fecha_desde')) {
            $query->where('fecha_venta', '>=', $request->fecha_desde . ' 00:00:00');
        } elseif ($request->filled('fecha_hasta')) {
            $query->where('fecha_venta', '<=', $request->fecha_hasta . ' 23:59:59');
        }
    
        $ventas = $query->orderBy('fecha_venta', 'desc')->paginate(5);
    
        $ventasEliminadas = Ventas::onlyTrashed()
                                ->with(['cliente', 'curso', 'vendedor'])
                                ->orderBy('fecha_venta', 'desc')
                                ->get();
    
        return view('modulos.sector_ventas.rventas.index', compact('ventas', 'ventasEliminadas'));
    }
    
    public function create()
    {
        $clientes = Cliente::all();
        $cursos = Curso::all();
        $vendedores = Personal::whereIn('cargo', ['Ejecutivo de Ventas', 'Supervisor de Ventas'])->get();
        $descuentos = Descuento::all();

        return view('modulos.sector_ventas.rventas.create', compact('clientes', 'cursos', 'vendedores', 'descuentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'curso_id' => 'required|exists:cursos,id',
            'vendedor_id' => 'required|exists:personals,id',
            'costo_curso' => 'required|numeric',
            'estado_venta' => 'required|in:Pagado,Plan de Pagos,Anulado',
            'forma_pago' => 'required|in:Contado Oficina,Transferencia Bancaria,Pago por QR',
            'descuento_id' => 'nullable|exists:descuentos,id',
            'primer_pago' => 'nullable|numeric',
            'total_pagado' => 'nullable|numeric',
            'comprobante_pago' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'baucher_numero' => 'nullable|string',
            'baucher_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // Nuevos campos
            'numero_transaccion' => 'nullable|string|unique:ventas,numero_transaccion',
            'banco' => 'nullable|in:BCP,Tigo Money,B U,Recibo,WesterUnion',
        ]);

        $data = $request->all();
        $data['fecha_venta'] = Carbon::now();

        // Guardar foto de baucher
        if ($request->hasFile('baucher_foto')) {
            $data['baucher_foto'] = $request->file('baucher_foto')->store('baucher_photos', 'public');
        }

        // Calcular descuento
        $monto_descuento = 0;
        if ($request->descuento_id) {
            $descuento = Descuento::find($request->descuento_id);
            $monto_descuento = ceil(($request->costo_curso * $descuento->porcentaje) / 100);
        }

        $total_con_descuento = $request->costo_curso - $monto_descuento;
        $primer_pago = null;
        $total_pagado = null;
        $saldo_pago = 0;

        if ($request->estado_venta === 'Pagado') {
            $total_pagado = $total_con_descuento;
            $saldo_pago = 0;
        } elseif ($request->estado_venta === 'Plan de Pagos') {
            $primer_pago = $request->primer_pago;
            $saldo_pago = $total_con_descuento - $primer_pago;
        }

        if ($request->hasFile('comprobante_pago')) {
            $data['comprobante_pago'] = $request->file('comprobante_pago')->store('comprobantes', 'public');
        }

        $data['descuento_monto'] = $monto_descuento;
        $data['saldo_pago'] = $saldo_pago;
        $data['total_pagado'] = $total_pagado;
        $data['primer_pago'] = $primer_pago;

        Ventas::create($data);

        return redirect()->route('rventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function edit(Ventas $rventa)
    {
        $clientes = Cliente::all();
        $cursos = Curso::all();
        $vendedores = Personal::whereIn('cargo', ['Ejecutivo de Ventas', 'Supervisor de Ventas'])->get();
        $descuentos = Descuento::all();

        return view('modulos.sector_ventas.rventas.edit', [
            'venta' => $rventa,
            'clientes' => $clientes,
            'cursos' => $cursos,
            'vendedores' => $vendedores,
            'descuentos' => $descuentos
        ]);
    }

    public function update(Request $request, $id)
    {
        $venta = Ventas::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'curso_id' => 'required|exists:cursos,id',
            'vendedor_id' => 'required|exists:personals,id',
            'costo_curso' => 'required|numeric',
            'estado_venta' => 'required|in:Pagado,Plan de Pagos,Anulado',
            'forma_pago' => 'required|in:Contado Oficina,Transferencia Bancaria,Pago por QR',
            'descuento_id' => 'nullable|exists:descuentos,id',
            'primer_pago' => 'nullable|numeric',
            'total_pagado' => 'nullable|numeric',
            'comprobante_pago' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            // Nuevos campos con validación única excluyendo el registro actual
            'numero_transaccion' => [
                'nullable', 
                'string', 
                Rule::unique('ventas', 'numero_transaccion')->ignore($venta->id)
            ],
            'banco' => 'nullable|in:BCP,Tigo Money,B U,Recibo,WesterUnion',
        ]);

        $data = $request->except(['_token', '_method']);

        // Calcular descuento
        $monto_descuento = 0;
        if ($request->descuento_id) {
            $descuento = Descuento::find($request->descuento_id);
            if ($descuento) {
                $monto_descuento = ceil(($request->costo_curso * $descuento->porcentaje) / 100);
            }
        }

        $data['descuento_monto'] = $monto_descuento;
        $total_con_descuento = $request->costo_curso - $monto_descuento;

        // Pagos
        $data['total_pagado'] = null;
        $data['primer_pago'] = null;
        $data['saldo_pago'] = 0;

        if ($request->estado_venta === 'Pagado') {
            $data['total_pagado'] = $request->total_pagado;
            $data['saldo_pago'] = $total_con_descuento - $request->total_pagado;
        } elseif ($request->estado_venta === 'Plan de Pagos') {
            $data['primer_pago'] = $request->primer_pago;
            $data['saldo_pago'] = $total_con_descuento - $request->primer_pago;
        }

        // Comprobante
        if ($request->hasFile('comprobante_pago')) {
            if ($venta->comprobante_pago) {
                Storage::disk('public')->delete($venta->comprobante_pago);
            }
            $data['comprobante_pago'] = $request->file('comprobante_pago')->store('comprobantes', 'public');
        }

        // Guardar cambios
        $venta->update($data);

        return redirect()->route('rventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $venta = Ventas::findOrFail($id);
        $venta->delete();

        return redirect()->route('rventas.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function restore($id)
    {
        $venta = Ventas::withTrashed()->findOrFail($id);
        $venta->restore();

        return redirect()->route('rventas.index')->with('success', 'Venta restaurada correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $query = Ventas::withTrashed()->with(['cliente', 'curso', 'vendedor']);

        // Filtro por rango de fechas
        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $desde = $request->fecha_desde . ' 00:00:00';
            $hasta = $request->fecha_hasta . ' 23:59:59';
            $query->whereBetween('fecha_venta', [$desde, $hasta]);
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();

        // 🧮 Totales
        $totalCosto = $ventas->sum('costo_curso');
        $totalDescuento = $ventas->sum('descuento_monto');
        $totalPrimerPago = $ventas->sum('primer_pago');
        $totalPagado = $ventas->sum('total_pagado');
        $totalSaldo = $ventas->sum('saldo_pago');

        // PDF
        $pdf = Pdf::loadView('modulos.sector_ventas.rventas.pdf', compact(
            'ventas', 'totalCosto', 'totalDescuento', 'totalPrimerPago', 'totalPagado', 'totalSaldo'
        ))->setPaper('A4', 'landscape');

        return $pdf->download('ventas.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new VentasExport($request->fecha_desde, $request->fecha_hasta),
            'ventas.xlsx'
        );
    }

    public function pendientes()
    {
        // Obtener las ventas pendientes, agrupadas por curso
        $ventasPendientes = Ventas::with(['cliente', 'curso', 'vendedor'])
            ->where('estado_venta', 'Plan de Pagos')
            ->get()
            ->groupBy('curso_id');

        // Obtener el historial de pagos, agrupado por curso
        $historialPagos = Pago::with('venta.cliente', 'venta.curso')
            ->latest()
            ->take(20)
            ->get()
            ->groupBy(function($pago) {
                return $pago->venta->curso->nombre;
            });

        return view('modulos.sector_ventas.rventas.pendientes', compact('ventasPendientes', 'historialPagos'));
    }

    public function completarPago(Request $request, $id)
    {
        $venta = Ventas::findOrFail($id);

        $request->validate([
            'monto' => ['required', 'numeric', 'min:1', 'max:' . $venta->saldo_pago],
            'baucher_numero' => 'nullable|string',
            'baucher_foto' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            // Nuevos campos para los pagos
            'numero_transaccion' => 'nullable|string|unique:pagos,numero_transaccion',
            'banco' => 'nullable|in:BCP,Tigo Money,B U,Recibo,WesterUnion',
        ]);

        // Registrar pago
        $pago = Pago::create([
            'venta_id' => $venta->id,
            'monto' => $request->monto,
            'registrado_por' => auth()->user()->name ?? 'Sistema',
            'baucher_numero' => $request->baucher_numero,
            'numero_transaccion' => $request->numero_transaccion,
            'banco' => $request->banco,
        ]);

        // Guardar la foto del baucher, si se proporcionó
        if ($request->hasFile('baucher_foto')) {
            $pago->baucher_foto = $request->file('baucher_foto')->store('baucher_fotos', 'public');
            $pago->save();
        }

        // Actualizar saldo y estado de la venta
        $venta->saldo_pago -= $request->monto;
        if ($venta->saldo_pago <= 0) {
            $venta->estado_venta = 'Pagado';
            $venta->total_pagado = $venta->costo_curso - $venta->descuento_monto;
        }
        $venta->save();

        return back()->with('success', 'Pago registrado correctamente.');
    }

    public function ventasPorArea()
    {
        $ventasPorArea = \App\Models\Ventas::with(['curso', 'cliente', 'vendedor'])
            ->whereNull('deleted_at')
            ->get()
            ->groupBy(function ($venta) {
                return $venta->curso->area;
            });

        return view('modulos.sector_ventas.rventas.ventas_por_area', compact('ventasPorArea'));
    }

    public function resumenPorCurso()
    {
        $resumenCursos = \App\Models\Ventas::with(['curso', 'cliente'])
        ->whereNull('deleted_at')
        ->get()
        ->groupBy('curso_id')
        ->map(function ($ventasCurso) {
            $curso = $ventasCurso->first()->curso;
            $inscritosLista = $ventasCurso->map(function ($venta) {
                return [
                    'id' => $venta->cliente->id,
                    'nombre_completo' => $venta->cliente->nombre . ' ' . $venta->cliente->apellido_paterno . ' ' . $venta->cliente->apellido_materno
                ];
            });

            return [
                'curso' => $curso->nombre,
                'area' => $curso->area,
                'inscritos' => $ventasCurso->count(),
                'inscritos_lista' => $inscritosLista
            ];
        });

        return view('modulos.sector_ventas.reportes.resumen_por_curso', compact('resumenCursos'));
    }
}