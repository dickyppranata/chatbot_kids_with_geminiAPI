<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FavoriteController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TopicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - AI Buddy Chatbot Edukasi Fullstack
|--------------------------------------------------------------------------
|
| Seluruh route web fullstack. Autentikasi menggunakan session cookie.
| Halaman dilindungi middleware 'auth'. AJAX endpoint mengembalikan JSON.
|
*/

// =========================================================================
// LANDING PAGE
// =========================================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =========================================================================
// GUEST ROUTES (Hanya untuk user yang BELUM login)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =========================================================================
// AUTHENTICATED ROUTES (Hanya untuk user yang SUDAH login)
// =========================================================================
Route::middleware('auth')->group(function () {

    // --- Logout ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Dashboard (Server-Side Rendered) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Chat (View + AJAX Endpoints) ---
    Route::get('/chat',                       [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send',                 [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/history',               [ChatController::class, 'history'])->name('chat.history');
    Route::get('/chat/history/{session}',     [ChatController::class, 'sessionMessages'])->name('chat.session');
    Route::put('/chat/history/{session}',     [ChatController::class, 'renameSession'])->name('chat.rename');
    Route::delete('/chat/history/{session}',  [ChatController::class, 'deleteSession'])->name('chat.delete');
    Route::post('/chat/history/{session}/pin', [ChatController::class, 'togglePinSession'])->name('chat.pin');

    // --- Favorites (View + AJAX Endpoints) ---
    Route::get('/favorites',        [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // --- Topics (JSON for AJAX) ---
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');

    // --- Profil Pengguna ---
    Route::get('/profile',           [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile',           [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// =========================================================================
// ADMIN ROUTES (Hanya untuk User dengan Role 'admin')
// =========================================================================
Route::middleware(['auth', 'ensure.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', \App\Http\Controllers\Admin\UserManagement::class);
    Route::resource('/topics', \App\Http\Controllers\Admin\TopicController::class);
    Route::resource('/prompts', \App\Http\Controllers\Admin\PromptController::class);
    Route::resource('/example-prompts', \App\Http\Controllers\Admin\ExamplePromptController::class);
    Route::get('/chat-history', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'index'])->name('chat-history.index');
    Route::get('/chat-history/{user}', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'show'])->name('chat-history.show');
    Route::delete('/chat-history/session/{session}', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'destroySession'])->name('chat-history.destroy-session');

    // Profil Admin
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Statistik Analitik Admin
    Route::get('/statistics', [\App\Http\Controllers\Admin\StatisticsController::class, 'index'])->name('statistics.index');
});

