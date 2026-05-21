<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    /**
     * GET /api/public/profile
     */
    public function profile(): JsonResponse
    {
        $profile = Profile::singleton();

        return response()->json($profile);
    }

    /**
     * GET /api/public/experiences
     */
    public function experiences(): JsonResponse
    {
        $experiences = Experience::published()->ordered()->get();

        return response()->json($experiences);
    }

    /**
     * GET /api/public/projects
     */
    public function projects(): JsonResponse
    {
        $projects = Project::published()->ordered()->get();

        return response()->json($projects);
    }

    /**
     * GET /api/public/projects/{slug}
     */
    public function projectShow(string $slug): JsonResponse
    {
        $project = Project::published()->where('slug', $slug)->firstOrFail();

        return response()->json($project);
    }

    /**
     * GET /api/public/bootstrap
     * Endpoint agregat untuk halaman utama — one-shot fetch.
     */
    public function bootstrap(): JsonResponse
    {
        return response()->json([
            'profile' => Profile::singleton(),
            'experiences' => Experience::published()->ordered()->get(),
            'projects' => Project::published()->ordered()->get(),
        ]);
    }
}
