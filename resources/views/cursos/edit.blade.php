@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header con breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Curso</li>
                </ol>
            </nav>
            <h2 class="mb-0">
                <i class="fas fa-edit me-2"></i>Editar Curso
            </h2>
            <p class="text-muted">Actualiza la información del curso</p>
        </div>
    </div>

    <!-- Alertas de error mejoradas -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>¡Ups!</strong> Hay algunos errores que debes corregir:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulario -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-graduation-cap me-2"></i>
                Información del Curso
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos.update', $curso->id) }}" method="POST" enctype="multipart/form-data" id="cursoForm">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Información Básica
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tag me-1"></i>Nombre del Curso
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $curso->nombre) }}" 
                               style="text-transform: uppercase;" 
                               oninput="this.value = this.value.toUpperCase();" 
                               placeholder="Ingresa el nombre del curso"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-university me-1"></i>Área Académica
                            <span class="text-danger">*</span>
                        </label>
                        <select name="area" class="form-select @error('area') is-invalid @enderror" required>
                            <option value="">Seleccionar área</option>
                            <option value="Ingeniería" {{ old('area', $curso->area) == 'Ingeniería' ? 'selected' : '' }}>Ingeniería</option>
                            <option value="Derecho" {{ old('area', $curso->area) == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                            <option value="Arquitectura" {{ old('area', $curso->area) == 'Arquitectura' ? 'selected' : '' }}>Arquitectura</option>
                            <option value="Cs. Empresariales" {{ old('area', $curso->area) == 'Cs. Empresariales' ? 'selected' : '' }}>Cs. Empresariales</option>
                            <option value="Cs. Salud" {{ old('area', $curso->area) == 'Cs. Salud' ? 'selected' : '' }}>Cs. Salud</option>
                        </select>
                        @error('area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información Institucional -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>
                            Información Institucional
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-bookmark me-1"></i>Marca/Institución
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="marca" 
                               class="form-control @error('marca') is-invalid @enderror" 
                               value="{{ old('marca', $curso->marca) }}" 
                               style="text-transform: uppercase;" 
                               oninput="this.value = this.value.toUpperCase();" 
                               placeholder="Ingresa la marca o institución"
                               required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user-tie me-1"></i>Encargado del Curso
                            <span class="text-danger">*</span>
                        </label>
                        <select name="personal_id" class="form-select @error('personal_id') is-invalid @enderror" required>
                            <option value="">Seleccionar encargado</option>
                            @foreach ($encargados as $encargado)
                                <option value="{{ $encargado->id }}" {{ old('personal_id', $curso->personal_id) == $encargado->id ? 'selected' : '' }}>
                                    {{ $encargado->nombre }} {{ $encargado->apellido_paterno }} {{ $encargado->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                        @error('personal_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Información Académica
                        </h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user-graduate me-1"></i>Docente Encargado
                            <span class="text-danger">*</span>
                        </label>
                        <select name="docente_id" class="form-select @error('docente_id') is-invalid @enderror" required>
                            <option value="">Seleccionar docente</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}" {{ old('docente_id', $curso->docente_id) == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombre }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                        @error('docente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-1"></i>Fecha de Inicio
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="fecha" 
                               class="form-control @error('fecha') is-invalid @enderror" 
                               value="{{ old('fecha', $curso->fecha) }}" 
                               min="{{ date('Y-m-d') }}" 
                               required>
                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Horarios y Estado -->
<div class="row mb-4">
    <div class="col-12">
        <h6 class="text-primary mb-3">
            <i class="fas fa-clock me-2"></i>
            Horarios y Estado
        </h6>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">
            <i class="fas fa-calendar-week me-1"></i>Días de Clases
            <span class="text-danger">*</span>
        </label>
        
        @php
            // Convertir los días guardados en array si están como string
            $diasSeleccionados = [];
            if ($curso->dias_clases) {
                if (is_array($curso->dias_clases)) {
                    $diasSeleccionados = $curso->dias_clases;
                } else {
                    // Si está guardado como string, convertirlo a array
                    $diasSeleccionados = array_map('trim', explode(',', $curso->dias_clases));
                }
            }
            
            // Si viene de old() (después de un error de validación)
            if (old('dias_clases')) {
                $diasSeleccionados = old('dias_clases');
            }
        @endphp
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Lunes" id="lunes"
                           {{ in_array('Lunes', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lunes">
                        <i class="fas fa-calendar-day me-1"></i>Lunes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Martes" id="martes"
                           {{ in_array('Martes', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="martes">
                        <i class="fas fa-calendar-day me-1"></i>Martes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Miércoles" id="miercoles"
                           {{ in_array('Miércoles', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="miercoles">
                        <i class="fas fa-calendar-day me-1"></i>Miércoles
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Jueves" id="jueves"
                           {{ in_array('Jueves', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="jueves">
                        <i class="fas fa-calendar-day me-1"></i>Jueves
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Viernes" id="viernes"
                           {{ in_array('Viernes', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="viernes">
                        <i class="fas fa-calendar-day me-1"></i>Viernes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Sábado" id="sabado"
                           {{ in_array('Sábado', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="sabado">
                        <i class="fas fa-calendar-day me-1"></i>Sábado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias_clases[]" 
                           value="Domingo" id="domingo"
                           {{ in_array('Domingo', $diasSeleccionados) ? 'checked' : '' }}>
                    <label class="form-check-label" for="domingo">
                        <i class="fas fa-calendar-day me-1"></i>Domingo
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-text">
            <i class="fas fa-info-circle me-1"></i>
            Selecciona los días en que se imparten las clases
        </div>
        
        @error('dias_clases')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">
            <i class="fas fa-traffic-light me-1"></i>Estado del Curso
            <span class="text-danger">*</span>
        </label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="">Seleccionar estado</option>
            <option value="Programado" {{ old('estado', $curso->estado) == 'Programado' ? 'selected' : '' }}>
                🟡 Programado
            </option>
            <option value="En curso" {{ old('estado', $curso->estado) == 'En curso' ? 'selected' : '' }}>
                🟢 En curso
            </option>
            <option value="Finalizado" {{ old('estado', $curso->estado) == 'Finalizado' ? 'selected' : '' }}>
                🔴 Finalizado
            </option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>Descripción del Curso
                    </label>
                    <textarea name="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="4" 
                              placeholder="Describe el contenido, objetivos y características del curso...">{{ old('descripcion', $curso->descripcion) }}</textarea>
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Información adicional sobre el curso (opcional)
                    </div>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Imagen del Flayer -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-image me-1"></i>Flayer del Curso
                    </label>
                    <input type="file" name="flayer" 
                           class="form-control @error('flayer') is-invalid @enderror" 
                           accept="image/*" 
                           onchange="previewImage(this)">
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                    </div>
                    @error('flayer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Vista previa de imagen -->
                    <div class="mt-3">
                        @if ($curso->flayer)
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Imagen actual:</h6>
                                    <img src="{{ asset('storage/' . $curso->flayer) }}" 
                                         alt="Flayer actual" 
                                         class="img-fluid rounded shadow-sm border"
                                         style="max-height: 200px; object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Vista previa:</h6>
                                    <img id="preview" 
                                         src="#" 
                                         alt="Vista previa" 
                                         class="img-fluid rounded shadow-sm border d-none"
                                         style="max-height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                <p class="text-muted">No hay imagen actual</p>
                                <img id="preview" 
                                     src="#" 
                                     alt="Vista previa" 
                                     class="img-fluid rounded shadow-sm border d-none"
                                     style="max-height: 200px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row">
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Restablecer
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Curso
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para funcionalidades adicionales -->
<script>
    // Agregar al final del JavaScript existente en tu vista

// Validación para días de clases
function validateDiasClases() {
    const checkboxes = document.querySelectorAll('input[name="dias_clases[]"]');
    const checked = Array.from(checkboxes).some(cb => cb.checked);
    
    checkboxes.forEach(cb => {
        if (checked) {
            cb.classList.remove('is-invalid');
            cb.classList.add('is-valid');
        } else {
            cb.classList.add('is-invalid');
            cb.classList.remove('is-valid');
        }
    });
    
    return checked;
}

// Agregar event listeners para los checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const diasCheckboxes = document.querySelectorAll('input[name="dias_clases[]"]');
    
    diasCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            validateDiasClases();
        });
    });
    
    // Modificar la función de validación del formulario existente
    const form = document.getElementById('cursoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const diasValidos = validateDiasClases();
            
            if (!diasValidos) {
                e.preventDefault();
                alert('Por favor, selecciona al menos un día de clases.');
                return false;
            }
        });
    }
});

// Función para seleccionar/deseleccionar todos los días
function toggleAllDays(selectAll = true) {
    const checkboxes = document.querySelectorAll('input[name="dias_clases[]"]');
    checkboxes.forEach(cb => {
        cb.checked = selectAll;
    });
    validateDiasClases();
}

// Función para días de semana (Lunes a Viernes)
function selectWeekdays() {
    const weekdays = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    const checkboxes = document.querySelectorAll('input[name="dias_clases[]"]');
    
    checkboxes.forEach(cb => {
        cb.checked = weekdays.includes(cb.value);
    });
    validateDiasClases();
}

// Función para fines de semana
function selectWeekends() {
    const weekends = ['Sábado', 'Domingo'];
    const checkboxes = document.querySelectorAll('input[name="dias_clases[]"]');
    
    checkboxes.forEach(cb => {
        cb.checked = weekends.includes(cb.value);
    });
    validateDiasClases();
}
// Vista previa de imagen
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.classList.add('d-none');
    }
}

// Restablecer formulario
function resetForm() {
    if (confirm('¿Estás seguro de que quieres restablecer el formulario?')) {
        document.getElementById('cursoForm').reset();
        document.getElementById('preview').classList.add('d-none');
    }
}

// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cursoForm');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
});

function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    if (isRequired && !value) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
    } else if (value) {
        field.classList.add('is-valid');
        field.classList.remove('is-invalid');
    } else {
        field.classList.remove('is-valid', 'is-invalid');
    }
}
</script>

@endsection
