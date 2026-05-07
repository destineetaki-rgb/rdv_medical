<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = null): mixed
    {
        if ($role === null) {
            return $next($request);
        }

        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}