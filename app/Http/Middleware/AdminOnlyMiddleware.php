<?php
// app/Http/Middleware/AdminOnlyMiddleware.php (NUEVO)
// app/Http/Middleware/AdminOnlyMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar si es admin o superadmin
        if (!$user->isAdmin() && !in_array($user->role, ['admin', 'superadmin'])) {
            abort(403, '⛔ Solo administradores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}
