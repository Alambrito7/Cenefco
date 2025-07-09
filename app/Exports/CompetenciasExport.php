<?php

namespace App\Exports;

use App\Models\Competencia;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompetenciasExport implements FromCollection
{
    public function collection()
    {
        return Competencia::all();
    }
}
