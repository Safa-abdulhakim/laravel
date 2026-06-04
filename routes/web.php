<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;

// ─── Main Platform Routes ─────────────────────────────────────────────────────
Route::get('/',            [HomeController::class,       'index'])->name('home');
Route::get('/analysis',    [AnalysisController::class,   'index'])->name('analysis.index');
Route::post('/analysis',   [AnalysisController::class,   'analyze'])->name('analysis.analyze');
Route::get('/analysis/{analysis}/results', [AnalysisController::class, 'results'])->name('analysis.results');
Route::get('/statistics',  [StatisticsController::class, 'index'])->name('statistics.index');
Route::get('/about',       [AboutController::class,      'index'])->name('about.index');
