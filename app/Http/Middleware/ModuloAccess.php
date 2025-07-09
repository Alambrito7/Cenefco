<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuloAccess
{
    public function handle(Request $request, Closure $next, $modulo)
    {
        $user = Auth::user();

        if (!$user || !$user->modulos->contains('nombre', $modulo)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
