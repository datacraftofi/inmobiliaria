<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Uso: ->middleware(['auth','role:admin'])  o  ->middleware('role:superadmin,admin')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Permite que superadmin pase siempre
        if (property_exists($user, 'is_superadmin') && $user->is_superadmin) {
            return $next($request);
        }

        // Admite checks por flags simples (admin, superadmin)
        foreach ($roles as $role) {
            $role = trim(strtolower($role));
            if ($role === 'admin' && !empty($user->is_admin)) {
                return $next($request);
            }
            if ($role === 'superadmin' && !empty($user->is_superadmin)) {
                return $next($request);
            }
        }

        abort(403, 'No autorizado.');
    }
}
