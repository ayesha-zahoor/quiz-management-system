<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;


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
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_correct'  => 'required|boolean',
        ]);

        // The form sends is_correct as "1" or "0", so read it as a real true/false
        $isCorrect = $request->boolean('is_correct');

        if ($isCorrect) {
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
            'image_url'   => $this->saveUpload($request, 'image', 'option_images'),
            'is_correct'  => $isCorrect,
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
            'option_text'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'sometimes|boolean',
            'is_correct'   => 'required|boolean',
        ]);

        $isCorrect = $request->boolean('is_correct');

        if ($isCorrect) {
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

        // The picture changes ONLY when a new one was chosen or Remove was pressed
        $changes = [
            'option_text' => $validated['option_text'],
            'is_correct'  => $isCorrect,
        ];

        if ($request->hasFile('image')) {
            $this->deleteUpload($option->image_url);
            $changes['image_url'] = $this->saveUpload($request, 'image', 'option_images');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteUpload($option->image_url);
            $changes['image_url'] = null;
        }

        $option->update($changes);

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

        $this->deleteUpload($option->image_url);

        $option->delete();

        return response()->json([
            'status' => true,
            'message' => 'Option deleted successfully'
        ]);
    }

    // Saves an uploaded file and returns its site path, such as /storage/option_images/abc.jpg
    private function saveUpload(Request $request, string $field, string $folder): ?string
    {
        return $request->hasFile($field)
            ? '/storage/' . $request->file($field)->store($folder, 'public')
            : null;
    }

    private function deleteUpload(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/')) {
            Storage::disk('public')->delete(substr($url, strlen('/storage/')));
        }
    }
}