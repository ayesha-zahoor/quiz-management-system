<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institute;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class InstituteAdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $admin = $request->user();

        $institute = Institute::with('configuration')
            ->findOrFail($admin->institute_id);
        // dd($institute);
        $teachers = User::where('institute_id', $admin->institute_id)
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'teacher');
            })
            ->count();

        
        $students = User::where('institute_id', $admin->institute_id)
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'student');
            })
            ->count();

        $Classes = SchoolClass::where('institute_id', $admin->institute_id)->with('students')->get();
        // dd($Classes);
        $totalSubjects = Subject::where('institute_id', $admin->institute_id)->get();
 $teachersAssigned = User::where('role_id',3)->where('institute_id', $admin->institute_id)->whereHas('teachingClasses')->with(['teachingClasses','teachingSubjects'])->get();
//  dd($teachers);
//  foreach($teachers as $teacher){
//      if($teacher->teachingClasses != ''){
//          $assignments = $teachers->teachingClasses()
//          ->withPivot('subject_id')
//          ->with('institute')
//          ->orderBy('sort_order')
//          ->get();
//      }
//  }
//  dd($assignments);
        return response()->json([
            'success' => true,
            'message' => 'Institute Admin dashboard retrieved successfully.',
            'data' => [
                'institute' => $institute,
                'teachers_count' => $teachers,
                'students_count' => $students,
                'Classes with students' => $Classes,
                'total_subjects' => $totalSubjects,
                'teacher assigned to classes and subjects' => $teachersAssigned,

            ]
        ]);
    }
}