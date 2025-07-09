@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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
    
    .controls-section {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .search-container {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    
    .search-input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 2.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
        background: white;
    }
    
    .search-icon {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 1rem;
    }
    
    .actions-toolbar {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-modern {
        border: none;
        border-radius: 12px;
        padding: 0.7rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-primary-modern {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-primary-modern:hover {
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        color: white;
    }
    
    .btn-success-modern {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success-modern:hover {
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-danger-modern {
        background: linear-gradient(45deg, #dc2626, #b91c1c);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }
    
    .btn-danger-modern:hover {
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        color: white;
    }
    
    .btn-warning-modern {
        background: linear-gradient(45deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-warning-modern:hover {
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
    }
    
    .btn-info-modern {
        background: linear-gradient(45deg, #0ea5e9, #0284c7);
        color: white;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    
    .btn-info-modern:hover {
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        color: white;
    }
    
    .btn-restore-modern {
        background: linear-gradient(45deg, #059669, #047857);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }
    
    .btn-restore-modern:hover {
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        color: white;
    }
    
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .table-header {
        background: linear-gradient(45deg, #1f2937, #374151);
        color: white;
        padding: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-title {
        font-size: 1.3rem;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .table-title i {
        margin-right: 0.7rem;
        font-size: 1.4rem;
    }
    
    .table-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .modern-table {
        margin: 0;
        background: white;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .modern-table thead th {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        color: white;
        font-weight: 600;
        padding: 1rem 0.8rem;
        border: none;
        text-align: center;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.005);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    
    .modern-table tbody td {
        padding: 1rem 0.8rem;
        vertical-align: middle;
        text-align: center;
        border: none;
        font-size: 0.85rem;
    }
    
    .badge-modern {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-activo {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
    }
    
    .badge-eliminado {
        background: linear-gradient(45deg, #dc2626, #b91c1c);
        color: white;
    }
    
    .client-name {
        font-weight: 600;
        color: #1f2937;
    }
    
    .client-detail {
        color: #6b7280;
        font-size: 0.8rem;
    }
    
    .actions-group {
        display: flex;
        gap: 0.3rem;
        justify-content: center;
        align-items: center;
    }
    
    .btn-sm-modern {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        border-radius: 8px;
    }
    
    .section-divider {
        margin: 3rem 0;
        border-top: 2px solid #e5e7eb;
        padding-top: 2rem;
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
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
            margin: 1rem;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
        
        .controls-section {
            padding: 1rem;
        }
        
        .controls-section > div {
            flex-direction: column;
            gap: 1rem;
        }
        
        .search-container {
            max-width: 100%;
        }
        
        .actions-toolbar {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .modern-table {
            font-size: 0.75rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.5rem 0.3rem;
        }
        
        .btn-modern {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .actions-group {
            flex-direction: column;
            gap: 0.2rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="admin-container">
    <div class="container">
        <div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-users"></i>
                    Gestión de Clientes
                </h1>
                <p class="page-subtitle">
                    Administra y supervisa toda la información de tus clientes
                </p>
            </div>

            @if(session('success'))
                <div class="alert-modern">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Estadísticas --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $clientes->where('deleted_at', null)->count() }}</div>
                    <div class="stat-label">Clientes Activos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $clientes->where('deleted_at', '!=', null)->count() }}</div>
                    <div class="stat-label">Clientes Eliminados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $clientes->count() }}</div>
                    <div class="stat-label">Total de Clientes</div>
                </div>
            </div>

            {{-- Controles --}}
            <div class="controls-section">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               id="buscador" 
                               class="search-input" 
                               placeholder="Buscar por nombre, CI, email o celular..."
                               onkeyup="filtrarTabla()">
                    </div>
                    <div class="actions-toolbar">
                        <a href="{{ route('clientes.export.pdf') }}" class="btn-modern btn-danger-modern">
                            <i class="fas fa-file-pdf"></i>
                            PDF
                        </a>
                        <a href="{{ route('clientes.export.excel') }}" class="btn-modern btn-success-modern">
                            <i class="fas fa-file-excel"></i>
                            Excel
                        </a>
                        <a href="{{ route('clientes.create') }}" class="btn-modern btn-primary-modern">
                            <i class="fas fa-plus"></i>
                            Nuevo Cliente
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabla de Clientes Activos --}}
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-users"></i>
                        Clientes Activos
                    </h3>
                    <span class="table-count">
                        {{ $clientes->where('deleted_at', null)->count() }} clientes
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table modern-table" id="clientes-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-user me-1"></i>Cliente</th>
                                <th><i class="fas fa-id-card me-1"></i>CI</th>
                                <th><i class="fas fa-envelope me-1"></i>Email</th>
                                <th><i class="fas fa-mobile-alt me-1"></i>Celular</th>
                                <th><i class="fas fa-map-marker-alt me-1"></i>Ubicación</th>
                                <th><i class="fas fa-venus-mars me-1"></i>Género</th>
                                <th><i class="fas fa-globe me-1"></i>País</th>
                                <th><i class="fas fa-briefcase me-1"></i>Profesión</th>
                                <th><i class="fas fa-graduation-cap me-1"></i>Grado</th>
                                <th><i class="fas fa-birthday-cake me-1"></i>Edad</th>
                                <th><i class="fas fa-circle me-1"></i>Estado</th>
                                <th><i class="fas fa-tools me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes->where('deleted_at', null) as $cliente)
                                <tr>
                                    <td><strong>{{ $cliente->id }}</strong></td>
                                    <td>
                                        <div class="client-name">{{ $cliente->nombre }}</div>
                                        <div class="client-detail">{{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</div>
                                    </td>
                                    <td>{{ $cliente->ci }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->celular }}</td>
                                    <td>
                                        <div class="client-name">{{ $cliente->departamento }}</div>
                                        <div class="client-detail">{{ $cliente->provincia }}</div>
                                    </td>
                                    <td>{{ $cliente->genero }}</td>
                                    <td>{{ $cliente->pais }}</td>
                                    <td>{{ $cliente->profesion }}</td>
                                    <td>{{ $cliente->grado_academico }}</td>
                                    <td>{{ $cliente->edad }}</td>
                                    <td>
                                        <span class="badge-modern badge-activo">
                                            <i class="fas fa-circle me-1"></i>
                                            Activo
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-group">
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn-modern btn-sm-modern btn-warning-modern">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-modern btn-sm-modern btn-danger-modern">
                                                    <i class="fas fa-trash"></i>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        <br>
                                        No hay clientes activos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabla de Clientes Eliminados --}}
            @if($clientes->where('deleted_at', '!=', null)->count() > 0)
            <div class="section-divider">
                <div class="table-container">
                    <div class="table-header" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                        <h3 class="table-title">
                            <i class="fas fa-trash-restore"></i>
                            Clientes Eliminados
                        </h3>
                        <span class="table-count">
                            {{ $clientes->where('deleted_at', '!=', null)->count() }} eliminados
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table modern-table deleted-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th><i class="fas fa-user me-1"></i>Cliente</th>
                                    <th><i class="fas fa-id-card me-1"></i>CI</th>
                                    <th><i class="fas fa-envelope me-1"></i>Email</th>
                                    <th><i class="fas fa-mobile-alt me-1"></i>Celular</th>
                                    <th><i class="fas fa-calendar me-1"></i>Fecha Eliminado</th>
                                    <th><i class="fas fa-undo me-1"></i>Restaurar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes->where('deleted_at', '!=', null) as $cliente)
                                    <tr>
                                        <td><strong>{{ $cliente->id }}</strong></td>
                                        <td>
                                            <div class="client-name">{{ $cliente->nombre }}</div>
                                            <div class="client-detail">{{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</div>
                                        </td>
                                        <td>{{ $cliente->ci }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->celular }}</td>
                                        <td>
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $cliente->deleted_at ? $cliente->deleted_at->format('d/m/Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('clientes.restore', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Restaurar este cliente?')">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn-modern btn-sm-modern btn-restore-modern">
                                                    <i class="fas fa-undo"></i>
                                                    Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript para filtrar tabla -->
<script>
    function filtrarTabla() {
        const input = document.getElementById("buscador").value.toLowerCase();
        const filas = document.querySelectorAll("#clientes-table tbody tr");
        
        filas.forEach(fila => {
            const texto = fila.innerText.toLowerCase();
            fila.style.display = texto.includes(input) ? "" : "none";
        });
    }
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush