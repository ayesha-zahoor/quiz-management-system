<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherClassController extends Controller
{
    public function store(Request $request, User $teacher)
    {
        $admin = $request->user();
    //     dd([
    //     'request' => $request->all(),
    //     'teacher' => $teacher,
    //     'teacher_id' => $teacher->id,
    // ]);
        if (
            $teacher->institute_id !== $admin->institute_id ||
            !$teacher->role || $teacher->role->role_name !== 'teacher'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found in your institute.'
            ], 404);
        }

        $validated = $request->validate([
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);

        $class = SchoolClass::where('id', $validated['class_id'])
            ->where('institute_id', $admin->institute_id)
            ->first();

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Class not found in your institute.'
            ], 404);
        }

        $subject = Subject::where('id', $validated['subject_id'])
            ->where('institute_id', $admin->institute_id)
            ->first();

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Subject not found in your institute.'
            ], 404);
        }

        $exists = $teacher->teachingClasses()
            ->wherePivot('class_id', $class->id)
            ->wherePivot('subject_id', $subject->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This teacher is already assigned to this class and subject.'
            ], 422);
        }

        $teacher->teachingClasses()->attach($class->id, [
            'subject_id' => $subject->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher assigned to class and subject successfully.'
        ], 201);
    }

    public function index(Request $request, User $teacher)
    {
        $admin = $request->user();

        if (
            $teacher->institute_id !== $admin->institute_id ||
            !$teacher->role ||
            $teacher->role->role_name !== 'teacher'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found in your institute.'
            ], 404);
        }

        $assignments = $teacher->teachingClasses()
            ->withPivot('subject_id')
            ->with('institute')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $assignments
        ]);
    }

    public function destroy(
        Request $request,
        User $teacher,
        SchoolClass $class
    ) {
        $admin = $request->user();

        if (
            $teacher->institute_id !== $admin->institute_id ||
            $class->institute_id !== $admin->institute_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        $subjectId = $request->validate([
            'subject_id' => 'required|integer'
        ])['subject_id'];

        $teacher->teachingClasses()
            ->wherePivot('class_id', $class->id)
            ->wherePivot('subject_id', $subjectId)
            ->detach();

        return response()->json([
            'success' => true,
            'message' => 'Teacher assignment removed successfully.'
        ]);
    }
}