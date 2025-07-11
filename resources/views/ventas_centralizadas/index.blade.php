@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Ventas Centralizadas por Curso
                </h2>
                
                <!-- Botones de Exportación -->
                <div class="btn-group" role="group">
                    <a href="{{ route('ventas_centralizadas.exportar_pdf') }}" 
                       class="btn btn-danger" 
                       target="_blank"
                       title="Exportar a PDF">
                        <i class="fas fa-file-pdf me-2"></i>
                        Exportar PDF
                    </a>

                    <button type="button" 
                            class="btn btn-info" 
                            onclick="printTable()"
                            title="Imprimir">
                        <i class="fas fa-print me-2"></i>
                        Imprimir
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Cursos</h6>
                                    <h4 class="fw-bold">{{ count($data) }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Inscritos</h6>
                                    <h4 class="fw-bold">{{ number_format(collect($data)->sum('total_inscritos')) }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Ventas Totales</h6>
                                    <h4 class="fw-bold">Bs {{ number_format(collect($data)->sum('total_ventas_curso'), 2) }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Pagos CD</h6>
                                    <h4 class="fw-bold">Bs {{ number_format(collect($data)->sum('total_pagos_cd'), 2) }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" id="ventasTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-building me-1"></i>
                                        Empresa (Área)
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-book me-1"></i>
                                        Curso
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-user-check me-1"></i>
                                        Total Inscritos
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-tag me-1"></i>
                                        Precio (Bs)
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-user-tie me-1"></i>
                                        Encargado
                                    </th>
                                    
                                    <!-- Columnas dinámicas de bancos -->
                                    @foreach($bancosUnicos as $banco)
                                        <th class="text-center banco-column">
                                            <i class="fas fa-university me-1"></i>
                                            {{ $banco }}
                                        </th>
                                    @endforeach
                                    
                                    <th class="text-center">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Total Ventas Curso
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Total Plan de Pagos
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-credit-card me-1"></i>
                                        Total Pagos CD
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $item)
                                    <tr class="table-row" data-empresa="{{ $item['empresa'] }}" data-encargado="{{ $item['encargado'] }}">
                                        <td class="fw-semibold">
                                            <span class="badge bg-light text-dark me-2">{{ $index + 1 }}</span>
                                            {{ $item['empresa'] }}
                                        </td>
                                        <td class="text-primary fw-semibold">{{ $item['curso'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ number_format($item['total_inscritos']) }}</span>
                                        </td>
                                        <td class="text-end fw-semibold">{{ number_format($item['precio'], 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $item['encargado'] }}</span>
                                        </td>
                                        
                                        <!-- Mostrar conteo por banco -->
                                        @foreach($bancosUnicos as $banco)
                                            <td class="text-center banco-data">
                                                @php
                                                    $count = $item['pagos_por_banco'][$banco] ?? 0;
                                                @endphp
                                                @if($count > 0)
                                                    <span class="badge bg-success">{{ $count }}</span>
                                                @else
                                                    <span class="text-muted">0</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        
                                        <td class="text-end fw-bold text-success">
                                            Bs {{ number_format($item['total_ventas_curso'], 2) }}
                                        </td>
                                        <td class="text-end fw-semibold text-warning">
                                            Bs {{ number_format($item['total_plan_pagos'], 2) }}
                                        </td>
                                        <td class="text-end fw-semibold text-info">
                                            Bs {{ number_format($item['total_pagos_cd'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr class="fw-bold">
                                    <td colspan="2" class="text-center">TOTALES</td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ number_format(collect($data)->sum('total_inscritos')) }}</span>
                                    </td>
                                    <td class="text-end">-</td>
                                    <td class="text-center">-</td>
                                    
                                    <!-- Totales por banco -->
                                    @foreach($bancosUnicos as $banco)
                                        <td class="text-center">
                                            @php
                                                $totalBanco = collect($data)->sum(function($item) use ($banco) {
                                                    return $item['pagos_por_banco'][$banco] ?? 0;
                                                });
                                            @endphp
                                            <span class="badge bg-warning">{{ $totalBanco }}</span>
                                        </td>
                                    @endforeach
                                    
                                    <td class="text-end text-success">
                                        Bs {{ number_format(collect($data)->sum('total_ventas_curso'), 2) }}
                                    </td>
                                    <td class="text-end text-warning">
                                        Bs {{ number_format(collect($data)->sum('total_plan_pagos'), 2) }}
                                    </td>
                                    <td class="text-end text-info">
                                        Bs {{ number_format(collect($data)->sum('total_pagos_cd'), 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const empresaFilter = document.getElementById('empresaFilter');
    const encargadoFilter = document.getElementById('encargadoFilter');
    const tableRows = document.querySelectorAll('.table-row');

    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const empresaValue = empresaFilter ? empresaFilter.value : '';
        const encargadoValue = encargadoFilter ? encargadoFilter.value : '';

        tableRows.forEach(row => {
            const empresa = row.dataset.empresa;
            const encargado = row.dataset.encargado;
            const rowText = row.textContent.toLowerCase();

            const matchesSearch = rowText.includes(searchTerm);
            const matchesEmpresa = !empresaValue || empresa === empresaValue;
            const matchesEncargado = !encargadoValue || encargado === encargadoValue;

            if (matchesSearch && matchesEmpresa && matchesEncargado) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (empresaFilter) empresaFilter.addEventListener('change', filterTable);
    if (encargadoFilter) encargadoFilter.addEventListener('change', filterTable);
});

function exportToExcel() {
    console.log('Exportando a Excel...');
}

function printTable() {
    window.print();
}
</script>

<style>
.table-responsive {
    border-radius: 0.375rem;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1);
}

.badge {
    font-size: 0.75em;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-body {
    padding: 1.5rem;
}

/* Estilos para las columnas de bancos */
.banco-column {
    background-color: rgba(13, 110, 253, 0.1);
    min-width: 100px;
}

.banco-data {
    background-color: rgba(13, 110, 253, 0.05);
}

@media print {
    .btn, .card:first-child {
        display: none !important;
    }
    
    .container-fluid {
        margin: 0;
        padding: 0;
    }
}

/* Responsive para muchas columnas */
@media (max-width: 1200px) {
    .banco-column, .banco-data {
        min-width: 80px;
        font-size: 0.85em;
    }
}
</style>
@endsection