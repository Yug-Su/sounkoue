<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TontineController;
use App\Http\Controllers\Api\ContributionController;
use App\Http\Controllers\Api\DashboardController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    
    Route::apiResource('tontines', TontineController::class);
    Route::post('tontines/{tontine}/join', [TontineController::class, 'join']);
    Route::post('tontines/{tontine}/leave', [TontineController::class, 'leave']);
    Route::post('tontines/{tontine}/start', [TontineController::class, 'start']);
    
    Route::apiResource('contributions', ContributionController::class);
    Route::post('contributions/{contribution}/pay', [ContributionController::class, 'pay']);
});