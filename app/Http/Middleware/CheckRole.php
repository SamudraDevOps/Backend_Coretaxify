<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole {
    public function handle($request, Closure $next, $role) {
        if (!$request->user()->hasRole($role)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
