<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->role || $user->role->role_name !== 'system_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. System Admin access required.'
            ], 403);
        }

        return $next($request);
    
    }
}
