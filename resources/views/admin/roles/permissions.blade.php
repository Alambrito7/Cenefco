{{-- resources/views/admin/roles/permissions.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>🔧 Permisos para: 
                        <span class="badge" style="background-color: {{ $role->color }};">
                            {{ $role->display_name }}
                        </span>
                    </h4>
                    <a href="{{ route('admin.roles') }}" class="btn btn-secondary float-right">
                        ← Volver a Roles
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.permissions.update', $role) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="selectAll()">
                                ✅ Seleccionar Todos
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deselectAll()">
                                ❌ Deseleccionar Todos
                            </button>
                        </div>
                        
                        @foreach($permissions as $module => $modulePermissions)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="border-bottom pb-2">
                                    📋 {{ ucfirst(str_replace('_', ' ', $module)) }}
                                </h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="toggleModule('{{ $module }}')">
                                    Alternar Módulo
                                </button>
                            </div>
                            
                            <div class="row" data-module="{{ $module }}">
                                @foreach($modulePermissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input module-{{ $module }}" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               id="permission_{{ $permission->id }}"
                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            <strong>{{ ucfirst($permission->action) }}</strong>
                                            <br><small class="text-muted">{{ $permission->display_name }}</small>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                💾 Guardar Permisos
                            </button>
                            <a href="{{ route('admin.roles') }}" class="btn btn-secondary">
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
function toggleModule(module) {
    const checkboxes = document.querySelectorAll('.module-' + module);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
}

function selectAll() {
    document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(cb => {
        cb.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(cb => {
        cb.checked = false;
    });
}
</script>
@endsection
