@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header con gradiente -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center text-white py-5">
                    <h1 class="display-4 fw-bold mb-2">
                        <i class="fas fa-graduation-cap me-3"></i>
                        Gestión de Cursos
                    </h1>
                    <p class="lead mb-0">Sistema integral para la administración de cursos de capacitación</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas mejoradas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Barra de herramientas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="buscador" onkeyup="filtrarCursos()" 
                                       class="form-control border-0 bg-light" 
                                       placeholder="Buscar por nombre o encargado...">
                            </div>
                        </div>
                        <div class="col-md-8 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle me-2"></i>Nuevo Curso
                                </a>
                                <a href="{{ route('cursos.export.pdf') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                </a>
                                <a href="{{ route('cursos.export.excel') }}" class="btn btn-outline-success">
                                    <i class="fas fa-file-excel me-2"></i>Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-play-circle text-primary fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $cursosActivos->where('estado', 'En curso')->count() }}</h3>
                    <p class="text-muted mb-0">En Curso</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-warning">{{ $cursosActivos->where('estado', 'Programado')->count() }}</h3>
                    <p class="text-muted mb-0">Programados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-secondary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle text-secondary fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-secondary">{{ $cursosActivos->where('estado', 'Finalizado')->count() }}</h3>
                    <p class="text-muted mb-0">Finalizados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-trash text-danger fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-danger">{{ $cursosEliminados->count() }}</h3>
                    <p class="text-muted mb-0">Eliminados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos Activos -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-book-open text-primary me-2"></i>
                        Cursos Activos
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tabla-cursos">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-0 px-4">ID</th>
                                    <th class="border-0">Curso</th>
                                    <th class="border-0">Encargado</th>
                                    <th class="border-0">Fecha</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0">Flayer</th>
                                    <th class="border-0 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cursosActivos as $curso)
                                    <tr class="border-bottom">
                                        <td class="px-4 fw-bold text-primary">#{{ $curso->id }}</td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $curso->nombre }}</h6>
                                                <small class="text-muted">{{ $curso->area }} | {{ $curso->marca }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $curso->encargado ? $curso->encargado->nombre . ' ' . $curso->encargado->apellido_paterno : 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-nowrap">
                                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                                {{ \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($curso->estado == 'En curso')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-play me-1"></i>En curso
                                                </span>
                                            @elseif($curso->estado == 'Programado')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i>Programado
                                                </span>
                                            @else
                                                <span class="badge bg-secondary px-3 py-2">
                                                    <i class="fas fa-check me-1"></i>Finalizado
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($curso->flayer)
                                                <img src="{{ asset('storage/' . $curso->flayer) }}" 
                                                     alt="Flayer" 
                                                     class="rounded shadow-sm border"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="rounded border d-flex align-items-center justify-content-center bg-light text-muted" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#verCursoModal{{ $curso->id }}"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('cursos.edit', $curso) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('cursos.destroy', $curso) }}" 
                                                      method="POST" 
                                                      class="d-inline-block" 
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este curso?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal mejorado -->
                                    <!-- Modal mejorado -->
<div class="modal fade" id="verCursoModal{{ $curso->id }}" tabindex="-1" aria-labelledby="modalLabelCurso{{ $curso->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white fw-bold" id="modalLabelCurso{{ $curso->id }}">
                    <i class="fas fa-info-circle me-2"></i>
                    Detalle del Curso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        @if($curso->flayer)
                            <img src="{{ asset('storage/' . $curso->flayer) }}" 
                                 alt="Flayer del Curso" 
                                 class="img-fluid rounded shadow-sm border">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p class="mb-0">Sin flayer</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">ID</small>
                                    <div class="fw-bold">#{{ $curso->id }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Estado</small>
                                    <div>
                                        @if($curso->estado == 'En curso')
                                            <span class="badge bg-success">En curso</span>
                                        @elseif($curso->estado == 'Programado')
                                            <span class="badge bg-warning text-dark">Programado</span>
                                        @else
                                            <span class="badge bg-secondary">Finalizado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Nombre del Curso</small>
                                    <div class="fw-bold">{{ $curso->nombre }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Área</small>
                                    <div class="fw-semibold">{{ $curso->area }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Marca</small>
                                    <div class="fw-semibold">{{ $curso->marca }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Encargado</small>
                                    <div class="fw-semibold">{{ $curso->encargado ? $curso->encargado->nombre . ' ' . $curso->encargado->apellido_paterno : 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Docente</small>
                                    <div class="fw-semibold">{{ $curso->docente ? $curso->docente->nombre . ' ' . $curso->docente->apellido_paterno : 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Fecha</small>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            @if($curso->descripcion)
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted">Descripción</small>
                                    <div class="mt-1">{{ $curso->descripcion }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                @if($curso->flayer)
                    <a href="{{ asset('storage/' . $curso->flayer) }}" 
                       target="_blank" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-2"></i>Ver Flayer
                    </a>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">No hay cursos activos registrados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos Eliminados -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-trash text-danger me-2"></i>
                        Cursos Eliminados
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4">ID</th>
                                    <th class="border-0">Nombre</th>
                                    <th class="border-0">Área</th>
                                    <th class="border-0">Fecha</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cursosEliminados as $curso)
                                    <tr class="border-bottom bg-danger bg-opacity-10">
                                        <td class="px-4 fw-bold text-danger">#{{ $curso->id }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $curso->nombre }}</div>
                                        </td>
                                        <td>{{ $curso->area }}</td>
                                        <td>
                                            <div class="text-nowrap">
                                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                                {{ \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($curso->estado == 'En curso')
                                                <span class="badge bg-success">En curso</span>
                                            @elseif($curso->estado == 'Programado')
                                                <span class="badge bg-warning text-dark">Programado</span>
                                            @else
                                                <span class="badge bg-secondary">Finalizado</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cursos.restore', $curso->id) }}" 
                                                  method="POST" 
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('¿Deseas restaurar este curso?')">
                                                @csrf
                                                <button class="btn btn-sm btn-success" title="Restaurar">
                                                    <i class="fas fa-undo me-1"></i>Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                                            <p class="mb-0">No hay cursos eliminados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    /* Previene el parpadeo en el modal */
    .modal-backdrop {
        opacity: 0.8 !important; /* Asegura que el fondo no sea opaco en exceso */
    }

    .modal-content {
        transition: opacity 0.3s ease-in-out !important;
    }

    .modal.fade .modal-dialog {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        opacity: 1;
    }
</style>

<!-- JavaScript mejorado -->
<script>
    // Función de búsqueda mejorada
    function filtrarCursos() {
        const input = document.getElementById("buscador").value.toLowerCase();
        const filas = document.querySelectorAll("#tabla-cursos tbody tr");
        let visibleCount = 0;
        
        filas.forEach(fila => {
            const texto = fila.innerText.toLowerCase();
            if (texto.includes(input)) {
                fila.style.display = "";
                visibleCount++;
            } else {
                fila.style.display = "none";
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const tbody = document.querySelector("#tabla-cursos tbody");
        const noResultsRow = document.getElementById("no-results-row");
        
        if (visibleCount === 0 && input.trim() !== "") {
            if (!noResultsRow) {
                const tr = document.createElement("tr");
                tr.id = "no-results-row";
                tr.innerHTML = `
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <p class="mb-0">No se encontraron cursos que coincidan con "${input}"</p>
                    </td>
                `;
                tbody.appendChild(tr);
            }
        } else if (noResultsRow) {
            noResultsRow.remove();
        }
    }
    
    
</script>
@endsection