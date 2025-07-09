<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 10px;
            color: #2c3e50;
            margin: 30px;
        }
        header {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            width: 100px;
        }
        h2 {
            font-size: 20px;
            margin: 10px 0 0;
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
            padding: 4px;
            font-size: 9px;
            text-align: center;
        }
        td {
            border: 1px solid #ccc;
            padding: 4px;
            font-size: 9px;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
            color: #888;
        }
        .cliente-col {
            width: 14%;
        }
        .curso-col {
            width: 14%;
        }
        .vendedor-col {
            width: 12%;
        }
        .numero-col {
            width: 10%;
        }
        .banco-col {
            width: 10%;
        }
        .monto-col {
            width: 8%;
        }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 10px;">
    <h2 style="margin: 0; font-size: 22px; font-weight: bold;">CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;">LISTA DE REGISTRO DE VENTAS</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <thead>
        <tr>
            <th style="width: 3%;">ID</th>
            <th class="cliente-col">Cliente</th>
            <th class="curso-col">Curso</th>
            <th class="vendedor-col">Vendedor</th>
            <th style="width: 8%;">Estado</th>
            <th style="width: 8%;">Forma Pago</th>
            <th style="width: 8%;">Fecha</th>
            <th class="numero-col">Nº Transacción</th>
            <th class="banco-col">Banco</th>
            <th class="monto-col">Costo</th>
            <th class="monto-col">Descuento</th>
            <th class="monto-col">Primer Pago</th>
            <th class="monto-col">Total Pagado</th>
            <th class="monto-col">Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
            <td>{{ $venta->curso->nombre }}</td>
            <td>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellido_paterno }}</td>
            <td>{{ $venta->estado_venta }}</td>
            <td>{{ $venta->forma_pago }}</td>
            <td>{{ date('d/m/Y', strtotime($venta->fecha_venta)) }}</td>
            <td>{{ $venta->numero_transaccion ?? '-' }}</td>
            <td>{{ $venta->banco ?? '-' }}</td>
            <td>{{ number_format($venta->costo_curso, 2) }}</td>
            <td>{{ number_format($venta->descuento_monto, 2) }}</td>
            <td>{{ number_format($venta->primer_pago, 2) }}</td>
            <td>{{ number_format($venta->total_pagado, 2) }}</td>
            <td>{{ number_format($venta->saldo_pago, 2) }}</td>
        </tr>
        @endforeach

        {{-- 🧮 Fila de Totales --}}
        <tr style="font-weight: bold; background-color: #f0f0f0;">
            <td colspan="9" style="text-align: right;">Totales:</td>
            <td>{{ number_format($totalCosto, 2) }}</td>
            <td>{{ number_format($totalDescuento, 2) }}</td>
            <td>{{ number_format($totalPrimerPago, 2) }}</td>
            <td>{{ number_format($totalPagado, 2) }}</td>
            <td>{{ number_format($totalSaldo, 2) }}</td>
        </tr>
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>