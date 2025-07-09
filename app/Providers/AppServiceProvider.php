<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\PermissionHelper;
use Illuminate\Pagination\Paginator;
use App\Milddleware\SuperAdminOnlyMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directivas de Blade para permisos específicos
        Blade::if('can', function ($permission) {
            return PermissionHelper::can($permission);
        });

        Blade::if('canDo', function ($module, $action) {
            return PermissionHelper::canDo($module, $action);
        });

        Blade::if('canAny', function (...$permissions) {
            return PermissionHelper::canAny($permissions);
        });

        Blade::if('canAll', function (...$permissions) {
            return PermissionHelper::canAll($permissions);
        });

        // Directivas de Blade para roles
        Blade::if('hasRole', function ($role) {
            return PermissionHelper::hasRole($role);
        });

        Blade::if('hasAnyRole', function (...$roles) {
            return PermissionHelper::hasAnyRole($roles);
        });

        Blade::if('isSuperAdmin', function () {
            return auth()->check() && auth()->user()->isSuperAdmin();
        });

        Blade::if('isAdmin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('isAgenteVentas', function () {
            return auth()->check() && auth()->user()->isAgenteVentas();
        });

        Blade::if('isAgenteAdministrativo', function () {
            return auth()->check() && auth()->user()->isAgenteAdministrativo();
        });

        Blade::if('isAgenteAcademico', function () {
            return auth()->check() && auth()->user()->isAgenteAcademico();
        });

        // Directivas específicas para módulos de tu sistema
        Blade::if('canAccessRegistros', function ($submodule = null) {
            return PermissionHelper::canAccessRegistros($submodule);
        });

        Blade::if('canAccessVentas', function () {
            return PermissionHelper::canAccessVentas();
        });

        Blade::if('canAccessVentaCliente', function () {
            return PermissionHelper::canAccessVentaCliente();
        });

        Blade::if('canAccessInventario', function () {
            return PermissionHelper::canAccessInventario();
        });

        Blade::if('canAccessCertificados', function () {
            return PermissionHelper::canAccessCertificados();
        });

        Blade::if('canAccessFinanzas', function () {
            return PermissionHelper::canAccessFinanzas();
        });

        // Directiva para mostrar badges de rol
        Blade::directive('roleBadge', function () {
            return "<?php echo '<span class=\"badge\" style=\"background-color: ' . \App\Helpers\PermissionHelper::getUserRoleColor() . ';\">' . \App\Helpers\PermissionHelper::getUserRoleName() . '</span>'; ?>";
        });

        // Directiva para mostrar menú dinámico
        Blade::directive('dynamicMenu', function () {
            return "<?php \$menuItems = \App\Helpers\PermissionHelper::getMenuItems(); ?>";
        });
        
        Paginator::useBootstrap();
    }
}
