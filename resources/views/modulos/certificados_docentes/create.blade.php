@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0 text-center">📄 Registrar Certificado Docente</h2>
                </div>
                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
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
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('certificadosdocentes.store') }}" method="POST" id="certificadoForm">
                        @csrf

                        <!-- Sección: Información del Docente y Curso -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">👨‍🏫 Información del Docente y Curso</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="docente_id" class="form-label">👨‍🏫 Docente *</label>
                                <select name="docente_id" id="docente_id" class="form-select @error('docente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un docente</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->nombre }} - {{ $docente->telefono }}
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
                                        <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
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
                                <h5 class="text-secondary border-bottom pb-2">📅 Detalles del Curso</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="anio" class="form-label">📅 Año *</label>
                                <input type="number" 
                                       name="anio" 
                                       id="anio" 
                                       class="form-control @error('anio') is-invalid @enderror" 
                                       value="{{ old('anio', date('Y')) }}" 
                                       min="2000" 
                                       max="{{ date('Y') + 5 }}"
                                       required>
                                @error('anio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="mes_curso" class="form-label">📅 Mes del Curso *</label>
                                <select name="mes_curso" id="mes_curso" class="form-select @error('mes_curso') is-invalid @enderror" required>
                                    <option value="">Seleccione un mes</option>
                                    <option value="Enero" {{ old('mes_curso') == 'Enero' ? 'selected' : '' }}>Enero</option>
                                    <option value="Febrero" {{ old('mes_curso') == 'Febrero' ? 'selected' : '' }}>Febrero</option>
                                    <option value="Marzo" {{ old('mes_curso') == 'Marzo' ? 'selected' : '' }}>Marzo</option>
                                    <option value="Abril" {{ old('mes_curso') == 'Abril' ? 'selected' : '' }}>Abril</option>
                                    <option value="Mayo" {{ old('mes_curso') == 'Mayo' ? 'selected' : '' }}>Mayo</option>
                                    <option value="Junio" {{ old('mes_curso') == 'Junio' ? 'selected' : '' }}>Junio</option>
                                    <option value="Julio" {{ old('mes_curso') == 'Julio' ? 'selected' : '' }}>Julio</option>
                                    <option value="Agosto" {{ old('mes_curso') == 'Agosto' ? 'selected' : '' }}>Agosto</option>
                                    <option value="Septiembre" {{ old('mes_curso') == 'Septiembre' ? 'selected' : '' }}>Septiembre</option>
                                    <option value="Octubre" {{ old('mes_curso') == 'Octubre' ? 'selected' : '' }}>Octubre</option>
                                    <option value="Noviembre" {{ old('mes_curso') == 'Noviembre' ? 'selected' : '' }}>Noviembre</option>
                                    <option value="Diciembre" {{ old('mes_curso') == 'Diciembre' ? 'selected' : '' }}>Diciembre</option>
                                </select>
                                @error('mes_curso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="ciudad" class="form-label">🏙️ Ciudad *</label>
                                <input type="text" 
                                       name="ciudad" 
                                       id="ciudad" 
                                       class="form-control @error('ciudad') is-invalid @enderror" 
                                       value="{{ old('ciudad') }}" 
                                       placeholder="Ej: La Paz, Cochabamba, Santa Cruz"
                                       required>
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección: Estado del Certificado -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">📦 Estado del Certificado</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="estado_certificado" class="form-label">📦 Estado del Certificado *</label>
                                <select name="estado_certificado" id="estado_certificado" class="form-select @error('estado_certificado') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Entregado" {{ old('estado_certificado') == 'Entregado' ? 'selected' : '' }}>
                                        ✅ Entregado
                                    </option>
                                    <option value="Pendiente" {{ old('estado_certificado') == 'Pendiente' ? 'selected' : '' }}>
                                        ⏳ Pendiente
                                    </option>
                                </select>
                                @error('estado_certificado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_entrega_area_academica" class="form-label">📆 Fecha entrega área académica</label>
                                <input type="date" 
                                       name="fecha_entrega_area_academica" 
                                       id="fecha_entrega_area_academica" 
                                       class="form-control @error('fecha_entrega_area_academica') is-invalid @enderror"
                                       value="{{ old('fecha_entrega_area_academica') }}">
                                @error('fecha_entrega_area_academica')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opcional - Solo si ya fue entregado</small>
                            </div>
                        </div>

                        <!-- Sección: Tipo de Entrega -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-secondary border-bottom pb-2">📤 Información de Entrega</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_entrega" class="form-label">📤 Tipo de entrega *</label>
                                <select name="tipo_entrega" id="tipo_entrega" class="form-select @error('tipo_entrega') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    <option value="envio" {{ old('tipo_entrega') == 'envio' ? 'selected' : '' }}>
                                        🚚 Envío por courier
                                    </option>
                                    <option value="entregado" {{ old('tipo_entrega') == 'entregado' ? 'selected' : '' }}>
                                        🏢 Entregado en oficina
                                    </option>
                                </select>
                                @error('tipo_entrega')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="contenedor_dinamico">
                                <!-- Contenido dinámico basado en tipo de entrega -->
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('certificadosdocentes.index') }}" class="btn btn-secondary">
                                        ← Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                                        💾 Guardar Certificado
                                    </button>
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
    const tipoEntrega = document.getElementById('tipo_entrega');
    const contenedor = document.getElementById('contenedor_dinamico');
    const form = document.getElementById('certificadoForm');
    const btnGuardar = document.getElementById('btnGuardar');

    // Función para obtener la fecha actual en formato YYYY-MM-DD
    function getFechaActual() {
        return new Date().toISOString().split('T')[0];
    }

    // Función para manejar el cambio en tipo de entrega
    function actualizarContenedorDinamico() {
        contenedor.innerHTML = ''; // Limpiar contenedor

        const valorSeleccionado = tipoEntrega.value;
        const fechaHoy = getFechaActual();

        if (valorSeleccionado === 'envio') {
            contenedor.innerHTML = `
                <label for="numero_guia" class="form-label">📦 N° de Guía *</label>
                <input type="text" 
                       name="numero_guia" 
                       id="numero_guia" 
                       class="form-control" 
                       value="{{ old('numero_guia') }}"
                       placeholder="Ej: GU123456789"
                       required>
                <input type="hidden" name="fecha_envio_entregada" value="${fechaHoy}">
                <small class="form-text text-muted">Ingrese el número de guía del courier</small>
            `;
        } else if (valorSeleccionado === 'entregado') {
            contenedor.innerHTML = `
                <label for="direccion_oficina" class="form-label">📍 Dirección Oficina *</label>
                <input type="text" 
                       name="direccion_oficina" 
                       id="direccion_oficina" 
                       class="form-control" 
                       value="{{ old('direccion_oficina') }}"
                       placeholder="Ej: Av. Arce 2799, La Paz"
                       required>
                <input type="hidden" name="fecha_envio_entregada" value="${fechaHoy}">
                <small class="form-text text-muted">Dirección donde se entregó el certificado</small>
            `;
        }
    }

    // Event listener para cambio en tipo de entrega
    tipoEntrega.addEventListener('change', actualizarContenedorDinamico);

    // Llamar función al cargar la página si ya hay un valor seleccionado
    if (tipoEntrega.value) {
        actualizarContenedorDinamico();
    }

    // Validación del formulario antes de enviar
    form.addEventListener('submit', function(e) {
        const tipoEntregaValue = tipoEntrega.value;
        
        if (tipoEntregaValue === 'envio') {
            const numeroGuia = document.getElementById('numero_guia');
            if (!numeroGuia || !numeroGuia.value.trim()) {
                e.preventDefault();
                alert('Por favor, ingrese el número de guía para el envío.');
                return false;
            }
        } else if (tipoEntregaValue === 'entregado') {
            const direccionOficina = document.getElementById('direccion_oficina');
            if (!direccionOficina || !direccionOficina.value.trim()) {
                e.preventDefault();
                alert('Por favor, ingrese la dirección de la oficina donde se entregó.');
                return false;
            }
        }

        // Deshabilitar botón para evitar envíos múltiples
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '⏳ Guardando...';
    });

    // Mejorar la búsqueda en los select
    const selectDocente = document.getElementById('docente_id');
    const selectCurso = document.getElementById('curso_id');

    // Agregar funcionalidad de búsqueda básica en los selects
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
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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

#contenedor_dinamico .form-control {
    margin-bottom: 5px;
}

#contenedor_dinamico .form-text {
    font-size: 0.8rem;
}
</style>
@endsection