<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS - UNA SOLA VERSIÓN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CENEFCO') }}</title>

    <!-- Bootstrap + Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Estilos mejorados -->
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --sidebar-bg: #f8fafc;
            --sidebar-border: #e2e8f0;
            --navbar-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --radius: 0.75rem;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f5f9;
            color: var(--text-primary);
        }

        /* Navbar mejorado */
        .navbar-custom {
            background: var(--navbar-bg);
            border-bottom: 1px solid var(--sidebar-border);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            letter-spacing: -0.025em;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            transition: all 0.2s ease;
            padding: 0.5rem 1rem !important;
            border-radius: var(--radius);
        }

        .navbar-nav .nav-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-md);
            border-radius: var(--radius);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-header {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: var(--sidebar-border);
        }

        .dropdown-item {
            border-radius: calc(var(--radius) - 2px);
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }

        /* Sidebar mejorado */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-visible {
            transform: translateX(0%) !important;
        }

        #sidebar {
            transform: translateX(-100%);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
        }

        /* Botón del sidebar */
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            padding: 0.75rem;
            box-shadow: var(--shadow-md);
            transition: all 0.2s ease;
            font-size: 1.1rem;
        }

        .sidebar-toggle:hover {
            background: var(--primary-hover);
            transform: scale(1.05);
        }

        /* Contenido principal */
        .main-content {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            min-height: calc(100vh - 120px);
            padding: 2rem;
            margin: 1rem;
        }

        /* Overlay para móvil */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-toggle {
                top: 15px;
                left: 15px;
                padding: 0.6rem;
            }

            .main-content {
                margin: 0.5rem;
                padding: 1rem;
            }
        }

        /* Animaciones suaves */
        * {
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        /* Mejoras adicionales */
        .container-fluid {
            max-width: 1400px;
        }

        /* Estados de focus mejorados */
        .btn:focus,
        .nav-link:focus,
        .dropdown-item:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar mejorado -->
        <nav class="navbar navbar-expand-md navbar-light navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-graduation-cap me-2"></i>
                    {{ config('app.name', 'CENEFCO') }}
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i>
                                        {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-user me-2"></i>
                                        {{ Auth::user()->name }}
                                    </h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="showUserProfile()">
                                        <i class="fas fa-user-cog me-2"></i>
                                        Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Botón del sidebar -->
        <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Overlay para móvil -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="hideSidebar()"></div>

        <!-- Contenido con sidebar -->
        <main class="d-flex">
            @include('layouts.partials.sidebar')
            
            <div class="container-fluid">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Script mejorado para controlar sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            const isVisible = sidebar.classList.contains('sidebar-visible');
            
            if (isVisible) {
                hideSidebar();
            } else {
                showSidebar();
            }
        }

        function showSidebar() {
            sidebar.classList.add('sidebar-visible');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideSidebar() {
            sidebar.classList.remove('sidebar-visible');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Cerrar sidebar con tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('sidebar-visible')) {
                hideSidebar();
            }
        });

        // Script mejorado para controlar sidebar y dropdown
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar sidebar
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar) {
                sidebar.classList.remove('sidebar-visible');
            }
            
            // Asegurar que Bootstrap está cargado y funcionando
            if (typeof bootstrap !== 'undefined') {
                console.log('Bootstrap cargado correctamente');
                
                // Inicializar dropdowns explícitamente
                const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
                const dropdownList = [...dropdownElementList].map(dropdownToggleEl => {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
                
                // Verificar que el dropdown del usuario funciona
                const userDropdown = document.getElementById('navbarDropdown');
                if (userDropdown) {
                    userDropdown.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('Dropdown clickeado');
                        
                        // Forzar toggle del dropdown
                        const dropdown = bootstrap.Dropdown.getInstance(userDropdown) || new bootstrap.Dropdown(userDropdown);
                        dropdown.toggle();
                    });
                }
            } else {
                console.error('Bootstrap no está cargado');
            }
            
            // Cerrar sidebar en pantallas grandes
            const handleResize = () => {
                if (window.innerWidth >= 768) {
                    hideSidebar();
                }
            };
            
            window.addEventListener('resize', handleResize);
        });

        // Funciones del sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isVisible = sidebar.classList.contains('sidebar-visible');
            
            if (isVisible) {
                hideSidebar();
            } else {
                showSidebar();
            }
        }

        function showSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('sidebar-visible');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('sidebar-visible');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Cerrar sidebar con tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && sidebar.classList.contains('sidebar-visible')) {
                    hideSidebar();
                }
            }
        });

        // Función placeholder para perfil
        function showUserProfile() {
            alert('Función de perfil - implementar según necesidad');
        }
    </script>

    @stack('scripts')

    <!-- Bootstrap 5 JavaScript - UNA SOLA VERSIÓN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>