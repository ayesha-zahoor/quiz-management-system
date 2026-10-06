<?php

namespace App\Http\Controllers\API\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function store(Request $request, Question $question)
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
            'option_text' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'is_correct' => 'required|boolean',
        ]);

        if ($validated['is_correct'] == true) {
            $existingCorrectOption = $question->options()
                ->where('is_correct', true)
                ->exists();

            if ($existingCorrectOption) {
                return response()->json([
                    'status' => false,
                    'message' => 'This question already has a correct option'
                ], 422);
            }
        }

        $option = Option::create([
            'question_id' => $question->id,
            'option_text' => $validated['option_text'],
            'image_url' => $validated['image_url'] ?? null,
            'is_correct' => $validated['is_correct'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Option created successfully',
            'data' => $option
        ], 201);
    }

    public function index(Request $request, Question $question)
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
            'message' => 'Options retrieved successfully',
            'data' => $question->options
        ]);
    }
    public function show(Request $request, Option $option)
{
    $teacher = $request->user();

    $question = $option->question;
    $quiz = $question->quiz;

    if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
        return response()->json([
            'status' => false,
            'message' => 'Option not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Option retrieved successfully',
        'data' => $option
    ]);
}

public function update(Request $request, Option $option)
{
    $teacher = $request->user();

    $question = $option->question;
    $quiz = $question->quiz;

    if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
        return response()->json([
            'status' => false,
            'message' => 'Option not found'
        ], 404);
    }

    if ($quiz->is_published) {
        return response()->json([
            'status' => false,
            'message' => 'Published quiz cannot be modified'
        ], 403);
    }

    $validated = $request->validate([
        'option_text' => 'required|string',
        'image_url' => 'nullable|string|max:255',
        'is_correct' => 'required|boolean',
    ]);

    if ($validated['is_correct'] == true) {
        $existingCorrectOption = $question->options()
            ->where('is_correct', true)
            ->where('id', '!=', $option->id)
            ->exists();

        if ($existingCorrectOption) {
            return response()->json([
                'status' => false,
                'message' => 'This question already has another correct option'
            ], 422);
        }
    }

    $option->update([
        'option_text' => $validated['option_text'],
        'image_url' => $validated['image_url'] ?? null,
        'is_correct' => $validated['is_correct'],
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Option updated successfully',
        'data' => $option
    ]);
}

public function destroy(Request $request, Option $option)
{
    $teacher = $request->user();

    $question = $option->question;
    $quiz = $question->quiz;

    if (!$quiz || $quiz->institute_id != $teacher->institute_id || $quiz->created_by != $teacher->id) {
        return response()->json([
            'status' => false,
            'message' => 'Option not found'
        ], 404);
    }

    if ($quiz->is_published) {
        return response()->json([
            'status' => false,
            'message' => 'Published quiz cannot be modified'
        ], 403);
    }

    $option->delete();

    return response()->json([
        'status' => true,
        'message' => 'Option deleted successfully'
    ]);
}
}