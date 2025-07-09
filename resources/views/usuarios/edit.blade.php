{{-- VISTA 1: EDITAR USUARIO --}}
@extends('layouts.app')

@section('content')
<style>
    .edit-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .form-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .page-title {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 300;
    }
    
    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: linear-gradient(45deg, #dc2626, #ef4444);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }
    
    .alert-modern strong {
        font-weight: 600;
    }
    
    .alert-modern ul {
        margin-top: 0.5rem;
    }
    
    .form-group {
        margin-bottom: 2rem;
    }
    
    .form-label-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }
    
    .form-control-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        width: 100%;
    }
    
    .form-control-modern:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
        transform: translateY(-2px);
    }
    
    .form-control-modern:hover {
        border-color: #d1d5db;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2.5rem;
        gap: 1rem;
    }
    
    .btn-modern {
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 150px;
        justify-content: center;
    }
    
    .btn-modern:hover {
        transform: translateY(-3px);
        text-decoration: none;
    }
    
    .btn-primary-modern {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-primary-modern:hover {
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        color: white;
    }
    
    .btn-secondary-modern {
        background: linear-gradient(45deg, #6b7280, #9ca3af);
        color: white;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }
    
    .btn-secondary-modern:hover {
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
        color: white;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        color: white;
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .form-wrapper {
            padding: 1.5rem;
            margin: 1rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-modern {
            width: 100%;
        }
    }
</style>

<div class="edit-container">
    <div class="container">
        <div class="form-wrapper">
            <div class="page-header">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Editar Usuario
                </h1>
                <p class="page-subtitle">
                    Modifica la información básica del usuario
                </p>
            </div>

            @if ($errors->any())
                <div class="alert-modern">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>¡Ups! Corrige los siguientes errores:</strong>
                    </div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label-modern">
                        <i class="fas fa-user"></i>
                        Nombre completo
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           class="form-control-modern" 
                           value="{{ old('name', $usuario->name) }}" 
                           required
                           placeholder="Ingresa el nombre completo">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label-modern">
                        <i class="fas fa-envelope"></i>
                        Correo electrónico
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           class="form-control-modern" 
                           value="{{ old('email', $usuario->email) }}" 
                           required
                           placeholder="usuario@ejemplo.com">
                </div>

                <div class="form-actions">
                    <a href="{{ route('usuarios.index') }}" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="fas fa-save"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush