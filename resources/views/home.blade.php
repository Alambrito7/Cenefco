@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --info-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        --header-gradient: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #dee2e6 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .header-container {
        background: var(--header-gradient);
        color: #2c3e50;
        padding: 2rem 0;
        border-radius: 0 0 30px 30px;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-row {
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .module-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .module-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transition: all 0.3s ease;
    }

    .module-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-hover-shadow);
    }

    .module-card:hover::before {
        height: 100%;
        opacity: 0.1;
    }

    .module-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .module-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        color: #2c3e50;
    }

    .module-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .module-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .module-btn:hover {
        color: white;
        transform: scale(1.05);
    }

    .module-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }

    .module-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .chart-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: var(--card-shadow);
    }

    .chart-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .dark-mode-toggle {
        background: rgba(52, 58, 64, 0.1);
        border: 2px solid rgba(52, 58, 64, 0.2);
        color: #495057;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .dark-mode-toggle:hover {
        background: rgba(52, 58, 64, 0.2);
        color: #343a40;
        transform: scale(1.05);
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #adb5bd 0%, #6c757d 100%);
        border-radius: 2px;
    }

    /* Colores específicos para cada módulo */
    .module-card[data-module="registros"] .module-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="registros"] .module-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }

    .module-card[data-module="ventas"] .module-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="ventas"] .module-btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .module-card[data-module="cliente"] .module-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="cliente"] .module-btn { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

    .module-card[data-module="inventario"] .module-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="inventario"] .module-btn { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

    .module-card[data-module="certificados"] .module-icon { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="certificados"] .module-btn { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }

    .module-card[data-module="competencias"] .module-icon { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="competencias"] .module-btn { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }

    .module-card[data-module="finanzas"] .module-icon { background: linear-gradient(135deg, #a8e6cf 0%, #dcedc8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="finanzas"] .module-btn { background: linear-gradient(135deg, #a8e6cf 0%, #dcedc8 100%); }

    .module-card[data-module="control"] .module-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="control"] .module-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }

    .module-card[data-module="entregas"] .module-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="entregas"] .module-btn { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

    .module-card[data-module="centralizadas"] .module-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .module-card[data-module="centralizadas"] .module-btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }
        
        .module-card {
            padding: 1.5rem;
        }
        
        .module-icon {
            font-size: 2.5rem;
        }
    }

    /* Animaciones */
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

    .module-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .module-card:nth-child(1) { animation-delay: 0.1s; }
    .module-card:nth-child(2) { animation-delay: 0.2s; }
    .module-card:nth-child(3) { animation-delay: 0.3s; }
    .module-card:nth-child(4) { animation-delay: 0.4s; }
    .module-card:nth-child(5) { animation-delay: 0.5s; }
    .module-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="header-container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="header-title">
                <i class="fas fa-tachometer-alt me-3"></i>
                Panel de Control SuperAdmin
            </h1>
            <button id="darkModeToggle" class="dark-mode-toggle">
                <i class="fas fa-moon me-2"></i>
                Modo Oscuro
            </button>
        </div>
    </div>
</div>

