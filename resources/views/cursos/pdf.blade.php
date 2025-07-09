<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Cursos</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 11px;
            margin: 40px;
            color: #2c3e50;
        }
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo img {
            height: 60px;
            margin-bottom: 5px;
        }
        h3 {
            margin: 0;
            font-size: 18px;
            color: #0a3d62;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #0a3d62;
            color: white;
            padding: 6px;
            font-size: 11px;
        }
        td {
            border: 1px solid #333;
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
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;">LISTA GENERAL DE CURSOS</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Área</th>
                <th>Marca</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->area }}</td>
                    <td>{{ $curso->marca }}</td>
                    <td>{{ $curso->fecha }}</td>
                    <td>{{ $curso->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
    </div>

</body>
</html>