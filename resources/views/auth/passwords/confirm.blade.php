@extends('layouts.app')

@section('content')
<div class="confirm-container">
    <!-- Fondo con patrón geométrico -->
    <div class="background-pattern"></div>
    
    <div class="confirm-content">
        <!-- Logo responsivo -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" class="logo">
        </div>

        <!-- Formulario de confirmación -->
        <div class="confirm-form-wrapper">
            <div class="card confirm-card">
                <div class="card-header">
                    <div class="security-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <h4 class="card-title">Confirmar identidad</h4>
                    <p class="card-subtitle">Por seguridad, confirma tu contraseña para continuar</p>
                </div>

                <div class="card-body">
                    <div class="security-info">
                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <p>Esta es una área protegida. Necesitamos verificar tu identidad antes de permitir el acceso.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}" class="confirm-form">
                        @csrf

                        <!-- Campo de contraseña -->
                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña actual</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required 
                                    autofocus
                                    autocomplete="current-password"
                                    placeholder="Ingresa tu contraseña"
                                >
                                <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botón de confirmación -->
                        <button type="submit" class="btn btn-confirm">
                            <span class="btn-text">Confirmar y continuar</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="confirm-links">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password-link">
                                <i class="fas fa-question-circle"></i>
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset y configuración base */
* {
    box-sizing: border-box;
}

.confirm-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 20px;
    position: relative;
    overflow: hidden;
}

/* Patrón de fondo */
.background-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.05) 0%, transparent 50%);
    z-index: 1;
}

.confirm-content {
    width: 100%;
    max-width: 450px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* Logo */
.logo-container {
    text-align: center;
    margin-bottom: 50px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.logo {
    max-width: 200px;
    width: 100%;
    height: auto;
    filter: drop-shadow(0 8px 25px rgba(0,0,0,0.15));
    transition: all 0.4s ease;
}

.logo:hover {
    transform: scale(1.05) rotate(1deg);
    filter: drop-shadow(0 12px 35px rgba(0,0,0,0.2));
}

/* Tarjeta principal */
.confirm-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    box-shadow: 
        0 8px 32px rgba(0,0,0,0.1),
        0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.confirm-card:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 40px rgba(0,0,0,0.15),
        0 4px 12px rgba(0,0,0,0.1);
}

/* Header de la tarjeta */
.card-header {
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
    color: white;
    text-align: center;
    padding: 40px 30px;
    border: none;
    position: relative;
    overflow: hidden;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-header::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    transform: rotate(45deg);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { opacity: 0; }
    50% { opacity: 1; }
}

.confirm-card:hover .card-header::before {
    opacity: 1;
}

.security-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
    opacity: 0.9;
}

.card-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-subtitle {
    opacity: 0.9;
    font-size: 1rem;
    margin-bottom: 0;
    font-weight: 400;
    position: relative;
    z-index: 1;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Cuerpo de la tarjeta */
.card-body {
    padding: 40px 35px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}

/* Info de seguridad */
.security-info {
    margin-bottom: 30px;
}

.info-box {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.info-box i {
    color: #3B82F6;
    font-size: 1.5rem;
    margin-top: 2px;
}

.info-box p {
    color: #374151;
    margin: 0;
    line-height: 1.5;
    font-size: 0.95rem;
}

/* Grupos de formulario */
.form-group {
    margin-bottom: 30px;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}

/* Grupos de input */
.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    color: #9CA3AF;
    font-size: 1.1rem;
    z-index: 3;
    transition: color 0.3s ease;
}

.form-control {
    width: 100%;
    height: 52px;
    border: 2px solid #E5E7EB;
    border-radius: 12px;
    padding: 0 15px 0 45px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #FAFAFA;
}

.form-control:focus {
    outline: none;
    border-color: #DC2626;
    background: white;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-control:focus + .input-icon {
    color: #DC2626;
}

.form-control.is-invalid {
    border-color: #EF4444;
}

/* Botón toggle contraseña */
.btn-toggle-password {
    position: absolute;
    right: 15px;
    background: none;
    border: none;
    color: #9CA3AF;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s ease;
    z-index: 3;
}

.btn-toggle-password:hover {
    color: #DC2626;
    background: rgba(220, 38, 38, 0.1);
}

/* Botón de confirmación */
.btn-confirm {
    width: 100%;
    height: 56px;
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 1.15rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}

.btn-confirm::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-confirm:hover::before {
    left: 100%;
}

.btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
}

.btn-confirm:active {
    transform: translateY(0);
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-confirm i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-confirm:hover i {
    transform: translateX(4px);
}

/* Enlaces */
.confirm-links {
    text-align: center;
}

.forgot-password-link {
    color: #6B7280;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
}

.forgot-password-link:hover {
    color: #DC2626;
    text-decoration: underline;
}

/* Feedback de error */
.invalid-feedback {
    display: block;
    color: #EF4444;
    font-size: 0.875rem;
    margin-top: 8px;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .confirm-container {
        padding: 15px;
    }
    
    .confirm-content {
        max-width: 100%;
    }
    
    .logo {
        max-width: 160px;
    }
    
    .card-body {
        padding: 30px 25px;
    }
    
    .card-header {
        padding: 30px 25px;
    }
    
    .card-title {
        font-size: 1.75rem;
    }
    
    .security-icon {
        font-size: 2.5rem;
    }
    
    .form-control {
        height: 48px;
        font-size: 0.95rem;
    }
    
    .btn-confirm {
        height: 48px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .confirm-container {
        padding: 10px;
    }
    
    .logo {
        max-width: 140px;
    }
    
    .card-body {
        padding: 25px 20px;
    }
    
    .card-header {
        padding: 25px 20px;
    }
    
    .card-title {
        font-size: 1.5rem;
    }
    
    .security-icon {
        font-size: 2rem;
    }
    
    .form-control {
        height: 46px;
        font-size: 0.9rem;
    }
    
    .btn-confirm {
        height: 46px;
        font-size: 0.95rem;
    }
}

@media (max-width: 360px) {
    .logo {
        max-width: 120px;
    }
    
    .logo-container {
        margin-bottom: 30px;
        padding: 15px;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .card-header {
        padding: 20px 15px;
    }
    
    .card-title {
        font-size: 1.4rem;
    }
}

/* Animaciones de entrada */
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

.confirm-content {
    animation: fadeInUp 0.6s ease-out;
}

.security-icon {
    animation: fadeInUp 0.8s ease-out 0.3s both;
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Efecto de ondas en el botón
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.querySelector('.btn-confirm');
    
    confirmBtn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});
</script>

<style>
/* Efecto ripple para el botón */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
</style>
@endsection