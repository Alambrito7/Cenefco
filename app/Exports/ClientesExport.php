<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientesExport implements FromCollection
{
    public function collection()
    {
        return Cliente::withTrashed()->get();
    }
}
