<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'app' => config('app.name'),
    'status' => 'Headless CMS API. See /api for endpoints.',
]));
