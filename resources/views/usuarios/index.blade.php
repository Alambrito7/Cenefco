@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        background: linear-gradient(135deg, #f5f7fa  0%, #c3cfe2  100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .content-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .page-title {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 1.1rem;
        font-weight: 300;
    }
    
    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .table-header {
        background: linear-gradient(45deg, #1f2937, #374151);
        color: white;
        padding: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-title {
        font-size: 1.2rem;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .table-title i {
        margin-right: 0.5rem;
        font-size: 1.3rem;
    }
    
    .modern-table {
        margin: 0;
        background: white;
    }
    
    .modern-table thead th {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        color: white;
        font-weight: 600;
        padding: 1rem;
        border: none;
        text-align: center;
        font-size: 0.9rem;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        text-align: center;
        border: none;
    }
    
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-superadmin {
        background: linear-gradient(45deg, #dc2626, #ef4444);
        color: white;
    }
    
    .badge-admin {
        background: linear-gradient(45deg, #ea580c, #f97316);
        color: white;
    }
    
    .badge-agente {
        background: linear-gradient(45deg, #2563eb, #3b82f6);
        color: white;
    }
    
    .badge-usuario {
        background: linear-gradient(45deg, #059669, #10b981);
        color: white;
    }
    
    .badge-sin-rol {
        background: linear-gradient(45deg, #6b7280, #9ca3af);
        color: white;
    }
    
    .badge-activo {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
    }
    
    .select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.5rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        width: 120px;
        margin-right: 0.5rem;
    }
    
    .select-modern:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .btn-modern {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-success-modern {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success-modern:hover {
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-info-modern {
        background: linear-gradient(45deg, #0ea5e9, #0284c7);
        color: white;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
    }
    
    .btn-info-modern:hover {
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
        color: white;
    }
    
    .btn-warning-modern {
        background: linear-gradient(45deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    
    .btn-warning-modern:hover {
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        color: white;
    }
    
    .btn-danger-modern {
        background: linear-gradient(45deg, #dc2626, #b91c1c);
        color: white;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }
    
    .btn-danger-modern:hover {
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        color: white;
    }
    
    .btn-restore-modern {
        background: linear-gradient(45deg, #059669, #047857);
        color: white;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
    }
    
    .btn-restore-modern:hover {
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
        color: white;
    }
    
    .deleted-table {
        background: #fef2f2;
    }
    
    .deleted-table thead th {
        background: linear-gradient(45deg, #dc2626, #ef4444);
    }
    
    .deleted-table tbody tr {
        background: rgba(254, 242, 242, 0.8);
    }
    
    .deleted-table tbody tr:hover {
        background: rgba(254, 242, 242, 1);
    }
    
    .section-divider {
        margin: 3rem 0;
        border-top: 2px solid #e5e7eb;
        padding-top: 2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
        font-style: italic;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    .form-inline-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }
    
    .actions-group {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
    }
    
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
            margin: 1rem;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
        
        .modern-table {
            font-size: 0.8rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.5rem;
        }
        
        .select-modern {
            width: 100px;
        }
        
        .btn-modern {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .actions-group {
            flex-direction: column;
            gap: 0.3rem;
        }
    }
</style>

<div class="admin-container">
    <div class="container">
        <div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-users-cog"></i>
                    Administración de Usuarios
                </h1>
                <p class="page-subtitle">
                    Gestiona roles, permisos y estados de los usuarios del sistema
                </p>
            </div>

            @if (session('success'))
                <div class="alert-modern">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabla de Usuarios Activos --}}
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-users"></i>
                        Usuarios Activos
                    </h3>
                    <span class="badge badge-modern badge-activo">
                        {{ count($usuarios) }} usuarios
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user me-1"></i>Nombre</th>
                                <th><i class="fas fa-envelope me-1"></i>Correo</th>
                                <th><i class="fas fa-shield-alt me-1"></i>Rol Actual</th>
                                
                             
                                <th><i class="fas fa-circle me-1"></i>Estado</th>
                                <th><i class="fas fa-tools me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <strong>{{ $usuario->name }}</strong>
                                    </td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        @php
                                            $roleClass = match($usuario->role) {
                                                'superadmin' => 'badge-superadmin',
                                                'admin' => 'badge-admin',
                                                'agente' => 'badge-agente',
                                                'usuario' => 'badge-usuario',
                                                default => 'badge-sin-rol'
                                            };
                                        @endphp
                                        <span class="badge-modern {{ $roleClass }}">
                                            {{ $usuario->role ?? 'Sin rol' }}
                                        </span>
                                    </td>
                                   
                                    
                                    <td>
                                        <span class="badge-modern badge-activo">
                                            <i class="fas fa-circle me-1"></i>
                                            Activo
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-group">
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn-modern btn-warning-modern">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </a>
                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Deseas eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-modern btn-danger-modern">
                                                    <i class="fas fa-trash"></i>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabla de Usuarios Eliminados --}}
            <div class="section-divider">
                <div class="table-container">
                    <div class="table-header" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                        <h3 class="table-title">
                            <i class="fas fa-trash-restore"></i>
                            Usuarios Eliminados
                        </h3>
                        <span class="badge badge-modern" style="background: rgba(255,255,255,0.2);">
                            {{ count($usuariosEliminados) }} eliminados
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table modern-table deleted-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-1"></i>Nombre</th>
                                    <th><i class="fas fa-envelope me-1"></i>Correo</th>
                                    <th><i class="fas fa-shield-alt me-1"></i>Rol</th>
                                    <th><i class="fas fa-calendar me-1"></i>Fecha Eliminado</th>
                                    <th><i class="fas fa-undo me-1"></i>Restaurar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usuariosEliminados as $usuario)
                                    <tr>
                                        <td><strong>{{ $usuario->name }}</strong></td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            @php
                                                $roleClass = match($usuario->role) {
                                                    'superadmin' => 'badge-superadmin',
                                                    'admin' => 'badge-admin',
                                                    'agente' => 'badge-agente',
                                                    'usuario' => 'badge-usuario',
                                                    default => 'badge-sin-rol'
                                                };
                                            @endphp
                                            <span class="badge-modern {{ $roleClass }}">
                                                {{ $usuario->role }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $usuario->deleted_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            <form action="{{ route('usuarios.restore', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Restaurar este usuario?')">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn-modern btn-restore-modern">
                                                    <i class="fas fa-undo"></i>
                                                    Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <br>
                                            No hay usuarios eliminados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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