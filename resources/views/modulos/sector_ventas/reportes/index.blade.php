@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 text-gradient fw-bold">📈 Dashboard de Ventas</h2>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="exportData()">
                        <i class="fas fa-download me-1"></i> Exportar
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="refreshData()">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros mejorados --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="year-select" class="form-label fw-semibold text-muted">Año:</label>
                            <select name="year" id="year-select" class="form-select shadow-sm">
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="month-select" class="form-label fw-semibold text-muted">Mes:</label>
                            <select name="month" id="month-select" class="form-select shadow-sm">
                                <option value="">Todos los meses</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Métricas destacadas mejoradas --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 metric-card bg-gradient-primary">
                <div class="card-body text-center text-white">
                    <div class="metric-icon">
                        <i class="fas fa-chart-line fa-2x mb-3"></i>
                    </div>
                    <h6 class="card-title opacity-75">Total Ventas {{ request('year', date('Y')) }}</h6>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ array_sum($ventasPorMes) }}">0</h3>
                    <small class="opacity-75">
                        <i class="fas fa-arrow-up me-1"></i> +12% vs año anterior
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 metric-card bg-gradient-info">
                <div class="card-body text-center text-white">
                    <div class="metric-icon">
                        <i class="fas fa-users fa-2x mb-3"></i>
                    </div>
                    <h6 class="card-title opacity-75">Vendedores Activos</h6>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ count($ventasPorVendedor) }}">0</h3>
                    <small class="opacity-75">
                        <i class="fas fa-arrow-up me-1"></i> Equipo completo
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 metric-card bg-gradient-success">
                <div class="card-body text-center text-white">
                    <div class="metric-icon">
                        <i class="fas fa-book fa-2x mb-3"></i>
                    </div>
                    <h6 class="card-title opacity-75">Cursos Vendidos</h6>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ count($cursosMasVendidos) }}">0</h3>
                    <small class="opacity-75">
                        <i class="fas fa-arrow-up me-1"></i> Catálogo activo
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 metric-card bg-gradient-warning">
                <div class="card-body text-center text-white">
                    <div class="metric-icon">
                        <i class="fas fa-dollar-sign fa-2x mb-3"></i>
                    </div>
                    <h6 class="card-title opacity-75">Promedio Mensual</h6>
                    <h3 class="fw-bold mb-2 counter" data-target="{{ round(array_sum($ventasPorMes) / max(1, count($ventasPorMes))) }}">0</h3>
                    <small class="opacity-75">
                        <i class="fas fa-chart-bar me-1"></i> Por mes
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Columna izquierda --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4 chart-card">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🗓 Ventas por Mes ({{ request('year', date('Y')) }})</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasMesChart', 'bar')">Barras</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasMesChart', 'line')">Líneas</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasMesChart', 'area')">Área</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mes</th>
                                    <th class="text-end">Ventas</th>
                                    <th class="text-end">Variación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $previous = 0; @endphp
                                @foreach ($ventasPorMes as $mes => $cantidad)
                                    @php 
                                        $variation = $previous > 0 ? (($cantidad - $previous) / $previous) * 100 : 0;
                                        $previous = $cantidad;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $mes }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-primary px-3 py-2">{{ $cantidad }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge {{ $variation >= 0 ? 'bg-success' : 'bg-danger' }} px-2 py-1">
                                                <i class="fas fa-arrow-{{ $variation >= 0 ? 'up' : 'down' }}"></i>
                                                {{ number_format(abs($variation), 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="chart-container">
                        <canvas id="ventasMesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna derecha --}}
        <div class="col-lg-6">
            {{-- Ventas por Vendedor --}}
            <div class="card border-0 shadow-sm mb-4 chart-card">
                <div class="card-header bg-gradient-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📊 Ventas por Vendedor</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasVendedorChart', 'pie')">Circular</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasVendedorChart', 'doughnut')">Donut</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('ventasVendedorChart', 'bar')">Barras</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Vendedor</th>
                                    <th class="text-end">Ventas</th>
                                    <th class="text-end">Ranking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @foreach ($ventasPorVendedor as $vendedor => $cantidad)
                                    <tr>
                                        <td class="fw-semibold">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    {{ strtoupper(substr($vendedor, 0, 1)) }}
                                                </div>
                                                {{ $vendedor }}
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-info px-3 py-2">{{ $cantidad }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge {{ $rank <= 3 ? 'bg-warning' : 'bg-secondary' }} px-2 py-1">
                                                #{{ $rank }}
                                            </span>
                                        </td>
                                    </tr>
                                    @php $rank++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="chart-container">
                        <canvas id="ventasVendedorChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Cursos más Vendidos --}}
            <div class="card border-0 shadow-sm mb-4 chart-card">
                <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📚 Cursos más Vendidos</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('cursosVendidosChart', 'doughnut')">Donut</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('cursosVendidosChart', 'pie')">Circular</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeChartType('cursosVendidosChart', 'bar')">Barras</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Curso</th>
                                    <th class="text-end">Ventas</th>
                                    <th class="text-end">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = array_sum($cursosMasVendidos->toArray()); @endphp
                                @foreach ($cursosMasVendidos as $curso => $cantidad)
                                    <tr>
                                        <td class="fw-semibold">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-book-open text-success me-2"></i>
                                                {{ Str::limit($curso, 25) }}
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-success px-3 py-2">{{ $cantidad }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-muted">{{ round(($cantidad / $total) * 100, 1) }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="chart-container">
                        <canvas id="cursosVendidosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de tendencias --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="mb-0">📈 Análisis de Tendencias</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="trend-item">
                                <div class="trend-icon bg-primary">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>Mejor Mes</h6>
                                    <p class="mb-0">{{ array_keys($ventasPorMes, max($ventasPorMes))[0] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="trend-item">
                                <div class="trend-icon bg-success">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>Top Vendedor</h6>
                                    <p class="mb-0">{{ $ventasPorVendedor->keys()->first() ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="trend-item">
                                <div class="trend-icon bg-warning">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>Curso Estrella</h6>
                                    <p class="mb-0">{{ Str::limit($cursosMasVendidos->keys()->first() ?? 'N/A', 20) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos mejorados --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --info-gradient: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --dark-gradient: linear-gradient(135deg, #495057 0%, #6c757d 100%);
    }

    /* Forzar fondo blanco */
    body {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }

    .container-fluid {
        background-color: #f8f9fa !important;
        min-height: 100vh;
    }

    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .bg-gradient-primary { background: var(--primary-gradient); }
    .bg-gradient-info { background: var(--info-gradient); }
    .bg-gradient-success { background: var(--success-gradient); }
    .bg-gradient-warning { background: var(--warning-gradient); }
    .bg-gradient-dark { background: var(--dark-gradient); }

    .card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background-color: #ffffff !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }

    .metric-card {
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .metric-icon {
        position: relative;
        z-index: 2;
    }

    .chart-card {
        position: relative;
        background-color: #ffffff !important;
    }

    .chart-container {
        position: relative;
        height: 300px;
        background: #ffffff !important;
        border-radius: 10px;
        padding: 10px;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.9rem;
        background: #f8f9fa !important;
        color: #495057 !important;
    }

    .table td {
        background-color: #ffffff !important;
        color: #212529 !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05) !important;
    }
    
    .badge {
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: 20px;
    }
    
    .card-header {
        border-bottom: none;
        font-weight: 600;
        border-radius: 15px 15px 0 0;
    }

    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
    }

    .trend-item {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        background: #f8f9fa !important;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .trend-item:hover {
        background: #e9ecef !important;
        transform: translateX(5px);
    }

    .trend-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
    }

    .trend-content h6 {
        margin-bottom: 5px;
        color: #6c757d !important;
        font-size: 0.9rem;
    }

    .trend-content p {
        font-weight: 600;
        color: #212529 !important;
    }

    .loading {
        position: relative;
        overflow: hidden;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: loading 2s infinite;
    }

    @keyframes loading {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 15px;
        }
        
        .chart-container {
            height: 250px;
        }
        
        .metric-card .card-body {
            padding: 1rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración global mejorada
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;
    Chart.defaults.plugins.legend.position = 'bottom';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.padding = 20;
    Chart.defaults.font.family = "'Inter', sans-serif";

    // Datos del backend
    const ventasPorMesData = @json(array_values($ventasPorMes));
    const mesesLabels = @json(array_keys($ventasPorMes));
    const vendedorLabels = @json(array_keys($ventasPorVendedor->toArray()));
    const vendedorData = @json(array_values($ventasPorVendedor->toArray()));
    const cursosLabels = @json(array_keys($cursosMasVendidos->toArray()));
    const cursosData = @json(array_values($cursosMasVendidos->toArray()));

    // Paleta de colores moderna mejorada
    const colors = {
        primary: [
            '#667eea', '#764ba2', '#f093fb', '#f5576c', 
            '#4facfe', '#00f2fe', '#43e97b', '#38f9d7',
            '#ffecd2', '#fcb69f', '#a8edea', '#fed6e3'
        ],
        gradient: {
            blue: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            purple: 'linear-gradient(135deg, #764ba2 0%, #667eea 100%)',
            pink: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            cyan: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            green: 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'
        }
    };

    // Variables para almacenar instancias de gráficos
    let ventasMesChart, ventasVendedorChart, cursosVendidosChart;

    // Gráfico de Ventas por Mes mejorado
    function initVentasMesChart() {
        const ctx = document.getElementById('ventasMesChart').getContext('2d');
        ventasMesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: mesesLabels,
                datasets: [{
                    label: 'Ventas por mes',
                    data: ventasPorMesData,
                    backgroundColor: colors.primary.map(color => color + '80'),
                    borderColor: colors.primary,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: colors.primary,
                    hoverBorderColor: '#fff',
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Ventas: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#666',
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#666',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Ventas por Vendedor mejorado
    function initVentasVendedorChart() {
        const ctx = document.getElementById('ventasVendedorChart').getContext('2d');
        ventasVendedorChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: vendedorLabels,
                datasets: [{
                    data: vendedorData,
                    backgroundColor: colors.primary,
                    borderWidth: 4,
                    borderColor: '#fff',
                    hoverBorderWidth: 6,
                    hoverBorderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return `${context.label}: ${context.parsed} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Función para cambiar tipo de gráfico
    function changeChartType(chartId, newType) {
        let chart;
        switch(chartId) {
            case 'ventasMesChart':
                chart = ventasMesChart;
                break;
            case 'ventasVendedorChart':
                chart = ventasVendedorChart;
                break;
            case 'cursosVendidosChart':
                chart = cursosVendidosChart;
                break;
        }
        
        if (chart) {
            chart.config.type = newType;
            if (newType === 'area') {
                chart.config.type = 'line';
                chart.config.data.datasets[0].fill = true;
                chart.config.data.datasets[0].backgroundColor = colors.primary[0] + '30';
            }
            chart.update();
        }
    }

    // Contador animado para métricas
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const count = 0;
            const speed = target / 100;
            
            const updateCount = () => {
                const current = parseInt(counter.innerText);
                if (current < target) {
                    counter.innerText = Math.ceil(current + speed);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            
            updateCount();
        });
    }

    // Función para exportar datos
    function exportData() {
        const data = {
            ventasPorMes: @json($ventasPorMes),
            ventasPorVendedor: @json($ventasPorVendedor->toArray()),
            cursosMasVendidos: @json($cursosMasVendidos->toArray()),
            fecha: new Date().toISOString()
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], {
            type: 'application/json'
        });
        
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `ventas_${new Date().getFullYear()}_${new Date().getMonth() + 1}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        // Mostrar notificación
        showNotification('Datos exportados correctamente', 'success');
    }

    // Función para actualizar datos
    function refreshData() {
        // Agregar clase de loading
        document.querySelectorAll('.card').forEach(card => {
            card.classList.add('loading');
        });
        
        // Simular actualización (en producción esto sería una llamada AJAX)
        setTimeout(() => {
            document.querySelectorAll('.card').forEach(card => {
                card.classList.remove('loading');
            });
            showNotification('Datos actualizados', 'success');
            location.reload();
        }, 2000);
    }

    // Sistema de notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        `;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove después de 3 segundos
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, 3000);
    }

    // Agregar estilos para notificaciones
    const notificationStyles = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .notification {
            border: none !important;
        }
    `;
    
    const styleSheet = document.createElement('style');
    styleSheet.textContent = notificationStyles;
    document.head.appendChild(styleSheet);

    // Filtros dinámicos mejorados
    document.getElementById('year-select').addEventListener('change', function() {
        showNotification('Filtrando por año...', 'info');
        setTimeout(() => {
            this.form.submit();
        }, 500);
    });

    document.getElementById('month-select').addEventListener('change', function() {
        showNotification('Filtrando por mes...', 'info');
    });

    // Tooltips mejorados
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Responsive charts
    function handleResize() {
        if (ventasMesChart) ventasMesChart.resize();
        if (ventasVendedorChart) ventasVendedorChart.resize();
        if (cursosVendidosChart) cursosVendidosChart.resize();
    }

    window.addEventListener('resize', handleResize);

    // Inicialización cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada para las tarjetas
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                card.classList.add('fade-in-up');
            }, index * 100);
        });

        // Inicializar gráficos con delay para mejor experiencia
        setTimeout(() => {
            initVentasMesChart();
            initVentasVendedorChart();
            initCursosVendidosChart();
        }, 500);

        // Inicializar contadores animados
        setTimeout(animateCounters, 800);

        // Inicializar tooltips si Bootstrap está disponible
        if (typeof bootstrap !== 'undefined') {
            initTooltips();
        }

        // Efectos hover mejorados para las tablas
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.2s ease';
                this.style.backgroundColor = 'rgba(0,123,255,0.05)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.backgroundColor = '';
            });
        });

        // Lazy loading para gráficos (mejorar rendimiento)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const canvas = entry.target;
                    if (!canvas.dataset.initialized) {
                        canvas.dataset.initialized = 'true';
                        // Aquí se inicializarían gráficos adicionales si es necesario
                    }
                }
            });
        });

        document.querySelectorAll('canvas').forEach(canvas => {
            observer.observe(canvas);
        });

        // Efecto de paralaje sutil para el header
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const header = document.querySelector('.text-gradient');
            if (header) {
                header.style.transform = `translateY(${scrolled * 0.1}px)`;
            }
        });

        console.log('Dashboard de Ventas inicializado correctamente ✅');
    });

    // Manejo de errores global
    window.addEventListener('error', function(e) {
        console.error('Error en el dashboard:', e);
        showNotification('Se produjo un error. Por favor, recarga la página.', 'danger');
    });

    // Función para detectar modo oscuro del sistema - DESHABILITADA
    function detectDarkMode() {
        // Forzar modo claro siempre
        document.body.style.backgroundColor = '#f8f9fa';
        document.body.style.color = '#212529';
        
        // Configurar Chart.js para modo claro
        Chart.defaults.color = '#495057';
        Chart.defaults.borderColor = 'rgba(0, 0, 0, 0.1)';
        Chart.defaults.backgroundColor = '#ffffff';
    }

    // Ejecutar detección de modo claro
    detectDarkMode();

    // NO escuchar cambios en el modo oscuro - mantener siempre claro
</script>

{{-- Agregar estilos para modo oscuro --}}
<style>
    /* Eliminar estilos de modo oscuro para forzar tema claro */
    .form-select, .form-control {
        background-color: #ffffff !important;
        border: 1px solid #ced4da !important;
        color: #495057 !important;
    }

    .form-select:focus, .form-control:focus {
        background-color: #ffffff !important;
        border-color: #80bdff !important;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25) !important;
    }

    .btn {
        border-radius: 8px !important;
    }

    .btn-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
    }

    .btn-outline-primary {
        border: 2px solid #667eea !important;
        color: #667eea !important;
        background: transparent !important;
    }

    .btn-outline-primary:hover {
        background: var(--primary-gradient) !important;
        border-color: #667eea !important;
        color: white !important;
    }

    .dropdown-menu {
        background-color: #ffffff !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }

    .dropdown-item {
        color: #495057 !important;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa !important;
        color: #495057 !important;
    }

    /* Asegurar que todos los textos sean visibles */
    * {
        color: inherit !important;
    }

    h1, h2, h3, h4, h5, h6 {
        color: #212529 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-primary {
        color: #667eea !important;
    }

    .text-info {
        color: #36d1dc !important;
    }

    .text-success {
        color: #11998e !important;
    }

    /* Forzar visibilidad en gráficos */
    canvas {
        background-color: #ffffff !important;
    }
</style>
@endsection

    