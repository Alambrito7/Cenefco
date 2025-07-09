@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title mb-0 text-center">
                        <i class="fas fa-truck me-2"></i>Formulario de Entrega
                    </h2>
                </div>
                <div class="card-body">
                    <!-- Mostrar alerta de error si el número de transacción es duplicado -->
                    @if ($errors->has('nro_transaccion_cd'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{ $errors->first('nro_transaccion_cd') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Mostrar otros errores de validación -->
                    @if ($errors->any() && !$errors->has('nro_transaccion_cd'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Por favor, corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('entrega_materials.store', $venta->id) }}" method="POST" enctype="multipart/form-data" id="entregaForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="opcion_entrega" class="form-label fw-bold">
                                <i class="fas fa-shipping-fast me-2 text-primary"></i>Selecciona la opción de entrega
                            </label>
                            <select name="opcion_entrega" id="opcion_entrega" class="form-select @error('opcion_entrega') is-invalid @enderror" required>
                                <option value="">-- Selecciona una opción --</option>
                                <option value="Google Drive" {{ old('opcion_entrega') == 'Google Drive' ? 'selected' : '' }}>
                                    <i class="fab fa-google-drive"></i> Google Drive
                                </option>
                                <option value="CD" {{ old('opcion_entrega') == 'CD' ? 'selected' : '' }}>
                                    <i class="fas fa-compact-disc"></i> CD
                                </option>
                            </select>
                            @error('opcion_entrega')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Opciones específicas para CD -->
                        <div id="cd_section" class="cd-options" style="display: none;">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">
                                        <i class="fas fa-compact-disc me-2"></i>Información del CD
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nro_transaccion_cd" class="form-label fw-bold">
                                                    <i class="fas fa-hashtag me-2 text-info"></i>Número de transacción CD
                                                </label>
                                                <input type="text" 
                                                       name="nro_transaccion_cd" 
                                                       id="nro_transaccion_cd"
                                                       class="form-control @error('nro_transaccion_cd') is-invalid @enderror" 
                                                       value="{{ old('nro_transaccion_cd') }}"
                                                       placeholder="Ej: TXN-2024-001">
                                                @error('nro_transaccion_cd')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="costo_cd" class="form-label fw-bold">
                                                    <i class="fas fa-dollar-sign me-2 text-success"></i>Costo del CD
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" 
                                                           name="costo_cd" 
                                                           id="costo_cd"
                                                           class="form-control @error('costo_cd') is-invalid @enderror" 
                                                           value="{{ old('costo_cd') }}"
                                                           step="0.01" 
                                                           min="0"
                                                           placeholder="0.00">
                                                </div>
                                                @error('costo_cd')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="comprobante_cd" class="form-label fw-bold">
                                            <i class="fas fa-file-upload me-2 text-warning"></i>Comprobante de CD
                                        </label>
                                        <input type="file" 
                                               name="comprobante_cd" 
                                               id="comprobante_cd"
                                               class="form-control @error('comprobante_cd') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Formatos permitidos: PDF, JPG, PNG, DOC, DOCX (máx. 5MB)
                                        </div>
                                        @error('comprobante_cd')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional para Google Drive -->
                        <div id="google_drive_section" class="google-drive-options" style="display: none;">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">
                                        <i class="fab fa-google-drive me-2"></i>Entrega por Google Drive
                                    </h5>
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Los materiales serán enviados a través de Google Drive al correo electrónico registrado en la venta.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ url('/entrega-material') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Guardar Entrega
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const opcionEntrega = document.getElementById('opcion_entrega');
    const cdSection = document.getElementById('cd_section');
    const googleDriveSection = document.getElementById('google_drive_section');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('entregaForm');

    // Función para mostrar/ocultar secciones
    function toggleSections() {
        const selectedValue = opcionEntrega.value;
        
        if (selectedValue === 'CD') {
            cdSection.style.display = 'block';
            googleDriveSection.style.display = 'none';
            
            // Hacer campos requeridos
            document.getElementById('nro_transaccion_cd').required = true;
            document.getElementById('costo_cd').required = true;
            
            // Animación suave
            cdSection.style.opacity = '0';
            setTimeout(() => {
                cdSection.style.opacity = '1';
            }, 100);
            
        } else if (selectedValue === 'Google Drive') {
            cdSection.style.display = 'none';
            googleDriveSection.style.display = 'block';
            
            // Quitar campos requeridos
            document.getElementById('nro_transaccion_cd').required = false;
            document.getElementById('costo_cd').required = false;
            
            // Animación suave
            googleDriveSection.style.opacity = '0';
            setTimeout(() => {
                googleDriveSection.style.opacity = '1';
            }, 100);
            
        } else {
            cdSection.style.display = 'none';
            googleDriveSection.style.display = 'none';
            
            // Quitar campos requeridos
            document.getElementById('nro_transaccion_cd').required = false;
            document.getElementById('costo_cd').required = false;
        }
    }

    // Event listener para el cambio de opción
    opcionEntrega.addEventListener('change', toggleSections);

    // Inicializar al cargar la página (para mantener selección anterior)
    toggleSections();

    // Validación adicional del formulario
    form.addEventListener('submit', function(e) {
        const selectedValue = opcionEntrega.value;
        
        if (!selectedValue) {
            e.preventDefault();
            alert('Por favor, selecciona una opción de entrega.');
            opcionEntrega.focus();
            return;
        }
        
        if (selectedValue === 'CD') {
            const nroTransaccion = document.getElementById('nro_transaccion_cd').value.trim();
            const costoCd = document.getElementById('costo_cd').value.trim();
            
            if (!nroTransaccion) {
                e.preventDefault();
                alert('Por favor, ingresa el número de transacción del CD.');
                document.getElementById('nro_transaccion_cd').focus();
                return;
            }
            
            if (!costoCd || parseFloat(costoCd) < 0) {
                e.preventDefault();
                alert('Por favor, ingresa un costo válido para el CD.');
                document.getElementById('costo_cd').focus();
                return;
            }
        }
        
        // Mostrar indicador de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    });

    // Validación del archivo
    document.getElementById('comprobante_cd').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['.pdf', '.jpg', '.jpeg', '.png', '.doc', '.docx'];
            const fileName = file.name.toLowerCase();
            const fileExtension = fileName.substring(fileName.lastIndexOf('.'));
            
            if (file.size > maxSize) {
                alert('El archivo es demasiado grande. El tamaño máximo es 5MB.');
                e.target.value = '';
                return;
            }
            
            if (!allowedTypes.includes(fileExtension)) {
                alert('Formato de archivo no permitido. Use: PDF, JPG, PNG, DOC, DOCX.');
                e.target.value = '';
                return;
            }
        }
    });
});
</script>

<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.cd-options, .google-drive-options {
    transition: all 0.3s ease-in-out;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.alert {
    border: none;
    border-radius: 8px;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.card-body .card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endsection