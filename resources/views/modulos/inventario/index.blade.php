@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
<div class="container py-4">
    <!-- Header con gradiente -->
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold text-primary mb-2">
            <i class="fas fa-boxes me-2"></i>Inventario General
        </h1>
        <p class="text-muted">Gestión completa de activos fijos</p>
    </div>

    <!-- Alertas mejoradas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Barra de herramientas mejorada -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="btn-group" role="group">
                <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Nuevo Registro
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end gap-2">
                <div class="btn-group" role="group">
                    <a href="{{ route('inventario.export.pdf') }}" class="btn btn-outline-danger">
                        <i class="fas fa-file-pdf me-2"></i>PDF
                    </a>
                    <a href="{{ route('inventario.export.excel') }}" class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-2"></i>Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar por código o nombre</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Escriba para buscar...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filtrar por estado</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Todos los estados</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filtrar por responsable</label>
                    <select class="form-select" id="responsableFilter">
                        <option value="">Todos los responsables</option>
                        @foreach($inventarios->pluck('responsable.nombre')->filter()->unique() as $responsable)
                            <option value="{{ $responsable }}">{{ $responsable }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                        <i class="fas fa-times me-2"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Activos</h5>
                            <h3 class="mb-0">{{ $inventarios->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-boxes fa-2x opacity-75"></i>
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
                            <h5 class="card-title">Activos</h5>
                            <h3 class="mb-0">{{ $inventarios->where('estado', 'Activo')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
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
                            <h5 class="card-title">Inactivos</h5>
                            <h3 class="mb-0">{{ $inventarios->where('estado', 'Inactivo')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-pause-circle fa-2x opacity-75"></i>
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
                            <h5 class="card-title">Valor Total</h5>
                            <h3 class="mb-0">Bs {{ number_format($inventarios->sum('valor'), 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla principal mejorada -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i>Listado de Inventario
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="inventarioTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">
                                <i class="fas fa-barcode me-1"></i>Código AF
                            </th>
                            <th class="text-center">
                                <i class="fas fa-tag me-1"></i>Nombre
                            </th>
                            <th class="text-center">
                                <i class="fas fa-cogs me-1"></i>Modelo
                            </th>
                            <th class="text-center">
                                <i class="fas fa-palette me-1"></i>Color
                            </th>
                            <th class="text-center">
                                <i class="fas fa-toggle-on me-1"></i>Estado
                            </th>
                            <th class="text-center">
                                <i class="fas fa-user me-1"></i>Responsable
                            </th>
                            <th class="text-center">
                                <i class="fas fa-money-bill me-1"></i>Valor
                            </th>
                            <th class="text-center">
                                <i class="fas fa-tools me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventarios as $inv)
                        <tr class="inventario-row">
                            <td class="text-center fw-bold">
                                <span class="badge bg-light text-dark">{{ $inv->codigo_af }}</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ $inv->nombre }}</strong>
                            </td>
                            <td class="text-center">{{ $inv->concepto_1 ?: '—' }}</td>
                            <td class="text-center">{{ $inv->concepto_2 ?: '—' }}</td>
                            <td class="text-center">
                                @if($inv->estado == 'Activo')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($inv->responsable)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i>{{ $inv->responsable->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-user-slash me-1"></i>Sin asignar
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-success">Bs {{ number_format($inv->valor, 2) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('inventario.edit', $inv->id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Editar registro">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete({{ $inv->id }})"
                                            title="Eliminar registro">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Formulario oculto para eliminación -->
                                <form id="deleteForm{{ $inv->id }}" 
                                      action="{{ route('inventario.destroy', $inv->id) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>No hay inventario registrado</h5>
                                    <p>Comience agregando un nuevo registro</p>
                                    <a href="{{ route('inventario.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Agregar Primer Registro
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sección de eliminados mejorada -->
    @if($eliminados->count())
        <div class="card mt-5">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-trash-restore me-2"></i>Registros Eliminados
                    <span class="badge bg-light text-dark ms-2">{{ $eliminados->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">
                                    <i class="fas fa-barcode me-1"></i>Código
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-tag me-1"></i>Nombre
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-user me-1"></i>Responsable
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-tools me-1"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eliminados as $inv)
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">{{ $inv->codigo_af }}</span>
                                </td>
                                <td class="text-center">{{ $inv->nombre }}</td>
                                <td class="text-center">
                                    @if($inv->responsable)
                                        <span class="badge bg-primary">
                                            <i class="fas fa-user me-1"></i>{{ $inv->responsable->nombre }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-user-slash me-1"></i>Sin asignar
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-success btn-sm" 
                                            onclick="confirmRestore({{ $inv->id }})"
                                            title="Restaurar registro">
                                        <i class="fas fa-undo me-1"></i>Restaurar
                                    </button>
                                    
                                    <!-- Formulario oculto para restauración -->
                                    <form id="restoreForm{{ $inv->id }}" 
                                          action="{{ route('inventario.restore', $inv->id) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf @method('PUT')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Scripts personalizados -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de búsqueda
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const responsableFilter = document.getElementById('responsableFilter');
    const table = document.getElementById('inventarioTable');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const responsableValue = responsableFilter.value;
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            if (row.classList.contains('inventario-row')) {
                const codigo = row.cells[0].textContent.toLowerCase();
                const nombre = row.cells[1].textContent.toLowerCase();
                const estado = row.cells[4].textContent.trim();
                const responsable = row.cells[5].textContent.trim();
                
                const matchesSearch = codigo.includes(searchTerm) || nombre.includes(searchTerm);
                const matchesStatus = !statusValue || estado.includes(statusValue);
                const matchesResponsable = !responsableValue || responsable.includes(responsableValue);
                
                if (matchesSearch && matchesStatus && matchesResponsable) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }
    
    // Event listeners para filtros
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    responsableFilter.addEventListener('change', filterTable);
});

// Función para limpiar filtros
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('responsableFilter').value = '';
    
    // Mostrar todas las filas
    const rows = document.querySelectorAll('#inventarioTable tbody .inventario-row');
    rows.forEach(row => row.style.display = '');
}

// Función para confirmar eliminación
function confirmDelete(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción eliminará el registro del inventario",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
        }
    });
}

// Función para confirmar restauración
function confirmRestore(id) {
    Swal.fire({
        title: '¿Restaurar registro?',
        text: "El registro volverá a estar disponible en el inventario",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('restoreForm' + id).submit();
        }
    });
}
</script>

<!-- Estilos personalizados -->
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}

.badge {
    font-size: 0.75em;
}

.inventario-row {
    transition: all 0.3s ease;
}

.inventario-row:hover {
    transform: translateY(-1px);
}

.display-5 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>