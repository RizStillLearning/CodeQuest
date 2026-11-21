<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Signed-in users are sent to /belajar instead (see bootstrap/app.php).
    Route::get('/', HomeController::class)->name('home');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/belajar', LearnController::class)->name('learn');
    Route::get('/belajar/{language}', PathController::class)->name('paths.show');

    Route::prefix('/belajar/{language}/{level}')->whereNumber('level')->group(function () {
        Route::get('/', LevelController::class)->name('levels.show');
        Route::get('/pelajaran/{lesson}', LessonController::class)->whereNumber('lesson')->name('lessons.show');

        Route::get('/latihan/hasil', [PracticeController::class, 'results'])->name('practice.results');
        Route::post('/latihan/ulangi', [PracticeController::class, 'restart'])->name('practice.restart');
        Route::get('/latihan/{number}', [PracticeController::class, 'show'])->whereNumber('number')->name('practice.show');
        Route::post('/latihan/{number}', [PracticeController::class, 'answer'])->whereNumber('number')->name('practice.answer');
    });

    Route::get('/progres', ProgressController::class)->name('progress');
    Route::get('/peringkat', LeaderboardController::class)->name('leaderboard');
    Route::get('/diskusi', ForumController::class)->name('forum');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
