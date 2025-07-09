@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold text-primary mb-3">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Gestión de Sector Ventas
                </h2>
                <p class="text-muted">Panel de control para la administración integral de ventas</p>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="row g-4">
                <!-- Ventas -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body p-4 text-center">
                            <div class="icon-container mb-3">
                                <i class="fas fa-file-invoice text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Ventas</h5>
                            <p class="card-text text-muted mb-4">
                                Gestión completa de todas las ventas realizadas
                            </p>
                            <a href="{{ route('ventas.index') }}" 
                               class="btn btn-primary btn-lg w-100 rounded-pill">
                                <i class="fas fa-arrow-right me-2"></i>Acceder
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Reportes de ventas -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body p-4 text-center">
                            <div class="icon-container mb-3">
                                <i class="fas fa-chart-line text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Reportes de Ventas</h5>
                            <p class="card-text text-muted mb-4">
                                Análisis detallado y estadísticas de rendimiento
                            </p>
                            <a href="{{ route('rventas.reportes') }}" 
                               class="btn btn-success btn-lg w-100 rounded-pill">
                                <i class="fas fa-chart-bar me-2"></i>Ver Reportes
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Ventas pendientes de cobro -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body p-4 text-center">
                            <div class="icon-container mb-3">
                                <i class="fas fa-clock text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Ventas Pendientes</h5>
                            <p class="card-text text-muted mb-4">
                                Control y seguimiento de cuentas por cobrar
                            </p>
                            <a href="{{ route('rventas.pendientes') }}" 
                               class="btn btn-warning btn-lg w-100 rounded-pill">
                                <i class="fas fa-exclamation-triangle me-2"></i>Gestionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.icon-container {
    position: relative;
    display: inline-block;
}

.icon-container::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 50%;
    z-index: -1;
}

.card-hover .icon-container::after {
    transition: all 0.3s ease;
}

.card-hover:hover .icon-container::after {
    transform: translate(-50%, -50%) scale(1.2);
}

.btn-lg {
    padding: 12px 24px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.display-6 {
    font-size: 2.5rem;
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}
</style>
@endsection