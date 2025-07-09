@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">📊 Panel de Estadísticas</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="fs-1">{{ $usuarios }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Clientes</h5>
                    <p class="fs-1">{{ $clientes }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Docentes</h5>
                    <p class="fs-1">{{ $docentes }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Cursos</h5>
                    <p class="fs-1">{{ $cursos }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Distribución de Roles</div>
                <div class="card-body">
                    <canvas id="rolesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rolesChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($roles)) !!},
            datasets: [{
                label: 'Usuarios por Rol',
                data: {!! json_encode(array_values($roles)) !!},
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Usuarios por Rol' }
            }
        }
    });
</script>
@endpush
