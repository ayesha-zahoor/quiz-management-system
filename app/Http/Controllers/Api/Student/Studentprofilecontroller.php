<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\Quiz;

class Studentprofilecontroller extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->payload($request->user()),
        ]);
    }
 
    /**
     * POST /api/student/profile      (multipart form: name, profile_image, remove_image)
     * A student may change ONLY their name and picture. Email, roll number, class and institute stay with the admin.
     */
    public function update(Request $request)
    {
        $user = $request->user();
 
        $data = $request->validate([
            'name'          => 'required|string|min:2|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image'  => 'sometimes|boolean',
        ]);
 
        $changes = ['name' => trim($data['name'])];
 
        if ($request->hasFile('profile_image')) {
            $this->deleteImage($user->profile_image);
            $changes['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($user->profile_image);
            $changes['profile_image'] = null;
        }
 
        $user->update($changes);
 
        return response()->json([
            'success' => true,
            'message' => 'Profile updated.',
            'data'    => $this->payload($user->fresh()),
        ]);
    }
 
    /**
     * PUT /api/student/profile/password   { current_password, password, password_confirmation }
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();
 
        $data = $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed|different:current_password',
        ]);
 
        if (! Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Your current password is not correct.',
                'errors'  => ['current_password' => ['Your current password is not correct.']],
            ], 422);
        }
 
        $user->forceFill(['password' => Hash::make($data['password'])])->save();
 
        // Sign the student out of their other devices, but keep this one signed in
        $current = $user->currentAccessToken();
 
        if ($current && isset($current->id)) {
            $user->tokens()->where('id', '!=', $current->id)->delete();
        }
 
        return response()->json(['success' => true, 'message' => 'Password changed.']);
    }
 
    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
 
    private function payload($user): array
    {
        $user->loadMissing('studentClasses');
 
        $institute = $user->institute;   // stays null if your User model has no institute() relationship
 
        // Small learning snapshot from completed attempts
        $attempts = QuizAttempt::where('student_id', $user->id)
            ->where('status', 'completed')
            ->get(['quiz_id', 'score']);
 
        $totals = Quiz::whereIn('id', $attempts->pluck('quiz_id')->unique())->pluck('total_marks', 'id');
 
        $percentages = $attempts->map(function ($a) use ($totals) {
            $total = $totals[$a->quiz_id] ?? 0;
 
            return $total > 0 ? round($a->score / $total * 100, 1) : 0;
        });
 
        return [
            'id'              => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'student_roll_no' => $user->student_roll_no,
            'profile_image'   => $user->profile_image,
            'created_at'      => $user->created_at,
            'institute'       => $institute ? ['name' => $institute->name] : null,
            'classes'         => $user->studentClasses->pluck('class_name')->values(),
            'stats'           => [
                'completed' => $attempts->count(),
                'average'   => $attempts->count() ? round($percentages->avg(), 1) : 0,
                'best'      => $attempts->count() ? $percentages->max() : 0,
            ],
        ];
    }
}
