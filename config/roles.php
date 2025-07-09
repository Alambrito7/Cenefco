<?php

// config/roles.php
return [

    /*
    |--------------------------------------------------------------------------
    | Sistema de Roles y Permisos
    |--------------------------------------------------------------------------
    |
    | Configuración para el sistema de roles y permisos personalizado
    |
    */

    // Configuración de roles
    'roles' => [
        'cache_enabled' => true,
        'cache_expiration' => 60, // minutos
        'default_role' => 'usuario',
        'superadmin_role' => 'superadmin',
    ],

    // Configuración de permisos
    'permissions' => [
        'cache_enabled' => true,
        'cache_expiration' => 60, // minutos
        'separator' => '.', // separador para permisos (module.action)
    ],

    // Módulos del sistema y sus acciones permitidas
    'modules' => [
        'registros_clientes' => [
            'display_name' => 'Registros - Clientes',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-users',
            'color' => '#007bff'
        ],
        'registros_docentes' => [
            'display_name' => 'Registros - Docentes', 
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-chalkboard-teacher',
            'color' => '#28a745'
        ],
        'registros_cursos' => [
            'display_name' => 'Registros - Cursos',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-book',
            'color' => '#ffc107'
        ],
        'registros_personal' => [
            'display_name' => 'Registros - Personal',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-id-badge',
            'color' => '#6f42c1'
        ],
        'ventas' => [
            'display_name' => 'Sector Ventas',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore', 'complete_payment'],
            'icon' => 'fas fa-shopping-cart',
            'color' => '#dc3545'
        ],
        'venta_cliente' => [
            'display_name' => 'Venta Cliente',
            'actions' => ['view', 'create', 'edit', 'delete', 'export'],
            'icon' => 'fas fa-store',
            'color' => '#17a2b8'
        ],
        'inventario' => [
            'display_name' => 'Inventario',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-boxes',
            'color' => '#fd7e14'
        ],
        'certificados' => [
            'display_name' => 'Certificados',
            'actions' => ['view', 'create', 'edit', 'delete', 'generate', 'download'],
            'icon' => 'fas fa-certificate',
            'color' => '#20c997'
        ],
        'competencias' => [
            'display_name' => 'Competencias',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-trophy',
            'color' => '#e83e8c'
        ],
        'certificados_docentes' => [
            'display_name' => 'Certificados Docentes',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore'],
            'icon' => 'fas fa-user-graduate',
            'color' => '#6610f2'
        ],
        'finanzas' => [
            'display_name' => 'Módulo Financiero',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore', 'reports'],
            'icon' => 'fas fa-dollar-sign',
            'color' => '#198754'
        ],
        'control_general' => [
            'display_name' => 'Control General',
            'actions' => ['view', 'manage', 'export', 'reports'],
            'icon' => 'fas fa-cog',
            'color' => '#495057'
        ],
        'entrega_material' => [
            'display_name' => 'Entregas de Material',
            'actions' => ['view', 'create', 'edit', 'delete', 'export'],
            'icon' => 'fas fa-truck',
            'color' => '#0d6efd'
        ],
        'ventas_centralizadas' => [
            'display_name' => 'Ventas Centralizadas',
            'actions' => ['view', 'export', 'reports'],
            'icon' => 'fas fa-chart-line',
            'color' => '#0dcaf0'
        ],
        'dashboard' => [
            'display_name' => 'Panel de Control',
            'actions' => ['view', 'statistics'],
            'icon' => 'fas fa-tachometer-alt',
            'color' => '#6c757d'
        ],
        'usuarios' => [
            'display_name' => 'Gestión de Usuarios',
            'actions' => ['view', 'create', 'edit', 'delete', 'manage_roles', 'manage_permissions'],
            'icon' => 'fas fa-users-cog',
            'color' => '#dc3545'
        ]
    ],

    // Definición de roles y sus permisos por defecto
    'default_role_permissions' => [
        'superadmin' => ['*'], // Todos los permisos
        'admin' => [
            // Casi todos excepto gestión avanzada de usuarios
            'exclude' => ['usuarios.manage_roles', 'usuarios.manage_permissions']
        ],
        'agente_administrativo' => [
            'modules' => [
                'registros_clientes' => ['view', 'create', 'edit', 'export', 'restore'],
                'registros_docentes' => ['view', 'create', 'edit', 'export', 'restore'],
                'registros_cursos' => ['view', 'create', 'edit', 'export', 'restore'],
                'registros_personal' => ['view', 'create', 'edit', 'export', 'restore'],
                'inventario' => ['view', 'create', 'edit', 'export', 'restore'],
                'control_general' => ['view', 'manage', 'export', 'reports'],
                'dashboard' => ['view', 'statistics'],
                'finanzas' => ['view', 'create', 'edit', 'export', 'reports'],
                'ventas_centralizadas' => ['view', 'export', 'reports']
            ]
        ],
        'agente_ventas' => [
            'modules' => [
                'registros_clientes' => ['view', 'create', 'edit', 'export', 'restore'],
                'ventas' => ['view', 'create', 'edit', 'export', 'restore', 'complete_payment'],
                'venta_cliente' => ['view', 'create', 'edit', 'export'],
                'entrega_material' => ['view', 'create', 'edit', 'export']
            ]
        ],
        'agente_academico' => [
            'modules' => [
                'registros_docentes' => ['view', 'create', 'edit', 'export', 'restore'],
                'registros_cursos' => ['view', 'create', 'edit', 'export', 'restore'],
                'certificados' => ['view', 'create', 'edit', 'generate', 'download'],
                'competencias' => ['view', 'create', 'edit', 'export', 'restore'],
                'certificados_docentes' => ['view', 'create', 'edit', 'export', 'restore'],
                'dashboard' => ['view', 'statistics']
            ]
        ],
        'usuario' => [
            'modules' => [
                'venta_cliente' => ['view', 'create', 'edit', 'export']
            ]
        ]
    ],

    // Configuración de UI
    'ui' => [
        'show_role_badges' => true,
        'show_permission_tooltips' => true,
        'use_icons' => true,
        'sidebar_collapse_by_role' => [
            'usuario' => true, // Los usuarios básicos ven el sidebar colapsado
        ]
    ],

    // Configuración de seguridad
    'security' => [
        'log_permission_denials' => true,
        'max_roles_per_user' => 3,
        'require_reason_for_role_change' => false,
    ],

    // Configuración de notificaciones
    'notifications' => [
        'notify_role_changes' => true,
        'notify_permission_changes' => false,
        'notification_channels' => ['mail', 'database']
    ],

    // Mensajes personalizables
    'messages' => [
        'access_denied' => '⛔ No tienes permisos suficientes para realizar esta acción.',
        'role_assigned' => '✅ Rol asignado correctamente.',
        'role_removed' => '✅ Rol removido correctamente.',
        'permissions_updated' => '✅ Permisos actualizados correctamente.',
    ]
];

// Comando para publicar la configuración:
// php artisan vendor:publish --tag=config