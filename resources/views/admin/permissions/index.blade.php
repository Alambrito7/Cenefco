{{-- resources/views/admin/permissions/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>🔑 Permisos del Sistema</h4>
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Permiso
                    </a>
                </div>
                <div class="card-body">
                    @foreach($permissions as $module => $modulePermissions)
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">
                            📋 {{ ucfirst(str_replace('_', ' ', $module)) }}
                            <span class="badge badge-info">{{ $modulePermissions->count() }} permisos</span>
                        </h5>
                        <div class="row">
                            @foreach($modulePermissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="card border-light">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1">
                                            <span class="badge badge-primary">{{ $permission->action }}</span>
                                        </h6>
                                        <p class="card-text small">
                                            <strong>{{ $permission->display_name }}</strong><br>
                                            <code>{{ $permission->name }}</code>
                                        </p>
                                        @if($permission->description)
                                            <p class="card-text small text-muted">{{ $permission->description }}</p>
                                        @endif
                                        
                                        {{-- Mostrar cuántos roles tienen este permiso --}}
                                        <small class="text-info">
                                            <i class="fas fa-users"></i> {{ $permission->roles->count() }} roles
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection