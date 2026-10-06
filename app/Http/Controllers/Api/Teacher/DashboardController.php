<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = request()->user();

        $totalQuizzes = Quiz::where('created_by', $teacher->id)->count();

        $publishedQuizzes = Quiz::where('created_by', $teacher->id)
            ->where('is_published', true)
            ->count();

        $draftQuizzes = Quiz::where('created_by', $teacher->id)
            ->where('is_published', false)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Teacher dashboard data retrieved successfully.',
            'data' => [
                'total_quizzes' => $totalQuizzes,
                'published_quizzes' => $publishedQuizzes,
                'draft_quizzes' => $draftQuizzes,
            ]
        ]);
    }
}