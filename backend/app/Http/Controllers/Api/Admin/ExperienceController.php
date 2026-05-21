<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Experience::orderBy('order_column')->orderByDesc('start_date')->get()
        );
    }

    public function show(Experience $experience): JsonResponse
    {
        return response()->json($experience);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);
        $experience = Experience::create($data);

        return response()->json($experience, 201);
    }

    public function update(Request $request, Experience $experience): JsonResponse
    {
        $data = $this->validateData($request, $experience->id);
        $experience->update($data);

        return response()->json($experience->fresh());
    }

    public function destroy(Experience $experience): JsonResponse
    {
        $experience->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'company' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:64',
            'company_url' => 'nullable|url',
            'order_column' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
    }
}
