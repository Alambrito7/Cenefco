<?php

// database/seeders/RolesAndPermissionsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $this->createRoles();
        
        // Crear permisos
        $this->createPermissions();
        
        // Asignar permisos a roles
        $this->assignPermissionsToRoles();
        
        // Crear usuario superadmin por defecto (opcional)
        $this->createDefaultSuperAdmin();
    }

    private function createRoles()
    {
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Super Administrador',
                'description' => 'Acceso completo a todo el sistema',
                'color' => '#dc3545' // Rojo
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Gestión general del sistema',
                'color' => '#fd7e14' // Naranja
            ],
            [
                'name' => 'agente_administrativo',
                'display_name' => 'Agente Administrativo',
                'description' => 'Gestión de registros, personal y administración',
                'color' => '#6f42c1' // Púrpura
            ],
            [
                'name' => 'agente_ventas',
                'display_name' => 'Agente de Ventas',
                'description' => 'Gestión de ventas, clientes y transacciones',
                'color' => '#198754' // Verde
            ],
            [
                'name' => 'agente_academico',
                'display_name' => 'Agente Académico',
                'description' => 'Gestión de certificados, competencias y academia',
                'color' => '#0dcaf0' // Cyan
            ],
            [
                'name' => 'usuario',
                'display_name' => 'Usuario',
                'description' => 'Acceso básico de solo lectura',
                'color' => '#6c757d' // Gris
            ]
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }

        $this->command->info('✅ Roles creados correctamente');
    }

    private function createPermissions()
    {
        // Definir módulos y sus acciones permitidas
        $modules = [
            // REGISTROS - Dividido por submodulos
            'registros_clientes' => [
                'display_name' => 'Registros - Clientes',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            'registros_docentes' => [
                'display_name' => 'Registros - Docentes',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            'registros_cursos' => [
                'display_name' => 'Registros - Cursos',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            'registros_personal' => [
                'display_name' => 'Registros - Personal',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            // VENTAS
            'ventas' => [
                'display_name' => 'Sector Ventas',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore', 'complete_payment']
            ],
            'venta_cliente' => [
                'display_name' => 'Venta Cliente',
                'actions' => ['view', 'create', 'edit', 'delete', 'export']
            ],

            'descuentos' => [
            'display_name' => 'Gestión de Descuentos',
            'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            // INVENTARIO
            'inventario' => [
                'display_name' => 'Inventario',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            // CERTIFICADOS
            'certificados' => [
                'display_name' => 'Certificados',
                'actions' => ['view', 'create', 'edit', 'delete', 'generate', 'download']
            ],
            'competencias' => [
                'display_name' => 'Competencias',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            'certificados_docentes' => [
                'display_name' => 'Certificados Docentes',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore']
            ],
            // FINANZAS
            'finanzas' => [
                'display_name' => 'Módulo Financiero',
                'actions' => ['view', 'create', 'edit', 'delete', 'export', 'restore', 'reports']
            ],
            // CONTROL Y ADMINISTRACIÓN
            'control_general' => [
                'display_name' => 'Control General',
                'actions' => ['view', 'manage', 'export', 'reports']
            ],
            'entrega_material' => [
                'display_name' => 'Entregas de Material',
                'actions' => ['view', 'create', 'edit', 'delete', 'export']
            ],
            'ventas_centralizadas' => [
                'display_name' => 'Ventas Centralizadas',
                'actions' => ['view', 'export', 'reports']
            ],
            // DASHBOARD
            'dashboard' => [
                'display_name' => 'Panel de Control',
                'actions' => ['view', 'statistics']
            ],
            // USUARIOS
            'usuarios' => [
                'display_name' => 'Gestión de Usuarios',
                'actions' => ['view', 'create', 'edit', 'delete', 'manage_roles', 'manage_permissions']
            ]
        ];

        // Definir nombres amigables para acciones
        $actionDisplayNames = [
            'view' => 'Ver',
            'create' => 'Crear',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'export' => 'Exportar',
            'restore' => 'Restaurar',
            'manage' => 'Administrar',
            'reports' => 'Reportes',
            'statistics' => 'Estadísticas',
            'generate' => 'Generar',
            'download' => 'Descargar',
            'complete_payment' => 'Completar Pago',
            'manage_roles' => 'Gestionar Roles',
            'manage_permissions' => 'Gestionar Permisos'
        ];

        foreach ($modules as $moduleKey => $moduleData) {
            foreach ($moduleData['actions'] as $action) {
                $permissionName = "{$moduleKey}.{$action}";
                $actionDisplay = $actionDisplayNames[$action] ?? ucfirst($action);
                
                Permission::firstOrCreate([
                    'name' => $permissionName,
                ], [
                    'display_name' => "{$actionDisplay} {$moduleData['display_name']}",
                    'module' => $moduleKey,
                    'action' => $action,
                    'description' => "Permite {$actionDisplay} en {$moduleData['display_name']}"
                ]);
            }
        }

        $this->command->info('✅ Permisos creados correctamente');
    }


private function assignPermissionsToRoles()
{
    // 🔴 SUPERADMIN: Todos los permisos
    $superadmin = Role::where('name', 'superadmin')->first();
    $allPermissions = Permission::all();
    $superadmin->permissions()->sync($allPermissions->pluck('id'));
    $this->command->info('✅ Permisos asignados a SuperAdmin (' . $allPermissions->count() . ' permisos)');

    // 🟠 ADMIN: Casi todos los permisos (sin gestión avanzada de usuarios)
    $admin = Role::where('name', 'admin')->first();
    $adminPermissions = Permission::where(function($query) {
        $query->where('module', '!=', 'usuarios')
              ->orWhere(function($subQuery) {
                  $subQuery->where('module', 'usuarios')
                           ->whereNotIn('action', ['manage_roles', 'manage_permissions']);
              });
    })->get();
    $admin->permissions()->sync($adminPermissions->pluck('id'));
    $this->command->info('✅ Permisos asignados a Admin (' . $adminPermissions->count() . ' permisos)');

    // 🟣 AGENTE ADMINISTRATIVO: *** ACTUALIZADO CON ENTREGA MATERIAL ***
$agenteAdmin = Role::where('name', 'agente_administrativo')->first();
$agenteAdminPermissions = collect();

// Registros (excepto usuarios) - Solo clientes, docentes, cursos, personal
$registrosPermisos = Permission::whereIn('module', [
    'registros_clientes', 'registros_docentes', 'registros_cursos', 'registros_personal'
])->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($registrosPermisos);

// Inventario (completo)
$inventarioPermisos = Permission::where('module', 'inventario')->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($inventarioPermisos);

// *** ENTREGA MATERIAL - NUEVO PARA AGENTE ADMINISTRATIVO ***
$entregaMaterialPermisos = Permission::where('module', 'entrega_material')->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($entregaMaterialPermisos);

// Control General (ver/gestionar)
$controlPermisos = Permission::where('module', 'control_general')
                           ->whereIn('action', ['view', 'manage', 'export', 'reports'])
                           ->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($controlPermisos);

// Dashboard (estadísticas)
$dashboardPermisos = Permission::where('module', 'dashboard')->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($dashboardPermisos);

// Finanzas (ver/crear/editar/exportar)
$finanzasPermisos = Permission::where('module', 'finanzas')
                            ->whereIn('action', ['view', 'create', 'edit', 'export', 'reports'])
                            ->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($finanzasPermisos);

// Ventas Centralizadas (ver/reportes)
$ventasCentralizadasPermisos = Permission::where('module', 'ventas_centralizadas')
                                       ->whereIn('action', ['view', 'export', 'reports'])
                                       ->get();
$agenteAdminPermissions = $agenteAdminPermissions->merge($ventasCentralizadasPermisos);

$agenteAdmin->permissions()->sync($agenteAdminPermissions->pluck('id')->unique());
$this->command->info('✅ Permisos asignados a Agente Administrativo (' . $agenteAdminPermissions->unique('id')->count() . ' permisos)');


    // 🟢 AGENTE DE VENTAS: *** ACTUALIZADO CON DESCUENTOS ***
$agenteVentas = Role::where('name', 'agente_ventas')->first();
$agenteVentasPermissions = collect();

// Registros - Solo clientes (completo)
$clientesPermisos = Permission::where('module', 'registros_clientes')->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($clientesPermisos);

// Ventas (completo)
$ventasPermisos = Permission::where('module', 'ventas')->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($ventasPermisos);

// Venta Cliente (completo)
$ventaClientePermisos = Permission::where('module', 'venta_cliente')->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($ventaClientePermisos);

// Entrega Material (completo)
$entregaMaterialPermisos = Permission::where('module', 'entrega_material')->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($entregaMaterialPermisos);

// *** DESCUENTOS - NUEVO PARA AGENTE DE VENTAS ***
$descuentosPermisos = Permission::where('module', 'descuentos')->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($descuentosPermisos);

// Dashboard, Finanzas (view/reports), Ventas Centralizadas
$otrosPermisos = Permission::whereIn('module', ['dashboard'])
                          ->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($otrosPermisos);

// Finanzas limitadas
$finanzasPermisos = Permission::where('module', 'finanzas')
                            ->whereIn('action', ['view', 'reports'])
                            ->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($finanzasPermisos);

// Ventas Centralizadas
$ventasCentralizadasPermisos = Permission::where('module', 'ventas_centralizadas')
                                       ->whereIn('action', ['view', 'export', 'reports'])
                                       ->get();
$agenteVentasPermissions = $agenteVentasPermissions->merge($ventasCentralizadasPermisos);

$agenteVentas->permissions()->sync($agenteVentasPermissions->pluck('id')->unique());
$this->command->info('✅ Permisos asignados a Agente de Ventas (' . $agenteVentasPermissions->unique('id')->count() . ' permisos)');


    // 🔵 AGENTE ACADÉMICO: (Sin cambios)
    $agenteAcademico = Role::where('name', 'agente_academico')->first();
    $agenteAcademicoPermissions = collect();

    // Registros - Solo docentes y cursos
    $docentesCursosPermisos = Permission::whereIn('module', [
        'registros_docentes', 'registros_cursos'
    ])->get();
    $agenteAcademicoPermissions = $agenteAcademicoPermissions->merge($docentesCursosPermisos);

    // Certificados, Competencias, Certificados Docentes, Dashboard
    $academicoModulosPermisos = Permission::whereIn('module', [
        'certificados', 'competencias', 'certificados_docentes', 'dashboard'
    ])->get();
    $agenteAcademicoPermissions = $agenteAcademicoPermissions->merge($academicoModulosPermisos);

    $agenteAcademico->permissions()->sync($agenteAcademicoPermissions->pluck('id')->unique());
    $this->command->info('✅ Permisos asignados a Agente Académico (' . $agenteAcademicoPermissions->unique('id')->count() . ' permisos)');

    // ⚫ USUARIO: Solo Venta Cliente (sin cambios)
    $usuario = Role::where('name', 'usuario')->first();
    $usuarioPermissions = Permission::where('module', 'venta_cliente')->get();
    $usuario->permissions()->sync($usuarioPermissions->pluck('id'));
    $this->command->info('✅ Permisos asignados a Usuario (' . $usuarioPermissions->count() . ' permisos)');
}

    private function createDefaultSuperAdmin()
    {
        // Verificar si ya existe un superadmin
        $existsSuperAdmin = User::whereHas('roles', function($query) {
            $query->where('name', 'superadmin');
        })->exists();

        if (!$existsSuperAdmin) {
            // Buscar el primer usuario o crear uno nuevo
            $user = User::first();
            
            if (!$user) {
                $user = User::create([
                    'name' => 'Super Administrador',
                    'email' => 'admin@sistema.com',
                    'password' => bcrypt('password123'),
                    'role' => 'superadmin', // Compatibilidad
                    'email_verified_at' => now(),
                ]);
                $this->command->info('✅ Usuario SuperAdmin creado: admin@sistema.com / password123');
            }

            // Asignar rol de superadmin
            $superadminRole = Role::where('name', 'superadmin')->first();
            if ($superadminRole) {
                $user->roles()->syncWithoutDetaching([$superadminRole->id => [
                    'assigned_at' => now(),
                    'assigned_by' => $user->id
                ]]);
                $this->command->info('✅ Rol SuperAdmin asignado al usuario');
            }
        }
    }
}