<?php

use App\Http\Controllers\Api\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public endpoints (no auth)
|--------------------------------------------------------------------------
*/
Route::prefix('public')->group(function () {
    Route::get('/bootstrap', [PublicController::class, 'bootstrap']);
    Route::get('/profile', [PublicController::class, 'profile']);
    Route::get('/experiences', [PublicController::class, 'experiences']);
    Route::get('/projects', [PublicController::class, 'projects']);
    Route::get('/projects/{slug}', [PublicController::class, 'projectShow']);
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin (Sanctum-protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Profile (singleton)
    Route::get('/profile', [AdminProfileController::class, 'show']);
    Route::put('/profile', [AdminProfileController::class, 'update']);

    // Experiences
    Route::apiResource('experiences', AdminExperienceController::class);

    // Projects
    Route::apiResource('projects', AdminProjectController::class);
});

Route::get('/health', fn () => response()->json(['status' => 'ok', 'time' => now()->toIso8601String()]));
