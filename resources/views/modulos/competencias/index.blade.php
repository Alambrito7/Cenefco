@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">📚 Lista de Competencias</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('competencias.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </a>
                    <a href="{{ route('competencias.export.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                </div>
            </div>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Controles superiores --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="buscador" class="form-control" 
                               placeholder="Buscar por curso, docente, área, estado..." 
                               onkeyup="filtrarCompetencias()">
                        <button class="btn btn-outline-secondary" type="button" onclick="limpiarBusqueda()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('competencias.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Competencia
                    </a>
                </div>
            </div>

            {{-- Estadísticas rápidas --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $competencias->count() }}</h5>
                            <p class="card-text mb-0">Competencias Activas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $competenciasEliminadas->count() }}</h5>
                            <p class="card-text mb-0">Competencias Eliminadas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $competencias->where('estado', 'activo')->count() }}</h5>
                            <p class="card-text mb-0">Estados Activos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $competencias->where('estado', 'pendiente')->count() }}</h5>
                            <p class="card-text mb-0">Estados Pendientes</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de competencias activas --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Competencias Activas
                        <span class="badge bg-primary ms-2" id="contador-resultados">{{ $competencias->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="tabla-competencias">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <th scope="col" class="text-center">ID</th>
                                    <th scope="col">Página Central</th>
                                    <th scope="col">Subpágina</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Docente</th>
                                    <th scope="col">F. Publicación</th>
                                    <th scope="col">F. Inicio</th>
                                    <th scope="col" class="text-center">Link Grupo</th>
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($competencias as $competencia)
                                    <tr data-id="{{ $competencia->id }}">
                                        <td class="text-center fw-bold">{{ $competencia->id }}</td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                                  title="{{ $competencia->pagina_central }}">
                                                {{ $competencia->pagina_central }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 120px;" 
                                                  title="{{ $competencia->subpagina }}">
                                                {{ $competencia->subpagina }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">{{ $competencia->area }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $competencia->curso }}</strong>
                                        </td>
                                        <td>
                                            <i class="fas fa-user me-1"></i>{{ $competencia->docente }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($competencia->fecha_publicacion)->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($competencia->fecha_inicio)->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            @if($competencia->link_grupo)
                                                <a href="{{ $competencia->link_grupo }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Abrir enlace del grupo">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">Sin enlace</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $estadoClass = match($competencia->estado) {
                                                    'activo' => 'bg-success',
                                                    'pendiente' => 'bg-warning text-dark',
                                                    'inactivo' => 'bg-secondary',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $estadoClass }} text-uppercase">
                                                {{ $competencia->estado }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('competencias.edit', $competencia->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Editar competencia">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="confirmarEliminacion({{ $competencia->id }}, '{{ $competencia->curso }}')"
                                                        title="Eliminar competencia">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay competencias registradas.</p>
                                                <a href="{{ route('competencias.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-plus"></i> Crear Primera Competencia
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

            {{-- Competencias eliminadas --}}
            @if($competenciasEliminadas->count() > 0)
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-trash"></i> Competencias Eliminadas
                            <span class="badge bg-danger ms-2">{{ $competenciasEliminadas->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Docente</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th scope="col">Fecha Eliminación</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($competenciasEliminadas as $competencia)
                                        <tr class="table-danger">
                                            <td class="text-center fw-bold">{{ $competencia->id }}</td>
                                            <td>{{ $competencia->curso }}</td>
                                            <td>
                                                <i class="fas fa-user me-1"></i>{{ $competencia->docente }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-dark text-uppercase">{{ $competencia->estado }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($competencia->deleted_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        onclick="confirmarRestauracion({{ $competencia->id }}, '{{ $competencia->curso }}')"
                                                        title="Restaurar competencia">
                                                    <i class="fas fa-undo"></i> Restaurar
                                                </button>
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
    </div>
</div>

{{-- Formularios ocultos para acciones --}}
<form id="form-eliminar" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="form-restaurar" method="POST" style="display: none;">
    @csrf
</form>

{{-- Modal de confirmación --}}
<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="mensaje-confirmacion"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>

{{-- Loading spinner --}}
<div id="loading" class="position-fixed top-50 start-50 translate-middle d-none">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    // Variables globales
    let accionPendiente = null;
    let idPendiente = null;

    // Función de filtrado mejorada
    function filtrarCompetencias() {
        const input = document.getElementById("buscador").value.toLowerCase().trim();
        const filas = document.querySelectorAll("#tabla-competencias tbody tr");
        let contador = 0;

        filas.forEach(fila => {
            // Excluir la fila de "sin datos"
            if (fila.children.length === 1 && fila.children[0].getAttribute('colspan')) {
                return;
            }

            const texto = fila.innerText.toLowerCase();
            const visible = input === '' || texto.includes(input);
            
            fila.style.display = visible ? "" : "none";
            if (visible) contador++;
        });

        // Actualizar contador
        const contadorElemento = document.getElementById("contador-resultados");
        if (contadorElemento) {
            contadorElemento.textContent = contador;
        }

        // Mostrar mensaje si no hay resultados
        mostrarMensajeNoResultados(contador === 0 && input !== '');
    }

    // Función para limpiar búsqueda
    function limpiarBusqueda() {
        document.getElementById("buscador").value = '';
        filtrarCompetencias();
    }

    // Función para mostrar mensaje de no resultados
    function mostrarMensajeNoResultados(mostrar) {
        const tbody = document.querySelector("#tabla-competencias tbody");
        const filaNoResultados = document.getElementById("fila-no-resultados");

        if (mostrar) {
            if (!filaNoResultados) {
                const fila = document.createElement("tr");
                fila.id = "fila-no-resultados";
                fila.innerHTML = `
                    <td colspan="11" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <p class="mb-0">No se encontraron resultados para la búsqueda.</p>
                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="limpiarBusqueda()">
                                <i class="fas fa-times"></i> Limpiar búsqueda
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(fila);
            }
        } else {
            if (filaNoResultados) {
                filaNoResultados.remove();
            }
        }
    }

    // Función para confirmar eliminación
    function confirmarEliminacion(id, curso) {
        document.getElementById("mensaje-confirmacion").innerHTML = `
            <strong>¿Estás seguro de que deseas eliminar esta competencia?</strong><br>
            <em>Curso: ${curso}</em><br>
            <small class="text-muted">Esta acción se puede deshacer posteriormente.</small>
        `;
        
        document.getElementById("modalConfirmacionLabel").textContent = "Confirmar Eliminación";
        document.getElementById("btn-confirmar").className = "btn btn-danger";
        document.getElementById("btn-confirmar").innerHTML = '<i class="fas fa-trash"></i> Eliminar';
        
        accionPendiente = 'eliminar';
        idPendiente = id;
        
        new bootstrap.Modal(document.getElementById('modalConfirmacion')).show();
    }

    // Función para confirmar restauración
    function confirmarRestauracion(id, curso) {
        document.getElementById("mensaje-confirmacion").innerHTML = `
            <strong>¿Deseas restaurar esta competencia?</strong><br>
            <em>Curso: ${curso}</em><br>
            <small class="text-muted">La competencia volverá a estar disponible.</small>
        `;
        
        document.getElementById("modalConfirmacionLabel").textContent = "Confirmar Restauración";
        document.getElementById("btn-confirmar").className = "btn btn-success";
        document.getElementById("btn-confirmar").innerHTML = '<i class="fas fa-undo"></i> Restaurar';
        
        accionPendiente = 'restaurar';
        idPendiente = id;
        
        new bootstrap.Modal(document.getElementById('modalConfirmacion')).show();
    }

    // Ejecutar acción confirmada
    document.getElementById("btn-confirmar").addEventListener("click", function() {
        if (accionPendiente && idPendiente) {
            mostrarLoading(true);
            
            if (accionPendiente === 'eliminar') {
                const form = document.getElementById("form-eliminar");
                form.action = `{{ route('competencias.destroy', '') }}/${idPendiente}`;
                form.submit();
            } else if (accionPendiente === 'restaurar') {
                const form = document.getElementById("form-restaurar");
                form.action = `{{ route('competencias.restore', '') }}/${idPendiente}`;
                form.submit();
            }
        }
    });

    // Función para mostrar/ocultar loading
    function mostrarLoading(mostrar) {
        const loading = document.getElementById("loading");
        if (mostrar) {
            loading.classList.remove("d-none");
        } else {
            loading.classList.add("d-none");
        }
    }

    // Mejorar la experiencia de usuario con tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-dismiss de alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });

    // Función para destacar texto en búsqueda (opcional)
    function destacarTexto(texto, busqueda) {
        if (!busqueda) return texto;
        
        const regex = new RegExp(`(${busqueda})`, 'gi');
        return texto.replace(regex, '<mark>$1</mark>');
    }

    // Atajo de teclado para búsqueda
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'f') {
            event.preventDefault();
            document.getElementById('buscador').focus();
        }
    });
</script>
@endsection