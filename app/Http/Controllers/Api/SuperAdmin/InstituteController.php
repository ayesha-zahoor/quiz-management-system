<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\InstituteConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user();
        // dd($user);
        $institutes = Institute::with(['configuration', 'users'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data has been fetched',
            'data' => $institutes,
            'admin'=>$admin,
        ]);
    }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'license_key' => 'nullable|string|max:100|unique:institutes,license_key',
    //         'license_expires_at' => 'nullable|date',
    //         'status' => 'nullable|in:active,suspended,expired',
    //         'email' => 'nullable|unique:institutes,email',
    //         'Contact' => 'nullable|numeric',
    //         'address' => 'nullable|string',

    //     ]);

    //     $logoPath = null;

    //     if ($request->hasFile('logo')) {
    //         $logoPath = $request->file('logo')
    //             ->store('institute_logos', 'public');
    //     }

    //     $institute = DB::transaction(function () use ($validated, $logoPath) {

    //         $institute = Institute::create([
    //             'name' => $validated['name'],
    //             'logo' => $logoPath,
    //             'Contact' => $validated['Contact'],
    //             'email' => $validated['email'],
    //             'address' => $validated['address'],
    //             'license_key' => $validated['license_key']
    //                 ?? strtoupper(Str::random(12)),
    //             'license_expires_at' => $validated['license_expires_at'] ?? null,
    //             'status' => $validated['status'] ?? 'active',
                
    //         ]);

    //         $institute->configuration()->create([
    //             'primary_color' => '#1E3A8A',
    //             'secondary_color' => '#2563EB',
    //             'accent_color' => '#F59E0B',
    //             'background_color' => '#F8FAFC',
    //             'text_color' => '#1F2937',
    //         ]);

    //         return $institute;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Institute created successfully.',
    //         'data' => $institute->load('configuration')
    //     ], 201);
    // }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255|unique:institutes,email',
        'Contact' => 'nullable|numeric',
        'address' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'license_key' => 'nullable|string|max:100|unique:institutes,license_key',
        'license_expires_at' => 'nullable|date',
        'status' => 'nullable|in:active,suspended,expired',

        'admin_name' => 'required|string|max:255',
        'admin_email' => 'required|email|max:255|unique:users,email',
        'admin_password' => 'required|string|min:8|confirmed',
        'admin_profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'primary_color' => 'required|string|max:20',
        'secondary_color' => 'required|string|max:20',
        'accent_color' => 'required|string|max:20',
        'background_color' => 'required|string|max:20',
        'text_color' => 'required|string|max:20',
    ]);

    $logoPath = null;
    $profileImagePath = null;

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')
            ->store('institute_logos', 'public');
    }

    if ($request->hasFile('admin_profile_image')) {
        $profileImagePath = $request->file('admin_profile_image')
            ->store('profile_images', 'public');
    }

    $data = DB::transaction(function () use ($validated, $logoPath, $profileImagePath) {

        $institute = Institute::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'Contact' => $validated['Contact'] ?? null,
            'address' => $validated['address'] ?? null,
            'logo' => $logoPath,
            'license_key' => $validated['license_key']
                ?? strtoupper(Str::random(12)),
            'license_expires_at' => $validated['license_expires_at'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        $configuration = $institute->configuration()->create([
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'accent_color' => $validated['accent_color'],
            'background_color' => $validated['background_color'],
            'text_color' => $validated['text_color'],
        ]);

        $role = Role::where(
            'role_name',
            'institute_admin'
        )->firstOrFail();

        $admin = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make(
                $validated['admin_password']
            ),
            'role_id' => $role->id,
            'institute_id' => $institute->id,
            'student_roll_no' => null,
            'profile_image' => $profileImagePath,
        ]);

        return [
            'institute' => $institute,
            'configuration' => $configuration,
            'admin' => $admin->load(['role', 'institute']),
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Institute, configuration and Institute Admin created successfully.',
        'data' => $data
    ], 201);
}

    public function show(Institute $institute)
    {
        $institute->load('configuration', 'users');

        return response()->json([
            'success' => true,
            'message' => 'Institute retrieved successfully.',
            'data' => $institute
        ]);
    }

  public function edit(String $id){
    $editInstitute = Institute::findOrFail($id);
    $editInstituteConfig = InstituteConfiguration::where('institute_id',$id)->first();
    $admin = User::where('institute_id',$id)
    ->whereHas('role',function($query){ 
        $query->where('role_name','institute_admin');
    })->first();
    return view('superAdmin.edit',compact(['editInstitute','editInstituteConfig','admin']));
  }
    public function update(Request $request,String $id)
    {
        $updateInstitute = Institute::where('id',$id)->findOrFail($id);
         $admin = User::where('institute_id',$id)
    ->whereHas('role',function($query){ 
        $query->where('role_name','institute_admin');
    })->first();
    // dd($admin);
         $validated = $request->validate([
        'name' => 'nullable|string|max:255',
       
           'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('institutes', 'email')->ignore($updateInstitute->id),
            ],
        'Contact' => 'nullable|numeric',
        'address' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'license_key' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('institutes', 'license_key')->ignore($updateInstitute->id),
            ],
        'license_expires_at' => 'nullable|date',
        'status' => 'nullable|in:active,suspended,expired',

        'admin_name' => 'nullable|string|max:255',
        'admin_email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin->id, 'id'),
            ],
        'admin_password' => 'nullable|string|min:8|confirmed',
        'admin_profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'primary_color' => 'nullable|string|max:20',
        'secondary_color' => 'nullable|string|max:20',
        'accent_color' => 'nullable|string|max:20',
        'background_color' => 'nullable|string|max:20',
        'text_color' => 'nullable|string|max:20',
    ]);
