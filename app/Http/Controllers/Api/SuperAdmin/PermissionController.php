<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    private function ensureAdminAccess(): void
    {
      abort_unless(
        
      auth()->user()?->role?->role_name === 'system_admin',
       403,
       'Only the system administrator can manage permissions.'
      );
    }
    public function index(Request $request){
      $this->ensureAdminAccess();
      $validated =  $request->validate([
        'role_id'=>['nullable','integer','exists:roles,id'],
      ]);
      $roles = Role::where('role_name','!=','system_admin')->orderBy('id')->get(['id','role_name']);
           $selectedRole = null;
        $assignedPermissionIds = [];
        if(isset($validated['role_id'])){
          $selectedRole = Role::findOrFail($validated['role_id']);
          if($selectedRole->role_name === "system_admin"){
            throw ValidationException::withMessages([
              'role_id' => ['system admins permission cannot be updated'],
            ]);
          }
          $assignedPermissionIds = $selectedRole->permissions()->pluck('permissions.id')->toArray();
        }

        $permissions = Permission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        return response()->json([
           'roles' => $roles,
            'permissions' => $permissions,
            'selected_role_id' => $selectedRole?->id,
            'assigned_permission_ids' => $assignedPermissionIds,
        ]);
    }
    public function update(Request $request){
      $this->ensureAdminAccess();
     $validated = $request->validate([
    'role_id' => ['required', 'integer', 'exists:roles,id'],
    'permission_ids' => ['present', 'array'],
    'permission_ids.*' => [
        'integer',
        'distinct',
        'exists:permissions,id',
    ],
]);
        $selectedRole = Role::findOrFail($validated['role_id']);
           if ($selectedRole->role_name === 'system_admin') {
            throw ValidationException::withMessages([
                'role_id' => [
                    'System administrator permissions cannot be changed.',
                ],
            ]);
        }
          $selectedRole->permissions()->sync($validated['permission_ids']);
          return response()->json([
             'message' => 'Role permissions updated successfully.',
            'assigned_permission_ids' => $selectedRole->permissions()
                ->pluck('permissions.id')
                ->toArray(),
          ]);

    }
    public function mine(Request $request)
{
    $user = $request->user()->loadMissing('role');
    $isSystemAdmin = $user->role?->role_name === 'system_admin';

    return response()->json([
        'is_system_admin' => $isSystemAdmin,
        'permissions' => ($isSystemAdmin || ! $user->role)
            ? []
            : $user->role->permissions()->pluck('permissions.name')->values(),
    ]);
}

}
