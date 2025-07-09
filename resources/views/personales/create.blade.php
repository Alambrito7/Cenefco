@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Registrar Personal
                    </h2>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Ups!</strong> Hay algunos errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('personals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Datos personales -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-user me-2"></i>
                                Información Personal
                            </h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="{{ old('nombre') }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El nombre es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" class="form-control" 
                                           value="{{ old('apellido_paterno') }}" required 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido paterno es requerido y debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control" 
                                           value="{{ old('apellido_materno') }}" 
                                           oninput="capitalizeFirstLetter(this); validateField(this)"
                                           pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]{2,50}">
                                    <div class="invalid-feedback">
                                        El apellido materno debe tener entre 2 y 50 caracteres.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">CI</label>
                                    <input type="text" name="ci" class="form-control" 
                                           value="{{ old('ci') }}" required
                                           maxlength="8" pattern="[0-9]{7,8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8);">
                                    <div class="invalid-feedback">
                                        El CI es requerido y debe tener hasta 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Edad</label>
                                    <input type="number" name="edad" class="form-control" 
                                           value="{{ old('edad') }}" required min="18" max="80">
                                    <div class="invalid-feedback">
                                        La edad es requerida y debe estar entre 18 y 80 años.
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Género</label>
                                    <select name="genero" class="form-select" required>
                                        <option value="">Seleccionar</option>
                                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe seleccionar un género.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-phone me-2"></i>
                                Información de Contacto
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control"
                                           value="{{ old('telefono') }}" required
                                           maxlength="8" pattern="[0-9]{8}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,8);">
                                    <div class="invalid-feedback">
                                        El teléfono es requerido y debe tener exactamente 8 dígitos.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Correo Electrónico</label>
                                    <input type="email" name="correo" class="form-control"
                                           value="{{ old('correo') }}" required>
                                    <div class="invalid-feedback">
                                        El correo es requerido y debe ser válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cargo -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-briefcase me-2"></i>
                                Cargo en la Empresa
                            </h5>
                            <div class="mb-3">
                            <select class="form-select" name="cargo" required>
                <option value="">Seleccione un cargo</option>
                <optgroup label="🟧 ALTA DIRECCIÓN">
                    <option>Director General</option>
                    <option>Gerente General</option>
                </optgroup>
                <optgroup label="🟦 ÁREA ACADÉMICA">
                    <option>Coordinador Académico</option>
                    <option>Responsable de Investigación y Desarrollo</option>
                    <option>Gestión de Base de Datos y Docentes</option>
                    <option>Asistente Académico</option>
                </optgroup>
                <optgroup label="🟩 ÁREA COMERCIAL">
                    <option>Jefe de Ventas</option>
                    <option>Supervisor de Ventas</option>
                    <option>Ejecutivo de Ventas</option>
                    <option>Servicio y Atención al Cliente</option>
                    <option>Pasante - Área Comercial</option>
                </optgroup>
                <optgroup label="🟪 ÁREA DE DISEÑO Y MARKETING">
                    <option>Director de Marketing y Diseño</option>
                    <option>Supervisor de Diseño Gráfico</option>
                    <option>Diseñador Gráfico</option>
                    <option>Pasante - Diseño y Marketing</option>
                </optgroup>
                <optgroup label="🟨 ÁREA ADMINISTRATIVA Y FINANCIERA">
                    <option>Gerente de Finanzas</option>
                    <option>Gerente de Recursos Humanos (RRHH)</option>
                    <option>Jefe de Logística y Gestión de Inventarios</option>
                    <option>Asistente/Auxiliar de Logística y Certificados</option>
                </optgroup>
            </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar un cargo.
                                </div>
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-image me-2"></i>
                                Foto del Personal
                            </h5>
                            <div class="mb-3">
                                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <div class="mt-3 text-center">
                                    <img id="preview" src="{{ isset($personal) && $personal->foto ? asset('storage/' . $personal->foto) : '#' }}"
                                         alt="Vista previa"
                                         style="max-width: 180px; max-height: 180px; {{ isset($personal) && $personal->foto ? '' : 'display:none;' }}"
                                         class="rounded border shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="text-end">
                            <a href="{{ route('personals.index') }}" class="btn btn-secondary">← Volver</a>
                            <button type="submit" class="btn btn-success">Guardar Personal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function capitalizeFirstLetter(input) {
    let words = input.value.toLowerCase().split(' ');
    for (let i = 0; i < words.length; i++) {
        if (words[i]) {
            words[i] = words[i][0].toUpperCase() + words[i].substr(1);
        }
    }
    input.value = words.join(' ');
}

function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
