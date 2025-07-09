<?php

// app/Http/Middleware/CheckModuleAccess.php (NUEVO - Para verificar acceso a módulos específicos)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckModuleAccess
{
    /**
     * Verificar si el usuario tiene acceso a módulos específicos según su rol
     */
    public function handle(Request $request, Closure $next, $moduleGroup)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si es superadmin, acceso total
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $hasAccess = false;

        switch ($moduleGroup) {
            case 'registros':
                // Agente Admin, Agente Ventas (solo clientes), Agente Académico (solo docentes/cursos)
                $hasAccess = $user->hasRole(['agente_administrativo', 'agente_ventas', 'agente_academico', 'admin']);
                break;

            case 'ventas':
                // Solo Agente de Ventas y Admin
                $hasAccess = $user->hasRole(['agente_ventas', 'admin']);
                break;

            case 'academico':
                // Solo Agente Académico y Admin
                $hasAccess = $user->hasRole(['agente_academico', 'admin']);
                break;

            case 'administrativo':
                // Solo Agente Administrativo y Admin
                $hasAccess = $user->hasRole(['agente_administrativo', 'admin']);
                break;

            case 'financiero':
                // Solo Agente Administrativo y Admin
                $hasAccess = $user->hasRole(['agente_administrativo', 'admin']);
                break;

            default:
                $hasAccess = false;
        }

        if (!$hasAccess) {
            abort(403, "⛔ No tienes acceso al módulo {$moduleGroup}.");
        }

        return $next($request);
    }
}