@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Editar docente
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">
                        <small>Editando información de: <strong>{{ $docente->nombre }} {{ $docente->apellido_paterno }}</strong></small>
                    </p>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Ups!</strong> Hay algunos errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('docentes.update', $docente->id) }}" method="POST" enctype="multipart/form-data" id="docenteEditForm" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Información Personal -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-user me-2"></i>
                                Información Personal
                            </h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="{{ old('nombre', $docente->nombre) }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El nombre es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" class="form-control" 
                                           value="{{ old('apellido_paterno', $docente->apellido_paterno) }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido paterno es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control" 
                                           value="{{ old('apellido_materno', $docente->apellido_materno) }}" 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido materno debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Edad</label>
                                    <input type="number" name="edad" class="form-control" 
                                           min="18" max="70" value="{{ old('edad', $docente->edad) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        La edad es requerida y debe estar entre 18 y 70 años.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Nacionalidad</label>
                                    <select name="nacionalidad" class="form-select" required onchange="validateField(this)">
                                        <option value="">Seleccionar nacionalidad</option>
                                        @php
                                            $nacionalidades = [
                                                'Argentina', 'Boliviana', 'Brasileña', 'Chilena', 'Colombiana', 'Ecuatoriana',
                                                'Guyanesa', 'Paraguaya', 'Peruana', 'Surinamesa', 'Uruguaya', 'Venezolana'
                                            ];
                                        @endphp
                                        @foreach ($nacionalidades as $nac)
                                            <option value="{{ $nac }}" {{ old('nacionalidad', $docente->nacionalidad) == $nac ? 'selected' : '' }}>
                                                {{ $nac }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar una nacionalidad.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Grado Académico</label>
                                    <select name="grado_academico" class="form-select" required onchange="validateField(this)">
                                        <option value="">Seleccionar grado académico</option>
                                        @php
                                            $grados = [
                                                'Técnico Superior', 'Licenciatura', 'Ingeniería', 'Maestría', 'Doctorado', 'Post-Doctorado'
                                            ];
                                        @endphp
                                        @foreach ($grados as $grado)
                                            <option value="{{ $grado }}" {{ old('grado_academico', $docente->grado_academico) == $grado ? 'selected' : '' }}>
                                                {{ $grado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar un grado académico.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-phone me-2"></i>
                                Información de Contacto
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Teléfono</label>
                                    <input type="tel" name="telefono" class="form-control" 
                                           value="{{ old('telefono', $docente->telefono) }}" required
                                           pattern="\d{8}" maxlength="8" inputmode="numeric"
                                           title="Debe tener exactamente 8 dígitos"
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        El teléfono es requerido y debe tener exactamente 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Correo Electrónico</label>
                                    <input type="email" name="correo" class="form-control" 
                                           value="{{ old('correo', $docente->correo) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        Debe ingresar un correo electrónico válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Experiencia Profesional -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-briefcase me-2"></i>
                                Experiencia Profesional
                            </h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Experiencia Laboral</label>
                                    <textarea name="experiencia" class="form-control" rows="4" required
                                              maxlength="1000" placeholder="Describa la experiencia laboral y profesional del docente..."
                                              oninput="validateField(this); updateCharCount(this, 'experienciaCount')">{{ old('experiencia', $docente->experiencia) }}</textarea>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Máximo 1000 caracteres</small>
                                        <small class="text-muted">
                                            <span id="experienciaCount">{{ strlen(old('experiencia', $docente->experiencia)) }}</span>/1000
                                        </small>
                                    </div>
                                    <div class="invalid-feedback">
                                        La experiencia laboral es requerida.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">¿Ha impartido clases anteriormente?</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="impartio_clases" value="1" 
                                                   id="impartio_si" {{ old('impartio_clases', $docente->impartio_clases) == '1' ? 'checked' : '' }} 
                                                   required onchange="validateField(this)">
                                            <label class="form-check-label" for="impartio_si">
                                                <i class="fas fa-check-circle text-success me-1"></i>
                                                Sí, ha impartido clases
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="impartio_clases" value="0" 
                                                   id="impartio_no" {{ old('impartio_clases', $docente->impartio_clases) == '0' ? 'checked' : '' }} 
                                                   required onchange="validateField(this)">
                                            <label class="form-check-label" for="impartio_no">
                                                <i class="fas fa-times-circle text-danger me-1"></i>
                                                No ha impartido clases
                                            </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Debe seleccionar una opción.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentos -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-file-upload me-2"></i>
                                Documentos
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fotografía del Docente</label>
                                    <input type="file" name="foto" class="form-control" 
                                           accept="image/jpeg,image/png,image/jpg" 
                                           onchange="previewImage(event)">
                                    <small class="text-muted">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</small>
                                    
                                    <div class="mt-3 text-center">
                                        @if ($docente->foto)
                                            <div class="position-relative d-inline-block">
                                                <img id="preview" 
                                                     src="{{ asset('storage/' . $docente->foto) }}" 
                                                     alt="Foto actual"
                                                     class="img-thumbnail shadow" 
                                                     style="max-width: 200px; max-height: 200px;">
                                                <span class="badge bg-primary position-absolute top-0 end-0 m-1">
                                                    Foto actual
                                                </span>
                                            </div>
                                        @else
                                            <img id="preview" 
                                                 src="#" 
                                                 alt="Vista previa" 
                                                 class="img-thumbnail shadow d-none" 
                                                 style="max-width: 200px; max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currículum Vitae</label>
                                    <input type="file" name="curriculum" class="form-control" 
                                           accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 5MB</small>
                                    
                                    @if ($docente->curriculum)
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <div>
                                                    <strong>Currículum actual:</strong><br>
                                                    <a href="{{ asset('storage/' . $docente->curriculum) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>
                                                        Ver documento
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información de Auditoría -->
                        <div class="form-section mb-4 bg-light">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Información del Registro
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha de Registro</label>
                                    <input type="text" class="form-control bg-light" 
                                           value="{{ $docente->created_at ? $docente->created_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Última Actualización</label>
                                    <input type="text" class="form-control bg-light" 
                                           value="{{ $docente->updated_at ? $docente->updated_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver al listado
                                </a>
                                
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>
                                    Deshacer cambios
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Actualizar docente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.required::after {
    content: " *";
    color: #dc3545;
}

.form-section {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    border-left: 4px solid #007bff;
}

.form-section.bg-light {
    background-color: #e9ecef !important;
    border-left-color: #6c757d;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    color: white;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
}

.btn-outline-secondary:hover, .btn-outline-info:hover, .btn-outline-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.is-invalid {
    border-color: #dc3545;
}

.is-valid {
    border-color: #28a745;
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #007bff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.changed-field {
    background-color: #cce5ff !important;
    border-left: 3px solid #007bff;
}

.img-thumbnail {
    border-radius: 8px;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}
</style>

<script>
// Almacenar valores originales para detectar cambios
const originalValues = {};

function capitalizeFirstLetter(input) {
    let value = input.value;
    input.value = value.charAt(0).toUpperCase() + value.slice(1);
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';

    // Remover clases previas
    field.classList.remove('is-valid', 'is-invalid');

    // Validaciones específicas por campo
    switch(fieldName) {
        case 'nombre':
        case 'apellido_paterno':
            if (!value) {
                isValid = false;
                errorMessage = 'Este campo es requerido';
            } else if (value.length < 2 || value.length > 50) {
                isValid = false;
                errorMessage = 'Debe tener entre 2 y 50 caracteres';
            } else if (!/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Solo se permiten letras';
            }
            break;

        case 'apellido_materno':
            if (value && (value.length < 2 || value.length > 50)) {
                isValid = false;
                errorMessage = 'Debe tener entre 2 y 50 caracteres';
            } else if (value && !/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Solo se permiten letras';
            }
            break;

        case 'edad':
            const edad = parseInt(value);
            if (!value) {
                isValid = false;
                errorMessage = 'La edad es requerida';
            } else if (edad < 18 || edad > 70) {
                isValid = false;
                errorMessage = 'Debe estar entre 18 y 70 años';
            }
            break;

        case 'nacionalidad':
        case 'grado_academico':
            if (!value) {
                isValid = false;
                errorMessage = 'Debe seleccionar una opción';
            }
            break;

        case 'correo':
            if (!value) {
                isValid = false;
                errorMessage = 'El correo es requerido';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Ingrese un correo válido';
            }
            break;

        case 'telefono':
            if (!value) {
                isValid = false;
                errorMessage = 'El teléfono es requerido';
            } else if (!/^\d{8}$/.test(value)) {
                isValid = false;
                errorMessage = 'Debe tener exactamente 8 dígitos';
            }
            break;

        case 'experiencia':
            if (!value) {
                isValid = false;
                errorMessage = 'La experiencia laboral es requerida';
            } else if (value.length > 1000) {
                isValid = false;
                errorMessage = 'Máximo 1000 caracteres';
            }
            break;

        case 'impartio_clases':
            if (!document.querySelector('input[name="impartio_clases"]:checked')) {
                isValid = false;
                errorMessage = 'Debe seleccionar una opción';
            }
            break;
    }

    // Aplicar clase y mensaje
    if (isValid) {
        field.classList.add('is-valid');
    } else {
        field.classList.add('is-invalid');
        const feedback = field.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = errorMessage;
        }
    }

    // Detectar cambios
    checkForChanges(field);

    return isValid;
}

function checkForChanges(field) {
    const currentValue = field.value;
    const originalValue = originalValues[field.name] || '';
    
    if (currentValue !== originalValue) {
        field.classList.add('changed-field');
    } else {
        field.classList.remove('changed-field');
    }
    
    updateSubmitButton();
}

function updateSubmitButton() {
    const submitBtn = document.getElementById('submitBtn');
    const hasChanges = document.querySelector('.changed-field') !== null;
    
    if (hasChanges) {
        submitBtn.classList.remove('btn-outline-primary');
        submitBtn.classList.add('btn-primary');
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar cambios';
    } else {
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-outline-primary');
        submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Sin cambios';
    }
}

function resetForm() {
    if (confirm('¿Está seguro de que desea deshacer todos los cambios?')) {
        const form = document.getElementById('docenteEditForm');
        const inputs = form.querySelectorAll('input:not([readonly]), select, textarea');
        
        inputs.forEach(input => {
            const originalValue = originalValues[input.name] || '';
            if (input.type === 'radio') {
                input.checked = originalValue === input.value;
            } else {
                input.value = originalValue;
            }
            input.classList.remove('is-valid', 'is-invalid', 'changed-field');
        });
        
        updateSubmitButton();
    }
}

function validateForm() {
    const form = document.getElementById('docenteEditForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });

    return isValid;
}

function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        // Validar tamaño del archivo (2MB máximo)
        if (file.size > 2 * 1024 * 1024) {
            alert('El archivo es demasiado grande. El tamaño máximo es 2MB.');
            event.target.value = '';
            return;
        }

        // Validar tipo de archivo
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Formato de archivo no permitido. Solo se permiten JPG, PNG.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}

function updateCharCount(textarea, counterId) {
    const count = textarea.value.length;
    const counter = document.getElementById(counterId);
    counter.textContent = count;
    
    // Cambiar color si se acerca al límite
    if (count > 800) {
        counter.style.color = '#dc3545';
    } else if (count > 600) {
        counter.style.color = '#ffc107';
    } else {
        counter.style.color = '#6c757d';
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('docenteEditForm');
    const inputs = form.querySelectorAll('input:not([readonly]), select, textarea');
    
    // Almacenar valores originales
    inputs.forEach(input => {
        if (input.type === 'radio') {
            originalValues[input.name] = input.checked ? input.value : '';
        } else {
            originalValues[input.name] = input.value;
        }
    });
    
    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        if (input.type === 'text' || input.type === 'email' || input.type === 'textarea') {
            input.addEventListener('input', function() {
                clearTimeout(this.validationTimeout);
                this.validationTimeout = setTimeout(() => {
                    validateField(this);
                }, 500);
            });
        }
    });
    
    // Inicializar contador de caracteres
    const experienciaTextarea = document.querySelector('textarea[name="experiencia"]');
    if (experienciaTextarea) {
        updateCharCount(experienciaTextarea, 'experienciaCount');
    }
    
    updateSubmitButton();
});

document.getElementById('docenteEditForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (validateForm()) {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Mostrar loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        submitBtn.disabled = true;
        
        // Simular envío (reemplazar con envío real)
        setTimeout(() => {
            this.submit();
        }, 1000);
    } else {
        // Scroll al primer campo con error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
});
</script>
@endsection