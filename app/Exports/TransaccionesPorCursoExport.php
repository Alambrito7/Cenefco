<?php

namespace App\Exports;

use App\Models\Finanza;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaccionesPorCursoExport implements FromCollection, WithHeadings, WithMapping
{
    protected $curso;

    public function __construct($curso)
    {
        $this->curso = $curso;
    }

    public function collection()
    {
        // Recupera las transacciones del curso
        return Finanza::where('curso_id', $this->curso->id)->get();
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Curso',
            'Monto',
            'Banco',
            'Transacción',
            'Fecha y Hora',
        ];
    }

    public function map($transaccion): array
    {
        return [
            $transaccion->cliente->nombre . ' ' . $transaccion->cliente->apellido_paterno,
            $transaccion->curso->nombre,
            $transaccion->monto,
            $transaccion->banco,
            $transaccion->nro_transaccion,
            $transaccion->fecha_hora,
        ];
    }
}
