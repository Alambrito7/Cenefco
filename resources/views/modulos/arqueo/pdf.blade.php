<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Arqueo Diario</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        .resumen { margin-top: 30px; }
    </style>
</head>
<body>

    <h1>🧾 Reporte Diario de Arqueo</h1>

    <p><strong>Fecha del arqueo:</strong> {{ \Carbon\Carbon::parse($arqueo->fecha_arqueo)->format('d/m/Y') }}</p>
    <p><strong>Responsable:</strong> {{ $arqueo->usuario->name ?? '—' }}</p>

    <div class="resumen">
        <table>
            <tr>
                <th>Detalle</th>
                <th>Monto (Bs)</th>
            </tr>
            <tr>
                <td>Ingresos por ventas (Pagado)</td>
                <td>{{ number_format($arqueo->ingresos - $abonos->sum('monto'), 2) }}</td>
            </tr>
            <tr>
                <td>Ingresos por abonos</td>
                <td>{{ number_format($abonos->sum('monto'), 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Ingresos</strong></td>
                <td><strong>{{ number_format($arqueo->ingresos, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Egresos</td>
                <td>{{ number_format($arqueo->egresos, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Saldo Final</strong></td>
                <td><strong>{{ number_format($arqueo->saldo_final, 2) }}</strong></td>
            </tr>
        </table>
    </div>

</body>
</html>
