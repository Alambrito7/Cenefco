@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">📚 Ventas por Área Académica</h2>
        <a href="{{ route('ventas.por.curso') }}" class="btn btn-outline-primary">
            📊 Ver Inscritos por Curso
        </a>
    </div>

    @foreach ($ventasPorArea as $area => $ventas)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Área: {{ $area }}</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover text-center m-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Curso</th>
                            <th>Vendedor</th>
                            <th>Estado</th>
                            <th>Forma de Pago</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</td>
                                <td>{{ $venta->curso->nombre }}</td>
                                <td>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellido_paterno }}</td>
                                <td>
                                    @if($venta->estado_venta == 'Pagado')
                                        <span class="badge bg-success">Pagado</span>
                                    @elseif($venta->estado_venta == 'Plan de Pagos')
                                        <span class="badge bg-warning text-dark">Plan de Pagos</span>
                                    @else
                                        <span class="badge bg-danger">Anulado</span>
                                    @endif
                                </td>
                                <td>{{ $venta->forma_pago }}</td>
                                <td>{{ $venta->fecha_venta }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
