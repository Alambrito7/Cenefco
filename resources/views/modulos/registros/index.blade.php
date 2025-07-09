@extends('layouts.app')

@section('content')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #f5f7fa   0%, #c3cfe2  100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .management-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .management-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 1);
    }
    
    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.8rem;
        color: white;
        font-weight: bold;
    }
    
    .icon-usuarios { background: linear-gradient(45deg, #4f46e5, #7c3aed); }
    .icon-clientes { background: linear-gradient(45deg, #059669, #10b981); }
    .icon-docentes { background: linear-gradient(45deg, #dc2626, #ef4444); }
    .icon-personal { background: linear-gradient(45deg, #ea580c, #f97316); }
    .icon-cursos { background: linear-gradient(45deg, #2563eb, #3b82f6); }
    
    .card-title {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }
    
    .card-description {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 2rem;
    }
    
    .btn-modern {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        color: white;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .btn-clientes {
        background: linear-gradient(45deg, #059669, #10b981);
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }
    
    .btn-clientes:hover {
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
    }
    
    .btn-docentes {
        background: linear-gradient(45deg, #dc2626, #ef4444);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }
    
    .btn-docentes:hover {
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    }
    
    .btn-personal {
        background: linear-gradient(45deg, #ea580c, #f97316);
        box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);
    }
    
    .btn-personal:hover {
        box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4);
    }
    
    .btn-cursos {
        background: linear-gradient(45deg, #2563eb, #3b82f6);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }
    
    .btn-cursos:hover {
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
    }
    
    .page-title {
        color: black;
        font-weight: 700;
        margin-bottom: 3rem;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .page-subtitle {
        color:rgba(0, 0, 0, 0.9);
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 3rem;
        font-weight: 300;
    }
    
    @media (max-width: 768px) {
        .management-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
        
        .card-title {
            font-size: 1.2rem;
        }
        
        .card-description {
            font-size: 0.9rem;
        }
    }
</style>

<div class="gradient-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="page-title display-4">
                    <i class="fas fa-clipboard-list me-3"></i>
                    Gestión de Registros
                </h1>
                <p class="page-subtitle">
                    Panel centralizado para administrar todos los recursos del sistema
                </p>
                
                <div class="row g-4">
                    {{-- Usuarios --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="management-card">
                            <div class="card-icon icon-usuarios">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h3 class="card-title">Usuarios</h3>
                            <p class="card-description">
                                Gestión completa de usuarios del sistema. Crear, editar, eliminar y administrar permisos de acceso.
                            </p>
                            <a href="{{ route('usuarios.index') }}" class="btn-modern">
                                <i class="fas fa-arrow-right me-2"></i>
                                Entrar
                            </a>
                        </div>
                    </div>

                    {{-- Clientes --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="management-card">
                            <div class="card-icon icon-clientes">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h3 class="card-title">Clientes</h3>
                            <p class="card-description">
                                Registro, edición y búsqueda de clientes. Mantén actualizada la información de contacto y historial.
                            </p>
                            <a href="{{ route('clientes.index') }}" class="btn-modern btn-clientes">
                                <i class="fas fa-arrow-right me-2"></i>
                                Entrar
                            </a>
                        </div>
                    </div>

                    {{-- Docentes --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="management-card">
                            <div class="card-icon icon-docentes">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="card-title">Docentes</h3>
                            <p class="card-description">
                                Administración de docentes registrados. Gestiona perfiles, especialidades y asignaciones de cursos.
                            </p>
                            <a href="{{ route('docentes.index') }}" class="btn-modern btn-docentes">
                                <i class="fas fa-arrow-right me-2"></i>
                                Entrar
                            </a>
                        </div>
                    </div>

                    {{-- Personal --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="management-card">
                            <div class="card-icon icon-personal">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3 class="card-title">Personal</h3>
                            <p class="card-description">
                                Control y edición del personal interno. Administra roles, departamentos y información laboral.
                            </p>
                            <a href="{{ route('personals.index') }}" class="btn-modern btn-personal">
                                <i class="fas fa-arrow-right me-2"></i>
                                Entrar
                            </a>
                        </div>
                    </div>

                    {{-- Cursos --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="management-card">
                            <div class="card-icon icon-cursos">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3 class="card-title">Cursos</h3>
                            <p class="card-description">
                                Listado y gestión de los cursos disponibles. Crear programas, asignar docentes y administrar contenido.
                            </p>
                            <a href="{{ route('cursos.index') }}" class="btn-modern btn-cursos">
                                <i class="fas fa-arrow-right me-2"></i>
                                Entrar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush