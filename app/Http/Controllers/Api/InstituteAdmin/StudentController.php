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

    $base = User::where('institute_id', $admin->institute_id)
        ->whereHas('role', fn ($q) => $q->where('role_name', 'student'));

    $stats = [
        'total'          => (clone $base)->count(),
        'new_this_month' => (clone $base)->where('created_at', '>=', now()->startOfMonth())->count(),
    ];

    $query = (clone $base)->with('studentClasses')->withCount('quizAttempts')->latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('student_roll_no', 'like', "%{$search}%")
              ->orWhereHas('studentClasses', fn ($c) => $c->where('class_name', 'like', "%{$search}%"));
        });
    }

    return response()->json([
        'success' => true,
        'message' => 'Students retrieved successfully.',
        'data'    => $query->paginate(10)->withQueryString(),
        'stats'   => $stats,
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
             'student_roll_no' => [
                'nullable',
                'string'
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
            'student_roll_no' => $validated['student_roll_no'],
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
            
            'password' => [
                'nullable',
                'string',
                'min:8'
            ],

            'profile_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'student_roll_no' => [
                'required',
                'string'
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
