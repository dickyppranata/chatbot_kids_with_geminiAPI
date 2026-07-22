<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\TopicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Chatbot Edukasi Anak SD
|--------------------------------------------------------------------------
|
| Semua route di bawah ini di-prefix dengan /api secara otomatis oleh Laravel.
|
*/

// =========================================================================
// AUTHENTICATION (Public - Tidak perlu login)
// =========================================================================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login',    [AuthController::class, 'login'])->name('auth.login');
});

// =========================================================================
// PROTECTED ROUTES (Memerlukan token Sanctum)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {

    // --- Auth ---
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/me',      [AuthController::class, 'me'])->name('auth.me');

    // --- Topics ---
    Route::get('/topics',       [TopicController::class, 'index'])->name('topics.index');

    // -------------------------------------------------------------------------
    // CHAT AI (Untuk user 'anak')
    // -------------------------------------------------------------------------
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('/',                        [ChatController::class, 'send'])->name('send');
        Route::get('/history',                  [ChatController::class, 'history'])->name('history');
        Route::get('/history/{session_id}',     [ChatController::class, 'sessionMessages'])->name('session');
    });
});
