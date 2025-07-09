<?php

// app/Console/Commands/ManageRoles.php (MÉTODO CORREGIDO)

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class ManageRoles extends Command
{
    protected $signature = 'roles:manage 
                           {action : assign|remove|list|create-user|migrate}
                           {--user= : Email del usuario}
                           {--role= : Nombre del rol}
                           {--name= : Nombre para nuevo usuario}
                           {--email= : Email para nuevo usuario}
                           {--password= : Password para nuevo usuario}';

    protected $description = 'Gestionar roles y usuarios desde la línea de comandos';

    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'assign':
                return $this->assignRole();
            case 'remove':
                return $this->removeRole();
            case 'list':
                return $this->listRolesAndUsers();
            case 'create-user':
                return $this->createUserWithRole();
            case 'migrate':
                return $this->migrateOldSystem();
            default:
                $this->error("Acción no válida. Usa: assign, remove, list, create-user, migrate");
                return 1;
        }
    }

    private function assignRole()
    {
        $userEmail = $this->option('user');
        $roleName = $this->option('role');

        if (!$userEmail || !$roleName) {
            $this->error('Debes especificar --user y --role');
            return 1;
        }

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            $this->error("Usuario con email {$userEmail} no encontrado");
            return 1;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Rol {$roleName} no encontrado");
            return 1;
        }

        // Verificar si ya tiene el rol usando una consulta más específica
        $hasRole = $user->roles()->where('roles.name', $roleName)->exists();
        
        if ($hasRole) {
            $this->warn("El usuario ya tiene el rol {$role->display_name}");
            return 0;
        }

        $user->assignRole($role);
        $this->info("✅ Rol '{$role->display_name}' asignado a {$user->name}");
        
        return 0;
    }

    private function removeRole()
    {
        $userEmail = $this->option('user');
        $roleName = $this->option('role');

        if (!$userEmail || !$roleName) {
            $this->error('Debes especificar --user y --role');
            return 1;
        }

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            $this->error("Usuario con email {$userEmail} no encontrado");
            return 1;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Rol {$roleName} no encontrado");
            return 1;
        }

        $user->removeRole($role);
        $this->info("✅ Rol '{$role->display_name}' removido de {$user->name}");
        
        return 0;
    }

    private function listRolesAndUsers()
    {
        $this->info('📋 ROLES DEL SISTEMA:');
        $this->newLine();

        $roles = Role::withCount('users')->get();
        
        foreach ($roles as $role) {
            $this->line("🏷️  <fg=blue>{$role->display_name}</> ({$role->name})");
            $this->line("   └─ {$role->users_count} usuarios");
            $this->line("   └─ {$role->description}");
            $this->newLine();
        }

        $this->info('👥 USUARIOS CON ROLES:');
        $this->newLine();

        $users = User::with('roles')->whereHas('roles')->get();
        
        foreach ($users as $user) {
            $this->line("👤 <fg=green>{$user->name}</> ({$user->email})");
            foreach ($user->roles as $role) {
                $this->line("   └─ {$role->display_name}");
            }
            $this->newLine();
        }

        return 0;
    }

    private function createUserWithRole()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');
        $roleName = $this->option('role');

        if (!$name || !$email || !$password || !$roleName) {
            $this->error('Debes especificar --name, --email, --password y --role');
            return 1;
        }

        if (User::where('email', $email)->exists()) {
            $this->error("Ya existe un usuario con el email {$email}");
            return 1;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Rol {$roleName} no encontrado");
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
            'role' => $roleName // Para compatibilidad
        ]);

        $user->assignRole($role);

        $this->info("✅ Usuario creado exitosamente:");
        $this->line("   👤 Nombre: {$user->name}");
        $this->line("   📧 Email: {$user->email}");
        $this->line("   🏷️ Rol: {$role->display_name}");

        return 0;
    }

    private function migrateOldSystem()
    {
        $this->info('🔄 Migrando usuarios del sistema anterior...');
        
        $migrated = 0;
        $users = User::whereNotNull('role')->get();

        foreach ($users as $user) {
            try {
                $oldRole = $user->role;
                $newRole = Role::where('name', $oldRole)->first();
                
                if ($newRole) {
                    // Verificar si ya tiene el rol usando consulta específica
                    $hasRole = $user->roles()->where('roles.name', $oldRole)->exists();
                    
                    if (!$hasRole) {
                        $user->assignRole($newRole);
                        $migrated++;
                        $this->line("✅ {$user->name} migrado a {$newRole->display_name}");
                    } else {
                        $this->line("⚠️  {$user->name} ya tiene el rol {$newRole->display_name}");
                    }
                } else {
                    $this->warn("⚠️  Rol '{$oldRole}' no encontrado para {$user->name}");
                }
            } catch (\Exception $e) {
                $this->error("❌ Error migrando {$user->name}: " . $e->getMessage());
            }
        }

        $this->info("🎉 Migración completada: {$migrated} usuarios migrados");
        
        return 0;
    }
}