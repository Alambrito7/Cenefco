@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container py-5">
        <!-- Main Card Container -->
        <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <!-- Header Section -->
            <div class="card-header bg-white border-0 py-4">
                <div class="text-center mb-4">
                    <h1 class="display-6 fw-bold text-dark mb-2">
                        <i class="fas fa-users me-3" style="color: #667eea;"></i>
                        Gestión de Personal
                    </h1>
                    <p class="text-muted mb-0">Administra y supervisa toda la información de tu personal</p>
                </div>

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                            <div class="card-body text-center py-4">
                                <div class="display-4 fw-bold text-primary mb-2">{{ $personalsActivos->count() }}</div>
                                <div class="text-muted fw-medium">Personal Activo</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                            <div class="card-body text-center py-4">
                                <div class="display-4 fw-bold text-danger mb-2">{{ $personalsEliminados->count() }}</div>
                                <div class="text-muted fw-medium">Personal Eliminado</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                            <div class="card-body text-center py-4">
                                <div class="display-4 fw-bold text-success mb-2">{{ $personalsActivos->count() + $personalsEliminados->count() }}</div>
                                <div class="text-muted fw-medium">Total de Personal</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Controls Section -->
                <div class="row g-3 align-items-center">
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" id="buscador" class="form-control ps-5 py-3" 
                                   placeholder="Buscar por nombre, CI, email o celular..." 
                                   onkeyup="filtrarPersonal()" 
                                   style="border-radius: 15px; border: 1px solid #e9ecef; background: #f8f9fa;">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex gap-2 justify-content-lg-end">
                            <a href="{{ route('personals.export.pdf') }}" class="btn btn-danger px-4 py-2" style="border-radius: 10px;">
                                <i class="fas fa-file-pdf me-2"></i>PDF
                            </a>
                            <a href="{{ route('personals.export.excel') }}" class="btn btn-success px-4 py-2" style="border-radius: 10px;">
                                <i class="fas fa-file-excel me-2"></i>EXCEL
                            </a>
                            <a href="{{ route('personals.create') }}" class="btn px-4 py-2 text-white" style="background: #667eea; border-radius: 10px;">
                                <i class="fas fa-plus me-2"></i>NUEVO PERSONAL
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Personnel Table -->
            <div class="card-body p-0">
                <!-- Table Header -->
                <div class="px-4 py-3" style="background: #2c3e50; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-user-check me-2"></i>
                            Personal Activo
                        </h5>
                        <span class="badge bg-light text-dark px-3 py-2">{{ $personalsActivos->count() }} personal</span>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #667eea; color: white;">
                            <tr>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-hashtag me-2"></i>ID
                                </th>
                                <th class="py-3 fw-bold">
                                    <i class="fas fa-user me-2"></i>PERSONAL
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-id-card me-2"></i>CI
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-envelope me-2"></i>EMAIL
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-phone me-2"></i>CELULAR
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-map-marker-alt me-2"></i>UBICACIÓN
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-venus-mars me-2"></i>GÉNERO
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-globe me-2"></i>PAÍS
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-briefcase me-2"></i>PROFESIÓN
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-graduation-cap me-2"></i>GRADO
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-birthday-cake me-2"></i>EDAD
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-toggle-on me-2"></i>ESTADO
                                </th>
                                <th class="text-center py-3 fw-bold">
                                    <i class="fas fa-cogs me-2"></i>ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody id="personalTableBody">
                            @forelse($personalsActivos as $index => $personal)
                                <tr class="align-middle">
                                    <td class="text-center py-3">
                                        <span class="fw-bold">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if($personal->foto)
                                                    <img src="{{ asset('storage/' . $personal->foto) }}" 
                                                         alt="Foto" 
                                                         class="rounded-circle border" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $personal->nombre }}</div>
                                                <div class="fw-bold text-dark">{{ $personal->apellido_paterno }}</div>
                                                <small class="text-muted">{{ $personal->apellido_materno }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->ci ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->correo ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->telefono ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->ubicacion ?? 'La Paz' }}</span>
                                        <br><small class="text-muted">{{ $personal->ciudad ?? 'Bolivia' }}</small>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->genero ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">Bolivia</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->cargo ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->nivel_educativo ?? 'Licenciatura' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="fw-medium">{{ $personal->edad ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="badge bg-success px-3 py-2 fw-bold" style="border-radius: 20px;">ACTIVO</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button class="btn btn-sm btn-warning fw-bold px-3" 
                                                    style="border-radius: 8px;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#verPersonalModal{{ $personal->id }}">
                                                <i class="fas fa-eye me-1"></i>VER
                                            </button>
                                            <a href="{{ route('personals.edit', $personal) }}" 
                                               class="btn btn-sm btn-primary fw-bold px-3" 
                                               style="border-radius: 8px;">
                                                <i class="fas fa-edit me-1"></i>EDITAR
                                            </a>
                                            <button class="btn btn-sm btn-danger fw-bold px-3" 
                                                    style="border-radius: 8px;"
                                                    onclick="confirmarEliminacion({{ $personal->id }})">
                                                <i class="fas fa-trash me-1"></i>ELIMINAR
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal for Personal Details -->
                                <div class="modal fade" id="verPersonalModal{{ $personal->id }}" tabindex="-1" 
                                     aria-labelledby="verPersonalModalLabel{{ $personal->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                            <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                                                <h5 class="modal-title fw-bold" id="verPersonalModalLabel{{ $personal->id }}">
                                                    <i class="fas fa-user-circle me-2"></i>
                                                    Información de {{ $personal->nombre }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" 
                                                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-4 text-center mb-4">
                                                        @if($personal->foto)
                                                            <img src="{{ asset('storage/' . $personal->foto) }}" 
                                                                 alt="Foto" 
                                                                 class="img-fluid rounded-circle shadow mb-3" 
                                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3 shadow" 
                                                                 style="width: 150px; height: 150px; font-size: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        @endif
                                                        <h5 class="fw-bold" style="color: #667eea;">{{ $personal->cargo }}</h5>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="row g-3">
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">NOMBRE COMPLETO</small>
                                                                        <div class="fw-bold">{{ $personal->nombre }} {{ $personal->apellido_paterno }} {{ $personal->apellido_materno }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">CÉDULA DE IDENTIDAD</small>
                                                                        <div class="fw-bold">{{ $personal->ci }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">EDAD</small>
                                                                        <div class="fw-bold">{{ $personal->edad }} años</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">GÉNERO</small>
                                                                        <div class="fw-bold">{{ $personal->genero }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">TELÉFONO</small>
                                                                        <div class="fw-bold">
                                                                            <a href="tel:{{ $personal->telefono }}" class="text-decoration-none">
                                                                                {{ $personal->telefono }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                                                    <div class="card-body p-3">
                                                                        <small class="text-muted d-block fw-bold">CORREO ELECTRÓNICO</small>
                                                                        <div class="fw-bold">
                                                                            <a href="mailto:{{ $personal->correo }}" class="text-decoration-none">
                                                                                {{ $personal->correo }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
                                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">
                                                    <i class="fas fa-times me-2"></i>Cerrar
                                                </button>
                                                <a href="{{ route('personals.edit', $personal) }}" class="btn btn-primary px-4" style="border-radius: 10px;">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3" style="color: #667eea;"></i>
                                            <h5>No hay personal registrado</h5>
                                            <p>Comienza agregando tu primer empleado</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination if needed -->
                <div class="px-4 py-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <i class="fas fa-angle-left me-2"></i>
                            <span>Página 1 de 1</span>
                        </div>
                        <div class="text-muted">
                            <span>Mostrando {{ $personalsActivos->count() }} registros</span>
                            <i class="fas fa-angle-right ms-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deleted Personnel Section -->
        @if($personalsEliminados->count() > 0)
        <div class="card border-0 shadow-lg mt-5" style="border-radius: 20px; overflow: hidden;">
            <div class="px-4 py-3" style="background: #e74c3c; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-times me-2"></i>
                        Personal Eliminado
                    </h5>
                    <span class="badge bg-light text-dark px-3 py-2">{{ $personalsEliminados->count() }} eliminados</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 fw-bold">ID</th>
                                <th class="py-3 fw-bold">Nombre</th>
                                <th class="py-3 fw-bold">Teléfono</th>
                                <th class="py-3 fw-bold">Correo</th>
                                <th class="py-3 fw-bold">Cargo</th>
                                <th class="text-center py-3 fw-bold">Estado</th>
                                <th class="text-center py-3 fw-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personalsEliminados as $personal)
                                <tr class="text-muted align-middle">
                                    <td class="py-3">{{ $personal->id }}</td>
                                    <td class="py-3">{{ $personal->nombre }} {{ $personal->apellido_paterno }} {{ $personal->apellido_materno }}</td>
                                    <td class="py-3">{{ $personal->telefono }}</td>
                                    <td class="py-3">{{ $personal->correo }}</td>
                                    <td class="py-3">{{ $personal->cargo }}</td>
                                    <td class="text-center py-3">
                                        <span class="badge bg-danger px-3 py-2 fw-bold" style="border-radius: 20px;">ELIMINADO</span>
                                    </td>
                                    <td class="text-center py-3">
                                        <button class="btn btn-sm btn-success fw-bold px-3" 
                                                style="border-radius: 8px;"
                                                onclick="confirmarRestauracion({{ $personal->id }})">
                                            <i class="fas fa-undo me-1"></i>RESTAURAR
                                        </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-danger text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">¿Estás seguro de que deseas eliminar este personal?</p>
                <p class="text-muted mb-0">Esta acción se puede deshacer posteriormente.</p>
            </div>
            <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4" style="border-radius: 10px;">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold" id="restoreModalLabel">
                    <i class="fas fa-undo me-2"></i>
                    Confirmar Restauración
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">¿Deseas restaurar este personal?</p>
                <p class="text-muted mb-0">El personal volverá a estar activo en el sistema.</p>
            </div>
            <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                <form id="restoreForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">
                        <i class="fas fa-undo me-2"></i>Restaurar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Función de búsqueda
function filtrarPersonal() {
    const input = document.getElementById("buscador").value.toLowerCase();
    const tableRows = document.querySelectorAll("#personalTableBody tr");
    
    tableRows.forEach(row => {
        const texto = row.innerText.toLowerCase();
        row.style.display = texto.includes(input) ? "" : "none";
    });
}

// Confirmación de eliminación
function confirmarEliminacion(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/personals/${id}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Confirmación de restauración
function confirmarRestauracion(id) {
    const form = document.getElementById('restoreForm');
    form.action = `/personals/${id}/restore`;
    const modal = new bootstrap.Modal(document.getElementById('restoreModal'));
    modal.show();
}

// Cerrar alertas automáticamente
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (alert.classList.contains('show')) {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }
    });
}, 5000);
</script>
@endsection