<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteConfigurationController extends Controller
{
    public function show(Institute $institute)
    {
        $configuration = $institute->configuration;

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Institute configuration not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Institute configuration retrieved successfully.',
            'data' => $configuration
        ]);
    }

    public function update(Request $request, Institute $institute)
    {
        $validated = $request->validate([
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'background_color' => 'required|string|max:20',
            'text_color' => 'required|string|max:20',
        ]);

        $configuration = $institute->configuration;

        if (!$configuration) {
            $configuration = $institute->configuration()->create($validated);
        } else {
            $configuration->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Institute configuration updated successfully.',
            'data' => $configuration->fresh()
        ]);
    }
}