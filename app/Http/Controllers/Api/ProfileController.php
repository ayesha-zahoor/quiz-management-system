<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $user->load(['role', 'institute']);

        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => $user
        ]);
    }

     public function editProfile(String $id){
        $user = User::findOrFail($id);
        // $user = $request->user();
        return view('superAdmin.profile',compact('user'));
    }
    
    public function update(Request $request,string $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {
        $validated['profile_image'] = $request->file('profile_image')
            ->store('profile_images', 'public');
    }

    $user->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'data' => $user->fresh()->load(['role', 'institute'])
    ]);
}


public function updatePassword(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if (!Hash::check($validated['current_password'], $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Current password is incorrect.'
        ], 422);
    }

    $user->update([
        'password' => Hash::make($validated['password']),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Password updated successfully.'
    ]);
}
}