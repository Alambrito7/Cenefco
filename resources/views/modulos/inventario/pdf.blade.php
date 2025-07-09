<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 11px;
            color: #2c3e50;
            margin: 40px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 20px;
            margin-bottom: 0;
            color: #0a3d62;
        }
        .sub {
            font-size: 13px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #0a3d62;
            color: white;
            padding: 6px;
            font-size: 11px;
        }
        td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 10px;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
            color: #888;
        }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 10px;">
    <h2 style="margin: 0; font-size: 22px; font-weight: bold;">CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;">LISTA DE INVENTARIO GENERAL</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <thead>
        <tr>
            <th>Código AF</th>
            <th>Nombre</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>IMEI 1</th>
            <th>IMEI 2</th>
            <th>SIM 1</th>
            <th>SIM 2</th>
            <th>Estado</th>
            <th>Destino</th>
            <th>Responsable</th>
            <th>Valor (Bs)</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventarios as $inv)
        <tr>
            <td>{{ $inv->codigo_af }}</td>
            <td>{{ $inv->nombre }}</td>
            <td>{{ $inv->concepto_1 }}</td>
            <td>{{ $inv->concepto_2 }}</td>
            <td>{{ $inv->imei_1 }}</td>
            <td>{{ $inv->imei_2 }}</td>
            <td>{{ $inv->sim_1 }}</td>
            <td>{{ $inv->sim_2 }}</td>
            <td>{{ $inv->estado }}</td>
            <td>{{ $inv->destino }}</td>
            <td>{{ $inv->responsable->nombre ?? '—' }}</td>
            <td>Bs {{ number_format($inv->valor, 2) }}</td>
            <td>{{ $inv->observaciones }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>
