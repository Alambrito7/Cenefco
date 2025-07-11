{{-- resources/views/profile/show.blade.php - VERSIÓN SIMPLIFICADA --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-user-circle me-2"></i>Mi Perfil
            </h1>
            <p class="text-muted">Información de tu cuenta personal</p>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
            
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-user me-1"></i>Mi Perfil
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

        <div class="row justify-content-center">
            <!-- Información del Perfil -->
            <div class="col-lg-4">
                <!-- Tarjeta de Usuario -->
                <div class="card shadow-lg mb-4">
                    <div class="card-body text-center p-4">
                        <!-- Avatar -->
                        <div class="mb-3">
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" 
             alt="Avatar de {{ $user->name }}" 
             class="rounded-circle border border-3 border-primary" 
             style="width: 120px; height: 120px; object-fit: cover;"
             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->getInitials()) }}&background=0d6efd&color=ffffff&size=200';">
    @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->getInitials()) }}&background=0d6efd&color=ffffff&size=200" 
             alt="Avatar de {{ $user->name }}" 
             class="rounded-circle border border-3 border-primary" 
             style="width: 120px; height: 120px; object-fit: cover;">
    @endif
</div>

                        <!-- Información básica -->
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-3">
                            <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                        </p>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Editar Perfil
                            </a>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-2"></i>Cambiar Contraseña
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas rápidas -->
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Estadísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $stats = app('App\Http\Controllers\ProfileController')->getStats();
                        @endphp
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-primary mb-0">{{ $stats['materials_created'] }}</div>
                                    <small class="text-muted">Materiales</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h4 text-success mb-0">{{ $stats['profile_completion'] }}%</div>
                                    <small class="text-muted">Perfil</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <div class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Miembro desde {{ $stats['account_age'] }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Barra de progreso del perfil -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Completitud del perfil</small>
                                <small class="text-muted">{{ $stats['profile_completion'] }}%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-gradient" 
                                     role="progressbar" 
                                     style="width: {{ $stats['profile_completion'] }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles del Perfil -->
            <div class="col-lg-6">
                <!-- Información Personal -->
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Información Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted">Nombre Completo</label>
                                <div class="form-control-plaintext">
                                    <i class="fas fa-user me-2 text-primary"></i>{{ $user->name }}
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted">Correo Electrónico</label>
                                <div class="form-control-plaintext">
                                    <i class="fas fa-envelope me-2 text-success"></i>{{ $user->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Cuenta -->
                <div class="card shadow-lg">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>Información de Cuenta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Fecha de Registro</label>
                                <div class="form-control-plaintext">
                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Último Acceso</label>
                                <div class="form-control-plaintext">
                                    <i class="fas fa-clock me-2 text-success"></i>
                                    {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'No registrado' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Estado de Email</label>
                                <div class="form-control-plaintext">
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Verificado
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>No Verificado
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">ID de Usuario</label>
                                <div class="form-control-plaintext">
                                    <code>#{{ $user->id }}</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>Cambiar Contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.form-control-plaintext {
    padding: 0.375rem 0;
    border-bottom: 1px solid #e9ecef;
    border-radius: 0;
}

.progress {
    border-radius: 10px;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 1rem;
}

.btn {
    border-radius: 8px;
}

.badge {
    font-size: 0.8em;
}
</style>
@endsection