@extends('layouts.app')

@section('content')
<div class="register-container">
    <!-- Fondo con patrón geométrico -->
    <div class="background-pattern"></div>
    
    <div class="register-content">
        <!-- Logo responsivo -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" class="logo">
        </div>

        <!-- Formulario de registro -->
        <div class="register-form-wrapper">
            <div class="card register-card">
                <div class="card-header">
                    <h4 class="card-title">Crear Cuenta</h4>
                    <p class="card-subtitle">Únete a la comunidad CENEFCO</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="register-form">
                        @csrf

                        <!-- Campo de nombre -->
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre completo</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    id="name" 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    required 
                                    autofocus
                                    placeholder="Tu nombre completo"
                                >
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                    placeholder="Mínimo 8 caracteres"
                                >
                                <button type="button" class="btn-toggle-password" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo de confirmar contraseña -->
                        <div class="form-group">
                            <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    id="password-confirm" 
                                    type="password" 
                                    class="form-control" 
                                    name="password_confirmation" 
                                    required
                                    placeholder="Confirma tu contraseña"
                                >
                                <button type="button" class="btn-toggle-password" onclick="togglePassword('password-confirm')">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Indicador de fortaleza de contraseña -->
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <p class="strength-text" id="strengthText">Ingresa una contraseña</p>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-register">
                            <span class="btn-text">Crear mi cuenta</span>
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="register-links">
                        <div class="login-section">
                            <p class="login-text">¿Ya tienes una cuenta?</p>
                            <a href="{{ route('login') }}" class="login-link">
                                Iniciar sesión
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

.register-container {
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

.register-content {
    width: 100%;
    max-width: 480px;
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
.register-card {
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

.register-card:hover {
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

.register-card:hover .card-header::before {
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

/* Indicador de fortaleza de contraseña */
.password-strength {
    margin-bottom: 25px;
}

.strength-bar {
    width: 100%;
    height: 6px;
    background: #E5E7EB;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 8px;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 3px;
}

.strength-text {
    font-size: 0.85rem;
    color: #6B7280;
    margin: 0;
    text-align: center;
}

/* Colores de fortaleza */
.strength-weak { background: #EF4444; }
.strength-fair { background: #F59E0B; }
.strength-good { background: #10B981; }
.strength-strong { background: #059669; }

/* Botón de registro */
.btn-register {
    width: 100%;
    height: 56px;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-register::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-register:hover::before {
    left: 100%;
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
}

.btn-register:active {
    transform: translateY(0);
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-register i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-register:hover i {
    transform: translateX(4px);
}

/* Enlaces */
.register-links {
    text-align: center;
}

.login-section {
    padding-top: 20px;
    border-top: 1px solid #E5E7EB;
}

.login-text {
    margin-bottom: 10px;
    color: #6B7280;
    font-size: 0.9rem;
}

.login-link {
    color: #4F46E5;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.login-link:hover {
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
    .register-container {
        padding: 15px;
    }
    
    .register-content {
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
    
    .btn-register {
        height: 48px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .register-container {
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
    
    .btn-register {
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

.register-content {
    animation: fadeInUp 0.6s ease-out;
}

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

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleIcon = fieldId === 'password' ? document.getElementById('toggleIcon1') : document.getElementById('toggleIcon2');
    
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

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = 'Ingresa una contraseña';
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    switch (strength) {
        case 0:
        case 1:
            strengthFill.className = 'strength-fill strength-weak';
            strengthFill.style.width = '25%';
            feedback = 'Contraseña muy débil';
            break;
        case 2:
            strengthFill.className = 'strength-fill strength-fair';
            strengthFill.style.width = '50%';
            feedback = 'Contraseña débil';
            break;
        case 3:
        case 4:
            strengthFill.className = 'strength-fill strength-good';
            strengthFill.style.width = '75%';
            feedback = 'Contraseña buena';
            break;
        case 5:
            strengthFill.className = 'strength-fill strength-strong';
            strengthFill.style.width = '100%';
            feedback = 'Contraseña muy fuerte';
            break;
    }
    
    if (password.length === 0) {
        strengthFill.style.width = '0%';
        feedback = 'Ingresa una contraseña';
    }
    
    strengthText.textContent = feedback;
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const registerBtn = document.querySelector('.btn-register');
    
    // Password strength checker
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // Ripple effect for button
    registerBtn.addEventListener('click', function(e) {
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
@endsection