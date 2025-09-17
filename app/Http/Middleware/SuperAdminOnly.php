<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if (!$u || !$u->is_superadmin) {
            abort(403, 'Solo Super Admin');
        }
        return $next($request);
    }
}
