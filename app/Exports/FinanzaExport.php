<?php

namespace App\Exports;

use App\Models\Finanza;
use Maatwebsite\Excel\Concerns\FromCollection;

class FinanzaExport implements FromCollection
{
    protected $curso;

    public function __construct($curso)
    {
        $this->curso = $curso;
    }

    public function collection()
    {
        return Finanza::with('venta', 'curso')
            ->where('curso_id', $this->curso->id)
            ->get();
    }
}
