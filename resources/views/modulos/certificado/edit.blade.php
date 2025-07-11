@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Header con información del certificado --}}
            <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                    <i class="fas fa-certificate text-primary fs-2"></i>
                </div>
                <div>
                    <h2 class="mb-1">Editar Certificado</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-user me-2"></i>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-book me-2"></i>{{ $curso->nombre }} ({{ $curso->area }})
                    </p>
                </div>
            </div>

            {{-- Formulario principal --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Información del Certificado
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('certificados.update', ['clienteId' => $cliente->id, 'cursoId' => $curso->id]) }}" method="POST" novalidate>
                        @csrf

                        {{-- Personal que entregó --}}
                        <div class="mb-4">
    <label for="personal_entrego_id" class="form-label fw-semibold">
        <i class="fas fa-user-tie me-2 text-primary"></i>Personal que Entregó
        <span class="text-danger">*</span>
    </label>
    <select 
        id="personal_entrego_id" 
        name="personal_entrego_id" 
        class="form-select @error('personal_entrego_id') is-invalid @enderror" 
        required
    >
        <option value="">Seleccione el personal responsable</option>
        @foreach($personales as $empleado)
            <option value="{{ $empleado->id }}" 
                {{ old('personal_entrego_id', $certificado->personal_entrego_id ?? '') == $empleado->id ? 'selected' : '' }}>
                {{ $empleado->nombre }} {{ $empleado->apellido }} - {{ $empleado->cargo ?? 'Sin cargo' }}
            </option>
        @endforeach
    </select>
    @error('personal_entrego_id')
        <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
        </div>
    @enderror
</div>

                        {{-- Modalidad de entrega --}}
                        <div class="mb-4">
                            <label for="modalidad_entrega" class="form-label fw-semibold">
                                <i class="fas fa-shipping-fast me-2 text-primary"></i>Modalidad de Entrega
                                <span class="text-danger">*</span>
                            </label>
                            <select 
                                id="modalidad_entrega" 
                                name="modalidad_entrega" 
                                class="form-select @error('modalidad_entrega') is-invalid @enderror" 
                                required
                            >
                                <option value="">-- Seleccione una modalidad --</option>
                                <option value="Envío" {{ old('modalidad_entrega', $certificado->modalidad_entrega ?? '') == 'Envío' ? 'selected' : '' }}>
                                    📦 Envío
                                </option>
                                <option value="Entrega en Oficina" {{ old('modalidad_entrega', $certificado->modalidad_entrega ?? '') == 'Entrega en Oficina' ? 'selected' : '' }}>
                                    🏢 Entrega en Oficina
                                </option>
                            </select>
                            @error('modalidad_entrega')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Estado de entrega --}}
                        <div class="mb-4">
                            <label for="estado_entrega" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-primary"></i>Estado de Entrega
                                <span class="text-danger">*</span>
                            </label>
                            <select 
                                id="estado_entrega" 
                                name="estado_entrega" 
                                class="form-select @error('estado_entrega') is-invalid @enderror" 
                                required
                            >
                                <option value="">-- Seleccione un estado --</option>
                                <option value="Entregado" {{ old('estado_entrega', $certificado->estado_entrega ?? '') == 'Entregado' ? 'selected' : '' }}>
                                    ✅ Entregado
                                </option>
                                <option value="Pendiente" {{ old('estado_entrega', $certificado->estado_entrega ?? '') == 'Pendiente' ? 'selected' : '' }}>
                                    ⏳ Pendiente
                                </option>
                            </select>
                            @error('estado_entrega')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Fecha de entrega --}}
                        <div class="mb-4">
                            <label for="fecha_entrega" class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Fecha de Entrega
                                <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="fecha_entrega" 
                                name="fecha_entrega" 
                                class="form-control @error('fecha_entrega') is-invalid @enderror" 
                                value="{{ old('fecha_entrega', $certificado?->fecha_entrega ? \Carbon\Carbon::parse($certificado->fecha_entrega)->format('Y-m-d') : '') }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required
                            >
                            @error('fecha_entrega')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                La fecha no puede ser posterior a hoy
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        <div class="mb-4">
                            <label for="observaciones" class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Observaciones
                                <span class="text-muted">(Opcional)</span>
                            </label>
                            <textarea 
                                id="observaciones" 
                                name="observaciones" 
                                class="form-control @error('observaciones') is-invalid @enderror"
                                rows="4"
                                placeholder="Ingrese cualquier observación adicional sobre la entrega del certificado..."
                                maxlength="500"
                            >{{ old('observaciones', $certificado->observaciones ?? '') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <span id="observaciones-counter">0</span>/500 caracteres
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="{{ route('certificados.dashboard', ['curso_id' => $curso->id]) }}" class="btn btn-secondary px-4">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="button" class="btn btn-outline-info px-4" data-bs-toggle="modal" data-bs-target="#historialModal">
                                <i class="fas fa-history me-2"></i>Ver Historial
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card de información adicional --}}
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Información Importante
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li><i class="fas fa-check text-success me-2"></i>Todos los campos marcados con (*) son obligatorios</li>
                        <li><i class="fas fa-check text-success me-2"></i>La fecha de entrega no puede ser posterior a la fecha actual</li>
                        <li><i class="fas fa-check text-success me-2"></i>Las observaciones son opcionales y pueden contener hasta 500 caracteres</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para historial (opcional) --}}
<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historialModalLabel">
                    <i class="fas fa-history me-2"></i>Historial de Cambios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Aquí se mostraría el historial de cambios del certificado.</p>
                {{-- Aquí puedes agregar la lógica para mostrar el historial --}}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para observaciones
    const observacionesTextarea = document.getElementById('observaciones');
    const counter = document.getElementById('observaciones-counter');
    
    function updateCounter() {
        const length = observacionesTextarea.value.length;
        counter.textContent = length;
        
        if (length > 450) {
            counter.classList.add('text-warning');
        } else {
            counter.classList.remove('text-warning');
        }
    }
    
    // Inicializar contador
    updateCounter();
    
    // Actualizar contador en tiempo real
    observacionesTextarea.addEventListener('input', updateCounter);
    
    // Validación en tiempo real
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    function validateField(field) {
        const isValid = field.checkValidity();
        
        if (!isValid) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
        } else {
            field.classList.add('is-valid');
            field.classList.remove('is-invalid');
        }
    }
    
    // Confirmación antes de enviar
    form.addEventListener('submit', function(e) {
        const confirmMessage = '¿Está seguro que desea guardar los cambios en este certificado?';
        if (!confirm(confirmMessage)) {
            e.preventDefault();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    transition: box-shadow 0.2s ease-in-out;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.text-danger {
    color: #dc3545 !important;
}

.is-valid {
    border-color: #198754 !important;
}

.is-invalid {
    border-color: #dc3545 !important;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.gap-2 .btn {
        width: 100%;
    }
}
</style>
@endpush