<div class="container">
    

    <!-- Módulos principales -->
    <h2 class="section-title">Módulos del Sistema</h2>
    
    <div class="row">
        {{-- Módulo: Registros --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="registros">
                <i class="fas fa-users module-icon"></i>
                <h5 class="module-title">Módulo Registros</h5>
                <p class="module-description">Gestión completa de clientes, docentes y personal administrativo</p>
                <a href="{{ route('superadmin.registros') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Acceder al módulo
                </a>
            </div>
        </div>

        {{-- Módulo: Sector Ventas --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="ventas">
                <i class="fas fa-chart-line module-icon"></i>
                <h5 class="module-title">Sector Ventas</h5>
                <p class="module-description">Control de ventas, pagos y seguimiento de transacciones</p>
                <a href="{{ route('superadmin.sector_ventas') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Acceder al módulo
                </a>
            </div>
        </div>

        {{-- Módulo: Venta de Cliente --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="cliente">
                <i class="fas fa-shopping-cart module-icon"></i>
                <h5 class="module-title">Venta Cliente</h5>
                <p class="module-description">Historial y estado de cursos adquiridos por los clientes</p>
                <a href="{{ route('cliente.panel.superadmin') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Ver ventas
                </a>
            </div>
        </div>

        {{-- Módulo: Inventario --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="inventario">
                <i class="fas fa-boxes module-icon"></i>
                <h5 class="module-title">Inventario</h5>
                <p class="module-description">Control de productos, stock y movimientos de inventario</p>
                <a href="{{ route('inventario.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Gestionar inventario
                </a>
            </div>
        </div>

        {{-- Módulo: Certificados --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="certificados">
                <i class="fas fa-certificate module-icon"></i>
                <h5 class="module-title">Certificados</h5>
                <p class="module-description">Control y gestión de entrega de certificados</p>
                <a href="{{ route('certificados.dashboard') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Gestionar certificados
                </a>
            </div>
        </div>

        {{-- Módulo: Competencias --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="competencias">
                <i class="fas fa-trophy module-icon"></i>
                <h5 class="module-title">Competencias</h5>
                <p class="module-description">Control de competencias y seguimiento de estados</p>
                <a href="{{ route('competencias.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Ver competencias
                </a>
            </div>
        </div>

        {{-- Módulo: Certificados Docentes --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="certificados">
                <i class="fas fa-user-graduate module-icon"></i>
                <h5 class="module-title">Certificados Docentes</h5>
                <p class="module-description">Control de entrega a docentes y validación</p>
                <a href="{{ route('certificadosdocentes.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Ver certificados
                </a>
            </div>
        </div>

        {{-- Módulo: Finanzas --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="finanzas">
                <i class="fas fa-wallet module-icon"></i>
                <h5 class="module-title">Módulo Financiero</h5>
                <p class="module-description">Registro de pagos por curso y control financiero</p>
                <a href="{{ route('finanzas.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Ver transacciones
                </a>
            </div>
        </div>

        {{-- Módulo: Control General --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="control">
                <i class="fas fa-cogs module-icon"></i>
                <h5 class="module-title">Control General</h5>
                <p class="module-description">Control general de clientes y transacciones</p>
                <a href="{{ route('controlGeneral.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Acceder al módulo
                </a>
            </div>
        </div>

        {{-- Módulo: Entregas de Material --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="entregas">
                <i class="fas fa-truck module-icon"></i>
                <h5 class="module-title">Entregas de Material</h5>
                <p class="module-description">Gestión de entregas de material de grabación</p>
                <a href="{{ route('entrega_materials.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Gestionar entregas
                </a>
            </div>
        </div>

        {{-- Módulo: Ventas Centralizadas --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="module-card" data-module="centralizadas">
                <i class="fas fa-chart-pie module-icon"></i>
                <h5 class="module-title">Ventas Centralizadas</h5>
                <p class="module-description">Información detallada y análisis por curso</p>
                <a href="{{ route('ventas_centralizadas.index') }}" class="module-btn">
                    <i class="fas fa-arrow-right me-2"></i>
                    Ver análisis
                </a>
            </div>
        </div>
    </div>

    <!-- Gráfico de ventas -->
    <div class="chart-container">
        <h4 class="chart-title">
            <i class="fas fa-chart-bar me-2"></i>
            Ventas del Año Actual
        </h4>
        <canvas id="ventasMesChart" height="100"></canvas>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración del gráfico
    const ctx = document.getElementById('ventasMesChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($meses ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']) !!},
            datasets: [{
                label: 'Ventas por mes',
                data: {!! json_encode($ventasPorMes ?? [12, 19, 3, 5, 2, 3, 15, 8, 12, 7, 9, 14]) !!},
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    display: false 
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Toggle Dark Mode
    document.getElementById('darkModeToggle').addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        const icon = this.querySelector('i');
        
        if (document.body.classList.contains('dark-mode')) {
            icon.className = 'fas fa-sun me-2';
            this.innerHTML = '<i class="fas fa-sun me-2"></i>Modo Claro';
        } else {
            icon.className = 'fas fa-moon me-2';
            this.innerHTML = '<i class="fas fa-moon me-2"></i>Modo Oscuro';
        }
    });

    // Añadir efecto de parallax suave
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const header = document.querySelector('.header-container');
        if (header) {
            header.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
</script>
@endsection