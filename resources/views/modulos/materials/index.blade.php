{{-- resources/views/modulos/materials/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold text-primary mb-2">
                <i class="fas fa-folder-open me-2"></i>Almacenamiento de Material
            </h1>
            <p class="text-muted">Gestión de archivos PDF y enlaces de video por área</p>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Barra de herramientas -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <a href="{{ route('materials.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Nuevo Material
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Buscar material</label>
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Buscar por descripción...">
                    </div>
                    <div class="col-md-3">
    <label class="form-label">Filtrar por tipo</label>
    <select class="form-select" id="typeFilter">
        <option value="">Todos los tipos</option>
        <option value="pdf">📄 PDF</option>
        <option value="image">🖼️ Imagen</option>
        <option value="document">📝 Documento Word</option>
        <option value="executable">⚙️ Ejecutable</option>
        <option value="compressed">🗃️ Archivo Comprimido</option>
        <option value="video">🎥 Video</option>
    </select>
</div>
                    <div class="col-md-3">
                        <label class="form-label">Filtrar por área</label>
                        <select class="form-select" id="areaFilter">
                            <option value="">Todas las áreas</option>
                            @foreach($materials->pluck('rama')->unique()->sort() as $area)
                                <option value="{{ $area }}">{{ $area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                            <i class="fas fa-times me-2"></i>Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas actualizadas -->
<!-- Reemplaza la sección de estadísticas en tu index.blade.php -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total</h6>
                        <h4 class="mb-0">{{ $stats['total'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-folder fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">PDFs</h6>
                        <h4 class="mb-0">{{ $stats['pdfs'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-pdf fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Imágenes</h6>
                        <h4 class="mb-0">{{ $stats['images'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-image fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Docs</h6>
                        <h4 class="mb-0">{{ $stats['documents'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-word fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Programas</h6>
                        <h4 class="mb-0">{{ $stats['executables'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cog fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Archivos</h6>
                        <h4 class="mb-0">{{ $stats['compressed'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-archive fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Segunda fila para videos y eliminados -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Videos</h6>
                        <h4 class="mb-0">{{ $stats['videos'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-video fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Eliminados</h6>
                        <h4 class="mb-0">{{ $stats['deleted'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-trash fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Espacio vacío para mantener el diseño -->
    <div class="col-md-8"></div>
</div>
        <!-- Tabla principal -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Listado de Materiales
                    <span class="badge bg-primary ms-2" id="contador-resultados">{{ $materials->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="materialsTable">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Área</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Archivo/Enlace</th>
                                <th class="text-center">Fecha Creación</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <!-- Reemplaza la sección de la tabla en tu index.blade.php -->
<tbody>
    @forelse($materials as $material)
    <tr class="material-row">
        <td class="text-center fw-bold">
            <span class="badge bg-light text-dark">{{ $material->id }}</span>
        </td>
        <td class="text-center">
            <span class="badge bg-{{ $material->getTypeColor() }}">
                <i class="{{ $material->getTypeIcon() }} me-1"></i>{{ $material->getTypeLabel() }}
            </span>
        </td>
        <td class="text-center">
            <span class="badge bg-info">{{ $material->rama }}</span>
        </td>
        <td class="text-center">
            <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                  title="{{ $material->description }}">
                {{ $material->description }}
            </span>
        </td>
        <td class="text-center">
            @if($material->isFile())
                <div>
                    <strong>{{ $material->file_name }}</strong>
                    <br>
                    <small class="text-muted">{{ $material->file_size }}</small>
                    @if($material->mime_type)
                        <br>
                        <span class="badge bg-secondary" style="font-size: 0.7em;">{{ $material->mime_type }}</span>
                    @endif
                </div>
            @else
                <a href="{{ $material->video_url }}" target="_blank" 
                   class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-external-link-alt me-1"></i>Ver Video
                </a>
            @endif
        </td>
        <td class="text-center">
            <small class="text-muted">
                {{ $material->created_at->format('d/m/Y H:i') }}
            </small>
        </td>
        <td class="text-center">
            <div class="btn-group" role="group">
                <!-- Ver/Descargar/Preview -->
                @if($material->isFile())
                    @if($material->isImage())
                        <a href="{{ route('materials.preview', $material) }}" 
                           class="btn btn-info btn-sm" 
                           title="Vista previa"
                           target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                    <a href="{{ route('materials.download', $material) }}" 
                       class="btn btn-success btn-sm" 
                       title="Descargar archivo">
                        <i class="fas fa-download"></i>
                    </a>
                @else
                    <a href="{{ $material->video_url }}" target="_blank"
                       class="btn btn-info btn-sm" 
                       title="Ver video">
                        <i class="fas fa-play"></i>
                    </a>
                @endif
                
                <!-- Editar -->
                <a href="{{ route('materials.edit', $material) }}" 
                   class="btn btn-warning btn-sm" 
                   title="Editar material">
                    <i class="fas fa-edit"></i>
                </a>
                
                <!-- Eliminar -->
                <form action="{{ route('materials.destroy', $material) }}" 
                      method="POST" 
                      style="display: inline;" 
                      onsubmit="return confirm('¿Está seguro de eliminar este material?')">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="btn btn-danger btn-sm" 
                            title="Eliminar material">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center py-5">
            <div class="text-muted">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <h5>No hay materiales registrados</h5>
                <p>Comience agregando un nuevo material</p>
                <a href="{{ route('materials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Agregar Primer Material
                </a>
            </div>
        </td>
    </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Materiales eliminados -->
        @if($materialsDeleted->count() > 0)
            <div class="card mt-5">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-trash-restore me-2"></i>Materiales Eliminados
                        <span class="badge bg-light text-dark ms-2">{{ $materialsDeleted->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Área</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Fecha Eliminación</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materialsDeleted as $material)
                                <tr>
                                    <td class="text-center fw-bold">{{ $material->id }}</td>
                                    <td class="text-center">
                                        @if($material->isPdf())
                                            <span class="badge bg-danger">PDF</span>
                                        @else
                                            <span class="badge bg-success">Video</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $material->rama }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                            {{ $material->description }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $material->deleted_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Restaurar -->
                                            <form action="{{ route('materials.restore', $material->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('¿Desea restaurar este material?')">
                                                @csrf @method('PUT')
                                                <button type="submit" 
                                                        class="btn btn-success btn-sm" 
                                                        title="Restaurar material">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Eliminar permanentemente -->
                                            <form action="{{ route('materials.force-destroy', $material->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('¿ELIMINAR PERMANENTEMENTE? Esta acción no se puede deshacer.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Eliminar permanentemente">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de búsqueda y filtros
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const areaFilter = document.getElementById('areaFilter');
    const table = document.getElementById('materialsTable');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const typeValue = typeFilter.value;
        const areaValue = areaFilter.value;
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let contador = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            if (row.classList.contains('material-row')) {
                const description = row.cells[3].textContent.toLowerCase();
                const type = row.cells[1].textContent.toLowerCase();
                const area = row.cells[2].textContent.trim();
                
                const matchesSearch = description.includes(searchTerm);
                const matchesType = !typeValue || type.includes(typeValue);
                const matchesArea = !areaValue || area.includes(areaValue);
                
                if (matchesSearch && matchesType && matchesArea) {
                    row.style.display = '';
                    contador++;
                } else {
                    row.style.display = 'none';
                }
            }
        }
        
        // Actualizar contador
        document.getElementById('contador-resultados').textContent = contador;
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
    areaFilter.addEventListener('change', filterTable);
});

// Función para limpiar filtros
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    document.getElementById('areaFilter').value = '';
    
    // Mostrar todas las filas
    const rows = document.querySelectorAll('#materialsTable tbody .material-row');
    rows.forEach(row => row.style.display = '');
    
    // Actualizar contador
    document.getElementById('contador-resultados').textContent = rows.length;
}
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.material-row {
    transition: all 0.3s ease;
}

.material-row:hover {
    transform: translateY(-1px);
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}
</style>
@endsection