<?php

// app/Http/Middleware/ModulePermissionMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulePermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $module, $action = 'view')
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $user = Auth::user();

        // Si es superadmin, permitir todo
        if ($user->isSuperAdmin() || $user->role === 'superadmin') {
            return $next($request);
        }

        // Verificar si tiene el permiso para el módulo y acción
        if (!$user->hasPermissionTo($module, $action)) {
            abort(403, "⛔ No tienes permiso para {$action} en el módulo {$module}.");
        }

        return $next($request);
    }
}
