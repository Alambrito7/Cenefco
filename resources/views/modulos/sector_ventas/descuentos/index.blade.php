@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Encabezado principal -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="display-6 text-center fw-bold text-primary mb-0">
                <i class="fas fa-tags me-2"></i>Gestión de Descuentos
            </h2>
            <p class="text-muted text-center mb-0">Administra todos los descuentos de tu sistema</p>
        </div>
    </div>

    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="bg-success rounded-circle p-3 me-3">
                            <i class="fas fa-tag text-white"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-success">{{ $descuentosActivos->count() }}</h3>
                            <small class="text-muted">Activos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="bg-danger rounded-circle p-3 me-3">
                            <i class="fas fa-trash text-white"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-danger">{{ $descuentosEliminados->count() }}</h3>
                            <small class="text-muted">Eliminados</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="bg-primary rounded-circle p-3 me-3">
                            <i class="fas fa-calculator text-white"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-primary">{{ $descuentosActivos->sum('porcentaje') }}%</h3>
                            <small class="text-muted">Total %</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de acción principal -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('descuentos.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i>Registrar Nuevo Descuento
        </a>
    </div>

    <!-- DESCUENTOS ACTIVOS -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="fas fa-tags me-2"></i>Descuentos Activos
                <span class="badge bg-light text-success ms-2">{{ $descuentosActivos->count() }}</span>
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 80px;">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th>
                                <i class="fas fa-tag me-1"></i>Nombre
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-percent me-1"></i>Porcentaje
                            </th>
                            <th>
                                <i class="fas fa-info-circle me-1"></i>Descripción
                            </th>
                            <th class="text-center" style="width: 200px;">
                                <i class="fas fa-cogs me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($descuentosActivos as $descuento)
                            <tr>
                                <td class="text-center fw-bold">
                                    <span class="badge bg-primary">{{ $descuento->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle p-2 me-3">
                                            <i class="fas fa-tag text-white small"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $descuento->nombre }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">{{ $descuento->porcentaje }}%</span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $descuento->descripcion ?? 'Sin descripción' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('descuentos.edit', $descuento) }}" 
                                           class="btn btn-sm btn-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Editar descuento">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('descuentos.destroy', $descuento) }}" 
                                              method="POST" 
                                              class="d-inline-block"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este descuento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" 
                                                    title="Eliminar descuento">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">No hay descuentos registrados.</p>
                                        <small>Comienza creando tu primer descuento.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DESCUENTOS ELIMINADOS -->
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fas fa-trash me-2"></i>Descuentos Eliminados
                <span class="badge bg-light text-danger ms-2">{{ $descuentosEliminados->count() }}</span>
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-center" style="width: 80px;">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th>
                                <i class="fas fa-tag me-1"></i>Nombre
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-percent me-1"></i>Porcentaje
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-undo me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($descuentosEliminados as $descuento)
                            <tr class="table-light">
                                <td class="text-center fw-bold">
                                    <span class="badge bg-secondary">{{ $descuento->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary rounded-circle p-2 me-3">
                                            <i class="fas fa-tag text-white small"></i>
                                        </div>
                                        <div>
                                            <strong class="text-muted">{{ $descuento->nombre }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $descuento->porcentaje }}%</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('descuentos.restore', $descuento->id) }}" 
                                          method="POST" 
                                          class="d-inline-block"
                                          onsubmit="return confirm('¿Deseas restaurar este descuento?')">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                                data-bs-toggle="tooltip" 
                                                title="Restaurar descuento">
                                            <i class="fas fa-undo me-1"></i>Restaurar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                                        <p class="mb-0">No hay descuentos eliminados.</p>
                                        <small>¡Perfecto! Todos los descuentos están activos.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection