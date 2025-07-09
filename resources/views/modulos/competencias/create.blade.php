@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="text-center mb-4">
                <h2 class="display-6 mb-2">
                    <i class="fas fa-plus-circle text-primary"></i>
                    Registrar Nueva Competencia
                </h2>
                <p class="text-muted">Complete todos los campos para registrar una nueva competencia</p>
            </div>

            {{-- Mensajes de error --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>¡Atención!</strong> Por favor corrija los siguientes errores:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Formulario --}}
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-form"></i> Formulario de Registro
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('competencias.store') }}" method="POST" id="form-competencia" novalidate>
                        @csrf

                        {{-- Sección 1: Información de Página --}}
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-globe me-2"></i>Información de Página
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pagina_central" class="form-label">
                                        <i class="fas fa-home me-1"></i>Página Central
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="pagina_central"
                                           name="pagina_central" 
                                           class="form-control @error('pagina_central') is-invalid @enderror" 
                                           value="{{ old('pagina_central') }}"
                                           placeholder="Ej: Centro de Competencias"
                                           required>
                                    @error('pagina_central')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subpagina" class="form-label">
                                        <i class="fas fa-sitemap me-1"></i>Subpágina
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="subpagina"
                                           name="subpagina" 
                                           class="form-control @error('subpagina') is-invalid @enderror" 
                                           value="{{ old('subpagina') }}"
                                           placeholder="Ej: Capacitación Técnica"
                                           required>
                                    @error('subpagina')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Sección 2: Información Académica --}}
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-graduation-cap me-2"></i>Información Académica
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="area" class="form-label">
                                        <i class="fas fa-folder me-1"></i>Área
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="area"
                                           name="area" 
                                           class="form-control @error('area') is-invalid @enderror" 
                                           value="{{ old('area') }}"
                                           placeholder="Ej: Tecnología, Administración, Marketing..."
                                           required>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="curso" class="form-label">
                                        <i class="fas fa-book me-1"></i>Curso
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="curso"
                                           name="curso" 
                                           class="form-control @error('curso') is-invalid @enderror" 
                                           value="{{ old('curso') }}"
                                           placeholder="Ej: Desarrollo Web Avanzado"
                                           required>
                                    @error('curso')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="docente" class="form-label">
                                        <i class="fas fa-user-tie me-1"></i>Docente
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="docente"
                                           name="docente" 
                                           class="form-control @error('docente') is-invalid @enderror" 
                                           value="{{ old('docente') }}"
                                           placeholder="Ej: Juan Pérez"
                                           required>
                                    @error('docente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Sección 3: Fechas --}}
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-calendar me-2"></i>Fechas Importantes
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_publicacion" class="form-label">
                                        <i class="fas fa-calendar-alt me-1"></i>Fecha de Publicación
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           id="fecha_publicacion"
                                           name="fecha_publicacion" 
                                           class="form-control @error('fecha_publicacion') is-invalid @enderror" 
                                           value="{{ old('fecha_publicacion') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('fecha_publicacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Fecha cuando se publicará la competencia
                                    </small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_inicio" class="form-label">
                                        <i class="fas fa-play me-1"></i>Fecha de Inicio
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           id="fecha_inicio"
                                           name="fecha_inicio" 
                                           class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                           value="{{ old('fecha_inicio') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Fecha cuando comenzará la competencia
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 4: Configuración --}}
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-cogs me-2"></i>Configuración
                            </h6>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="link_grupo" class="form-label">
                                        <i class="fas fa-link me-1"></i>Link del Grupo
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-external-link-alt"></i>
                                        </span>
                                        <input type="url" 
                                               id="link_grupo"
                                               name="link_grupo" 
                                               class="form-control @error('link_grupo') is-invalid @enderror" 
                                               value="{{ old('link_grupo') }}"
                                               placeholder="https://ejemplo.com/grupo"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="validarUrl()">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @error('link_grupo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>URL del grupo donde se desarrollará la competencia
                                    </small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">
                                        <i class="fas fa-flag me-1"></i>Estado
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="estado" 
                                            name="estado" 
                                            class="form-select @error('estado') is-invalid @enderror" 
                                            required>
                                        <option value="">Seleccionar estado</option>
                                        <option value="testeo" {{ old('estado') == 'testeo' ? 'selected' : '' }}>
                                            🧪 Testeo
                                        </option>
                                        <option value="ejecutado" {{ old('estado') == 'ejecutado' ? 'selected' : '' }}>
                                            ✅ Ejecutado
                                        </option>
                                        <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>
                                            ❌ Cancelado
                                        </option>
                                        <option value="sin respuesta" {{ old('estado') == 'sin respuesta' ? 'selected' : '' }}>
                                            ⏳ Sin respuesta
                                        </option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-4" id="btn-guardar">
                                <i class="fas fa-save me-2"></i>Guardar Competencia
                            </button>
                            <a href="{{ route('competencias.index') }}" class="btn btn-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Información adicional --}}
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información Importante
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-info">
                                <i class="fas fa-lightbulb me-1"></i>Consejos para completar el formulario:
                            </h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Asegúrese de que el link del grupo sea válido</li>
                                <li><i class="fas fa-check text-success me-2"></i>La fecha de inicio debe ser posterior a la de publicación</li>
                                <li><i class="fas fa-check text-success me-2"></i>Revise que el nombre del docente esté completo</li>
                                <li><i class="fas fa-check text-success me-2"></i>Escriba el área de conocimiento específica</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">
                                <i class="fas fa-flag me-1"></i>Estados disponibles:
                            </h6>
                            <ul class="list-unstyled">
                                <li><span class="badge bg-warning text-dark me-2">Testeo</span>En fase de pruebas</li>
                                <li><span class="badge bg-success me-2">Ejecutado</span>Competencia activa</li>
                                <li><span class="badge bg-danger me-2">Cancelado</span>Competencia cancelada</li>
                                <li><span class="badge bg-secondary me-2">Sin respuesta</span>Pendiente de respuesta</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Loading Modal --}}
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Guardando...</span>
                </div>
                <p class="mb-0">Guardando competencia...</p>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    // Variables globales
    let formSubmitted = false;

    // Inicialización cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        initializeForm();
        setupValidation();
        setupDateValidation();
        setupFormSubmission();
    });

    // Función para inicializar el formulario
    function initializeForm() {
        // Establecer fecha actual como mínimo
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha_publicacion').setAttribute('min', today);
        document.getElementById('fecha_inicio').setAttribute('min', today);

        // Auto-dismiss de alertas
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 8000);
    }

    // Configurar validación del formulario
    function setupValidation() {
        const form = document.getElementById('form-competencia');
        
        // Validación en tiempo real
        form.addEventListener('input', function(e) {
            validateField(e.target);
        });

        // Validación al cambiar select
        form.addEventListener('change', function(e) {
            validateField(e.target);
        });
    }

    // Validar campo individual
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        
        // Remover clases de validación previas
        field.classList.remove('is-valid', 'is-invalid');
        
        // Validaciones específicas
        let isValid = true;
        let errorMessage = '';

        switch(fieldName) {
            case 'link_grupo':
                if (value && !isValidUrl(value)) {
                    isValid = false;
                    errorMessage = 'Ingrese una URL válida';
                }
                break;
            case 'docente':
                if (value && value.length < 2) {
                    isValid = false;
                    errorMessage = 'El nombre del docente debe tener al menos 2 caracteres';
                }
                break;
            case 'curso':
                if (value && value.length < 3) {
                    isValid = false;
                    errorMessage = 'El nombre del curso debe tener al menos 3 caracteres';
                }
                break;
            case 'area':
                if (value && value.length < 2) {
                    isValid = false;
                    errorMessage = 'El área debe tener al menos 2 caracteres';
                }
                break;
        }

        // Aplicar clase de validación
        if (field.hasAttribute('required') && !value) {
            // Campo requerido vacío - no marcar como válido o inválido hasta submit
            return;
        }

        if (isValid && value) {
            field.classList.add('is-valid');
            removeCustomError(field);
        } else if (!isValid) {
            field.classList.add('is-invalid');
            showCustomError(field, errorMessage);
        }
    }

    // Mostrar error personalizado
    function showCustomError(field, message) {
        removeCustomError(field);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback custom-error';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    // Remover error personalizado
    function removeCustomError(field) {
        const existingError = field.parentNode.querySelector('.custom-error');
        if (existingError) {
            existingError.remove();
        }
    }

    // Configurar validación de fechas
    function setupDateValidation() {
        const fechaPublicacion = document.getElementById('fecha_publicacion');
        const fechaInicio = document.getElementById('fecha_inicio');

        fechaPublicacion.addEventListener('change', function() {
            if (this.value) {
                fechaInicio.setAttribute('min', this.value);
                validateDateOrder();
            }
        });

        fechaInicio.addEventListener('change', function() {
            validateDateOrder();
        });
    }

    // Validar orden de fechas
    function validateDateOrder() {
        const fechaPublicacion = document.getElementById('fecha_publicacion').value;
        const fechaInicio = document.getElementById('fecha_inicio').value;

        if (fechaPublicacion && fechaInicio) {
            const datePublicacion = new Date(fechaPublicacion);
            const dateInicio = new Date(fechaInicio);

            if (dateInicio < datePublicacion) {
                document.getElementById('fecha_inicio').classList.add('is-invalid');
                showCustomError(document.getElementById('fecha_inicio'), 
                    'La fecha de inicio debe ser posterior a la fecha de publicación');
            } else {
                document.getElementById('fecha_inicio').classList.remove('is-invalid');
                document.getElementById('fecha_inicio').classList.add('is-valid');
                removeCustomError(document.getElementById('fecha_inicio'));
            }
        }
    }

    // Configurar envío del formulario
    function setupFormSubmission() {
        const form = document.getElementById('form-competencia');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (formSubmitted) {
                return false;
            }

            if (validateForm()) {
                formSubmitted = true;
                showLoading();
                
                // Simular delay para mejor UX
                setTimeout(() => {
                    form.submit();
                }, 1000);
            }
        });
    }

    // Validar formulario completo
    function validateForm() {
        const form = document.getElementById('form-competencia');
        let isValid = true;

        // Validar todos los campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                validateField(field);
                if (field.classList.contains('is-invalid')) {
                    isValid = false;
                }
            }
        });

        // Validar orden de fechas
        const fechaPublicacion = document.getElementById('fecha_publicacion').value;
        const fechaInicio = document.getElementById('fecha_inicio').value;

        if (fechaPublicacion && fechaInicio) {
            const datePublicacion = new Date(fechaPublicacion);
            const dateInicio = new Date(fechaInicio);

            if (dateInicio < datePublicacion) {
                isValid = false;
            }
        }

        if (!isValid) {
            // Scroll al primer campo con error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }

        return isValid;
    }

    // Mostrar modal de carga
    function showLoading() {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
    }

    // Validar URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Función para validar URL en tiempo real
    function validarUrl() {
        const linkInput = document.getElementById('link_grupo');
        const url = linkInput.value.trim();
        
        if (!url) {
            alert('Por favor ingrese una URL primero');
            linkInput.focus();
            return;
        }

        if (isValidUrl(url)) {
            linkInput.classList.remove('is-invalid');
            linkInput.classList.add('is-valid');
            removeCustomError(linkInput);
            
            // Mostrar feedback visual
            const button = linkInput.parentNode.querySelector('button');
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check text-success"></i>';
            
            setTimeout(() => {
                button.innerHTML = originalHtml;
            }, 2000);
        } else {
            linkInput.classList.add('is-invalid');
            showCustomError(linkInput, 'URL no válida');
            linkInput.focus();
        }
    }

    // Función para formato de texto (capitalizar primera letra)
    function capitalizeFirst(input) {
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }

    // Aplicar formato automático a campos de texto
    document.addEventListener('DOMContentLoaded', function() {
        const textFields = ['docente', 'curso', 'pagina_central', 'subpagina', 'area'];
        textFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    capitalizeFirst(this);
                });
            }
        });
    });

    // Atajos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl + S para guardar
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('btn-guardar').click();
        }
        
        // Escape para volver
        if (e.key === 'Escape') {
            if (confirm('¿Desea salir sin guardar?')) {
                window.location.href = "{{ route('competencias.index') }}";
            }
        }
    });

    // Prevenir pérdida de datos
    window.addEventListener('beforeunload', function(e) {
        if (!formSubmitted) {
            const formData = new FormData(document.getElementById('form-competencia'));
            let hasData = false;
            
            for (let [key, value] of formData.entries()) {
                if (value.trim()) {
                    hasData = true;
                    break;
                }
            }
            
            if (hasData) {
                e.preventDefault();
                e.returnValue = '';
            }
        }
    });
</script>
@endsection