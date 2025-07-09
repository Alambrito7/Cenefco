@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar cliente
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">
                        <small>Editando información de: <strong>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</strong></small>
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

                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" id="clienteEditForm" novalidate>
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
                                           value="{{ old('nombre', $cliente->nombre) }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El nombre es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" class="form-control" 
                                           value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido paterno es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control" 
                                           value="{{ old('apellido_materno', $cliente->apellido_materno) }}" 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido materno debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">CI</label>
                                    <input type="text" name="ci" class="form-control" 
                                           pattern="\d{1,8}" maxlength="8" inputmode="numeric" 
                                           title="Puede tener hasta 8 números" 
                                           value="{{ old('ci', $cliente->ci) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        El CI es requerido y debe tener hasta 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Edad</label>
                                    <input type="number" name="edad" class="form-control" 
                                           min="15" max="70" value="{{ old('edad', $cliente->edad) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        La edad es requerida y debe estar entre 15 y 70 años.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Género</label>
                                    <select name="genero" class="form-select" required onchange="validateField(this)">
                                        <option value="">Seleccionar</option>
                                        <option value="Masculino" {{ old('genero', $cliente->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero', $cliente->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero', $cliente->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar un género.
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
                                    <label class="form-label required">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ old('email', $cliente->email) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        Debe ingresar un correo electrónico válido.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Celular</label>
                                    <input type="text" name="celular" class="form-control" 
                                           pattern="\d{8}" maxlength="8" inputmode="numeric" 
                                           title="Debe tener exactamente 8 dígitos" 
                                           value="{{ old('celular', $cliente->celular) }}" required
                                           oninput="validateField(this)">
                                    <div class="invalid-feedback">
                                        El celular es requerido y debe tener exactamente 8 dígitos.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Académica/Profesional -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Información Académica/Profesional
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profesión</label>
                                    <input type="text" name="profesion" class="form-control" 
                                           value="{{ old('profesion', $cliente->profesion) }}"
                                           oninput="capitalizeFirstLetter(this); validateField(this)">
                                    <div class="invalid-feedback">
                                        La profesión debe tener entre 2 y 100 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Grado académico</label>
                                    <select name="grado_academico" class="form-select" onchange="validateField(this)">
                                        <option value="">Seleccionar</option>
                                        <option value="Estudiante" {{ old('grado_academico', $cliente->grado_academico) == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                        <option value="Licenciatura" {{ old('grado_academico', $cliente->grado_academico) == 'Licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                        <option value="Posgrado" {{ old('grado_academico', $cliente->grado_academico) == 'Posgrado' ? 'selected' : '' }}>Posgrado</option>
                                        <option value="Maestría" {{ old('grado_academico', $cliente->grado_academico) == 'Maestría' ? 'selected' : '' }}>Maestría</option>
                                        <option value="Doctorado" {{ old('grado_academico', $cliente->grado_academico) == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Información Geográfica -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Información Geográfica
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">País</label>
                                    <input type="text" name="pais" class="form-control bg-light" value="Bolivia" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Departamento</label>
                                    <select name="departamento" id="departamento" class="form-select" required onchange="validateField(this)">
                                        <option value="">Seleccionar</option>
                                        @php
                                            $departamentos = ['La Paz', 'Santa Cruz', 'Cochabamba', 'Oruro', 'Potosí', 'Tarija', 'Chuquisaca', 'Beni', 'Pando'];
                                        @endphp
                                        @foreach ($departamentos as $dep)
                                            <option value="{{ $dep }}" {{ old('departamento', $cliente->departamento) == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar un departamento.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Provincia</label>
                                    <select name="provincia" id="provincia" class="form-select" required onchange="validateField(this)">
                                        <option value="">Seleccionar</option>
                                        @if (old('provincia') || $cliente->provincia)
                                            <option value="{{ old('provincia', $cliente->provincia) }}" selected>{{ old('provincia', $cliente->provincia) }}</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar una provincia.
                                    </div>
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
                                           value="{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Última Actualización</label>
                                    <input type="text" class="form-control bg-light" 
                                           value="{{ $cliente->updated_at ? $cliente->updated_at->format('d/m/Y H:i') : 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver al listado
                                </a>
                               
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>
                                    Deshacer cambios
                                </button>
                                <button type="submit" class="btn btn-warning btn-lg px-4" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Actualizar cliente
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
    border-left: 4px solid #ffc107;
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
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    border: none;
    color: #212529;
    font-weight: 600;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800 0%, #e6781a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    color: #212529;
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
    border: 2px solid #212529;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.changed-field {
    background-color: #fff3cd !important;
    border-left: 3px solid #ffc107;
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

        case 'ci':
            if (!value) {
                isValid = false;
                errorMessage = 'El CI es requerido';
            } else if (!/^\d{1,8}$/.test(value)) {
                isValid = false;
                errorMessage = 'Debe tener hasta 8 dígitos';
            }
            break;

        case 'edad':
            const edad = parseInt(value);
            if (!value) {
                isValid = false;
                errorMessage = 'La edad es requerida';
            } else if (edad < 15 || edad > 70) {
                isValid = false;
                errorMessage = 'Debe estar entre 15 y 70 años';
            }
            break;

        case 'genero':
        case 'departamento':
        case 'provincia':
            if (!value) {
                isValid = false;
                errorMessage = 'Debe seleccionar una opción';
            }
            break;

        case 'email':
            if (!value) {
                isValid = false;
                errorMessage = 'El correo es requerido';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Ingrese un correo válido';
            }
            break;

        case 'celular':
            if (!value) {
                isValid = false;
                errorMessage = 'El celular es requerido';
            } else if (!/^\d{8}$/.test(value)) {
                isValid = false;
                errorMessage = 'Debe tener exactamente 8 dígitos';
            }
            break;

        case 'profesion':
            if (value && (value.length < 2 || value.length > 100)) {
                isValid = false;
                errorMessage = 'Debe tener entre 2 y 100 caracteres';
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
        submitBtn.classList.remove('btn-outline-warning');
        submitBtn.classList.add('btn-warning');
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar cambios';
    } else {
        submitBtn.classList.remove('btn-warning');
        submitBtn.classList.add('btn-outline-warning');
        submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Sin cambios';
    }
}

function resetForm() {
    if (confirm('¿Está seguro de que desea deshacer todos los cambios?')) {
        const form = document.getElementById('clienteEditForm');
        const inputs = form.querySelectorAll('input:not([readonly]), select');
        
        inputs.forEach(input => {
            const originalValue = originalValues[input.name] || '';
            input.value = originalValue;
            input.classList.remove('is-valid', 'is-invalid', 'changed-field');
        });
        
        // Restaurar provincia
        const departamento = document.getElementById('departamento').value;
        if (departamento) {
            loadProvincias(departamento);
            setTimeout(() => {
                document.getElementById('provincia').value = originalValues['provincia'] || '';
            }, 100);
        }
        
        updateSubmitButton();
    }
}

function validateForm() {
    const form = document.getElementById('clienteEditForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });

    return isValid;
}

function loadProvincias(departamento) {
    const provincias = provinciasPorDepartamento[departamento] || [];
    const provinciaSelect = document.getElementById("provincia");
    const currentProvincia = provinciaSelect.value;

    provinciaSelect.innerHTML = '<option value="">Seleccionar</option>';
    provincias.forEach(provincia => {
        const option = document.createElement("option");
        option.value = provincia;
        option.textContent = provincia;
        if (provincia === currentProvincia) {
            option.selected = true;
        }
        provinciaSelect.appendChild(option);
    });
}

// Datos de provincias por departamento
const provinciasPorDepartamento = {
    "La Paz": ["Abel Iturralde", "Aroma", "Bautista Saavedra", "Caranavi", "Eliodoro Camacho", "Franz Tamayo", "Gualberto Villarroel",
        "Ingavi", "Inquisivi", "José Manuel Pando", "Larecaja", "Loayza", "Los Andes", "Manco Kapac", "Muñecas",
        "Nor Yungas", "Omasuyos", "Pacajes", "Pedro Domingo Murillo", "Sud Yungas"],
    "Santa Cruz": ["Andrés Ibáñez", "Ángel Sandóval", "Chiquitos", "Cordillera", "Florida", "Germán Busch", "Guarayos", "Ichilo",
        "Ignacio Warnes", "José Miguel de Velasco", "Manuel María Caballero", "Ñuflo de Chávez", "Obispo Santistevan",
        "Sara", "Vallegrande"],
    "Cochabamba": ["Arani", "Arque", "Ayopaya", "Bolívar", "Capinota", "Carrasco", "Cercado", "Chapare", "Esteban Arce",
        "Germán Jordán", "Mizque", "Narciso Campero", "Punata", "Quillacollo", "Tapacarí", "Tiraque"],
    "Oruro": ["Abaroa", "Carangas", "Cercado", "Eduardo Abaroa", "Ladislao Cabrera", "Litoral", "Mejillones", "Nor Carangas",
        "Nor Chichas", "Poopó", "Sajama", "San Pedro de Totora", "Saucarí", "Sebastián Pagador", "Sud Carangas", "Tomás Barrón"],
    "Potosí": ["Alonso de Ibáñez", "Antonio Quijarro", "Bernardino Bilbao", "Charcas", "Chayanta", "Cornelio Saavedra", "Daniel Campos",
        "Enrique Baldivieso", "José María Linares", "Modesto Omiste", "Nor Chichas", "Nor Lípez", "Rafael Bustillo", "Sud Chichas",
        "Sud Lípez", "Tomás Frías"],
    "Tarija": ["Aniceto Arce", "Burnet O'Connor", "Cercado", "Eustaquio Méndez", "Gran Chaco", "José María Avilés"],
    "Chuquisaca": ["Azurduy", "Belisario Boeto", "Hernando Siles", "Jaime Zudáñez", "Juana Azurduy de Padilla", "Luis Calvo",
        "Nor Cinti", "Oropeza", "Sud Cinti", "Tomina"],
    "Beni": ["Cercado", "Iténez", "José Ballivián", "Mamoré", "Marbán", "Moxos", "Vaca Díez", "Yacuma"],
    "Pando": ["Abuná", "Federico Román", "Madre de Dios", "Manuripi", "Nicolás Suárez"]
};

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clienteEditForm');
    const inputs = form.querySelectorAll('input:not([readonly]), select');
    
    // Almacenar valores originales
    inputs.forEach(input => {
        originalValues[input.name] = input.value;
    });
    
    // Cargar provincias iniciales
    const departamento = document.getElementById('departamento').value;
    if (departamento) {
        loadProvincias(departamento);
    }
    
    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        if (input.type === 'text' || input.type === 'email') {
            input.addEventListener('input', function() {
                clearTimeout(this.validationTimeout);
                this.validationTimeout = setTimeout(() => {
                    validateField(this);
                }, 500);
            });
        }
    });
    
    updateSubmitButton();
});

document.getElementById("departamento").addEventListener("change", function () {
    const selected = this.value;
    loadProvincias(selected);
    
    // Limpiar validación de provincia
    const provinciaSelect = document.getElementById("provincia");
    provinciaSelect.classList.remove('is-valid', 'is-invalid');
    checkForChanges(provinciaSelect);
});

document.getElementById('clienteEditForm').addEventListener('submit', function(e) {
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