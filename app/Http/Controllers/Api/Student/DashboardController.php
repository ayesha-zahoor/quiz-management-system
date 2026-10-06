<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;

class DashboardController extends Controller
{
    public function index()
    {
        $student = request()->user();

        $totalAttempts = QuizAttempt::where('student_id', $student->id)->count();

        $completedAttempts = QuizAttempt::where('student_id', $student->id)
            ->where('status', 'completed')
            ->count();

        $inProgressAttempts = QuizAttempt::where('student_id', $student->id)
            ->where('status', 'in_progress')
            ->count();

        $availableQuizzes = Quiz::where('is_published', true)->count();

        return response()->json([
            'success' => true,
            'message' => 'Student dashboard data retrieved successfully.',
            'data' => [
                'available_quizzes' => $availableQuizzes,
                'total_attempts' => $totalAttempts,
                'completed_attempts' => $completedAttempts,
                'in_progress_attempts' => $inProgressAttempts,
            ]
        ]);
    }
}