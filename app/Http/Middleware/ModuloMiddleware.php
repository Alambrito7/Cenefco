<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ModuloMiddleware
{
    public function handle($request, Closure $next, $modulo)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->modulos->contains('modulo', $modulo)) {
            abort(403, '⛔ No tienes acceso al módulo: ' . $modulo);
        }

        return $next($request);
    }
}


