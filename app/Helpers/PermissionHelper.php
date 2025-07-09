<?php

// app/Helpers/PermissionHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Verificar si el usuario actual tiene un permiso específico
     */
    public static function can($permission)
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        
        // Si es superadmin, permitir todo
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermission($permission);
    }

    /**
     * Verificar si el usuario puede realizar una acción en un módulo
     */
    public static function canDo($module, $action)
    {
        return self::can("{$module}.{$action}");
    }

    /**
     * Verificar si el usuario tiene al menos uno de los permisos dados
     */
    public static function canAny(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (self::can($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si el usuario tiene todos los permisos dados
     */
    public static function canAll(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!self::can($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public static function hasRole($role)
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->hasRole($role);
    }

    /**
     * Verificar si el usuario tiene alguno de los roles dados
     */
    public static function hasAnyRole(array $roles)
    {
        if (!Auth::check()) {
            return false;
        }

        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Obtener todos los permisos del usuario actual
     */
    public static function getUserPermissions()
    {
        if (!Auth::check()) {
            return collect();
        }

        $user = Auth::user();
        return $user->getAllPermissions();
    }

    /**
     * Obtener el color del rol principal del usuario
     */
    public static function getUserRoleColor()
    {
        if (!Auth::check()) {
            return '#6c757d';
        }

        return Auth::user()->getRoleColor();
    }

    /**
     * Obtener el nombre del rol principal del usuario
     */
    public static function getUserRoleName()
    {
        if (!Auth::check()) {
            return 'Sin rol';
        }

        $user = Auth::user();
        $primaryRole = $user->getPrimaryRole();
        return $primaryRole ? $primaryRole->display_name : ($user->role ?? 'Sin rol');
    }

    /**
     * Verificar acceso a módulos específicos según tu sistema
     */
    public static function canAccessRegistros($submodule = null)
    {
        if (!$submodule) {
            return self::canAny([
                'registros_clientes.view',
                'registros_docentes.view', 
                'registros_cursos.view',
                'registros_personal.view'
            ]);
        }

        return self::canDo("registros_{$submodule}", 'view');
    }

    public static function canAccessVentas()
    {
        return self::canDo('ventas', 'view');
    }

    public static function canAccessVentaCliente()
    {
        return self::canDo('venta_cliente', 'view');
    }

    public static function canAccessInventario()
    {
        return self::canDo('inventario', 'view');
    }

    public static function canAccessCertificados()
    {
        return self::canDo('certificados', 'view');
    }

    public static function canAccessCompetencias()
    {
        return self::canDo('competencias', 'view');
    }

    public static function canAccessFinanzas()
    {
        return self::canDo('finanzas', 'view');
    }

    /**
     * Generar menú dinámico basado en permisos
     */
    public static function getMenuItems()
    {
        $menu = [];

        // Dashboard
        if (self::canDo('dashboard', 'view')) {
            $menu[] = [
                'title' => 'Dashboard',
                'route' => 'superadmin.dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'badge' => null
            ];
        }

        // Módulo Registros
        $registrosSubmenu = [];
        if (self::canDo('registros_clientes', 'view')) {
            $registrosSubmenu[] = [
                'title' => 'Clientes',
                'route' => 'clientes.index',
                'icon' => 'fas fa-users'
            ];
        }
        if (self::canDo('registros_docentes', 'view')) {
            $registrosSubmenu[] = [
                'title' => 'Docentes',
                'route' => 'docentes.index',
                'icon' => 'fas fa-chalkboard-teacher'
            ];
        }
        if (self::canDo('registros_cursos', 'view')) {
            $registrosSubmenu[] = [
                'title' => 'Cursos',
                'route' => 'cursos.index',
                'icon' => 'fas fa-book'
            ];
        }
        if (self::canDo('registros_personal', 'view')) {
            $registrosSubmenu[] = [
                'title' => 'Personal',
                'route' => 'personals.index',
                'icon' => 'fas fa-id-badge'
            ];
        }

        if (!empty($registrosSubmenu)) {
            $menu[] = [
                'title' => 'Módulo Registros',
                'icon' => 'fas fa-database',
                'submenu' => $registrosSubmenu
            ];
        }

        // Sector Ventas
        if (self::canDo('ventas', 'view')) {
            $menu[] = [
                'title' => 'Sector Ventas',
                'route' => 'rventas.index',
                'icon' => 'fas fa-shopping-cart'
            ];
        }

        // Venta Cliente
        if (self::canDo('venta_cliente', 'view')) {
            $menu[] = [
                'title' => 'Venta Cliente',
                'route' => 'cliente.panel.superadmin',
                'icon' => 'fas fa-store'
            ];
        }

        // Inventario
        if (self::canDo('inventario', 'view')) {
            $menu[] = [
                'title' => 'Inventario',
                'route' => 'inventario.index',
                'icon' => 'fas fa-boxes'
            ];
        }

        // Módulos Académicos
        $academicoSubmenu = [];
        if (self::canDo('certificados', 'view')) {
            $academicoSubmenu[] = [
                'title' => 'Certificados',
                'route' => 'certificados.dashboard',
                'icon' => 'fas fa-certificate'
            ];
        }
        if (self::canDo('competencias', 'view')) {
            $academicoSubmenu[] = [
                'title' => 'Competencias',
                'route' => 'competencias.index',
                'icon' => 'fas fa-trophy'
            ];
        }

        if (!empty($academicoSubmenu)) {
            $menu[] = [
                'title' => 'Módulo Académico',
                'icon' => 'fas fa-graduation-cap',
                'submenu' => $academicoSubmenu
            ];
        }

        // Finanzas
        if (self::canDo('finanzas', 'view')) {
            $menu[] = [
                'title' => 'Finanzas',
                'route' => 'finanzas.index',
                'icon' => 'fas fa-dollar-sign'
            ];
        }

        // Gestión de Usuarios (Solo SuperAdmin)
        if (self::hasRole('superadmin')) {
            $menu[] = [
                'title' => 'Usuarios',
                'route' => 'usuarios.index',
                'icon' => 'fas fa-users-cog',
                'badge' => 'SuperAdmin'
            ];
        }

        return $menu;
    }
}