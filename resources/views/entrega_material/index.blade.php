@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Encabezado mejorado -->
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold text-primary mb-2">
                    <i class="fas fa-truck-loading me-2"></i>
                    Entregas de Material
                </h2>
                <p class="text-muted">Gestión y seguimiento de entregas de materiales por curso</p>
            </div>

            <!-- Formulario de búsqueda mejorado -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('entrega_materials.index') }}" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- Campo para buscar por nombre de cliente -->
                            <div class="col-md-6">
                                <label for="cliente" class="form-label">Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           id="cliente"
                                           name="cliente" 
                                           class="form-control" 
                                           placeholder="Buscar por nombre de cliente" 
                                           value="{{ request()->get('cliente') }}"
                                           autocomplete="off">
                                </div>
                            </div>
                            
                            <!-- Campo para buscar por curso -->
                            <div class="col-md-6">
                                <label for="curso_id" class="form-label">Curso</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    <select name="curso_id" id="curso_id" class="form-select">
                                        <option value="">Todos los cursos</option>
                                        @foreach($cursos as $curso)
                                            <option value="{{ $curso->id }}" 
                                                    {{ request()->get('curso_id') == $curso->id ? 'selected' : '' }}>
                                                {{ $curso->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>
                                    Buscar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('entrega_materials.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-undo me-2"></i>
                                    Restablecer Filtros
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas generales -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <h5 class="card-title">{{ count($cursos) }}</h5>
                            <p class="card-text">Cursos Activos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h5 class="card-title">{{ $cursos->sum(function($curso) { return count($curso->ventas); }) }}</h5>
                            <p class="card-text">Total Inscritos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-truck fa-2x mb-2"></i>
                            <h5 class="card-title">
                                {{ $cursos->sum(function($curso) { 
                                    return $curso->ventas->filter(function($venta) { 
                                        return $venta->entregaMaterial; 
                                    })->count(); 
                                }) }}
                            </h5>
                            <p class="card-text">Entregas Configuradas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de cursos mejorada -->
            @forelse($cursos as $curso)
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-black">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-graduation-cap fa-lg me-3"></i>
                                <div>
                                    <h5 class="mb-0">{{ $curso->nombre }}</h5>
                                    <small class="opacity-75">
                                        <i class="fas fa-users me-1"></i>
                                        {{ count($curso->ventas) }} cliente{{ count($curso->ventas) !== 1 ? 's' : '' }} inscrito{{ count($curso->ventas) !== 1 ? 's' : '' }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Botón para mostrar/ocultar -->
                            <button class="btn btn-light btn-sm" 
                                    type="button"
                                    data-toggle="collapse" 
                                    data-target="#curso-{{ $curso->id }}-inscritos" 
                                    aria-expanded="false" 
                                    aria-controls="curso-{{ $curso->id }}-inscritos"
                                    onclick="toggleCursoList({{ $curso->id }}, this)">
                                <i class="fas fa-chevron-down"></i>
                                <span class="ms-1">Ver Inscritos</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Botones de exportación -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a href="{{ route('reportes.pdf', $curso->id) }}" 
                                   class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    Exportar PDF
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('reportes.excel', $curso->id) }}" 
                                   class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-file-excel me-2"></i>
                                    Exportar Excel
                                </a>
                            </div>
                        </div>

                        <!-- Lista de inscritos colapsable -->
                        <div class="collapse" id="curso-{{ $curso->id }}-inscritos" style="display: none;">
                            @if(count($curso->ventas) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Entrega</th>
                                                <th>Nro. Transacción</th>
                                                <th>Costo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($curso->ventas as $venta)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                                                <i class="fas fa-user text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <strong>ID: {{ $venta->id }}</strong><br>
                                                                <small class="text-muted">{{ $venta->cliente->nombre_completo }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($venta->entregaMaterial)
                                                            @php
                                                                $badgeClass = match($venta->entregaMaterial->opcion_entrega) {
                                                                    'CD' => 'bg-warning text-dark',
                                                                    'Google Drive' => 'bg-success',
                                                                    default => 'bg-secondary'
                                                                };
                                                                $icon = match($venta->entregaMaterial->opcion_entrega) {
                                                                    'CD' => 'fas fa-compact-disc',
                                                                    'Google Drive' => 'fab fa-google-drive',
                                                                    default => 'fas fa-question'
                                                                };
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }}">
                                                                <i class="{{ $icon }} me-1"></i>
                                                                {{ $venta->entregaMaterial->opcion_entrega }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Sin selección
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            {{ $venta->entregaMaterial->nro_transaccion_cd ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            Bs {{ $venta->entregaMaterial->costo_cd ?? '0.00' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('entrega_materials.showForm', $venta->id) }}" 
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-cog me-1"></i>
                                                            Configurar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No hay clientes inscritos en este curso</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No se encontraron cursos</h4>
                    <p class="text-muted">No hay cursos que coincidan con los filtros aplicados.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 25px rgba(0,0,0,0.1) !important;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-sm {
        font-size: 0.8125rem;
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Función simple para mostrar/ocultar lista de inscritos
    function toggleCursoList(cursoId, button) {
        const targetDiv = document.getElementById('curso-' + cursoId + '-inscritos');
        const icon = button.querySelector('i');
        const text = button.querySelector('span');
        
        if (targetDiv.style.display === 'none' || targetDiv.style.display === '') {
            // Mostrar
            targetDiv.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            text.textContent = 'Ocultar Inscritos';
            button.setAttribute('aria-expanded', 'true');
        } else {
            // Ocultar
            targetDiv.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            text.textContent = 'Ver Inscritos';
            button.setAttribute('aria-expanded', 'false');
        }
    }
    
    // Auto-submit del formulario al cambiar filtros
    document.addEventListener('DOMContentLoaded', function() {
        const cursoSelect = document.getElementById('curso_id');
        if (cursoSelect) {
            cursoSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush
@endsection