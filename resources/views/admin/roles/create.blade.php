{{-- resources/views/admin/roles/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>➕ Crear Nuevo Rol</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Nombre del Rol (interno) *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="ej: agente_soporte"
                                   required>
                            <small class="form-text text-muted">
                                Solo letras minúsculas, números y guiones bajos. Este nombre se usa internamente.
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
                                   placeholder="ej: Agente de Soporte"
                                   required>
                            <small class="form-text text-muted">
                                Este es el nombre que verán los usuarios.
                            </small>
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
                                      placeholder="Describe las responsabilidades de este rol...">{{ old('description') }}</textarea>
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
                                       value="{{ old('color', '#007bff') }}"
                                       style="width: 80px;">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Vista previa: <span id="colorPreview" class="badge ml-2">Nuevo Rol</span>
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
                                       {{ old('active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Rol activo (los usuarios pueden ser asignados a este rol)
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                💾 Crear Rol
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

// Actualizar automáticamente el display name basado en el name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const displayName = document.getElementById('display_name');
    
    if (!displayName.value) {
        // Convertir snake_case a Title Case
        const formatted = name.replace(/_/g, ' ')
                             .replace(/\b\w/g, l => l.toUpperCase());
        displayName.value = formatted;
    }
});
</script>
@endsection
