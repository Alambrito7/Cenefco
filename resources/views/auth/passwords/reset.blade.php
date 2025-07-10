@extends('layouts.app')

@section('content')
<div class="new-password-container">
    <!-- Fondo con patrón geométrico -->
    <div class="background-pattern"></div>
    
    <div class="new-password-content">
        <!-- Logo y marca -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" class="logo">
            <div class="brand-info">
                <h2 class="brand-title">CENEFCO</h2>
                <p class="brand-subtitle">CENTRO NACIONAL DE EDUCACIÓN<br>Y FORMACIÓN CONTINUA - BOLIVIA</p>
            </div>
        </div>

        <!-- Formulario de nueva contraseña -->
        <div class="new-password-form-wrapper">
            <div class="card new-password-card">
                <div class="card-header">
                    <div class="password-icon">
                        <i class="fas fa-lock-open"></i>
                    </div>
                    <h4 class="card-title">Nueva contraseña</h4>
                    <p class="card-subtitle">Crea una contraseña segura para tu cuenta</p>
                </div>

                <div class="card-body">
                    <div class="security-tips">
                        <h5 class="tips-title">
                            <i class="fas fa-shield-alt"></i>
                            Consejos de seguridad
                        </h5>
                        <div class="tips-grid">
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Mínimo 8 caracteres</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Incluye mayúsculas y minúsculas</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Añade números y símbolos</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Evita información personal</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="new-password-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

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

                        <!-- Campo de nueva contraseña -->
                        <div class="form-group">
                            <label for="password" class="form-label">Nueva contraseña</label>
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
                                    placeholder="Tu nueva contraseña"
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
                            <label for="password-confirm" class="form-label">Confirmar nueva contraseña</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input 
                                    id="password-confirm" 
                                    type="password" 
                                    class="form-control" 
                                    name="password_confirmation" 
                                    required
                                    placeholder="Confirma tu nueva contraseña"
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
                            <div class="strength-requirements" id="requirements">
                                <div class="requirement" id="length">
                                    <i class="fas fa-times"></i>
                                    <span>Al menos 8 caracteres</span>
                                </div>
                                <div class="requirement" id="uppercase">
                                    <i class="fas fa-times"></i>
                                    <span>Una letra mayúscula</span>
                                </div>
                                <div class="requirement" id="lowercase">
                                    <i class="fas fa-times"></i>
                                    <span>Una letra minúscula</span>
                                </div>
                                <div class="requirement" id="number">
                                    <i class="fas fa-times"></i>
                                    <span>Un número</span>
                                </div>
                                <div class="requirement" id="special">
                                    <i class="fas fa-times"></i>
                                    <span>Un carácter especial</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-new-password">
                            <span class="btn-text">Guardar nueva contraseña</span>
                            <i class="fas fa-check"></i>
                        </button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="new-password-links">
                        <div class="back-to-login">
                            <a href="{{ route('login') }}" class="login-link">
                                <i class="fas fa-arrow-left"></i>
                                Volver al inicio de sesión
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

