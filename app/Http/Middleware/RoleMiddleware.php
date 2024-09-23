<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403); // Retorna erro 403 se o usuário não tiver o papel correto
        }
        return $next($request);
    }
}

