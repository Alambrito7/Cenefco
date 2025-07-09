<?php
// app/Http/Middleware/RoleMiddleware.php (ACTUALIZADO)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        $user = Auth::user();

        // Verificar roles nuevos
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Verificar rol antiguo para compatibilidad
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, '⛔ No tienes permiso para acceder a esta sección.');
    }
}