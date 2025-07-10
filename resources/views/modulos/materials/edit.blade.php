{{-- resources/views/modulos/materials/edit.blade.php --}}

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
            <div class="col-lg-8">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-3">
                            <i class="fas fa-info-circle me-1"></i>Material Actual
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Tipo:</strong>
                                @if($material->isPdf())
                                    <span class="badge bg-danger ms-1">
                                        <i class="fas fa-file-pdf me-1"></i>PDF
                                    </span>
                                @else
                                    <span class="badge bg-success ms-1">
                                        <i class="fas fa-video me-1"></i>Video
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <strong>Área:</strong>
                                <span class="badge bg-info ms-1">{{ $material->rama }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Creado:</strong>
                                <small class="text-muted">{{ $material->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
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
                                        <option value="pdf" {{ old('type', $material->type) == 'pdf' ? 'selected' : '' }}>
                                            Archivo PDF
                                        </option>
                                        <option value="video" {{ old('type', $material->type) == 'video' ? 'selected' : '' }}>
                                            Enlace de Video
                                        </option>
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
                            </div>

                            <!-- Archivo PDF (solo visible cuando type = pdf) -->
                            <div class="mb-4" id="pdfSection" style="display: none;">
                                <label for="file" class="form-label fw-bold">
                                    <i class="fas fa-file-pdf me-1 text-danger"></i>Archivo PDF
                                    <small class="text-muted">(Opcional - Solo si desea cambiar el archivo)</small>
                                </label>
                                
                                <!-- Archivo actual -->
                                @if($material->isPdf() && $material->file_path)
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <strong>Archivo actual:</strong> {{ $material->file_name }}
                                        <br>
                                        <small>Tamaño: {{ $material->file_size }}</small>
                                        <div class="mt-2">
                                            <a href="{{ route('materials.download', $material) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i>Descargar archivo actual
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file" name="file" id="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       accept=".pdf">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Solo archivos PDF. Tamaño máximo: 10MB. Dejar vacío para mantener el archivo actual.
                                </div>
                                
                                <!-- Preview del nuevo archivo -->
                                <div id="filePreview" class="mt-3" style="display: none;">
                                    <div class="alert alert-success">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <strong>Nuevo archivo seleccionado:</strong>
                                        <span id="fileName"></span>
                                        <br>
                                        <small id="fileSize"></small>
                                    </div>
                                </div>
                            </div>

                            <!-- URL del Video (solo visible cuando type = video) -->
                            <div class="mb-4" id="videoSection" style="display: none;">
                                <label for="video_url" class="form-label fw-bold">
                                    <i class="fas fa-video me-1 text-success"></i>URL del Video
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <!-- URL actual -->
                                @if($material->isVideo() && $material->video_url)
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-video me-2"></i>
                                        <strong>URL actual:</strong>
                                        <a href="{{ $material->video_url }}" target="_blank" class="alert-link">
                                            {{ $material->video_url }}
                                        </a>
                                    </div>
                                @endif
                                
                                <input type="url" name="video_url" id="video_url" 
                                       class="form-control @error('video_url') is-invalid @enderror" 
                                       value="{{ old('video_url', $material->video_url) }}"
                                       placeholder="https://www.youtube.com/watch?v=...">
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

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando JavaScript del formulario de edición...');
    
    const typeSelect = document.getElementById('type');
    const pdfSection = document.getElementById('pdfSection');
    const videoSection = document.getElementById('videoSection');
    const fileInput = document.getElementById('file');
    const videoUrlInput = document.getElementById('video_url');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('materialForm');

    // Función para limpiar campos según el tipo
    function resetFieldsForType(type) {
        if (type === 'pdf') {
            // Si cambia a PDF, limpiar video URL pero no remover el campo
            // (solo limpiar si realmente está cambiando de tipo)
            if (videoUrlInput.value && type !== '{{ $material->type }}') {
                videoUrlInput.value = '';
            }
            videoUrlInput.removeAttribute('required');
        } else if (type === 'video') {
            // Si cambia a video, limpiar archivo
            if (fileInput.value) {
                fileInput.value = '';
                document.getElementById('filePreview').style.display = 'none';
            }
            fileInput.removeAttribute('required');
        }
    }

    // Mostrar/ocultar secciones según el tipo
    function toggleSections() {
        const selectedType = typeSelect.value;
        console.log('Tipo seleccionado:', selectedType);
        
        // Resetear campos según el tipo
        resetFieldsForType(selectedType);
        
        if (selectedType === 'pdf') {
            pdfSection.style.display = 'block';
            videoSection.style.display = 'none';
            videoUrlInput.removeAttribute('required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar PDF';
        } else if (selectedType === 'video') {
            pdfSection.style.display = 'none';
            videoSection.style.display = 'block';
            videoUrlInput.setAttribute('required', 'required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Video';
        } else {
            pdfSection.style.display = 'none';
            videoSection.style.display = 'none';
            videoUrlInput.removeAttribute('required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Actualizar Material';
        }
    }

    // Event listener para cambio de tipo
    typeSelect.addEventListener('change', toggleSections);

    // Preview del archivo PDF
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        const filePreview = document.getElementById('filePreview');
        
        if (file) {
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = `Tamaño: ${formatFileSize(file.size)}`;
            filePreview.style.display = 'block';
            console.log('Archivo seleccionado:', file.name);
        } else {
            filePreview.style.display = 'none';
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
            console.log('URL válida:', url);
        } else {
            videoPreview.style.display = 'none';
        }
    });

    // VALIDACIÓN CRÍTICA DEL FORMULARIO
    form.addEventListener('submit', function(e) {
        const type = typeSelect.value;
        console.log('Enviando formulario con tipo:', type);
        
        if (!type) {
            e.preventDefault();
            alert('Por favor, selecciona un tipo de material.');
            return false;
        }
        
        // CRUCIAL: Limpiar campos conflictivos antes del envío
        if (type === 'pdf') {
            // Si es PDF, asegurar que video_url esté vacío o se remueva
            if (videoUrlInput.value.trim() === '') {
                videoUrlInput.removeAttribute('name');
            }
        } else if (type === 'video') {
            // Si es video, verificar que tenga URL válida
            if (!videoUrlInput.value.trim()) {
                e.preventDefault();
                alert('Por favor, ingresa la URL del video.');
                return false;
            }
            
            if (!isValidUrl(videoUrlInput.value.trim())) {
                e.preventDefault();
                alert('Por favor, ingresa una URL válida.');
                return false;
            }
            
            // Limpiar archivo si se seleccionó alguno
            if (fileInput.value) {
                fileInput.removeAttribute('name');
            }
        }
        
        // Mostrar indicador de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        console.log('✅ Formulario válido, enviando...');
        
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
    
    console.log('✅ JavaScript del formulario de edición cargado correctamente');
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
#pdfSection,
#videoSection {
    transition: all 0.3s ease;
}

.btn:disabled {
    opacity: 0.6;
}

.form-control[readonly] {
    background-color: #f8f9fa;
    opacity: 1;
}
</style>
@endsection