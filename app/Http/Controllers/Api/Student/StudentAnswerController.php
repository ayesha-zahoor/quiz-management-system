<?php

namespace App\Http\Controllers\API\Student;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\StudentAnswer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentAnswerController extends Controller
{
    public function store(Request $request){
        $student = $request->user();
        // dd($student);
         $validated = $request->validate([
        'attempt_id' => 'required|integer|exists:quiz_attempts,id',
        'question_id' => 'required|integer|exists:questions,id',
        'selected_option_id' => 'required|integer|exists:options,id',
    ]);
    $quizAttempt = QuizAttempt::find($validated['attempt_id']);
     if($quizAttempt->student_id != $student->id){
        return response()->json([
            'status'=>false,
            'message'=>'you are not allowed to submit this attempt'
        ]);
     }
    $option = Option::find($validated['selected_option_id']);
    if($option->question_id != $validated['question_id']){
         return response()->json([
            'status'=>false,
            'message'=>'option is not selected correctly'
        ]);
    }
    $question = Question::find($validated['question_id']);
    if ($question->quiz_id != $quizAttempt->quiz_id) {
    return response()->json([
        'status' => false,
        'message' => 'This question does not belong to this quiz.'
    ], 422);
}
   if ($quizAttempt->status != 'in_progress'){
     return response()->json([
        'status' => false,
        'message' => 'You cannot submit an answer for this quiz attempt.'
    ], 422);
   }
    $alreadySelectedAnswer=StudentAnswer::where('attempt_id',$request->attempt_id)->where('question_id',$request->question_id)->first();
    if($alreadySelectedAnswer){
        $alreadySelectedAnswer->update([
        'selected_option_id'=>$validated['selected_option_id'],
        ]);
         $answer = $alreadySelectedAnswer;
    }
    else{
       $answer = StudentAnswer::create([
        'attempt_id'=>$validated['attempt_id'],
        'question_id'=>$validated['question_id'],
        'selected_option_id'=>$validated['selected_option_id'],
    ]);
    }
   
    return response()->json([
        'status'=>true,
        'message'=>'answer is submitted',
        'data'=>$answer
    ]);
    }
    public function submit(Request $request){
        $student =$request->user();
        $validated = $request->validate([
        'attempt_id' => 'required|integer|exists:quiz_attempts,id',
    ]);

        $quizAttempt=QuizAttempt::find($validated['attempt_id']);
        if($quizAttempt->student_id != $student->id){
            return response()->json([
                'status'=>false,
                'message'=>'the staduent is not matched'
            ]);
        }
        if($quizAttempt->status != 'in_progress'){
            return response()->json([
                'status'=>false,
                'message'=>'this quiz has been already submitted',
            ],405);
        }
        $answers = StudentAnswer::where('attempt_id', $quizAttempt->id)->with('option')->get();
       $score = 0;
       foreach ($answers as $answer) {
        if($answer->option->is_correct)
{
         $score += $answer->question->marks_per_question;
}       }
       $quiz = $quizAttempt->quiz;
       $quizAttempt->update([
        'score'=>$score,
        'status'=>'completed',
        'completed_at'=>now()
       ]);
        return response()->json([
        'status' => true,
        'message' => 'Quiz submitted successfully.',
        'data' => [
            'attempt_id' => $quizAttempt->id,
            'score' => $score,
            'total_marks' => $quiz->total_marks,
            'pass_marks' => $quiz->pass_marks,
            'percentage' => $quiz->total_marks > 0
                ? round(($score / $quiz->total_marks) * 100, 2)
                : 0,
            'result' => $score >= $quiz->pass_marks ? 'Passed' : 'Failed',
        ]
    ]);
    }
    public function result(Request $request, Quiz $quiz){
        $student = $request->user();
        // dd($quiz->id);
        
        $quizAttempt = QuizAttempt::where('quiz_id',$quiz->id)->where('student_id',$student->id)->where('status','completed')->first();
        $score=$quizAttempt->score;
        // dd($score);
        return response()->json([
            'status'=>true,
            'data'=>[
                'score'=>$score,
                'total_marks'=>$quiz->total_marks,
                'pass_marks'=>$quiz->pass_marks,
                'percentage' => $quiz->total_marks > 0
                ? round(($quizAttempt->score / $quiz->total_marks) * 100, 2)
                : 0,
                'result' => $quizAttempt->score >= $quiz->pass_marks ? 'Passed' : 'Failed',
            ],
        ]);
    }

    
}
