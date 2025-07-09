@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header mejorado --}}
    <div class="row mb-4">
        <div class="col-12 text-center">
            <div class="d-inline-flex align-items-center bg-light rounded-pill px-4 py-2 mb-3">
                <i class="fas fa-clock text-warning me-2 fs-4"></i>
                <h2 class="mb-0 text-dark">Ventas Pendientes</h2>
            </div>
            <p class="text-muted fs-6">Gestión de ventas con saldo por cobrar (Plan de Pagos)</p>
        </div>
    </div>

    {{-- Alertas mejoradas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Buscador mejorado --}}
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <div class="input-group">
                <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="buscador" class="form-control form-control-lg" 
                       placeholder="Buscar por ID, Nombre, Apellido o Curso..." 
                       onkeyup="filtrarTabla()">
            </div>
        </div>
    </div>

    {{-- Tabla principal mejorada --}}
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Ventas Pendientes
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablaVentas">
                    <thead class="table-warning">
                        <tr>
                            <th class="text-center">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="text-center">
                                <i class="fas fa-user me-1"></i>Cliente
                            </th>
                            <th class="text-center">
                                <i class="fas fa-graduation-cap me-1"></i>Curso
                            </th>
                            <th class="text-center">
                                <i class="fas fa-user-tie me-1"></i>Vendedor
                            </th>
                            <th class="text-center">
                                <i class="fas fa-money-check me-1"></i>Primer Pago
                            </th>
                            <th class="text-center">
                                <i class="fas fa-exclamation-triangle me-1"></i>Saldo Pendiente
                            </th>
                            <th class="text-center">
                                <i class="fas fa-calendar me-1"></i>Fecha
                            </th>
                            <th class="text-center">
                                <i class="fas fa-info-circle me-1"></i>Estado
                            </th>
                            <th class="text-center">
                                <i class="fas fa-cog me-1"></i>Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventasPendientes as $cursoId => $ventasCurso)
                            <tr class="table-active">
                                <td colspan="9" class="text-center py-3">
                                    <strong class="text-primary fs-5">
                                        <i class="fas fa-book me-2"></i>
                                        {{ $ventasCurso->first()->curso->nombre }}
                                    </strong>
                                </td>
                            </tr>
                            @foreach($ventasCurso as $venta)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <span class="badge bg-secondary">#{{ $venta->id }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $venta->cliente->nombre }}</div>
                                                <small class="text-muted">{{ $venta->cliente->apellido_paterno }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">{{ $venta->curso->nombre }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <div class="fw-bold">{{ $venta->vendedor->nombre }}</div>
                                            <small class="text-muted">{{ $venta->vendedor->apellido_paterno }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success fw-bold">
                                            Bs {{ number_format($venta->primer_pago, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-danger fw-bold fs-5">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Bs {{ number_format($venta->saldo_pago, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-credit-card me-1"></i>
                                            Plan de Pagos
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="card bg-light border-0 p-3" style="min-width: 200px;">
                                            <form action="{{ route('rventas.completarPago', $venta->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-2">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Bs</span>
                                                        <input type="number" name="monto" class="form-control" 
                                                               placeholder="Monto" min="1" max="{{ $venta->saldo_pago }}" 
                                                               required>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <input type="text" name="baucher_numero" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="Número de Baucher" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Foto del Baucher:</label>
                                                    <input type="file" name="baucher_foto" 
                                                           class="form-control form-control-sm" 
                                                           accept="image/*,application/pdf" required>
                                                </div>

                                                <button class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-money-bill-wave me-1"></i>
                                                    Registrar Pago
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Historial de Pagos mejorado --}}
    @if(isset($historialPagos) && count($historialPagos) > 0)
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-gradient-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Historial de Pagos Registrados
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">
                                    <i class="fas fa-hashtag me-1"></i>Venta ID
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-user me-1"></i>Cliente
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-graduation-cap me-1"></i>Curso
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-money-bill me-1"></i>Monto Abonado
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-user-check me-1"></i>Registrado por
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-clock me-1"></i>Fecha y Hora
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-receipt me-1"></i>N° Baucher
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-image me-1"></i>Foto
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historialPagos as $curso => $pagosCurso)
                                <tr class="table-active">
                                    <td colspan="9" class="text-center py-3">
                                        <strong class="text-success fs-5">
                                            <i class="fas fa-book me-2"></i>
                                            {{ $curso }}
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($pagosCurso as $loopIndex => $pago)
                                    <tr class="align-middle">
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">#{{ $pago->venta_id }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($pago->venta && $pago->venta->cliente)
                                                <div>
                                                    <div class="fw-bold">{{ $pago->venta->cliente->nombre }}</div>
                                                    <small class="text-muted">{{ $pago->venta->cliente->apellido_paterno }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Cliente no disponible</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($pago->venta && $pago->venta->curso)
                                                <span class="badge bg-info text-dark">{{ $pago->venta->curso->nombre }}</span>
                                            @else
                                                <span class="text-muted">Curso no disponible</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="text-success fw-bold fs-5">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Bs {{ number_format($pago->monto, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-info fw-bold">{{ $pago->registrado_por }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($pago->created_at)->format('d/m/Y') }}
                                                <br>
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($pago->created_at)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($pago->baucher_numero)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-receipt me-1"></i>
                                                    {{ $pago->baucher_numero }}
                                                </span>
                                            @else
                                                <span class="text-muted">No disponible</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($pago->baucher_foto)
                                                <a href="{{ Storage::url($pago->baucher_foto) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-image me-1"></i>
                                                    Ver Foto
                                                </a>
                                            @else
                                                <span class="text-muted">No disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Estilos CSS adicionales --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }
    
    .avatar-sm {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1abc9c);
        transform: translateY(-1px);
    }
    
    .input-group-text {
        border-color: #007bff;
    }
</style>

{{-- Script de filtro mejorado --}}
<script>
    function filtrarTabla() {
        const filtro = document.getElementById('buscador').value.toLowerCase();
        const filas = document.querySelectorAll('#tablaVentas tbody tr');
        let resultados = 0;

        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            const esVisible = texto.includes(filtro);
            fila.style.display = esVisible ? '' : 'none';
            
            if (esVisible && !fila.classList.contains('table-active')) {
                resultados++;
            }
        });

        // Mostrar mensaje si no hay resultados
        const tbody = document.querySelector('#tablaVentas tbody');
        const mensajeNoResultados = document.getElementById('no-resultados');
        
        if (resultados === 0 && filtro !== '') {
            if (!mensajeNoResultados) {
                const fila = document.createElement('tr');
                fila.id = 'no-resultados';
                fila.innerHTML = `
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-search text-muted fs-1"></i>
                        <p class="text-muted mt-2">No se encontraron resultados para "${filtro}"</p>
                    </td>
                `;
                tbody.appendChild(fila);
            }
        } else if (mensajeNoResultados) {
            mensajeNoResultados.remove();
        }
    }

    // Mejora en la experiencia del usuario
    document.addEventListener('DOMContentLoaded', function() {
        const buscador = document.getElementById('buscador');
        buscador.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.add('border-primary');
            } else {
                this.classList.remove('border-primary');
            }
        });
    });
</script>
@endsection