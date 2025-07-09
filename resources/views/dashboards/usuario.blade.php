@extends('layouts.app')

@section('content')
<div class="client-dashboard">
    <!-- Header Premium para Cliente -->
    <div class="client-header">
        <div class="header-overlay"></div>
        <div class="floating-elements">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
            <div class="floating-triangle triangle-1"></div>
            <div class="floating-triangle triangle-2"></div>
        </div>
        <div class="header-content">
            <div class="welcome-section">
                <div class="client-avatar-container">
                    <div class="client-avatar">
                        <i class="fas fa-user-circle"></i>
                        <div class="avatar-glow"></div>
                    </div>
                </div>
                <div class="welcome-text">
                <h1 class="client-welcome">
            <span class="text-gradient">¡Bienvenido</span> 
            <span class="user-name">{{ auth()->check() ? (auth()->user()->name ?? 'Usuario') : 'Invitado' }}</span> 
            a tu Panel Premium!
        </h1>
                    <p class="client-subtitle">
                        <i class="fas fa-sparkles"></i>
                        Gestiona tus servicios de manera fácil y eficiente
                    </p>
                </div>
            </div>
            <div class="header-benefits">
                <div class="benefit-item">
                    <div class="benefit-icon-wrapper">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <span>Seguro y Confiable</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon-wrapper">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span>Disponible 24/7</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon-wrapper">
                        <i class="fas fa-headset"></i>
                    </div>
                    <span>Soporte Técnico</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="client-content">
        <div class="content-wrapper">
            <!-- Mensaje de Bienvenida Personalizado -->
            <div class="welcome-message">
                <div class="message-content">
                    <h2>
                        <i class="fas fa-star-of-david"></i>
                        Tu experiencia es nuestra prioridad
                    </h2>
                    <p>Hemos diseñado este panel especialmente para ti. Accede a todos tus servicios de manera intuitiva y segura.</p>
                    <div class="message-stats">
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Soporte</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Seguro</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">∞</span>
                            <span class="stat-label">Acceso</span>
                        </div>
                    </div>
                </div>
                <div class="message-illustration">
                    <div class="illustration-container">
                        <i class="fas fa-gem"></i>
                        <div class="illustration-glow"></div>
                    </div>
                </div>
            </div>

            <!-- Módulo Principal - Venta Cliente -->
            <div class="main-module-section">
                <div class="section-title">
                    <h2>
                        <span class="title-icon">💼</span>
                        Área de Ventas Premium
                    </h2>
                    <p>Accede a tu historial de compras y gestiona tus cursos</p>
                </div>

                <div class="client-module-card premium">
                    <div class="module-decoration">
                        <div class="decoration-circle"></div>
                        <div class="decoration-dots"></div>
                        <div class="sparkles">
                            <span class="sparkle sparkle-1">✨</span>
                            <span class="sparkle sparkle-2">⭐</span>
                            <span class="sparkle sparkle-3">✨</span>
                        </div>
                    </div>
                    
                    <div class="module-header">
                        <div class="module-icon-wrapper">
                            <div class="icon-background">
                                <i class="fas fa-shopping-cart module-icon"></i>
                            </div>
                            <div class="icon-pulse"></div>
                        </div>
                        <div class="premium-badge">
                            <i class="fas fa-crown"></i>
                            <span>Servicio Premium</span>
                            <div class="badge-glow"></div>
                        </div>
                    </div>

                    <div class="module-body">
                        <h3 class="module-title">
                            <span class="gradient-text">Panel de Ventas</span>
                        </h3>
                        <p class="module-description">
                            Consulta el historial completo de tus cursos adquiridos, revisa el estado de tus compras y accede a toda la información de tus servicios contratados.
                        </p>
                        
                        <div class="module-features">
                            <div class="feature-list">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <span>Historial completo de compras</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <span>Estado de cursos en tiempo real</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <span>Descargas y certificados</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <span>Soporte técnico directo</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="module-footer">
                        <a href="{{ route('cliente.panel.superadmin') }}" class="premium-btn">
                            <span class="btn-text">Acceder a mis Ventas</span>
                            <div class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="btn-shine"></div>
                            <div class="btn-particles">
                                <span class="particle"></span>
                                <span class="particle"></span>
                                <span class="particle"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de Beneficios -->
            <div class="benefits-section">
                <h3>
                    <span class="emoji">🚀</span>
                    ¿Por qué elegir nuestros servicios?
                </h3>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-award"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Calidad Garantizada</h4>
                        <p>Contenido de alta calidad respaldado por expertos</p>
                        <div class="card-glow"></div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-infinity"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Acceso Ilimitado</h4>
                        <p>Disfruta de acceso sin restricciones a tu contenido</p>
                        <div class="card-glow"></div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-mobile-alt"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Multiplataforma</h4>
                        <p>Accede desde cualquier dispositivo, en cualquier momento</p>
                        <div class="card-glow"></div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Comunidad Activa</h4>
                        <p>Conecta con otros usuarios y comparte experiencias</p>
                        <div class="card-glow"></div>
                    </div>
                </div>
            </div>

            <!-- Sección de Contacto -->
            <div class="contact-section">
                <div class="contact-content">
                    <h3>
                        <span class="emoji">💬</span>
                        ¿Necesitas ayuda?
                    </h3>
                    <p>Nuestro equipo está disponible para asistirte en cualquier momento</p>
                    <div class="contact-options">
                        <div class="contact-option">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span>cenefco@gmail.com</span>
                        </div>
                        <div class="contact-option">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>+591 60100541</span>
                        </div>
                        <div class="contact-option">
                            <div class="contact-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <span>Chat en vivo disponible</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .client-dashboard {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    .client-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        padding: 4rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        opacity: 0.4;
    }

    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .floating-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        animation: float 6s ease-in-out infinite;
    }

    .circle-1 {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .circle-2 {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .circle-3 {
        width: 100px;
        height: 100px;
        bottom: 10%;
        left: 70%;
        animation-delay: 4s;
    }

    .floating-triangle {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        border-bottom: 35px solid rgba(255,255,255,0.1);
        animation: rotate 10s linear infinite;
    }

    .triangle-1 {
        top: 30%;
        right: 20%;
        animation-delay: 1s;
    }

    .triangle-2 {
        bottom: 20%;
        left: 20%;
        animation-delay: 3s;
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .welcome-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 3rem;
        color: white;
    }

    .client-avatar-container {
        position: relative;
    }

    .client-avatar {
        font-size: 5rem;
        color: rgba(255,255,255,0.95);
        animation: pulse 2s infinite;
        position: relative;
        z-index: 2;
    }

    .avatar-glow {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        border-radius: 50%;
        animation: glow 3s ease-in-out infinite;
    }

    .welcome-text h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .text-gradient {
        background: linear-gradient(45deg, #ffd700, #ffed4e, #fff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s ease-in-out infinite;
    }

    .client-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 400;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-benefits {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255,255,255,0.15);
        padding: 1.5rem 2.5rem;
        border-radius: 60px;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255,255,255,0.2);
        color: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .benefit-item:hover {
        transform: translateY(-5px) scale(1.05);
        background: rgba(255,255,255,0.25);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .benefit-icon-wrapper {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .client-content {
        background: #f8fafc;
        padding: 5rem 2rem;
        margin-top: -40px;
        border-radius: 40px 40px 0 0;
        position: relative;
        z-index: 1;
        box-shadow: 0 -20px 40px rgba(0,0,0,0.1);
    }

    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-message {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem;
        border-radius: 25px;
        margin-bottom: 4rem;
        box-shadow: 0 20px 60px rgba(102,126,234,0.3);
        position: relative;
        overflow: hidden;
    }

    .welcome-message::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: rotate 10s linear infinite;
    }

    .message-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .message-content h2 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .message-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    .message-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }

    .stat-item {
        text-align: center;
        background: rgba(255,255,255,0.15);
        padding: 1rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        min-width: 80px;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffd700;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .message-illustration {
        position: relative;
        z-index: 2;
    }

    .illustration-container {
        position: relative;
        font-size: 6rem;
        opacity: 0.8;
        animation: float 4s ease-in-out infinite;
    }

    .illustration-glow {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        background: radial-gradient(circle, rgba(255,215,0,0.3) 0%, transparent 70%);
        border-radius: 50%;
        animation: glow 2s ease-in-out infinite;
    }

    .main-module-section {
        margin-bottom: 5rem;
    }

    .section-title {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-title h2 {
        font-size: 2.8rem;
        color: #2d3748;
        margin-bottom: 1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .title-icon {
        font-size: 2.5rem;
        animation: bounce 2s infinite;
    }

    .section-title p {
        color: #718096;
        font-size: 1.2rem;
    }

    .client-module-card {
        background: white;
        border-radius: 30px;
        padding: 4rem;
        box-shadow: 0 30px 80px rgba(0,0,0,0.12);
        border: 2px solid rgba(102,126,234,0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .client-module-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 40px 100px rgba(0,0,0,0.2);
    }

    .module-decoration {
        position: absolute;
        top: -60px;
        right: -60px;
        width: 250px;
        height: 250px;
        opacity: 0.1;
    }

    .decoration-circle {
        width: 100%;
        height: 100%;
        border: 4px solid #667eea;
        border-radius: 50%;
        animation: rotate 25s linear infinite;
    }

    .decoration-dots {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 15px;
        height: 15px;
        background: #667eea;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .sparkles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .sparkle {
        position: absolute;
        font-size: 1.5rem;
        animation: twinkle 3s ease-in-out infinite;
    }

    .sparkle-1 {
        top: 20%;
        left: 20%;
        animation-delay: 0s;
    }

    .sparkle-2 {
        top: 60%;
        right: 30%;
        animation-delay: 1s;
    }

    .sparkle-3 {
        bottom: 20%;
        left: 60%;
        animation-delay: 2s;
    }

    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
    }

    .module-icon-wrapper {
        position: relative;
    }

    .icon-background {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 40px rgba(102,126,234,0.4);
        transition: all 0.3s ease;
    }

    .module-icon {
        font-size: 2.5rem;
        color: white;
    }

    .icon-pulse {
        position: absolute;
        top: -5px;
        left: -5px;
        width: calc(100% + 10px);
        height: calc(100% + 10px);
        border: 3px solid #667eea;
        border-radius: 25px;
        animation: pulse-ring 2s infinite;
    }

    .premium-badge {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #744210;
        padding: 1rem 2rem;
        border-radius: 30px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 1rem;
        box-shadow: 0 10px 30px rgba(255,215,0,0.4);
        position: relative;
        overflow: hidden;
    }

    .badge-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 3s ease-in-out infinite;
    }

    .module-body {
        margin-bottom: 3rem;
    }

    .module-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 2rem;
    }

    .gradient-text {
        background: linear-gradient(45deg, #667eea, #764ba2, #f093fb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradient-shift 3s ease-in-out infinite;
    }

    .module-description {
        font-size: 1.2rem;
        color: #4a5568;
        line-height: 1.8;
        margin-bottom: 2.5rem;
    }

    .feature-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px;
        color: #2d3748;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .feature-item:hover {
        transform: translateX(10px);
        border-color: #667eea;
        box-shadow: 0 10px 30px rgba(102,126,234,0.2);
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 5px 15px rgba(56,161,105,0.3);
    }

    .premium-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 3rem;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.2rem;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 15px 40px rgba(102,126,234,0.4);
    }

    .premium-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 25px 60px rgba(102,126,234,0.6);
        color: white;
        text-decoration: none;
    }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s ease;
    }

    .premium-btn:hover .btn-shine {
        left: 100%;
    }

    .btn-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,0.8);
        border-radius: 50%;
        animation: particle-float 3s ease-in-out infinite;
    }

    .particle:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
    .particle:nth-child(2) { top: 60%; right: 20%; animation-delay: 1s; }
    .particle:nth-child(3) { bottom: 20%; left: 60%; animation-delay: 2s; }

    .benefits-section {
        margin-bottom: 5rem;
    }

    .benefits-section h3 {
        text-align: center;
        font-size: 2.5rem;
        color: #2d3748;
        margin-bottom: 4rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .emoji {
        font-size: 2.5rem;
        animation: bounce 2s infinite;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
    }

    .benefit-card {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .benefit-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        border-color: #667eea;
    }

    .benefit-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 2rem;
        box-shadow: 0 15px 40px rgba(102,126,234,0.3);
        position: relative;
        transition: all 0.3s ease;
    }

    .benefit-card:hover .benefit-icon {
        transform: scale(1.1);
        box-shadow: 0 20px 50px rgba(102,126,234,0.5);
    }

    .icon-bg-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: linear-gradient(45deg, rgba(102,126,234,0.3), rgba(118,75,162,0.3));
        border-radius: 25px;
        animation: glow 3s ease-in-out infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .benefit-card:hover .icon-bg-glow {
        opacity: 1;
    }

    .benefit-card h4 {
        color: #2d3748;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    .benefit-card p {
        color: #4a5568;
        line-height: 1.7;
        font-size: 1.1rem;
    }

    .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(102,126,234,0.1), transparent);
        animation: rotate 8s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .benefit-card:hover .card-glow {
        opacity: 1;
    }

    .contact-section {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        color: white;
        padding: 4rem;
        border-radius: 25px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .contact-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 15s linear infinite;
    }

    .contact-content {
        position: relative;
        z-index: 2;
    }

    .contact-content h3 {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .contact-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 3rem;
    }

    .contact-options {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .contact-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255,255,255,0.15);
        padding: 1.5rem 2rem;
        border-radius: 60px;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .contact-option:hover {
        transform: translateY(-3px);
        background: rgba(255,255,255,0.25);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* Animaciones */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes glow {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    @keyframes pulse-ring {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.3); opacity: 0; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0.3; transform: scale(0.8); }
        50% { opacity: 1; transform: scale(1.2); }
    }

    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes particle-float {
        0%, 100% { transform: translateY(0px); opacity: 0.3; }
        50% { transform: translateY(-10px); opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .client-header {
            padding: 2rem 1rem;
        }
        
        .welcome-section {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .welcome-text h1 {
            font-size: 2.2rem;
        }
        
        .header-benefits {
            gap: 1rem;
        }
        
        .benefit-item {
            padding: 1rem 1.5rem;
        }
        
        .client-content {
            padding: 3rem 1rem;
        }
        
        .client-module-card {
            padding: 2.5rem;
        }
        
        .welcome-message {
            flex-direction: column;
            text-align: center;
            padding: 2rem;
        }
        
        .message-illustration {
            margin-top: 2rem;
        }
        
        .message-stats {
            justify-content: center;
        }
        
        .benefits-grid {
            grid-template-columns: 1fr;
        }
        
        .contact-options {
            flex-direction: column;
            gap: 1rem;
        }
        
        .section-title h2 {
            font-size: 2.2rem;
        }
        
        .module-title {
            font-size: 2rem;
        }
        
        .floating-circle,
        .floating-triangle {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .welcome-text h1 {
            font-size: 1.8rem;
        }
        
        .client-avatar {
            font-size: 4rem;
        }
        
        .section-title h2 {
            font-size: 1.8rem;
        }
        
        .benefits-section h3 {
            font-size: 2rem;
        }
        
        .contact-content h3 {
            font-size: 2rem;
        }
        
        .client-module-card {
            padding: 2rem;
        }
        
        .welcome-message {
            padding: 1.5rem;
        }
        
        .message-content h2 {
            font-size: 1.8rem;
        }
        
        .premium-btn {
            padding: 1.2rem 2rem;
            font-size: 1rem;
        }
    }
</style>
@endsection
