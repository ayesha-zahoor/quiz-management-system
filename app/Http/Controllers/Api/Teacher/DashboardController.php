<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = request()->user();

        $teacher->load([
            'teachingClasses',
            'teachingSubjects',
            'institute.configuration',
        ]);

        $institute = $teacher->institute;
        $configuration = $institute?->configuration;

        $totalQuizzes = $teacher->createdQuizzes()->count();

        $publishedQuizzes = $teacher->createdQuizzes()
            ->where('is_published', true)
            ->count();

        $draftQuizzes = $teacher->createdQuizzes()
            ->where('is_published', false)
            ->count();

        $quizzes = Quiz::where('created_by', $teacher->id)
            ->with(['academicClass', 'questions'])
            ->latest()
            ->get();

        $classes = $teacher->teachingClasses;

        $subjects = $teacher->teachingSubjects;

        return response()->json([
            'success' => true,
            'message' => 'Teacher dashboard data retrieved successfully.',
            'data' => [
                'teacher' => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'profile_image' => $teacher->profile_image,
                ],

                'institute' => [
                    'id' => $institute?->id,
                    'name' => $institute?->name,
                    'logo' => $institute?->logo,
                    'status' => $institute?->status,
                ],

                'configuration' => [
                    'primary_color' => $configuration?->primary_color ?? '#84CC16',
                    'secondary_color' => $configuration?->secondary_color ?? '#365314',
                    'accent_color' => $configuration?->accent_color ?? '#A3E635',
                    'background_color' => $configuration?->background_color ?? '#F8FAFC',
                    'text_color' => $configuration?->text_color ?? '#1F2937',
                ],

                'total_quizzes' => $totalQuizzes,
                'published_quizzes' => $publishedQuizzes,
                'draft_quizzes' => $draftQuizzes,

                'classes' => $classes,
                'subjects' => $subjects,
                'quizzes' => $quizzes,
            ],
        ]);
    }
}
