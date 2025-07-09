{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    @isSuperAdmin
        <div class="row mb-4">
            <div class="col-md-12">
                <h1>🔧 Panel de Gestión de Roles y Permisos</h1>
                <p class="text-muted">Administración completa del sistema de usuarios y permisos</p>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_roles'] }}</h3>
                        <p>Roles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_permissions'] }}</h3>
                        <p>Permisos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p>Usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['users_with_roles'] }}</h3>
                        <p>Con Roles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['active_roles'] }}</h3>
                        <p>Roles Activos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3>1</h3>
                        <p>SuperAdmin</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones Rápidas --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>⚡ Acciones Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.roles') }}" class="btn btn-primary">
                                <i class="fas fa-user-tag"></i> Gestionar Roles
                            </a>
                            <a href="{{ route('admin.users.roles') }}" class="btn btn-success">
                                <i class="fas fa-users"></i> Asignar Roles a Usuarios
                            </a>
                            <a href="{{ route('admin.permissions') }}" class="btn btn-info">
                                <i class="fas fa-key"></i> Ver Permisos
                            </a>
                            <a href="#" onclick="migrateOldRoles()" class="btn btn-warning">
                                <i class="fas fa-sync"></i> Migrar Sistema Anterior
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribución de Roles --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>📊 Distribución de Roles</h5>
                    </div>
                    <div class="card-body">
                        @foreach($roleDistribution as $role)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    <span class="badge" style="background-color: {{ $role->color }};">
                                        {{ $role->display_name }}
                                    </span>
                                </span>
                                <span class="badge badge-secondary">{{ $role->users_count }} usuarios</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>👥 Usuarios Recientes</h5>
                    </div>
                    <div class="card-body">
                        @foreach($recentUsers as $user)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <div>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-sm" style="background-color: {{ $role->color }};">
                                            {{ $role->display_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            ⛔ Solo el Super Administrador puede acceder a esta sección.
        </div>
    @endisSuperAdmin
</div>

<script>
function migrateOldRoles() {
    if (confirm('¿Migrar usuarios del sistema anterior al nuevo sistema de roles?')) {
        fetch('{{ route("admin.migrate-roles") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endsection