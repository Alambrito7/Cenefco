<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inscritos - {{ $curso->nombre }}</title>
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
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;"> LISTA DE INSCRITOS - {{ $curso->nombre }}</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Opción de Entrega</th>
            <th>Costo CD</th> <!-- Agregado costo CD -->
        </tr>
    </thead>
    <tbody>
        @foreach($curso->ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->cliente->nombre_completo }}</td>
            <td>
                @if($venta->entregaMaterial)
                    {{ $venta->entregaMaterial->opcion_entrega }}
                @else
                    Sin selección
                @endif
            </td>
            <td>
                @if($venta->entregaMaterial && $venta->entregaMaterial->opcion_entrega == 'CD')
                    Bs {{ $venta->entregaMaterial->costo_cd ?? 'No disponible' }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>
