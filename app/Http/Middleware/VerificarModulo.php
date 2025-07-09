<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificarModulo
{
    public function handle($request, Closure $next, $modulo)
    {
        $usuario = Auth::user();

        // Verificamos si el usuario tiene acceso al módulo
        $tieneAcceso = $usuario->modulos()->where('ruta', $modulo)->exists();

        if (!$tieneAcceso) {
            abort(403, 'No tiene permiso para acceder a este módulo.');
        }

        return $next($request);
    }
}
