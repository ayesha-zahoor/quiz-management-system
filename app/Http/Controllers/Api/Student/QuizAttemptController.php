<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function getQuiz(Request $request, User $student){
        $student = $request->user();
        // dd($student->role->role_name);
        if(!$student->role||$student->role->role_name !='student'){
            return response()->json([
                'ststau'=>false,
                'message'=>'student access required',
            ]);
        }
    
        $class=$student->studentClasses()->first();
          if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Student is not assigned to any class.'
            ], 404);
        }
       
        $quizzes= Quiz::with(['academicClass','subject'])
        ->where('class_id',$class->id)
        ->where('institute_id',$student->institute_id)
        ->where('is_published',true)
        ->get();
           return response()->json([
            'success' => true,
            'class' => $class,
            'quizzes' => $quizzes
        ]);
    }

public function start(Request $request, Quiz $quiz)
{
    $student = $request->user();

    if (!$student->role || $student->role->role_name != 'student') {
        return response()->json([
            'status' => false,
            'message' => 'Student access required',
        ], 403);
    }

    $isStudentInClass = $student->studentClasses()
        ->where('classes.id', $quiz->class_id)
        ->exists();

    if (!$isStudentInClass) {
        return response()->json([
            'status' => false,
            'message' => 'You are not enrolled in this class',
        ], 403);
    }

    if (!$quiz->is_published) {
        return response()->json([
            'status' => false,
            'message' => 'This quiz is not published yet.',
        ], 403);
    }

    $completedAttempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $student->id)
        ->where('status', 'completed')
        ->first();

    if ($completedAttempt) {
        return response()->json([
            'status' => false,
            'message' => 'You have already completed this quiz.',
        ], 422);
    }

    $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $student->id)
        ->where('status', 'in_progress')
        ->first();

    if ($existingAttempt) {
        $quiz->load('questions.options');

        return response()->json([
            'status' => true,
            'message' => 'You already have an active attempt for this quiz.',
            'attempt' => $existingAttempt,
            'quiz' => $quiz,
        ]);
    }

    $attempt = QuizAttempt::create([
        'quiz_id' => $quiz->id,
        'student_id' => $student->id,
        'score' => 0,
        'status' => 'in_progress',
        'started_at' => now(),
    ]);

    $quiz->load('questions.options');

    return response()->json([
        'status' => true,
        'message' => 'Quiz started successfully.',
        'attempt' => $attempt,
        'quiz' => $quiz,
    ], 201);
}


}
