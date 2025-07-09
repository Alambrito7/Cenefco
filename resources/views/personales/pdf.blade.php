<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Personal</title>
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
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;"> LISTA  DE PERSONAL </h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>CI</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Cargo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personals as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nombre }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}</td>
                <td>{{ $p->ci }}</td>
                <td>{{ $p->edad }}</td>
                <td>{{ $p->genero }}</td>
                <td>{{ $p->telefono }}</td>
                <td>{{ $p->correo }}</td>
                <td>{{ $p->cargo }}</td>
                <td style="color: {{ $p->deleted_at ? 'red' : 'green' }}">
                    {{ $p->deleted_at ? 'Inactivo' : 'Activo' }}
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