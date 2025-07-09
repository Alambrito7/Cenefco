<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckModuloAccess
{
    public function handle($request, Closure $next, $modulo)
    {
        $user = Auth::user();
        if ($user && $user->modulos->pluck('ruta')->contains($modulo)) {
            return $next($request);
        }
        abort(403, 'No tienes acceso a este módulo.');
    }
}