//      dd([
//     'admin_id' => $admin->id,
//     'admin_email' => $admin->email,
//     'request_email' => $request->email,
// ]);
    $logoPath = $updateInstitute->logo;
    $profileImagePath = $admin->profile_image;

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')
            ->store('institute_logos', 'public');
    }
    if ($request->hasFile('admin_profile_image')) {
        $profileImagePath = $request->file('admin_profile_image')
            ->store('profile_images', 'public');
    }
    $data = DB::transaction(function () use ($validated, $logoPath, $profileImagePath,$updateInstitute,$admin) {

       $updateInstitute->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'Contact' => $validated['Contact'] ?? null,
            'address' => $validated['address'] ?? null,
            'logo' => $logoPath,
            'license_key' => $validated['license_key']
                ?? strtoupper(Str::random(12)),
            'license_expires_at' => $validated['license_expires_at'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        $configuration = $updateInstitute->configuration()->update([
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'accent_color' => $validated['accent_color'],
            'background_color' => $validated['background_color'],
            'text_color' => $validated['text_color'],
        ]);

        $role = Role::where(
            'role_name',
            'institute_admin'
        )->firstOrFail();
        // $admin = User::where('institute_id',$updateInstitute->id)->first();
        $admin->update([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make(
                $validated['admin_password']
            ),
            'role_id' => $role->id,
            'institute_id' => $updateInstitute->id,
            'student_roll_no' => null,
            'profile_image' => $profileImagePath,
        ]);

        return [
            'institute' => $updateInstitute,
            'configuration' => $configuration,
            'admin' => $admin->load(['role', 'institute']),
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Institute, configuration and Institute Admin Updated successfully.',
        'data' => $data
    ], 201);
    }
    public function destroy(Institute $institute)
    {
        if ($institute->users()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete an institute that has users.'
            ], 422);
        }

        if (
            $institute->logo &&
            Storage::disk('public')->exists($institute->logo)
        ) {
            Storage::disk('public')->delete($institute->logo);
        }

        $institute->delete();

        return response()->json([
            'success' => true,
            'message' => 'Institute deleted successfully.'
        ]);
    }


    public function toggleStatus(Institute $institute)
    {
        $newStatus = $institute->status === 'active'
            ? 'suspended'
            : 'active';

        $institute->update([
            'status' => $newStatus
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Institute status updated successfully.',
            'status' => $newStatus
        ]);
    }
}