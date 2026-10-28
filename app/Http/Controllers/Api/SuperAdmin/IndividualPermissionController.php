<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Per-user permission blocking.
 *
 * A user always gets the permissions of their role.
 * This controller lets the Super Admin BLOCK some of them for one user.
 * A blocked permission is stored in `permission_user` with allowed = 0.
 * No row means the user simply keeps what their role gives them.
 */
class IndividualPermissionController extends Controller
{
    /** Every user that has a role can be managed, except the Super Admin. */
    private function isManageable(User $user): bool
    {
        $role = $user->role?->role_name;

        return $role !== null && $role !== 'system_admin';
    }

    private function forbidden()
    {
        return response()->json([
            'message' => 'This user cannot be managed here.',
        ], 403);
    }

    /**
     * The permissions that belong to the user's role.
     *
     * Assumes Role has a permissions() belongsToMany relation.
     * If your relation has another name, or the role pivot has an on/off
     * column, change it here and nothing else needs to change.
     */
    private function rolePermissions(User $user)
    {
        $table = (new Permission)->getTable();

        return $user->role
            ->permissions()
            ->orderBy("{$table}.module")
            ->orderBy("{$table}.name")
            ->get(["{$table}.id", "{$table}.name", "{$table}.module", "{$table}.description"])
            ->makeHidden('pivot');
    }

    /**
     * GET /api/permission-users?role=&search=
     * Users the Super Admin can pick from.
     */
    public function users(Request $request)
    {
        $request->validate([
            'role'   => ['nullable', 'string', 'max:50'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $roleFilter = $request->input('role');
        $search     = trim((string) $request->input('search', ''));

        $users = User::with('role')
            ->whereHas('role', function ($q) use ($roleFilter) {
                $q->where('role_name', '!=', 'system_admin');

                if ($roleFilter) {
                    $q->where('role_name', $roleFilter);
                }
            })
            ->when($search !== '', function ($q) use ($search) {
                $q->where(fn ($q) => $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('name')
            ->limit(100)
            ->get();

        // Roles for the filter dropdown, taken from the database
        $roles = (new User)->role()->getRelated()->newQuery()
            ->where('role_name', '!=', 'system_admin')
            ->orderBy('role_name')
            ->pluck('role_name');

        return response()->json([
            'data' => $users->map(fn (User $u) => [
                'id'    => $u->id,
                'name'  => $u->name,
                'email' => $u->email,
                'role'  => $u->role?->role_name,
            ])->values(),
            'roles' => $roles,
        ]);
    }

    /**
     * GET /api/users/{user}/permissions
     * Returns the role's permissions and which of them are blocked for this user.
     */
    public function show(User $user)
    {
        if (! $this->isManageable($user)) {
            return $this->forbidden();
        }

        $permissions = $this->rolePermissions($user);

        $blocked = DB::table('permission_user')
            ->where('user_id', $user->id)
            ->where('allowed', 0)
            ->whereIn('permission_id', $permissions->pluck('id'))
            ->pluck('permission_id')
            ->map(fn ($id) => (int) $id)
            ->values();

        return response()->json([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role?->role_name,
            ],
            'permissions' => $permissions,
            'blocked'     => $blocked,
        ]);
    }

    /**
     * PUT /api/users/{user}/permissions
     * Body: { "blocked": [3, 7] }   (an empty list unblocks everything)
     */
    public function update(Request $request, User $user)
    {
        if (! $this->isManageable($user)) {
            return $this->forbidden();
        }

        $validated = $request->validate([
            'blocked'   => ['present', 'array'],
            'blocked.*' => ['integer'],
        ]);

        $roleIds = $this->rolePermissions($user)->pluck('id')->map(fn ($id) => (int) $id)->all();
        $blocked = array_values(array_unique(array_map('intval', $validated['blocked'])));

        // Only permissions that the role really has can be blocked
        if (array_diff($blocked, $roleIds)) {
            return response()->json([
                'message' => 'One or more permissions do not belong to this user\'s role.',
            ], 422);
        }

        DB::transaction(function () use ($user, $roleIds, $blocked) {
            // Start clean for this role's permissions, then store the blocked ones
            DB::table('permission_user')
                ->where('user_id', $user->id)
                ->whereIn('permission_id', $roleIds)
                ->delete();

            $rows = array_map(fn ($id) => [
                'user_id'       => $user->id,
                'permission_id' => $id,
                'allowed'       => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
            ], $blocked);

            if ($rows) {
                DB::table('permission_user')->insert($rows);
            }
        });

        return response()->json(['message' => 'Permissions updated successfully.']);
    }
}