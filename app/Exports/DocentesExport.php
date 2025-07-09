<?php

namespace App\Exports;

use App\Models\Docente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocentesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Docente::withTrashed()->get([
            'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'telefono', 'correo',
            'nacionalidad', 'edad', 'grado_academico', 'experiencia', 'impartio_clases'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Teléfono', 'Correo',
            'Nacionalidad', 'Edad', 'Grado Académico', 'Experiencia', 'Impartió Clases'
        ];
    }
}
