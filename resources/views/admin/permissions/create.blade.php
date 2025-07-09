{{-- resources/views/admin/permissions/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>➕ Crear Nuevo Permiso</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.permissions.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="module">Módulo *</label>
                            <select class="form-control @error('module') is-invalid @enderror" 
                                    id="module" 
                                    name="module" 
                                    required>
                                <option value="">Seleccionar módulo...</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module }}" {{ old('module') == $module ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $module)) }}
                                    </option>
                                @endforeach
                                <option value="nuevo">➕ Crear nuevo módulo</option>
                            </select>
                            @error('module')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="newModuleGroup" style="display: none;">
                            <label for="new_module">Nuevo Módulo</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="new_module" 
                                   placeholder="ej: nuevo_modulo">
                        </div>
                        
                        <div class="form-group">
                            <label for="action">Acción *</label>
                            <select class="form-control @error('action') is-invalid @enderror" 
                                    id="action" 
                                    name="action" 
                                    required>
                                <option value="">Seleccionar acción...</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ old('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                @endforeach
                                <option value="nueva">➕ Crear nueva acción</option>
                            </select>
                            @error('action')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="newActionGroup" style="display: none;">
                            <label for="new_action">Nueva Acción</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="new_action" 
                                   placeholder="ej: nueva_accion">
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Nombre del Permiso *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Se generará automáticamente"
                                   readonly>
                            <small class="form-text text-muted">
                                Se genera automáticamente como: módulo.acción
                            </small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Nombre Para Mostrar *</label>
                            <input type="text" 
                                   class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" 
                                   name="display_name" 
                                   value="{{ old('display_name') }}" 
                                   placeholder="Se generará automáticamente"
                                   required>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Describe para qué sirve este permiso...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                💾 Crear Permiso
                            </button>
                            <a href="{{ route('admin.permissions') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const moduleSelect = document.getElementById('module');
    const actionSelect = document.getElementById('action');
    const nameInput = document.getElementById('name');
    const displayNameInput = document.getElementById('display_name');
    const newModuleGroup = document.getElementById('newModuleGroup');
    const newActionGroup = document.getElementById('newActionGroup');
    
    function updatePermissionName() {
        let module = moduleSelect.value;
        let action = actionSelect.value;
        
        if (module === 'nuevo') {
            module = document.getElementById('new_module').value;
        }
        
        if (action === 'nueva') {
            action = document.getElementById('new_action').value;
        }
        
        if (module && action) {
            nameInput.value = module + '.' + action;
            
            const moduleDisplay = module.replace(/_/g, ' ');
            const actionDisplay = action.charAt(0).toUpperCase() + action.slice(1);
            displayNameInput.value = actionDisplay + ' ' + moduleDisplay.charAt(0).toUpperCase() + moduleDisplay.slice(1);
        }
    }
    
    moduleSelect.addEventListener('change', function() {
        if (this.value === 'nuevo') {
            newModuleGroup.style.display = 'block';
        } else {
            newModuleGroup.style.display = 'none';
        }
        updatePermissionName();
    });
    
    actionSelect.addEventListener('change', function() {
        if (this.value === 'nueva') {
            newActionGroup.style.display = 'block';
        } else {
            newActionGroup.style.display = 'none';
        }
        updatePermissionName();
    });
    
    document.getElementById('new_module').addEventListener('input', updatePermissionName);
    document.getElementById('new_action').addEventListener('input', updatePermissionName);
});
</script>
@endsection