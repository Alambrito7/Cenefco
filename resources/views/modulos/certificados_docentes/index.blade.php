@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">📄 Certificados Docentes</h2>
                <div class="badge bg-info fs-6">
                    Total: {{ $certificados->count() }} certificados
                </div>
            </div>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Barra de herramientas --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">🔍</span>
                                <input type="text" id="buscador" class="form-control" 
                                       placeholder="Buscar por docente, curso, ciudad..."
                                       onkeyup="filtrarCertificados()">
                                <button class="btn btn-outline-secondary" type="button" onclick="limpiarBusqueda()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="filtro-estado" class="form-select" onchange="filtrarPorEstado()">
                                <option value="">Todos los estados</option>
                                <option value="Entregado">Entregado</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En proceso">En proceso</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('certificados_docentes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nuevo Certificado
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de certificados activos --}}
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Certificados Activos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tabla-certificados">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Docente</th>
                                    <th>Contacto</th>
                                    <th>Curso</th>
                                    <th>Periodo</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>Fechas</th>
                                    <th>Guía/Dirección</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificados as $certificado)
                                    <tr class="certificado-row">
                                        <td class="text-center fw-bold">{{ $certificado->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    {{ strtoupper(substr($certificado->docente->nombre, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $certificado->docente->nombre }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">📱</small>
                                            <span class="ms-1">{{ $certificado->docente->telefono }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $certificado->curso->nombre }}</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><strong>{{ $certificado->anio }}</strong></div>
                                                <div class="text-muted">{{ $certificado->mes_curso }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                            {{ $certificado->ciudad }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $certificado->estado_certificado === 'Entregado' ? 'bg-success' : ($certificado->estado_certificado === 'En proceso' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                                {{ $certificado->estado_certificado }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                @if($certificado->fecha_entrega_area_academica)
                                                    <div class="text-success">
                                                        <i class="fas fa-calendar-check me-1"></i>
                                                        {{ \Carbon\Carbon::parse($certificado->fecha_entrega_area_academica)->format('d/m/Y') }}
                                                    </div>
                                                @endif
                                                @if($certificado->fecha_envio_entregada)
                                                    <div class="text-primary">
                                                        <i class="fas fa-shipping-fast me-1"></i>
                                                        {{ \Carbon\Carbon::parse($certificado->fecha_envio_entregada)->format('d/m/Y') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($certificado->estado_certificado === 'Entregado')
                                                <div class="small">
                                                    <i class="fas fa-building text-success me-1"></i>
                                                    {{ $certificado->direccion_oficina }}
                                                </div>
                                            @else
                                                <div class="small">
                                                    <i class="fas fa-truck text-warning me-1"></i>
                                                    {{ $certificado->numero_guia ?? 'Sin asignar' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('certificados_docentes.edit', $certificado->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirmarEliminacion({{ $certificado->id }})"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <div>No hay certificados registrados</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Certificados Eliminados --}}
            @if($certificadosEliminados->count() > 0)
                <div class="card mt-5">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">🗑 Certificados Eliminados</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Docente</th>
                                        <th>Curso</th>
                                        <th>Estado</th>
                                        <th>Fecha Eliminación</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($certificadosEliminados as $certificado)
                                        <tr class="table-light">
                                            <td class="fw-bold">{{ $certificado->id }}</td>
                                            <td>{{ $certificado->docente->nombre }}</td>
                                            <td>{{ $certificado->curso->nombre }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $certificado->estado_certificado }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($certificado->deleted_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        onclick="confirmarRestauracion({{ $certificado->id }})"
                                                        title="Restaurar">
                                                    <i class="fas fa-undo me-1"></i>Restaurar
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

{{-- Estilos personalizados --}}
<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .btn-group .btn {
        border-radius: 0.375rem;
    }
    
    .btn-group .btn:not(:last-child) {
        margin-right: 2px;
    }
    
    .certificado-row {
        transition: all 0.3s ease;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .alert {
        border-radius: 0.5rem;
    }
    
    .badge {
        font-size: 0.75em;
    }
</style>

{{-- Scripts mejorados --}}
<script>
    // URLs base para las rutas
    const baseUrl = window.location.origin;
    const certificadosUrl = `${baseUrl}/certificados_docentes`;

    // Función de búsqueda mejorada
    function filtrarCertificados() {
        const input = document.getElementById("buscador").value.toLowerCase();
        const estado = document.getElementById("filtro-estado").value.toLowerCase();
        const filas = document.querySelectorAll("#tabla-certificados tbody tr.certificado-row");
        let contador = 0;
        
        filas.forEach(fila => {
            const texto = fila.innerText.toLowerCase();
            const estadoFila = fila.querySelector('.badge').innerText.toLowerCase();
            
            const coincideTexto = texto.includes(input);
            const coincideEstado = !estado || estadoFila.includes(estado);
            
            if (coincideTexto && coincideEstado) {
                fila.style.display = "";
                contador++;
            } else {
                fila.style.display = "none";
            }
        });
        
        // Mostrar contador de resultados
        actualizarContadorResultados(contador);
    }

    function filtrarPorEstado() {
        filtrarCertificados();
    }

    function limpiarBusqueda() {
        document.getElementById("buscador").value = "";
        document.getElementById("filtro-estado").value = "";
        filtrarCertificados();
    }

    function actualizarContadorResultados(contador) {
        const badge = document.querySelector('.badge.bg-info');
        if (badge) {
            badge.textContent = `Mostrando: ${contador} certificados`;
        }
    }

    // Confirmación de eliminación mejorada
    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El certificado será movido a la papelera",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('form-eliminar');
                form.action = `${certificadosUrl}/${id}`;
                form.submit();
            }
        });
    }

    // Confirmación de restauración
    function confirmarRestauracion(id) {
        Swal.fire({
            title: '¿Restaurar certificado?',
            text: "El certificado será restaurado a la lista activa",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('form-restaurar');
                form.action = `${certificadosUrl}/${id}/restore`;
                form.submit();
            }
        });
    }

    // Inicializar tooltips si Bootstrap está disponible
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>

{{-- CDN para SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection