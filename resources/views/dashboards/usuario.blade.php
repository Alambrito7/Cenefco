@extends('layouts.app')

@section('content')
<div class="modern-client-dashboard">
    <!-- Navigation Bar -->
    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-brand">
                <div class="brand-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <span class="brand-text">CENEFCO</span>
            </div>
            <div class="nav-actions">
                <button class="nav-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                <div class="user-menu">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name">{{ auth()->check() ? (auth()->user()->name ?? 'Usuario') : 'Invitado' }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>
        </div>
        <div class="hero-content">
            <div class="welcome-badge">
                <i class="fas fa-crown"></i>
                <span>Cliente Premium</span>
            </div>
            <h1 class="hero-title">
                <span class="gradient-text">¡Bienvenido</span> 
                <span class="user-highlight">{{ auth()->check() ? (auth()->user()->name ?? 'Usuario') : 'Invitado' }}</span><br>
                <span class="subtitle">a tu Panel Premium</span>
            </h1>
            <p class="hero-description">
                <i class="fas fa-sparkles"></i>
                Gestiona tus servicios de manera fácil y eficiente con tecnología de última generación
            </p>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Seguro y Confiable</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Disponible Siempre</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number">∞</span>
                        <span class="stat-label">Soporte Técnico</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Welcome Message -->
            <section class="welcome-message">
                <div class="message-bg-effect"></div>
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
            </section>

            <!-- Sales Panel Section -->
            <section class="sales-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <span class="title-icon">💼</span>
                        Área de Ventas Premium
                    </h2>
                    <p class="section-subtitle">Accede a tu historial de compras y gestiona tus cursos</p>
                </div>

                <div class="sales-card">
                    <div class="card-bg-effect"></div>
                    <div class="sparkles">
                        <span class="sparkle sparkle-1">✨</span>
                        <span class="sparkle sparkle-2">⭐</span>
                        <span class="sparkle sparkle-3">✨</span>
                    </div>
                    
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <div class="icon-glow"></div>
                        </div>
                        <div class="premium-badge">
                            <i class="fas fa-crown"></i>
                            <span>Servicio Premium</span>
                            <div class="badge-glow"></div>
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">
                            <span class="gradient-text">Panel de Ventas</span>
                        </h3>
                        <p class="card-description">
                            Consulta el historial completo de tus cursos adquiridos, revisa el estado de tus compras y accede a toda la información de tus servicios contratados.
                        </p>
                        
                        <div class="features-grid">
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

                    <div class="card-footer">
                        <a href="{{ route('cliente.panel.superadmin') }}" class="cta-button" id="salesBtn">
                            <span class="btn-text">Acceder a mis Ventas</span>
                            <div class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="btn-glow"></div>
                            <div class="btn-particles">
                                <span class="particle"></span>
                                <span class="particle"></span>
                                <span class="particle"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Benefits Section -->
            <section class="benefits-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <span class="title-icon">🚀</span>
                        ¿Por qué elegir nuestros servicios?
                    </h2>
                </div>
                
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="card-glow-effect"></div>
                        <div class="benefit-icon">
                            <i class="fas fa-award"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Calidad Garantizada</h4>
                        <p>Contenido de alta calidad respaldado por expertos en la industria</p>
                    </div>
                    <div class="benefit-card">
                        <div class="card-glow-effect"></div>
                        <div class="benefit-icon">
                            <i class="fas fa-infinity"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Acceso Ilimitado</h4>
                        <p>Disfruta de acceso sin restricciones a todo tu contenido premium</p>
                    </div>
                    <div class="benefit-card">
                        <div class="card-glow-effect"></div>
                        <div class="benefit-icon">
                            <i class="fas fa-mobile-alt"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Multiplataforma</h4>
                        <p>Accede desde cualquier dispositivo, en cualquier momento y lugar</p>
                    </div>
                    <div class="benefit-card">
                        <div class="card-glow-effect"></div>
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                            <div class="icon-bg-glow"></div>
                        </div>
                        <h4>Comunidad Activa</h4>
                        <p>Conecta con otros usuarios y comparte experiencias valiosas</p>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact-section">
                <div class="contact-bg"></div>
                <div class="contact-content">
                    <h3 class="contact-title">
                        <span class="title-icon">💬</span>
                        ¿Necesitas ayuda?
                    </h3>
                    <p class="contact-description">
                        Nuestro equipo está disponible para asistirte en cualquier momento
                    </p>
                    <div class="contact-grid">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <span class="contact-label">Email</span>
                                <span class="contact-value">cenefco@gmail.com</span>
                            </div>
                        </div>
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info">
                                <span class="contact-label">Teléfono</span>
                                <span class="contact-value">+591 60100541</span>
                            </div>
                        </div>
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="contact-info">
                                <span class="contact-label">Chat</span>
                                <span class="contact-value">Disponible en vivo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --dark-bg: #0f0f23;
        --card-bg: rgba(255, 255, 255, 0.05);
        --glass-border: rgba(255, 255, 255, 0.1);
        --text-primary: #ffffff;
        --text-secondary: rgba(255, 255, 255, 0.7);
        --text-accent: #667eea;
        --shadow-primary: 0 8px 32px rgba(31, 38, 135, 0.37);
        --shadow-glow: 0 0 20px rgba(102, 126, 234, 0.3);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--dark-bg);
        color: var(--text-primary);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .modern-client-dashboard {
        min-height: 100vh;
        background: 
            radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(240, 147, 251, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(79, 172, 254, 0.1) 0%, transparent 50%),
            var(--dark-bg);
    }

    /* Navigation */
    .top-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: rgba(15, 15, 35, 0.9);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 800;
        font-size: 1.25rem;
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-btn {
        width: 40px;
        height: 40px;
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        color: var(--text-primary);
    }

    .nav-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .notification-dot {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 8px;
        height: 8px;
        background: #ff4757;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-menu:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    /* Hero Section */
    .hero-section {
        padding: 120px 2rem 80px;
        position: relative;
        overflow: hidden;
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: var(--primary-gradient);
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 100px;
        height: 100px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        top: 50%;
        right: 15%;
        animation-delay: 2s;
        background: var(--secondary-gradient);
    }

    .shape-3 {
        width: 80px;
        height: 80px;
        bottom: 20%;
        left: 60%;
        animation-delay: 4s;
        background: var(--accent-gradient);
    }

    .shape-4 {
        width: 120px;
        height: 120px;
        top: 70%;
        left: 20%;
        animation-delay: 1s;
    }

    .hero-content {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        margin-bottom: 2rem;
        font-weight: 600;
        color: #ffd700;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .user-highlight {
        color: #ffd700;
        text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
    }

    .subtitle {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .hero-description {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .stat-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        min-width: 180px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-glow);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-gradient);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Main Content */
    /* REEMPLÁZALO POR: */
.main-content {
    background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
    padding: 0 2rem 5rem;
    color: white;
}

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .title-icon {
        font-size: 2rem;
        animation: bounce 2s infinite;
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    /* Welcome Message */
    .welcome-message {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        padding: 3rem;
        margin-bottom: 6rem;
        position: relative;
        overflow: hidden;
    }

    .message-bg-effect {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.1), transparent);
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
        color: var(--text-secondary);
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
        background: rgba(255,255,255,0.05);
        padding: 1rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        min-width: 80px;
    }

    .stat-item .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffd700;
    }

    .stat-item .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
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

    /* Sales Section */
    .sales-section {
        margin-bottom: 6rem;
    }

    .sales-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    color: white;
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        transition: all 0.5s ease;
    }

    .sales-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-glow);
    }

    .card-bg-effect {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        animation: rotate 20s linear infinite;
    }

    .sparkles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
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

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }

    .card-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-gradient);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        position: relative;
        box-shadow: var(--shadow-primary);
    }

    .icon-glow {
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        background: var(--primary-gradient);
        border-radius: 25px;
        opacity: 0.5;
        animation: pulse 2s infinite;
        z-index: -1;
    }

    .premium-badge {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #744210;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
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

    .card-content {
        position: relative;
        z-index: 2;
        margin-bottom: 2.5rem;
    }

    .card-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
    }

    .card-description {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        border: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateX(10px);
        background: rgba(255, 255, 255, 0.1);
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .card-footer {
        position: relative;
        z-index: 2;
    }

    .cta-button {
        background: var(--primary-gradient);
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-primary);
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-glow {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s ease;
    }

    .cta-button:hover .btn-glow {
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

    /* Benefits Section */
    .benefits-section {
        margin-bottom: 6rem;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .benefit-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        padding: 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .benefit-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-glow);
    }

    .card-glow-effect {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        animation: rotate 15s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .benefit-card:hover .card-glow-effect {
        opacity: 1;
    }

    .benefit-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-gradient);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        box-shadow: var(--shadow-primary);
        position: relative;
        z-index: 2;
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
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }

    .benefit-card p {
        color: var(--text-secondary);
        line-height: 1.6;
        position: relative;
        z-index: 2;
    }

    /* Contact Section */
    .contact-section {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 4rem;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .contact-bg {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        animation: rotate 25s linear infinite;
    }

    .contact-content {
        position: relative;
        z-index: 2;
    }

    .contact-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .contact-description {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 3rem;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.1);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-gradient);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .contact-info {
        text-align: left;
    }

    .contact-label {
        display: block;
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .contact-value {
        display: block;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.05); opacity: 1; }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes glow {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0.3; transform: scale(0.8); }
        50% { opacity: 1; transform: scale(1.2); }
    }

    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes particle-float {
        0%, 100% { transform: translateY(0px); opacity: 0.3; }
        50% { transform: translateY(-10px); opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .nav-container {
            padding: 1rem;
        }

        .hero-section {
            padding: 100px 1rem 60px;
        }

        .hero-stats {
            gap: 1rem;
        }

        .stat-card {
            min-width: 120px;
            padding: 1rem;
            flex-direction: column;
            text-align: center;
        }

        .main-content {
            padding: 0 1rem 3rem;
        }

        .sales-card {
            padding: 2rem;
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

        .features-grid {
            grid-template-columns: 1fr;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
        }

        .contact-section {
            padding: 2.5rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-card {
            flex-direction: column;
            text-align: center;
        }

        .contact-info {
            text-align: center;
        }

        .section-title {
            flex-direction: column;
            gap: 0.5rem;
        }

        .user-menu .user-name {
            display: none;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }
        .section-title {
            color: #ffffff;
        }

        .card-title {
            font-size: 2rem;
        }

        .contact-title {
            font-size: 2rem;
        }

        .sales-card {
            padding: 1.5rem;
        }

        .benefit-card {
            padding: 2rem;
        }

        .contact-section {
            padding: 2rem;
        }

        .cta-button {
            width: 100%;
            justify-content: center;
        }

        .hero-stats {
            flex-direction: column;
            align-items: center;
        }

        .stat-card {
            width: 100%;
            max-width: 200px;
        }
    }

    /* Loading states */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid var(--text-primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Focus states for accessibility */
    .cta-button:focus,
    .nav-btn:focus,
    .user-menu:focus {
        outline: 2px solid var(--text-accent);
        outline-offset: 2px;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--dark-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-gradient);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulate sales button functionality
        const salesBtn = document.getElementById('salesBtn');
        
        if (salesBtn) {
            salesBtn.addEventListener('click', function(e) {
                // Add loading state
                this.classList.add('loading');
                this.style.pointerEvents = 'none';
                
                // Remove loading state after a short delay (in real app, this would be on page load)
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.style.pointerEvents = 'auto';
                }, 800);
            });
        }

        // Add smooth parallax effect to floating shapes
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.shape');
            
            shapes.forEach((shape, index) => {
                const speed = 0.1 + (index * 0.05);
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for scroll animations
        const animatedElements = document.querySelectorAll('.benefit-card, .sales-card, .contact-section, .welcome-message');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Add click effect to cards
        const cards = document.querySelectorAll('.benefit-card, .contact-card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Dynamic greeting based on time
        const updateGreeting = () => {
            const hour = new Date().getHours();
            const heroTitle = document.querySelector('.hero-title');
            let greeting = '¡Bienvenido';
            
            if (hour < 12) {
                greeting = '¡Buenos días';
            } else if (hour < 18) {
                greeting = '¡Buenas tardes';
            } else {
                greeting = '¡Buenas noches';
            }
            
            const gradientText = heroTitle?.querySelector('.gradient-text');
            if (gradientText) {
                gradientText.textContent = greeting;
            }
        };

        updateGreeting();

        // Add notification system
        const showNotification = (message, type = 'info') => {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content" style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 1rem;
                ">
                    <span>${message}</span>
                    <button class="notification-close" style="
                        background: none;
                        border: none;
                        color: inherit;
                        font-size: 1.2rem;
                        cursor: pointer;
                        padding: 0;
                        width: 20px;
                        height: 20px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">&times;</button>
                </div>
            `;
            
            // Add notification styles
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: var(--card-bg);
                backdrop-filter: blur(20px);
                border: 1px solid var(--glass-border);
                border-radius: 15px;
                padding: 1rem;
                z-index: 10000;
                min-width: 300px;
                max-width: 400px;
                color: var(--text-primary);
                transform: translateX(400px);
                transition: transform 0.3s ease;
                box-shadow: var(--shadow-glow);
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Close button functionality
            const closeBtn = notification.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            });
            
            // Auto close after 5 seconds
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    notification.style.transform = 'translateX(400px)';
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }
            }, 5000);
        };

        // Welcome notification
        setTimeout(() => {
            showNotification('¡Bienvenido a tu Panel Premium! Aquí puedes gestionar todos tus servicios.', 'success');
        }, 2000);
    });
</script>
@endsection