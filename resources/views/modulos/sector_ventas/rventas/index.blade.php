@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Principal -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <div>
                        <h2 class="mb-1 fw-bold">
                            <i class="fas fa-chart-line me-2"></i>Registro de Ventas
                        </h2>
                        <p class="mb-0 opacity-75">Gestiona y controla todas las ventas de tu negocio</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-pill px-3 py-2">
                        <small class="text-white">Total de ventas: <span class="fw-bold">{{ $ventas->total() }}</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerta de Éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-white shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2 text-success"></i>
                <span class="text-dark">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Card de Acciones Principales -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-muted mb-3 fw-semibold">Acciones Principales</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('rventas.create') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-plus me-2"></i>Nueva Venta
                            </a>
                            <a href="{{ route('ventas.por.area') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-folder-open me-2"></i>Ventas por Área
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3 fw-semibold">Exportar Datos</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('rventas.pdf', ['fecha_desde' => request('fecha_desde'), 'fecha_hasta' => request('fecha_hasta')]) }}" 
                               class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-file-pdf me-2"></i>PDF
                            </a>
                            <a href="{{ route('rventas.excel', ['fecha_desde' => request('fecha_desde'), 'fecha_hasta' => request('fecha_hasta')]) }}" 
                               class="btn btn-success rounded-pill px-4">
                                <i class="fas fa-file-excel me-2"></i>Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Filtros -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Búsqueda General</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="buscador" onkeyup="filtrarVentas()" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Buscar cliente, curso o vendedor..."
                                   style="box-shadow: none; border-color: #e3e6f0;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Filtro por Fechas</label>
                        <form action="{{ route('rventas.index') }}" method="GET" class="d-flex gap-2">
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                                   class="form-control" title="Fecha desde">
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                                   class="form-control" title="Fecha hasta">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            <a href="{{ route('rventas.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Ventas Activas -->
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 pb-0">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-table me-2"></i>Ventas Activas
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tabla-ventas">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <tr class="text-white">
                                <th class="text-center border-0 py-3">#</th>
                                <th class="border-0 py-3">Cliente</th>
                                <th class="border-0 py-3">Curso</th>
                                <th class="border-0 py-3">Vendedor</th>
                                <th class="text-center border-0 py-3">Estado</th>
                                <th class="text-center border-0 py-3">Forma de Pago</th>
                                <th class="text-center border-0 py-3">Fecha</th>
                                <th class="text-center border-0 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas as $venta)
                            <tr class="border-bottom">
                                <td class="text-center py-3">
                                    <span class="badge bg-primary rounded-pill">{{ $venta->id }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="fw-semibold" style="color: #667eea;">{{ $venta->curso->nombre }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellido_paterno }}</span>
                                </td>
                                <td class="text-center py-3">
                                    @if($venta->estado_venta == 'Pagado')
                                        <span class="badge bg-success rounded-pill">
                                            <i class="fas fa-check me-1"></i>Pagado
                                        </span>
                                    @elseif($venta->estado_venta == 'Plan de Pagos')
                                        <span class="badge bg-warning rounded-pill">
                                            <i class="fas fa-clock me-1"></i>Plan de Pagos
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="fas fa-times me-1"></i>Anulado
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center py-3">
                                    <span class="text-muted">{{ $venta->forma_pago }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill" 
                                                data-bs-toggle="modal" data-bs-target="#verVentaModal{{ $venta->id }}" 
                                                title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('rventas.edit', $venta->id) }}" 
                                           class="btn btn-sm btn-outline-warning rounded-pill" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('rventas.destroy', $venta->id) }}" method="POST" 
                                              class="d-inline-block" onsubmit="return confirm('¿Eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detalle de Venta -->
                            <div class="modal fade" id="verVentaModal{{ $venta->id }}" tabindex="-1" 
                                 aria-labelledby="ventaModalLabel{{ $venta->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0" style="border-radius: 15px;">
                                        <div class="modal-header text-white border-0" 
                                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                                            <h5 class="modal-title fw-bold" id="ventaModalLabel{{ $venta->id }}">
                                                <i class="fas fa-receipt me-2"></i>Detalle de Venta #{{ $venta->id }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" 
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-3" style="color: #667eea;">Información del Cliente</h6>
                                                    <div class="mb-3">
                                                        <strong>Cliente:</strong> 
                                                        <span class="text-muted">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Curso:</strong> 
                                                        <span class="text-muted">{{ $venta->curso->nombre }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Vendedor:</strong> 
                                                        <span class="text-muted">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellido_paterno }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-3" style="color: #667eea;">Detalles de Pago</h6>
                                                    <div class="mb-3">
                                                        <strong>Costo del Curso:</strong> 
                                                        <span class="text-success fw-bold">Bs {{ number_format($venta->costo_curso, 2) }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Descuento:</strong> 
                                                        <span class="text-warning fw-bold">Bs {{ number_format($venta->descuento_monto, 2) }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Estado:</strong> 
                                                        @if($venta->estado_venta == 'Pagado')
                                                            <span class="badge bg-success rounded-pill">{{ $venta->estado_venta }}</span>
                                                        @elseif($venta->estado_venta == 'Plan de Pagos')
                                                            <span class="badge bg-warning rounded-pill">{{ $venta->estado_venta }}</span>
                                                        @else
                                                            <span class="badge bg-danger rounded-pill">{{ $venta->estado_venta }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Forma de Pago:</strong> 
                                                        <span class="text-muted">{{ $venta->forma_pago }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr class="my-4">
                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="fw-bold mb-3" style="color: #667eea;">Información Adicional</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if($venta->numero_transaccion)
                                                                <div class="mb-3">
                                                                    <strong>Número de Transacción:</strong> 
                                                                    <span class="text-muted">{{ $venta->numero_transaccion }}</span>
                                                                </div>
                                                            @endif
                                                            @if($venta->banco)
                                                                <div class="mb-3">
                                                                    <strong>Banco:</strong> 
                                                                    <span class="text-muted">{{ $venta->banco }}</span>
                                                                </div>
                                                            @endif
                                                            @if($venta->estado_venta == 'Pagado')
                                                                <div class="mb-3">
                                                                    <strong>Total Pagado:</strong> 
                                                                    <span class="text-success fw-bold">Bs {{ number_format($venta->total_pagado, 2) }}</span>
                                                                </div>
                                                            @elseif($venta->estado_venta == 'Plan de Pagos')
                                                                <div class="mb-3">
                                                                    <strong>Primer Pago:</strong> 
                                                                    <span class="text-info fw-bold">Bs {{ number_format($venta->primer_pago, 2) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <strong>Saldo Pendiente:</strong> 
                                                                <span class="text-danger fw-bold">Bs {{ number_format($venta->saldo_pago, 2) }}</span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>Fecha de Venta:</strong> 
                                                                <span class="text-muted">{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</span>
                                                            </div>
                                                            @if($venta->comprobante_pago)
                                                                <div class="mb-3">
                                                                    <strong>Comprobante:</strong> 
                                                                    <a href="{{ asset('storage/' . $venta->comprobante_pago) }}" 
                                                                       target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                                                        <i class="fas fa-file-pdf me-1"></i>Ver Comprobante
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3" style="color: #e3e6f0;"></i>
                                        <p class="mb-0">No hay ventas registradas</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $ventas->appends(request()->query())->links() }}
        </div>

        <!-- Ventas Eliminadas -->
        <div class="card border-0 shadow-sm mt-5" style="border-radius: 15px;">
            <div class="card-header bg-danger text-white border-0" style="border-radius: 15px 15px 0 0;">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-trash me-2"></i>Ventas Eliminadas
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center border-0 py-3">#</th>
                                <th class="border-0 py-3">Cliente</th>
                                <th class="border-0 py-3">Curso</th>
                                <th class="border-0 py-3">Vendedor</th>
                                <th class="text-center border-0 py-3">Estado</th>
                                <th class="text-center border-0 py-3">Forma de Pago</th>
                                <th class="text-center border-0 py-3">Fecha</th>
                                <th class="text-center border-0 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventasEliminadas as $venta)
                            <tr class="border-bottom">
                                <td class="text-center py-3">
                                    <span class="badge bg-secondary rounded-pill">{{ $venta->id }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-secondary me-3">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-muted">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido_paterno }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $venta->curso->nombre }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellido_paterno }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="badge bg-secondary rounded-pill">{{ $venta->estado_venta }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="text-muted">{{ $venta->forma_pago }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <form action="{{ route('rventas.restore', $venta->id) }}" method="POST" 
                                          class="d-inline-block" onsubmit="return confirm('¿Restaurar esta venta?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-success rounded-pill" title="Restaurar">
                                            <i class="fas fa-undo me-1"></i>Restaurar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-check-circle fa-3x mb-3" style="color: #e3e6f0;"></i>
                                        <p class="mb-0">No hay ventas eliminadas</p>
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
</div>

<!-- Estilos CSS personalizados -->
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .avatar-circle-secondary {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(10px);
    }
    
    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .btn-outline-primary:hover,
    .btn-outline-warning:hover,
    .btn-outline-danger:hover,
    .btn-outline-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e3e6f0;
    }
    
    .modal-content {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<!-- Script de búsqueda mejorado -->
<script>
    function filtrarVentas() {
        const input = document.getElementById("buscador").value.toLowerCase();
        const filas = document.querySelectorAll("#tabla-ventas tbody tr");
        let coincidencias = 0;
        
        filas.forEach(fila => {
            const texto = fila.innerText.toLowerCase();
            const esVisible = texto.includes(input);
            fila.style.display = esVisible ? "" : "none";
            if (esVisible) coincidencias++;
        });
        
        // Mostrar mensaje si no hay coincidencias
        const tbody = document.querySelector("#tabla-ventas tbody");
        let mensajeNoEncontrado = document.getElementById("mensaje-no-encontrado");
        
        if (coincidencias === 0 && input !== "") {
            if (!mensajeNoEncontrado) {
                mensajeNoEncontrado = document.createElement("tr");
                mensajeNoEncontrado.id = "mensaje-no-encontrado";
                mensajeNoEncontrado.innerHTML = `
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-search fa-3x mb-3" style="color: #e3e6f0;"></i>
                            <p class="mb-0">No se encontraron resultados para "${input}"</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(mensajeNoEncontrado);
            }
        } else if (mensajeNoEncontrado) {
            mensajeNoEncontrado.remove();
        }
    }
    
    // Efecto de carga en botones
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[onsubmit*="confirm"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                if (button) {
                    button.disabled = true;
                    const originalHtml = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    
                    // Restaurar el botón después de 3 segundos si no se envía
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                    }, 3000);
                }
            });
        });
    });
</script>
@endsection