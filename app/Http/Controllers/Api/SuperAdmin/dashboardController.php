<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
      public function dashboard(Request $request)
    {
        $user = $request->user();
        
        // dd($user);
        
        $totalInstitutes = Institute::count();

        $activeInstitutes = Institute::where('status', 'active')->count();

        $suspendedInstitutes = Institute::where('status', 'suspended')->count();

        $totalInstituteAdmins = User::whereHas('role', function ($query) {
            $query->where('role_name', 'institute_admin');
        })->count();

        return view('superAdmin.dashboard',compact(['total_institutes','active_institutes','suspended_institutes','total_institute_admins','user']));
    }
}
