<?php

namespace App\Http\Controllers\API\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
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
                'message' => 'Published quiz cannot be modified'
            ], 403);
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'tts_audio_url' => 'nullable|string|max:255',
            'marks_per_question' => 'required|integer|min:1',
        ]);

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'image_url' => $validated['image_url'] ?? null,
            'tts_audio_url' => $validated['tts_audio_url'] ?? null,
            'marks_per_question' => $validated['marks_per_question'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Question created successfully',
            'data' => $question
        ], 201);
    }

    public function index(Request $request, Quiz $quiz)
    {
        $teacher = $request->user();

        if ($quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Questions retrieved successfully',
            'data' => $quiz->questions()->with('options')->get()
        ]);
    }

    public function show(Request $request, Question $question)
    {
        $teacher = $request->user();

        $quiz = $question->quiz;

        if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Question retrieved successfully',
            'data' => $question->load('options')
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $teacher = $request->user();

        $quiz = $question->quiz;

        if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found'
            ], 404);
        }

        if ($quiz->is_published) {
            return response()->json([
                'status' => false,
                'message' => 'Published quiz cannot be modified'
            ], 403);
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'tts_audio_url' => 'nullable|string|max:255',
            'marks_per_question' => 'required|integer|min:1',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'image_url' => $validated['image_url'] ?? null,
            'tts_audio_url' => $validated['tts_audio_url'] ?? null,
            'marks_per_question' => $validated['marks_per_question'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Question updated successfully',
            'data' => $question
        ]);
    }

    public function destroy(Request $request, Question $question)
    {
        $teacher = $request->user();

        $quiz = $question->quiz;

        if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found'
            ], 404);
        }

        if ($quiz->is_published) {
            return response()->json([
                'status' => false,
                'message' => 'Published quiz cannot be modified'
            ], 403);
        }

        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully'
        ]);
    }
}