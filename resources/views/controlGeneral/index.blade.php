@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Header con estadísticas -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-gradient-primary text-black">
                    <h2 class="mb-0 text-center">📦 Control General de Transacciones</h2>
                </div>
                <div class="card-body">
                    @if(isset($transaccionesAgrupadas) && $transaccionesAgrupadas->isNotEmpty())
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <h4 class="text-primary">{{ $transaccionesAgrupadas->count() }}</h4>
                                    <p class="text-muted mb-0">📚 Cursos Activos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <h4 class="text-success">{{ $transaccionesAgrupadas->flatten()->count() }}</h4>
                                    <p class="text-muted mb-0">💰 Total Transacciones</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <h4 class="text-info">Bs. {{ number_format($transaccionesAgrupadas->flatten()->sum('monto'), 2) }}</h4>
                                    <p class="text-muted mb-0">💵 Monto Total</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <h4 class="text-warning">{{ $transaccionesAgrupadas->flatten()->unique('venta.cliente.id')->count() }}</h4>
                                    <p class="text-muted mb-0">👥 Clientes Únicos</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <h5>No hay transacciones disponibles</h5>
                                <p class="mb-0">No se encontraron transacciones en el sistema. Verifique que los datos estén siendo enviados correctamente desde el controlador.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(isset($transaccionesAgrupadas) && $transaccionesAgrupadas->isNotEmpty())
                <!-- Filtros y búsqueda -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="filtro-curso" class="form-label fw-bold">🔍 Filtrar por Curso</label>
                                <select id="filtro-curso" class="form-select">
                                    <option value="">Todos los cursos</option>
                                    @foreach($transaccionesAgrupadas as $cursoNombre => $transacciones)
                                        <option value="{{ $cursoNombre }}">{{ $cursoNombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filtro-banco" class="form-label fw-bold">🏦 Filtrar por Banco</label>
                                <select id="filtro-banco" class="form-select">
                                    <option value="">Todos los bancos</option>
                                    @foreach($transaccionesAgrupadas->flatten()->unique('banco') as $transaccion)
                                        <option value="{{ $transaccion->banco }}">{{ $transaccion->banco }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="buscar-cliente" class="form-label fw-bold">👤 Buscar Cliente</label>
                                <input type="text" id="buscar-cliente" class="form-control" placeholder="Nombre o celular...">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="btn btn-outline-secondary btn-sm" onclick="limpiarFiltros()">
                                    🔄 Limpiar Filtros
                                </button>
                                <button class="btn btn-outline-success btn-sm" onclick="exportarDatos()">
                                    📊 Exportar Datos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Iteramos sobre los cursos agrupados -->
                @foreach($transaccionesAgrupadas as $cursoNombre => $transacciones)
                    <div class="curso-section mb-5" data-curso="{{ $cursoNombre }}">
                        <!-- Header del curso -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h3 class="mb-0 text-primary">
                                            <i class="fas fa-graduation-cap"></i> {{ $cursoNombre }}
                                        </h3>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="d-flex justify-content-end align-items-center flex-wrap">
                                            <span class="badge bg-primary me-2 mb-1">{{ $transacciones->count() }} transacciones</span>
                                            <span class="badge bg-success me-2 mb-1">Bs. {{ number_format($transacciones->sum('monto'), 2) }}</span>
                                            <button class="btn btn-sm btn-outline-primary mb-1" onclick="toggleTable('{{ Str::slug($cursoNombre) }}')">
                                                <i class="fas fa-eye" id="toggle-icon-{{ Str::slug($cursoNombre) }}"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0 table-container" id="table-{{ Str::slug($cursoNombre) }}">
                                <!-- Tabla de transacciones para cada curso -->
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 transacciones-table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="sortable" data-column="cliente">
                                                    👤 Cliente <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="celular">
                                                    📱 Celular <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="grado">
                                                    🎓 Grado Académico <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="ciudad">
                                                    🏙️ Ciudad <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="grabaciones">
                                                    📹 Grabaciones <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="monto">
                                                    💰 Monto <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="banco">
                                                    🏦 Banco <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="transaccion">
                                                    🔢 Transacción <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="sortable" data-column="fecha">
                                                    📅 Fecha y Hora <i class="fas fa-sort"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transacciones as $transaccion)
                                                <tr class="transaccion-row" 
                                                    data-curso="{{ $cursoNombre }}"
                                                    data-banco="{{ $transaccion->banco ?? 'Sin banco' }}"
                                                    data-cliente="{{ strtolower(($transaccion->venta->cliente->nombre ?? '') . ' ' . ($transaccion->venta->cliente->apellido_paterno ?? '')) }}"
                                                    data-celular="{{ $transaccion->venta->cliente->celular ?? '' }}">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                                {{ substr($transaccion->venta->cliente->nombre ?? 'S', 0, 1) }}
                                                            </div>
                                                            <div>
                                                                <strong>
                                                                    {{ $transaccion->venta->cliente->nombre ?? 'Sin nombre' }} 
                                                                    {{ $transaccion->venta->cliente->apellido_paterno ?? '' }}
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($transaccion->venta->cliente->celular ?? false)
                                                            <a href="https://wa.me/591{{ $transaccion->venta->cliente->celular }}" 
                                                               class="text-success text-decoration-none" 
                                                               target="_blank">
                                                                <i class="fab fa-whatsapp"></i> {{ $transaccion->venta->cliente->celular }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Sin celular</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ $transaccion->venta->cliente->grado_academico ?? 'Sin especificar' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-map-marker-alt text-danger"></i> 
                                                        {{ $transaccion->venta->cliente->departamento ?? 'Sin especificar' }}
                                                    </td>
                                                    <td>
                                                        @if(isset($transaccion->venta->entregaMaterial->opcion_entrega))
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check"></i> {{ $transaccion->venta->entregaMaterial->opcion_entrega }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-exclamation-triangle"></i> No disponible
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            Bs. {{ number_format($transaccion->monto ?? 0, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $transaccion->banco ?? 'Sin banco' }}</span>
                                                    </td>
                                                    <td>
                                                        <code class="bg-light px-2 py-1 rounded">
                                                            {{ $transaccion->nro_transaccion ?? 'Sin número' }}
                                                        </code>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ isset($transaccion->fecha_hora) ? \Carbon\Carbon::parse($transaccion->fecha_hora)->format('d/m/Y H:i') : 'Sin fecha' }}
                                                        </small>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-4">
                                                        <div class="alert alert-warning mb-0">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            No hay transacciones para el curso "{{ $cursoNombre }}"
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Resumen final -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="text-muted">📊 Resumen Final</h5>
                        <p class="mb-0">
                            Se encontraron <strong>{{ $transaccionesAgrupadas->flatten()->count() }}</strong> transacciones 
                            distribuidas en <strong>{{ $transaccionesAgrupadas->count() }}</strong> cursos diferentes.
                        </p>
                    </div>
                </div>
            @else
                <!-- Mensaje cuando no hay datos -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-database fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay transacciones disponibles</h4>
                            <p class="text-muted mb-4">
                                Parece que no hay transacciones en el sistema o hay un problema con la conexión a la base de datos.
                            </p>
                        </div>
                        <div class="alert alert-info">
                            <h6><i class="fas fa-lightbulb"></i> Posibles soluciones:</h6>
                            <ul class="text-start mb-0">
                                <li>Verificar que la variable <code>$transaccionesAgrupadas</code> esté siendo enviada desde el controlador</li>
                                <li>Comprobar que existan registros en la base de datos</li>
                                <li>Revisar las relaciones entre modelos (venta, cliente, entregaMaterial)</li>
                                <li>Verificar la conexión a la base de datos</li>
                            </ul>
                        </div>
                        <button class="btn btn-primary" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Recargar Página
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Solo ejecutar si hay transacciones
    if (document.querySelector('.transacciones-table')) {
        // Filtros
        const filtroCurso = document.getElementById('filtro-curso');
        const filtroBanco = document.getElementById('filtro-banco');
        const buscarCliente = document.getElementById('buscar-cliente');

        // Event listeners para filtros
        if (filtroCurso) filtroCurso.addEventListener('change', aplicarFiltros);
        if (filtroBanco) filtroBanco.addEventListener('change', aplicarFiltros);
        if (buscarCliente) buscarCliente.addEventListener('input', aplicarFiltros);

        // Función para aplicar filtros
        function aplicarFiltros() {
            const cursoSeleccionado = filtroCurso ? filtroCurso.value.toLowerCase() : '';
            const bancoSeleccionado = filtroBanco ? filtroBanco.value.toLowerCase() : '';
            const clienteBuscado = buscarCliente ? buscarCliente.value.toLowerCase() : '';

            // Filtrar secciones de cursos
            document.querySelectorAll('.curso-section').forEach(section => {
                const cursoNombre = section.dataset.curso.toLowerCase();
                let mostrarSeccion = true;

                if (cursoSeleccionado && !cursoNombre.includes(cursoSeleccionado)) {
                    mostrarSeccion = false;
                }

                if (mostrarSeccion) {
                    // Filtrar filas dentro de la sección
                    const filas = section.querySelectorAll('.transaccion-row');
                    let filasVisibles = 0;

                    filas.forEach(fila => {
                        const banco = fila.dataset.banco.toLowerCase();
                        const cliente = fila.dataset.cliente;
                        const celular = fila.dataset.celular;

                        let mostrarFila = true;

                        if (bancoSeleccionado && !banco.includes(bancoSeleccionado)) {
                            mostrarFila = false;
                        }

                        if (clienteBuscado && 
                            !cliente.includes(clienteBuscado) && 
                            !celular.includes(clienteBuscado)) {
                            mostrarFila = false;
                        }

                        fila.style.display = mostrarFila ? '' : 'none';
                        if (mostrarFila) filasVisibles++;
                    });

                    section.style.display = filasVisibles > 0 ? '' : 'none';
                } else {
                    section.style.display = 'none';
                }
            });
        }

        // Ordenamiento de tablas
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.column;
                const table = this.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Alternar orden
                const isAsc = this.classList.contains('asc');
                
                // Remover clases de orden de todos los headers
                table.querySelectorAll('.sortable').forEach(h => {
                    h.classList.remove('asc', 'desc');
                });
                
                // Agregar clase de orden al header actual
                this.classList.add(isAsc ? 'desc' : 'asc');
                
                // Ordenar filas
                rows.sort((a, b) => {
                    const aValue = getColumnValue(a, column);
                    const bValue = getColumnValue(b, column);
                    
                    if (column === 'monto') {
                        return isAsc ? bValue - aValue : aValue - bValue;
                    }
                    
                    return isAsc ? bValue.localeCompare(aValue) : aValue.localeCompare(bValue);
                });
                
                // Reinsertarlas en el tbody
                rows.forEach(row => tbody.appendChild(row));
            });
        });

        function getColumnValue(row, column) {
            const cells = row.querySelectorAll('td');
            let value = '';
            
            switch(column) {
                case 'cliente':
                    value = cells[0] ? cells[0].textContent.trim() : '';
                    break;
                case 'celular':
                    value = cells[1] ? cells[1].textContent.trim() : '';
                    break;
                case 'grado':
                    value = cells[2] ? cells[2].textContent.trim() : '';
                    break;
                case 'ciudad':
                    value = cells[3] ? cells[3].textContent.trim() : '';
                    break;
                case 'grabaciones':
                    value = cells[4] ? cells[4].textContent.trim() : '';
                    break;
                case 'monto':
                    const montoText = cells[5] ? cells[5].textContent.replace('Bs. ', '').replace(',', '') : '0';
                    value = parseFloat(montoText) || 0;
                    break;
                case 'banco':
                    value = cells[6] ? cells[6].textContent.trim() : '';
                    break;
                case 'transaccion':
                    value = cells[7] ? cells[7].textContent.trim() : '';
                    break;
                case 'fecha':
                    value = cells[8] ? cells[8].textContent.trim() : '';
                    break;
            }
            
            return value;
        }
    }

    // Función para limpiar filtros
    window.limpiarFiltros = function() {
        const filtroCurso = document.getElementById('filtro-curso');
        const filtroBanco = document.getElementById('filtro-banco');
        const buscarCliente = document.getElementById('buscar-cliente');
        
        if (filtroCurso) filtroCurso.value = '';
        if (filtroBanco) filtroBanco.value = '';
        if (buscarCliente) buscarCliente.value = '';
        
        if (typeof aplicarFiltros === 'function') {
            aplicarFiltros();
        }
    };

    // Función para alternar visibilidad de tablas
    window.toggleTable = function(cursoSlug) {
        const table = document.getElementById(`table-${cursoSlug}`);
        const icon = document.getElementById(`toggle-icon-${cursoSlug}`);
        
        if (table && icon) {
            if (table.style.display === 'none') {
                table.style.display = 'block';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                table.style.display = 'none';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    };

    // Función para exportar datos
    window.exportarDatos = function() {
        // Crear CSV simple
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Curso,Cliente,Celular,Grado,Ciudad,Grabaciones,Monto,Banco,Transaccion,Fecha\n";
        
        document.querySelectorAll('.transaccion-row').forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = [];
            
            // Extraer datos de cada celda
            rowData.push(row.dataset.curso || '');
            rowData.push(cells[0] ? cells[0].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[1] ? cells[1].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[2] ? cells[2].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[3] ? cells[3].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[4] ? cells[4].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[5] ? cells[5].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[6] ? cells[6].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[7] ? cells[7].textContent.trim().replace(/,/g, '') : '');
            rowData.push(cells[8] ? cells[8].textContent.trim().replace(/,/g, '') : '');
            
            csvContent += rowData.join(",") + "\n";
        });
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "transacciones_" + new Date().toISOString().split('T')[0] + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.stat-card {
    padding: 1rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 1rem;
}

.avatar-sm {
    width: 35px;
    height: 35px;
    font-size: 14px;
    font-weight: bold;
}

.table-responsive {
    border-radius: 8px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 14px;
    padding: 12px 8px;
}

.table td {
    vertical-align: middle;
    padding: 10px 8px;
    font-size: 14px;
}

.sortable {
    cursor: pointer;
    user-select: none;
    transition: background-color 0.2s;
}

.sortable:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.sortable.asc i::before {
    content: "\f0de";
}

.sortable.desc i::before {
    content: "\f0dd";
}

.badge {
    font-size: 11px;
    padding: 4px 8px;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.125);
    border-radius: 12px 12px 0 0 !important;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
}

code {
    font-size: 12px;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-primary {
    color: #007bff !important;
}

.alert {
    border-radius: 8px;
}

.alert ul {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 12px;
    }
    
    .d-flex.justify-content-end {
        justify-content: center !important;
    }
    
    .stat-card h4 {
        font-size: 1.2rem;
    }
    
    .badge {
        font-size: 10px;
        margin-bottom: 2px;
    }
}
</style>
@endpush
@endsection