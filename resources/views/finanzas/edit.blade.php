@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-center">✏️ Editar Transacción</h3>
                </div>
                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>❌ Por favor corrige los siguientes errores:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('finanzas.update', $finanza->id) }}" method="POST" id="editTransactionForm">
                        @csrf
                        @method('PUT')

                        <!-- Información del curso y venta -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="curso_id" class="form-label fw-bold">📘 Curso *</label>
                                <select name="curso_id" id="curso_id" class="form-select @error('curso_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ old('curso_id', $finanza->curso_id) == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="venta_id" class="form-label fw-bold">📱 Venta *</label>
                                <select name="venta_id" id="venta_id" class="form-select @error('venta_id') is-invalid @enderror" required>
                                    @foreach($ventas as $venta)
                                        <option value="{{ $venta->id }}" {{ old('venta_id', $finanza->venta_id) == $venta->id ? 'selected' : '' }}>
                                            {{ $venta->cliente->nombre_completo }} - {{ $venta->curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('venta_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <div id="loading-ventas" class="d-none">
                                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                        Cargando ventas...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información financiera -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="monto" class="form-label fw-bold">💰 Monto *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs.</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="monto" 
                                           id="monto"
                                           value="{{ old('monto', $finanza->monto) }}" 
                                           class="form-control @error('monto') is-invalid @enderror" 
                                           required
                                           min="0.01"
                                           placeholder="0.00">
                                </div>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="banco" class="form-label fw-bold">🏦 Banco *</label>
                                <select name="banco" id="banco" class="form-select @error('banco') is-invalid @enderror" required>
                                    <option value="">Seleccione un banco</option>
                                    @foreach(['BCP', 'Tigo Money', 'Banco Union', 'Recibo', 'Western Union'] as $opcion)
                                        <option value="{{ $opcion }}" {{ old('banco', $finanza->banco) == $opcion ? 'selected' : '' }}>
                                            {{ $opcion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('banco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="nro_transaccion" class="form-label fw-bold">🔢 Nº de Transacción *</label>
                                <input type="text" 
                                       name="nro_transaccion" 
                                       id="nro_transaccion"
                                       value="{{ old('nro_transaccion', $finanza->nro_transaccion) }}" 
                                       class="form-control @error('nro_transaccion') is-invalid @enderror" 
                                       required
                                       placeholder="Ingrese el número de transacción">
                                @error('nro_transaccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha y hora -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="fecha_hora" class="form-label fw-bold">📅 Fecha y Hora *</label>
                                <input type="datetime-local" 
                                       name="fecha_hora" 
                                       id="fecha_hora"
                                       value="{{ old('fecha_hora', \Carbon\Carbon::parse($finanza->fecha_hora)->format('Y-m-d\TH:i')) }}" 
                                       class="form-control @error('fecha_hora') is-invalid @enderror" 
                                       required>
                                @error('fecha_hora')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">📊 Información Adicional</label>
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        <small class="text-muted">
                                            <strong>ID Transacción:</strong> #{{ $finanza->id }}<br>
                                            <strong>Creado:</strong> {{ $finanza->created_at->format('d/m/Y H:i') }}<br>
                                            <strong>Última modificación:</strong> {{ $finanza->updated_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('finanzas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> ↩️ Volver
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" onclick="resetForm()">
                                            🔄 Restablecer
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            💾 Actualizar Transacción
                                        </button>
                                    </div>
                                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const cursoSelect = document.getElementById('curso_id');
    const ventaSelect = document.getElementById('venta_id');
    const loadingDiv = document.getElementById('loading-ventas');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('editTransactionForm');

    // Función para cargar ventas por curso
    function cargarVentas(cursoId) {
        if (!cursoId) {
            ventaSelect.innerHTML = '<option value="">Primero seleccione un curso</option>';
            ventaSelect.disabled = true;
            return;
        }

        // Mostrar loading
        loadingDiv.classList.remove('d-none');
        ventaSelect.disabled = true;
        ventaSelect.innerHTML = '<option value="">Cargando...</option>';

        // Hacer petición AJAX
        fetch(`{{ route('finanzas.ventas-por-curso') }}?curso_id=${cursoId}&exclude_finanza_id={{ $finanza->id }}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                ventaSelect.innerHTML = '<option value="">Seleccione una venta</option>';
                
                if (data.length > 0) {
                    data.forEach(venta => {
                        const option = document.createElement('option');
                        option.value = venta.id;
                        option.textContent = venta.texto;
                        
                        // Mantener la selección actual si coincide
                        if (venta.id == {{ $finanza->venta_id }}) {
                            option.selected = true;
                        }
                        ventaSelect.appendChild(option);
                    });
                    ventaSelect.disabled = false;
                } else {
                    ventaSelect.innerHTML = '<option value="">No hay ventas disponibles para este curso</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                ventaSelect.innerHTML = '<option value="">Error al cargar ventas</option>';
                
                // Mostrar mensaje de error al usuario
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
                alertDiv.innerHTML = `
                    <strong>⚠️ Advertencia:</strong> No se pudieron cargar las ventas. Por favor, recargue la página.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                ventaSelect.parentNode.appendChild(alertDiv);
            })
            .finally(() => {
                loadingDiv.classList.add('d-none');
            });
    }

    // Event listener para cambio de curso
    cursoSelect.addEventListener('change', function() {
        cargarVentas(this.value);
    });

    // Función para restablecer el formulario
    window.resetForm = function() {
        if (confirm('¿Está seguro de que desea restablecer todos los campos?')) {
            form.reset();
            // Recargar ventas del curso original
            cargarVentas('{{ $finanza->curso_id }}');
        }
    };

    // Validación del formulario antes de enviar
    form.addEventListener('submit', function(e) {
        let valid = true;
        const requiredFields = ['curso_id', 'venta_id', 'monto', 'banco', 'nro_transaccion', 'fecha_hora'];
        
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('⚠️ Por favor complete todos los campos obligatorios');
            return false;
        }

        // Deshabilitar botón para evitar doble envío
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Actualizando...';
    });

    // Validación en tiempo real del monto
    document.getElementById('monto').addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (value <= 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Formatear número de transacción (solo alfanumérico)
    document.getElementById('nro_transaccion').addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div {
        text-align: center;
    }
}
</style>
@endpush
@endsection