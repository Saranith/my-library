<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Collection (dashboard)
    Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');

    // Series CRUD
    Route::get('/series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
    Route::get('/series/{series}/edit', [SeriesController::class, 'edit'])->name('series.edit');
    Route::put('/series/{series}', [SeriesController::class, 'update'])->name('series.update');
    Route::patch('/series/{series}/progress', [SeriesController::class, 'updateProgress'])->name('series.progress');
    Route::delete('/series/{series}', [SeriesController::class, 'destroy'])->name('series.destroy');

    // Activity log
    Route::get('/log', [ActivityLogController::class, 'index'])->name('log.index');
});
