<?php

namespace App\Http\Controllers\API\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function store(Request $request, User $student)
    {
        $admin = $request->user();
    //     dd([
    //     'request' => $request->all(),
    //     'teacher' => $teacher,
    //     'teacher_id' => $teacher->id,
    // ]);
        if (
            $student->institute_id !== $admin->institute_id ||
            !$student->role || $student->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
        }

        $validated = $request->validate([
            'class_id' => 'required|integer',
            // 'subject_id' => 'required|integer',
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

        // $subject = Subject::where('id', $validated['subject_id'])
        //     ->where('institute_id', $admin->institute_id)
        //     ->first();

        // if (!$subject) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Subject not found in your institute.'
        //     ], 404);
        // }
        // $exists = $student->teachingClasses()
   $alreadyAssigned = $student->studentClasses()->exists();
            // ->wherePivot('subject_id', $subject->id)
            // ->exists();

        if ($alreadyAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'This student is already assigned to this class.'
            ], 422);
        }

      $student->studentClasses()->attach($class->id);

        return response()->json([
            'success' => true,
            'message' => 'Student assigned to class successfully.'
        ], 201);
    }

    public function index(Request $request, User $student)
    {
        $admin = $request->user();

        if (
            $student->institute_id !== $admin->institute_id ||
            !$student->role ||
            $student->role->role_name !== 'student'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found in your institute.'
            ], 404);
        }

        $assignments = $student->studentClasses()
            ->with('institute')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $assignments
        ]);
    }

    public function destroy(
        Request $request,
        User $student,
        SchoolClass $class
    ) {
        $admin = $request->user();

        if (
            $student->institute_id !== $admin->institute_id ||
            $class->institute_id !== $admin->institute_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        // $subjectId = $request->validate([
        //     'subject_id' => 'required|integer'
        // ])['subject_id'];

        $student->studentClasses()
            ->wherePivot('class_id', $class->id)
            ->detach();

        return response()->json([
            'success' => true,
            'message' => 'Student assignment removed successfully.'
        ]);
    }
}
