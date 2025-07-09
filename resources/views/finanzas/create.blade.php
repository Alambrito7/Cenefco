@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-plus-circle me-3 fa-lg"></i>
                        <h2 class="mb-0">Registrar Nueva Transacción</h2>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Atención!</strong> Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('finanzas.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <!-- Sección 1: Información del Curso y Venta -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Información del Curso
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <label for="curso_id" class="form-label fw-bold">
                                    <i class="fas fa-book me-2 text-primary"></i>
                                    Curso <span class="text-danger">*</span>
                                </label>
                                <select name="curso_id" id="curso_id" class="form-select form-select-lg" required>
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Seleccione el curso para ver las ventas disponibles
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="venta_id" class="form-label fw-bold">
                                    <i class="fas fa-shopping-cart me-2 text-success"></i>
                                    Venta <span class="text-danger">*</span>
                                </label>
                                <select name="venta_id" id="venta_id" class="form-select form-select-lg" required disabled>
                                    <option value="">Primero seleccione un curso</option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="venta-info">Información de la venta aparecerá aquí</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: Detalles de la Transacción -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Detalles de la Transacción
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <label for="monto" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>
                                    Monto <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs.</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="monto" 
                                           id="monto"
                                           class="form-control form-control-lg" 
                                           placeholder="0.00"
                                           value="{{ old('monto') }}"
                                           required>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ingrese el monto de la transacción
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="banco" class="form-label fw-bold">
                                    <i class="fas fa-university me-2 text-info"></i>
                                    Banco/Método <span class="text-danger">*</span>
                                </label>
                                <select name="banco" id="banco" class="form-select form-select-lg" required>
                                    <option value="">Seleccione método de pago</option>
                                    <option value="BCP" {{ old('banco') == 'BCP' ? 'selected' : '' }}>
                                        <i class="fas fa-building"></i> BCP
                                    </option>
                                    <option value="Tigo Money" {{ old('banco') == 'Tigo Money' ? 'selected' : '' }}>
                                        <i class="fas fa-mobile"></i> Tigo Money
                                    </option>
                                    <option value="B U" {{ old('banco') == 'B U' ? 'selected' : '' }}>
                                        <i class="fas fa-building"></i> Banco Unión
                                    </option>
                                    <option value="Recibo" {{ old('banco') == 'Recibo' ? 'selected' : '' }}>
                                        <i class="fas fa-receipt"></i> Recibo
                                    </option>
                                    <option value="WesterUnion" {{ old('banco') == 'WesterUnion' ? 'selected' : '' }}>
                                        <i class="fas fa-globe"></i> Western Union
                                    </option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Método de pago utilizado
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="nro_transaccion" class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-2 text-warning"></i>
                                    No. de Transacción <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="nro_transaccion" 
                                       id="nro_transaccion"
                                       class="form-control form-control-lg" 
                                       placeholder="Ej: TXN123456789"
                                       value="{{ old('nro_transaccion') }}"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Número de referencia de la transacción
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Fecha y Hora -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Fecha y Hora de la Transacción
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_hora" class="form-label fw-bold">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    Fecha y Hora <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       name="fecha_hora" 
                                       id="fecha_hora"
                                       class="form-control form-control-lg" 
                                       value="{{ old('fecha_hora', date('Y-m-d\TH:i')) }}"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Fecha y hora cuando se realizó la transacción
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Vista previa</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-check fa-2x text-success me-3"></i>
                                            <div>
                                                <div class="fw-bold" id="fecha-preview">--/--/----</div>
                                                <div class="text-muted" id="hora-preview">--:--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de la transacción -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <h6 class="mb-0 text-primary">
                                            <i class="fas fa-eye me-2"></i>
                                            Resumen de la Transacción
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <strong>Curso:</strong> 
                                                    <span id="resumen-curso" class="text-muted">No seleccionado</span>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Cliente:</strong> 
                                                    <span id="resumen-cliente" class="text-muted">No seleccionado</span>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Venta:</strong> 
                                                    <span id="resumen-venta" class="text-muted">No seleccionado</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <strong>Monto:</strong> 
                                                    <span id="resumen-monto" class="text-muted">Bs. 0.00</span>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Método:</strong> 
                                                    <span id="resumen-banco" class="text-muted">No seleccionado</span>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>No. Transacción:</strong> 
                                                    <span id="resumen-nro" class="text-muted">No ingresado</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('finanzas.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Volver
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-outline-warning btn-lg me-2">
                                            <i class="fas fa-eraser me-2"></i>
                                            Limpiar
                                        </button>
                                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Transacción
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

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>
                    Confirmar Transacción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas guardar esta transacción?</p>
                <div class="bg-light p-3 rounded">
                    <div id="modal-resumen"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmSave">
                    <i class="fas fa-save me-2"></i>
                    Confirmar y Guardar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cursoSelect = document.getElementById('curso_id');
    const ventaSelect = document.getElementById('venta_id');
    const montoInput = document.getElementById('monto');
    const bancoSelect = document.getElementById('banco');
    const nroTransaccionInput = document.getElementById('nro_transaccion');
    const fechaHoraInput = document.getElementById('fecha_hora');
    const form = document.getElementById('transactionForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Actualizar vista previa de fecha
    fechaHoraInput.addEventListener('change', function() {
        const fechaHora = new Date(this.value);
        const fechaPreview = document.getElementById('fecha-preview');
        const horaPreview = document.getElementById('hora-preview');
        
        if (this.value) {
            fechaPreview.textContent = fechaHora.toLocaleDateString('es-BO');
            horaPreview.textContent = fechaHora.toLocaleTimeString('es-BO', {hour: '2-digit', minute:'2-digit'});
        } else {
            fechaPreview.textContent = '--/--/----';
            horaPreview.textContent = '--:--';
        }
    });
    
    // Actualizar resumen en tiempo real
    function actualizarResumen() {
        const cursoTexto = cursoSelect.options[cursoSelect.selectedIndex].text;
        const ventaTexto = ventaSelect.options[ventaSelect.selectedIndex].text;
        const monto = montoInput.value || '0.00';
        const banco = bancoSelect.options[bancoSelect.selectedIndex].text;
        const nroTransaccion = nroTransaccionInput.value || 'No ingresado';
        
        document.getElementById('resumen-curso').textContent = cursoSelect.value ? cursoTexto : 'No seleccionado';
        document.getElementById('resumen-venta').textContent = ventaSelect.value ? ventaTexto : 'No seleccionado';
        document.getElementById('resumen-monto').textContent = `Bs. ${parseFloat(monto).toFixed(2)}`;
        document.getElementById('resumen-banco').textContent = bancoSelect.value ? banco : 'No seleccionado';
        document.getElementById('resumen-nro').textContent = nroTransaccion;
    }
    
    // Event listeners para actualizar resumen
    [cursoSelect, ventaSelect, montoInput, bancoSelect, nroTransaccionInput].forEach(element => {
        element.addEventListener('change', actualizarResumen);
        element.addEventListener('input', actualizarResumen);
    });
    
    // Manejo del select de cursos
    cursoSelect.addEventListener('change', function() {
        const cursoId = this.value;
        
        // Limpiar y deshabilitar el select de ventas
        ventaSelect.innerHTML = '<option value="">Cargando...</option>';
        ventaSelect.disabled = true;
        
        // Mostrar loading
        const ventaInfo = document.getElementById('venta-info');
        ventaInfo.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Cargando ventas...';
        
        if (cursoId) {
            // Hacer petición AJAX para obtener las ventas del curso seleccionado
            fetch(`{{ route('finanzas.ventas-por-curso') }}?curso_id=${cursoId}`)
                .then(response => response.json())
                .then(data => {
                    ventaSelect.innerHTML = '<option value="">Seleccione una venta</option>';
                    
                    if (data.length > 0) {
                        data.forEach(venta => {
                            const option = document.createElement('option');
                            option.value = venta.id;
                            option.textContent = venta.texto;
                            option.dataset.cliente = venta.cliente;
                            ventaSelect.appendChild(option);
                        });
                        ventaSelect.disabled = false;
                        ventaInfo.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Ventas cargadas correctamente';
                    } else {
                        ventaSelect.innerHTML = '<option value="">No hay ventas disponibles para este curso</option>';
                        ventaInfo.innerHTML = '<i class="fas fa-exclamation-triangle text-warning me-1"></i> No hay ventas disponibles para este curso';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    ventaSelect.innerHTML = '<option value="">Error al cargar ventas</option>';
                    ventaInfo.innerHTML = '<i class="fas fa-exclamation-circle text-danger me-1"></i> Error al cargar ventas';
                });
        } else {
            ventaSelect.innerHTML = '<option value="">Primero seleccione un curso</option>';
            ventaInfo.innerHTML = '<i class="fas fa-info-circle me-1"></i> Información de la venta aparecerá aquí';
        }
        
        actualizarResumen();
    });
    
    // Actualizar información del cliente cuando se selecciona una venta
    ventaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const ventaInfo = document.getElementById('venta-info');
        
        if (this.value && selectedOption.dataset.cliente) {
            ventaInfo.innerHTML = `<i class="fas fa-user text-info me-1"></i> Cliente: ${selectedOption.dataset.cliente}`;
            document.getElementById('resumen-cliente').textContent = selectedOption.dataset.cliente;
        } else {
            ventaInfo.innerHTML = '<i class="fas fa-info-circle me-1"></i> Información de la venta aparecerá aquí';
            document.getElementById('resumen-cliente').textContent = 'No seleccionado';
        }
        
        actualizarResumen();
    });
    
    // Formatear el monto mientras se escribe
    montoInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value)) {
            document.getElementById('resumen-monto').textContent = `Bs. ${value.toFixed(2)}`;
        } else {
            document.getElementById('resumen-monto').textContent = 'Bs. 0.00';
        }
    });
    
    // Validación del formulario antes de enviar
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (isValid) {
            // Mostrar modal de confirmación
            const modalResumen = document.getElementById('modal-resumen');
            modalResumen.innerHTML = `
                <div class="row">
                    <div class="col-6"><strong>Curso:</strong></div>
                    <div class="col-6">${cursoSelect.options[cursoSelect.selectedIndex].text}</div>
                    <div class="col-6"><strong>Cliente:</strong></div>
                    <div class="col-6">${ventaSelect.options[ventaSelect.selectedIndex].dataset.cliente || 'N/A'}</div>
                    <div class="col-6"><strong>Monto:</strong></div>
                    <div class="col-6">Bs. ${parseFloat(montoInput.value).toFixed(2)}</div>
                    <div class="col-6"><strong>Método:</strong></div>
                    <div class="col-6">${bancoSelect.options[bancoSelect.selectedIndex].text}</div>
                    <div class="col-6"><strong>No. Transacción:</strong></div>
                    <div class="col-6">${nroTransaccionInput.value}</div>
                </div>
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        } else {
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });
    
    // Confirmar y enviar formulario
    document.getElementById('confirmSave').addEventListener('click', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Guardando...';
        form.submit();
    });
    
    // Inicializar vista previa de fecha
    const event = new Event('change');
    fechaHoraInput.dispatchEvent(event);
});
</script>
@endpush

<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
}

.form-control-lg,
.form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1.125rem;
}

.input-group-text {
    font-weight: 600;
}

.form-text {
    font-size: 0.875rem;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.bg-opacity-10 {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection