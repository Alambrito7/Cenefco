{{-- resources/views/modulos/materials/create.blade.php - VERSIÓN MULTI-ARCHIVO --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Material
            </h1>
            <p class="text-muted">Agregar nuevo archivo o enlace de video</p>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('materials.index') }}" class="text-decoration-none">
                        <i class="fas fa-folder-open me-1"></i>Materiales
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-plus me-1"></i>Nuevo Material
                </li>
            </ol>
        </nav>

        <!-- Alertas de errores -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error en el formulario:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Formulario -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Formulario de Nuevo Material
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" id="materialForm">
                            @csrf
                            
                            <!-- Información básica -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="rama" class="form-label fw-bold">
                                        <i class="fas fa-sitemap me-1 text-primary"></i>Área/Rama
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="rama" id="rama" class="form-select @error('rama') is-invalid @enderror" required>
                                        <option value="">Seleccionar área...</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area }}" {{ old('rama') == $area ? 'selected' : '' }}>
                                                {{ $area }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="type" class="form-label fw-bold">
                                        <i class="fas fa-file-alt me-1 text-success"></i>Tipo de Material
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Seleccionar tipo...</option>
                                        @foreach($fileTypes as $key => $config)
                                            <option value="{{ $key }}" 
                                                    data-extensions="{{ implode(',', $config['extensions']) }}"
                                                    data-max-size="{{ $config['max_size'] }}"
                                                    data-accept="{{ $config['accept'] }}"
                                                    {{ old('type') == $key ? 'selected' : '' }}>
                                                {{ $config['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1 text-info"></i>Descripción del Material
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" id="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="4" required 
                                          placeholder="Describe el contenido del material, su propósito y cualquier información relevante...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Proporciona una descripción clara y detallada del material (mínimo 10 caracteres).
                                </div>
                            </div>

                            <!-- Archivo (visible para todos los tipos excepto video) -->
                            <div class="mb-4" id="fileSection" style="display: none;">
                                <label for="file" class="form-label fw-bold">
                                    <i class="fas fa-file me-1" id="fileIcon"></i>
                                    <span id="fileLabel">Archivo</span>
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <input type="file" name="file" id="file" 
                                       class="form-control @error('file') is-invalid @enderror">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <div class="form-text" id="fileHelp">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="fileHelpText">Selecciona un archivo válido.</span>
                                </div>
                                
                                <!-- Preview del archivo -->
                                <div id="filePreview" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file fa-2x me-3" id="previewIcon"></i>
                                            <div>
                                                <strong>Archivo seleccionado:</strong>
                                                <span id="fileName"></span>
                                                <br>
                                                <small id="fileSize" class="text-muted"></small>
                                                <span id="fileMimeType" class="badge bg-secondary ms-2"></span>
                                            </div>
                                        </div>
                                        <!-- Preview especial para imágenes -->
                                        <div id="imagePreview" class="mt-3" style="display: none;">
                                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- URL del Video (solo visible cuando type = video) -->
                            <div class="mb-4" id="videoSection" style="display: none;">
                                <label for="video_url" class="form-label fw-bold">
                                    <i class="fas fa-video me-1 text-success"></i>URL del Video
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="url" name="video_url" id="video_url" 
                                       class="form-control @error('video_url') is-invalid @enderror" 
                                       value="{{ old('video_url') }}"
                                       placeholder="https://www.youtube.com/watch?v=... o https://vimeo.com/...">
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ingresa la URL completa del video (YouTube, Vimeo, etc.).
                                </div>
                                
                                <!-- Preview del video -->
                                <div id="videoPreview" class="mt-3" style="display: none;">
                                    <div class="alert alert-success">
                                        <i class="fas fa-video me-2"></i>
                                        <strong>Video detectado:</strong>
                                        <a href="#" id="videoLink" target="_blank" class="alert-link">Ver video</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de límites según tipo -->
                            <div class="mb-4" id="typeInfo" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-3">
                                            <i class="fas fa-info-circle me-1"></i>Información del Tipo Seleccionado
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Extensiones permitidas:</strong>
                                                <div id="allowedExtensions" class="mt-1"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Tamaño máximo:</strong>
                                                <div id="maxFileSize" class="mt-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Debug info -->
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Estado del formulario:</strong>
                                <span id="debugInfo">Formulario listo para usar</span>
                            </div>

                            <!-- Botones -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="{{ route('materials.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>Guardar Material
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
</div>

<!-- Scripts mejorados para múltiples tipos de archivo -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando JavaScript del formulario multi-archivo...');
    
    const typeSelect = document.getElementById('type');
    const fileSection = document.getElementById('fileSection');
    const videoSection = document.getElementById('videoSection');
    const typeInfo = document.getElementById('typeInfo');
    const fileInput = document.getElementById('file');
    const videoUrlInput = document.getElementById('video_url');
    const submitBtn = document.getElementById('submitBtn');
    const debugInfo = document.getElementById('debugInfo');
    const form = document.getElementById('materialForm');

    // Configuración de tipos de archivo
    const fileTypeConfigs = {
        pdf: {
            icon: 'fas fa-file-pdf',
            color: 'danger',
            label: 'Archivo PDF',
            extensions: ['pdf'],
            maxSize: 10240
        },
        image: {
            icon: 'fas fa-image',
            color: 'success',
            label: 'Imagen',
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            maxSize: 5120
        },
        document: {
            icon: 'fas fa-file-word',
            color: 'primary',
            label: 'Documento Word',
            extensions: ['doc', 'docx'],
            maxSize: 15360
        },
        executable: {
            icon: 'fas fa-cog',
            color: 'warning',
            label: 'Programa/Ejecutable',
            extensions: ['exe', 'msi'],
            maxSize: 512000
        },
        compressed: {
            icon: 'fas fa-file-archive',
            color: 'info',
            label: 'Archivo Comprimido',
            extensions: ['zip', 'rar', '7z', 'tar', 'gz'],
            maxSize: 102400
        },
        video: {
            icon: 'fas fa-video',
            color: 'secondary',
            label: 'Video (URL)',
            extensions: [],
            maxSize: 0
        }
    };

    // Función para actualizar debug info
    function updateDebug(message) {
        debugInfo.textContent = message;
        console.log('📋 Debug:', message);
    }

    // Función para resetear campos
    function resetFields() {
        fileInput.value = '';
        fileInput.removeAttribute('required');
        document.getElementById('filePreview').style.display = 'none';
        document.getElementById('imagePreview').style.display = 'none';
        
        videoUrlInput.value = '';
        videoUrlInput.removeAttribute('required');
        document.getElementById('videoPreview').style.display = 'none';
    }

    // Función para actualizar la interfaz según el tipo
    function updateTypeInterface(selectedType) {
        const config = fileTypeConfigs[selectedType];
        if (!config) return;

        // Actualizar iconos y etiquetas
        const fileIcon = document.getElementById('fileIcon');
        const fileLabel = document.getElementById('fileLabel');
        const fileHelpText = document.getElementById('fileHelpText');
        
        fileIcon.className = config.icon + ' me-1 text-' + config.color;
        fileLabel.textContent = config.label;
        
        // Actualizar información del tipo
        if (selectedType !== 'video') {
            const extensions = config.extensions.join(', ').toUpperCase();
            const maxSizeMB = Math.round(config.maxSize / 1024);
            
            fileHelpText.textContent = `Archivos permitidos: ${extensions}. Tamaño máximo: ${maxSizeMB}MB.`;
            fileInput.accept = '.' + config.extensions.join(',.');
            
            // Mostrar información detallada
            document.getElementById('allowedExtensions').innerHTML = 
                config.extensions.map(ext => `<span class="badge bg-${config.color} me-1">.${ext}</span>`).join('');
            document.getElementById('maxFileSize').innerHTML = 
                `<span class="badge bg-secondary">${maxSizeMB}MB</span>`;
            
            typeInfo.style.display = 'block';
        } else {
            typeInfo.style.display = 'none';
        }
    }

    // Mostrar/ocultar secciones según el tipo
    typeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        updateDebug(`Tipo seleccionado: ${selectedType}`);
        
        // Resetear campos
        fileSection.style.display = 'none';
        videoSection.style.display = 'none';
        typeInfo.style.display = 'none';
        resetFields();
        
        if (selectedType === 'video') {
            videoSection.style.display = 'block';
            videoUrlInput.setAttribute('required', 'required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Video';
            updateDebug('Modo Video activado - URL requerida');
        } else if (selectedType) {
            fileSection.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            updateTypeInterface(selectedType);
            submitBtn.innerHTML = `<i class="fas fa-save me-2"></i>Guardar ${fileTypeConfigs[selectedType].label}`;
            updateDebug(`Modo ${fileTypeConfigs[selectedType].label} activado - Archivo requerido`);
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Material';
            updateDebug('Esperando selección de tipo');
        }
    });

    // Preview del archivo
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        const filePreview = document.getElementById('filePreview');
        const imagePreview = document.getElementById('imagePreview');
        
        if (file) {
            // Información básica del archivo
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = `Tamaño: ${formatFileSize(file.size)}`;
            document.getElementById('fileMimeType').textContent = file.type;
            
            // Icono según el tipo
            const previewIcon = document.getElementById('previewIcon');
            const selectedType = typeSelect.value;
            const config = fileTypeConfigs[selectedType];
            if (config) {
                previewIcon.className = config.icon + ' fa-2x me-3 text-' + config.color;
            }
            
            filePreview.style.display = 'block';
            
            // Preview especial para imágenes
            if (selectedType === 'image' && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
            
            updateDebug(`Archivo seleccionado: ${file.name} (${formatFileSize(file.size)})`);
        } else {
            filePreview.style.display = 'none';
            imagePreview.style.display = 'none';
            updateDebug('Sin archivo seleccionado');
        }
    });

    // Preview del video
    videoUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        const videoPreview = document.getElementById('videoPreview');
        const videoLink = document.getElementById('videoLink');
        
        if (url && isValidUrl(url)) {
            videoLink.href = url;
            videoLink.textContent = url;
            videoPreview.style.display = 'block';
            updateDebug(`URL válida: ${url}`);
        } else {
            videoPreview.style.display = 'none';
            if (url) {
                updateDebug(`URL inválida: ${url}`);
            } else {
                updateDebug('Sin URL de video');
            }
        }
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        const type = typeSelect.value;
        updateDebug('Intentando enviar formulario...');
        
        if (!type) {
            e.preventDefault();
            alert('Por favor, selecciona un tipo de material.');
            updateDebug('❌ Error: Tipo no seleccionado');
            return false;
        }
        
        // Limpiar campos conflictivos
        if (type === 'video') {
            fileInput.removeAttribute('name');
            
            if (!videoUrlInput.value.trim()) {
                e.preventDefault();
                alert('Por favor, ingresa la URL del video.');
                updateDebug('❌ Error: URL de video vacía');
                return false;
            }
            
            if (!isValidUrl(videoUrlInput.value.trim())) {
                e.preventDefault();
                alert('Por favor, ingresa una URL válida.');
                updateDebug('❌ Error: URL de video inválida');
                return false;
            }
        } else {
            videoUrlInput.removeAttribute('name');
            
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Por favor, selecciona un archivo.');
                updateDebug('❌ Error: Archivo no seleccionado');
                return false;
            }
            
            // Validar extensión
            const file = fileInput.files[0];
            const config = fileTypeConfigs[type];
            const extension = file.name.split('.').pop().toLowerCase();
            
            if (!config.extensions.includes(extension)) {
                e.preventDefault();
                alert(`El archivo debe ser de tipo: ${config.extensions.join(', ')}`);
                updateDebug('❌ Error: Extensión no válida');
                return false;
            }
            
            // Validar tamaño
            const fileSizeKB = file.size / 1024;
            if (fileSizeKB > config.maxSize) {
                e.preventDefault();
                alert(`El archivo no debe exceder ${Math.round(config.maxSize / 1024)}MB`);
                updateDebug('❌ Error: Archivo muy grande');
                return false;
            }
        }
        
        // Mostrar indicador de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        updateDebug('✅ Formulario válido, enviando...');
        
        return true;
    });

    // Funciones auxiliares
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function isValidUrl(string) {
        try {
            const url = new URL(string);
            return url.protocol === 'http:' || url.protocol === 'https:';
        } catch (_) {
            return false;
        }
    }

    // Inicializar si hay valor previo
    if (typeSelect.value) {
        typeSelect.dispatchEvent(new Event('change'));
        updateDebug(`Inicializado con tipo: ${typeSelect.value}`);
    } else {
        updateDebug('Formulario multi-archivo inicializado correctamente');
    }
    
    console.log('✅ JavaScript del formulario multi-archivo cargado correctamente');
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.form-label {
    margin-bottom: 0.75rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.alert {
    border-radius: 10px;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 1rem;
}

.text-danger {
    color: #dc3545 !important;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

/* Animaciones */
#fileSection,
#videoSection,
#typeInfo {
    transition: all 0.3s ease;
}

.btn:disabled {
    opacity: 0.6;
}

/* Preview de imagen */
.img-thumbnail {
    border: 2px solid #dee2e6;
    border-radius: 8px;
}

/* Badges para extensiones */
.badge {
    font-size: 0.75em;
}
</style>
@endsection