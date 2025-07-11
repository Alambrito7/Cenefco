{{-- resources/views/modulos/materials/edit.blade.php - VERSIÓN MULTI-ARCHIVO --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-edit me-2"></i>Editar Material
            </h1>
            <p class="text-muted">Modificar información del material seleccionado</p>
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
                    <i class="fas fa-edit me-1"></i>Editar Material #{{ $material->id }}
                </li>
            </ol>
        </nav>

        <!-- Información actual del material -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-3">
                            <i class="fas fa-info-circle me-1"></i>Material Actual
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Tipo:</strong>
                                <span class="badge bg-{{ $material->getTypeColor() }} ms-1">
                                    <i class="{{ $material->getTypeIcon() }} me-1"></i>{{ $material->getTypeLabel() }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <strong>Área:</strong>
                                <span class="badge bg-info ms-1">{{ $material->rama }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Creado:</strong>
                                <small class="text-muted">{{ $material->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="col-md-3">
                                @if($material->isFile() && $material->file_path)
                                    <strong>Tamaño:</strong>
                                    <small class="text-muted">{{ $material->file_size }}</small>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Mostrar archivo/URL actual -->
                        @if($material->isFile() && $material->file_path)
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <i class="{{ $material->getTypeIcon() }} me-2 text-{{ $material->getTypeColor() }}"></i>
                                    <strong>Archivo actual:</strong>
                                    <span class="ms-2">{{ $material->file_name }}</span>
                                    <div class="ms-auto">
                                        <a href="{{ route('materials.download', $material) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </a>
                                        @if($material->isImage())
                                            <a href="{{ route('materials.preview', $material) }}" 
                                               class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="fas fa-eye me-1"></i>Vista Previa
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($material->isVideo() && $material->video_url)
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-video me-2 text-secondary"></i>
                                    <strong>URL actual:</strong>
                                    <a href="{{ $material->video_url }}" target="_blank" class="ms-2 text-decoration-none">
                                        {{ Str::limit($material->video_url, 50) }}
                                    </a>
                                    <div class="ms-auto">
                                        <a href="{{ $material->video_url }}" target="_blank" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-play me-1"></i>Ver Video
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Formulario de Edición
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data" id="materialForm">
                            @csrf
                            @method('PUT')
                            
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
                                            <option value="{{ $area }}" 
                                                {{ (old('rama', $material->rama) == $area) ? 'selected' : '' }}>
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
                                                    {{ old('type', $material->type) == $key ? 'selected' : '' }}>
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
                                          placeholder="Describe el contenido del material...">{{ old('description', $material->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Proporciona una descripción clara y detallada del material (mínimo 10 caracteres).
                                </div>
                            </div>

                            <!-- Archivo (para todos los tipos excepto video) -->
                            <div class="mb-4" id="fileSection" style="display: none;">
                                <label for="file" class="form-label fw-bold">
                                    <i class="fas fa-file me-1" id="fileIcon"></i>
                                    <span id="fileLabel">Archivo</span>
                                    <small class="text-muted">(Opcional - Solo si desea cambiar el archivo)</small>
                                </label>
                                
                                <input type="file" name="file" id="file" 
                                       class="form-control @error('file') is-invalid @enderror">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <div class="form-text" id="fileHelp">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="fileHelpText">Dejar vacío para mantener el archivo actual.</span>
                                </div>
                                
                                <!-- Preview del nuevo archivo -->
                                <div id="filePreview" class="mt-3" style="display: none;">
                                    <div class="alert alert-success">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file fa-2x me-3" id="previewIcon"></i>
                                            <div>
                                                <strong>Nuevo archivo seleccionado:</strong>
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
                                       value="{{ old('video_url', $material->video_url) }}"
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
                                        <strong>Video:</strong>
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

                            <!-- Información de fechas -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">
                                        <i class="fas fa-calendar-plus me-1"></i>Fecha de Creación
                                    </label>
                                    <input type="text" class="form-control" 
                                           value="{{ $material->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">
                                        <i class="fas fa-calendar-edit me-1"></i>Última Actualización
                                    </label>
                                    <input type="text" class="form-control" 
                                           value="{{ $material->updated_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>

                            <!-- Debug info -->
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Estado del formulario:</strong>
                                <span id="debugInfo">Formulario listo para edición</span>
                            </div>

                            <!-- Botones -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex gap-3 justify-content-between">
                                        <a href="{{ route('materials.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('materials.show', $material) }}" class="btn btn-info btn-lg">
                                                <i class="fas fa-eye me-2"></i>Ver Material
                                            </a>
                                            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                                                <i class="fas fa-save me-2"></i>Actualizar Material
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
</div>

<!-- Scripts mejorados para edición multi-archivo -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando JavaScript del formulario de edición multi-archivo...');
    
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

    // Material original para comparar cambios
    const originalType = '{{ $material->type }}';

    // Función para actualizar debug info
    function updateDebug(message) {
        debugInfo.textContent = message;
        console.log('📋 Debug:', message);
    }

    // Función para limpiar campos según el tipo
    function resetFieldsForType(type) {
        if (type === 'video') {
            fileInput.value = '';
            fileInput.removeAttribute('required');
            document.getElementById('filePreview').style.display = 'none';
            document.getElementById('imagePreview').style.display = 'none';
        } else {
            videoUrlInput.removeAttribute('required');
            if (type !== originalType) {
                // Solo limpiar video URL si se está cambiando de tipo
                videoUrlInput.value = '';
                document.getElementById('videoPreview').style.display = 'none';
            }
        }
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
            
            fileHelpText.textContent = `Archivos permitidos: ${extensions}. Tamaño máximo: ${maxSizeMB}MB. Dejar vacío para mantener el archivo actual.`;
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
    function toggleSections() {
        const selectedType = typeSelect.value;
        updateDebug(`Tipo seleccionado: ${selectedType}`);
        
        // Resetear campos según el tipo
        resetFieldsForType(selectedType);
        
        if (selectedType === 'video') {
            fileSection.style.display = 'none';
            videoSection.style.display = 'block';
            typeInfo.style.display = 'none';
            videoUrlInput.setAttribute('required', 'required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Video';
            updateDebug('Modo Video activado - URL requerida');
        } else if (selectedType) {
            fileSection.style.display = 'block';
            videoSection.style.display = 'none';
            videoUrlInput.removeAttribute('required');
            updateTypeInterface(selectedType);
            submitBtn.innerHTML = `<i class="fas fa-save me-2"></i>Actualizar ${fileTypeConfigs[selectedType].label}`;
            updateDebug(`Modo ${fileTypeConfigs[selectedType].label} activado`);
        } else {
            fileSection.style.display = 'none';
            videoSection.style.display = 'none';
            typeInfo.style.display = 'none';
            videoUrlInput.removeAttribute('required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Material';
            updateDebug('Esperando selección de tipo');
        }
    }

    // Event listener para cambio de tipo
    typeSelect.addEventListener('change', toggleSections);

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
            
            updateDebug(`Nuevo archivo seleccionado: ${file.name} (${formatFileSize(file.size)})`);
        } else {
            filePreview.style.display = 'none';
            imagePreview.style.display = 'none';
            updateDebug('Sin archivo nuevo seleccionado');
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
            
            // Validar archivo si se seleccionó uno nuevo
            if (fileInput.files[0]) {
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
        }
        
        // Mostrar indicador de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
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

    // Inicializar vista según el tipo actual
    toggleSections();
    
    // Inicializar preview del video si existe URL
    if (videoUrlInput.value) {
        videoUrlInput.dispatchEvent(new Event('input'));
    }
    
    updateDebug(`Formulario de edición inicializado - Tipo original: ${originalType}`);
    console.log('✅ JavaScript del formulario de edición multi-archivo cargado correctamente');
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

.form-control[readonly] {
    background-color: #f8f9fa;
    opacity: 1;
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

/* Estilos para información del material actual */
.bg-light .card-body {
    border-radius: 10px;
}

/* Hover effects */
.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

/* File input styling */
.form-control[type="file"] {
    padding: 0.5rem;
}

.form-control[type="file"]:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endsection