<?php

namespace App\Http\Controllers\Api\Teacher;
 
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherResultController extends Controller
{
  private const OWNER_COLUMN = 'created_by';
 
    private function pct($score, $total): float
    {
        return $total > 0 ? round(($score / $total) * 100, 1) : 0;
    }
 
    /**
     * GET /api/teacher/results
     * One row per quiz of this teacher, with attempts, average and pass rate.
     */
    public function index(Request $request)
    {
        $teacher = $request->user();
 
        $quizzes = Quiz::where('institute_id', $teacher->institute_id)
            ->where(self::OWNER_COLUMN, $teacher->id)
            ->latest()
            ->get();
 
        $classNames = DB::table('classes')
            ->whereIn('id', $quizzes->pluck('class_id')->filter()->unique())
            ->pluck('class_name', 'id');
 
        $attempts = QuizAttempt::whereIn('quiz_id', $quizzes->pluck('id'))
            ->where('status', 'completed')
            ->get()
            ->groupBy('quiz_id');
 
        $rows = $quizzes->map(function ($quiz) use ($attempts, $classNames) {
            $list   = $attempts->get($quiz->id, collect());
            $count  = $list->count();
            $passed = $list->filter(fn ($a) => $a->score >= $quiz->pass_marks)->count();
 
            return [
                'id'           => $quiz->id,
                'title'        => $quiz->title,
                'class_name'   => $classNames->get($quiz->class_id),
                'is_published' => (bool) ($quiz->is_published ?? false),
                'attempts'     => $count,
                'average'      => $count ? round($list->avg(fn ($a) => $this->pct($a->score, $quiz->total_marks)), 1) : 0,
                'pass_rate'    => $count ? (int) round($passed / $count * 100) : 0,
                'passed'       => $passed,
            ];
        })->values();
 
        $totalAttempts = $rows->sum('attempts');
 
        return response()->json([
            'success' => true,
            'data' => [
                'stats' => [
                    'quizzes'   => $rows->count(),
                    'attempts'  => $totalAttempts,
                    'average'   => $totalAttempts ? round($rows->sum(fn ($r) => $r['average'] * $r['attempts']) / $totalAttempts, 1) : 0,
                    'pass_rate' => $totalAttempts ? (int) round($rows->sum('passed') / $totalAttempts * 100) : 0,
                ],
                'quizzes' => $rows,
            ],
        ]);
    }
 
    /**
     * GET /api/teacher/results/{quiz}
     * Every student's result for one quiz, plus the students who have not finished it.
     */
    public function show(Request $request, Quiz $quiz)
    {
        $teacher = $request->user();
 
        abort_unless(
            (int) $quiz->institute_id === (int) $teacher->institute_id
            && (int) $quiz->{self::OWNER_COLUMN} === (int) $teacher->id,
            404
        );
 
        $total = (int) $quiz->total_marks;
 
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('status', 'completed')
            ->orderByDesc('updated_at')
            ->get();
 
        $students = User::whereIn('id', $attempts->pluck('student_id')->unique())
            ->get(['id', 'name', 'student_roll_no'])
            ->keyBy('id');
 
        $rows = $attempts->map(fn ($a) => [
            'student'    => $students->get($a->student_id)?->name ?? 'Unknown student',
            'roll_no'    => $students->get($a->student_id)?->student_roll_no,
            'score'      => $a->score,
            'percentage' => $this->pct($a->score, $total),
            'passed'     => $a->score >= $quiz->pass_marks,
            'date'       => $a->updated_at,
        ])->values();
 
        // Score ranges: 0-20, 21-40, 41-60, 61-80, 81-100
        $buckets = [0, 0, 0, 0, 0];
        foreach ($rows as $row) {
            $buckets[min((int) floor($row['percentage'] / 20), 4)]++;
        }
 
        // Students of this quiz's class who have no completed attempt
$inProgressIds = QuizAttempt::where('quiz_id', $quiz->id)
    ->where('status', 'in_progress')
    ->pluck('student_id');

$pending = User::whereHas('studentClasses', fn ($q) => $q->whereKey($quiz->class_id))
    ->whereNotIn('id', $attempts->pluck('student_id'))
    ->orderBy('name')
    ->get(['id', 'name', 'student_roll_no'])
    ->map(fn ($s) => [
        'name'    => $s->name,
        'roll_no' => $s->student_roll_no,
        'status'  => $inProgressIds->contains($s->id) ? 'In progress' : 'Not started',
    ])->values();
 
        $count = $rows->count();
 
        return response()->json([
            'success' => true,
            'data' => [
                'quiz' => [
                    'id'          => $quiz->id,
                    'title'       => $quiz->title,
                    'total_marks' => $total,
                    'pass_marks'  => $quiz->pass_marks,
                ],
                'stats' => [
                    'attempts'  => $count,
                    'average'   => $count ? round($rows->avg('percentage'), 1) : 0,
                    'highest'   => $count ? $rows->max('percentage') : 0,
                    'lowest'    => $count ? $rows->min('percentage') : 0,
                    'pass_rate' => $count ? (int) round($rows->where('passed', true)->count() / $count * 100) : 0,
                ],
                'buckets' => $buckets,
                'results' => $rows,
                'pending' => $pending,
            ],
        ]);
    }
}
