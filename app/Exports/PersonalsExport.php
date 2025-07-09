<?php

namespace App\Exports;

use App\Models\Personal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Personal::withTrashed()->get([
            'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'ci', 'edad',
            'genero', 'telefono', 'correo', 'cargo'
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Paterno', 'Materno', 'CI', 'Edad', 'Género', 'Teléfono', 'Correo', 'Cargo'];
    }
}
