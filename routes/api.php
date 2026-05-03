<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\AduanController;
use App\Http\Controllers\Api\AspirasiController;

// Public API routes
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes (memerlukan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::get('/agenda/{id}', [AgendaController::class, 'show']);
    Route::post('/agenda/{id}/comment', [AgendaController::class, 'comment']);
    Route::post('/agenda/{id}/like', [AgendaController::class, 'toggleLike']);

    // Aduan
    Route::post('/aduan', [AduanController::class, 'store']);
    Route::get('/aduan/history', [AduanController::class, 'history']);
    Route::get('/aduan/{id}', [AduanController::class, 'show']);

    // Aspirasi
    Route::get('/aspirasi/events', [AspirasiController::class, 'events']);
    Route::get('/aspirasi', [AspirasiController::class, 'index']);
    Route::get('/aspirasi/{id}', [AspirasiController::class, 'show']);
    Route::post('/aspirasi/{id}', [AspirasiController::class, 'store']);
    Route::post('/aspirasi/{id}/vote', [AspirasiController::class, 'vote']);
    Route::post('/aspirasi/{id}/comment', [AspirasiController::class, 'comment']);
});
