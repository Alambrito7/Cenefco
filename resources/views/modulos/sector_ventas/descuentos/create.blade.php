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
                    <li class="breadcrumb-item active" aria-current="page">Registrar Nuevo</li>
                </ol>
            </nav>
            <h2 class="display-6 text-center fw-bold text-primary mb-0">
                <i class="fas fa-plus-circle me-2"></i>Registrar Nuevo Descuento
            </h2>
            <p class="text-muted text-center mb-0">Complete el formulario para crear un nuevo descuento</p>
        </div>
    </div>

    <!-- Contenedor principal del formulario -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Información del Descuento
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

                    <form action="{{ route('descuentos.store') }}" method="POST" id="descuentoForm">
                        @csrf

                        <!-- Nombre del descuento -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tag me-2 text-primary"></i>Nombre del Descuento
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre') }}" 
                                   placeholder="Ej: Descuento de Temporada"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Ingrese un nombre descriptivo para identificar el descuento
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
                                       value="{{ old('porcentaje') }}" 
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
                                Ingrese el porcentaje de descuento (0-100%)
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
                                      placeholder="Describe las condiciones o detalles del descuento...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Información adicional sobre el descuento (opcional)
                            </div>
                        </div>

                        <!-- Vista previa -->
                        <div class="alert alert-light border" id="preview" style="display: none;">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-eye me-2"></i>Vista Previa:
                            </h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class="fas fa-tag text-white"></i>
                                </div>
                                <div>
                                    <strong id="previewNombre">-</strong>
                                    <span class="badge bg-success ms-2" id="previewPorcentaje">0%</span>
                                    <br>
                                    <small class="text-muted" id="previewDescripcion">Sin descripción</small>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('descuentos.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                <i class="fas fa-save me-2"></i>Guardar Descuento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Vista previa en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.querySelector('input[name="nombre"]');
        const porcentajeInput = document.querySelector('input[name="porcentaje"]');
        const descripcionInput = document.querySelector('textarea[name="descripcion"]');
        const preview = document.getElementById('preview');
        const previewNombre = document.getElementById('previewNombre');
        const previewPorcentaje = document.getElementById('previewPorcentaje');
        const previewDescripcion = document.getElementById('previewDescripcion');

        function updatePreview() {
            const nombre = nombreInput.value.trim();
            const porcentaje = porcentajeInput.value.trim();
            const descripcion = descripcionInput.value.trim();

            if (nombre || porcentaje) {
                preview.style.display = 'block';
                previewNombre.textContent = nombre || 'Nombre del descuento';
                previewPorcentaje.textContent = (porcentaje || '0') + '%';
                previewDescripcion.textContent = descripcion || 'Sin descripción';
            } else {
                preview.style.display = 'none';
            }
        }

        // Eventos para actualizar vista previa
        nombreInput.addEventListener('input', updatePreview);
        porcentajeInput.addEventListener('input', updatePreview);
        descripcionInput.addEventListener('input', updatePreview);

        // Validación en tiempo real del porcentaje
        porcentajeInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
        });

        // Confirmación antes de enviar
        document.getElementById('descuentoForm').addEventListener('submit', function(e) {
            const nombre = nombreInput.value.trim();
            const porcentaje = porcentajeInput.value.trim();
            
            if (!nombre || !porcentaje) {
                e.preventDefault();
                alert('Por favor, complete todos los campos obligatorios.');
                return false;
            }

            // Confirmación opcional
            if (!confirm('¿Está seguro de que desea guardar este descuento?')) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush
@endsection