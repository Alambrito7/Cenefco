@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-center">
        🎓 Panel del Cliente - Mis Cursos
    </h2>

    <div class="row justify-content-center g-4">
        {{-- Mis Cursos --}}
        <div class="col-md-4">
            <div class="card text-center shadow h-100 border-0">
                <div class="card-body">
                    <i class="fa fa-book-open fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Mis Cursos</h5>
                    <p class="text-muted">Revisa tus cursos comprados y en progreso</p>
                    <a href="#" class="btn btn-primary w-100">📘 Ver mis cursos</a>
                </div>
            </div>
        </div>

        {{-- Certificados --}}
        <div class="col-md-4">
            <div class="card text-center shadow h-100 border-0">
                <div class="card-body">
                    <i class="fa fa-certificate fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Certificados</h5>
                    <p class="text-muted">Descarga tus certificados de cursos finalizados</p>
                    <a href="#" class="btn btn-success w-100">🎓 Ver certificados</a>
                </div>
            </div>
        </div>

        {{-- Recomendaciones --}}
        <div class="col-md-4">
            <div class="card text-center shadow h-100 border-0">
                <div class="card-body">
                    <i class="fa fa-lightbulb fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Cursos Recomendados</h5>
                    <p class="text-muted">Amplía tus conocimientos con nuevos cursos</p>
                    <a href="#" class="btn btn-warning w-100 text-dark">✨ Ver recomendaciones</a>
                </div>
            </div>
        </div>

        {{-- Seguimiento Académico --}}
        <div class="col-md-6">
            <div class="card text-center shadow h-100 border-0 mt-3">
                <div class="card-body">
                    <i class="fa fa-chart-bar fa-3x text-info mb-3"></i>
                    <h5 class="fw-bold">Seguimiento Académico</h5>
                    <p class="text-muted">Consulta tu progreso, tareas y asistencia</p>
                    <a href="#" class="btn btn-outline-info w-100">📊 Ver seguimiento</a>
                </div>
            </div>
        </div>

        {{-- Historial y Extras --}}
        <div class="col-md-6">
            <div class="card text-center shadow h-100 border-0 mt-3">
                <div class="card-body">
                    <i class="fa fa-history fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Historial y Extras</h5>
                    <p class="text-muted">Consulta tus compras anteriores, valoraciones y recursos</p>
                    <a href="#" class="btn btn-outline-danger w-100">📂 Ver historial</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
