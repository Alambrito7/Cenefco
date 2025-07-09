<?php

namespace App\Exports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Inventario::with('responsable')->get()->map(function ($item) {
            return [
                'Código AF'     => $item->codigo_af,
                'Nombre'        => $item->nombre,
                'Modelo'        => $item->concepto_1,
                'Color'         => $item->concepto_2,
                'IMEI 1'        => $item->imei_1,
                'IMEI 2'        => $item->imei_2,
                'SIM 1'         => $item->sim_1,
                'SIM 2'         => $item->sim_2,
                'Estado'        => $item->estado,
                'Destino'       => $item->destino,
                'Responsable'   => optional($item->responsable)->nombre,
                'Valor (Bs)'    => $item->valor,
                'Observaciones' => $item->observaciones,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Código AF', 'Nombre', 'Modelo', 'Color', 'IMEI 1', 'IMEI 2',
            'SIM 1', 'SIM 2', 'Estado', 'Destino', 'Responsable', 'Valor (Bs)', 'Observaciones'
        ];
    }
}
