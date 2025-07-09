{{-- resources/views/admin/users/manage-roles.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>👤 Gestionar Roles: {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update-roles', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <h6>🏷️ Seleccionar Roles:</h6>
                            <div class="row">
                                @foreach($availableRoles as $role)
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="roles[]" 
                                               value="{{ $role->id }}"
                                               id="role_{{ $role->id }}"
                                               {{ in_array($role->id, $userRoles) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            <span class="badge" style="background-color: {{ $role->color }};">
                                                {{ $role->display_name }}
                                            </span>
                                            <br><small class="text-muted">{{ $role->description }}</small>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                💾 Actualizar Roles
                            </button>
                            <a href="{{ route('admin.users.roles') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>ℹ️ Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Registrado:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                    <p><strong>Rol Anterior:</strong> 
                        <span class="badge badge-secondary">{{ $user->role ?? 'Sin asignar' }}</span>
                    </p>
                    
                    <hr>
                    
                    <h6>🔑 Permisos Actuales:</h6>
                    @php
                        $allPermissions = collect();
                        foreach($user->roles as $role) {
                            $allPermissions = $allPermissions->merge($role->permissions);
                        }
                        $allPermissions = $allPermissions->unique('id');
                    @endphp
                    
                    @if($allPermissions->count() > 0)
                        <div class="small">
                            @foreach($allPermissions->groupBy('module') as $module => $permissions)
                                <div class="mb-2">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $module)) }}:</strong><br>
                                    @foreach($permissions as $permission)
                                        <span class="badge badge-light badge-sm">{{ $permission->action }}</span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small">Sin permisos asignados</p>
                    @endif
                </div>
            </div>
            
            {{-- Acciones Rápidas --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6>⚡ Acciones Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical w-100" role="group">
                        @foreach($availableRoles as $role)
                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary mb-1"
                                    onclick="quickAssignRole({{ $user->id }}, {{ $role->id }}, '{{ $role->display_name }}')">
                                Asignar solo "{{ $role->display_name }}"
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function quickAssignRole(userId, roleId, roleName) {
    if (confirm(`¿Asignar SOLO el rol "${roleName}" a este usuario? (Se eliminarán otros roles)`)) {
        // Desmarcar todos los checkboxes
        document.querySelectorAll('input[name="roles[]"]').forEach(cb => cb.checked = false);
        
        // Marcar solo el rol seleccionado
        document.getElementById(`role_${roleId}`).checked = true;
        
        // Enviar el formulario
        document.querySelector('form').submit();
    }
}
</script>
@endsection