<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function getQuiz(Request $request)
    {
        $student = $request->user();
        // dd($student->id);

        $student->load('institute.configuration');

        $classIds = DB::table('class_student')
            ->where('user_id', $student->id)
            ->pluck('class_id');

        $quizzes = Quiz::with(['academicClass', 'subject'])
            ->where('institute_id', $student->institute_id)
            ->where('is_published', true)
            ->whereIn('class_id', $classIds)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($quiz) use ($student) {
                $attempt = QuizAttempt::where('student_id', $student->id)
                    ->where('quiz_id', $quiz->id)
                    ->whereIn('status', ['in_progress', 'completed'])
                    ->latest()
                    ->first();
                    
                    return [
                        'id' => $quiz->id,
                    'title' => $quiz->title,
                    'time_limit_minutes' => $quiz->time_limit_minutes,
                    'total_marks' => $quiz->total_marks,
                    'pass_marks' => $quiz->pass_marks,
                    'class_id' => $quiz->class_id,
                    'class_name' => $quiz->academicClass?->class_name,
                    'class_group' => $quiz->academicClass?->group,
                    'subject_id' => $quiz->subject_id,
                    'subject_name' => $quiz->subject?->name,
                    'attempt_status' => $attempt?->status,
                    'attempt_id' => $attempt?->id,
                ];
            });

        $institute = $student->institute;
        $configuration = $institute?->configuration;

        return response()->json([
            'success' => true,
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'profile_image' => $student->profile_image,
                ],
                'institute' => [
                    'id' => $institute?->id,
                    'name' => $institute?->name,
                    'logo' => $institute?->logo,
                ],
                'configuration' => $configuration ? [
                    'primary_color' => $configuration->primary_color,
                    'secondary_color' => $configuration->secondary_color,
                    'accent_color' => $configuration->accent_color,
                    'background_color' => $configuration->background_color,
                    'text_color' => $configuration->text_color,
                ] : null,
                'quizzes' => $quizzes,
            ],
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
    if ($quiz->institute_id != $student->institute_id) {
    return response()->json([
        'status' => false,
        'message' => 'This quiz does not belong to your institute.',
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

    $quiz->load([
    'questions' => function ($query) {
        $query->select(
            'id',
            'quiz_id',
            'question_text',
            'image_url',
            'tts_audio_url',
            'marks_per_question'
        );
    },
    'questions.options' => function ($query) {
        $query->select(
            'id',
            'question_id',
            'option_text'
        );
    }
]);

    return response()->json([
        'status' => true,
        'message' => 'Quiz started successfully.',
        'attempt' => $attempt,
        'quiz' => $quiz,
    ], 201);
}
public function show(Request $request, $attemptId)
{
    $student = $request->user();

    $attempt = QuizAttempt::with([
        'quiz.questions.options',
        'quiz.academicClass',
        'quiz.subject',
    ])
        ->where('id', $attemptId)
        ->where('student_id', $student->id)
        ->first();

    if (!$attempt) {
        return response()->json([
            'status' => false,
            'message' => 'Quiz attempt not found.',
        ], 404);
    }

    if ($attempt->status !== 'in_progress') {
        return response()->json([
            'status' => false,
            'message' => 'This quiz attempt is no longer in progress.',
        ], 422);
    }

    return response()->json([
        'status' => true,
        'attempt' => $attempt,
        'quiz' => $attempt->quiz,
    ]);
}


}
