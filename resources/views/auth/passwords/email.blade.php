@extends('layouts.app')

@section('content')
<div class="reset-container">
    <!-- Fondo con patrón geométrico -->
    <div class="background-pattern"></div>
    
    <div class="reset-content">
        <!-- Logo responsivo -->
        <div class="logo-container">
            <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" class="logo">
        </div>

        <!-- Formulario de recuperación -->
        <div class="reset-form-wrapper">
            <div class="card reset-card">
                <div class="card-header">
                    <div class="reset-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 class="card-title">Recuperar contraseña</h4>
                    <p class="card-subtitle">Te ayudamos a recuperar el acceso a tu cuenta</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>¡Correo enviado!</strong>
                                <p>{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="reset-info">
                        <div class="info-steps">
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <p>Ingresa tu correo electrónico</p>
                            </div>
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <p>Recibirás un enlace de recuperación</p>
                            </div>
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <p>Crea una nueva contraseña segura</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}" class="reset-form">
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

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-reset">
                            <span class="btn-text">Enviar enlace de recuperación</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="reset-links">
                        <div class="back-to-login">
                            <a href="{{ route('login') }}" class="login-link">
                                <i class="fas fa-arrow-left"></i>
                                Volver al inicio de sesión
                            </a>
                        </div>

                        <div class="help-section">
                            <div class="help-box">
                                <i class="fas fa-question-circle"></i>
                                <div>
                                    <strong>¿Necesitas ayuda?</strong>
                                    <p>Si no recibes el correo, revisa tu carpeta de spam o contacta soporte.</p>
                                </div>
                            </div>
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

.reset-container {
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

.reset-content {
    width: 100%;
    max-width: 500px;
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
    max-width: 400px;
    width: 100%;
    height: auto;
    filter: drop-shadow(0 8px 25px rgba(0,0,0,0.15));
    transition: all 0.4s ease;
}

.logo:hover {
    transform: scale(1.03) rotate(0.5deg);
    filter: drop-shadow(0 12px 35px rgba(0,0,0,0.2));
}

/* Tarjeta principal */
.reset-card {
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

.reset-card:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 40px rgba(0,0,0,0.15),
        0 4px 12px rgba(0,0,0,0.1);
}

/* Header de la tarjeta */
.card-header {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
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
    background: linear-gradient(135deg, #D97706 0%, #B45309 100%);
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

.reset-card:hover .card-header::before {
    opacity: 1;
}

.reset-icon {
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

/* Alert de éxito */
.alert-success {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    border: none;
    border-radius: 12px;
    color: white;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.alert-success i {
    font-size: 1.5rem;
    margin-top: 2px;
}

.alert-success strong {
    display: block;
    margin-bottom: 5px;
    font-size: 1.1rem;
}

.alert-success p {
    margin: 0;
    opacity: 0.95;
}

/* Info de pasos */
.reset-info {
    margin-bottom: 30px;
}

.info-steps {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 25px;
}

.step-item {
    flex: 1;
    text-align: center;
    padding: 20px 15px;
    background: rgba(249, 250, 251, 0.8);
    border-radius: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.step-item:hover {
    border-color: #F59E0B;
    background: rgba(249, 250, 251, 0.95);
    transform: translateY(-2px);
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    margin: 0 auto 10px;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.step-item p {
    margin: 0;
    color: #374151;
    font-size: 0.9rem;
    font-weight: 500;
    line-height: 1.4;
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
    border-color: #F59E0B;
    background: white;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-control:focus + .input-icon {
    color: #F59E0B;
}

.form-control.is-invalid {
    border-color: #EF4444;
}

/* Botón de reset */
.btn-reset {
    width: 100%;
    height: 56px;
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
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
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.btn-reset::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-reset:hover::before {
    left: 100%;
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
    background: linear-gradient(135deg, #D97706 0%, #B45309 100%);
}

.btn-reset:active {
    transform: translateY(0);
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-reset i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-reset:hover i {
    transform: translateX(4px);
}

/* Enlaces */
.reset-links {
    text-align: center;
}

.back-to-login {
    margin-bottom: 25px;
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
    color: #F59E0B;
    text-decoration: underline;
}

.login-link i {
    transition: transform 0.3s ease;
}

.login-link:hover i {
    transform: translateX(-3px);
}

/* Sección de ayuda */
.help-section {
    margin-top: 25px;
}

.help-box {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.help-box i {
    color: #3B82F6;
    font-size: 1.5rem;
    margin-top: 2px;
}

.help-box strong {
    color: #1F2937;
    display: block;
    margin-bottom: 5px;
    font-size: 1rem;
}

.help-box p {
    color: #6B7280;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.5;
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
    .reset-container {
        padding: 15px;
    }
    
    .reset-content {
        max-width: 100%;
    }
    
    .logo {
        max-width: 300px;
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
    
    .reset-icon {
        font-size: 2.5rem;
    }
    
    .info-steps {
        flex-direction: column;
        gap: 10px;
    }
    
    .step-item {
        padding: 15px;
    }
    
    .step-number {
        width: 35px;
        height: 35px;
        font-size: 1.1rem;
    }
    
    .form-control {
        height: 48px;
        font-size: 0.95rem;
    }
    
    .btn-reset {
        height: 48px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .reset-container {
        padding: 10px;
    }
    
    .logo {
        max-width: 250px;
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
    
    .reset-icon {
        font-size: 2rem;
    }
    
    .form-control {
        height: 46px;
        font-size: 0.9rem;
    }
    
    .btn-reset {
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

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.reset-content {
    animation: fadeInUp 0.6s ease-out;
}

.reset-icon {
    animation: fadeInUp 0.8s ease-out 0.3s both;
}

.step-item {
    animation: slideInFromLeft 0.6s ease-out;
}

.step-item:nth-child(1) { animation-delay: 0.1s; }
.step-item:nth-child(2) { animation-delay: 0.2s; }
.step-item:nth-child(3) { animation-delay: 0.3s; }

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
// Efecto de ondas en el botón
document.addEventListener('DOMContentLoaded', function() {
    const resetBtn = document.querySelector('.btn-reset');
    
    resetBtn.addEventListener('click', function(e) {
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
    
    // Animación de aparición progresiva para los pasos
    const steps = document.querySelectorAll('.step-item');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateX(0)';
            }
        });
    }, observerOptions);
    
    steps.forEach((step, index) => {
        step.style.opacity = '0';
        step.style.transform = 'translateX(-20px)';
        step.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(step);
    });
});
</script>
@endsection