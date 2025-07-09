<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Transacciones por Curso</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            font-size: 11px; 
            color: #2c3e50; 
            margin: 40px; 
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
            padding: 6px; 
            font-size: 10px; 
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
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;">TRANSACCIONES REGISTRADAS POR CURSO</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Curso</th>
            <th>Monto</th>
            <th>Banco</th>
            <th>Transacción</th>
            <th>Fecha y Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaccionesPorCurso as $transaccion)
        <tr>
            <td>{{ $transaccion->venta->cliente->nombre }} {{ $transaccion->venta->cliente->apellido_paterno }}</td>
            <td>{{ $transaccion->curso->nombre }}</td>
            <td>Bs {{ number_format($transaccion->monto, 2) }}</td>
            <td>{{ $transaccion->banco }}</td>
            <td>{{ $transaccion->nro_transaccion }}</td>
            <td>{{ $transaccion->fecha_hora }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>
