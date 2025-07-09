<?php

// app/Http/Middleware/PermissionMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $user = Auth::user();

        // Si es superadmin, permitir todo
        if ($user->isSuperAdmin() || $user->role === 'superadmin') {
            return $next($request);
        }

        // Verificar si tiene el permiso específico
        if (!$user->hasPermission($permission)) {
            abort(403, "⛔ No tienes permiso para realizar esta acción: {$permission}");
        }

        return $next($request);
    }
}