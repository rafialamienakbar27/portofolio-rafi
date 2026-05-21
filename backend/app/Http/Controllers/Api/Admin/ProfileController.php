<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * GET /api/admin/profile
     */
    public function show(): JsonResponse
    {
        return response()->json(Profile::singleton());
    }

    /**
     * PUT /api/admin/profile
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:32',
            'location' => 'nullable|string|max:255',
            'avatar_url' => 'nullable|url',
            'cv_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'hero_tagline' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*.category' => 'required_with:skills|string',
            'skills.*.items' => 'required_with:skills|array',
        ]);

        $profile = Profile::singleton();
        $profile->update($data);

        return response()->json($profile->fresh());
    }
}
