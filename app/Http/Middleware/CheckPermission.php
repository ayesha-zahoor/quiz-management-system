<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usage on a route:  ->middleware('permission:view_classes')
 *
 * Order of checks:
 *   1. Super Admin always passes.
 *   2. A per-user row in `permission_user` wins (allowed = 0 blocks, allowed = 1 grants).
 *   3. Otherwise the user's role decides.
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $roleName = $user->role?->role_name;

        // 1. Super Admin
        if ($roleName === 'system_admin') {
            return $next($request);
        }

        $table = (new Permission)->getTable();

        // 2. Per-user override
        $override = DB::table('permission_user')
            ->join($table, "{$table}.id", '=', 'permission_user.permission_id')
            ->where('permission_user.user_id', $user->id)
            ->where("{$table}.name", $permission)
            ->value('permission_user.allowed');

        if ($override !== null) {
            return $override
                ? $next($request)
                : $this->deny();
        }

        // 3. Role permission
        $roleHasIt = $user->role
            && $user->role->permissions()->where("{$table}.name", $permission)->exists();

        return $roleHasIt ? $next($request) : $this->deny();
    }

    private function deny(): Response
    {
        return response()->json([
            'message' => 'You do not have permission to perform this action.',
        ], 403);
    }
}