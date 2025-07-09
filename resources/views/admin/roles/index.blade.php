{{-- resources/views/admin/roles/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>🔐 Gestión de Roles del Sistema</h4>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Rol
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rol</th>
                                    <th>Descripción</th>
                                    <th>Usuarios</th>
                                    <th>Permisos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <span class="badge" style="background-color: {{ $role->color }};">
                                            {{ $role->display_name }}
                                        </span>
                                        <br><small class="text-muted">{{ $role->name }}</small>
                                    </td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $role->users_count }} usuarios
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $role->permissions_count }} permisos
                                        </span>
                                    </td>
                                    <td>
                                        @if($role->active)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-secondary">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.roles.permissions', $role) }}" 
                                               class="btn btn-sm btn-primary" title="Gestionar Permisos">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            <a href="{{ route('admin.roles.edit', $role) }}" 
                                               class="btn btn-sm btn-warning" title="Editar Rol">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
