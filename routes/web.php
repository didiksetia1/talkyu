<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::post('/aspirasi/{id}', [AspirasiController::class, 'store'])->name('aspirasi.store');

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
        ->middleware([\App\Http\Middleware\IsAdmin::class])
        ->group(function () {
            // Dashboard
            Route::get('/', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

            // Aduan Routes
            Route::get('/aduan', [App\Http\Controllers\AdminAduanController::class, 'index'])->name('aduan.index');
            Route::get('/aduan/{id}', [App\Http\Controllers\AdminAduanController::class, 'show'])->name('aduan.show');
            Route::put('/aduan/{id}', [App\Http\Controllers\AdminAduanController::class, 'update'])->name('aduan.update');

            // Agenda Routes
            Route::get('/agenda', [App\Http\Controllers\AdminAgendaController::class, 'index'])->name('agenda.index');
            Route::get('/agenda/create', [App\Http\Controllers\AdminAgendaController::class, 'create'])->name('agenda.create');
            Route::post('/agenda', [App\Http\Controllers\AdminAgendaController::class, 'store'])->name('agenda.store');
            Route::get('/agenda/{id}/edit', [App\Http\Controllers\AdminAgendaController::class, 'edit'])->name('agenda.edit');
            Route::put('/agenda/{id}', [App\Http\Controllers\AdminAgendaController::class, 'update'])->name('agenda.update');
            Route::delete('/agenda/{id}', [App\Http\Controllers\AdminAgendaController::class, 'destroy'])->name('agenda.destroy');

            // Aspirasi Routes
            Route::get('/aspirasi', [App\Http\Controllers\AdminAspirasiController::class, 'index'])->name('aspirasi.index');
            Route::post('/aspirasi/{id}/respond', [App\Http\Controllers\AdminAspirasiController::class, 'respond'])->name('aspirasi.respond');
    });
});