.new-password-container {
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

.new-password-content {
    width: 100%;
    max-width: 550px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* Logo y marca */
.logo-container {
    text-align: center;
    margin-bottom: 40px;
    padding: 25px;
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
    margin-bottom: 15px;
}

.logo:hover {
    transform: scale(1.03);
    filter: drop-shadow(0 12px 35px rgba(0,0,0,0.2));
}

.brand-info {
    margin-top: 15px;
}

.brand-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1F2937;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.brand-subtitle {
    font-size: 0.9rem;
    color: #6B7280;
    line-height: 1.4;
    margin: 0;
    font-weight: 500;
}

/* Tarjeta principal */
.new-password-card {
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

.new-password-card:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 40px rgba(0,0,0,0.15),
        0 4px 12px rgba(0,0,0,0.1);
}

/* Header de la tarjeta */
.card-header {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
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

.new-password-card:hover .card-header::before {
    opacity: 1;
}

.password-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
    opacity: 0.9;
}

.card-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-subtitle {
    opacity: 0.9;
    font-size: 1.1rem;
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

/* Tips de seguridad */
.security-tips {
    background: rgba(16, 185, 129, 0.05);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
}

.tips-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #059669;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.tips-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #374151;
}

.tip-item i {
    color: #10B981;
    font-size: 0.8rem;
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
    border-color: #10B981;
    background: white;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-control:focus + .input-icon {
    color: #10B981;
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
    color: #10B981;
    background: rgba(16, 185, 129, 0.1);
}

/* Indicador de fortaleza de contraseña */
.password-strength {
    margin-bottom: 25px;
    padding: 20px;
    background: rgba(249, 250, 251, 0.8);
    border-radius: 12px;
    border: 1px solid #E5E7EB;
}

.strength-bar {
    width: 100%;
    height: 8px;
    background: #E5E7EB;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 12px;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.strength-text {
    font-size: 0.9rem;
    color: #374151;
    margin: 0 0 15px;
    text-align: center;
    font-weight: 600;
}

.strength-requirements {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.requirement {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #6B7280;
    transition: color 0.3s ease;
}

.requirement i {
    font-size: 0.75rem;
    color: #EF4444;
    transition: color 0.3s ease;
}

.requirement.valid {
    color: #059669;
}

.requirement.valid i {
    color: #10B981;
}

/* Colores de fortaleza */
.strength-weak { background: #EF4444; }
.strength-fair { background: #F59E0B; }
.strength-good { background: #10B981; }
.strength-strong { background: #059669; }

/* Botón de nueva contraseña */
.btn-new-password {
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
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-new-password::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-new-password:hover::before {
    left: 100%;
}

.btn-new-password:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
}

.btn-new-password:active {
    transform: translateY(0);
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-new-password i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-new-password:hover i {
    transform: scale(1.1);
}

/* Enlaces */
.new-password-links {
    text-align: center;
}

.back-to-login {
    margin-bottom: 20px;
}

.login-link {
    color: #6B7280;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
}

.login-link:hover {
    color: #10B981;
    text-decoration: underline;
}

.login-link i {
    transition: transform 0.3s ease;
}

.login-link:hover i {
    transform: translateX(-3px);
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
    .new-password-container {
        padding: 15px;
    }
    
    .new-password-content {
        max-width: 100%;
    }
    
    .logo {
        max-width: 160px;
    }
    
    .brand-title {
        font-size: 1.5rem;
    }
    
    .brand-subtitle {
        font-size: 0.85rem;
    }
    
    .card-body {
        padding: 30px 25px;
    }
    
    .card-header {
        padding: 30px 25px;
    }
    
    .card-title {
        font-size: 1.8rem;
    }
    
    .password-icon {
        font-size: 2.5rem;
    }
    
    .tips-grid {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    
    .strength-requirements {
        grid-template-columns: 1fr;
    }
    
    .form-control {
        height: 48px;
        font-size: 0.95rem;
    }
    
    .btn-new-password {
        height: 48px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .new-password-container {
        padding: 10px;
    }
    
    .logo {
        max-width: 140px;
    }
    
    .logo-container {
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .brand-title {
        font-size: 1.3rem;
    }
    
    .brand-subtitle {
        font-size: 0.8rem;
    }
    
    .card-body {
        padding: 25px 20px;
    }
    
    .card-header {
        padding: 25px 20px;
    }
    
    .card-title {
        font-size: 1.6rem;
    }
    
    .card-subtitle {
        font-size: 1rem;
    }
    
    .password-icon {
        font-size: 2rem;
    }
    
    .security-tips {
        padding: 20px;
    }
    
    .form-control {
        height: 46px;
        font-size: 0.9rem;
    }
    
    .btn-new-password {
        height: 46px;
        font-size: 0.95rem;
    }
}

@media (max-width: 360px) {
    .logo {
        max-width: 120px;
    }
    
    .logo-container {
        padding: 15px;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .card-header {
        padding: 20px 15px;
    }
    
    .brand-title {
        font-size: 1.2rem;
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

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.1);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.new-password-content {
    animation: fadeInUp 0.6s ease-out;
}

.password-icon {
    animation: bounceIn 0.8s ease-out 0.3s both;
}

.tip-item {
    animation: fadeInUp 0.6s ease-out;
}

.tip-item:nth-child(1) { animation-delay: 0.1s; }
.tip-item:nth-child(2) { animation-delay: 0.2s; }
.tip-item:nth-child(3) { animation-delay: 0.3s; }
.tip-item:nth-child(4) { animation-delay: 0.4s; }

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

/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Estados de focus para accesibilidad */
.btn-new-password:focus {
    outline: 2px solid #10B981;
    outline-offset: 2px;
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
    
    // Check requirements
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[^a-zA-Z0-9]/.test(password)
    };
    
    // Update requirement indicators
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(req);
        const icon = element.querySelector('i');
        
        if (requirements[req]) {
            element.classList.add('valid');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-check');
            strength++;
        } else {
            element.classList.remove('valid');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-times');
        }
    });
    
    // Update strength bar
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    switch (strength) {
        case 0:
        case 1:
            strengthFill.className = 'strength-fill strength-weak';
            strengthFill.style.width = '20%';
            feedback = 'Contraseña muy débil';
            break;
        case 2:
            strengthFill.className = 'strength-fill strength-fair';
            strengthFill.style.width = '40%';
            feedback = 'Contraseña débil';
            break;
        case 3:
        case 4:
            strengthFill.className = 'strength-fill strength-good';
            strengthFill.style.width = '80%';
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
        
        // Reset all requirements
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(req);
            const icon = element.querySelector('i');
            element.classList.remove('valid');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-times');
        });
    }
    
    strengthText.textContent = feedback;
}

// Password confirmation checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password-confirm').value;
    const confirmInput = document.getElementById('password-confirm');
    
    if (confirmPassword.length > 0) {
        if (password === confirmPassword) {
            confirmInput.style.borderColor = '#10B981';
        } else {
            confirmInput.style.borderColor = '#EF4444';
        }
    } else {
        confirmInput.style.borderColor = '#E5E7EB';
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password-confirm');
    const newPasswordBtn = document.querySelector('.btn-new-password');
    
    // Password strength checker
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        checkPasswordMatch();
    });
    
    // Password confirmation checker
    confirmPasswordInput.addEventListener('input', function() {
        checkPasswordMatch();
    });
    
    // Ripple effect for button
    newPasswordBtn.addEventListener('click', function(e) {
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
    
    // Animate tips on load
    const tips = document.querySelectorAll('.tip-item');
    tips.forEach((tip, index) => {
        tip.style.opacity = '0';
        tip.style.transform = 'translateY(20px)';
        tip.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        
        setTimeout(() => {
            tip.style.opacity = '1';
            tip.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
});
</script>
@endsection