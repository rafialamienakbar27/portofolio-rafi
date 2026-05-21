<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Project::orderBy('order_column')->orderByDesc('year')->get()
        );
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($project);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);
        $project = Project::create($data);

        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $data = $this->validateData($request, $project->id);
        $project->update($data);

        return response()->json($project->fresh());
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,'.($ignoreId ?? 'NULL'),
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string|max:500',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:64',
            'demo_url' => 'nullable|url',
            'repo_url' => 'nullable|url',
            'category' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1990|max:'.(date('Y') + 1),
            'order_column' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);
    }
}
