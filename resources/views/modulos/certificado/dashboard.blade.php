@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center">🎓 Módulo Certificados</h2>

    @if(session('success'))
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtro de cursos --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">📚 Seleccionar Curso</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('certificados.dashboard') }}" method="GET">
                <div class="row">
                    <div class="col-md-8">
                        <select name="curso_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccione un Curso --</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" 
                                        {{ (isset($cursoSeleccionadoId) && $cursoSeleccionadoId == $curso->id) ? 'selected' : '' }}>
                                    {{ $curso->nombre }} ({{ $curso->area }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de certificados --}}
    @if($cursoSeleccionadoId)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Inscritos al Curso: {{ $cursos->find($cursoSeleccionadoId)->nombre }}</h5>
                <span class="badge bg-primary">{{ $inscritos->count() }} inscrito(s)</span>
            </div>
            <div class="card-body">
                @if($inscritos->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No hay inscritos en este curso.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 15%;">Cliente</th>
                                    <th style="width: 12%;">Estado</th>
                                    <th style="width: 15%;">Personal Entrega</th>
                                    <th style="width: 12%;">Modalidad</th>
                                    <th style="width: 15%;">Observaciones</th>
                                    <th style="width: 10%;">Fecha Entrega</th>
                                    <th style="width: 21%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscritos as $inscrito)
                                    @php
                                        $certificado = $inscrito->certificados->first();
                                        $personal = $certificado?->personal;
                                        $estadoEntrega = $certificado?->estado_entrega ?? 'Pendiente';
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $inscrito->nombre }}</strong><br>
                                            <small class="text-muted">{{ $inscrito->apellido_paterno }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $estadoEntrega === 'Entregado' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $estadoEntrega }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($personal)
                                                <small>{{ $personal->nombre }} {{ $personal->apellido_paterno }} {{ $personal->apellido_materno }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $certificado?->modalidad_entrega ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($certificado?->observaciones)
                                                <small>{{ Str::limit($certificado->observaciones, 50) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($certificado?->fecha_entrega)
                                                <small>{{ \Carbon\Carbon::parse($certificado->fecha_entrega)->format('d/m/Y') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column align-items-center gap-1">

                                                {{-- Botón Editar --}}
                                                <a href="{{ route('certificados.edit', ['clienteId' => $inscrito->id, 'cursoId' => $cursoSeleccionadoId]) }}"
                                                   class="btn btn-outline-primary btn-sm w-100"
                                                   title="Editar certificado">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>

                                                {{-- Acciones para certificados entregados --}}
                                                @if($certificado && $certificado->estado_entrega === 'Entregado')
                                                    {{-- Ver Recibo --}}
                                                    <a href="{{ route('certificados.recibo', ['clienteId' => $inscrito->id, 'cursoId' => $cursoSeleccionadoId]) }}"
                                                       class="btn btn-outline-dark btn-sm w-100" 
                                                       target="_blank"
                                                       title="Ver recibo de entrega">
                                                        <i class="fas fa-receipt"></i> Ver Recibo
                                                    </a>

                                                    {{-- Sección WhatsApp --}}
                                                    <div class="whatsapp-section w-100 mt-2">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-whatsapp text-success"></i>
                                                            </span>
                                                            <input type="text"
                                                                   id="numero_whatsapp_{{ $inscrito->id }}"
                                                                   class="form-control text-center"
                                                                   placeholder="591XXXXXXXXX"
                                                                   pattern="591[0-9]{8}"
                                                                   title="Formato: 591XXXXXXXXX"
                                                                   maxlength="11"
                                                                   required>
                                                        </div>
                                                        <button class="btn btn-success btn-sm w-100 mt-1"
                                                                onclick="enviarPorWhatsApp({{ $inscrito->id }}, '{{ route('certificados.recibo', ['clienteId' => $inscrito->id, 'cursoId' => $cursoSeleccionadoId]) }}', '{{ $inscrito->nombre }} {{ $inscrito->apellido_paterno }}')"
                                                                title="Enviar recibo por WhatsApp">
                                                            <i class="fab fa-whatsapp"></i> Enviar WhatsApp
                                                        </button>
                                                    </div>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-arrow-up"></i> Seleccione un curso para ver los certificados.
        </div>
    @endif

</div>

{{-- Loading overlay --}}
<div id="loadingOverlay" class="d-none">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>
@endsection

@push('styles')
<style>
    .whatsapp-section {
        background-color: #f8f9fa;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
    
    .input-group-sm .form-control {
        font-size: 0.8rem;
    }
    
    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.075);
    }
</style>
@endpush

@push('scripts')
<script>
function enviarPorWhatsApp(clienteId, linkRecibo, nombreCliente) {
    const input = document.getElementById('numero_whatsapp_' + clienteId);
    const numero = input.value.trim();

    // Validaciones mejoradas
    if (!numero) {
        mostrarAlerta('⚠️ Por favor ingrese un número de WhatsApp', 'warning');
        input.focus();
        return;
    }

    if (!numero.startsWith('591')) {
        mostrarAlerta('⚠️ El número debe comenzar con 591 (código de Bolivia)', 'warning');
        input.focus();
        return;
    }

    if (numero.length !== 11) {
        mostrarAlerta('⚠️ El número debe tener 11 dígitos (ej. 59176543210)', 'warning');
        input.focus();
        return;
    }

    if (!/^591[0-9]{8}$/.test(numero)) {
        mostrarAlerta('⚠️ Formato de número inválido. Use solo números (ej. 59176543210)', 'warning');
        input.focus();
        return;
    }

    // Mostrar loading
    mostrarLoading(true);

    try {
        // Mensaje personalizado
        const mensaje = encodeURIComponent(
            `¡Hola ${nombreCliente}! 👋\n\n` +
            `Te saluda el equipo de certificaciones. 🎓\n\n` +
            `Aquí tienes tu recibo de entrega de certificado:\n` +
            `📄 ${linkRecibo}\n\n` +
            `¡Felicitaciones por completar el curso! 🎉`
        );

        const url = `https://api.whatsapp.com/send?phone=${numero}&text=${mensaje}`;
        
        // Abrir WhatsApp
        window.open(url, '_blank');
        
        // Limpiar el input después de enviar
        setTimeout(() => {
            input.value = '';
            mostrarAlerta('✅ Mensaje enviado correctamente', 'success');
        }, 1000);

    } catch (error) {
        console.error('Error al enviar WhatsApp:', error);
        mostrarAlerta('❌ Error al enviar el mensaje', 'danger');
    } finally {
        mostrarLoading(false);
    }
}

function mostrarAlerta(mensaje, tipo) {
    // Crear alerta dinámica
    const alertaId = 'alerta-' + Date.now();
    const alertaHTML = `
        <div id="${alertaId}" class="alert alert-${tipo} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertaHTML);
    
    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        const alerta = document.getElementById(alertaId);
        if (alerta) {
            alerta.remove();
        }
    }, 5000);
}

function mostrarLoading(mostrar) {
    const overlay = document.getElementById('loadingOverlay');
    if (mostrar) {
        overlay.classList.remove('d-none');
    } else {
        overlay.classList.add('d-none');
    }
}

// Formatear automáticamente el número mientras se escribe
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('[id^="numero_whatsapp_"]');
    
    inputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            
            // Asegurar que comience con 591
            if (value.length > 0 && !value.startsWith('591')) {
                if (value.startsWith('591')) {
                    value = value;
                } else {
                    value = '591' + value.replace(/^591/, '');
                }
            }
            
            // Limitar a 11 dígitos
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            e.target.value = value;
        });
        
        // Placeholder dinámico
        input.addEventListener('focus', function(e) {
            if (!e.target.value) {
                e.target.value = '591';
            }
        });
    });
});

// Confirmación antes de salir si hay datos en los inputs
window.addEventListener('beforeunload', function(e) {
    const inputs = document.querySelectorAll('[id^="numero_whatsapp_"]');
    let hayDatos = false;
    
    inputs.forEach(input => {
        if (input.value.trim() && input.value.trim() !== '591') {
            hayDatos = true;
        }
    });
    
    if (hayDatos) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endpush