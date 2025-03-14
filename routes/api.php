<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Middleware\ApiJsonResponseMiddleware;
use App\Http\Controllers\ProjectUserController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', ApiJsonResponseMiddleware::class])->group(function () {
    Route::get("user/me", [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);


    Route::apiResource('project', ProjectController::class);
    Route::apiResource('project_user', controller: ProjectUserController::class);
    Route::apiResource('attribute', AttributeController::class);
    Route::apiResource('timesheet', TimesheetController::class);
});
