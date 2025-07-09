<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - {{ auth()->check() ? ucfirst(optional(auth()->user()->roles->first())->name ?? auth()->user()->role ?? 'Usuario') : 'Invitado' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #64748b;
            --secondary-color: #94a3b8;
            --accent-color: #cbd5e1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
            --sidebar-width: 280px;
            --silver-light: #e2e8f0;
            --silver-medium: #cbd5e1;
            --silver-dark: #64748b;
            --silver-darker: #475569;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Botón hamburguesa mejorado */
        .menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1060;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--silver-dark), var(--silver-darker));
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 8px 25px rgba(100, 116, 139, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(100, 116, 139, 0.4);
            background: linear-gradient(135deg, var(--silver-darker), var(--silver-dark));
        }

        .menu-toggle.active {
            transform: rotate(90deg);
        }

        /* Sidebar mejorado */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: rgba(248, 250, 252, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(203, 213, 225, 0.3);
            transform: translateX(-100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            box-shadow: 0 0 40px rgba(100, 116, 139, 0.15);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 30px 25px 20px;
            background: linear-gradient(135deg, var(--silver-dark), var(--silver-darker));
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .sidebar-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 5px;
            position: relative;
            z-index: 1;
        }

        .role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-top: 8px;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav {
            padding: 20px 0;
            height: calc(100vh - 140px);
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.3);
            border-radius: 2px;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            padding: 8px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--silver-darker);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .nav-item {
            margin: 4px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--silver-darker);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, var(--silver-dark), var(--silver-darker));
            transition: width 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover {
            color: white;
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.2);
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--silver-dark), var(--silver-darker));
            color: white;
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-text {
            flex: 1;
        }

        .nav-badge {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-left: 8px;
        }

        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 0;
            padding: 100px 30px 30px;
            transition: margin-left 0.3s ease;
        }

        .dashboard-header {
            background: rgba(248, 250, 252, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(100, 116, 139, 0.1);
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--silver-dark), var(--silver-darker));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .dashboard-subtitle {
            color: var(--silver-darker);
            font-size: 1.1rem;
            margin-top: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
            }
            
            .main-content {
                padding: 90px 20px 20px;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
        }

        /* Animaciones adicionales */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-item {
            animation: slideIn 0.3s ease forwards;
        }

        .nav-item:nth-child(1) { animation-delay: 0.05s; }
        .nav-item:nth-child(2) { animation-delay: 0.1s; }
        .nav-item:nth-child(3) { animation-delay: 0.15s; }
        .nav-item:nth-child(4) { animation-delay: 0.2s; }
        .nav-item:nth-child(5) { animation-delay: 0.25s; }
        .nav-item:nth-child(6) { animation-delay: 0.3s; }
        .nav-item:nth-child(7) { animation-delay: 0.35s; }
        .nav-item:nth-child(8) { animation-delay: 0.4s; }
        .nav-item:nth-child(9) { animation-delay: 0.45s; }
        .nav-item:nth-child(10) { animation-delay: 0.5s; }
        .nav-item:nth-child(11) { animation-delay: 0.55s; }
        .nav-item:nth-child(12) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <!-- Botón hamburguesa -->
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Overlay -->
    <div class="sidebar-overlay" onclick="hideSidebar()"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="sidebar-title">📁 Panel de Control</h5>
            <p class="sidebar-subtitle">{{ auth()->check() ? (auth()->user()->name ?? 'Usuario') : 'Invitado' }}</p>
            <span class="role-badge">
                {{ auth()->check() ? ucfirst(optional(auth()->user()->roles->first())->name ?? auth()->user()->role ?? 'Usuario') : 'No autenticado' }}
            </span>
        </div>
        
        <div class="sidebar-nav">
            @auth
            {{-- DASHBOARD - Todos los roles --}}
            <div class="nav-section">
                <div class="nav-section-title">Principal</div>
                <div class="nav-item">
                    @php
                        $dashboardRoute = 'home';
                        $user = auth()->user();
                        
                        if ($user && ($user->hasRole('superadmin') || $user->role === 'superadmin')) {
                            $dashboardRoute = 'superadmin.dashboard';
                        } elseif ($user && ($user->hasRole('admin') || $user->role === 'admin')) {
                            $dashboardRoute = 'admin.dashboard';
                        } elseif ($user && ($user->hasRole('agente_administrativo') || $user->role === 'agente_administrativo')) {
                            $dashboardRoute = 'agente_administrativo.dashboard';
                        } elseif ($user && ($user->hasRole('agente_ventas') || $user->role === 'agente_ventas')) {
                            $dashboardRoute = 'agente_ventas.dashboard';
                        } elseif ($user && ($user->hasRole('agente_academico') || $user->role === 'agente_academico')) {
                            $dashboardRoute = 'agente_academico.dashboard';
                        } elseif ($user && ($user->hasRole('usuario') || $user->role === 'usuario')) {
                            $dashboardRoute = 'usuario.dashboard';
                        }
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="nav-link active" onclick="hideSidebar()">
                        <span class="nav-icon">🏠</span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
            </div>

            {{-- REGISTROS - SuperAdmin, Admin, Agente Admin, Agente Ventas (algunos módulos) --}}
            @if(auth()->user() && (auth()->user()->hasRole(['superadmin', 'admin', 'agente_administrativo', 'agente_ventas']) || 
                in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_administrativo', 'agente_ventas'])))
                <div class="nav-section">
                    <div class="nav-section-title">Registros</div>
                    
                    {{-- Clientes - SuperAdmin, Admin, Agente Admin, Agente Ventas --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_administrativo', 'agente_ventas']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_administrativo', 'agente_ventas']))
                        <div class="nav-item">
                            <a href="{{ route('clientes.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">👥</span>
                                <span class="nav-text">Clientes</span>
                            </a>
                        </div>
                    @endif
                    
                    {{-- Docentes - SuperAdmin, Admin, Agente Académico --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_academico']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_academico']))
                        <div class="nav-item">
                            <a href="{{ route('docentes.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">👨‍🏫</span>
                                <span class="nav-text">Docentes</span>
                            </a>
                        </div>
                    @endif
                    
                    {{-- Cursos - SuperAdmin, Admin, Agente Académico --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_academico']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_academico']))
                        <div class="nav-item">
                            <a href="{{ route('cursos.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">📚</span>
                                <span class="nav-text">Cursos</span>
                            </a>
                        </div>
                    @endif
                    
                    {{-- Personal - SuperAdmin, Admin, Agente Admin --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_administrativo']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_administrativo']))
                        <div class="nav-item">
                            <a href="{{ route('personals.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">👤</span>
                                <span class="nav-text">Personal</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            {{-- VENTAS - SuperAdmin, Admin, Agente Ventas --}}
            @if(auth()->user() && (auth()->user()->hasRole(['superadmin', 'admin', 'agente_ventas']) || 
                in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_ventas'])))
                <div class="nav-section">
                    <div class="nav-section-title">Ventas</div>
                    
                    <div class="nav-item">
                        <a href="{{ route('rventas.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">💼</span>
                            <span class="nav-text">Gestión de Ventas</span>
                        </a>
                    </div>
                    
                    {{-- Descuentos - SuperAdmin, Agente Ventas --}}
                    @if(auth()->user()->hasRole(['superadmin', 'agente_ventas']) || 
                        in_array(auth()->user()->role, ['superadmin', 'agente_ventas']))
                        <div class="nav-item">
                            <a href="{{ route('descuentos.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">🏷️</span>
                                <span class="nav-text">Descuentos</span>
                                <span class="nav-badge">Nuevo</span>
                            </a>
                        </div>
                    @endif

                    
                    
                    
                </div>
            @endif

            {{-- Entrega de Material - SuperAdmin, Admin, Agente Ventas, Agente Administrativo --}}
@canDo('entrega_material', 'view')
    <div class="nav-item">
        <a href="{{ route('entrega_materials.index') }}" class="nav-link" onclick="hideSidebar()">
            <span class="nav-icon">📦</span>
            <span class="nav-text">Entrega Material</span>
            
            {{-- Badge opcional para mostrar el rol que tiene acceso --}}
            @hasAnyRole('agente_administrativo', 'agente_ventas')
                <span class="badge badge-sm" style="background-color: {{ auth()->user()->getRoleColor() }}; font-size: 0.7em;">
                    {{ auth()->user()->getPrimaryRole()->display_name ?? auth()->user()->role }}
                </span>
            @endhasAnyRole
        </a>
    </div>
@endcanDo


            

            {{-- VENTA CLIENTE - Todos los usuarios autenticados --}}
            <div class="nav-section">
                <div class="nav-section-title">Cliente</div>
                <div class="nav-item">
                    <a href="{{ route('cliente.panel.superadmin') }}" class="nav-link" onclick="hideSidebar()">
                        <span class="nav-icon">🛒</span>
                        <span class="nav-text">Panel de Compras</span>
                    </a>
                </div>
            </div>

            {{-- MÓDULOS ACADÉMICOS - SuperAdmin, Admin, Agente Académico --}}
            @if(auth()->user() && (auth()->user()->hasRole(['superadmin', 'admin', 'agente_academico']) || 
                in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_academico'])))
                <div class="nav-section">
                    <div class="nav-section-title">Académico</div>
                    
                    <div class="nav-item">
                        <a href="{{ route('certificados.dashboard') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">🎓</span>
                            <span class="nav-text">Certificados</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('competencias.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">🏆</span>
                            <span class="nav-text">Competencias</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('certificadosdocentes.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">📑</span>
                            <span class="nav-text">Cert. Docentes</span>
                        </a>
                    </div>
                </div>
            
                <div class="nav-section">
                    <div class="nav-section-title">Registros</div>            
                {{-- Docentes - SuperAdmin, Admin, Agente Académico --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_academico']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_academico']))
                        <div class="nav-item">
                            <a href="{{ route('docentes.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">👨‍🏫</span>
                                <span class="nav-text">Docentes</span>
                            </a>
                        </div>
                    @endif
                    
                    {{-- Cursos - SuperAdmin, Admin, Agente Académico --}}
                    @if(auth()->user()->hasRole(['superadmin', 'admin', 'agente_academico']) || 
                        in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_academico']))
                        <div class="nav-item">
                            <a href="{{ route('cursos.index') }}" class="nav-link" onclick="hideSidebar()">
                                <span class="nav-icon">📚</span>
                                <span class="nav-text">Cursos</span>
                            </a>
                        </div>
                    @endif

                    </div>
                
            @endif

            {{-- ADMINISTRATIVO - SuperAdmin, Admin, Agente Admin --}}
            @if(auth()->user() && (auth()->user()->hasRole(['superadmin', 'admin', 'agente_administrativo']) || 
                in_array(auth()->user()->role, ['superadmin', 'admin', 'agente_administrativo'])))
                <div class="nav-section">
                    <div class="nav-section-title">Administrativo</div>
                    
                    <div class="nav-item">
                        <a href="{{ route('inventario.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">📦</span>
                            <span class="nav-text">Inventario</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('finanzas.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">💰</span>
                            <span class="nav-text">Finanzas</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('ventas_centralizadas.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">🌐</span>
                            <span class="nav-text">Ventas Centralizadas</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('controlGeneral.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">🔧</span>
                            <span class="nav-text">Control General</span>
                        </a>
                    </div>

                    
                    
                    {{-- Arqueo - SuperAdmin, Admin, Agente Admin --}}
                    
                </div>
            @endif

            {{-- ADMINISTRACIÓN - Solo SuperAdmin --}}
            @if(auth()->user() && (auth()->user()->hasRole('superadmin') || auth()->user()->role === 'superadmin'))
                <div class="nav-section">
                    <div class="nav-section-title">Administración</div>
                    
                    <div class="nav-item">
                        <a href="{{ route('usuarios.index') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">👥</span>
                            <span class="nav-text">Usuarios</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('admin.roles') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">🔐</span>
                            <span class="nav-text">Roles y Permisos</span>
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('dashboard.estadisticas') }}" class="nav-link" onclick="hideSidebar()">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Estadísticas</span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- CONFIGURACIÓN - Todos --}}
            <div class="nav-section">
                <div class="nav-section-title">Sistema</div>
                
                <div class="nav-item">
                    <a href="{{ route('smart-redirect') }}" class="nav-link" onclick="hideSidebar()">
                        <span class="nav-icon">🎯</span>
                        <span class="nav-text">Ir a Mi Área</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); hideSidebar();">
                        <span class="nav-icon">🚪</span>
                        <span class="nav-text">Cerrar Sesión</span>
                    </a>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @else
            {{-- Para usuarios no autenticados --}}
            <div class="nav-section">
                <div class="nav-section-title">Acceso</div>
                <div class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link" onclick="hideSidebar()">
                        <span class="nav-icon">🔑</span>
                        <span class="nav-text">Iniciar Sesión</span>
                    </a>
                </div>
            </div>
            @endauth
        </div> action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <script>
        let sidebarVisible = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const toggleButton = document.querySelector('.menu-toggle');
            
            sidebarVisible = !sidebarVisible;
            
            if (sidebarVisible) {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                toggleButton.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                toggleButton.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        function hideSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const toggleButton = document.querySelector('.menu-toggle');
            
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            toggleButton.classList.remove('active');
            document.body.style.overflow = 'auto';
            sidebarVisible = false;
        }

        // Cerrar sidebar con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebarVisible) {
                hideSidebar();
            }
        });

        // Manejar cambios de tamaño de pantalla
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && sidebarVisible) {
                hideSidebar();
            }
        });

        // Marcar enlace activo basado en la URL actual
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

        // Agregar efecto de clic a los enlaces
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Solo si no es el enlace de logout
                if (!this.getAttribute('href').includes('logout')) {
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>