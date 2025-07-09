@extends('layouts.app')

@section('content')
<style>
    .modules-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .modules-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .modules-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .modules-title {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .modules-subtitle {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 300;
    }
    
    .user-info {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .user-info h3 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .alert-success-modern {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .module-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #4f46e5;
    }
    
    .module-card.checked {
        border-color: #10b981;
        background: linear-gradient(45deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    }
    
    .module-card.checked::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(45deg, #10b981, #059669);
    }
    
    .module-checkbox {
        width: 1.5rem;
        height: 1.5rem;
        margin-right: 1rem;
        accent-color: #10b981;
        cursor: pointer;
    }
    
    .module-label {
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        user-select: none;
    }
    
    .module-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .module-description {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        font-style: italic;
    }
    
    .form-actions-modules {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #e5e7eb;
    }
    
    .btn-success-modern {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success-modern:hover {
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .modules-counter {
        background: rgba(255, 255, 255, 0.9);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .counter-number {
        font-size: 2rem;
        font-weight: 700;
        color: #4f46e5;
        display: block;
    }
    
    .counter-label {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .modules-wrapper {
            padding: 1.5rem;
            margin: 1rem;
        }
        
        .modules-title {
            font-size: 1.5rem;
        }
        
        .modules-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .form-actions-modules {
            flex-direction: column;
        }
        
        .btn-modern {
            width: 100%;
        }
    }
</style>

<div class="modules-container">
    <div class="container">
        <div class="modules-wrapper">
            <div class="modules-header">
                <h1 class="modules-title">
                    <i class="fas fa-cogs"></i>
                    Asignar Módulos
                </h1>
                <p class="modules-subtitle">
                    Configura los permisos de acceso a módulos del sistema
                </p>
            </div>

            <div class="user-info">
                <h3>
                    <i class="fas fa-user"></i>
                    {{ $usuario->name }}
                </h3>
            </div>

            @if(session('success'))
                <div class="alert-success-modern">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="modules-counter">
                <span class="counter-number" id="selectedCount">0</span>
                <span class="counter-label">módulos seleccionados</span>
            </div>

            <form action="{{ route('usuarios.modulos.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modules-grid">
                    @php
                        $moduleIcons = [
                            'registros' => 'fas fa-clipboard-list',
                            'ventas' => 'fas fa-shopping-cart',
                            'inventario' => 'fas fa-boxes',
                            'certificados' => 'fas fa-certificate',
                            'competencias' => 'fas fa-award',
                            'financiero' => 'fas fa-chart-line',
                            'control' => 'fas fa-cog',
                            'entregas' => 'fas fa-truck',
                            'usuarios' => 'fas fa-users',
                            'clientes' => 'fas fa-user-friends',
                            'docentes' => 'fas fa-chalkboard-teacher',
                            'personal' => 'fas fa-user-tie',
                            'cursos' => 'fas fa-graduation-cap'
                        ];
                        
                        $moduleDescriptions = [
                            'registros' => 'Gestión de registros del sistema',
                            'ventas' => 'Administración de ventas y comercio',
                            'inventario' => 'Control de stock y productos',
                            'certificados' => 'Emisión y gestión de certificados',
                            'competencias' => 'Evaluación de competencias',
                            'financiero' => 'Módulo financiero y contable',
                            'control' => 'Panel de control general',
                            'entregas' => 'Gestión de entregas y logística',
                            'usuarios' => 'Administración de usuarios',
                            'clientes' => 'Gestión de clientes',
                            'docentes' => 'Administración de docentes',
                            'personal' => 'Gestión de personal interno',
                            'cursos' => 'Administración de cursos'
                        ];
                    @endphp

                    @foreach($modulosDisponibles as $modulo)
                        <div class="module-card {{ in_array($modulo, $modulosAsignados) ? 'checked' : '' }}">
                            <label class="module-label" for="modulo_{{ $modulo }}">
                                <div class="module-icon">
                                    <i class="{{ $moduleIcons[$modulo] ?? 'fas fa-cube' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <input class="module-checkbox" 
                                           type="checkbox" 
                                           name="modulos[]" 
                                           value="{{ $modulo }}"
                                           id="modulo_{{ $modulo }}"
                                           {{ in_array($modulo, $modulosAsignados) ? 'checked' : '' }}>
                                    <strong>{{ ucfirst($modulo) }}</strong>
                                    <div class="module-description">
                                        {{ $moduleDescriptions[$modulo] ?? 'Módulo del sistema' }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-actions-modules">
                    <a href="{{ route('usuarios.index') }}" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                    <button type="submit" class="btn-modern btn-success-modern">
                        <i class="fas fa-save"></i>
                        Guardar permisos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.module-checkbox');
    const counter = document.getElementById('selectedCount');
    
    function updateCounter() {
        const checked = document.querySelectorAll('.module-checkbox:checked').length;
        counter.textContent = checked;
    }
    
    function updateCardState(checkbox) {
        const card = checkbox.closest('.module-card');
        if (checkbox.checked) {
            card.classList.add('checked');
        } else {
            card.classList.remove('checked');
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCounter();
            updateCardState(this);
        });
        
        // Initialize card state
        updateCardState(checkbox);
    });
    
    // Initialize counter
    updateCounter();
});
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush