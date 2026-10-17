<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

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
            'question_text'      => 'required|string',
            'marks_per_question' => 'required|integer|min:1',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'audio'              => 'nullable|file|mimes:mp3,wav,ogg,m4a,mp4,webm|max:5120',
        ]);

        $question = Question::create([
            'quiz_id'            => $quiz->id,
            'question_text'      => $validated['question_text'],
            'image_url'          => $this->saveUpload($request, 'image', 'question_images'),
            'tts_audio_url'      => $this->saveUpload($request, 'audio', 'question_audio'),
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
            'question_text'      => 'required|string',
            'marks_per_question' => 'required|integer|min:1',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'audio'              => 'nullable|file|mimes:mp3,wav,ogg,m4a,mp4,webm|max:5120',
            'remove_image'       => 'sometimes|boolean',
            'remove_audio'       => 'sometimes|boolean',
        ]);

        // Only these two always change. The picture and audio change ONLY when the teacher
        // chose a new file or pressed Remove, so editing the text never wipes them.
        $changes = [
            'question_text'      => $validated['question_text'],
            'marks_per_question' => $validated['marks_per_question'],
        ];

        if ($request->hasFile('image')) {
            $this->deleteUpload($question->image_url);   // the old picture goes
            $changes['image_url'] = $this->saveUpload($request, 'image', 'question_images');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteUpload($question->image_url);
            $changes['image_url'] = null;
        }

        if ($request->hasFile('audio')) {
            $this->deleteUpload($question->tts_audio_url);
            $changes['tts_audio_url'] = $this->saveUpload($request, 'audio', 'question_audio');
        } elseif ($request->boolean('remove_audio')) {
            $this->deleteUpload($question->tts_audio_url);
            $changes['tts_audio_url'] = null;
        }

        $question->update($changes);

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

        // Remove the files too, so nothing is left behind on the disk
        foreach ($question->options as $option) {
            $this->deleteUpload($option->image_url);
        }

        $this->deleteUpload($question->image_url);
        $this->deleteUpload($question->tts_audio_url);

        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully'
        ]);
    }

    // Saves an uploaded file and returns its site path, such as /storage/question_images/abc.jpg
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