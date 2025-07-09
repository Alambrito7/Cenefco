@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">🧮 Historial de Arqueos</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- ✅ Resumen Diario --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body text-center">
                    <h6 class="text-success fw-bold">Ingresos por Ventas (Pagado)</h6>
                    <p class="fs-5 text-dark">Bs {{ number_format($ventasPagadasHoy, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <h6 class="text-primary fw-bold">Abonos del Día</h6>
                    <p class="fs-5 text-dark">Bs {{ number_format($abonosHoy, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body text-center">
                    <h6 class="text-dark fw-bold">Total Ingresos</h6>
                    <p class="fs-5 fw-bold text-success">Bs {{ number_format($totalIngresos, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔘 Botón para generar arqueo --}}
    <div class="mb-4 text-end">
        <form action="{{ route('arqueo.generar') }}" method="POST">
            @csrf
            <button class="btn btn-primary">➕ Generar arqueo del día</button>
        </form>
    </div>

    {{-- 📜 Tabla de arqueos --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Ingresos</th>
                    <th>Egresos</th>
                    <th>Saldo Final</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arqueos as $i => $arqueo)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($arqueo->fecha_arqueo)->format('d/m/Y') }}</td>
                        <td>Bs {{ number_format($arqueo->ingresos, 2) }}</td>
                        <td>Bs {{ number_format($arqueo->egresos, 2) }}</td>
                        <td class="fw-bold {{ $arqueo->saldo_final < 0 ? 'text-danger' : 'text-success' }}">
                            Bs {{ number_format($arqueo->saldo_final, 2) }}
                        </td>
                        <td>{{ $arqueo->usuario->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay arqueos registrados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
