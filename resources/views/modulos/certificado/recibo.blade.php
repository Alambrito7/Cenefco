<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Entrega de Certificado</title>
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
            width: 120px;
        }
        h2 {
            font-size: 20px;
            margin: 10px 0 0;
            color: #0a3d62;
        }
        h3 {
            font-size: 16px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #0a3d62;
            color: white;
            padding: 6px;
            font-size: 10px;
        }
        td {
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
            color: #888;
        }
        .firmas {
            margin-top: 40px;
        }
        .firmas td {
            border: none;
            padding: 40px 10px 10px;
            text-align: center;
        }
        .firmas td span {
            display: block;
            border-top: 1px solid #000;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 180px; margin-bottom: 10px;">
    <h2>CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3>RECIBO DE ENTREGA DE CERTIFICADO</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <tr>
        <th>Cliente</th>
        <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</td>
    </tr>
    <tr>
        <th>Curso</th>
        <td>{{ $curso->nombre }} ({{ $curso->area }})</td>
    </tr>
    <tr>
        <th>Fecha de Entrega</th>
        <td>{{ \Carbon\Carbon::parse($certificado->fecha_entrega)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th>Modalidad</th>
        <td>{{ $certificado->modalidad_entrega }}</td>
    </tr>
    <tr>
        <th>Personal que Entregó</th>
        <td>
    {{ $certificado->personal ? $certificado->personal->nombre . ' ' . $certificado->personal->apellido_paterno : ($certificado->personal_entrego ?? '-') }}
</td>

    </tr>
    <tr>
        <th>Observaciones</th>
        <td>{{ $certificado->observaciones ?? '-' }}</td>
    </tr>
</table>

<table class="firmas" width="100%">
    <tr>
        <td>
            <span>Firma del Cliente</span>
        </td>
        <td>
            <span>Responsable de Entrega</span>
        </td>
    </tr>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>
