<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InscritosExport implements FromCollection, WithHeadings
{
    protected $cursoId;

    public function __construct($cursoId)
    {
        $this->cursoId = $cursoId;
    }

    public function collection()
    {
        return Ventas::where('curso_id', $this->cursoId)
                    ->with('cliente', 'entregaMaterial') // Asegúrate de incluir las relaciones necesarias
                    ->get()
                    ->map(function($venta) {
                        return [
                            $venta->cliente->nombre_completo ?? 'Sin nombre',
                            $venta->entregaMaterial ? $venta->entregaMaterial->opcion_entrega : 'Sin selección',
                        ];
                    });
    }

    public function headings(): array
    {
        return [
            'Nombre del Cliente',
            'Opción de Entrega',
        ];
    }
}

