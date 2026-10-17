<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\SchoolClass;
use App\Models\Subject;


class QuizController extends Controller
{
    public function index(Request $request)
{
    $teacher = $request->user();

    $quizzes = Quiz::with(['academicClass', 'subject'])
        ->withCount('questions')
        ->where('institute_id', $teacher->institute_id)
        ->where('created_by', $teacher->id)
        ->latest()
        ->get();

    return response()->json(['status' => true, 'message' => 'quizzes fetched', 'data' => $quizzes]);
}

public function unpublish(Request $request, Quiz $quiz)
{
    $teacher = $request->user();

    if ($quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
        return response()->json(['status' => false, 'message' => 'Quiz not found'], 404);
    }

    // Later: block this if students have already attempted the quiz
    $quiz->update(['is_published' => false]);

    return response()->json(['status' => true, 'message' => 'Quiz unpublished', 'data' => $quiz]);
}
    public function store(Request $request){
      $teacher=$request->user();
      $validated = $request->validate([
    'class_id' => 'required|integer|exists:classes,id',
    'subject_id' => 'required|integer|exists:subjects,id',
    'title' => 'required|string|max:255',
    'time_limit_minutes' => 'nullable|integer|min:1',
    'total_marks' => 'required|integer|min:0',
    'pass_marks' => 'required|integer|min:0',
]);
  $class = SchoolClass::where('id',$validated['class_id'])->where('institute_id',$teacher->institute_id)->first();
  if(!$class){
    return response()->json([
        'status'=>false,
        'message'=>'class not found',
    ]);
  }
   $subject = Subject::where('id',$validated['subject_id'])->where('institute_id',$teacher->institute_id)->first();
  if(!$subject){
    return response()->json([
        'status'=>false,
        'message'=>'subject not found',
    ]);
    }
    // dd($subject->id);
  $assigned = $teacher->teachingClasses()
  ->wherePivot('class_id',$class->id)
  ->wherePivot('subject_id',$subject->id)
  ->exists();
  if(!$assigned){
    return response()->json([
        'status'=>false,
        'message'=>'you are not assigned to this suject and class',
    ]);
  }
   $quiz = Quiz::create([
      'institute_id' => $teacher->institute_id,
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'created_by' => $teacher->id,
            'title' => $validated['title'],
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? null,
            'pass_marks' => $validated['pass_marks'],
            'total_marks' => $validated['total_marks'],
            'is_published' => false,
   ]);
   return response()->json([
      'status'=>true,
      'messgae'=>'quiz created successfully',
      'data'=>$quiz->load(['academicClass','subject'])
   ]);
    
}
public function show(Request $request, Quiz $quiz){
    $teacher = $request->user();
    if($quiz->institute_id !=$teacher->institute_id||$quiz->created_by != $teacher->id){
        return response()->json([
            'status'=>false,
            'message'=>'quiz not found'
        ]);
    }
    return response()->json([
        'status'=>true,
        'message'=>'quiz is here',
        'data'=>$quiz->load([
            'academicClass',
                'subject',
                'questions'
        ]),
    ]);

}
public function update(Request $request, Quiz $quiz){

  $teacher=$request->user();
    if($quiz->institute_id !=$teacher->institute_id||$quiz->created_by != $teacher->id){
        return response()->json([
            'status'=>false,
            'message'=>'quiz not found'
        ]);
    }
    $validated = $request->validate([
    'class_id' => 'required|integer|exists:classes,id',
    'subject_id' => 'required|integer|exists:subjects,id',
    'title' => 'required|string|max:255',
    'time_limit_minutes' => 'nullable|integer|min:1',
    'total_marks' => 'required|integer|min:0',
    'pass_marks' => 'required|integer|min:0',
]);
  $class = SchoolClass::where('id',$validated['class_id'])->where('institute_id',$teacher->institute_id)->first();
  if(!$class){
    return response()->json([
        'status'=>false,
        'message'=>'class not found',
    ]);
  }
   $subject = Subject::where('id',$validated['subject_id'])->where('institute_id',$teacher->institute_id)->first();
  if(!$subject){
    return response()->json([
        'status'=>false,
        'message'=>'subject not found',
    ]);
  }
  $assigned = $teacher->teachingClasses()->wherePivot('class_id',$class->id)->wherePivot('subject_id',$subject->id)->exists();
  if(!$assigned){
    return response()->json([
        'status'=>false,
        'message'=>'you are not assigned to this suject and class',
    ]);
  }
   $quiz->update([
      'institute_id' => $teacher->institute_id,
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'created_by' => $teacher->id,
            'title' => $validated['title'],
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? null,
            'pass_marks' => $validated['pass_marks'],
            'total_marks' => $validated['total_marks'],
            'is_published' => false,
   ]);
   return response()->json([
      'status'=>true,
      'messgae'=>'quiz updated successfully',
      'data'=>$quiz->load(['academicClass','subject'])
   ]);
}
public function publish(Request $request, Quiz $quiz)
{
    $teacher = $request->user();

    if ($quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
        return response()->json([
            'status' => false,
            'message' => 'Quiz not found'
        ], 404);
    }

    if ($quiz->is_published) {
        return response()->json([
            'status' => false,
            'message' => 'Quiz is already published'
        ], 422);
    }

    $questions = $quiz->questions()->with('options')->get();

    if ($questions->count() == 0) {
        return response()->json([
            'status' => false,
            'message' => 'Quiz must have at least one question'
        ], 422);
    }

    foreach ($questions as $question) {

        if ($question->options->count() < 2) {
            return response()->json([
                'status' => false,
                'message' => 'Every question must have at least two options'
            ], 422);
        }

        $correctOptions = $question->options->where('is_correct', true)->count();

        if ($correctOptions != 1) {
            return response()->json([
                'status' => false,
                'message' => 'Every question must have exactly one correct option'
            ], 422);
        }
    }

    $totalQuestionMarks = $questions->sum('marks_per_question');

    if ($totalQuestionMarks != $quiz->total_marks) {
        return response()->json([
            'status' => false,
            'message' => 'Question marks do not match quiz total marks',
            'quiz_total_marks' => $quiz->total_marks,
            'question_total_marks' => $totalQuestionMarks
        ], 422);
    }

    $quiz->update([
        'is_published' => true
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Quiz published successfully',
        'data' => $quiz
    ]);
}
public function destroy(Request $request, Quiz $quiz){
     $teacher=$request->user();
    if($quiz->institute_id!=$teacher->institute_id||$quiz->created_by!=$teacher->id){
        return response()->json([
            'status'=>false,
            'message'=>'quiz not found'
        ]);
}
         $quiz->delete();
      
        return response()->json([
            'status'=>true,
            'message'=>'quiz  has been deleted',
        ]);

}
public function results(Request $request, Quiz $quiz)
{
    $teacher = $request->user();

    abort_unless(
        $quiz->institute_id === $teacher->institute_id && $quiz->teacher_id === $teacher->id,
        404
    );

    $total = max((int) $quiz->total_marks, 1);

    $attempts = QuizAttempt::with('student:id,name,student_roll_no')
        ->where('quiz_id', $quiz->id)
        ->where('status', 'completed')
        ->latest()
        ->get();

    $rows = $attempts->map(fn ($a) => [
        'student'    => $a->student?->name,
        'roll_no'    => $a->student?->student_roll_no,
        'score'      => $a->score,
        'percentage' => round($a->score / $total * 100, 1),
        'result'     => $a->score >= $quiz->pass_marks ? 'Passed' : 'Failed',
        'date'       => $a->updated_at,
    ]);

    // Students in the quiz's class who have not finished it
    $classStudentIds = DB::table('class_student')->where('class_id', $quiz->class_id)->pluck('student_id');
    $pending = User::whereIn('id', $classStudentIds)
        ->whereNotIn('id', $attempts->pluck('student_id'))
        ->get(['id', 'name', 'student_roll_no']);

    return response()->json([
        'success' => true,
        'data' => [
            'quiz'    => $quiz->only('id', 'title', 'total_marks', 'pass_marks'),
            'stats'   => [
                'attempts'  => $rows->count(),
                'average'   => round($rows->avg('percentage') ?? 0, 1),
                'highest'   => $rows->max('percentage') ?? 0,
                'lowest'    => $rows->min('percentage') ?? 0,
                'pass_rate' => $rows->count() ? round($rows->where('result', 'Passed')->count() / $rows->count() * 100) : 0,
            ],
            'results' => $rows->values(),
            'pending' => $pending,
        ],
    ]);
}
}
