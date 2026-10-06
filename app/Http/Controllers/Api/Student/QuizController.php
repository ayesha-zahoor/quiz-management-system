<?php

namespace App\Http\Controllers\API\Student;


use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user();

        $quizzes = Quiz::with([
            'academicClass',
            'subject'
        ])
        ->where('institute_id', $student->institute_id)
        ->where('class_id', $student->class_id)
        ->where('is_published', true)
        ->latest()
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Available quizzes retrieved successfully',
            'data' => $quizzes
        ]);
    }
    
}