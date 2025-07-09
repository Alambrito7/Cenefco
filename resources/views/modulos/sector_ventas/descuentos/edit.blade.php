@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Encabezado con breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('descuentos.index') }}" class="text-decoration-none">
                            <i class="fas fa-tags me-1"></i>Descuentos
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Descuento</li>
                </ol>
            </nav>
            <h2 class="display-6 text-center fw-bold text-warning mb-0">
                <i class="fas fa-edit me-2"></i>Editar Descuento
            </h2>
            <p class="text-muted text-center mb-0">Modifique los datos del descuento seleccionado</p>
        </div>
    </div>

    <!-- Contenedor principal del formulario -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Información actual del descuento -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información Actual
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle p-3 me-3">
                            <i class="fas fa-tag text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $descuento->nombre }}</h5>
                            <span class="badge bg-info fs-6 me-2">{{ $descuento->porcentaje }}%</span>
                            <small class="text-muted">ID: {{ $descuento->id }}</small>
                            <p class="mb-0 text-muted mt-1">
                                {{ $descuento->descripcion ?? 'Sin descripción' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modificar Información
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>¡Ups!</strong> Hay algunos errores:
                            </div>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('descuentos.update', $descuento) }}" method="POST" id="editDescuentoForm">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del descuento -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tag me-2 text-primary"></i>Nombre del Descuento
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $descuento->nombre) }}" 
                                   placeholder="Ej: Descuento de Temporada"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Modifique el nombre del descuento
                            </div>
                        </div>

                        <!-- Porcentaje -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-percent me-2 text-success"></i>Porcentaje (%)
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       step="0.01" 
                                       name="porcentaje" 
                                       class="form-control form-control-lg @error('porcentaje') is-invalid @enderror" 
                                       value="{{ old('porcentaje', $descuento->porcentaje) }}" 
                                       placeholder="15.00"
                                       min="0" 
                                       max="100"
                                       required>
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                @error('porcentaje')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Ajuste el porcentaje de descuento (0-100%)
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-align-left me-2 text-info"></i>Descripción
                                <span class="text-muted">(Opcional)</span>
                            </label>
                            <textarea name="descripcion" 
                                      class="form-control @error('descripcion') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Actualice la descripción del descuento...">{{ old('descripcion', $descuento->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Modifique la información adicional del descuento
                            </div>
                        </div>

                        <!-- Comparación de cambios -->
                        <div class="alert alert-light border" id="changesPreview" style="display: none;">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-exchange-alt me-2"></i>Cambios Detectados:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-danger">
                                        <div class="card-header bg-danger text-white py-2">
                                            <small><i class="fas fa-minus me-1"></i>Valores Actuales</small>
                                        </div>
                                        <div class="card-body py-2">
                                            <div id="currentValues"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white py-2">
                                            <small><i class="fas fa-plus me-1"></i>Nuevos Valores</small>
                                        </div>
                                        <div class="card-body py-2">
                                            <div id="newValues"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('descuentos.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-warning btn-lg me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Restaurar
                                </button>
                                <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                    <i class="fas fa-save me-2"></i>Actualizar Descuento
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Valores originales para comparación
    const originalValues = {
        nombre: '{{ $descuento->nombre }}',
        porcentaje: '{{ $descuento->porcentaje }}',
        descripcion: '{{ $descuento->descripcion ?? '' }}'
    };

    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.querySelector('input[name="nombre"]');
        const porcentajeInput = document.querySelector('input[name="porcentaje"]');
        const descripcionInput = document.querySelector('textarea[name="descripcion"]');
        const changesPreview = document.getElementById('changesPreview');
        const currentValues = document.getElementById('currentValues');
        const newValues = document.getElementById('newValues');

        function checkChanges() {
            const current = {
                nombre: nombreInput.value.trim(),
                porcentaje: porcentajeInput.value.trim(),
                descripcion: descripcionInput.value.trim()
            };

            const hasChanges = 
                current.nombre !== originalValues.nombre ||
                current.porcentaje !== originalValues.porcentaje ||
                current.descripcion !== originalValues.descripcion;

            if (hasChanges) {
                changesPreview.style.display = 'block';
                
                // Mostrar valores actuales
                currentValues.innerHTML = `
                    <small><strong>Nombre:</strong> ${originalValues.nombre}</small><br>
                    <small><strong>Porcentaje:</strong> ${originalValues.porcentaje}%</small><br>
                    <small><strong>Descripción:</strong> ${originalValues.descripcion || 'Sin descripción'}</small>
                `;
                
                // Mostrar nuevos valores
                newValues.innerHTML = `
                    <small><strong>Nombre:</strong> ${current.nombre}</small><br>
                    <small><strong>Porcentaje:</strong> ${current.porcentaje}%</small><br>
                    <small><strong>Descripción:</strong> ${current.descripcion || 'Sin descripción'}</small>
                `;
            } else {
                changesPreview.style.display = 'none';
            }
        }

        // Eventos para detectar cambios
        nombreInput.addEventListener('input', checkChanges);
        porcentajeInput.addEventListener('input', checkChanges);
        descripcionInput.addEventListener('input', checkChanges);

        // Validación del porcentaje
        porcentajeInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
        });

        // Confirmación antes de enviar
        document.getElementById('editDescuentoForm').addEventListener('submit', function(e) {
            const nombre = nombreInput.value.trim();
            const porcentaje = porcentajeInput.value.trim();
            
            if (!nombre || !porcentaje) {
                e.preventDefault();
                alert('Por favor, complete todos los campos obligatorios.');
                return false;
            }

            if (!confirm('¿Está seguro de que desea actualizar este descuento?')) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Función para restaurar valores originales
    function resetForm() {
        if (confirm('¿Está seguro de que desea restaurar los valores originales?')) {
            document.querySelector('input[name="nombre"]').value = originalValues.nombre;
            document.querySelector('input[name="porcentaje"]').value = originalValues.porcentaje;
            document.querySelector('textarea[name="descripcion"]').value = originalValues.descripcion;
            document.getElementById('changesPreview').style.display = 'none';
        }
    }
</script>
@endpush
@endsection