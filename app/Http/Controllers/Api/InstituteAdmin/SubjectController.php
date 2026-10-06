<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::where('institute_id', $request->user()->institute_id)
            ->orderBy('name')
            ->get();

        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
        ]);

        $validated['institute_id'] = $request->user()->institute_id;

        $subject = Subject::create($validated);

        return response()->json([
            'message' => 'Subject created successfully.',
            'subject' => $subject,
        ], 201);
    }

    public function show(Request $request, Subject $subject)
    {
        if ($subject->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        return response()->json($subject);
    }

    public function update(Request $request, Subject $subject)
    {
        if ($subject->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
        ]);

        $subject->update($validated);

        return response()->json([
            'message' => 'Subject updated successfully.',
            'subject' => $subject,
        ]);
    }

    public function destroy(Request $request, Subject $subject)
    {
        if ($subject->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $subject->delete();

        return response()->json([
            'message' => 'Subject deleted successfully.'
        ]);
    }
}