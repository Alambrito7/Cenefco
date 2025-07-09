@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Inscritos en el Curso: {{ $curso->nombre }}</h2>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($curso->inscritos as $inscrito)
                <tr>
                    <td>{{ $inscrito->id }}</td>
                    <td>{{ $inscrito->nombre_completo }}</td>
                    <td>{{ $inscrito->correo_electronico }}</td>
                    <td>{{ $inscrito->fecha_inscripcion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay estudiantes inscritos en este curso.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
