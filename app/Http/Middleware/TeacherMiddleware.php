<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        if (!$user->role || $user->role->role_name !== 'teacher') {
            return response()->json([
                'status' => false,
                'message' => 'Teacher access required'
            ], 403);
        }

        return $next($request);
    }
}