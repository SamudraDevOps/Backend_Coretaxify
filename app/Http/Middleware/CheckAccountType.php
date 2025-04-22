<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sistem;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountType
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$allowedTypes): Response
    {
        $sistemId = $request->route('sistem');
        $sistem = Sistem::findOrFail($sistemId);

        if (!in_array($sistem->tipe_akun, $allowedTypes)) {
            return response()->json([
                'message' => 'This action is not allowed for your account type.'
            ], 403);
        }

        // Store the sistem in the request for later use
        $request->attributes->add(['current_sistem' => $sistem]);

        return $next($request);
    }
}
