@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Competencia
                    </h2>
                </div>
                
                <div class="card-body p-5">
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

                    {{-- Mensaje de éxito --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('competencias.update', $competencia) }}" method="POST" id="form-competencia" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Sección: Información de Ubicación --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                Información de Ubicación
                            </h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="pagina_central" 
                                               id="pagina_central"
                                               class="form-control @error('pagina_central') is-invalid @enderror" 
                                               value="{{ old('pagina_central', $competencia->pagina_central) }}" 
                                               placeholder="Centro de Competencias"
                                               required>
                                        <label for="pagina_central">
                                            <i class="fas fa-home me-1"></i>Página Central
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('pagina_central')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="subpagina" 
                                               id="subpagina"
                                               class="form-control @error('subpagina') is-invalid @enderror" 
                                               value="{{ old('subpagina', $competencia->subpagina) }}" 
                                               placeholder="Capacitación Técnica"
                                               required>
                                        <label for="subpagina">
                                            <i class="fas fa-sitemap me-1"></i>Subpágina
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('subpagina')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Información Académica --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Información Académica
                            </h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="area" 
                                               id="area"
                                               class="form-control @error('area') is-invalid @enderror" 
                                               value="{{ old('area', $competencia->area) }}" 
                                               placeholder="Tecnología, Administración, Marketing..."
                                               required>
                                        <label for="area">
                                            <i class="fas fa-folder me-1"></i>Área
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="curso" 
                                               id="curso"
                                               class="form-control @error('curso') is-invalid @enderror" 
                                               value="{{ old('curso', $competencia->curso) }}" 
                                               placeholder="Desarrollo Web Avanzado"
                                               required>
                                        <label for="curso">
                                            <i class="fas fa-book me-1"></i>Curso
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('curso')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" 
                                               name="docente" 
                                               id="docente"
                                               class="form-control @error('docente') is-invalid @enderror" 
                                               value="{{ old('docente', $competencia->docente) }}" 
                                               placeholder="Juan Pérez"
                                               required>
                                        <label for="docente">
                                            <i class="fas fa-user-tie me-1"></i>Docente
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('docente')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Fechas --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                Cronograma
                            </h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" 
                                               name="fecha_publicacion" 
                                               id="fecha_publicacion"
                                               class="form-control @error('fecha_publicacion') is-invalid @enderror" 
                                               value="{{ old('fecha_publicacion', $competencia->fecha_publicacion) }}" 
                                               required>
                                        <label for="fecha_publicacion">
                                            <i class="fas fa-calendar-plus me-1"></i>Fecha de Publicación
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('fecha_publicacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>Fecha cuando se publicará la competencia
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" 
                                               name="fecha_inicio" 
                                               id="fecha_inicio"
                                               class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                               value="{{ old('fecha_inicio', $competencia->fecha_inicio) }}" 
                                               required>
                                        <label for="fecha_inicio">
                                            <i class="fas fa-play me-1"></i>Fecha de Inicio
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('fecha_inicio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>Fecha cuando comenzará la competencia
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Configuración --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-cogs me-2 text-primary"></i>
                                Configuración
                            </h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">
                                        <i class="fas fa-link me-1"></i>Link del Grupo
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-external-link-alt"></i>
                                        </span>
                                        <input type="url" 
                                               name="link_grupo" 
                                               id="link_grupo"
                                               class="form-control @error('link_grupo') is-invalid @enderror" 
                                               value="{{ old('link_grupo', $competencia->link_grupo) }}" 
                                               placeholder="https://ejemplo.com/grupo"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn-validar-url" onclick="validarUrl()">
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
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="estado" 
                                                id="estado"
                                                class="form-select @error('estado') is-invalid @enderror" 
                                                required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="testeo" {{ (old('estado', $competencia->estado) === 'testeo') ? 'selected' : '' }}>
                                                🧪 Testeo
                                            </option>
                                            <option value="ejecutado" {{ (old('estado', $competencia->estado) === 'ejecutado') ? 'selected' : '' }}>
                                                ✅ Ejecutado
                                            </option>
                                            <option value="cancelado" {{ (old('estado', $competencia->estado) === 'cancelado') ? 'selected' : '' }}>
                                                ❌ Cancelado
                                            </option>
                                            <option value="sin respuesta" {{ (old('estado', $competencia->estado) === 'sin respuesta') ? 'selected' : '' }}>
                                                ⏳ Sin respuesta
                                            </option>
                                        </select>
                                        <label for="estado">
                                            <i class="fas fa-flag me-1"></i>Estado
                                            <span class="text-danger">*</span>
                                        </label>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex justify-content-center gap-3 mt-5">
                            <button class="btn btn-success btn-lg px-5" type="submit" id="btn-actualizar">
                                <i class="fas fa-save me-2"></i>Actualizar Competencia
                            </button>
                            <a href="{{ route('competencias.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="validationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-info-circle text-primary me-2"></i>
            <strong class="me-auto">Información</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

{{-- Loading Modal --}}
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Actualizando...</span>
                </div>
                <h5 class="mb-2">Actualizando competencia...</h5>
                <p class="text-muted mb-0">Por favor espere un momento</p>
            </div>
        </div>
    </div>
</div>

{{-- Estilos personalizados --}}
<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 2rem;
        border-left: 4px solid #007bff;
    }
    
    .section-title {
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
    }
    
    .form-floating > label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn-lg {
        padding: 0.75rem 2rem;
        font-weight: 500;
        border-radius: 8px;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    
    .input-group-text {
        background-color: #e9ecef;
        border-color: #ced4da;
    }
    
    .is-valid {
        border-color: #28a745;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .toast {
        min-width: 300px;
    }
    
    .spinner-border {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

{{-- SCRIPTS --}}
<script>
    // Configuración global
    const APP_CONFIG = {
        formSubmitted: false,
        validationRules: {
            pagina_central: { minLength: 3, required: true },
            subpagina: { minLength: 3, required: true },
            area: { minLength: 2, required: true },
            curso: { minLength: 3, required: true },
            docente: { minLength: 2, required: true },
            link_grupo: { type: 'url', required: true },
            fecha_publicacion: { type: 'date', required: true },
            fecha_inicio: { type: 'date', required: true },
            estado: { required: true }
        }
    };

    // Clase para manejar el formulario
    class CompetenciaForm {
        constructor() {
            this.form = document.getElementById('form-competencia');
            this.loadingModal = null;
            this.validationToast = null;
            this.init();
        }

        init() {
            this.setupComponents();
            this.setupEventListeners();
            this.setupValidation();
            this.setupKeyboardShortcuts();
            this.autoFormatFields();
        }

        setupComponents() {
            // Inicializar modal de carga
            this.loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
            
            // Inicializar toast
            this.validationToast = new bootstrap.Toast(document.getElementById('validationToast'));
            
            // Auto-dismiss alertas
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 8000);
        }

        setupEventListeners() {
            // Validación en tiempo real
            this.form.addEventListener('input', (e) => this.validateField(e.target));
            this.form.addEventListener('change', (e) => this.validateField(e.target));
            
            // Envío del formulario
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            
            // Validación de fechas
            this.setupDateValidation();
            
            // Prevenir pérdida de datos
            window.addEventListener('beforeunload', (e) => this.handleBeforeUnload(e));
        }

        setupValidation() {
            // Configurar validación para cada campo
            Object.keys(APP_CONFIG.validationRules).forEach(fieldName => {
                const field = this.form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.addEventListener('blur', () => this.validateField(field));
                }
            });
        }

        validateField(field) {
            const value = field.value.trim();
            const fieldName = field.name;
            const rules = APP_CONFIG.validationRules[fieldName];

            if (!rules) return;

            // Limpiar clases previas
            field.classList.remove('is-valid', 'is-invalid');
            this.removeCustomError(field);

            // Validar campo requerido
            if (rules.required && !value) {
                if (field.hasAttribute('data-touched')) {
                    field.classList.add('is-invalid');
                    this.showCustomError(field, 'Este campo es requerido');
                }
                return false;
            }

            // Validaciones específicas
            let isValid = true;
            let errorMessage = '';

            if (value) {
                if (rules.minLength && value.length < rules.minLength) {
                    isValid = false;
                    errorMessage = `Debe tener al menos ${rules.minLength} caracteres`;
                }

                if (rules.type === 'url' && !this.isValidUrl(value)) {
                    isValid = false;
                    errorMessage = 'Ingrese una URL válida';
                }

                if (rules.type === 'date' && !this.isValidDate(value)) {
                    isValid = false;
                    errorMessage = 'Ingrese una fecha válida';
                }
            }

            // Aplicar resultado
            if (isValid && value) {
                field.classList.add('is-valid');
            } else if (!isValid) {
                field.classList.add('is-invalid');
                this.showCustomError(field, errorMessage);
            }

            // Marcar campo como tocado
            field.setAttribute('data-touched', 'true');
            return isValid;
        }

        setupDateValidation() {
            const fechaPublicacion = document.getElementById('fecha_publicacion');
            const fechaInicio = document.getElementById('fecha_inicio');

            fechaPublicacion.addEventListener('change', () => {
                if (fechaPublicacion.value) {
                    fechaInicio.setAttribute('min', fechaPublicacion.value);
                    this.validateDateOrder();
                }
            });

            fechaInicio.addEventListener('change', () => this.validateDateOrder());
        }

        validateDateOrder() {
            const fechaPublicacion = document.getElementById('fecha_publicacion').value;
            const fechaInicio = document.getElementById('fecha_inicio').value;

            if (fechaPublicacion && fechaInicio) {
                const datePublicacion = new Date(fechaPublicacion);
                const dateInicio = new Date(fechaInicio);

                if (dateInicio < datePublicacion) {
                    const fechaInicioField = document.getElementById('fecha_inicio');
                    fechaInicioField.classList.add('is-invalid');
                    this.showCustomError(fechaInicioField, 
                        'La fecha de inicio debe ser posterior a la fecha de publicación');
                    return false;
                } else {
                    const fechaInicioField = document.getElementById('fecha_inicio');
                    fechaInicioField.classList.remove('is-invalid');
                    if (fechaInicio) {
                        fechaInicioField.classList.add('is-valid');
                    }
                    this.removeCustomError(fechaInicioField);
                    return true;
                }
            }
            return true;
        }

        handleSubmit(e) {
            e.preventDefault();
            
            if (APP_CONFIG.formSubmitted) {
                return false;
            }

            if (this.validateForm()) {
                APP_CONFIG.formSubmitted = true;
                this.showLoading();
                
                // Simular delay para mejor UX
                setTimeout(() => {
                    this.form.submit();
                }, 1500);
            } else {
                this.showToast('Por favor corrija los errores antes de continuar', 'error');
            }
        }

        validateForm() {
            let isValid = true;
            const errors = [];

            // Validar todos los campos
            Object.keys(APP_CONFIG.validationRules).forEach(fieldName => {
                const field = this.form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.setAttribute('data-touched', 'true');
                    if (!this.validateField(field)) {
                        isValid = false;
                        errors.push(fieldName);
                    }
                }
            });

            // Validar orden de fechas
            if (!this.validateDateOrder()) {
                isValid = false;
            }

            // Scroll al primer error
            if (!isValid && errors.length > 0) {
                const firstErrorField = this.form.querySelector(`[name="${errors[0]}"]`);
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
            }

            return isValid;
        }

        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ctrl + S para guardar
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    document.getElementById('btn-actualizar').click();
                }
                
                // Escape para cancelar
                if (e.key === 'Escape') {
                    if (confirm('¿Desea salir sin guardar los cambios?')) {
                        window.location.href = "{{ route('competencias.index') }}";
                    }
                }
            });
        }

        autoFormatFields() {
            const textFields = ['docente', 'curso', 'pagina_central', 'subpagina', 'area'];
            textFields.forEach(fieldName => {
                const field = this.form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.addEventListener('blur', () => {
                        field.value = this.capitalizeFirst(field.value);
                    });
                }
            });
        }

        handleBeforeUnload(e) {
            if (!APP_CONFIG.formSubmitted && this.hasFormChanges()) {
                e.preventDefault();
                e.returnValue = '';
            }
        }

        hasFormChanges() {
            const formData = new FormData(this.form);
            let hasChanges = false;
            
            for (let [key, value] of formData.entries()) {
                if (value.trim() && key !== '_token' && key !== '_method') {
                    hasChanges = true;
                    break;
                }
            }
            
            return hasChanges;
        }

        // Métodos auxiliares
        showCustomError(field, message) {
            this.removeCustomError(field);
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback custom-error';
            errorDiv.textContent = message;
            
            field.parentNode.appendChild(errorDiv);
        }

        removeCustomError(field) {
            const existingError = field.parentNode.querySelector('.custom-error');
            if (existingError) {
                existingError.remove();
            }
        }

        showLoading() {
            this.loadingModal.show();
        }

        showToast(message, type = 'info') {
            const toastBody = document.querySelector('#validationToast .toast-body');
            const toastHeader = document.querySelector('#validationToast .toast-header i');
            
            toastBody.textContent = message;
            
            // Cambiar icono según tipo
            toastHeader.className = type === 'error' ? 'fas fa-exclamation-triangle text-danger me-2' : 'fas fa-info-circle text-primary me-2';
            
            this.validationToast.show();
        }

        isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        isValidDate(dateString) {
            return !isNaN(Date.parse(dateString));
        }

        capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    }

    // Funciones globales para mantener compatibilidad
    function validarUrl() {
        const linkInput = document.getElementById('link_grupo');
        const url = linkInput.value.trim();
        
        if (!url) {
            competenciaForm.showToast('Por favor ingrese una URL primero', 'error');
            linkInput.focus();
            return;
        }

        if (competenciaForm.isValidUrl(url)) {
            linkInput.classList.remove('is-invalid');
            linkInput.classList.add('is-valid');
            competenciaForm.removeCustomError(linkInput);
            
            // Mostrar feedback visual
            const button = document.getElementById('btn-validar-url');
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check text-success"></i>';
            
            setTimeout(() => {
                button.innerHTML = originalHtml;
            }, 2000);
            
            competenciaForm.showToast('URL válida', 'success');
        } else {
            linkInput.classList.add('is-invalid');
            competenciaForm.showCustomError(linkInput, 'URL no válida');
            linkInput.focus();
        }
    }

    // Inicializar cuando se carga la página
    let competenciaForm;
    document.addEventListener('DOMContentLoaded', function() {
        competenciaForm = new CompetenciaForm();
    });
</script>
@endsection