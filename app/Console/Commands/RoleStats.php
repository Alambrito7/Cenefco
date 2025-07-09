<?php

// app/Console/Commands/RoleStats.php (CORREGIDO)
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RoleStats extends Command
{
    protected $signature = 'roles:stats {--detailed}';
    protected $description = 'Mostrar estadísticas del sistema de roles';

    public function handle()
    {
        $this->info('📊 ESTADÍSTICAS DEL SISTEMA DE ROLES');
        $this->newLine();

        // Estadísticas generales
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalUsers = User::count();
        $usersWithRoles = User::has('roles')->count();

        $this->table([
            'Métrica', 'Cantidad'
        ], [
            ['Total de Roles', $totalRoles],
            ['Total de Permisos', $totalPermissions],
            ['Total de Usuarios', $totalUsers],
            ['Usuarios con Roles', $usersWithRoles],
            ['Usuarios sin Roles', $totalUsers - $usersWithRoles]
        ]);

        $this->newLine();

        // Distribución por roles
        $this->info('👥 DISTRIBUCIÓN DE USUARIOS POR ROL:');
        $roleDistribution = Role::withCount('users')->get();
        
        $roleData = [];
        foreach ($roleDistribution as $role) {
            $roleData[] = [
                $role->display_name,
                $role->users_count,
                $role->active ? '✅' : '❌'
            ];
        }

        $this->table(['Rol', 'Usuarios', 'Activo'], $roleData);

        if ($this->option('detailed')) {
            $this->newLine();
            $this->info('🔑 PERMISOS POR MÓDULO:');
            
            $permissionsByModule = Permission::selectRaw('module, COUNT(*) as count')
                                           ->groupBy('module')
                                           ->get();
            
            $moduleData = [];
            foreach ($permissionsByModule as $module) {
                $moduleData[] = [
                    ucfirst(str_replace('_', ' ', $module->module)),
                    $module->count
                ];
            }

            $this->table(['Módulo', 'Permisos'], $moduleData);
        }

        return 0;
    }
}