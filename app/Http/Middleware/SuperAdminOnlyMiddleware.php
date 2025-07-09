<?php

// app/Http/Middleware/SuperAdminOnlyMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $user = Auth::user();

        // Verificar si es superadmin por el campo role (sistema anterior)
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Verificar si tiene el rol superadmin en el nuevo sistema
        try {
            if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
                return $next($request);
            }

            if (method_exists($user, 'hasRole') && $user->hasRole('superadmin')) {
                return $next($request);
            }
        } catch (\Exception $e) {
            // Si hay error con los métodos nuevos, usar solo el campo role
        }

        // Si no es superadmin, denegar acceso
        abort(403, '⛔ Solo el Super Administrador puede acceder a esta sección.');
    }
}