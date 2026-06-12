<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAdminOrBem;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password (Web)
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AgendaController;

Route::get('/home', function () {
    $latestAgendas = \App\Models\Agenda::withCount(['comments', 'likes'])->latest()->take(3)->get();
    $popularAgenda = \App\Models\Agenda::withCount(['comments', 'likes'])->orderByDesc('likes_count')->first();

    return view('home', compact('latestAgendas', 'popularAgenda'));
})->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    // Aspirasi Routes - Home/Categories
    Route::get('/aspirasi/kategori', function () {
        return view('aspirasi.home');
    })->name('aspirasi.home');

    // Aspirasi Routes - Form Submission
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}', [AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::post('/aspirasi/{id}', [AspirasiController::class, 'store'])->name('aspirasi.store.with_event');

    // Aspirasi Routes - List & View Submissions
    Route::get('/aspirasi-list', [AspirasiController::class, 'list'])->name('aspirasi.list');
    Route::get('/aspirasi-detail/{id}', [AspirasiController::class, 'detail'])->name('aspirasi.detail');
    Route::post('/aspirasi/{id}/vote', [AspirasiController::class, 'vote'])->name('aspirasi.vote');
    Route::post('/aspirasi/{id}/comment', [AspirasiController::class, 'comment'])->name('aspirasi.comment');

    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/{id}', [AgendaController::class, 'show'])->name('agenda.show');
    Route::post('/agenda/{id}/comment', [AgendaController::class, 'comment'])->name('agenda.comment');
    Route::post('/agenda/{id}/like', [AgendaController::class, 'toggleLike'])->name('agenda.like');

    Route::get('/aduan', [App\Http\Controllers\AduanController::class, 'index'])->name('aduan.index');
    Route::get('/aduan/create', [App\Http\Controllers\AduanController::class, 'create'])->name('aduan.create');
    Route::post('/aduan', [App\Http\Controllers\AduanController::class, 'store'])->name('aduan.store');
    Route::get('/aduan/history', [App\Http\Controllers\AduanController::class, 'history'])->name('aduan.history');

    // Admin Routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware([IsAdminOrBem::class])
        ->group(function () {
            // Dashboard
            Route::get('/', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

            // Agenda Routes
            Route::get('/agenda', [App\Http\Controllers\AdminAgendaController::class, 'index'])->name('agenda.index');
            Route::get('/agenda/create', [App\Http\Controllers\AdminAgendaController::class, 'create'])->name('agenda.create');
            Route::post('/agenda', [App\Http\Controllers\AdminAgendaController::class, 'store'])->name('agenda.store');
            Route::get('/agenda/{id}/edit', [App\Http\Controllers\AdminAgendaController::class, 'edit'])->name('agenda.edit');
            Route::put('/agenda/{id}', [App\Http\Controllers\AdminAgendaController::class, 'update'])->name('agenda.update');
            Route::delete('/agenda/{id}', [App\Http\Controllers\AdminAgendaController::class, 'destroy'])->name('agenda.destroy');

            // Aspirasi Routes
            Route::get('/aspirasi', [App\Http\Controllers\AdminAspirasiController::class, 'index'])->name('aspirasi.index');
            Route::get('/aspirasi/export', [App\Http\Controllers\AdminAspirasiController::class, 'exportExcel'])->name('aspirasi.export');
            Route::post('/aspirasi/{id}/respond', [App\Http\Controllers\AdminAspirasiController::class, 'respond'])->name('aspirasi.respond');

            Route::middleware([IsAdmin::class])->group(function () {
                // Aduan Routes
                Route::get('/aduan', [App\Http\Controllers\AdminAduanController::class, 'index'])->name('aduan.index');
                Route::get('/aduan/export', [App\Http\Controllers\AdminAduanController::class, 'exportExcel'])->name('aduan.export');
                Route::get('/aduan/{id}', [App\Http\Controllers\AdminAduanController::class, 'show'])->name('aduan.show');
                Route::put('/aduan/{id}', [App\Http\Controllers\AdminAduanController::class, 'update'])->name('aduan.update');

                // BEM Routes
                Route::get('/bem', [App\Http\Controllers\AdminBemController::class, 'index'])->name('bem.index');
                Route::post('/bem', [App\Http\Controllers\AdminBemController::class, 'store'])->name('bem.store');
                Route::get('/bem/{id}/edit', [App\Http\Controllers\AdminBemController::class, 'edit'])->name('bem.edit');
                Route::put('/bem/{id}', [App\Http\Controllers\AdminBemController::class, 'update'])->name('bem.update');
                Route::delete('/bem/{id}', [App\Http\Controllers\AdminBemController::class, 'destroy'])->name('bem.destroy');
            });
    });
});