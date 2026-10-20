<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public fucntion ensureAdminAccess(): void
    {
      abort_unless(auth()->user()?->role?->role_name==='syetem_admin',
      403,
      'Only the system administrator can manage permissions'.
      )
    }
}
