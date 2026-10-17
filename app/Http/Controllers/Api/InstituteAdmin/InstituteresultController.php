<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstituteresultController extends Controller
{
    private function pct($score, $total): float
    {
        return $total > 0 ? round(($score / $total) * 100, 1) : 0;
    }

    // attempts, average and pass rate for a group of result rows
    private function summarise($rows): array
    {
        $count = $rows->count();

        return [
            'attempts'  => $count,
            'average'   => $count ? round($rows->avg('percentage'), 1) : 0,
            'pass_rate' => $count ? (int) round($rows->where('passed', true)->count() / $count * 100) : 0,
        ];
    }

    /**
     * GET /api/instituteAdmin/results?class_id=&quiz_id=
     */
    public function index(Request $request)
    {
        $admin   = $request->user();
        $classId = $request->integer('class_id') ?: null;
        $quizId  = $request->integer('quiz_id') ?: null;

        $allQuizzes = Quiz::where('institute_id', $admin->institute_id)
            ->get(['id', 'title', 'class_id', 'total_marks', 'pass_marks']);

        $classes = DB::table('classes')
            ->where('institute_id', $admin->institute_id)
            ->orderBy('class_name')
            ->get(['id', 'class_name']);

        $classNames = $classes->pluck('class_name', 'id');

        // Apply the filters
        $quizzes = $allQuizzes
            ->when($classId, fn ($c) => $c->where('class_id', $classId))
            ->when($quizId, fn ($c) => $c->where('id', $quizId))
            ->keyBy('id');

        $attempts = QuizAttempt::whereIn('quiz_id', $quizzes->keys())
            ->where('status', 'completed')
            ->orderByDesc('updated_at')
            ->get();

        $students = User::whereIn('id', $attempts->pluck('student_id')->unique())
            ->get(['id', 'name', 'student_roll_no'])
            ->keyBy('id');

        // One flat list of results, everything below is built from it
        $rows = $attempts->map(function ($a) use ($quizzes, $students, $classNames) {
            $quiz = $quizzes[$a->quiz_id];

            return [
                'student_id'  => $a->student_id,
                'student'     => $students->get($a->student_id)?->name ?? 'Unknown student',
                'roll_no'     => $students->get($a->student_id)?->student_roll_no,
                'quiz_id'     => $quiz->id,
                'quiz'        => $quiz->title,
                'class_id'    => $quiz->class_id,
                'class_name'  => $classNames->get($quiz->class_id),
                'score'       => $a->score,
                'total'       => $quiz->total_marks,
                'percentage'  => $this->pct($a->score, $quiz->total_marks),
                'passed'      => $a->score >= $quiz->pass_marks,
                'date'        => $a->updated_at,
            ];
        })->values();

        $byClass = $rows->groupBy('class_id')->map(function ($group) {
            return ['class_name' => $group->first()['class_name'] ?? 'No class']
                + $this->summarise($group)
                + ['students' => $group->pluck('student_id')->unique()->count()];
        })->sortByDesc('average')->values();

        $byQuiz = $rows->groupBy('quiz_id')->map(function ($group) {
            return ['quiz' => $group->first()['quiz'], 'class_name' => $group->first()['class_name']]
                + $this->summarise($group);
        })->sortByDesc('attempts')->values();

        $topStudents = $rows->groupBy('student_id')->map(function ($group) {
            return [
                'student'  => $group->first()['student'],
                'roll_no'  => $group->first()['roll_no'],
                'attempts' => $group->count(),
                'average'  => round($group->avg('percentage'), 1),
            ];
        })->sortByDesc('average')->take(5)->values();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $this->summarise($rows) + [
                    'students' => $rows->pluck('student_id')->unique()->count(),
                ],
                'by_class'     => $byClass,
                'by_quiz'      => $byQuiz,
                'top_students' => $topStudents,
                'recent'       => $rows->take(8)->values(),
                'filters'      => [
                    'classes' => $classes,
                    'quizzes' => $allQuizzes->map(fn ($q) => $q->only('id', 'title', 'class_id'))->values(),
                ],
            ],
        ]);
    }
}