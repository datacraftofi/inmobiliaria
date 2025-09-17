<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if (!$u) return redirect()->route('login');

        // superadmin también pasa al panel admin
        if (!empty($u->is_admin) || !empty($u->is_superadmin)) {
            return $next($request);
        }
        abort(403, 'No autorizado');
    }
}
