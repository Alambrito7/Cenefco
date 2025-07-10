@extends('layouts.app')

@section('content')
<div class="login-container">
    <!-- Fondo con patrón geométrico -->
    <div class="background-pattern"></div>
    
    <div class="login-content">
        <!-- Logo responsivo -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" class="logo">
        </div>

        <!-- Formulario de login -->
        <div class="login-form-wrapper">
            <div class="card login-card">
                <div class="card-header">
                    <h4 class="card-title">Bienvenido</h4>
                    <p class="card-subtitle">Ingresa a tu cuenta CENEFCO</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Campo de email -->
                        <div class="form-group">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    placeholder="tu@correo.com"
                                >
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo de contraseña -->
                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required
                                    placeholder="Tu contraseña"
                                >
                                <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Checkbox recordarme -->
                        <div class="form-group-checkbox">
                            <label class="checkbox-container">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <span class="checkmark"></span>
                                Recordarme en este dispositivo
                            </label>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-login">
                            <span class="btn-text">Iniciar Sesión</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="login-links">
                        <a href="{{ route('password.request') }}" class="forgot-password-link">
                            ¿Olvidaste tu contraseña?
                        </a>
                        
                        <div class="register-section">
                            <p class="register-text">¿No tienes cuenta?</p>
                            <a href="{{ route('register') }}" class="register-link">
                                Regístrate aquí
                            </a>
                        </div>
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

.login-container {
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

.login-content {
    width: 100%;
    max-width: 420px;
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
    max-width: 320px;
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
.login-card {
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

.login-card:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 40px rgba(0,0,0,0.15),
        0 4px 12px rgba(0,0,0,0.1);
}

/* Header de la tarjeta */
.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
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

.login-card:hover .card-header::before {
    opacity: 1;
}

.card-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-subtitle {
    opacity: 0.95;
    font-size: 1.1rem;
    margin-bottom: 0;
    font-weight: 400;
    position: relative;
    z-index: 1;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Cuerpo de la tarjeta */
.card-body {
    padding: 45px 35px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}

/* Grupos de formulario */
.form-group {
    margin-bottom: 25px;
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
    border-color: #4F46E5;
    background: white;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-control:focus + .input-icon {
    color: #4F46E5;
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
    color: #4F46E5;
    background: rgba(79, 70, 229, 0.1);
}

/* Checkbox personalizado */
.form-group-checkbox {
    margin-bottom: 30px;
}

.checkbox-container {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 0.95rem;
    color: #374151;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    height: 20px;
    width: 20px;
    background-color: #FAFAFA;
    border: 2px solid #E5E7EB;
    border-radius: 6px;
    margin-right: 12px;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-container:hover input ~ .checkmark {
    background-color: #F3F4F6;
    border-color: #4F46E5;
}

.checkbox-container input:checked ~ .checkmark {
    background-color: #4F46E5;
    border-color: #4F46E5;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.checkbox-container .checkmark:after {
    left: 6px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Botón de login */
.btn-login {
    width: 100%;
    height: 56px;
    background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
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
    margin-bottom: 35px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

.btn-login:active {
    transform: translateY(0);
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-login i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-login:hover i {
    transform: translateX(4px);
}

/* Enlaces */
.login-links {
    text-align: center;
}

.forgot-password-link {
    color: #4F46E5;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
    display: inline-block;
    margin-bottom: 25px;
}

.forgot-password-link:hover {
    color: #3730A3;
    text-decoration: underline;
}

.register-section {
    padding-top: 20px;
    border-top: 1px solid #E5E7EB;
}

.register-text {
    margin-bottom: 10px;
    color: #6B7280;
    font-size: 0.9rem;
}

.register-link {
    color: #4F46E5;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.register-link:hover {
    color: #3730A3;
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
    .login-container {
        padding: 15px;
    }
    
    .login-content {
        max-width: 100%;
    }
    
    .logo {
        max-width: 280px;
    }
    
    .card-body {
        padding: 35px 25px;
    }
    
    .card-header {
        padding: 35px 25px;
    }
    
    .card-title {
        font-size: 1.75rem;
    }
    
    .card-subtitle {
        font-size: 0.95rem;
    }
    
    .form-control {
        height: 48px;
        font-size: 0.95rem;
    }
    
    .btn-login {
        height: 48px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .login-container {
        padding: 10px;
    }
    
    .logo {
        max-width: 240px;
    }
    
    .card-body {
        padding: 30px 20px;
    }
    
    .card-header {
        padding: 30px 20px;
    }
    
    .card-title {
        font-size: 1.5rem;
    }
    
    .form-control {
        height: 46px;
        font-size: 0.9rem;
    }
    
    .btn-login {
        height: 46px;
        font-size: 0.95rem;
    }
}

@media (max-width: 360px) {
    .logo {
        max-width: 200px;
    }
    
    .logo-container {
        margin-bottom: 30px;
        padding: 15px;
    }
    
    .card-body {
        padding: 25px 15px;
    }
    
    .card-header {
        padding: 25px 15px;
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

.login-content {
    animation: fadeInUp 0.6s ease-out;
}

/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
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
    const loginBtn = document.querySelector('.btn-login');
    
    loginBtn.addEventListener('click', function(e) {
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