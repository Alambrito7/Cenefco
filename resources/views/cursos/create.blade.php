@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white text-center py-4">
                    <h2 class="mb-2">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Registrar nuevo curso
                    </h2>
                    <p class="mb-0 opacity-75">Complete la información del curso</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle fa-lg text-danger"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <strong>¡Ups!</strong> Hay algunos errores.<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Información Básica -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-info-circle me-2"></i>
                            Información Básica
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nombre del Curso <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" 
                                       class="form-control form-control-lg text-uppercase" 
                                       value="{{ old('nombre') }}" 
                                       style="text-transform: uppercase;" 
                                       oninput="this.value = this.value.toUpperCase();" 
                                       placeholder="Ingrese el nombre del curso"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Área Académica <span class="text-danger">*</span></label>
                                <select name="area" class="form-select form-select-lg" required>
                                    <option value="">Seleccionar área</option>
                                    <option value="Ingeniería" {{ old('area') == 'Ingeniería' ? 'selected' : '' }}>Ingeniería</option>
                                    <option value="Derecho" {{ old('area') == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                                    <option value="Arquitectura" {{ old('area') == 'Arquitectura' ? 'selected' : '' }}>Arquitectura</option>
                                    <option value="Cs. Empresariales" {{ old('area') == 'Cs. Empresariales' ? 'selected' : '' }}>Cs. Empresariales</option>
                                    <option value="Cs. Salud" {{ old('area') == 'Cs. Salud' ? 'selected' : '' }}>Cs. Salud</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Marca/Institución <span class="text-danger">*</span></label>
                                <input type="text" name="marca" 
                                       class="form-control form-control-lg text-uppercase" 
                                       value="{{ old('marca') }}" 
                                       style="text-transform: uppercase;" 
                                       oninput="this.value = this.value.toUpperCase();" 
                                       placeholder="Ingrese la marca o institución"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Estado del Curso <span class="text-danger">*</span></label>
                                <select name="estado" class="form-select form-select-lg" required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="Programado" {{ old('estado') == 'Programado' ? 'selected' : '' }}>Programado</option>
                                    <option value="En curso" {{ old('estado') == 'En curso' ? 'selected' : '' }}>En curso</option>
                                    <option value="Finalizado" {{ old('estado') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe el contenido y objetivos del curso...">{{ old('descripcion') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Información de Personal -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 text-success">
                            <i class="fas fa-users me-2"></i>
                            Información de Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Encargado del Curso <span class="text-danger">*</span></label>
                                <select name="personal_id" class="form-select form-select-lg" required>
                                    <option value="">Seleccionar encargado</option>
                                    @foreach ($encargados as $encargado)
                                        <option value="{{ $encargado->id }}" {{ old('personal_id') == $encargado->id ? 'selected' : '' }}>
                                            {{ $encargado->nombre }} {{ $encargado->apellido_paterno }} {{ $encargado->apellido_materno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Docente Encargado <span class="text-danger">*</span></label>
                                <select name="docente_id" class="form-select form-select-lg" required>
                                    <option value="">Seleccionar docente</option>
                                    @foreach ($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->nombre }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Horarios -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 text-warning">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Información de Horarios
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" name="fecha" 
                                       class="form-control form-control-lg" 
                                       value="{{ old('fecha') }}" 
                                       min="{{ date('Y-m-d') }}" 
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Días de Clases <span class="text-danger">*</span></label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="row">
                                        @php
                                            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        @endphp
                                        @foreach($dias as $dia)
                                            <div class="col-6 col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dias_clases[]" value="{{ $dia }}" id="{{ $dia }}"
                                                        {{ (is_array(old('dias_clases')) && in_array($dia, old('dias_clases'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="{{ $dia }}">
                                                        {{ $dia }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Material del Curso -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0 text-info">
                            <i class="fas fa-image me-2"></i>
                            Material del Curso
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Foto del Flayer</label>
                                <input type="file" name="flayer" class="form-control form-control-lg" accept="image/*">
                                <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>
                                Volver
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save me-2"></i>
                                Guardar Curso
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e3e6f0;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }
    
    .card-header {
        border-bottom: 1px solid #f8f9fc;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .text-primary {
        color: #667eea !important;
    }
    
    .alert {
        border-radius: 10px;
    }
</style>
@endsection