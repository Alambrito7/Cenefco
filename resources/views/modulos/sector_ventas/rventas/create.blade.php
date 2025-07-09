@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0 text-center">
                        <i class="fas fa-plus-circle me-2"></i>Registrar Nueva Venta
                    </h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Atención!</strong> Se encontraron los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('rventas.store') }}" method="POST" enctype="multipart/form-data" id="form-venta">
                        @csrf

                        <!-- Información del Cliente y Curso -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Información del Cliente y Curso
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user me-1"></i>Cliente <span class="text-danger">*</span>
                                        </label>
                                        <select name="cliente_id" id="cliente-select" class="form-select" required>
                                            <option value="">Seleccionar cliente</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->nombre }} {{ $cliente->apellido_paterno }} - {{ $cliente->celular }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor selecciona un cliente.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-book me-1"></i>Curso <span class="text-danger">*</span>
                                        </label>
                                        <select name="curso_id" class="form-select" required>
                                            <option value="">Seleccionar curso</option>
                                            @foreach ($cursos as $curso)
                                                <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                                    {{ $curso->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor selecciona un curso.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user-tie me-1"></i>Vendedor <span class="text-danger">*</span>
                                        </label>
                                        <select name="vendedor_id" class="form-select" required>
                                            <option value="">Seleccionar vendedor</option>
                                            @foreach ($vendedores as $vendedor)
                                                <option value="{{ $vendedor->id }}" {{ old('vendedor_id') == $vendedor->id ? 'selected' : '' }}>
                                                    {{ $vendedor->nombre }} {{ $vendedor->apellido_paterno }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor selecciona un vendedor.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de la Venta -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>Información de la Venta
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-dollar-sign me-1"></i>Costo del curso (Bs) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="costo_curso" id="costo_curso" class="form-control" 
                                               step="0.01" min="0" value="{{ old('costo_curso') }}" required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa el costo del curso.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-info-circle me-1"></i>Estado de la venta <span class="text-danger">*</span>
                                        </label>
                                        <select name="estado_venta" id="estado_venta" class="form-select" required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="Pagado" {{ old('estado_venta') == 'Pagado' ? 'selected' : '' }}>
                                                <i class="fas fa-check-circle"></i> Pagado
                                            </option>
                                            <option value="Plan de Pagos" {{ old('estado_venta') == 'Plan de Pagos' ? 'selected' : '' }}>
                                                <i class="fas fa-calendar-alt"></i> Plan de Pagos
                                            </option>
                                            <option value="Anulado" {{ old('estado_venta') == 'Anulado' ? 'selected' : '' }}>
                                                <i class="fas fa-times-circle"></i> Anulado
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor selecciona un estado.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-credit-card me-1"></i>Forma de pago <span class="text-danger">*</span>
                                        </label>
                                        <select name="forma_pago" class="form-select" required>
                                            <option value="">Seleccionar forma</option>
                                            <option value="Contado Oficina" {{ old('forma_pago') == 'Contado Oficina' ? 'selected' : '' }}>
                                                Contado Oficina
                                            </option>
                                            <option value="Transferencia Bancaria" {{ old('forma_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>
                                                Transferencia Bancaria
                                            </option>
                                            <option value="Pago por QR" {{ old('forma_pago') == 'Pago por QR' ? 'selected' : '' }}>
                                                Pago por QR
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor selecciona una forma de pago.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-percent me-1"></i>Descuento
                                        </label>
                                        <select name="descuento_id" id="descuento_id" class="form-select">
                                            <option value="" data-porcentaje="0">Sin descuento</option>
                                            @foreach ($descuentos as $descuento)
                                                <option value="{{ $descuento->id }}" 
                                                        data-porcentaje="{{ $descuento->porcentaje }}"
                                                        {{ old('descuento_id') == $descuento->id ? 'selected' : '' }}>
                                                    {{ $descuento->nombre }} ({{ $descuento->porcentaje }}%)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-hashtag me-1"></i>Número de Transacción
                                        </label>
                                        <input type="text" name="numero_transaccion" class="form-control" 
                                               value="{{ old('numero_transaccion') }}" 
                                               placeholder="Ingrese el número de transacción">
                                        <small class="form-text text-muted">
                                            Número único de la transacción
                                        </small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-university me-1"></i>Banco
                                        </label>
                                        <select name="banco" class="form-select">
                                            <option value="">Seleccionar banco</option>
                                            <option value="BCP" {{ old('banco') == 'BCP' ? 'selected' : '' }}>BCP</option>
                                            <option value="Tigo Money" {{ old('banco') == 'Tigo Money' ? 'selected' : '' }}>Tigo Money</option>
                                            <option value="B U" {{ old('banco') == 'B U' ? 'selected' : '' }}>B U</option>
                                            <option value="Recibo" {{ old('banco') == 'Recibo' ? 'selected' : '' }}>Recibo</option>
                                            <option value="WesterUnion" {{ old('banco') == 'WesterUnion' ? 'selected' : '' }}>WesterUnion</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-file-upload me-1"></i>Comprobante de pago
                                        </label>
                                        <input type="file" name="comprobante_pago" class="form-control" 
                                               accept="image/*,application/pdf">
                                        <small class="form-text text-muted">
                                            Formatos permitidos: PDF, JPG, PNG (máximo 2MB)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Pagos -->
                        <div class="card mb-4" id="grupo_pago" style="display: none;">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-money-bill-wave me-2"></i>Información de Pagos
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold" id="label_pago">
                                            <i class="fas fa-hand-holding-usd me-1"></i>Monto Cancelado
                                        </label>
                                        <input type="number" step="0.01" min="0" name="primer_pago" 
                                               id="primer_pago" class="form-control" 
                                               value="{{ old('primer_pago') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-balance-scale me-1"></i>Saldo de Pago
                                        </label>
                                        <input type="text" class="form-control" id="saldo_pago" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calculator me-1"></i>Costo Final
                                        </label>
                                        <input type="text" class="form-control" id="costo_final" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de la Venta -->
                        <div class="card mb-4" id="resumen_venta" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Resumen de la Venta
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="border rounded p-3">
                                            <h6 class="text-muted">Costo Original</h6>
                                            <h4 id="costo_original_display" class="text-primary">0.00 Bs</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3">
                                            <h6 class="text-muted">Descuento</h6>
                                            <h4 id="descuento_display" class="text-warning">0.00 Bs</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3">
                                            <h6 class="text-muted">Total a Pagar</h6>
                                            <h4 id="total_pagar_display" class="text-success">0.00 Bs</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3">
                                            <h6 class="text-muted">Saldo Pendiente</h6>
                                            <h4 id="saldo_pendiente_display" class="text-danger">0.00 Bs</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rventas.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>Guardar Venta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos adicionales --}}
<style>
.select2-container--default .select2-selection--single {
    height: calc(2.375rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    right: 0.75rem;
    top: 0;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: normal;
}

.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.form-label {
    font-weight: 500;
}

.text-danger {
    color: #dc3545 !important;
}

.btn-lg {
    padding: 0.5rem 1.5rem;
    font-size: 1.1rem;
}

.alert {
    border-radius: 8px;
}

.border {
    border: 1px solid #dee2e6 !important;
}

.rounded {
    border-radius: 8px !important;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.4rem 1rem;
        font-size: 1rem;
    }
}
</style>

{{-- Scripts --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Select2
    $('#cliente-select').select2({
        placeholder: "Buscar cliente...",
        width: '100%',
        allowClear: true
    });

    // Elementos del DOM
    const estadoVenta = document.getElementById('estado_venta');
    const descuentoSelect = document.getElementById('descuento_id');
    const costoCurso = document.getElementById('costo_curso');
    const primerPago = document.getElementById('primer_pago');
    const saldoPago = document.getElementById('saldo_pago');
    const costoFinal = document.getElementById('costo_final');
    const grupoPago = document.getElementById('grupo_pago');
    const resumenVenta = document.getElementById('resumen_venta');
    const labelPago = document.getElementById('label_pago');
    
    // Elementos del resumen
    const costoOriginalDisplay = document.getElementById('costo_original_display');
    const descuentoDisplay = document.getElementById('descuento_display');
    const totalPagarDisplay = document.getElementById('total_pagar_display');
    const saldoPendienteDisplay = document.getElementById('saldo_pendiente_display');

    // Función para actualizar todos los campos y cálculos
    function actualizarCampos() {
        const estado = estadoVenta.value;
        const descuento = parseFloat(descuentoSelect.selectedOptions[0]?.dataset.porcentaje || 0);
        const costo = parseFloat(costoCurso.value) || 0;
        const pago = parseFloat(primerPago.value) || 0;

        // Cálculos
        const descuentoMonto = Math.round(costo * (descuento / 100));
        const costoConDescuento = costo - descuentoMonto;
        let saldo = 0;

        // Actualizar resumen
        if (costo > 0) {
            costoOriginalDisplay.textContent = `${costo.toFixed(2)} Bs`;
            descuentoDisplay.textContent = `${descuentoMonto.toFixed(2)} Bs`;
            totalPagarDisplay.textContent = `${costoConDescuento.toFixed(2)} Bs`;
            resumenVenta.style.display = 'block';
        } else {
            resumenVenta.style.display = 'none';
        }

        // Mostrar/ocultar campos según el estado
        if (estado === "Pagado") {
            grupoPago.style.display = 'block';
            labelPago.innerHTML = '<i class="fas fa-hand-holding-usd me-1"></i>Monto Cancelado';
            saldo = costoConDescuento - pago;
            saldoPendienteDisplay.textContent = `${saldo.toFixed(2)} Bs`;
        } else if (estado === "Plan de Pagos") {
            grupoPago.style.display = 'block';
            labelPago.innerHTML = '<i class="fas fa-credit-card me-1"></i>Primer Pago';
            saldo = costoConDescuento - pago;
            saldoPendienteDisplay.textContent = `${saldo.toFixed(2)} Bs`;
        } else {
            grupoPago.style.display = 'none';
            saldoPendienteDisplay.textContent = '0.00 Bs';
        }

        // Actualizar campos de pago
        if (grupoPago.style.display === 'block') {
            saldoPago.value = saldo.toFixed(2);
            costoFinal.value = costoConDescuento.toFixed(2);
        } else {
            saldoPago.value = '';
            costoFinal.value = '';
        }
    }

    // Validación del formulario
    function validarFormulario() {
        const form = document.getElementById('form-venta');
        const inputs = form.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        });

        return isValid;
    }

    // Event listeners
    estadoVenta.addEventListener('change', actualizarCampos);
    descuentoSelect.addEventListener('change', actualizarCampos);
    costoCurso.addEventListener('input', actualizarCampos);
    primerPago.addEventListener('input', actualizarCampos);

    // Validación en tiempo real
    document.querySelectorAll('[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    });

    // Validación al enviar el formulario
    document.getElementById('form-venta').addEventListener('submit', function(e) {
        if (!validarFormulario()) {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios.');
        }
    });

    // Inicializar cálculos si hay valores previos
    actualizarCampos();
});
</script>
@endsection