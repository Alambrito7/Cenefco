<?php

// app/Http/Controllers/RolePermissionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden acceder
        $this->middleware('auth');
        
        // Solo SuperAdmin puede gestionar roles y permisos (excepto algunas vistas básicas)
        $this->middleware('superadmin_only')->except(['apiCheckUserPermissions']);
    }

    // =========================================================================
    // GESTIÓN DE ROLES
    // =========================================================================
    
    /**
     * Lista todos los roles del sistema
     */
    public function roles()
    {
        $roles = Role::withCount(['users', 'permissions'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Crear un nuevo rol
     */
    public function createRole()
    {
        return view('admin.roles.create');
    }

    /**
     * Guardar un nuevo rol
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:50',
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:7'
        ]);

        Role::create($request->all());

        return redirect()->route('admin.roles')
                        ->with('success', '✅ Rol creado correctamente.');
    }

    /**
     * Editar un rol
     */
    public function editRole(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Actualizar un rol
     */
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
            'active' => 'boolean'
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roles')
                        ->with('success', '✅ Rol actualizado correctamente.');
    }

    // =========================================================================
    // GESTIÓN DE PERMISOS POR ROL
    // =========================================================================
    
    /**
     * Gestionar permisos de un rol específico
     */
    public function rolePermissions(Role $role)
    {
        $permissions = Permission::where('active', true)
                                ->orderBy('module')
                                ->orderBy('action')
                                ->get()
                                ->groupBy('module');
        
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Actualizar permisos de un rol
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->back()
                        ->with('success', '✅ Permisos actualizados correctamente.');
    }

    // =========================================================================
    // GESTIÓN DE ROLES DE USUARIOS
    // =========================================================================
    
    /**
     * Lista de usuarios con sus roles
     */
    public function userRoles()
    {
        $users = User::with('roles')->paginate(15);
        $roles = Role::where('active', true)->get();
        
        return view('admin.users.roles', compact('users', 'roles'));
    }

    /**
     * Gestionar roles de un usuario específico
     */
    public function manageUserRoles(User $user)
    {
        $availableRoles = Role::where('active', true)->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('admin.users.manage-roles', compact('user', 'availableRoles', 'userRoles'));
    }

    /**
     * Asignar rol a un usuario
     */
    public function assignRoleToUser(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findOrFail($request->role_id);

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            
            // Actualizar también el campo rol antiguo para compatibilidad
            if ($role->name === 'superadmin') {
                $user->update(['role' => 'superadmin']);
            }
        }

        return redirect()->back()
                        ->with('success', "✅ Rol '{$role->display_name}' asignado correctamente.");
    }

    /**
     * Remover rol de un usuario
     */
    public function removeRoleFromUser(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findOrFail($request->role_id);
        $user->removeRole($role);

        return redirect()->back()
                        ->with('success', "✅ Rol '{$role->display_name}' removido correctamente.");
    }

    /**
     * Actualizar todos los roles de un usuario
     */
    public function updateUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->roles()->sync($request->roles ?? []);

        // Actualizar campo role antiguo para compatibilidad
        $primaryRole = $user->roles()->first();
        if ($primaryRole) {
            $user->update(['role' => $primaryRole->name]);
        } else {
            $user->update(['role' => null]);
        }

        return redirect()->route('admin.users.roles')
                        ->with('success', '✅ Roles del usuario actualizados correctamente.');
    }

    // =========================================================================
    // VISTAS DE INFORMACIÓN
    // =========================================================================
    
    /**
     * Dashboard de gestión de roles y permisos
     */
    public function dashboard()
    {
        $stats = [
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_users' => User::count(),
            'users_with_roles' => User::has('roles')->count(),
            'active_roles' => Role::where('active', true)->count(),
        ];

        $recentUsers = User::with('roles')
                          ->latest()
                          ->limit(5)
                          ->get();

        $roleDistribution = Role::withCount('users')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'roleDistribution'));
    }

    /**
     * Lista de todos los permisos del sistema
     */
    public function permissions()
    {
        $permissions = Permission::orderBy('module')
                                ->orderBy('action')
                                ->get()
                                ->groupBy('module');
        
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Crear un nuevo permiso (avanzado)
     */
    public function createPermission()
    {
        $modules = Permission::distinct('module')->pluck('module');
        $actions = Permission::distinct('action')->pluck('action');
        
        return view('admin.permissions.create', compact('modules', 'actions'));
    }

    /**
     * Guardar un nuevo permiso
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:100',
            'display_name' => 'required|string|max:150',
            'module' => 'required|string|max:50',
            'action' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        Permission::create($request->all());

        return redirect()->route('admin.permissions')
                        ->with('success', '✅ Permiso creado correctamente.');
    }

    // =========================================================================
    // API ENDPOINTS PARA AJAX
    // =========================================================================
    
    /**
     * API: Verificar permisos de un usuario
     */
    public function apiCheckUserPermissions(User $user)
    {
        return response()->json([
            'user' => $user->only(['id', 'name', 'email']),
            'roles' => $user->roles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'color' => $role->color
                ];
            }),
            'permissions' => $user->getAllPermissions()->map(function($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'module' => $permission->module,
                    'action' => $permission->action
                ];
            })->groupBy('module'),
            'is_superadmin' => $user->isSuperAdmin()
        ]);
    }

    /**
     * API: Obtener estadísticas del sistema
     */
    public function apiStats()
    {
        return response()->json([
            'roles' => Role::withCount('users')->get(),
            'permissions_by_module' => Permission::selectRaw('module, COUNT(*) as count')
                                               ->groupBy('module')
                                               ->get(),
            'users_by_role' => User::with('roles')
                                  ->get()
                                  ->groupBy(function($user) {
                                      $primaryRole = $user->roles->first();
                                      return $primaryRole ? $primaryRole->display_name : 'Sin Rol';
                                  })
                                  ->map(function($users) {
                                      return $users->count();
                                  })
        ]);
    }

    // =========================================================================
    // HERRAMIENTAS DE MIGRACIÓN
    // =========================================================================
    
    /**
     * Migrar usuarios del sistema anterior al nuevo
     */
    public function migrateOldRoles()
    {
        $migrated = 0;
        $users = User::whereNotNull('role')->get();

        foreach ($users as $user) {
            try {
                $oldRole = $user->role;
                $newRole = Role::where('name', $oldRole)->first();
                
                if ($newRole) {
                    // Verificar si ya tiene el rol
                    $hasRole = $user->roles()->where('roles.name', $oldRole)->exists();
                    
                    if (!$hasRole) {
                        $user->assignRole($newRole);
                        $migrated++;
                    }
                }
            } catch (\Exception $e) {
                // Continuar con el siguiente usuario si hay error
                continue;
            }
        }

        return redirect()->back()
                        ->with('success', "✅ Se migraron {$migrated} usuarios al nuevo sistema de roles.");
    }
}