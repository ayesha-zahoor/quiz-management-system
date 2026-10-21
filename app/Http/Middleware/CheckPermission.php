<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {

           $user = $request->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        if ($user->role?->role_name === 'system_admin') {
            return $next($request);
        }

        $hasPermission = $user->role
            ? $user->role->permissions()
                ->where('permissions.name', $permission)
                ->exists()
            : false;

        if (!$hasPermission) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    
    }
}
