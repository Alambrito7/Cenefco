<?php

namespace App\Exports;

use App\Models\Curso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CursosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Curso::withTrashed()->get([
            'id', 'nombre', 'area', 'marca', 'fecha', 'estado'
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Área', 'Marca', 'Fecha', 'Estado'];
    }
}
