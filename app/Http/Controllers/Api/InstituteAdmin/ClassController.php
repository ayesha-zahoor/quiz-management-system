<?php

namespace App\Http\Controllers\Api\InstituteAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::where('institute_id', $request->user()->institute_id)
            ->orderBy('sort_order')
            ->get();

        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:100',
            'group' => 'required|string|max:50',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['institute_id'] = $request->user()->institute_id;

        $class = SchoolClass::create($validated);

        return response()->json([
            'message' => 'Class created successfully.',
            'class' => $class,
        ], 201);
    }

    public function show(Request $request, SchoolClass $class)
    {
        if ($class->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        return response()->json($class);
    }

    public function update(Request $request, SchoolClass $class)
    {
        if ($class->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $validated = $request->validate([
            'class_name' => 'required|string|max:100',
            'group' => 'required|string|max:50',
            'sort_order' => 'required|integer|min:0',
        ]);

        $class->update($validated);

        return response()->json([
            'message' => 'Class updated successfully.',
            'class' => $class,
        ]);
    }

    public function destroy(Request $request, SchoolClass $class)
    {
        if ($class->institute_id !== $request->user()->institute_id) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $class->delete();

        return response()->json([
            'message' => 'Class deleted successfully.'
        ]);
    }
}