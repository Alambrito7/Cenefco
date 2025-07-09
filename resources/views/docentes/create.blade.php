@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header Principal --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="display-6 fw-bold text-primary mb-2">
                        <i class="fas fa-user-plus me-2"></i>
                        Registrar Nuevo Docente
                    </h1>
                    <p class="text-muted mb-0">Complete la información del docente para agregarlo al sistema</p>
                </div>
            </div>

            {{-- Alertas de Error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>¡Atención!</strong> Por favor corrija los siguientes errores:
                    </div>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Formulario Principal --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('docentes.store') }}" method="POST" enctype="multipart/form-data" id="formularioDocente">
                        @csrf

                        {{-- Sección: Datos Personales --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    Datos Personales
                                </h4>
                                <hr class="mb-3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nombre" class="form-control" 
                                       value="{{ old('nombre') }}" 
                                       required 
                                       oninput="capitalizeFirstLetter(this)"
                                       placeholder="Ingrese el nombre">
                                @error('nombre')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Apellido Paterno <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="apellido_paterno" class="form-control" 
                                       value="{{ old('apellido_paterno') }}" 
                                       required 
                                       oninput="capitalizeFirstLetter(this)"
                                       placeholder="Ingrese el apellido paterno">
                                @error('apellido_paterno')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Apellido Materno
                                </label>
                                <input type="text" name="apellido_materno" class="form-control" 
                                       value="{{ old('apellido_materno') }}" 
                                       oninput="capitalizeFirstLetter(this)"
                                       placeholder="Ingrese el apellido materno">
                                @error('apellido_materno')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección: Información de Contacto --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-address-book me-2"></i>
                                    Información de Contacto
                                </h4>
                                <hr class="mb-3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone me-2 text-primary"></i>
                                    Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="telefono" class="form-control" 
                                       value="{{ old('telefono') }}" 
                                       required 
                                       maxlength="8" 
                                       pattern="[0-9]{8}" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8);"
                                       placeholder="12345678">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ingrese 8 dígitos numéricos
                                </div>
                                @error('telefono')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="correo" class="form-control" 
                                       value="{{ old('correo') }}" 
                                       required
                                       placeholder="ejemplo@correo.com">
                                @error('correo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección: Información Adicional --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Información Adicional
                                </h4>
                                <hr class="mb-3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-flag me-2 text-primary"></i>
                                    Nacionalidad <span class="text-danger">*</span>
                                </label>
                                <select name="nacionalidad" class="form-select" required>
                                    <option value="">Seleccionar nacionalidad</option>
                                    @php
                                        $nacionalidades = [
                                            'Argentina', 'Boliviana', 'Brasileña', 'Chilena', 'Colombiana', 'Ecuatoriana',
                                            'Guyanesa', 'Paraguaya', 'Peruana', 'Surinamesa', 'Uruguaya', 'Venezolana'
                                        ];
                                    @endphp
                                    @foreach ($nacionalidades as $nac)
                                        <option value="{{ $nac }}" {{ old('nacionalidad') == $nac ? 'selected' : '' }}>{{ $nac }}</option>
                                    @endforeach
                                </select>
                                @error('nacionalidad')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                    Edad <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="edad" class="form-control" 
                                       value="{{ old('edad') }}" 
                                       required 
                                       min="18" 
                                       max="70"
                                       placeholder="Ej: 30">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Entre 18 y 70 años
                                </div>
                                @error('edad')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                    Grado Académico <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="grado_academico" class="form-control" 
                                       value="{{ old('grado_academico') }}" 
                                       required
                                       placeholder="Ej: Licenciatura en Educación">
                                @error('grado_academico')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección: Experiencia Profesional --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Experiencia Profesional
                                </h4>
                                <hr class="mb-3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                    Experiencia <span class="text-danger">*</span>
                                </label>
                                <textarea name="experiencia" class="form-control" rows="4" required 
                                          placeholder="Describa la experiencia laboral y profesional del docente...">{{ old('experiencia') }}</textarea>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Incluya años de experiencia, instituciones donde ha trabajado, logros relevantes, etc.
                                </div>
                                @error('experiencia')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                                    ¿Ha impartido clases? <span class="text-danger">*</span>
                                </label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="impartio_clases" value="1" 
                                               {{ old('impartio_clases') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Sí
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="impartio_clases" value="0" 
                                               {{ old('impartio_clases') == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label">
                                            <i class="fas fa-times-circle text-danger me-1"></i>
                                            No
                                        </label>
                                    </div>
                                </div>
                                @error('impartio_clases')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección: Documentos --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-folder-open me-2"></i>
                                    Documentos
                                </h4>
                                <hr class="mb-3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-camera me-2 text-primary"></i>
                                    Foto del Docente
                                </label>
                                <input type="file" name="foto" class="form-control" 
                                       accept="image/*" 
                                       onchange="previewImage(event)">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Formatos permitidos: JPG, PNG, GIF (máx. 2MB)
                                </div>
                                @error('foto')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                
                                {{-- Vista previa de la imagen --}}
                                <div class="mt-3 text-center">
                                    <div id="preview-container" class="d-none">
                                        <div class="border rounded p-3 bg-light">
                                            <p class="text-muted mb-2">Vista previa:</p>
                                            <img id="preview" src="#" alt="Vista previa" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-file-pdf me-2 text-primary"></i>
                                    Currículum Vitae
                                </label>
                                <input type="file" name="curriculum" class="form-control" 
                                       accept=".pdf,.doc,.docx"
                                       onchange="showFileInfo(event)">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Formatos permitidos: PDF, DOC, DOCX (máx. 5MB)
                                </div>
                                @error('curriculum')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                
                                {{-- Información del archivo --}}
                                <div id="file-info" class="mt-2 d-none">
                                    <div class="alert alert-info py-2">
                                        <i class="fas fa-file me-2"></i>
                                        <span id="file-name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="row">
                            <div class="col-12">
                                <hr class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>
                                        Guardar Docente
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

{{-- Scripts --}}
<script>
    // Función para capitalizar primera letra
    function capitalizeFirstLetter(input) {
        let words = input.value.toLowerCase().split(' ');
        for (let i = 0; i < words.length; i++) {
            if (words[i]) {
                words[i] = words[i][0].toUpperCase() + words[i].substr(1);
            }
        }
        input.value = words.join(' ');
    }

    // Función para previsualizar imagen
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('preview-container');

        reader.onload = function() {
            preview.src = reader.result;
            previewContainer.classList.remove('d-none');
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    // Función para mostrar información del archivo
    function showFileInfo(event) {
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        
        if (event.target.files[0]) {
            const file = event.target.files[0];
            fileName.textContent = file.name;
            fileInfo.classList.remove('d-none');
        } else {
            fileInfo.classList.add('d-none');
        }
    }

    // Validación del formulario
    document.getElementById('formularioDocente').addEventListener('submit', function(e) {
        // Aquí puedes agregar validaciones adicionales si es necesario
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        submitBtn.disabled = true;
    });

    // Limpiar formulario si hay errores
    document.addEventListener('DOMContentLoaded', function() {
        // Restaurar estado del botón si hay errores
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Docente';
            submitBtn.disabled = false;
        }
    });
</script>
@endsection