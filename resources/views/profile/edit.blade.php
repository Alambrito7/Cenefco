{{-- resources/views/profile/edit.blade.php - VERSIÓN SIMPLIFICADA --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-user-edit me-2"></i>Editar Perfil
            </h1>
            <p class="text-muted">Actualiza tu información personal</p>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
            
                <li class="breadcrumb-item">
                    <a href="{{ route('profile.show') }}" class="text-decoration-none">
                        <i class="fas fa-user me-1"></i>Mi Perfil
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-edit me-1"></i>Editar
                </li>
            </ol>
        </nav>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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

        <div class="row justify-content-center">
            <!-- Avatar y Vista Previa -->
            <div class="col-lg-4">
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-image me-2"></i>Foto de Perfil
                        </h5>
                    </div>
                    <div class="card-body text-center p-4">
                        <!-- Avatar actual -->
                        <div class="mb-3">
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" 
             alt="Avatar de {{ $user->name }}" 
             id="currentAvatar"
             class="rounded-circle border border-3 border-primary" 
             style="width: 150px; height: 150px; object-fit: cover;"
             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->getInitials()) }}&background=0d6efd&color=ffffff&size=200';">
    @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->getInitials()) }}&background=0d6efd&color=ffffff&size=200" 
             alt="Avatar de {{ $user->name }}" 
             id="currentAvatar"
             class="rounded-circle border border-3 border-primary" 
             style="width: 150px; height: 150px; object-fit: cover;">
    @endif
</div>

                        <!-- Preview del nuevo avatar -->
                        <div id="avatarPreview" class="mb-3" style="display: none;">
                            <img id="previewImage" src="" alt="Preview" 
                                 class="rounded-circle border border-3 border-success" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-check me-1"></i>Nueva imagen seleccionada
                                </small>
                            </div>
                        </div>

                        <!-- Botones de avatar -->
                        <div class="d-grid gap-2">
                            <label for="avatar" class="btn btn-outline-primary">
                                <i class="fas fa-upload me-2"></i>Seleccionar Nueva Imagen
                            </label>
                            @if($user->avatar)
                                <form action="{{ route('profile.avatar.delete') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100" 
                                            onclick="return confirm('¿Seguro que deseas eliminar tu avatar?')">
                                        <i class="fas fa-trash me-2"></i>Eliminar Avatar
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Formatos permitidos: JPG, PNG, GIF<br>
                                Tamaño máximo: 2MB
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Información actual -->
                <div class="card shadow-lg">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Información Actual
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Nombre:</strong> {{ $user->name }}
                        </div>
                        <div class="mb-2">
                            <strong>Email:</strong> {{ $user->email }}
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                Miembro desde {{ $user->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Edición -->
            <div class="col-lg-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <!-- Avatar (campo oculto) -->
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">

                    <!-- Información Personal -->
                    <div class="card shadow-lg mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Información Personal
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-user me-1 text-primary"></i>Nombre Completo
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-1 text-success"></i>Correo Electrónico
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3 justify-content-between">
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Volver al Perfil
                                </a>
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-warning btn-lg">
                                        <i class="fas fa-undo me-2"></i>Resetear
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Guardar Cambios
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

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando JavaScript del formulario de perfil simplificado...');
    
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const previewImage = document.getElementById('previewImage');
    const currentAvatar = document.getElementById('currentAvatar');
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');

    // Preview del avatar
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecciona una imagen válida.');
                this.value = '';
                return;
            }
            
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen no debe exceder 2MB.');
                this.value = '';
                return;
            }
            
            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                avatarPreview.style.display = 'block';
                currentAvatar.style.opacity = '0.5';
            };
            reader.readAsDataURL(file);
            
            console.log('Avatar seleccionado:', file.name);
        } else {
            // Ocultar preview si se cancela
            avatarPreview.style.display = 'none';
            currentAvatar.style.opacity = '1';
        }
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        console.log('Enviando formulario de perfil...');
        
        // Mostrar indicador de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        
        console.log('✅ Formulario válido, enviando...');
        return true;
    });

    // Reset del formulario
    const resetBtn = document.querySelector('button[type="reset"]');
    resetBtn.addEventListener('click', function() {
        avatarPreview.style.display = 'none';
        currentAvatar.style.opacity = '1';
        avatarInput.value = '';
        console.log('Formulario reseteado');
    });

    console.log('✅ JavaScript del formulario de perfil simplificado cargado correctamente');
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

.btn:disabled {
    opacity: 0.6;
}

/* Transiciones suaves */
#currentAvatar,
#avatarPreview {
    transition: all 0.3s ease;
}

/* Hover effects */
.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}
</style>
@endsection