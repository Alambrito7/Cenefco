{{-- resources/views/modulos/materials/create.blade.php - VERSIÓN CORREGIDA --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Material
            </h1>
            <p class="text-muted">Agregar nuevo archivo PDF o enlace de video</p>
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
            <div class="col-lg-8">
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
                                        <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>
                                            📄 Archivo PDF
                                        </option>
                                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>
                                            🎥 Enlace de Video
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
                                          placeholder="Describe el contenido del material, su propósito y cualquier información relevante...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Proporciona una descripción clara y detallada del material.
                                </div>
                            </div>

                            <!-- Archivo PDF (solo visible cuando type = pdf) -->
                            <div class="mb-4" id="pdfSection" style="display: none;">
                                <label for="file" class="form-label fw-bold">
                                    <i class="fas fa-file-pdf me-1 text-danger"></i>Archivo PDF
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="file" id="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       accept=".pdf">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Solo archivos PDF. Tamaño máximo: 10MB.
                                </div>
                                
                                <!-- Preview del archivo -->
                                <div id="filePreview" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <strong>Archivo seleccionado:</strong>
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
                                <input type="url" name="video_url" id="video_url" 
                                       class="form-control @error('video_url') is-invalid @enderror" 
                                       value="{{ old('video_url') }}"
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
                                        <strong>Video detectado:</strong>
                                        <a href="#" id="videoLink" target="_blank" class="alert-link">Ver video</a>
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

<!-- Scripts mejorados -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando JavaScript del formulario de materiales...');
    
    const typeSelect = document.getElementById('type');
    const pdfSection = document.getElementById('pdfSection');
    const videoSection = document.getElementById('videoSection');
    const fileInput = document.getElementById('file');
    const videoUrlInput = document.getElementById('video_url');
    const submitBtn = document.getElementById('submitBtn');
    const debugInfo = document.getElementById('debugInfo');
    const form = document.getElementById('materialForm');

    // Función para actualizar debug info
    function updateDebug(message) {
        debugInfo.textContent = message;
        console.log('📋 Debug:', message);
    }

    // Función para limpiar y resetear campos
    function resetFields() {
        // Limpiar archivo
        fileInput.value = '';
        fileInput.removeAttribute('required');
        document.getElementById('filePreview').style.display = 'none';
        
        // Limpiar video URL
        videoUrlInput.value = '';
        videoUrlInput.removeAttribute('required');
        document.getElementById('videoPreview').style.display = 'none';
    }

    // Mostrar/ocultar secciones según el tipo
    typeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        updateDebug(`Tipo seleccionado: ${selectedType}`);
        
        // Primero ocultar todo y limpiar
        pdfSection.style.display = 'none';
        videoSection.style.display = 'none';
        resetFields();
        
        if (selectedType === 'pdf') {
            pdfSection.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar PDF';
            updateDebug('Modo PDF activado - Archivo requerido');
        } else if (selectedType === 'video') {
            videoSection.style.display = 'block';
            videoUrlInput.setAttribute('required', 'required');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Video';
            updateDebug('Modo Video activado - URL requerida');
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Material';
            updateDebug('Esperando selección de tipo');
        }
    });

    // Preview del archivo PDF
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        const filePreview = document.getElementById('filePreview');
        
        if (file) {
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = `Tamaño: ${formatFileSize(file.size)}`;
            filePreview.style.display = 'block';
            updateDebug(`Archivo seleccionado: ${file.name} (${formatFileSize(file.size)})`);
        } else {
            filePreview.style.display = 'none';
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

    // VALIDACIÓN CRÍTICA DEL FORMULARIO
    form.addEventListener('submit', function(e) {
        const type = typeSelect.value;
        updateDebug('Intentando enviar formulario...');
        
        // Validación básica
        if (!type) {
            e.preventDefault();
            alert('Por favor, selecciona un tipo de material.');
            updateDebug('❌ Error: Tipo no seleccionado');
            return false;
        }
        
        // CRUCIAL: Limpiar el campo que no corresponde al tipo seleccionado
        if (type === 'pdf') {
            // Limpiar URL de video para evitar conflictos
            videoUrlInput.value = '';
            videoUrlInput.removeAttribute('name');
            
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Por favor, selecciona un archivo PDF.');
                updateDebug('❌ Error: Archivo PDF no seleccionado');
                return false;
            }
        } else if (type === 'video') {
            // Limpiar archivo para evitar conflictos
            fileInput.value = '';
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

    // Inicializar si hay valor previo (en caso de errores de validación)
    if (typeSelect.value) {
        typeSelect.dispatchEvent(new Event('change'));
        updateDebug(`Inicializado con tipo: ${typeSelect.value}`);
    } else {
        updateDebug('Formulario inicializado correctamente');
    }
    
    console.log('✅ JavaScript del formulario cargado correctamente');
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
</style>
@endsection