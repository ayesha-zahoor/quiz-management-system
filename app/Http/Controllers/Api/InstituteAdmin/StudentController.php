<?php

namespace App\Http\Controllers\API\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
      public function index(Request $request)
    {
        $admin = $request->user();

        $query = User::with('role')
            ->where('institute_id', $admin->institute_id)
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'student');
            })
            ->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $students = $query->paginate(15)->withQueryString();
        return response()->json([
            'success' => true,
            'message' => 'Students retrieved successfully.',
            'data' => $students
        ]);
    }


    public function store(Request $request)
    {
        $admin = $request->user();

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

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ]);

        $role = Role::where('role_name', 'student')->firstOrFail();

        $profileImagePath = null;

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')
                ->store('profile_images', 'public');
        }

        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
            'institute_id' => $admin->institute_id,
            'student_roll_no' => null,
            'profile_image' => $profileImagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data' => $student->load('role')
        ], 201);
    }


    public function show(Request $request, User $user)
    {
        $admin = $request->user();

        $user->load('role');

        if (
            $user->institute_id !== $admin->institute_id ||
            !$user->role ||
            $user->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student retrieved successfully.',
            'data' => $user
        ]);
    }


    public function update(Request $request, User $user)
    {
        $admin = $request->user();

        $user->load('role');

        if (
            $user->institute_id !== $admin->institute_id ||
            !$user->role ||
            $user->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
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

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $user->fresh()->load('role')
        ]);
    }


    public function updatePassword(Request $request, User $user)
    {
        $admin = $request->user();

        $user->load('role');

        if (
            $user->institute_id !== $admin->institute_id ||
            !$user->role ||
            $user->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student password updated successfully.'
        ]);
    }


    public function destroy(Request $request, User $user)
    {
        $admin = $request->user();

        $user->load('role');

        if (
            $user->institute_id !== $admin->institute_id ||
            !$user->role ||
            $user->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
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
            'message' => 'Student deleted successfully.'
        ]);
    }
}
