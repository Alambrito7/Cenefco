@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Personal
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">
                        <small>Editando información de: <strong>{{ $personal->nombre }} {{ $personal->apellido_paterno }}</strong></small>
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

                    <form action="{{ route('personals.update', $personal->id) }}" method="POST" enctype="multipart/form-data" id="personalEditForm" novalidate>
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
                                           value="{{ old('nombre', $personal->nombre) }}" 
                                           required oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El nombre es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" class="form-control" 
                                           value="{{ old('apellido_paterno', $personal->apellido_paterno) }}" 
                                           required oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido paterno es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control" 
                                           value="{{ old('apellido_materno', $personal->apellido_materno) }}" 
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
                                           value="{{ old('ci', $personal->ci) }}" 
                                           required maxlength="8" pattern="[0-9]{7,8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8);">
                                    <div class="invalid-feedback">
                                        El CI es requerido y debe tener hasta 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Edad</label>
                                    <input type="number" name="edad" class="form-control" 
                                           value="{{ old('edad', $personal->edad) }}" 
                                           required min="18" max="80">
                                    <div class="invalid-feedback">
                                        La edad es requerida y debe estar entre 18 y 80 años.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Género</label>
                                    <select name="genero" class="form-select" required>
                                        <option value="">Seleccionar</option>
                                        <option value="Masculino" {{ old('genero', $personal->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero', $personal->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero', $personal->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                                    <label class="form-label required">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control" 
                                           value="{{ old('telefono', $personal->telefono) }}" 
                                           required maxlength="8" pattern="[0-9]{8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8);">
                                    <div class="invalid-feedback">
                                        El teléfono es requerido y debe tener 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Correo Electrónico</label>
                                    <input type="email" name="correo" class="form-control" 
                                           value="{{ old('correo', $personal->correo) }}" 
                                           required>
                                    <div class="invalid-feedback">
                                        El correo es requerido y debe ser válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cargo -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-briefcase me-2"></i>
                                Cargo
                            </h5>
                            <input type="text" name="cargo" class="form-control" 
                                   value="{{ old('cargo', $personal->cargo) }}" 
                                   required>
                        </div>

                        <!-- Foto -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-image me-2"></i>
                                Foto del Personal
                            </h5>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            @if ($personal->foto)
                                <small class="text-muted">Foto actual: 
                                    <a href="{{ asset('storage/' . $personal->foto) }}" target="_blank">Ver</a>
                                </small>
                            @endif
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('personals.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver al listado
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-warning btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>
                                    Actualizar Personal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function capitalizeFirstLetter(input) {
    let words = input.value.toLowerCase().split(' ');
    for (let i = 0; i < words.length; i++) {
        if (words[i]) {
            words[i] = words[i][0].toUpperCase() + words[i].substr(1);
        }
    }
    input.value = words.join(' ');
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
            } else if (edad < 18 || edad > 80) {
                isValid = false;
                errorMessage = 'Debe estar entre 18 y 80 años';
            }
            break;

        case 'genero':
        case 'cargo':
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
                errorMessage = 'Debe tener 8 dígitos';
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

    return isValid;
}
</script>
@endsection
