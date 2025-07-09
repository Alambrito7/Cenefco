<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes - CENEFCO</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 50px; }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #0a3d62;
            padding-bottom: 10px;
        }
        .logo {
            height: 60px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #0a3d62;
            color: white;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>


<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 10px;">
    <h2 style="margin: 0; font-size: 22px; font-weight: bold;">CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;"> LISTA  DE CLIENTES REGISTRADOS </h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>CI</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Departamento</th>
            <th>Provincia</th>
            <th>Género</th>
            <th>País</th>
            <th>Profesión</th>
            <th>Grado Académico</th>
            <th>Edad</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</td>
                <td>{{ $cliente->ci }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->celular }}</td>
                <td>{{ $cliente->departamento }}</td>
                <td>{{ $cliente->provincia }}</td>
                <td>{{ $cliente->genero }}</td>
                <td>{{ $cliente->pais }}</td>
                <td>{{ $cliente->profesion }}</td>
                <td>{{ $cliente->grado_academico }}</td>
                <td>{{ $cliente->edad }}</td>
                <td>{{ $cliente->deleted_at ? 'Eliminado' : 'Activo' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
</div>

</body>
</html>