<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'institute'])
            ->whereHas('role', function ($q) {
                $q->where('role_name', 'institute_admin');
            })
            ->latest();

        if ($request->filled('institute_id')) {
            $query->where('institute_id', $request->institute_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Institute Admins retrieved successfully.',
            'data' => $users
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8'
            ],

            'institute_id' => [
                'required',
                'exists:institutes,id'
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ]);

        $role = Role::where('role_name', 'institute_admin')->firstOrFail();

        $profileImagePath = null;

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')
                ->store('profile_images', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
            'institute_id' => $validated['institute_id'],
            'student_roll_no' => null,
            'profile_image' => $profileImagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Institute Admin created successfully.',
            'data' => $user->load(['role', 'institute'])
        ], 201);
    }


    public function show(User $user)
    {
        $user->load(['role', 'institute']);

        if (
            !$user->role ||
            $user->role->role_name !== 'institute_admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This user is not an Institute Admin.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Institute Admin retrieved successfully.',
            'data' => $user
        ]);
    }
    // public function editProfile(string $id){
    //     $user = User::findOrFail($id);
    //     return view('superAdmin.profile',compact('user'));
    // }

    public function update(Request $request, User $user)
    {
        // $user->load('role');
        $user = $request->user();
        // dd($user);

        // if (
        //     !$user->role ||
        //     $user->role->role_name !== 'institute_admin'
        // ) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Only Institute Admin accounts can be updated here.'
        //     ], 422);
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'institute_id' => [
                'required',
                'exists:institutes,id'
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'student_roll_no' => [
                'nullable',
                 'string'
            ],
            'role_id' => [
                'required',
            ],
        ]);

        if ($request->hasFile('profile_image')) {

            if (
                $user->profile_image &&
                Storage::disk('public')->exists($user->profile_image)
            ) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $validated['profile_image'] = $request->file('profile_image')
                ->store('profile_images', 'public');
        }
         if(!$request->student_roll_no){
            $validated['student_roll_no'] = null;

         }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfuly',
            'data' => $user->fresh()->load(['role', 'institute'])
        ]);
    }


    public function updatePassword(Request $request, User $user)
    {
        $user->load('role');

        if (
            !$user->role ||
            $user->role->role_name !== 'institute_admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Only Institute Admin passwords can be changed here.'
            ], 422);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Institute Admin password updated successfully.'
        ]);
    }


    public function destroy(User $user)
    {
        $user->load('role');

        if (
            !$user->role ||
            $user->role->role_name !== 'institute_admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Only Institute Admin accounts can be deleted here.'
            ], 422);
        }

        if (
            $user->profile_image &&
            Storage::disk('public')->exists($user->profile_image)
        ) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Institute Admin deleted successfully.'
        ]);
    }
}
