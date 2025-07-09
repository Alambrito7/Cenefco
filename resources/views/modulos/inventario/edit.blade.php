@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Inventario
                    </h3>
                    <small class="text-muted">
                        Código: <strong>{{ $inventario->codigo_af }}</strong>
                    </small>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Atención!</strong> Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('inventario.update', $inventario->id) }}" method="POST" id="inventarioEditForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Básica -->
                        <div class="mb-4">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>
                                Información Básica
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-barcode me-1"></i>
                                        Código AF
                                    </label>
                                    <input type="text" name="codigo_af" class="form-control bg-light" 
                                           value="{{ old('codigo_af', $inventario->codigo_af) }}" readonly>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-lock me-1"></i>
                                        Campo protegido - Solo lectura
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-tag me-1"></i>
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="{{ old('nombre', $inventario->nombre) }}" required 
                                           placeholder="Nombre del activo">
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del activo.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-cube me-1"></i>
                                        Modelo
                                    </label>
                                    <input type="text" name="concepto_1" class="form-control" 
                                           value="{{ old('concepto_1', $inventario->concepto_1) }}" 
                                           placeholder="Modelo o concepto">
                                </div>
                            </div>
                        </div>

                        <!-- Características -->
                        <div class="mb-4">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fas fa-cogs me-2"></i>
                                Características
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-palette me-1"></i>
                                        Color
                                    </label>
                                    <input type="text" name="concepto_2" class="form-control" 
                                           value="{{ old('concepto_2', $inventario->concepto_2) }}" 
                                           placeholder="Color del activo">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-mobile-alt me-1"></i>
                                        IMEI 1
                                    </label>
                                    <input type="text" name="imei_1" class="form-control" 
                                           value="{{ old('imei_1', $inventario->imei_1) }}" 
                                           placeholder="IMEI principal">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-mobile-alt me-1"></i>
                                        IMEI 2
                                    </label>
                                    <input type="text" name="imei_2" class="form-control" 
                                           value="{{ old('imei_2', $inventario->imei_2) }}" 
                                           placeholder="IMEI secundario">
                                </div>
                            </div>
                        </div>

                        <!-- Información SIM -->
                        <div class="mb-4">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fas fa-sim-card me-2"></i>
                                Información SIM
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-sim-card me-1"></i>
                                        SIM 1
                                    </label>
                                    <input type="text" name="sim_1" class="form-control" 
                                           value="{{ old('sim_1', $inventario->sim_1) }}" 
                                           placeholder="Número SIM 1">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-sim-card me-1"></i>
                                        SIM 2
                                    </label>
                                    <input type="text" name="sim_2" class="form-control" 
                                           value="{{ old('sim_2', $inventario->sim_2) }}" 
                                           placeholder="Número SIM 2">
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Asignación -->
                        <div class="mb-4">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Estado y Asignación
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-toggle-on me-1"></i>
                                        Estado <span class="text-danger">*</span>
                                    </label>
                                    <select name="estado" class="form-select" required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="Activo" {{ old('estado', $inventario->estado) == 'Activo' ? 'selected' : '' }}>
                                            ✅ Activo
                                        </option>
                                        <option value="Inactivo" {{ old('estado', $inventario->estado) == 'Inactivo' ? 'selected' : '' }}>
                                            ❌ Inactivo
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un estado.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Destino
                                    </label>
                                    <input type="text" name="destino" class="form-control" 
                                           value="{{ old('destino', $inventario->destino) }}" 
                                           placeholder="Ubicación o destino">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-user-tie me-1"></i>
                                        Responsable <span class="text-danger">*</span>
                                    </label>
                                    <select name="responsable_id" class="form-select" required>
                                        <option value="">Seleccionar responsable</option>
                                        @foreach($personales as $p)
                                            <option value="{{ $p->id }}" 
                                                    {{ old('responsable_id', $inventario->responsable_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre }} {{ $p->apellido_paterno }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un responsable.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones y Valor -->
                        <div class="mb-4">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Información Adicional
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-comment me-1"></i>
                                        Observaciones
                                    </label>
                                    <textarea name="observaciones" class="form-control" rows="3" 
                                              placeholder="Observaciones adicionales o notas importantes...">{{ old('observaciones', $inventario->observaciones) }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-dollar-sign me-1"></i>
                                        Valor (Bs) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Bs</span>
                                        <input type="number" step="0.01" name="valor" class="form-control" 
                                               value="{{ old('valor', $inventario->valor) }}" required 
                                               placeholder="0.00" min="0">
                                        <div class="invalid-feedback">
                                            Por favor ingrese el valor del activo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Auditoría -->
                        <div class="mb-4">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Información de Registro
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-plus me-1"></i>
                                            <strong>Creado:</strong> {{ $inventario->created_at ? $inventario->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-edit me-1"></i>
                                            <strong>Última modificación:</strong> {{ $inventario->updated_at ? $inventario->updated_at->format('d/m/Y H:i') : 'No disponible' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Los campos marcados con <span class="text-danger">*</span> son obligatorios
                            </small>
                            <div class="btn-group">
                                <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning text-dark">
                                    <i class="fas fa-save me-1"></i>
                                    Actualizar Registro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.getElementById('inventarioEditForm');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    }, false);
    
    // Formatear valor en tiempo real
    const valorInput = document.querySelector('input[name="valor"]');
    if (valorInput) {
        valorInput.addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });
    }

    // Confirmación antes de enviar
    form.addEventListener('submit', function(e) {
        const confirmed = confirm('¿Está seguro de que desea actualizar este registro de inventario?');
        if (!confirmed) {
            e.preventDefault();
        }
    });
});
</script>
@endsection