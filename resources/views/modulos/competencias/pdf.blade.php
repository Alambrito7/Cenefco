<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Competencias</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 11px;
            color: #2c3e50;
            margin: 40px;
        }
        .logo img {
            width: 100px;
        }
        h2 {
            font-size: 20px;
            color: #0a3d62;
        }
        h3 {
            font-size: 18px;
            color: #2c3e50;
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
    <h2>CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3>LISTA DE COMPETENCIAS REGISTRADAS</h3>
    <hr style="border-top: 2px solid #000;">
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Página Central</th>
            <th>Subpágina</th>
            <th>Área</th>
            <th>Curso</th>
            <th>Docente</th>
            <th>F. Publicación</th>
            <th>F. Inicio</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($competencias as $comp)
            <tr>
                <td>{{ $comp->id }}</td>
                <td>{{ $comp->pagina_central }}</td>
                <td>{{ $comp->subpagina }}</td>
                <td>{{ $comp->area }}</td>
                <td>{{ $comp->curso }}</td>
                <td>{{ $comp->docente }}</td>
                <td>{{ $comp->fecha_publicacion }}</td>
                <td>{{ $comp->fecha_inicio }}</td>
                <td>{{ strtoupper($comp->estado) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>
