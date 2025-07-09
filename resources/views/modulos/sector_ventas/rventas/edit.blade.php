@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0 text-center">
                        <i class="fas fa-edit me-2"></i>Editar Venta #{{ $venta->id }}
                    </h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Atención!</strong> Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('rventas.update', $venta->id) }}" method="POST" enctype="multipart/form-data" id="ventaForm">
                        @csrf
                        @method('PUT')

                        <!-- Información del Cliente y Curso -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-users me-2 text-primary"></i>Información del Cliente y Curso
                                </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i>Cliente *
                                </label>
                                <select name="cliente_id" class="form-select" required>
                                    <option value="">Seleccionar cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }} {{ $cliente->apellido_paterno }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor selecciona un cliente.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-book me-1"></i>Curso *
                                </label>
                                <select name="curso_id" class="form-select" required>
                                    <option value="">Seleccionar curso</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ $venta->curso_id == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor selecciona un curso.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-tie me-1"></i>Vendedor *
                                </label>
                                <select name="vendedor_id" class="form-select" required>
                                    <option value="">Seleccionar vendedor</option>
                                    @foreach ($vendedores as $vendedor)
                                        <option value="{{ $vendedor->id }}" {{ $venta->vendedor_id == $vendedor->id ? 'selected' : '' }}>
                                            {{ $vendedor->nombre }} {{ $vendedor->apellido_paterno }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor selecciona un vendedor.</div>
                            </div>
                        </div>

                        <!-- Información Financiera -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>Información Financiera
                                </h5>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-1"></i>Costo del Curso (Bs) *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs</span>
                                    <input type="number" name="costo_curso" class="form-control" step="0.01" min="0" required 
                                           value="{{ $venta->costo_curso }}" id="costo_curso">
                                </div>
                                <div class="invalid-feedback">El costo debe ser mayor a 0.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-percentage me-1"></i>Descuento
                                </label>
                                <select name="descuento_id" class="form-select" id="descuento_id">
                                    <option value="">Sin descuento</option>
                                    @foreach ($descuentos as $descuento)
                                        <option value="{{ $descuento->id }}" data-porcentaje="{{ $descuento->porcentaje }}" 
                                                {{ $venta->descuento_id == $descuento->id ? 'selected' : '' }}>
                                            {{ $descuento->nombre }} ({{ $descuento->porcentaje }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calculator me-1"></i>Total a Pagar (Bs)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs</span>
                                    <input type="text" class="form-control bg-light" id="total_pagar" readonly>
                                </div>
                                <small class="text-muted">Se calcula automáticamente</small>
                            </div>
                        </div>

                        <!-- Estado y Forma de Pago -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-credit-card me-2 text-info"></i>Estado y Forma de Pago
                                </h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-info-circle me-1"></i>Estado de la Venta *
                                </label>
                                <select name="estado_venta" id="estado_venta" class="form-select" required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="Pagado" {{ $venta->estado_venta == 'Pagado' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Pagado
                                    </option>
                                    <option value="Plan de Pagos" {{ $venta->estado_venta == 'Plan de Pagos' ? 'selected' : '' }}>
                                        <i class="fas fa-calendar-alt"></i> Plan de Pagos
                                    </option>
                                    <option value="Anulado" {{ $venta->estado_venta == 'Anulado' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle"></i> Anulado
                                    </option>
                                </select>
                                <div class="invalid-feedback">Por favor selecciona un estado.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-check me-1"></i>Forma de Pago *
                                </label>
                                <select name="forma_pago" class="form-select" required>
                                    <option value="">Seleccionar forma de pago</option>
                                    <option value="Contado Oficina" {{ $venta->forma_pago == 'Contado Oficina' ? 'selected' : '' }}>
                                        💵 Contado Oficina
                                    </option>
                                    <option value="Transferencia Bancaria" {{ $venta->forma_pago == 'Transferencia Bancaria' ? 'selected' : '' }}>
                                        🏦 Transferencia Bancaria
                                    </option>
                                    <option value="Pago por QR" {{ $venta->forma_pago == 'Pago por QR' ? 'selected' : '' }}>
                                        📱 Pago por QR
                                    </option>
                                </select>
                                <div class="invalid-feedback">Por favor selecciona una forma de pago.</div>
                            </div>
                        </div>

                        <!-- Información de Pagos -->
                        <div class="row mb-4" id="pagos_section">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-receipt me-2 text-warning"></i>Información de Pagos
                                </h5>
                            </div>
                            <div class="col-md-6 mb-3" id="total_pagado_group" style="display: none;">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill me-1"></i>Monto Total Cancelado (Bs)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs</span>
                                    <input type="number" name="total_pagado" class="form-control" step="0.01" min="0" 
                                           value="{{ $venta->total_pagado }}" id="total_pagado">
                                </div>
                                <small class="text-muted">Monto total ya pagado</small>
                            </div>
                            <div class="col-md-6 mb-3" id="primer_pago_group" style="display: none;">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-coins me-1"></i>Primer Pago (Bs)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Bs</span>
                                    <input type="number" name="primer_pago" class="form-control" step="0.01" min="0" 
                                           value="{{ $venta->primer_pago }}" id="primer_pago">
                                </div>
                                <small class="text-muted">Primer pago del plan</small>
                            </div>
                        </div>

                        <!-- Información Bancaria -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-university me-2 text-secondary"></i>Información Bancaria
                                </h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-1"></i>Número de Transacción
                                </label>
                                <input type="text" name="numero_transaccion" class="form-control" 
                                       value="{{ old('numero_transaccion', $venta->numero_transaccion) }}" 
                                       placeholder="Ej: TXN123456789">
                                <small class="form-text text-muted">Número único de la transacción</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-building me-1"></i>Banco
                                </label>
                                <select name="banco" class="form-select">
                                    <option value="">Seleccionar banco</option>
                                    <option value="BCP" {{ $venta->banco == 'BCP' ? 'selected' : '' }}>🏦 BCP</option>
                                    <option value="Tigo Money" {{ $venta->banco == 'Tigo Money' ? 'selected' : '' }}>📱 Tigo Money</option>
                                    <option value="B U" {{ $venta->banco == 'B U' ? 'selected' : '' }}>🏛️ Banco Unión</option>
                                    <option value="Recibo" {{ $venta->banco == 'Recibo' ? 'selected' : '' }}>📄 Recibo</option>
                                    <option value="WesterUnion" {{ $venta->banco == 'WesterUnion' ? 'selected' : '' }}>💸 Western Union</option>
                                </select>
                            </div>
                        </div>

                        <!-- Comprobante -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-upload me-2 text-dark"></i>Comprobante de Pago
                                </h5>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-paperclip me-1"></i>Subir Comprobante
                                </label>
                                <input type="file" name="comprobante_pago" class="form-control" accept="application/pdf,image/*">
                                <small class="form-text text-muted">Formatos permitidos: PDF, JPG, PNG (Máx. 5MB)</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                @if ($venta->comprobante_pago)
                                    <label class="form-label fw-bold">Comprobante Actual</label>
                                    <div class="border rounded p-3 text-center">
                                        <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                        <br>
                                        <a href="{{ asset('storage/' . $venta->comprobante_pago) }}" target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Ver Comprobante
                                        </a>
                                    </div>
                                @else
                                    <div class="text-muted text-center pt-4">
                                        <i class="fas fa-file-times fa-2x mb-2"></i>
                                        <br>
                                        <small>Sin comprobante</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Los campos marcados con (*) son obligatorios
                                        </small>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('rventas.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-success" id="submitBtn">
                                            <i class="fas fa-save me-1"></i>Actualizar Venta
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const estadoVenta = document.getElementById('estado_venta');
    const totalPagadoGroup = document.getElementById('total_pagado_group');
    const primerPagoGroup = document.getElementById('primer_pago_group');
    const costoCurso = document.getElementById('costo_curso');
    const descuentoId = document.getElementById('descuento_id');
    const totalPagar = document.getElementById('total_pagar');
    const form = document.getElementById('ventaForm');
    const submitBtn = document.getElementById('submitBtn');

    // Función para mostrar/ocultar campos según el estado
    function togglePagos() {
        const estado = estadoVenta.value;
        
        if (estado === 'Pagado') {
            totalPagadoGroup.style.display = 'block';
            primerPagoGroup.style.display = 'none';
            totalPagadoGroup.classList.add('animate__fadeIn');
        } else if (estado === 'Plan de Pagos') {
            totalPagadoGroup.style.display = 'none';
            primerPagoGroup.style.display = 'block';
            primerPagoGroup.classList.add('animate__fadeIn');
        } else {
            totalPagadoGroup.style.display = 'none';
            primerPagoGroup.style.display = 'none';
        }
    }

    // Función para calcular el total a pagar
    function calcularTotal() {
        const costo = parseFloat(costoCurso.value) || 0;
        const descuentoOption = descuentoId.options[descuentoId.selectedIndex];
        const porcentajeDescuento = parseFloat(descuentoOption.getAttribute('data-porcentaje')) || 0;
        
        const descuento = (costo * porcentajeDescuento) / 100;
        const total = costo - descuento;
        
        totalPagar.value = total.toFixed(2);
        
        // Actualizar el color según el descuento
        if (porcentajeDescuento > 0) {
            totalPagar.classList.add('text-success', 'fw-bold');
        } else {
            totalPagar.classList.remove('text-success', 'fw-bold');
        }
    }

    // Validación en tiempo real
    function validarFormulario() {
        const inputs = form.querySelectorAll('input[required], select[required]');
        let esValido = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                esValido = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        });
        
        submitBtn.disabled = !esValido;
        
        if (esValido) {
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-success');
        } else {
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-secondary');
        }
    }

    // Animación de envío
    function animarEnvio() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Actualizando...';
        submitBtn.disabled = true;
    }

    // Event listeners
    estadoVenta.addEventListener('change', togglePagos);
    costoCurso.addEventListener('input', calcularTotal);
    descuentoId.addEventListener('change', calcularTotal);
    
    // Validación en tiempo real
    form.addEventListener('input', validarFormulario);
    form.addEventListener('change', validarFormulario);
    
    // Animación al enviar
    form.addEventListener('submit', animarEnvio);

    // Inicializar
    togglePagos();
    calcularTotal();
    validarFormulario();
});
</script>

<style>
.animate__fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-control.is-valid {
    border-color: #28a745;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.btn-group .btn {
    min-width: 120px;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-select option {
    padding: 8px 12px;
}

.border-bottom {
    border-bottom: 2px solid #e9ecef !important;
}

.text-muted {
    color: #6c757d !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

small.form-text {
    font-size: 0.875em;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1.25rem 1rem;
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection