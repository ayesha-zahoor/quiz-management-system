<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstituteAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        if (
            !$user->role ||
            $user->role->role_name !== 'institute_admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institute Admin access required.'
            ], 403);
        }

        if (!$user->institute_id) {
            return response()->json([
                'success' => false,
                'message' => 'Institute is not assigned to this account.'
            ], 403);
        }

        return $next($request);
    }
}