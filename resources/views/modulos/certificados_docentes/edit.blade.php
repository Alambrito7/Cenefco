@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h2 class="mb-0 text-center">✏️ Editar Certificado Docente</h2>
                    <p class="mb-0 text-center small">Modificando certificado #{{ $certificado->id }}</p>
                </div>
                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">❌ Errores encontrados:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Mostrar mensaje de éxito -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('certificados_docentes.update', $certificado->id) }}" method="POST" id="editCertificadoForm">
                        @csrf
                        @method('PUT')

                        <!-- Sección: Información del Docente y Curso -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">
                                    👨‍🏫 Información del Docente y Curso
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="docente_id" class="form-label">👨‍🏫 Docente *</label>
                                <select name="docente_id" id="docente_id" class="form-select @error('docente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un docente</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" 
                                                {{ (old('docente_id', $certificado->docente_id) == $docente->id) ? 'selected' : '' }}>
                                            {{ $docente->nombre }} - {{ $docente->celular }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('docente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="curso_id" class="form-label">📘 Curso *</label>
                                <select name="curso_id" id="curso_id" class="form-select @error('curso_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" 
                                                {{ (old('curso_id', $certificado->curso_id) == $curso->id) ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección: Detalles del Curso -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">
                                    📅 Detalles del Curso
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="anio" class="form-label">📅 Año *</label>
                                <input type="number" 
                                       name="anio" 
                                       id="anio" 
                                       value="{{ old('anio', $certificado->anio) }}" 
                                       class="form-control @error('anio') is-invalid @enderror" 
                                       min="2000" 
                                       max="{{ date('Y') + 5 }}"
                                       required>
                                @error('anio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="mes_curso" class="form-label">🗓 Mes *</label>
                                <select name="mes_curso" id="mes_curso" class="form-select @error('mes_curso') is-invalid @enderror" required>
                                    <option value="">Seleccione un mes</option>
                                    @php
                                        $meses = [
                                            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                                        ];
                                    @endphp
                                    @foreach($meses as $mes)
                                        <option value="{{ $mes }}" 
                                                {{ (old('mes_curso', $certificado->mes_curso) == $mes) ? 'selected' : '' }}>
                                            {{ $mes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mes_curso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="ciudad" class="form-label">🏙 Ciudad *</label>
                                <input type="text" 
                                       name="ciudad" 
                                       id="ciudad" 
                                       value="{{ old('ciudad', $certificado->ciudad) }}" 
                                       class="form-control @error('ciudad') is-invalid @enderror" 
                                       placeholder="Ej: La Paz, Cochabamba"
                                       required>
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="estado_certificado" class="form-label">📌 Estado del Certificado *</label>
                                <select name="estado_certificado" id="estado_certificado" class="form-select @error('estado_certificado') is-invalid @enderror" required>
                                    <option value="Entregado" 
                                            {{ (old('estado_certificado', $certificado->estado_certificado) == 'Entregado') ? 'selected' : '' }}>
                                        ✅ Entregado
                                    </option>
                                    <option value="Pendiente" 
                                            {{ (old('estado_certificado', $certificado->estado_certificado) == 'Pendiente') ? 'selected' : '' }}>
                                        ⏳ Pendiente
                                    </option>
                                </select>
                                @error('estado_certificado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección: Fechas de Entrega -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">
                                    📆 Fechas de Entrega
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha_entrega_area_academica" class="form-label">📆 Fecha entrega área académica</label>
                                <input type="date" 
                                       name="fecha_entrega_area_academica" 
                                       id="fecha_entrega_area_academica" 
                                       value="{{ old('fecha_entrega_area_academica', $certificado->fecha_entrega_area_academica) }}" 
                                       class="form-control @error('fecha_entrega_area_academica') is-invalid @enderror">
                                @error('fecha_entrega_area_academica')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opcional - Fecha de entrega al área académica</small>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_envio_entrega" class="form-label">📤 Fecha de envío o entrega</label>
                                <input type="date" 
                                       name="fecha_envio_entrega" 
                                       id="fecha_envio_entrega" 
                                       value="{{ old('fecha_envio_entrega', $certificado->fecha_envio_entrega) }}" 
                                       class="form-control @error('fecha_envio_entrega') is-invalid @enderror">
                                @error('fecha_envio_entrega')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opcional - Fecha de envío o entrega final</small>
                            </div>
                        </div>

                        <!-- Sección: Información de Entrega -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">
                                    📦 Información de Entrega
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="numero_guia" class="form-label">📦 Número de guía</label>
                                <input type="text" 
                                       name="numero_guia" 
                                       id="numero_guia" 
                                       value="{{ old('numero_guia', $certificado->numero_guia) }}" 
                                       class="form-control @error('numero_guia') is-invalid @enderror"
                                       placeholder="Ej: GU123456789">
                                @error('numero_guia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Solo para envíos por courier</small>
                            </div>

                            <div class="col-md-6">
                                <label for="direccion_oficina" class="form-label">🏢 Dirección de oficina</label>
                                <input type="text" 
                                       name="direccion_oficina" 
                                       id="direccion_oficina" 
                                       value="{{ old('direccion_oficina', $certificado->direccion_oficina) }}" 
                                       class="form-control @error('direccion_oficina') is-invalid @enderror"
                                       placeholder="Ej: Av. Arce 2799, La Paz">
                                @error('direccion_oficina')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Solo para entregas en oficina</small>
                            </div>
                        </div>

                        <!-- Información de auditoría -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">📊 Información del Registro</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small><strong>Creado:</strong> {{ $certificado->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small><strong>Última actualización:</strong> {{ $certificado->updated_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('certificados_docentes.index') }}" class="btn btn-secondary">
                                        ↩ Volver al Listado
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-info me-2" onclick="resetForm()">
                                            🔄 Restaurar Valores
                                        </button>
                                        <button type="submit" class="btn btn-success" id="btnActualizar">
                                            💾 Actualizar Certificado
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
    const form = document.getElementById('editCertificadoForm');
    const btnActualizar = document.getElementById('btnActualizar');
    
    // Valores originales del certificado para la función de reset
    const valoresOriginales = {
        docente_id: '{{ $certificado->docente_id }}',
        curso_id: '{{ $certificado->curso_id }}',
        anio: '{{ $certificado->anio }}',
        mes_curso: '{{ $certificado->mes_curso }}',
        ciudad: '{{ $certificado->ciudad }}',
        estado_certificado: '{{ $certificado->estado_certificado }}',
        fecha_entrega_area_academica: '{{ $certificado->fecha_entrega_area_academica }}',
        fecha_envio_entrega: '{{ $certificado->fecha_envio_entrega }}',
        numero_guia: '{{ $certificado->numero_guia }}',
        direccion_oficina: '{{ $certificado->direccion_oficina }}'
    };

    // Función para detectar cambios en el formulario
    let formModificado = false;
    const campos = form.querySelectorAll('input, select');
    
    campos.forEach(campo => {
        campo.addEventListener('change', function() {
            formModificado = true;
            mostrarIndicadorCambios();
        });
    });

    // Función para mostrar indicador de cambios
    function mostrarIndicadorCambios() {
        if (formModificado) {
            btnActualizar.innerHTML = '💾 Actualizar Certificado *';
            btnActualizar.classList.add('btn-warning');
            btnActualizar.classList.remove('btn-success');
        }
    }

    // Función para restaurar valores originales
    window.resetForm = function() {
        if (confirm('¿Está seguro de que desea restaurar los valores originales? Se perderán todos los cambios no guardados.')) {
            Object.keys(valoresOriginales).forEach(campo => {
                const elemento = document.getElementById(campo);
                if (elemento) {
                    elemento.value = valoresOriginales[campo];
                }
            });
            
            formModificado = false;
            btnActualizar.innerHTML = '💾 Actualizar Certificado';
            btnActualizar.classList.remove('btn-warning');
            btnActualizar.classList.add('btn-success');
        }
    };

    // Validación antes de enviar el formulario
    form.addEventListener('submit', function(e) {
        // Validar que al menos un campo haya sido modificado
        if (!formModificado) {
            if (!confirm('No se detectaron cambios en el formulario. ¿Desea continuar de todas formas?')) {
                e.preventDefault();
                return false;
            }
        }

        // Validar coherencia de datos
        const estadoCertificado = document.getElementById('estado_certificado').value;
        const fechaEntregaAcademica = document.getElementById('fecha_entrega_area_academica').value;
        const numeroGuia = document.getElementById('numero_guia').value;
        const direccionOficina = document.getElementById('direccion_oficina').value;

        if (estadoCertificado === 'Entregado' && !fechaEntregaAcademica) {
            if (!confirm('El certificado está marcado como "Entregado" pero no tiene fecha de entrega al área académica. ¿Desea continuar?')) {
                e.preventDefault();
                return false;
            }
        }

        if (numeroGuia && direccionOficina) {
            alert('No puede tener tanto número de guía como dirección de oficina. Por favor, complete solo el campo correspondiente al tipo de entrega.');
            e.preventDefault();
            return false;
        }

        // Deshabilitar botón para evitar envíos múltiples
        btnActualizar.disabled = true;
        btnActualizar.innerHTML = '⏳ Actualizando...';
    });

    // Advertencia al salir sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (formModificado) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Mejorar la experiencia con los campos de fecha
    const fechaActual = new Date().toISOString().split('T')[0];
    const camposFecha = document.querySelectorAll('input[type="date"]');
    
    camposFecha.forEach(campo => {
        campo.addEventListener('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const hoy = new Date();
            
            if (fechaSeleccionada > hoy) {
                if (!confirm('La fecha seleccionada es futura. ¿Está seguro de que es correcta?')) {
                    this.value = fechaActual;
                }
            }
        });
    });

    // Funcionalidad de búsqueda en selects
    const selectDocente = document.getElementById('docente_id');
    const selectCurso = document.getElementById('curso_id');

    [selectDocente, selectCurso].forEach(select => {
        select.addEventListener('keyup', function(e) {
            const filter = e.target.value.toLowerCase();
            const options = select.querySelectorAll('option');
            
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? 'block' : 'none';
            });
        });
    });
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.text-secondary {
    color: #6c757d !important;
}

.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}

.invalid-feedback {
    display: block;
}

.alert {
    border-radius: 10px;
}

.form-text {
    font-size: 0.8rem;
    color: #6c757d;
}

.btn-warning {
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.alert-info {
    background-color: #e7f3ff;
    border-color: #b8daff;
    color: #0c5460;
}

.alert-info .alert-heading {
    color: #0c5460;
}

/* Estilos para campos modificados */
.form-control:not(:focus):valid {
    border-color: #28a745;
}

.form-select:not(:focus):valid {
    border-color: #28a745;
}

/* Mejoras responsivas */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }
    
    .d-flex.justify-content-between > div {
        text-align: center;
    }
}
</style>
@endsection