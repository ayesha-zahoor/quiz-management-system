<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\InstituteConfiguration;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use App\Models\Institute;


class DashboardController extends Controller
{
    public function index()
    {
        $admin = request()->user();

        $instituteId = $admin->institute_id;

        $totalClasses = SchoolClass::where('institute_id', $instituteId)->count();

        $totalTeachers = User::where('institute_id', $instituteId)
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'teacher');
            })
            ->count();

        $totalStudents = User::where('institute_id', $instituteId)
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'student');
            })
            ->count();

        $totalSubjects = Subject::where('institute_id', $instituteId)->count();
        $instituteConfiguration = InstituteConfiguration::where('institute_id', $instituteId)->first();
        $institute = Institute::where('institute_id', $admin->institute_id)->first();
        $teacher = User::where('role_id',3)->get();
         $assignments = $teacher->teachingClasses()
            ->withPivot('subject_id')
            ->with('institute')
            ->orderBy('sort_order')
            ->get();
        //  dd($assignments);
        return response()->json([
            'success' => true,
            'message' => 'Institute Admin dashboard data retrieved successfully.',
            'data' => [
                'total_classes' => $totalClasses,
                'total_teachers' => $totalTeachers,
                'total_students' => $totalStudents,
                'total_subjects' => $totalSubjects,
                'instituteConfiguration' => $instituteConfiguration,
                'institute' => $institute,
                'assignments' => $assignments,

            ]
        ]);
    }
}