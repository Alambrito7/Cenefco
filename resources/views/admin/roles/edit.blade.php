{{-- resources/views/admin/roles/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>✏️ Editar Rol: {{ $role->display_name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Nombre del Rol (interno)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   value="{{ $role->name }}" 
                                   disabled>
                            <small class="form-text text-muted">
                                El nombre interno no se puede cambiar.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Nombre Para Mostrar *</label>
                            <input type="text" 
                                   class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" 
                                   name="display_name" 
                                   value="{{ old('display_name', $role->display_name) }}" 
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
                                      rows="3">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="color">Color del Badge *</label>
                            <div class="input-group">
                                <input type="color" 
                                       class="form-control @error('color') is-invalid @enderror" 
                                       id="color" 
                                       name="color" 
                                       value="{{ old('color', $role->color) }}"
                                       style="width: 80px;">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Vista previa: <span id="colorPreview" class="badge ml-2" style="background-color: {{ $role->color }};">{{ $role->display_name }}</span>
                                    </span>
                                </div>
                            </div>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="active" 
                                       name="active" 
                                       value="1" 
                                       {{ old('active', $role->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Rol activo (los usuarios pueden ser asignados a este rol)
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                💾 Actualizar Rol
                            </button>
                            <a href="{{ route('admin.roles') }}" class="btn btn-secondary">
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
                    <h5>ℹ️ Información del Rol</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre interno:</strong> {{ $role->name }}</p>
                    <p><strong>Creado:</strong> {{ $role->created_at->format('d/m/Y') }}</p>
                    <p><strong>Usuarios asignados:</strong> 
                        <span class="badge badge-info">{{ $role->users->count() }}</span>
                    </p>
                    <p><strong>Permisos asignados:</strong> 
                        <span class="badge badge-success">{{ $role->permissions->count() }}</span>
                    </p>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <a href="{{ route('admin.roles.permissions', $role) }}" class="btn btn-primary btn-block">
                            🔧 Gestionar Permisos
                        </a>
                    </div>
                    
                    @if($role->users->count() > 0)
                        <h6>👥 Usuarios con este rol:</h6>
                        <div class="small">
                            @foreach($role->users->take(5) as $user)
                                <div class="mb-1">{{ $user->name }}</div>
                            @endforeach
                            @if($role->users->count() > 5)
                                <div class="text-muted">y {{ $role->users->count() - 5 }} más...</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('change', function() {
    const color = this.value;
    const preview = document.getElementById('colorPreview');
    preview.style.backgroundColor = color;
    preview.style.color = getContrastColor(color);
});

function getContrastColor(hexcolor) {
    const r = parseInt(hexcolor.substr(1,2),16);
    const g = parseInt(hexcolor.substr(3,2),16);
    const b = parseInt(hexcolor.substr(5,2),16);
    const yiq = ((r*299)+(g*587)+(b*114))/1000;
    return (yiq >= 128) ? 'black' : 'white';
}
</script>
@endsection