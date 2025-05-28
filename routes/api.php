<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpouseDetailController;
use App\Http\Controllers\PreferenceController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Authenticated User Routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Basic Details
    Route::get('/profile/basic', [ProfileController::class, 'showBasic']);
    Route::put('/profile/basic', [ProfileController::class, 'updateBasic']);

    // Additional Details
    Route::get('/profile/additional', [ProfileController::class, 'showAdditional']);
    Route::put('/profile/additional', [ProfileController::class, 'updateAdditional']);

    // Spouse Details
    Route::get('/spouse', [SpouseDetailController::class, 'show']);
    Route::put('/spouse', [SpouseDetailController::class, 'update']);

    // Preferences
    Route::get('/preferences', [PreferenceController::class, 'show']);
    Route::put('/preferences', [PreferenceController::class, 'update']);

    // Profile Image Upload
    Route::post('/profile/upload', [ProfileController::class, 'uploadImage']);

    Route::get('/user/is-married', [ProfileController::class, 'isMarried']);

});

