@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold text-primary mb-3">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    Gestión de Ventas
                </h2>
                <p class="text-muted">Panel de control para registro y administración de ventas</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                
                <!-- Registrar Venta -->
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body p-4 text-center">
                            <div class="icon-container mb-3">
                                <i class="fas fa-shopping-cart text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Registrar Venta</h5>
                            <p class="card-text text-muted mb-4">
                                Registro rápido y eficiente de nuevas ventas de cursos
                            </p>
                            <a href="{{ route('rventas.index') }}" 
                               class="btn btn-primary btn-lg w-100 rounded-pill">
                                <i class="fas fa-plus-circle me-2"></i>Nueva Venta
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Registrar Descuento -->
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body p-4 text-center">
                            <div class="icon-container mb-3">
                                <i class="fas fa-percentage text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Registrar Descuento</h5>
                            <p class="card-text text-muted mb-4">
                                Configuración y gestión de descuentos aplicables
                            </p>
                            <a href="{{ route('descuentos.index') }}" 
                               class="btn btn-success btn-lg w-100 rounded-pill">
                                <i class="fas fa-tags me-2"></i>Gestionar Descuentos
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
    border-radius: 15px;
    overflow: hidden;
}

.card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.icon-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.icon-container::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.1), rgba(var(--bs-primary-rgb), 0.05));
    border-radius: 50%;
    z-index: -1;
    transition: all 0.3s ease;
}

.card-hover:hover .icon-container::before {
    transform: translate(-50%, -50%) scale(1.3);
    background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.15), rgba(var(--bs-primary-rgb), 0.08));
}

.card-hover:nth-child(2) .icon-container::before {
    background: linear-gradient(135deg, rgba(var(--bs-success-rgb), 0.1), rgba(var(--bs-success-rgb), 0.05));
}

.card-hover:nth-child(2):hover .icon-container::before {
    background: linear-gradient(135deg, rgba(var(--bs-success-rgb), 0.15), rgba(var(--bs-success-rgb), 0.08));
}

.btn-lg {
    padding: 14px 28px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-lg::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-lg:hover::before {
    left: 100%;
}

.display-6 {
    font-size: 2.5rem;
}

.card-title {
    color: #2c3e50;
    font-size: 1.4rem;
}

.card-text {
    font-size: 0.95rem;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem !important;
    }
    
    .col-md-6 {
        max-width: 400px;
    }
}

@media (max-width: 576px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}
</style>
@endsection