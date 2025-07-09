@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Módulo Financiero por Curso
                </h2>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="toggleDeletedTransactions()">
                        <i class="fas fa-trash-restore me-1"></i>
                        Ver Eliminadas
                    </button>
                    <a href="{{ route('finanzas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Registrar Nueva Venta
                    </a>
                </div>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Resumen financiero -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Cursos</h6>
                                    <h3 class="mb-0">{{ count($transaccionesPorCurso) }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Ventas</h6>
                                    <h3 class="mb-0">{{ $transaccionesPorCurso->flatten()->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Ingresos Total</h6>
                                    <h3 class="mb-0">Bs. {{ number_format($transaccionesPorCurso->flatten()->sum('monto'), 2) }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Eliminadas</h6>
                                    <h3 class="mb-0">{{ count($transaccionesEliminadas) }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-trash fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros y búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Buscar por cliente:</label>
                            <input type="text" class="form-control" id="searchClient" placeholder="Nombre del cliente...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrar por banco:</label>
                            <select class="form-select" id="filterBank">
                                <option value="">Todos los bancos</option>
                                @foreach($transaccionesPorCurso->flatten()->unique('banco') as $transaccion)
                                    <option value="{{ $transaccion->banco }}">{{ $transaccion->banco }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filtrar por fecha:</label>
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transacciones por curso -->
            <div id="transacciones-activas">
                @foreach($transaccionesPorCurso as $cursoNombre => $transacciones)
                    <div class="card mb-4 shadow-sm course-card">
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-0">
                                        <i class="fas fa-book me-2"></i>
                                        {{ $cursoNombre }}
                                        <span class="badge bg-primary ms-2">{{ count($transacciones) }} transacciones</span>
                                        <span class="badge bg-success ms-1">Bs. {{ number_format($transacciones->sum('monto'), 2) }}</span>
                                    </h5>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleCourseTable('{{ $loop->index }}')">
                                            <i class="fas fa-eye me-1"></i>
                                            <span id="toggle-text-{{ $loop->index }}">Ocultar</span>
                                        </button>
                                        <a href="{{ route('finanzas.exportExcel', $transacciones->first()->curso->id) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-file-excel me-1"></i>
                                            Excel
                                        </a>
                                        <a href="{{ route('finanzas.exportPDF', $transacciones->first()->curso->id) }}" 
                                           class="btn btn-sm btn-danger">
                                            <i class="fas fa-file-pdf me-1"></i>
                                            PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0" id="course-table-{{ $loop->index }}">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Cliente</th>
                                            <th width="15%">Curso</th>
                                            <th width="10%">Monto</th>
                                            <th width="12%">Banco</th>
                                            <th width="12%">Transacción</th>
                                            <th width="15%">Fecha y hora</th>
                                            <th width="11%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transacciones as $transaccion)
                                            <tr class="transaction-row" 
                                                data-client="{{ strtolower($transaccion->venta->cliente->nombre . ' ' . $transaccion->venta->cliente->apellido_paterno) }}"
                                                data-bank="{{ $transaccion->banco }}"
                                                data-date="{{ date('Y-m-d', strtotime($transaccion->fecha_hora)) }}">
                                                <td>
                                                    <span class="badge bg-secondary">#{{ $transaccion->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            {{ strtoupper(substr($transaccion->venta->cliente->nombre, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $transaccion->venta->cliente->nombre }}</div>
                                                            <small class="text-muted">{{ $transaccion->venta->cliente->apellido_paterno }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $transaccion->curso->nombre }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success">Bs. {{ number_format($transaccion->monto, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $transaccion->banco }}</span>
                                                </td>
                                                <td>
                                                    <code class="small">{{ $transaccion->nro_transaccion }}</code>
                                                </td>
                                                <td>
                                                    <small>
                                                        <div>{{ date('d/m/Y', strtotime($transaccion->fecha_hora)) }}</div>
                                                        <div class="text-muted">{{ date('H:i', strtotime($transaccion->fecha_hora)) }}</div>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('finanzas.edit', $transaccion->id) }}" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm" 
                                                                onclick="confirmDelete({{ $transaccion->id }})"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Transacciones eliminadas -->
            <div id="transacciones-eliminadas" style="display: none;">
                <h3 class="mb-3">
                    <i class="fas fa-trash-restore me-2"></i>
                    Transacciones Eliminadas
                </h3>
                @if(count($transaccionesEliminadas) > 0)
                    <div class="card mb-4 border-warning">
                        <div class="card-header bg-warning bg-opacity-10">
                            <h6 class="mb-0 text-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Transacciones en papelera de reciclaje
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Curso</th>
                                            <th>Monto</th>
                                            <th>Banco</th>
                                            <th>Transacción</th>
                                            <th>Fecha y hora</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaccionesEliminadas as $transaccion)
                                            <tr class="table-warning bg-opacity-25">
                                                <td>
                                                    <span class="badge bg-warning">#{{ $transaccion->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            {{ strtoupper(substr($transaccion->venta->cliente->nombre, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $transaccion->venta->cliente->nombre }}</div>
                                                            <small class="text-muted">{{ $transaccion->venta->cliente->apellido_paterno }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $transaccion->curso->nombre }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-muted">Bs. {{ number_format($transaccion->monto, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $transaccion->banco }}</span>
                                                </td>
                                                <td>
                                                    <code class="small">{{ $transaccion->nro_transaccion }}</code>
                                                </td>
                                                <td>
                                                    <small>
                                                        <div>{{ date('d/m/Y', strtotime($transaccion->fecha_hora)) }}</div>
                                                        <div class="text-muted">{{ date('H:i', strtotime($transaccion->fecha_hora)) }}</div>
                                                    </small>
                                                </td>
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm" 
                                                            onclick="confirmRestore({{ $transaccion->id }})"
                                                            title="Restaurar">
                                                        <i class="fas fa-undo me-1"></i>
                                                        Restaurar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No hay transacciones eliminadas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta transacción?</p>
                <p class="text-muted">Esta acción se puede deshacer desde la sección de transacciones eliminadas.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para restaurar -->
<div class="modal fade" id="restoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar restauración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas restaurar esta transacción?</p>
                <p class="text-muted">La transacción volverá a aparecer en la lista principal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Restaurar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Función para alternar visibilidad de transacciones eliminadas
function toggleDeletedTransactions() {
    const activasDiv = document.getElementById('transacciones-activas');
    const eliminadasDiv = document.getElementById('transacciones-eliminadas');
    const button = event.target.closest('button');
    
    if (eliminadasDiv.style.display === 'none') {
        activasDiv.style.display = 'none';
        eliminadasDiv.style.display = 'block';
        button.innerHTML = '<i class="fas fa-arrow-left me-1"></i> Ver Activas';
    } else {
        activasDiv.style.display = 'block';
        eliminadasDiv.style.display = 'none';
        button.innerHTML = '<i class="fas fa-trash-restore me-1"></i> Ver Eliminadas';
    }
}

// Función para alternar visibilidad de tabla por curso
function toggleCourseTable(index) {
    const table = document.getElementById(`course-table-${index}`);
    const toggleText = document.getElementById(`toggle-text-${index}`);
    
    if (table.style.display === 'none') {
        table.style.display = 'block';
        toggleText.textContent = 'Ocultar';
    } else {
        table.style.display = 'none';
        toggleText.textContent = 'Mostrar';
    }
}

// Función para confirmar eliminación
function confirmDelete(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/finanzas/${id}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Función para confirmar restauración
function confirmRestore(id) {
    const form = document.getElementById('restoreForm');
    form.action = `/finanzas/${id}/restore`;
    const modal = new bootstrap.Modal(document.getElementById('restoreModal'));
    modal.show();
}

// Filtros y búsqueda
document.addEventListener('DOMContentLoaded', function() {
    const searchClient = document.getElementById('searchClient');
    const filterBank = document.getElementById('filterBank');
    const filterDate = document.getElementById('filterDate');
    
    function filterTransactions() {
        const searchValue = searchClient.value.toLowerCase();
        const bankValue = filterBank.value;
        const dateValue = filterDate.value;
        
        document.querySelectorAll('.transaction-row').forEach(row => {
            const client = row.getAttribute('data-client');
            const bank = row.getAttribute('data-bank');
            const date = row.getAttribute('data-date');
            
            const matchesClient = !searchValue || client.includes(searchValue);
            const matchesBank = !bankValue || bank === bankValue;
            const matchesDate = !dateValue || date === dateValue;
            
            if (matchesClient && matchesBank && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchClient.addEventListener('input', filterTransactions);
    filterBank.addEventListener('change', filterTransactions);
    filterDate.addEventListener('change', filterTransactions);
});
</script>

<style>
.avatar-sm {
    width: 35px;
    height: 35px;
    font-size: 14px;
}

.course-card {
    transition: transform 0.2s ease-in-out;
}

.course-card:hover {
    transform: translateY(-2px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1);
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.alert-dismissible {
    padding-right: 3rem;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
    background-color: rgba(0,0,0,.03);
}

.text-success {
    color: #198754 !important;
}

.text-muted {
    color: #6c757d !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
@endsection