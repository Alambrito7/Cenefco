@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">📋 Inscritos por Curso</h2>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>Área</th>
                <th>Curso</th>
                <th>Inscritos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resumenCursos as $curso)
                <tr>
                    <td>{{ $curso['area'] }}</td>
                    <td>{{ $curso['curso'] }}</td>
                    <td><strong>{{ $curso['inscritos'] }}</strong></td>
                    <td class="text-center">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#inscritosModal{{ $curso['curso'] }}">
                            Ver Inscritos
                        </button>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="inscritosModal{{ $curso['curso'] }}" tabindex="-1" aria-labelledby="inscritosModalLabel{{ $curso['curso'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="inscritosModalLabel{{ $curso['curso'] }}">Inscritos en el curso {{ $curso['curso'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(isset($curso['inscritos_lista']) && !empty($curso['inscritos_lista']))
                                        <ul>
                                            @foreach($curso['inscritos_lista'] as $inscrito)
                                                <li><strong>{{ $inscrito['nombre_completo'] }}</strong></li> <!-- Solo mostramos el nombre completo -->
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No hay inscritos registrados para este curso.</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay datos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
