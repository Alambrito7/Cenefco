@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            {{-- Header Principal --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="display-6 fw-bold text-primary mb-2">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Lista de Docentes
                    </h1>
                    <p class="text-muted mb-0">Gestiona el personal docente de tu institución</p>
                </div>
            </div>

            {{-- Alerta de Éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Barra de Acciones --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="buscador" onkeyup="filtrarDocentes()" 
                                       class="form-control border-start-0 ps-0"
                                       placeholder="Buscar por nombre, teléfono, correo, profesión o experiencia...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('docentes.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Nuevo Docente
                                </a>
                                <a href="{{ route('docentes.export.pdf') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                </a>
                                <a href="{{ route('docentes.export.excel') }}" class="btn btn-outline-success">
                                    <i class="fas fa-file-excel me-2"></i>Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-users text-success fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-success">{{ count($docentesActivos) }}</h4>
                                    <small class="text-muted">Docentes Activos</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-trash text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-danger">{{ count($docentesEliminados) }}</h4>
                                    <small class="text-muted">Docentes Eliminados</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DOCENTES ACTIVOS --}}
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Docentes Activos
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tablaDocentes">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">ID</th>
                                    <th class="border-0 fw-semibold">Docente</th>
                                    <th class="border-0 fw-semibold">Contacto</th>
                                    <th class="border-0 fw-semibold">Foto</th>
                                    <th class="border-0 fw-semibold">Currículum</th>
                                    <th class="border-0 fw-semibold d-none">Experiencia</th>
                                    <th class="border-0 fw-semibold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($docentesActivos as $docente)
                                    <tr class="align-middle">
                                        <td class="fw-medium text-primary">#{{ $docente->id }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $docente->nombre }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}</span>
                                                @if($docente->grado_academico)
                                                    <small class="text-muted">{{ $docente->grado_academico }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-muted">
                                                    <i class="fas fa-phone me-1"></i>{{ $docente->telefono }}
                                                </span>
                                                <span class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>{{ $docente->correo }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($docente->foto)
                                                <img src="{{ asset('storage/' . $docente->foto) }}" alt="Foto" 
                                                     class="rounded-circle border shadow-sm" 
                                                     style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center"
                                                     style="width: 45px; height: 45px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($docente->curriculum)
                                                <a href="{{ asset('storage/' . $docente->curriculum) }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-alt me-1"></i>Ver
                                                </a>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-times me-1"></i>No disponible
                                                </span>
                                            @endif
                                        </td>
                                        <td class="d-none">{{ $docente->experiencia }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#verDocenteModal{{ $docente->id }}"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('docentes.edit', $docente) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('docentes.destroy', $docente) }}" method="POST" 
                                                      class="d-inline-block"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este docente?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL DETALLE --}}
                                    <div class="modal fade" id="verDocenteModal{{ $docente->id }}" tabindex="-1" 
                                         aria-labelledby="modalLabel{{ $docente->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="modalLabel{{ $docente->id }}">
                                                        <i class="fas fa-user-graduate me-2"></i>
                                                        Información de {{ $docente->nombre }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" 
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-4 text-center mb-3">
                                                            @if($docente->foto)
                                                                <img src="{{ asset('storage/' . $docente->foto) }}" 
                                                                     alt="Foto" class="img-fluid rounded shadow-sm"
                                                                     style="max-width: 200px;">
                                                            @else
                                                                <div class="bg-light rounded shadow-sm p-4">
                                                                    <i class="fas fa-user-graduate text-muted" style="font-size: 4rem;"></i>
                                                                    <p class="text-muted mt-2">Sin foto disponible</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row g-3">
                                                                <div class="col-12">
                                                                    <label class="form-label fw-semibold text-muted">Nombre Completo</label>
                                                                    <p class="fw-medium">{{ $docente->nombre }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">Teléfono</label>
                                                                    <p class="fw-medium">
                                                                        <i class="fas fa-phone me-2 text-primary"></i>{{ $docente->telefono }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">Correo Electrónico</label>
                                                                    <p class="fw-medium">
                                                                        <i class="fas fa-envelope me-2 text-primary"></i>{{ $docente->correo }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">Nacionalidad</label>
                                                                    <p class="fw-medium">
                                                                        <i class="fas fa-flag me-2 text-primary"></i>{{ $docente->nacionalidad }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">Edad</label>
                                                                    <p class="fw-medium">
                                                                        <i class="fas fa-birthday-cake me-2 text-primary"></i>{{ $docente->edad }} años
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-semibold text-muted">Grado Académico</label>
                                                                    <p class="fw-medium">
                                                                        <i class="fas fa-graduation-cap me-2 text-primary"></i>{{ $docente->grado_academico }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-semibold text-muted">Experiencia</label>
                                                                    <p class="fw-medium">{{ $docente->experiencia }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">¿Impartió Clases?</label>
                                                                    <p class="fw-medium">
                                                                        @if($docente->impartio_clases)
                                                                            <span class="badge bg-success">
                                                                                <i class="fas fa-check me-1"></i>Sí
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-secondary">
                                                                                <i class="fas fa-times me-1"></i>No
                                                                            </span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold text-muted">Currículum</label>
                                                                    @if($docente->curriculum)
                                                                        <p class="fw-medium">
                                                                            <a href="{{ asset('storage/' . $docente->curriculum) }}" 
                                                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                <i class="fas fa-file-alt me-1"></i>Ver Documento
                                                                            </a>
                                                                        </p>
                                                                    @else
                                                                        <p class="text-muted">No adjuntado</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-users fa-2x mb-3"></i>
                                            <p class="mb-0">No hay docentes activos registrados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- DOCENTES ELIMINADOS --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-trash me-2"></i>
                        Docentes Eliminados
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">ID</th>
                                    <th class="border-0 fw-semibold">Nombre</th>
                                    <th class="border-0 fw-semibold">Teléfono</th>
                                    <th class="border-0 fw-semibold">Correo</th>
                                    <th class="border-0 fw-semibold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($docentesEliminados as $docente)
                                    <tr class="align-middle table-danger">
                                        <td class="fw-medium text-danger">#{{ $docente->id }}</td>
                                        <td class="fw-medium">{{ $docente->nombre }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}</td>
                                        <td>
                                            <i class="fas fa-phone me-2 text-muted"></i>{{ $docente->telefono }}
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope me-2 text-muted"></i>{{ $docente->correo }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('docentes.restore', $docente->id) }}" method="POST" 
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('¿Deseas restaurar este docente?')">
                                                @csrf
                                                <button class="btn btn-sm btn-success" title="Restaurar">
                                                    <i class="fas fa-undo me-1"></i>Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                                            <p class="mb-0">No hay docentes eliminados</p>
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

{{-- SCRIPTS --}}
<script>
    // Función de búsqueda mejorada
    function filtrarDocentes() {
        const input = document.getElementById("buscador").value.toLowerCase();
        const tabla = document.getElementById("tablaDocentes");
        const filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        
        let resultados = 0;
        
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const texto = fila.innerText.toLowerCase();
            
            if (texto.includes(input)) {
                fila.style.display = "";
                resultados++;
            } else {
                fila.style.display = "none";
            }
        }
        
        // Mostrar mensaje si no hay resultados
        const tbody = tabla.getElementsByTagName("tbody")[0];
        let mensajeNoResultados = document.getElementById("mensajeNoResultados");
        
        if (resultados === 0 && input.trim() !== "") {
            if (!mensajeNoResultados) {
                mensajeNoResultados = document.createElement("tr");
                mensajeNoResultados.id = "mensajeNoResultados";
                mensajeNoResultados.innerHTML = `
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <p class="mb-0">No se encontraron docentes que coincidan con "${input}"</p>
                    </td>
                `;
                tbody.appendChild(mensajeNoResultados);
            }
        } else if (mensajeNoResultados) {
            mensajeNoResultados.remove();
        }
    }

    // Limpiar búsqueda al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("buscador").value = "";
    });
</script>
@endsection