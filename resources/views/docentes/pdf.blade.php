<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Docentes</title>
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
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;"> LISTA  DE DOCENTES REGISTRADOS </h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Nacionalidad</th>
                <th>Edad</th>
                <th>Grado</th>
                <th>Experiencia</th>
                <th>Impartió</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docentes as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->nombre }} {{ $d->apellido_paterno }} {{ $d->apellido_materno }}</td>
                <td>{{ $d->telefono }}</td>
                <td>{{ $d->correo }}</td>
                <td>{{ $d->nacionalidad }}</td>
                <td>{{ $d->edad }}</td>
                <td>{{ $d->grado_academico }}</td>
                <td>{{ $d->experiencia }}</td>
                <td>{{ $d->impartio_clases ? 'Sí' : 'No' }}</td>
                <td style="color: {{ $d->deleted_at ? 'red' : 'green' }}">
                    {{ $d->deleted_at ? 'Eliminado' : 'Activo' }}
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