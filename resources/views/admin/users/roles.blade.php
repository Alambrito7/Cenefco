{{-- resources/views/admin/users/roles.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>👥 Gestión de Roles de Usuarios</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Roles Actuales</th>
                                    <th>Rol Anterior</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-sm mr-1" 
                                                      style="background-color: {{ $role->color }};">
                                                    {{ $role->display_name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin roles asignados</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->role)
                                            <span class="badge badge-secondary">{{ $user->role }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.manage-roles', $user) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-user-cog"></i> Gestionar
                                            </a>
                                            <button type="button" class="btn btn-sm btn-info" 
                                                    onclick="showUserPermissions({{ $user->id }})">
                                                <i class="fas fa-eye"></i> Ver Permisos
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Paginación --}}
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para mostrar permisos del usuario --}}
<div class="modal fade" id="userPermissionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permisos del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userPermissionsContent">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showUserPermissions(userId) {
    $('#userPermissionsModal').modal('show');
    
    fetch(`/api/admin/users/${userId}/permissions`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="mb-3">
                    <h6>👤 ${data.user.name}</h6>
                    <p class="text-muted">${data.user.email}</p>
                </div>
                
                <div class="mb-3">
                    <h6>🏷️ Roles:</h6>
                    ${data.roles.map(role => 
                        `<span class="badge mr-1" style="background-color: ${role.color};">${role.display_name}</span>`
                    ).join('')}
                </div>
                
                <div>
                    <h6>🔑 Permisos por Módulo:</h6>
            `;
            
            Object.keys(data.permissions).forEach(module => {
                html += `
                    <div class="mb-2">
                        <strong>${module.replace('_', ' ')}:</strong>
                        ${data.permissions[module].map(perm => 
                            `<span class="badge badge-light mr-1">${perm.action}</span>`
                        ).join('')}
                    </div>
                `;
            });
            
            html += '</div>';
            document.getElementById('userPermissionsContent').innerHTML = html;
        });
}
</script>
@endsection
