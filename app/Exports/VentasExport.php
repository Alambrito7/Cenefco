<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class VentasExport implements FromCollection, WithHeadings
{
    protected $desde;
    protected $hasta;

    public function __construct($desde = null, $hasta = null)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function collection()
    {
        $query = Ventas::withTrashed()->with(['cliente', 'curso', 'vendedor']);

        if ($this->desde && $this->hasta) {
            $query->whereBetween('fecha_venta', [
                $this->desde . ' 00:00:00',
                $this->hasta . ' 23:59:59'
            ]);
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();

        // Mapeo de filas de ventas
        $filas = $ventas->map(function ($venta) {
            return [
                'ID'                => $venta->id,
                'Cliente'           => $venta->cliente->nombre . ' ' . $venta->cliente->apellido_paterno,
                'Curso'             => $venta->curso->nombre,
                'Vendedor'          => $venta->vendedor->nombre . ' ' . $venta->vendedor->apellido_paterno,
                'Estado de Venta'   => $venta->estado_venta,
                'Forma de Pago'     => $venta->forma_pago,
                'Fecha de Venta'    => $venta->fecha_venta,
                'Costo del Curso'   => $venta->costo_curso,
                'Descuento'         => $venta->descuento_monto,
                'Primer Pago'       => $venta->primer_pago,
                'Total Pagado'      => $venta->total_pagado,
                'Saldo Pendiente'   => $venta->saldo_pago,
            ];
        });

        // Fila de totales
        $total = [
            '', '', '', '', '', '', 'Totales:',
            $ventas->sum('costo_curso'),
            $ventas->sum('descuento_monto'),
            $ventas->sum('primer_pago'),
            $ventas->sum('total_pagado'),
            $ventas->sum('saldo_pago')
        ];

        // Agregamos los totales como una fila extra al final
        $filas->push($total);

        return $filas;
    }

    public function headings(): array
    {
        return [
            'ID', 'Cliente', 'Curso', 'Vendedor', 'Estado de Venta', 'Forma de Pago',
            'Fecha de Venta', 'Costo del Curso', 'Descuento', 'Primer Pago',
            'Total Pagado', 'Saldo Pendiente'
        ];
    }
}
